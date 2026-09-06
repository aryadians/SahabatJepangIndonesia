<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashTransaction;
use App\Models\SiteSetting;
use App\Models\Teacher;
use App\Traits\UploadsImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    use UploadsImage;

    /**
     * Tampilkan Daftar Karyawan, Manajemen & Sensei
     */
    public function index(Request $request)
    {
        $query = Teacher::query();

        // 1. Filter Pencarian Teks
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('nip', 'like', "%{$q}%")
                    ->orWhere('position_title', 'like', "%{$q}%")
                    ->orWhere('romaji_name', 'like', "%{$q}%")
                    ->orWhere('department', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('specialization', 'like', "%{$q}%");
            });
        }

        // 2. Filter Role / Jabatan (CEO, Direktur, Keuangan, Sensei, Staf)
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        // 3. Filter Status Keaktifan
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // 4. Filter JLPT Level
        if ($request->filled('jlpt_level') && $request->jlpt_level !== 'all') {
            $query->where('jlpt_level', $request->jlpt_level);
        }

        $teachers = $query->orderBy('order', 'asc')->orderBy('id', 'asc')->paginate(15)->withQueryString();

        $stats = [
            'total_teachers' => Teacher::count(),
            'active_teachers' => Teacher::where('status', 'active')->count(),
            'executives_count' => Teacher::where('is_executive', true)->orWhereIn('role', ['ceo_owner', 'director'])->count(),
            'n1_teachers' => Teacher::where('jlpt_level', 'like', '%N1%')->orWhere('jlpt_level', 'like', '%Native%')->count(),
        ];

        $paymentMethods = CashTransaction::PAYMENT_METHODS;

        return view('admin.teachers.index', compact('teachers', 'stats', 'paymentMethods'));
    }

    /**
     * Export / Cetak Daftar Dewan Pengajar & Karyawan ke PDF Resmi
     */
    public function exportPdf(Request $request)
    {
        $query = Teacher::query();

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('nip', 'like', "%{$q}%")
                    ->orWhere('position_title', 'like', "%{$q}%")
                    ->orWhere('romaji_name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('specialization', 'like', "%{$q}%");
            });
        }

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('jlpt_level') && $request->jlpt_level !== 'all') {
            $query->where('jlpt_level', $request->jlpt_level);
        }

        $teachers = $query->orderBy('order', 'asc')->orderBy('id', 'asc')->get();

        return view('admin.teachers.export_pdf', compact('teachers'));
    }

    /**
     * Form Tambah Karyawan / Sensei
     */
    public function create()
    {
        return view('admin.teachers.form', ['teacher' => new Teacher()]);
    }

    /**
     * Simpan Karyawan / Pengajar Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:50|unique:teachers,nip',
            'role' => 'nullable|string|in:ceo_owner,director,finance,operations,sensei,staff',
            'name' => 'required|string|max:255',
            'romaji_name' => 'nullable|string|max:255',
            'position_title' => 'nullable|string|max:150',
            'department' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'join_date' => 'nullable|date',
            'jlpt_level' => 'nullable|string|max:100',
            'japan_experience' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:50',
            'status' => 'required|string|max:30',
            'is_executive' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'notes' => 'nullable|string',
            'photo_file' => 'nullable|image|max:5120',
            'photo' => 'nullable|string',
        ]);

        $photo = $this->handleImageUpload($request, 'photo_file', 'photo');

        // Defaults untuk data karyawan non-guru
        $role = $validated['role'] ?? 'sensei';
        $isExecutive = $request->has('is_executive') ? (bool) $request->input('is_executive') : in_array($role, ['ceo_owner', 'director']);

        Teacher::create(array_merge($validated, [
            'role' => $role,
            'jlpt_level' => $validated['jlpt_level'] ?? ($role === 'sensei' ? 'N2' : '-'),
            'specialization' => $validated['specialization'] ?? ($role === 'sensei' ? 'Bunpou & Kaiwa' : ($validated['position_title'] ?? 'Operasional')),
            'employment_type' => $validated['employment_type'] ?? 'full_time',
            'is_executive' => $isExecutive,
            'order' => (int) ($validated['order'] ?? 0),
            'photo' => $photo,
        ]));

        return redirect()->route('admin.teachers.index')->with('success', 'Data karyawan / pengajar berhasil ditambahkan.');
    }

    /**
     * Form Edit Karyawan / Sensei
     */
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('admin.teachers.form', compact('teacher'));
    }

    /**
     * Update Karyawan / Pengajar
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validated = $request->validate([
            'nip' => 'required|string|max:50|unique:teachers,nip,' . $teacher->id,
            'role' => 'nullable|string|in:ceo_owner,director,finance,operations,sensei,staff',
            'name' => 'required|string|max:255',
            'romaji_name' => 'nullable|string|max:255',
            'position_title' => 'nullable|string|max:150',
            'department' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'join_date' => 'nullable|date',
            'jlpt_level' => 'nullable|string|max:100',
            'japan_experience' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:50',
            'status' => 'required|string|max:30',
            'is_executive' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'notes' => 'nullable|string',
            'photo_file' => 'nullable|image|max:5120',
            'photo' => 'nullable|string',
        ]);

        $photo = $this->handleImageUpload($request, 'photo_file', 'photo', $teacher->photo);

        $role = $validated['role'] ?? $teacher->role ?? 'sensei';
        $isExecutive = $request->has('is_executive') ? (bool) $request->input('is_executive') : in_array($role, ['ceo_owner', 'director']);

        $teacher->update(array_merge($validated, [
            'role' => $role,
            'jlpt_level' => $validated['jlpt_level'] ?? $teacher->jlpt_level ?? '-',
            'specialization' => $validated['specialization'] ?? $teacher->specialization ?? 'Operasional',
            'employment_type' => $validated['employment_type'] ?? $teacher->employment_type ?? 'full_time',
            'is_executive' => $isExecutive,
            'order' => (int) ($validated['order'] ?? 0),
            'photo' => $photo,
        ]));

        return redirect()->route('admin.teachers.index')->with('success', 'Data karyawan / sensei berhasil diperbarui.');
    }

    /**
     * Hapus Data Karyawan / Sensei
     */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return back()->with('success', 'Data karyawan / sensei berhasil dihapus.');
    }

    /**
     * Pencatatan Pembayaran Gaji / Honorarium Sensei & Karyawan ke Buku Kas Umum
     */
    public function paySalary(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|string|in:' . implode(',', array_keys(CashTransaction::PAYMENT_METHODS)),
            'payment_date' => 'required|date',
            'salary_period' => 'required|string|max:100',
            'notes' => 'nullable|string|max:1000',
            'proof_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
        ]);

        // Cek proteksi periode tutup buku
        $lockDate = SiteSetting::get('financial_lock_until');
        if ($lockDate && $validated['payment_date'] <= $lockDate) {
            $formattedLock = Carbon::parse($lockDate)->format('d/m/Y');
            return back()->with('error', "Gagal! Tanggal transaksi berada dalam periode yang telah Ditutup Buku (Lock Period s/d {$formattedLock}).");
        }

        $proofBase64 = $this->handleFileUpload($request, 'proof_file', 'proof_file');

        $trxNumber = CashTransaction::generateNumber('expense');

        $trx = CashTransaction::create([
            'transaction_number' => $trxNumber,
            'transaction_date' => $validated['payment_date'],
            'type' => 'expense',
            'category' => 'teacher_salary',
            'title' => "Gaji / Honorarium Sensei: {$teacher->name} ({$validated['salary_period']})",
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'reference_type' => 'teacher',
            'reference_id' => $teacher->id,
            'proof_file' => $proofBase64,
            'notes' => $validated['notes'] ?: "Pembayaran honorarium pengajar/staf {$teacher->name} ({$teacher->nip}) periode {$validated['salary_period']}.",
            'recorded_by' => auth()->user()->name ?? 'Admin Keuangan',
        ]);

        $formattedAmount = 'Rp ' . number_format($validated['amount'], 0, ',', '.');

        // Notifikasi WhatsApp via Fonnte ke Guru / Sensei
        $cleanPhone = preg_replace('/[^0-9]/', '', $teacher->phone ?? '');
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        if (\App\Services\FonnteService::isConfigured() && !empty($cleanPhone)) {
            $position = $teacher->position_title ?: 'Sensei';
            $msg = "Konnichiwa, *{$teacher->name}* ({$position}) 🌸\n\n";
            $msg .= "Gaji / Honorarium Anda untuk periode *{$validated['salary_period']}* telah berhasil diproses dan dicairkan oleh Manajemen *LPK Sahabat Jepang Indonesia*.\n\n";
            $msg .= "📋 *Detail Pembayaran Honorarium*:\n";
            $msg .= "🔖 *No. Bukti Kas*: `{$trxNumber}`\n";
            $msg .= "💵 *Nominal Diterima*: *{$formattedAmount}*\n";
            $msg .= "💳 *Metode Pembayaran*: " . ($trx->payment_method_label) . "\n";
            $msg .= "📅 *Tanggal Transaksi*: " . Carbon::parse($validated['payment_date'])->format('d/m/Y') . "\n\n";
            $msg .= "Terima kasih banyak atas dedikasi dan bimbingan terbaik Anda dalam mencetak calon tenaga kerja unggul ke Jepang 🇯🇵.\n\n";
            $msg .= "_LPK Sahabat Jepang Indonesia - Lembaga Penyalur & Pelatihan Kerja Resmi Kemenaker RI_";

            \App\Services\FonnteService::send($cleanPhone, $msg, [
                'type' => 'salary_slip',
                'teacher_id' => $teacher->id,
            ]);
        }

        return back()->with('success', "Gaji {$teacher->name} sebesar {$formattedAmount} berhasil dicatat di Buku Kas Umum (No: {$trxNumber}).");
    }
}

