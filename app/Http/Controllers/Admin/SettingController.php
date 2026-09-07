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
        $inputs = $request->except(['_token', '_method', 'site_logo_file', 'hero_image_file', 'site_favicon_file', 'corporate_leader_photo_file']);

        // 2. Prioritaskan Upload File Gambar untuk Logo, Hero, Favicon, & Foto Pimpinan
        if ($request->hasFile('site_logo_file')) {
            $base64Logo = $this->handleImageUpload($request, 'site_logo_file', 'site_logo');
            $inputs['site_logo'] = $base64Logo;
        } elseif ($request->filled('site_logo')) {
            $inputs['site_logo'] = trim($request->input('site_logo'));
        } else {
            // Jangan timpa logo lama jika input dikosongkan tanpa file baru
            unset($inputs['site_logo']);
        }

        if ($request->hasFile('site_favicon_file')) {
            $circleFavicon = $this->createCircularFavicon($request->file('site_favicon_file'));
            $inputs['site_favicon'] = $circleFavicon ?? $this->handleImageUpload($request, 'site_favicon_file', 'site_favicon');
        } elseif ($request->filled('site_favicon')) {
            $inputs['site_favicon'] = trim($request->input('site_favicon'));
        } else {
            unset($inputs['site_favicon']);
        }

        if ($request->hasFile('corporate_leader_photo_file')) {
            $base64LeaderPhoto = $this->handleImageUpload($request, 'corporate_leader_photo_file', 'corporate_leader_photo');
            $inputs['corporate_leader_photo'] = $base64LeaderPhoto;
        } elseif ($request->filled('corporate_leader_photo')) {
            $inputs['corporate_leader_photo'] = trim($request->input('corporate_leader_photo'));
        } else {
            unset($inputs['corporate_leader_photo']);
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
            } elseif (str_starts_with($key, 'corporate_') || str_starts_with($key, 'social_')) {
                $group = 'corporate';
            }

            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value, 'group' => $group]
            );
        }

        // 7. Invalidate dan flush cache agar seketika sinkron di halaman guest
        \Illuminate\Support\Facades\Cache::forget('site_settings_all');
        \Illuminate\Support\Facades\Cache::forget('sji_corporate_synced_stats');
        try {
            \Illuminate\Support\Facades\Cache::flush();
            \Illuminate\Support\Facades\Artisan::call('view:clear');
        } catch (\Throwable $e) {
            // ignore if redis/tag cache not supporting full flush
        }

        return back()->with('success', 'Pengaturan website, banner hero, dan profil korporasi berhasil disimpan dan seketika disinkronkan ke seluruh halaman publik.');
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

    /**
     * Konversi upload favicon menjadi PNG bulat / lingkaran sempurna (Circular Favicon)
     */
    protected function createCircularFavicon($file): ?string
    {
        if (!extension_loaded('gd')) {
            return null;
        }

        try {
            $raw = file_get_contents($file->getRealPath());
            $src = @imagecreatefromstring($raw);
            if (!$src) {
                return null;
            }

            $size = 128;
            $dst = imagecreatetruecolor($size, $size);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
            imagefill($dst, 0, 0, $transparent);

            $srcW = imagesx($src);
            $srcH = imagesy($src);

            // Scale to fit inside circle (approx 78% of diameter)
            $maxInner = 98;
            if ($srcW >= $srcH) {
                $targetW = $maxInner;
                $targetH = max(1, (int)($srcH * ($targetW / $srcW)));
            } else {
                $targetH = $maxInner;
                $targetW = max(1, (int)($srcW * ($targetH / $srcH)));
            }

            $dstX = (int)(($size - $targetW) / 2);
            $dstY = (int)(($size - $targetH) / 2);

            // White circular background with crimson rim
            $white = imagecolorallocate($dst, 255, 255, 255);
            $redBorder = imagecolorallocate($dst, 225, 29, 72);
            imagefilledellipse($dst, (int)($size / 2), (int)($size / 2), $size - 2, $size - 2, $redBorder);
            imagefilledellipse($dst, (int)($size / 2), (int)($size / 2), $size - 6, $size - 6, $white);

            imagecopyresampled($dst, $src, $dstX, $dstY, 0, 0, $targetW, $targetH, $srcW, $srcH);
            imagedestroy($src);

            // Alpha mask outer corners outside circle
            $radius = $size / 2;
            for ($x = 0; $x < $size; $x++) {
                for ($y = 0; $y < $size; $y++) {
                    $dx = $x - $radius;
                    $dy = $y - $radius;
                    $dist = sqrt($dx * $dx + $dy * $dy);
                    if ($dist > ($radius - 1)) {
                        imagesetpixel($dst, $x, $y, $transparent);
                    }
                }
            }

            ob_start();
            imagepng($dst, null, 9);
            $pngData = ob_get_clean();
            imagedestroy($dst);

            // Also refresh circular favicon file on disk
            @file_put_contents(public_path('images/favicon-circle.png'), $pngData);
            @file_put_contents(public_path('favicon.ico'), $pngData);

            return 'data:image/png;base64,' . base64_encode($pngData);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
