<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Traits\UploadsImage;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use UploadsImage;

    /**
     * Tampilkan Form Pengaturan Website (Hero, Logo, Navbar, Footer, Stats, Kontak)
     */
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Simpan Pembaruan Pengaturan Website & Upload Logo/Hero Base64
     */
    public function update(Request $request)
    {
        // 1. Ambil semua input kecuali token dan file
        $inputs = $request->except(['_token', '_method', 'site_logo_file', 'hero_image_file']);

        // 2. Prioritaskan Upload File Gambar untuk Logo & Hero
        if ($request->hasFile('site_logo_file')) {
            $base64Logo = $this->handleImageUpload($request, 'site_logo_file', 'site_logo');
            $inputs['site_logo'] = $base64Logo;
        } elseif ($request->filled('site_logo')) {
            $inputs['site_logo'] = trim($request->input('site_logo'));
        } else {
            // Jangan timpa logo lama jika input dikosongkan tanpa file baru
            unset($inputs['site_logo']);
        }

        if ($request->hasFile('hero_image_file')) {
            $base64Hero = $this->handleImageUpload($request, 'hero_image_file', 'hero_image');
            $inputs['hero_image'] = $base64Hero;
        } elseif ($request->filled('hero_image')) {
            $inputs['hero_image'] = trim($request->input('hero_image'));
        } else {
            // Jangan timpa hero_image lama jika input dikosongkan tanpa file baru
            unset($inputs['hero_image']);
        }

        // 3. Handle popup_ticker_enabled checkbox
        if (!$request->has('popup_ticker_enabled')) {
            $inputs['popup_ticker_enabled'] = '0';
        }

        // 4. Handle fonnte_enabled checkbox
        if (!$request->has('fonnte_enabled')) {
            $inputs['fonnte_enabled'] = '0';
        }

        // 5. Handle popup_ticker_items if passed as array
        if (isset($inputs['popup_ticker_items']) && is_array($inputs['popup_ticker_items'])) {
            $inputs['popup_ticker_items'] = json_encode(array_values($inputs['popup_ticker_items']), JSON_UNESCAPED_UNICODE);
        }

        // 6. Simpan semua konfigurasi ke database
        foreach ($inputs as $key => $value) {
            $group = 'general';
            if (str_starts_with($key, 'hero_')) {
                $group = 'hero';
            } elseif (str_starts_with($key, 'stat_')) {
                $group = 'stats';
            } elseif (str_starts_with($key, 'contact_')) {
                $group = 'contact';
            } elseif (str_starts_with($key, 'popup_')) {
                $group = 'ticker';
            } elseif (str_starts_with($key, 'fonnte_')) {
                $group = 'whatsapp';
            }

            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value, 'group' => $group]
            );
        }

        // 7. Invalidate dan flush cache agar seketika sinkron di halaman guest
        \Illuminate\Support\Facades\Cache::forget('site_settings_all');
        try {
            \Illuminate\Support\Facades\Cache::flush();
        } catch (\Throwable $e) {
            // ignore if redis/tag cache not supporting full flush
        }

        return back()->with('success', 'Pengaturan website, banner hero, dan logo berhasil disimpan dan otomatis disinkronkan ke halaman utama.');
    }

    /**
     * Uji Kirim Pesan WhatsApp via Fonnte Gateway
     */
    public function testFonnte(Request $request)
    {
        $validated = $request->validate([
            'target_phone' => 'required|string',
            'token' => 'nullable|string',
        ]);

        if (!empty($validated['token'])) {
            SiteSetting::updateOrCreate(['key' => 'fonnte_api_token'], ['value' => trim($validated['token']), 'group' => 'whatsapp']);
            \Illuminate\Support\Facades\Cache::forget('site_settings_all');
        }

        $testMsg = "Konnichiwa! 🌸\n\nPesan ini adalah UJI COBA KONEKSI WhatsApp Gateway Fonnte dari Portal Admin LPK Sahabat Jepang Indonesia.\n\nStatus: Terhubung Aktif ✅\nWaktu: " . now()->format('d M Y H:i') . " WIB\n\nSelamat, integrasi API WhatsApp Fonnte Anda telah berjalan sempurna tanpa perlu pengaturan file .env!";

        $result = \App\Services\FonnteService::send($validated['target_phone'], $testMsg, [
            'template_key' => 'fonnte_test',
            'recipient_name' => 'Admin Tester',
        ]);

        return response()->json($result);
    }

    /**
     * Cek Status Koneksi Device Fonnte
     */
    public function checkFonnteDevice()
    {
        $status = \App\Services\FonnteService::checkDevice();
        return response()->json($status);
    }
}
