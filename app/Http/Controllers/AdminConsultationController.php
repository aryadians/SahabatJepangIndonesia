<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
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
}
