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
        // 1. Handle File Uploads (Base64 LongText)
        if ($request->hasFile('site_logo_file')) {
            $base64Logo = $this->handleImageUpload($request, 'site_logo_file', 'site_logo');
            SiteSetting::updateOrCreate(['key' => 'site_logo'], ['value' => $base64Logo, 'group' => 'general']);
        }

        if ($request->hasFile('hero_image_file')) {
            $base64Hero = $this->handleImageUpload($request, 'hero_image_file', 'hero_image');
            SiteSetting::updateOrCreate(['key' => 'hero_image'], ['value' => $base64Hero, 'group' => 'hero']);
        }

        // 2. Handle Text Inputs
        $inputs = $request->except(['_token', '_method', 'site_logo_file', 'hero_image_file']);

        foreach ($inputs as $key => $value) {
            $group = 'general';
            if (str_starts_with($key, 'hero_')) {
                $group = 'hero';
            } elseif (str_starts_with($key, 'stat_')) {
                $group = 'stats';
            } elseif (str_starts_with($key, 'contact_')) {
                $group = 'contact';
            }

            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group]
            );
        }

        return back()->with('success', 'Pengaturan website dan logo berhasil diperbarui.');
    }
}
