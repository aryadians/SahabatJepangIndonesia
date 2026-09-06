<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalArchive;
use App\Models\SiteSetting;
use App\Models\Student;
use App\Traits\UploadsImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FlightReadinessController extends Controller
{
    use UploadsImage;

    /**
     * Tampilkan Pusat Checklist & Verifikasi Dokumen Kesiapan Terbang ke Jepang
     */
    public function index(Request $request)
    {
        $query = Student::query();

        // Filter Pencarian (Nama, NIS, Kaisha, Prefektur)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('destination_company', 'like', "%{$search}%")
                  ->orWhere('destination_prefecture', 'like', "%{$search}%")
                  ->orWhere('passport_number', 'like', "%{$search}%");
            });
        }

        // Filter Program
        if ($request->filled('program') && $request->program !== 'all') {
            $query->where('program', $request->program);
        }

        // Filter Prefektur
        if ($request->filled('prefecture') && $request->prefecture !== 'all') {
            $query->where('destination_prefecture', $request->prefecture);
        }

        // Filter Status Keberangkatan / Tahapan
        if ($request->filled('flight_stage') && $request->flight_stage !== 'all') {
            switch ($request->flight_stage) {
                case 'ready':
                    // Memiliki Paspor, MCU Fit, Sertifikat, CoE & Visa
                    $query->whereNotNull('document_passport')
                          ->whereNotNull('document_coe_visa')
                          ->where('mcu_result', 'fit');
                    break;
                case 'waiting_visa':
                    $query->whereNotNull('coe_number')
                          ->whereNull('visa_number');
                    break;
                case 'waiting_coe':
                    $query->whereIn('status', ['passed_interview', 'matched'])
                          ->whereNull('coe_number');
                    break;
                case 'incomplete':
                    $query->where(function ($q) {
                        $q->whereNull('document_passport')
                          ->orWhereNull('document_mcu')
                          ->orWhereNull('document_coe_visa');
                    });
                    break;
            }
        }

        // KPI Metrik Global
        $totalCandidates = Student::where(function ($q) {
            $q->whereIn('status', ['interview', 'passed_interview', 'visa_processing', 'ready_to_depart', 'departed'])
              ->orWhereNotNull('destination_company')
              ->orWhereNotNull('coe_number');
        })->count();

        $readyCount = Student::whereNotNull('document_passport')
                             ->whereNotNull('document_coe_visa')
                             ->where('mcu_result', 'fit')
                             ->count();

        $waitingVisaCount = Student::whereNotNull('coe_number')
                                   ->whereNull('visa_number')
                                   ->count();

        $waitingCoeCount = Student::whereIn('status', ['passed_interview', 'matched'])
                                  ->whereNull('coe_number')
                                  ->count();

        // Early Warning Expiry Alerts
        $criticalPassports = Student::whereNotNull('passport_expiry')
            ->where('passport_expiry', '<=', now()->addMonths(6))
            ->get();

        $expiredMcus = Student::whereNotNull('mcu_date')
            ->where(function ($q) {
                $q->where('mcu_date', '<=', now()->subDays(90))
                  ->orWhere('mcu_result', 'unfit');
            })
            ->get();

        $expiringCoes = Student::whereNotNull('coe_number')
            ->whereNull('visa_number')
            ->whereNotNull('coe_date')
            ->where('coe_date', '<=', now()->subDays(60))
            ->get();

        // Data Siswa Terurut
        $students = $query->orderByRaw("
            CASE 
                WHEN status = 'ready_to_depart' THEN 1
                WHEN status = 'visa_processing' THEN 2
                WHEN status = 'passed_interview' THEN 3
                WHEN status = 'interview' THEN 4
                ELSE 5 
            END ASC
        ")
        ->orderBy('departure_date', 'asc')
        ->orderBy('name', 'asc')
        ->paginate(15)
        ->withQueryString();

        // Prefektur unik untuk filter
        $prefectures = Student::whereNotNull('destination_prefecture')
                              ->where('destination_prefecture', '!=', '')
                              ->distinct()
                              ->pluck('destination_prefecture');

        $programs = Student::distinct()->pluck('program')->filter();

        return view('admin.students.flight_readiness', compact(
            'students',
            'totalCandidates',
            'readyCount',
            'waitingVisaCount',
            'waitingCoeCount',
            'prefectures',
            'programs',
            'criticalPassports',
            'expiredMcus',
            'expiringCoes'
        ));
    }

    /**
     * Kirim Pengingat Dokumen & Update Kesiapan Terbang via WhatsApp
     */
    public function sendDocumentReminderWa(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $phone = $request->input('phone', $student->phone);

        $cleanPhone = preg_replace('/[^0-9]/', '', (string)$phone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        if (empty($cleanPhone)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Nomor WhatsApp siswa belum terdaftar atau tidak valid.'], 422);
            }
            return back()->with('error', 'Nomor WhatsApp siswa belum terdaftar atau tidak valid.');
        }

        // Cek dokumen yang belum lengkap
        $missingDocs = [];
        if (empty($student->document_ktp)) $missingDocs[] = 'KTP Siswa (E-KTP)';
        if (empty($student->document_kk)) $missingDocs[] = 'Kartu Keluarga (KK)';
        if (empty($student->document_ijazah)) $missingDocs[] = 'Ijazah Pendidikan Terakhir';
        if (empty($student->document_passport)) $missingDocs[] = 'Buku Paspor RI (Min. 12 bulan)';
        if (empty($student->document_certificate)) $missingDocs[] = 'Sertifikat Bahasa Jepang (JLPT N5/N4 atau JFT)';
        if (empty($student->document_ssw)) $missingDocs[] = 'Sertifikat Keahlian Kerja (SSW / Magang)';
        if (empty($student->document_mcu) || $student->mcu_result !== 'fit') $missingDocs[] = 'Hasil Medical Check-Up (MCU Fit to Fly)';
        if (empty($student->document_coe_visa)) $missingDocs[] = 'CoE & Visa Kerja Resmi Jepang';

        $trackingUrl = url('/cek-kesiapan/' . $student->nis);
        $isReady = empty($missingDocs);

        if ($isReady) {
            $msg = "Konnichiwa, *{$student->name}* ({$student->nis})! ✈️🇯🇵\n\n";
            $msg .= "Selamat! Berdasarkan hasil verifikasi berkas *Sending Organization (SO) LPK Sahabat Jepang Indonesia*, seluruh dokumen keberangkatan Anda telah dinyatakan *LENGKAP & SIAP TERBANG (READY TO FLY)*.\n\n";
            $msg .= "📋 *Rincian Keberangkatan*:\n";
            $msg .= "🏢 *Perusahaan Penerima*: " . ($student->destination_company ?: '-') . "\n";
            $msg .= "🗾 *Prefektur Tujuan*: " . ($student->destination_prefecture ?: '-') . "\n";
            $msg .= "🛂 *No. Paspor*: " . ($student->passport_number ?: '-') . "\n";
            $msg .= "📅 *Estimasi Keberangkatan*: " . ($student->departure_date ? Carbon::parse($student->departure_date)->format('d F Y') : 'Menunggu Tiket Penerbangan') . "\n\n";
            $msg .= "🔗 *Cek Dossier & Panduan Keberangkatan*:\n";
            $msg .= "👉 {$trackingUrl}\n\n";
            $msg .= "Mohon jaga kesehatan fisik dan mental, serta persiapkan perlengkapan pribadi Anda dengan baik. Ganbatte kudasai!\n\n";
            $msg .= "_Divisi Penempatan Luar Negeri - LPK Sahabat Jepang Indonesia_";
        } else {
            $msg = "Konnichiwa, *{$student->name}* ({$student->nis}) 🌸\n\n";
            $msg .= "Berdasarkan audit kelengkapan berkas keberangkatan menuju Jepang di *LPK Sahabat Jepang Indonesia*, terdapat beberapa dokumen yang masih *BELUM LENGKAP* atau memerlukan pembaruan:\n\n";
            $msg .= "⚠️ *Daftar Dokumen yang Harus Dilengkapi*:\n";
            foreach ($missingDocs as $idx => $doc) {
                $msg .= ($idx + 1) . ". {$doc}\n";
            }
            if ($student->departure_date) {
                $msg .= "\n📅 *Estimasi Rencana Terbang*: " . Carbon::parse($student->departure_date)->format('d F Y') . "\n";
            }
            $msg .= "\n🔗 *Pantau Progres & Rincian Berkas Anda*:\n";
            $msg .= "👉 {$trackingUrl}\n\n";
            $msg .= "Mohon segera menyerahkan / mengunggah dokumen di atas ke bagian administrasi LPK agar proses pengurusan visa dan tiket tidak tertunda.\n\n";
            $msg .= "_Divisi Verifikasi Dokumen & Visa - LPK Sahabat Jepang Indonesia_";
        }

        // Kirim via Fonnte Gateway jika aktif
        $sentViaFonnte = false;
        if (\App\Services\FonnteService::isConfigured()) {
            $res = \App\Services\FonnteService::send($cleanPhone, $msg, [
                'type' => 'flight_reminder',
                'student_id' => $student->id,
            ]);
            $sentViaFonnte = $res['success'] ?? false;
        }

        $waLink = 'https://wa.me/' . $cleanPhone . '?text=' . urlencode($msg);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'sent_via_fonnte' => $sentViaFonnte,
                'message' => $sentViaFonnte 
                    ? "Notifikasi WhatsApp kesiapan terbang berhasil dikirimkan ke {$student->name} ({$cleanPhone})."
                    : "Tautan WhatsApp berhasil disiapkan untuk dikirim ke {$student->name}.",
                'wa_link' => $waLink,
            ]);
        }

        if ($sentViaFonnte) {
            return back()->with('success', "Pengingat WhatsApp berhasil dikirim ke {$student->name} ({$cleanPhone}).");
        }

        return redirect()->away($waLink);
    }

    /**
     * Pembaruan Status Kelayakan & Data Keberangkatan Siswa
     */
    public function updateStatus(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'status' => 'nullable|string',
            'destination_company' => 'nullable|string|max:255',
            'destination_prefecture' => 'nullable|string|max:100',
            'departure_date' => 'nullable|date',
            'passport_number' => 'nullable|string|max:50',
            'passport_expiry' => 'nullable|date',
            'mcu_clinic' => 'nullable|string|max:150',
            'mcu_date' => 'nullable|date',
            'mcu_result' => 'nullable|in:fit,unfit,follow_up,pending',
            'coe_number' => 'nullable|string|max:100',
            'coe_date' => 'nullable|date',
            'visa_number' => 'nullable|string|max:100',
            'visa_expiry' => 'nullable|date',
            'admin_notes' => 'nullable|string',
        ]);

        $student->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Data keberangkatan {$student->name} berhasil diperbarui.",
                'student' => $student,
            ]);
        }

        return back()->with('success', "Data kesiapan terbang untuk siswa {$student->name} berhasil diperbarui.");
    }

    /**
     * Upload Cepat Dokumen Keberangkatan (Paspor, MCU, CoE, Visa, dll)
     */
    public function quickUploadDoc(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'doc_type' => 'required|in:ktp,kk,ijazah,passport,certificate,ssw,mcu,coe_visa',
            'file' => 'required|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
        ]);

        $type = $request->doc_type;
        $column = "document_{$type}";
        $docLabel = match($type) {
            'ktp' => 'KTP Siswa',
            'kk' => 'Kartu Keluarga',
            'ijazah' => 'Ijazah Terakhir',
            'passport' => 'Paspor RI',
            'certificate' => 'Sertifikat Bahasa JLPT/JFT',
            'ssw' => 'Sertifikat Keahlian SSW / Magang',
            'mcu' => 'Hasil MCU Fit to Fly',
            'coe_visa' => 'CoE & Visa Kerja Jepang',
            default => 'Dokumen Siswa',
        };

        $base64 = $this->handleFileUpload($request, 'file', 'file_url', $student->{$column});
        $student->{$column} = $base64;
        $student->save();

        // Otomatis sinkronisasi ke Arsip Digital
        if (!empty($base64)) {
            $archiveNo = 'ARC-STD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
            $archiveTitle = "[{$student->nis}] {$student->name} - {$docLabel}";

            DigitalArchive::create([
                'archive_no' => $archiveNo,
                'title' => $archiveTitle,
                'category' => 'dokumen_siswa',
                'file_name' => "{$student->nis}_{$type}." . ($request->file('file')->getClientOriginalExtension() ?: 'jpg'),
                'file_type' => $request->file('file')->getMimeType() ?: 'application/octet-stream',
                'file_size' => round($request->file('file')->getSize() / 1024, 1) . ' KB',
                'file_base64' => $base64,
                'document_date' => now()->toDateString(),
                'uploader_name' => auth()->user()->name ?? 'Admin Flight Tracker',
                'notes' => "Diunggah melalui Flight Readiness Tracker untuk verifikasi terbang ke Jepang ({$student->name} - NIS: {$student->nis}).",
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Berkas {$docLabel} untuk {$student->name} berhasil diunggah dan tercatat di Arsip Digital.",
                'doc_type' => $type,
                'doc_url' => $base64,
            ]);
        }

        return back()->with('success', "Berkas {$docLabel} untuk {$student->name} berhasil diunggah.");
    }

    /**
     * Cetak Lembar Rekapitulasi Checklist Keberangkatan Resmi PDF (A4 Landscape)
     */
    public function exportPdf(Request $request)
    {
        $query = Student::query();

        if ($request->filled('program') && $request->program !== 'all') {
            $query->where('program', $request->program);
        }
        if ($request->filled('prefecture') && $request->prefecture !== 'all') {
            $query->where('destination_prefecture', $request->prefecture);
        }

        $students = $query->where(function ($q) {
            $q->whereIn('status', ['interview', 'passed_interview', 'visa_processing', 'ready_to_depart', 'departed'])
              ->orWhereNotNull('destination_company')
              ->orWhereNotNull('coe_number');
        })
        ->orderBy('departure_date', 'asc')
        ->orderBy('name', 'asc')
        ->get();

        $settings = SiteSetting::allCached();
        $docNumber = 'FLIGHT-SJI/' . date('Ym') . '/' . str_pad(rand(10, 99), 4, '0', STR_PAD_LEFT);

        return view('admin.students.flight_readiness_pdf', compact('students', 'settings', 'docNumber'));
    }
}
