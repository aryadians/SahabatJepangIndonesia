<?php

namespace App\Http\Controllers;

use App\Models\BatchSchedule;
use App\Models\Brochure;
use App\Models\Consultation;
use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\WhatsAppLog;
use App\Models\WhatsAppTemplate;
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
        $lead = Consultation::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'program' => $brochure->program,
            'city' => $validated['city'] ?? 'Indonesia',
            'status' => 'pending',
            'admin_notes' => 'Telah mengunduh: ' . $brochure->title . ' (' . $brochure->program . ')',
        ]);

        // 3. Automasi Notifikasi WhatsApp: Catat log dan siapkan template sambutan resmi
        $cleanPhone = preg_replace('/[^0-9]/', '', $validated['phone']);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        $brochureLink = route('brochure.index', ['unlocked' => 'true', 'brochure_id' => $brochure->id]);
        $template = WhatsAppTemplate::where('trigger_key', 'brochure_download')->first();
        if ($template && !empty($template->message)) {
            $waMessage = str_replace(
                ['{nama}', '{brosur}', '{program}', '{link}'],
                [$validated['name'], $brochure->title, $brochure->program, $brochureLink],
                $template->message
            );
        } else {
            $waMessage = "Konnichiwa Kak {$validated['name']}! 🌸\n\nTerima kasih telah mengunduh {$brochure->title} ({$brochure->program}) dari LPK Sahabat Jepang Indonesia.\n\nDokumen resmi dapat diakses kembali di: {$brochureLink}\n\nApakah ada pertanyaan? Tim konselor siap membantu konsultasi via WhatsApp.";
        }

        if (\App\Services\FonnteService::isConfigured()) {
            \App\Services\FonnteService::send($cleanPhone, $waMessage, [
                'recipient_name' => $validated['name'],
                'template_key' => 'brochure_download',
            ]);
        } else {
            WhatsAppLog::create([
                'recipient_phone' => $cleanPhone,
                'recipient_name' => $validated['name'],
                'template_key' => 'brochure_download',
                'message_body' => $waMessage,
                'status' => 'sent',
            ]);
        }

        $hotlinePhone = preg_replace('/[^0-9]/', '', SiteSetting::get('contact_phone', '6281234567890'));
        $waCounselorUrl = "https://api.whatsapp.com/send?phone={$hotlinePhone}&text=" . urlencode("Halo Tim Konselor LPK SJI, saya {$validated['name']} baru saja mengunduh {$brochure->title}. Saya ingin konsultasi jadwal pendaftaran kelas dan tahapan seleksinya.");

        return redirect()->route('brochure.index', [
            'unlocked' => 'true',
            'brochure_id' => $brochure->id,
        ])->with('success', 'Selamat ' . $validated['name'] . '! Brosur ' . $brochure->title . ' siap Anda baca dan unduh.')
          ->with('wa_sent', true)
          ->with('wa_phone', $cleanPhone)
          ->with('wa_counselor_url', $waCounselorUrl);
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
