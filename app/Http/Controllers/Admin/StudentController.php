<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Traits\UploadsImage;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use UploadsImage;

    /**
     * Tampilkan List Siswa (High-Performance Server-Side Pagination & Filter)
     */
    public function index(Request $request)
    {
        $query = Student::query();

        // 1. Live Search (NIS, Nama, NIK, No WA)
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('nis', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('destination_company', 'like', "%{$q}%");
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

        // 5. Select only lightweight columns for fast list rendering (exclude heavy base64 strings in listing)
        $students = $query->select([
            'id', 'nis', 'name', 'japanese_name', 'phone', 'gender', 'batch',
            'program', 'sector', 'status', 'entry_date', 'departure_date',
            'destination_company', 'destination_prefecture', 'japanese_level',
            'total_cost', 'paid_amount', 'payment_status', 'payment_scheme', 'photo'
        ])
        ->orderByDesc('id')
        ->paginate(15)
        ->withQueryString();

        // 6. Quick KPI Metrics
        $stats = [
            'total_students' => Student::count(),
            'active_students' => Student::whereIn('status', ['active', 'interview', 'passed_interview'])->count(),
            'departed_students' => Student::where('status', 'departed')->count(),
            'total_receivables' => Student::selectRaw('SUM(total_cost - paid_amount) as total_unpaid')->value('total_unpaid') ?? 0,
        ];

        return view('admin.students.index', compact('students', 'stats'));
    }

    /**
     * Form Tambah Siswa Baru
     */
    public function create()
    {
        return view('admin.students.form', ['student' => new Student()]);
    }

    /**
     * Simpan Data Siswa Baru (Base64 LONGTEXT Image Handling)
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
            'total_cost' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_scheme' => 'required|string|max:50',
            'payment_status' => 'required|string|max:50',
            'payment_notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'photo_file' => 'nullable|image|max:5120',
            'photo' => 'nullable|string',
        ]);

        // Upload Base64 Photo
        $photo = $this->handleImageUpload($request, 'photo_file', 'photo');

        // Otomatis tentukan status pembayaran jika tidak dipilih manual
        $totalCost = (float)$validated['total_cost'];
        $paidAmount = (float)$validated['paid_amount'];
        $paymentStatus = $validated['payment_status'];
        if ($paidAmount >= $totalCost && $totalCost > 0) {
            $paymentStatus = 'paid';
        } elseif ($paidAmount > 0 && $paidAmount < $totalCost) {
            $paymentStatus = 'partial';
        }

        Student::create(array_merge($validated, [
            'photo' => $photo,
            'payment_status' => $paymentStatus,
        ]));

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
            'total_cost' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_scheme' => 'required|string|max:50',
            'payment_status' => 'required|string|max:50',
            'payment_notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'photo_file' => 'nullable|image|max:5120',
            'photo' => 'nullable|string',
        ]);

        $photo = $this->handleImageUpload($request, 'photo_file', 'photo', $student->photo);

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
            'payment_notes' => 'nullable|string',
        ]);

        $paidAmount = (float)$validated['paid_amount'];
        $totalCost = (float)$student->total_cost;
        
        $paymentStatus = 'unpaid';
        if ($paidAmount >= $totalCost && $totalCost > 0) {
            $paymentStatus = 'paid';
        } elseif ($paidAmount > 0) {
            $paymentStatus = 'partial';
        }

        $student->update([
            'paid_amount' => $paidAmount,
            'payment_status' => $paymentStatus,
            'payment_notes' => $validated['payment_notes'] ?? $student->payment_notes,
        ]);

        return back()->with('success', "Pembayaran siswa {$student->name} berhasil diperbarui.");
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
     * Export Data Siswa ke CSV / Excel
     */
    public function exportCsv()
    {
        $students = Student::orderBy('id')->get();
        $fileName = 'Data_Siswa_LPK_Sahabat_Jepang_' . date('Ymd_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'NIS', 'Nama Lengkap', 'Nama Katakana', 'NIK', 'WhatsApp', 'Email',
                'Jenis Kelamin', 'Pendidikan', 'Kota Asal', 'Angkatan', 'Program',
                'Sektor Pekerjaan', 'Tgl Masuk', 'Tgl Terbang', 'Perusahaan Jepang',
                'Prefektur', 'Status Pelatihan', 'Level Bahasa', 'Sertifikat SSW',
                'Total Biaya (IDR)', 'Sudah Bayar (IDR)', 'Sisa Tanggungan (IDR)', 'Status Pembayaran'
            ]);

            foreach ($students as $s) {
                fputcsv($file, [
                    $s->nis,
                    $s->name,
                    $s->japanese_name ?? '-',
                    $s->nik ?? '-',
                    $s->phone ?? '-',
                    $s->email ?? '-',
                    $s->gender,
                    $s->education ?? '-',
                    $s->city ?? '-',
                    $s->batch ?? '-',
                    $s->program,
                    $s->sector ?? '-',
                    $s->entry_date ? $s->entry_date->format('d/m/Y') : '-',
                    $s->departure_date ? $s->departure_date->format('d/m/Y') : '-',
                    $s->destination_company ?? '-',
                    $s->destination_prefecture ?? '-',
                    strtoupper($s->status),
                    $s->japanese_level ?? '-',
                    $s->ssw_certificate ?? '-',
                    $s->total_cost,
                    $s->paid_amount,
                    $s->remaining_balance,
                    strtoupper($s->payment_status)
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
