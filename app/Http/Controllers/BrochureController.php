<?php

namespace App\Http\Controllers;

use App\Models\BatchSchedule;
use App\Models\Consultation;
use App\Models\Program;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class BrochureController extends Controller
{
    /**
     * Tampilkan Halaman Unduh & Preview Brosur Resmi LPK
     */
    public function index()
    {
        $settings = SiteSetting::allCached();
        $programs = Program::orderBy('order')->get();
        $batches = BatchSchedule::where('status', '!=', 'closed')->orderBy('start_date')->get();

        return view('landing.brochure', compact('settings', 'programs', 'batches'));
    }

    /**
     * Simpan Data Pendaftar (Lead Magnet) dan Izinkan Unduh Brosur
     */
    public function download(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:25',
            'program' => 'required|string|max:100',
            'city' => 'nullable|string|max:100',
        ]);

        // Simpan langsung sebagai lead konsultasi baru di database
        Consultation::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'program' => $validated['program'],
            'city' => $validated['city'] ?? 'Indonesia',
            'status' => 'pending',
            'admin_notes' => 'Telah mengunduh Brosur Resmi Kurikulum & Biaya LPK SJI melalui website publik.',
        ]);

        return redirect()->route('brochure.index', ['unlocked' => 'true'])
                         ->with('success', 'Terima kasih ' . $validated['name'] . '! Brosur resmi LPK Sahabat Jepang Indonesia siap Anda baca dan cetak.');
    }
}
