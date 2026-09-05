<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashTransaction;
use App\Models\SiteSetting;
use App\Models\Student;
use App\Traits\UploadsImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use UploadsImage;

    /**
     * Tampilkan List Siswa (Server-Side Filter, Search & Pagination)
     */
    public function index(Request $request)
    {
        $query = Student::query();

        // 1. Live Search (NIS, Nama, NIK, No WA, Kaisha, CoE)
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('nis', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('destination_company', 'like', "%{$q}%")
                    ->orWhere('coe_number', 'like', "%{$q}%");
            });
        }

        // 2. Filter Status Pelatihan
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // 3. Filter Program Karir
        if ($request->filled('program') && $request->program !== 'all') {
            $query->where('program', $request->program);
        }

        // 4. Filter Status Pembayaran / Tanggungan
        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        // 5. Filter Status MCU
        if ($request->filled('mcu_result') && $request->mcu_result !== 'all') {
            $query->where('mcu_result', $request->mcu_result);
        }

        // 5b. Filter Kategori / Jalur Pendaftaran (Umum, SMILE Project, SMK Go Japan, BKK, Kampus)
        if ($request->filled('registration_category') && $request->registration_category !== 'all') {
            if (in_array($request->registration_category, ['smile_project', 'kemenkes_kaigo'])) {
                $query->whereIn('registration_category', ['smile_project', 'kemenkes_kaigo']);
            } else {
                $query->where('registration_category', $request->registration_category);
            }
        }

        // 6. Select light columns for list performance (exclude heavy base64 strings)
        $students = $query->select([
            'id', 'nis', 'name', 'japanese_name', 'phone', 'gender', 'batch',
            'program', 'registration_category', 'sector', 'status', 'entry_date', 'departure_date',
            'destination_company', 'destination_prefecture', 'japanese_level',
            'total_cost', 'paid_amount', 'payment_status', 'payment_scheme', 'photo',
            'mcu_result', 'coe_number', 'visa_number', 'exam_score'
        ])
        ->orderByDesc('id')
        ->paginate(15)
        ->withQueryString();

        // 7. Quick KPI Metrics
        $stats = [
            'total_students' => Student::count(),
            'active_students' => Student::whereIn('status', ['active', 'interview', 'passed_interview'])->count(),
            'departed_students' => Student::where('status', 'departed')->count(),
            'total_receivables' => Student::selectRaw('SUM(total_cost - paid_amount) as total_unpaid')->value('total_unpaid') ?? 0,
            'smile_project_count' => Student::whereIn('registration_category', ['smile_project', 'kemenkes_kaigo'])->count(),
            'smk_go_japan_count' => Student::where('registration_category', 'smk_go_japan')->count(),
        ];

        $paymentMethods = CashTransaction::PAYMENT_METHODS;

        return view('admin.students.index', compact('students', 'stats', 'paymentMethods'));
    }

    /**
     * Detail Data Siswa (JSON untuk Quick Detail Modal atau View Print)
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);

        if (request()->wantsJson() || request()->ajax() || request('format') === 'json') {
            return response()->json([
                'student' => $student,
                'registration_category_label' => $student->registration_category_label,
                'registration_category_badge' => $student->registration_category_badge,
                'remaining_balance' => $student->remaining_balance,
                'formatted_total_cost' => $student->formatted_total_cost,
                'formatted_paid_amount' => $student->formatted_paid_amount,
                'formatted_remaining_balance' => $student->formatted_remaining_balance,
                'mcu_label' => $student->mcu_label,
                'uploaded_docs_count' => $student->uploaded_documents_count,
                'has_ktp' => !empty($student->document_ktp),
                'has_kk' => !empty($student->document_kk),
                'has_ijazah' => !empty($student->document_ijazah),
                'has_passport' => !empty($student->document_passport),
                'has_cert' => !empty($student->document_certificate),
                'has_ssw' => !empty($student->document_ssw),
                'has_mcu' => !empty($student->document_mcu),
                'has_coe' => !empty($student->document_coe_visa),
            ]);
        }

        return view('admin.students.print', compact('student'));
    }

    /**
     * Form Tambah Siswa Baru
     */
    public function create()
    {
        return view('admin.students.form', ['student' => new Student()]);
    }

    /**
     * Simpan Data Siswa Baru (Base64 LONGTEXT File & Dokumen Handling)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:50|unique:students,nis',
            'name' => 'required|string|max:255',
            'japanese_name' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'education' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:30',
            'batch' => 'nullable|string|max:100',
            'program' => 'required|string|max:100',
            'registration_category' => 'nullable|string|max:50',
            'sector' => 'nullable|string|max:100',
            'entry_date' => 'nullable|date',
            'departure_date' => 'nullable|date',
            'destination_company' => 'nullable|string|max:255',
            'destination_prefecture' => 'nullable|string|max:100',
            'status' => 'required|string|max:50',
            'japanese_level' => 'nullable|string|max:50',
            'ssw_certificate' => 'nullable|string|max:150',
            'passport_number' => 'nullable|string|max:50',
            'passport_expiry' => 'nullable|date',
            'mcu_date' => 'nullable|date',
            'mcu_clinic' => 'nullable|string|max:150',
            'mcu_result' => 'nullable|string|max:50',
            'coe_number' => 'nullable|string|max:100',
            'coe_date' => 'nullable|date',
            'visa_number' => 'nullable|string|max:100',
            'visa_expiry' => 'nullable|date',
            'exam_score' => 'nullable|numeric|min:0|max:100',
            'attendance_percentage' => 'nullable|integer|min:0|max:100',
            'discipline_grade' => 'nullable|string|max:10',
            'total_cost' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_scheme' => 'required|string|max:50',
            'payment_status' => 'required|string|max:50',
            'payment_notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'photo_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:10240',
            'document_ktp_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_kk_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_ijazah_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_passport_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_certificate_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_ssw_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_mcu_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_coe_visa_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'photo' => 'nullable|string',
            'document_ktp' => 'nullable|string',
            'document_kk' => 'nullable|string',
            'document_ijazah' => 'nullable|string',
            'document_passport' => 'nullable|string',
            'document_certificate' => 'nullable|string',
            'document_ssw' => 'nullable|string',
            'document_mcu' => 'nullable|string',
            'document_coe_visa' => 'nullable|string',
        ]);

        // Upload Dokumen & Foto Pribadi Siswa
        $photo = $this->handleFileUpload($request, 'photo_file', 'photo');
        $docKtp = $this->handleFileUpload($request, 'document_ktp_file', 'document_ktp');
        $docKk = $this->handleFileUpload($request, 'document_kk_file', 'document_kk');
        $docIjazah = $this->handleFileUpload($request, 'document_ijazah_file', 'document_ijazah');
        $docPassport = $this->handleFileUpload($request, 'document_passport_file', 'document_passport');
        $docCert = $this->handleFileUpload($request, 'document_certificate_file', 'document_certificate');
        $docSsw = $this->handleFileUpload($request, 'document_ssw_file', 'document_ssw');
        $docMcu = $this->handleFileUpload($request, 'document_mcu_file', 'document_mcu');
        $docCoe = $this->handleFileUpload($request, 'document_coe_visa_file', 'document_coe_visa');

        // Otomatis tentukan status pembayaran jika tidak dipilih manual
        $totalCost = (float)$validated['total_cost'];
        $paidAmount = (float)$validated['paid_amount'];
        $paymentStatus = $validated['payment_status'];
        if ($paidAmount >= $totalCost && $totalCost > 0) {
            $paymentStatus = 'paid';
        } elseif ($paidAmount > 0 && $paidAmount < $totalCost) {
            $paymentStatus = 'partial';
        }

        $student = Student::create(array_merge($validated, [
            'photo' => $photo,
            'document_ktp' => $docKtp,
            'document_kk' => $docKk,
            'document_ijazah' => $docIjazah,
            'document_passport' => $docPassport,
            'document_certificate' => $docCert,
            'document_ssw' => $docSsw,
            'document_mcu' => $docMcu,
            'document_coe_visa' => $docCoe,
            'payment_status' => $paymentStatus,
        ]));

        if ($paidAmount > 0) {
            CashTransaction::create([
                'transaction_number' => CashTransaction::generateNumber('income'),
                'transaction_date' => now()->toDateString(),
                'type' => 'income',
                'category' => 'tuition_student',
                'title' => "Pembayaran Awal Siswa: {$student->name} ({$student->nis})",
                'amount' => $paidAmount,
                'payment_method' => 'bank_mandiri',
                'reference_type' => 'student',
                'reference_id' => $student->id,
                'notes' => 'Penerimaan biaya pendidikan registrasi awal siswa baru.',
                'recorded_by' => auth()->user()->name ?? 'Admin Keuangan',
            ]);
        }

        return redirect()->route('admin.students.index')->with('success', 'Data siswa baru berhasil ditambahkan.');
    }

    /**
     * Form Edit Data Siswa
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.form', compact('student'));
    }

    /**
     * Update Data Siswa
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'required|string|max:50|unique:students,nis,' . $student->id,
            'name' => 'required|string|max:255',
            'japanese_name' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'education' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:30',
            'batch' => 'nullable|string|max:100',
            'program' => 'required|string|max:100',
            'registration_category' => 'nullable|string|max:50',
            'sector' => 'nullable|string|max:100',
            'entry_date' => 'nullable|date',
            'departure_date' => 'nullable|date',
            'destination_company' => 'nullable|string|max:255',
            'destination_prefecture' => 'nullable|string|max:100',
            'status' => 'required|string|max:50',
            'japanese_level' => 'nullable|string|max:50',
            'ssw_certificate' => 'nullable|string|max:150',
            'passport_number' => 'nullable|string|max:50',
            'passport_expiry' => 'nullable|date',
            'mcu_date' => 'nullable|date',
            'mcu_clinic' => 'nullable|string|max:150',
            'mcu_result' => 'nullable|string|max:50',
            'coe_number' => 'nullable|string|max:100',
            'coe_date' => 'nullable|date',
            'visa_number' => 'nullable|string|max:100',
            'visa_expiry' => 'nullable|date',
            'exam_score' => 'nullable|numeric|min:0|max:100',
            'attendance_percentage' => 'nullable|integer|min:0|max:100',
            'discipline_grade' => 'nullable|string|max:10',
            'total_cost' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_scheme' => 'required|string|max:50',
            'payment_status' => 'required|string|max:50',
            'payment_notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'photo_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:10240',
            'document_ktp_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_kk_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_ijazah_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_passport_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_certificate_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_ssw_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_mcu_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'document_coe_visa_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'photo' => 'nullable|string',
            'document_ktp' => 'nullable|string',
            'document_kk' => 'nullable|string',
            'document_ijazah' => 'nullable|string',
            'document_passport' => 'nullable|string',
            'document_certificate' => 'nullable|string',
            'document_ssw' => 'nullable|string',
            'document_mcu' => 'nullable|string',
            'document_coe_visa' => 'nullable|string',
        ]);

        // Upload Dokumen & Foto (jika ada file baru diunggah)
        $photo = $this->handleFileUpload($request, 'photo_file', 'photo', $student->photo);
        $docKtp = $this->handleFileUpload($request, 'document_ktp_file', 'document_ktp', $student->document_ktp);
        $docKk = $this->handleFileUpload($request, 'document_kk_file', 'document_kk', $student->document_kk);
        $docIjazah = $this->handleFileUpload($request, 'document_ijazah_file', 'document_ijazah', $student->document_ijazah);
        $docPassport = $this->handleFileUpload($request, 'document_passport_file', 'document_passport', $student->document_passport);
        $docCert = $this->handleFileUpload($request, 'document_certificate_file', 'document_certificate', $student->document_certificate);
        $docSsw = $this->handleFileUpload($request, 'document_ssw_file', 'document_ssw', $student->document_ssw);
        $docMcu = $this->handleFileUpload($request, 'document_mcu_file', 'document_mcu', $student->document_mcu);
        $docCoe = $this->handleFileUpload($request, 'document_coe_visa_file', 'document_coe_visa', $student->document_coe_visa);

        $totalCost = (float)$validated['total_cost'];
        $paidAmount = (float)$validated['paid_amount'];
        $paymentStatus = $validated['payment_status'];
        if ($paidAmount >= $totalCost && $totalCost > 0) {
            $paymentStatus = 'paid';
        } elseif ($paidAmount > 0 && $paidAmount < $totalCost) {
            $paymentStatus = 'partial';
        }

        $student->update(array_merge($validated, [
            'photo' => $photo,
            'document_ktp' => $docKtp,
            'document_kk' => $docKk,
            'document_ijazah' => $docIjazah,
            'document_passport' => $docPassport,
            'document_certificate' => $docCert,
            'document_ssw' => $docSsw,
            'document_mcu' => $docMcu,
            'document_coe_visa' => $docCoe,
            'payment_status' => $paymentStatus,
        ]));

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Hapus Data Siswa
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return back()->with('success', 'Data siswa berhasil dihapus.');
    }

    /**
     * Update Cepat Pembayaran Siswa
     */
    public function updatePayment(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|in:' . implode(',', array_keys(CashTransaction::PAYMENT_METHODS)),
            'payment_date' => 'nullable|date',
            'payment_notes' => 'nullable|string',
            'proof_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
        ]);

        $paymentDate = $validated['payment_date'] ?? now()->toDateString();

        // Cek apakah tanggal transaksi berada dalam periode tutup buku
        $lockDate = SiteSetting::get('financial_lock_until');
        if ($lockDate && $paymentDate <= $lockDate) {
            $formattedLock = Carbon::parse($lockDate)->format('d/m/Y');
            return back()->with('error', "Gagal! Tanggal transaksi berada dalam periode yang telah Ditutup Buku (Lock Period s/d {$formattedLock}).");
        }

        $paidAmount = (float)$validated['paid_amount'];
        $totalCost = (float)$student->total_cost;
        
        $paymentStatus = 'unpaid';
        if ($paidAmount >= $totalCost && $totalCost > 0) {
            $paymentStatus = 'paid';
        } elseif ($paidAmount > 0) {
            $paymentStatus = 'partial';
        }

        $oldPaid = (float) $student->paid_amount;
        $diff = $paidAmount - $oldPaid;

        $student->update([
            'paid_amount' => $paidAmount,
            'payment_status' => $paymentStatus,
            'payment_notes' => $validated['payment_notes'] ?? $student->payment_notes,
        ]);

        if ($diff > 0) {
            $proofBase64 = null;
            if ($request->hasFile('proof_file')) {
                $file = $request->file('proof_file');
                $mime = $file->getMimeType();
                $data = base64_encode(file_get_contents($file->getRealPath()));
                $proofBase64 = 'data:' . $mime . ';base64,' . $data;
            }

            $trxNumber = CashTransaction::generateNumber('income');

            CashTransaction::create([
                'transaction_number' => $trxNumber,
                'transaction_date' => $paymentDate,
                'type' => 'income',
                'category' => 'tuition_student',
                'title' => "Pembayaran Biaya Pelatihan: {$student->name} ({$student->nis})",
                'amount' => $diff,
                'payment_method' => $validated['payment_method'] ?? 'bank_mandiri',
                'reference_type' => 'student',
                'reference_id' => $student->id,
                'proof_file' => $proofBase64,
                'notes' => $validated['payment_notes'] ?? 'Cicilan/pelunasan biaya pelatihan siswa.',
                'recorded_by' => auth()->user()->name ?? 'Admin Keuangan',
            ]);

            // WhatsApp Notification to Student/Parent via Fonnte
            $cleanPhone = preg_replace('/[^0-9]/', '', $student->phone);
            if (str_starts_with($cleanPhone, '0')) {
                $cleanPhone = '62' . substr($cleanPhone, 1);
            }

            if (\App\Services\FonnteService::isConfigured() && !empty($cleanPhone)) {
                $formattedDiff = 'Rp ' . number_format($diff, 0, ',', '.');
                $formattedTotalPaid = 'Rp ' . number_format($paidAmount, 0, ',', '.');
                $remaining = max(0, $totalCost - $paidAmount);
                $formattedRemaining = 'Rp ' . number_format($remaining, 0, ',', '.');

                $msg = "Konnichiwa, *{$student->name}* ({$student->nis}) 🌸\n\n";
                $msg .= "Pembayaran biaya pelatihan Anda telah berhasil kami verifikasi dan tercatat resmi di Buku Kas Umum *LPK Sahabat Jepang Indonesia*.\n\n";
                $msg .= "📋 *Kuitansi Pembayaran Digital*:\n";
                $msg .= "🔖 *No. Bukti Kas*: `{$trxNumber}`\n";
                $msg .= "💵 *Nominal Diterima*: *{$formattedDiff}*\n";
                $msg .= "📊 *Akumulasi Terbayar*: {$formattedTotalPaid}\n";
                $msg .= "⏳ *Sisa Tanggungan*: " . ($remaining <= 0 ? '*LUNAS*' : $formattedRemaining) . "\n";
                $msg .= "📅 *Tanggal Transaksi*: " . Carbon::parse($paymentDate)->format('d/m/Y') . "\n\n";
                $msg .= "Terima kasih atas kedisiplinan administrasi Anda. Terus semangat dalam menempuh pelatihan bahasa dan budaya Jepang! 🇯🇵\n\n";
                $msg .= "_LPK Sahabat Jepang Indonesia - Lembaga Penyalur & Pelatihan Kerja Resmi Kemenaker RI_";

                \App\Services\FonnteService::send($cleanPhone, $msg, [
                    'type' => 'payment_receipt',
                    'student_id' => $student->id,
                ]);
            }
        }

        $msgText = $diff > 0 
            ? "Pembayaran siswa {$student->name} sebesar Rp " . number_format($diff, 0, ',', '.') . " berhasil dicatat di Buku Kas Umum."
            : "Data pembayaran siswa {$student->name} berhasil diperbarui.";

        return back()->with('success', $msgText);
    }

    /**
     * Cetak Lembar Profil / Rirekisho Pelatihan Siswa (Print / PDF)
     */
    public function printDossier($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.print', compact('student'));
    }

    /**
     * Export / Cetak Rekapitulasi Buku Induk Siswa ke PDF Resmi
     */
    public function exportPdf(Request $request)
    {
        $query = Student::query();

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('nis', 'like', "%{$q}%")
                    ->orWhere('japanese_name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
                    ->orWhere('destination_company', 'like', "%{$q}%");
            });
        }

        if ($request->filled('program') && $request->program !== 'all') {
            $query->where('program', $request->program);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('registration_category') && $request->registration_category !== 'all') {
            $category = $request->registration_category;
            if ($category === 'smile_project') {
                $query->whereIn('registration_category', ['smile_project', 'kemenkes_kaigo']);
            } else {
                $query->where('registration_category', $category);
            }
        }

        $students = $query->orderBy('id', 'asc')->get();

        return view('admin.students.export_pdf', compact('students'));
    }

    /**
     * Export Seluruh Database Siswa ke CSV / Excel
     */
    public function exportCsv()
    {
        $students = Student::orderBy('id')->get();
        $fileName = 'Database_Siswa_LPK_Sahabat_Jepang_' . date('Ymd_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'NIS', 'Nama Lengkap', 'Nama Katakana', 'NIK', 'WhatsApp', 'Email',
                'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Pendidikan', 'Alamat', 'Kota Asal',
                'Kontak Darurat', 'No Kontak Darurat', 'Angkatan', 'Program', 'Sektor Pekerjaan',
                'Tgl Masuk', 'Tgl Terbang', 'Perusahaan Jepang', 'Prefektur', 'Status Pelatihan',
                'Level Bahasa', 'Sertifikat SSW', 'Nomor Paspor', 'Masa Berlaku Paspor',
                'Tgl MCU', 'Klinik MCU', 'Hasil MCU', 'Nomor CoE', 'Tgl Terbit CoE', 'Nomor Visa', 'Masa Berlaku Visa',
                'Rata Rata Ujian', 'Kehadiran %', 'Grade Kedisiplinan',
                'Total Biaya (IDR)', 'Sudah Bayar (IDR)', 'Sisa Tanggungan (IDR)', 'Skema Biaya', 'Status Pembayaran', 'Catatan Admin'
            ]);

            foreach ($students as $s) {
                fputcsv($file, [
                    $s->nis,
                    $s->name,
                    $s->japanese_name ?? '',
                    $s->nik ?? '',
                    $s->phone ?? '',
                    $s->email ?? '',
                    $s->gender,
                    $s->birth_place ?? '',
                    $s->birth_date ? $s->birth_date->format('Y-m-d') : '',
                    $s->education ?? '',
                    $s->address ?? '',
                    $s->city ?? '',
                    $s->emergency_contact_name ?? '',
                    $s->emergency_contact_phone ?? '',
                    $s->batch ?? '',
                    $s->program,
                    $s->sector ?? '',
                    $s->entry_date ? $s->entry_date->format('Y-m-d') : '',
                    $s->departure_date ? $s->departure_date->format('Y-m-d') : '',
                    $s->destination_company ?? '',
                    $s->destination_prefecture ?? '',
                    $s->status,
                    $s->japanese_level ?? '',
                    $s->ssw_certificate ?? '',
                    $s->passport_number ?? '',
                    $s->passport_expiry ? $s->passport_expiry->format('Y-m-d') : '',
                    $s->mcu_date ? $s->mcu_date->format('Y-m-d') : '',
                    $s->mcu_clinic ?? '',
                    $s->mcu_result ?? '',
                    $s->coe_number ?? '',
                    $s->coe_date ? $s->coe_date->format('Y-m-d') : '',
                    $s->visa_number ?? '',
                    $s->visa_expiry ? $s->visa_expiry->format('Y-m-d') : '',
                    $s->exam_score ?? '',
                    $s->attendance_percentage ?? '',
                    $s->discipline_grade ?? '',
                    $s->total_cost,
                    $s->paid_amount,
                    $s->remaining_balance,
                    $s->payment_scheme,
                    $s->payment_status,
                    $s->admin_notes ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download Template CSV untuk Import Siswa Massal
     */
    public function exportTemplate()
    {
        $fileName = 'Template_Import_Siswa_LPK_SJI.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header baris 1
            fputcsv($file, [
                'NIS', 'Nama Lengkap', 'Nama Katakana', 'NIK', 'WhatsApp', 'Email',
                'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir (YYYY-MM-DD)', 'Pendidikan', 'Kota Asal', 'Alamat',
                'Kontak Darurat', 'No Darurat', 'Angkatan', 'Program', 'Kategori Pendaftaran', 'Sektor',
                'Tgl Masuk (YYYY-MM-DD)', 'Tgl Terbang (YYYY-MM-DD)', 'Perusahaan Jepang', 'Prefektur', 'Status Pelatihan',
                'Level Bahasa', 'Sertifikat SSW', 'Nomor Paspor', 'Tgl MCU (YYYY-MM-DD)', 'Klinik MCU', 'Hasil MCU',
                'Nomor CoE', 'Nomor Visa', 'Nilai Ujian', 'Kehadiran (%)', 'Total Biaya', 'Sudah Bayar', 'Skema Biaya'
            ]);

            // Baris Contoh 1
            fputcsv($file, [
                'SJI-2026-801', 'Fajar Ramadhan', 'ファジャル・ラマダン', '3201123456780001', '081298761234', 'fajar@example.com',
                'Laki-laki', 'Bandung', '2002-05-14', 'SMK Mesin', 'Bandung', 'Jl. Sukajadi No. 12',
                'Bapak Ramadhan', '081299887766', 'Angkatan 45', 'Tokutei Ginou (SSW)', 'smk_go_japan', 'Pengolahan Makanan',
                '2026-01-10', '2026-11-20', 'Nichirei Foods Inc.', 'Aichi', 'passed_interview',
                'JLPT N4', 'SSW Food Processing', 'C9876543', '2026-03-15', 'RS Medistra Jakarta', 'fit',
                'COE-2026-TYO-991', 'VISA-JPN-4421', '88.5', '96', '25000000', '15000000', 'mandiri'
            ]);

            // Baris Contoh 2
            fputcsv($file, [
                'SJI-2026-802', 'Siti Nurhaliza', 'シティ・ヌルハリザ', '3302123456780002', '081377881122', 'siti@example.com',
                'Perempuan', 'Semarang', '2003-08-22', 'D3 Keperawatan', 'Semarang', 'Jl. Pandanaran No. 45',
                'Ibu Nur', '081366554433', 'Angkatan 46', 'Tokutei Ginou (SSW)', 'smile_project', 'Kaigo (Caregiver)',
                '2026-02-01', '', 'Sun City Care Group', 'Tokyo', 'active',
                'JFT-Basic A2', 'SSW Kaigo Certified', '', '', '', 'pending',
                '', '', '92.0', '100', '28000000', '10000000', 'talangan'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import Data Siswa Massal dari File CSV
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|max:10240',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        $handle = fopen($path, 'r');
        if (!$handle) {
            return back()->with('error', 'Gagal membuka file CSV yang diunggah.');
        }

        // Handle UTF-8 BOM
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $header = fgetcsv($handle, 10000, ',');
        if (!$header) {
            fclose($handle);
            return back()->with('error', 'File CSV kosong atau format baris tidak valid.');
        }

        // Normalisasi header (lowercase, buang spasi dan simbol khusus)
        $cleanHeaders = array_map(function ($h) {
            $clean = strtolower(trim($h));
            $clean = str_replace(['(', ')', '-', '/', '%'], '', $clean);
            $clean = preg_replace('/\s+/', '_', $clean);
            return $clean;
        }, $header);

        $createdCount = 0;
        $updatedCount = 0;
        $rowNumber = 1;

        while (($row = fgetcsv($handle, 10000, ',')) !== false) {
            $rowNumber++;
            if (empty(array_filter($row))) {
                continue; // Skip baris kosong
            }

            // Map baris dengan header
            $data = [];
            foreach ($cleanHeaders as $index => $colName) {
                $data[$colName] = isset($row[$index]) ? trim($row[$index]) : null;
            }

            // Temukan atau generate NIS unik
            $nis = $data['nis'] ?? null;
            if (empty($nis)) {
                $nis = 'SJI-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
            }

            // Temukan Nama Lengkap
            $name = $data['nama_lengkap'] ?? $data['nama'] ?? $data['name'] ?? null;
            if (empty($name)) {
                continue; // Nama wajib ada
            }

            // Gender normalisasi
            $gender = 'Laki-laki';
            $genderInput = strtolower($data['jenis_kelamin'] ?? $data['gender'] ?? '');
            if (str_contains($genderInput, 'perempuan') || str_contains($genderInput, 'wanita') || $genderInput === 'f' || $genderInput === 'p') {
                $gender = 'Perempuan';
            }

            // Program
            $program = $data['program'] ?? 'Tokutei Ginou (SSW)';

            // Kategori / Jalur Pendaftaran (SMILE Project Khusus Poltekkes MoU, SMK Go Japan, dll)
            $rawCat = strtolower($data['kategori_pendaftaran'] ?? $data['jalur_pendaftaran'] ?? $data['kategori'] ?? $data['registration_category'] ?? '');
            $registrationCategory = 'umum';
            if (str_contains($rawCat, 'smile') || str_contains($rawCat, 'kemenkes')) {
                $registrationCategory = 'smile_project';
            } elseif (str_contains($rawCat, 'smk_go') || str_contains($rawCat, 'go_japan')) {
                $registrationCategory = 'smk_go_japan';
            } elseif (str_contains($rawCat, 'bkk')) {
                $registrationCategory = 'bkk_smk';
            } elseif (str_contains($rawCat, 'poltekkes') || str_contains($rawCat, 'stikes')) {
                $registrationCategory = 'poltekkes_kampus';
            }

            // Status
            $status = strtolower($data['status_pelatihan'] ?? $data['status'] ?? 'active');
            if (!in_array($status, ['active', 'interview', 'passed_interview', 'departed', 'graduated', 'dropout'])) {
                $status = 'active';
            }

            // Keuangan
            $totalCost = (float)($data['total_biaya'] ?? 25000000);
            $paidAmount = (float)($data['sudah_bayar'] ?? 0);
            $paymentScheme = strtolower($data['skema_biaya'] ?? $data['skema_pembiayaan'] ?? 'mandiri');
            if (!in_array($paymentScheme, ['mandiri', 'talangan', 'beasiswa'])) {
                $paymentScheme = 'mandiri';
            }

            $paymentStatus = 'unpaid';
            if ($paidAmount >= $totalCost && $totalCost > 0) {
                $paymentStatus = 'paid';
            } elseif ($paidAmount > 0) {
                $paymentStatus = 'partial';
            }

            // Dates helper
            $parseDate = function ($val) {
                if (empty($val) || $val === '-') return null;
                $timestamp = strtotime($val);
                return $timestamp ? date('Y-m-d', $timestamp) : null;
            };

            $studentPayload = [
                'nis' => $nis,
                'name' => $name,
                'japanese_name' => $data['nama_katakana'] ?? $data['japanese_name'] ?? null,
                'nik' => $data['nik'] ?? null,
                'phone' => $data['whatsapp'] ?? $data['phone'] ?? null,
                'email' => $data['email'] ?? null,
                'gender' => $gender,
                'birth_place' => $data['tempat_lahir'] ?? null,
                'birth_date' => $parseDate($data['tanggal_lahir_yyyymmdd'] ?? $data['tanggal_lahir'] ?? null),
                'education' => $data['pendidikan'] ?? null,
                'address' => $data['alamat'] ?? null,
                'city' => $data['kota_asal'] ?? $data['kota'] ?? null,
                'emergency_contact_name' => $data['kontak_darurat'] ?? null,
                'emergency_contact_phone' => $data['no_darurat'] ?? $data['no_kontak_darurat'] ?? null,
                'batch' => $data['angkatan'] ?? $data['batch'] ?? null,
                'program' => $program,
                'registration_category' => $registrationCategory,
                'sector' => $data['sektor'] ?? $data['sektor_pekerjaan'] ?? null,
                'entry_date' => $parseDate($data['tgl_masuk_yyyymmdd'] ?? $data['tgl_masuk'] ?? null),
                'departure_date' => $parseDate($data['tgl_terbang_yyyymmdd'] ?? $data['tgl_terbang'] ?? null),
                'destination_company' => $data['perusahaan_jepang'] ?? $data['kaisha'] ?? null,
                'destination_prefecture' => $data['prefektur'] ?? null,
                'status' => $status,
                'japanese_level' => $data['level_bahasa'] ?? null,
                'ssw_certificate' => $data['sertifikat_ssw'] ?? null,
                'passport_number' => $data['nomor_paspor'] ?? null,
                'mcu_date' => $parseDate($data['tgl_mcu_yyyymmdd'] ?? $data['tgl_mcu'] ?? null),
                'mcu_clinic' => $data['klinik_mcu'] ?? null,
                'mcu_result' => strtolower($data['hasil_mcu'] ?? 'pending'),
                'coe_number' => $data['nomor_coe'] ?? null,
                'visa_number' => $data['nomor_visa'] ?? null,
                'exam_score' => !empty($data['nilai_ujian']) ? (float)$data['nilai_ujian'] : null,
                'attendance_percentage' => !empty($data['kehadiran']) ? (int)$data['kehadiran'] : null,
                'total_cost' => $totalCost,
                'paid_amount' => $paidAmount,
                'payment_scheme' => $paymentScheme,
                'payment_status' => $paymentStatus,
            ];

            // Cek apakah NIS sudah ada
            $existing = Student::where('nis', $nis)->first();
            if ($existing) {
                $existing->update($studentPayload);
                $updatedCount++;
            } else {
                Student::create($studentPayload);
                $createdCount++;
            }
        }

        fclose($handle);

        return redirect()->route('admin.students.index')->with(
            'success',
            "Proses import CSV selesai: {$createdCount} siswa baru berhasil ditambahkan, {$updatedCount} data siswa diperbarui."
        );
    }

    /**
     * Cetak Kwitansi Pembayaran Resmi Digital
     */
    public function receipt($id)
    {
        $student = Student::findOrFail($id);
        $settings = \App\Models\SiteSetting::allCached();
        $receiptNo = 'KW-SJI/' . date('Ym') . '/' . str_pad($student->id, 4, '0', STR_PAD_LEFT);
        $terbilang = trim($this->terbilang((int)$student->paid_amount)) . ' Rupiah';

        return view('admin.students.receipt', compact('student', 'settings', 'receiptNo', 'terbilang'));
    }

    /**
     * Cetak Invoice Tagihan Biaya Pelatihan
     */
    public function invoice($id)
    {
        $student = Student::findOrFail($id);
        $settings = \App\Models\SiteSetting::allCached();
        $invoiceNo = 'INV-SJI/' . date('Ym') . '/' . str_pad($student->id, 4, '0', STR_PAD_LEFT);
        $terbilangRemaining = trim($this->terbilang((int)$student->remaining_balance)) . ' Rupiah';

        return view('admin.students.invoice', compact('student', 'settings', 'invoiceNo', 'terbilangRemaining'));
    }

    /**
     * Konversi Angka ke Kata Terbilang Rupiah
     */
    private function terbilang($number)
    {
        $number = abs((int)$number);
        $bilang = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        
        if ($number < 12) {
            return $bilang[$number];
        } elseif ($number < 20) {
            return $this->terbilang($number - 10) . ' Belas';
        } elseif ($number < 100) {
            return $this->terbilang((int)($number / 10)) . ' Puluh ' . $this->terbilang($number % 10);
        } elseif ($number < 200) {
            return 'Seratus ' . $this->terbilang($number - 100);
        } elseif ($number < 1000) {
            return $this->terbilang((int)($number / 100)) . ' Ratus ' . $this->terbilang($number % 100);
        } elseif ($number < 2000) {
            return 'Seribu ' . $this->terbilang($number - 1000);
        } elseif ($number < 1000000) {
            return $this->terbilang((int)($number / 1000)) . ' Ribu ' . $this->terbilang($number % 1000);
        } elseif ($number < 1000000000) {
            return $this->terbilang((int)($number / 1000000)) . ' Juta ' . $this->terbilang($number % 1000000);
        }
        return (string)$number;
    }
}
