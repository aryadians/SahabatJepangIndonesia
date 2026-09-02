<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Tampilkan Form Pengaturan Website (Hero, Navbar, Footer, Stats, Kontak)
     */
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Simpan Pembaruan Pengaturan Website
     */
    public function update(Request $request)
    {
        $inputs = $request->except(['_token', '_method']);

        foreach ($inputs as $key => $value) {
            // Determine group
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

        return back()->with('success', 'Pengaturan website berhasil disimpan dan diperbarui.');
    }
}
