<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    /**
     * Halaman Publik Pendaftaran Mitra Sekolah & Afiliasi
     */
    public function publicRegister()
    {
        $settings = SiteSetting::allCached();
        return view('landing.affiliate-register', compact('settings'));
    }

    /**
     * Simpan Pendaftaran Mitra Sekolah Baru dari Publik
     */
    public function storePublic(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:sekolah,guru_bk,alumni,komunitas',
            'institution_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'bank_name' => 'nullable|string|max:50',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_holder' => 'nullable|string|max:255',
        ]);

        // Auto-generate Unique Referral Code (e.g. SMK-XYZ-123 or REF-NAME)
        $cleanName = strtoupper(Str::slug(substr($validated['institution_name'] ?? $validated['name'], 0, 10)));
        $uniqueCode = $cleanName . '-' . strtoupper(Str::random(4));

        $affiliate = Affiliate::create([
            'code' => $uniqueCode,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'institution_name' => $validated['institution_name'] ?? null,
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'bank_account_number' => $validated['bank_account_number'] ?? null,
            'bank_account_holder' => $validated['bank_account_holder'] ?? null,
            'reward_per_lead' => 500000,
            'is_active' => true,
        ]);

        $refLink = url('/?ref=' . $affiliate->code);

        return back()->with([
            'success' => "Selamat! Kemitraan Anda berhasil terdaftar. Kode Referral Anda: {$affiliate->code}",
            'referral_link' => $refLink,
            'affiliate_code' => $affiliate->code,
        ]);
    }

    /**
     * Panel Admin - Kelola Mitra Afiliasi & Referral
     */
    public function index()
    {
        $affiliates = Affiliate::withCount(['consultations', 'students'])->latest()->paginate(15);
        $totalAffiliates = Affiliate::count();
        $totalReferredLeads = \App\Models\Consultation::whereNotNull('affiliate_code')->count();
        $totalReferredStudents = \App\Models\Student::whereNotNull('affiliate_code')->count();

        return view('admin.affiliates.index', compact('affiliates', 'totalAffiliates', 'totalReferredLeads', 'totalReferredStudents'));
    }

    /**
     * Simpan Mitra Baru dari Admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:affiliates,code|max:50',
            'type' => 'required|in:smk_bkk,sekolah,kampus_poltekkes,guru_bk,alumni,komunitas',
            'institution_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'reward_per_lead' => 'required|numeric|min:0',
            'bank_name' => 'nullable|string|max:50',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_holder' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        Affiliate::create([
            'code' => strtoupper($validated['code']),
            'name' => $validated['name'],
            'type' => $validated['type'],
            'institution_name' => $validated['institution_name'] ?? null,
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'reward_per_lead' => $validated['reward_per_lead'],
            'bank_name' => $validated['bank_name'] ?? null,
            'bank_account_number' => $validated['bank_account_number'] ?? null,
            'bank_account_holder' => $validated['bank_account_holder'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', "Mitra {$validated['name']} berhasil ditambahkan.");
    }

    /**
     * Update Data Mitra
     */
    public function update(Request $request, $id)
    {
        $affiliate = Affiliate::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:smk_bkk,sekolah,kampus_poltekkes,guru_bk,alumni,komunitas',
            'institution_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'reward_per_lead' => 'required|numeric|min:0',
            'bank_name' => 'nullable|string|max:50',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_holder' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $affiliate->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'institution_name' => $validated['institution_name'] ?? null,
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'reward_per_lead' => $validated['reward_per_lead'],
            'bank_name' => $validated['bank_name'] ?? null,
            'bank_account_number' => $validated['bank_account_number'] ?? null,
            'bank_account_holder' => $validated['bank_account_holder'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', "Data mitra {$affiliate->name} berhasil diperbarui.");
    }

    /**
     * Hapus Mitra
     */
    public function destroy($id)
    {
        $affiliate = Affiliate::findOrFail($id);
        $name = $affiliate->name;
        $affiliate->delete();

        return back()->with('success', "Mitra {$name} berhasil dihapus.");
    }

    /**
     * Detail Siswa yang Terdaftar Melalui Referral SMK / BKK (JSON for Modal)
     */
    public function referredStudents($id)
    {
        $affiliate = Affiliate::with(['students', 'consultations'])->findOrFail($id);

        $students = $affiliate->students()->get()->map(function ($s) use ($affiliate) {
            return [
                'id' => $s->id,
                'name' => $s->name,
                'nis' => $s->nis,
                'program' => $s->program,
                'status' => $s->status,
                'status_label' => match($s->status) {
                    'active' => 'Aktif Belajar',
                    'interview' => 'Wawancara Kaisha',
                    'passed_interview' => 'Lolos Seleksi Kaisha',
                    'departed' => 'Terbang ke Jepang',
                    default => ucfirst($s->status),
                },
                'payment_status' => $s->payment_status,
                'paid_amount' => (float) $s->paid_amount,
                'commission' => (float) $affiliate->reward_per_lead,
                'date' => $s->created_at ? $s->created_at->format('d/m/Y') : '-',
            ];
        });

        $leads = $affiliate->consultations()->get()->map(function ($c) {
            return [
                'id' => $c->id,
                'name' => $c->name,
                'phone' => $c->phone,
                'program_interest' => $c->program_interest,
                'status' => $c->status,
                'date' => $c->created_at ? $c->created_at->format('d/m/Y') : '-',
            ];
        });

        return response()->json([
            'success' => true,
            'affiliate' => [
                'id' => $affiliate->id,
                'name' => $affiliate->name,
                'code' => $affiliate->code,
                'type' => $affiliate->type,
                'type_label' => $affiliate->type_label,
                'institution_name' => $affiliate->institution_name,
                'phone' => $affiliate->phone,
                'reward_per_lead' => (float) $affiliate->reward_per_lead,
                'total_reward_earned' => (float) $affiliate->total_reward_earned,
                'referral_link' => url('/?ref=' . $affiliate->code),
            ],
            'students' => $students,
            'leads' => $leads,
            'counts' => [
                'students' => $students->count(),
                'leads' => $leads->count(),
                'passed' => $students->where('status', 'passed_interview')->count() + $students->where('status', 'departed')->count(),
            ]
        ]);
    }

    /**
     * Kirim Sapaan & Rekapitulasi Referral via WhatsApp Fonnte ke Koordinator BKK SMK
     */
    public function sendWaGreeting(Request $request, $id)
    {
        $affiliate = Affiliate::findOrFail($id);
        $studentCount = $affiliate->students()->count();
        $totalCommission = number_format($affiliate->total_reward_earned, 0, ',', '.');
        $rewardPerLead = number_format($affiliate->reward_per_lead, 0, ',', '.');
        $refLink = url('/?ref=' . $affiliate->code);

        $customMessage = $request->input('message');
        if (empty($customMessage)) {
            $msg = "Konnichiwa, Bapak/Ibu *{$affiliate->name}* ({$affiliate->institution_name}) 🌸\n\n";
            $msg .= "Salam hangat dari manajemen *LPK Sahabat Jepang Indonesia*.\n\n";
            $msg .= "Berikut adalah ringkasan kemitraan sekolah & BKK Anda:\n";
            $msg .= "🏷️ *Kode Referral*: `{$affiliate->code}`\n";
            $msg .= "🔗 *Tautan Pendaftaran*: {$refLink}\n";
            $msg .= "👥 *Siswa Terdaftar*: {$studentCount} Siswa\n";
            $msg .= "🎁 *Insentif per Siswa*: Rp {$rewardPerLead}\n";
            $msg .= "💰 *Total Estimasi Komisi*: Rp {$totalCommission}\n\n";
            $msg .= "Terima kasih atas dedikasi dan kerjasama baik dalam menyalurkan alumni menuju karir profesional ke Jepang 🇯🇵.\n\n";
            $msg .= "_LPK Sahabat Jepang Indonesia - Lembaga Penyalur & Pelatihan Kerja Resmi Kemenaker RI_";
        } else {
            $msg = $customMessage;
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', $affiliate->phone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        if (\App\Services\FonnteService::isConfigured()) {
            $res = \App\Services\FonnteService::send($cleanPhone, $msg, [
                'type' => 'affiliate_greeting',
                'affiliate_id' => $affiliate->id
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($res);
            }

            if (!empty($res['success'])) {
                return back()->with('success', "Pesan WhatsApp berhasil dikirim ke mitra {$affiliate->name}.");
            }
        }

        $manualUrl = 'https://wa.me/' . $cleanPhone . '?text=' . urlencode($msg);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'manual_url' => $manualUrl,
                'message' => 'Fonnte belum aktif, tautan WhatsApp manual disiapkan.'
            ]);
        }

        return redirect()->away($manualUrl);
    }

    /**
     * Ekspor Rekapitulasi Kemitraan SMK & BKK ke CSV
     */
    public function exportCsv()
    {
        $affiliates = Affiliate::withCount(['consultations', 'students'])->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="rekap_kemitraan_smk_bkk_' . date('Ymd_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($affiliates) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM

            fputcsv($file, [
                'ID',
                'Kode Referral',
                'Nama Koordinator / Lembaga',
                'Instansi / SMK / BKK',
                'Kategori Kemitraan',
                'No. Telepon / WhatsApp',
                'Email',
                'Total Leads Masuk',
                'Total Siswa Terdaftar',
                'Insentif per Siswa (Rp)',
                'Total Akumulasi Komisi (Rp)',
                'Nomor Rekening',
                'Bank & Pemilik',
                'Status Kemitraan',
                'Tanggal Kerjasama'
            ]);

            foreach ($affiliates as $a) {
                fputcsv($file, [
                    $a->id,
                    $a->code,
                    $a->name,
                    $a->institution_name ?: '-',
                    $a->type_label,
                    $a->phone,
                    $a->email ?: '-',
                    $a->consultations_count,
                    $a->students_count,
                    (float) $a->reward_per_lead,
                    (float) $a->total_reward_earned,
                    $a->bank_account_number ?: '-',
                    ($a->bank_name ? $a->bank_name . ' - ' : '') . ($a->bank_account_holder ?: '-'),
                    $a->is_active ? 'Aktif' : 'Nonaktif',
                    $a->created_at ? $a->created_at->format('d/m/Y H:i') : '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Cetak Lembar Rekapitulasi Kemitraan SMK & BKK ke PDF Resmi
     */
    public function exportPdf()
    {
        $affiliates = Affiliate::withCount(['consultations', 'students'])->latest()->get();
        $totalAffiliates = $affiliates->count();
        $totalStudents = $affiliates->sum('students_count');
        $totalCommission = $affiliates->sum(fn($a) => $a->total_reward_earned);

        return view('admin.affiliates.export_pdf', compact('affiliates', 'totalAffiliates', 'totalStudents', 'totalCommission'));
    }
}
