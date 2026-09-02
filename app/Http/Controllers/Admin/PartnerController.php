<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('order')->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prefecture' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
        ]);

        Partner::create([
            'name' => $validated['name'],
            'prefecture' => $validated['prefecture'] ?? null,
            'category' => $validated['category'] ?? 'Kaisha',
            'order' => $validated['order'] ?? 0,
        ]);

        return back()->with('success', 'Mitra perusahaan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prefecture' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
        ]);

        $partner->update($validated);

        return back()->with('success', 'Mitra perusahaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();
        return back()->with('success', 'Mitra perusahaan berhasil dihapus.');
    }
}
