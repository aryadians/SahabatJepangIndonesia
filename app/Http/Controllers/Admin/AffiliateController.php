<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    /**
     * Halaman Publik Pendaftaran Mitra Sekolah & Afiliasi
     */
    public function publicRegister()
    {
        $settings = SiteSetting::allCached();
        return view('landing.affiliate-register', compact('settings'));
    }

    /**
     * Simpan Pendaftaran Mitra Sekolah Baru dari Publik
     */
    public function storePublic(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:sekolah,guru_bk,alumni,komunitas',
            'institution_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'bank_name' => 'nullable|string|max:50',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_holder' => 'nullable|string|max:255',
        ]);

        // Auto-generate Unique Referral Code (e.g. SMK-XYZ-123 or REF-NAME)
        $cleanName = strtoupper(Str::slug(substr($validated['institution_name'] ?? $validated['name'], 0, 10)));
        $uniqueCode = $cleanName . '-' . strtoupper(Str::random(4));

        $affiliate = Affiliate::create([
            'code' => $uniqueCode,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'institution_name' => $validated['institution_name'] ?? null,
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'bank_account_number' => $validated['bank_account_number'] ?? null,
            'bank_account_holder' => $validated['bank_account_holder'] ?? null,
            'reward_per_lead' => 500000,
            'is_active' => true,
        ]);

        $refLink = url('/?ref=' . $affiliate->code);

        return back()->with([
            'success' => "Selamat! Kemitraan Anda berhasil terdaftar. Kode Referral Anda: {$affiliate->code}",
            'referral_link' => $refLink,
            'affiliate_code' => $affiliate->code,
        ]);
    }

    /**
     * Panel Admin - Kelola Mitra Afiliasi & Referral
     */
    public function index()
    {
        $affiliates = Affiliate::withCount(['consultations', 'students'])->latest()->paginate(15);
        $totalAffiliates = Affiliate::count();
        $totalReferredLeads = \App\Models\Consultation::whereNotNull('affiliate_code')->count();
        $totalReferredStudents = \App\Models\Student::whereNotNull('affiliate_code')->count();

        return view('admin.affiliates.index', compact('affiliates', 'totalAffiliates', 'totalReferredLeads', 'totalReferredStudents'));
    }

    /**
     * Simpan Mitra Baru dari Admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:affiliates,code|max:50',
            'type' => 'required|in:sekolah,guru_bk,alumni,komunitas',
            'institution_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'reward_per_lead' => 'required|numeric|min:0',
            'bank_name' => 'nullable|string|max:50',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_holder' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        Affiliate::create([
            'code' => strtoupper($validated['code']),
            'name' => $validated['name'],
            'type' => $validated['type'],
            'institution_name' => $validated['institution_name'] ?? null,
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'reward_per_lead' => $validated['reward_per_lead'],
            'bank_name' => $validated['bank_name'] ?? null,
            'bank_account_number' => $validated['bank_account_number'] ?? null,
            'bank_account_holder' => $validated['bank_account_holder'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', "Mitra {$validated['name']} berhasil ditambahkan.");
    }

    /**
     * Update Data Mitra
     */
    public function update(Request $request, $id)
    {
        $affiliate = Affiliate::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:sekolah,guru_bk,alumni,komunitas',
            'institution_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'reward_per_lead' => 'required|numeric|min:0',
            'bank_name' => 'nullable|string|max:50',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_holder' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $affiliate->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'institution_name' => $validated['institution_name'] ?? null,
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'reward_per_lead' => $validated['reward_per_lead'],
            'bank_name' => $validated['bank_name'] ?? null,
            'bank_account_number' => $validated['bank_account_number'] ?? null,
            'bank_account_holder' => $validated['bank_account_holder'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', "Data mitra {$affiliate->name} berhasil diperbarui.");
    }

    /**
     * Hapus Mitra
     */
    public function destroy($id)
    {
        $affiliate = Affiliate::findOrFail($id);
        $name = $affiliate->name;
        $affiliate->delete();

        return back()->with('success', "Mitra {$name} berhasil dihapus.");
    }
}
