<?php

namespace App\Http\Controllers;

use App\Models\BatchSchedule;
use App\Models\Brochure;
use App\Models\Consultation;
use App\Models\Program;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class BrochureController extends Controller
{
    /**
     * Tampilkan Halaman Katalog & Unduh Brosur Resmi LPK
     */
    public function index(Request $request)
    {
        $settings = SiteSetting::allCached();
        $selectedProgram = $request->query('program', 'all');

        $query = Brochure::active();
        if ($selectedProgram !== 'all') {
            $query->where('program', $selectedProgram);
        }
        $brochures = $query->get();

        $allPrograms = Program::orderBy('order')->get();
        $batches = BatchSchedule::where('status', '!=', 'closed')->orderBy('start_date')->get();

        // Brosur yang dipilih untuk dibuka
        $unlockedBrochure = null;
        if ($request->has('brochure_id')) {
            $unlockedBrochure = Brochure::find($request->query('brochure_id'));
        } elseif ($request->query('unlocked') === 'true' && $brochures->count() > 0) {
            $unlockedBrochure = $brochures->first();
        }

        return view('landing.brochure', compact(
            'settings',
            'brochures',
            'allPrograms',
            'batches',
            'selectedProgram',
            'unlockedBrochure'
        ));
    }

    /**
     * Simpan Data Pendaftar (Lead Magnet) dan Berikan File Brosur Sesuai Pilihan
     */
    public function download(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:25',
            'brochure_id' => 'required|exists:brochures,id',
            'city' => 'nullable|string|max:100',
        ]);

        $brochure = Brochure::findOrFail($validated['brochure_id']);

        // 1. Naikkan hitungan total unduh brosur
        $brochure->increment('download_count');

        // 2. Simpan pendaftar baru ke master database leads
        Consultation::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'program' => $brochure->program,
            'city' => $validated['city'] ?? 'Indonesia',
            'status' => 'pending',
            'admin_notes' => 'Telah mengunduh: ' . $brochure->title . ' (' . $brochure->program . ')',
        ]);

        return redirect()->route('brochure.index', [
            'unlocked' => 'true',
            'brochure_id' => $brochure->id,
        ])->with('success', 'Selamat ' . $validated['name'] . '! Brosur ' . $brochure->title . ' siap Anda baca dan unduh.');
    }

    /**
     * Unduh File Fisik Brosur (Jika Tersimpan Sebagai Base64 atau URL)
     */
    public function downloadFile($id)
    {
        $brochure = Brochure::findOrFail($id);
        $brochure->increment('download_count');

        if (!empty($brochure->file_path) && str_starts_with($brochure->file_path, 'data:')) {
            // Decode Base64 Data URI
            list($header, $data) = explode(';', $brochure->file_path);
            list(, $mime) = explode(':', $header);
            list(, $data) = explode(',', $data);
            $binary = base64_decode($data);

            return response($binary)
                ->header('Content-Type', $mime ?: 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . ($brochure->file_name ?: 'Brosur-LPK-SJI.pdf') . '"');
        }

        // Fallback jika belum ada file fisik: redirect ke mode preview print
        return redirect()->route('brochure.index', [
            'unlocked' => 'true',
            'brochure_id' => $brochure->id,
        ]);
    }
}
