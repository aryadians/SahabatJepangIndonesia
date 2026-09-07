<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Consultation;
use App\Models\Student;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminConsultationController extends Controller
{
    /**
     * Tampilkan Daftar Leads Pendaftaran & Konsultasi Calon Siswa
     */
    public function index(Request $request)
    {
        $query = Consultation::query()->latest();

        // Filter status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter program
        if ($request->filled('program') && $request->program !== 'all') {
            $query->where('program', 'like', "%{$request->program}%");
        }

        // Search name, phone, city
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $consultations = $query->paginate(15)->withQueryString();

        // Metrics Summary
        $stats = [
            'total' => Consultation::count(),
            'pending' => Consultation::where('status', 'pending')->count(),
            'contacted' => Consultation::where('status', 'contacted')->count(),
            'registered' => Consultation::where('status', 'registered')->count(),
        ];

        return view('admin.consultations.index', compact('consultations', 'stats'));
    }

    /**
     * Update Status Konsultasi (Pending -> Contacted -> Registered -> Cancelled)
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,contacted,registered,cancelled',
            'admin_notes' => 'nullable|string',
        ]);

        $consultation = Consultation::findOrFail($id);
        $consultation->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            $stats = [
                'total' => Consultation::count(),
                'pending' => Consultation::where('status', 'pending')->count(),
                'contacted' => Consultation::where('status', 'contacted')->count(),
                'registered' => Consultation::where('status', 'registered')->count(),
                'cancelled' => Consultation::where('status', 'cancelled')->count(),
            ];

            return response()->json([
                'success' => true,
                'message' => "Status {$consultation->name} berhasil diubah menjadi " . ucfirst($consultation->status),
                'status' => $consultation->status,
                'consultation' => $consultation,
                'stats' => $stats,
            ]);
        }

        return back()->with('success', "Data follow-up {$consultation->name} berhasil diperbarui.");
    }

    /**
     * Hapus Data Konsultasi
     */
    public function destroy($id)
    {
        $consultation = Consultation::findOrFail($id);
        $name = $consultation->name;
        $consultation->delete();

        return back()->with('success', "Data {$name} berhasil dihapus.");
    }

    /**
     * Export Seluruh Data Leads ke CSV
     */
    public function exportCsv(): StreamedResponse
    {
        $fileName = 'data-pendaftar-lpk-sji-' . date('Y-m-d-His') . '.csv';
        $consultations = Consultation::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($consultations) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // CSV Header
            fputcsv($file, [
                'ID',
                'Nama Lengkap',
                'Nomor WhatsApp',
                'Usia',
                'Pendidikan',
                'Program Minat',
                'Kota Asal',
                'Pesan / Catatan Pendaftar',
                'Catatan Internal Admin / Konselor',
                'Status',
                'Tanggal Pendaftaran'
            ]);

            foreach ($consultations as $row) {
                fputcsv($file, [
                    $row->id,
                    $row->name,
                    $row->phone,
                    $row->age ?? '-',
                    $row->education ?? '-',
                    $row->program,
                    $row->city ?? '-',
                    $row->message ?? '-',
                    $row->admin_notes ?? '-',
                    strtoupper($row->status),
                    $row->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Cetak Lembar Formulir Pendaftaran / Biodata Siswa (PDF / Print View)
     */
    public function printForm($id)
    {
        $consultation = Consultation::findOrFail($id);
        return view('admin.consultations.print', compact('consultation'));
    }

    /**
     * Export / Cetak Rekapitulasi Data Leads Calon Siswa ke PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Consultation::query()->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('program') && $request->program !== 'all') {
            $query->where('program', 'like', "%{$request->program}%");
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $consultations = $query->get();

        return view('admin.consultations.export_pdf', compact('consultations'));
    }

    /**
     * Konversi Data Calon Pendaftar (Lead) Menjadi Siswa Resmi LPK SJI Group
     */
    public function convertToStudent(Request $request, $id)
    {
        $consultation = Consultation::findOrFail($id);

        $validated = $request->validate([
            'batch' => 'nullable|string|max:100',
            'program' => 'required|string|max:100',
            'city' => 'nullable|string|max:100',
            'gender' => 'nullable|string|in:Laki-laki,Perempuan',
            'entry_date' => 'nullable|date',
            'total_cost' => 'nullable|numeric|min:0',
            'payment_scheme' => 'nullable|string|in:mandiri,talangan,beasiswa',
            'registration_category' => 'nullable|string|max:50',
        ]);

        // Generate NIS Otomatis Berurutan (SJI-Y-XXX)
        $year = date('Y');
        $prefix = "SJI-{$year}-";
        $latestNis = Student::where('nis', 'like', "{$prefix}%")
            ->orderByDesc('nis')
            ->value('nis');

        if ($latestNis && preg_match('/-(\d+)$/', $latestNis, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        } else {
            $nextNumber = Student::count() + 1;
        }

        $nis = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        while (Student::where('nis', $nis)->exists()) {
            $nextNumber++;
            $nis = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        // Buat record siswa baru
        $student = Student::create([
            'nis' => $nis,
            'name' => $consultation->name,
            'phone' => $consultation->phone,
            'city' => $validated['city'] ?? $consultation->city,
            'education' => $consultation->education,
            'program' => $validated['program'] ?? $consultation->program ?? 'Tokutei Ginou (SSW)',
            'batch' => !empty($validated['batch']) ? $validated['batch'] : ('Angkatan ' . date('Y')),
            'gender' => $validated['gender'] ?? 'Laki-laki',
            'entry_date' => $validated['entry_date'] ?? now()->toDateString(),
            'total_cost' => $validated['total_cost'] ?? 15000000,
            'paid_amount' => 0,
            'payment_scheme' => $validated['payment_scheme'] ?? 'mandiri',
            'payment_status' => 'unpaid',
            'registration_category' => $validated['registration_category'] ?? 'reguler',
            'status' => 'active',
        ]);

        // Update status lead menjadi registered
        $note = "Dikonversi menjadi Siswa Resmi (NIS: {$student->nis}) pada " . now()->format('d/m/Y H:i') . " oleh " . (auth()->user()->name ?? 'Admin');
        $consultation->update([
            'status' => 'registered',
            'admin_notes' => trim(($consultation->admin_notes ? $consultation->admin_notes . "\n" : '') . $note),
        ]);

        // Audit Log
        AuditLog::record(
            'lead_convert_to_student',
            "Mengonversi calon siswa {$consultation->name} menjadi siswa resmi (NIS: {$student->nis})",
            [
                'consultation_id' => $consultation->id,
                'student_id' => $student->id,
                'nis' => $student->nis,
                'program' => $student->program,
            ]
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Pendaftar {$consultation->name} berhasil dikonversi menjadi siswa resmi dengan NIS: {$student->nis}.",
                'student_id' => $student->id,
                'nis' => $student->nis,
                'redirect_url' => route('admin.students.edit', $student->id),
            ]);
        }

        return redirect()->route('admin.students.edit', $student->id)
            ->with('success', "Pendaftar {$consultation->name} berhasil dikonversi menjadi siswa resmi dengan NIS: {$student->nis}. Silakan lengkapi biodata atau dokumen siswa.");
    }
}
