<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::orderBy('order')->get();
        return view('admin.facilities.index', compact('facilities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'image' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        Facility::create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'image' => $validated['image'],
            'order' => $validated['order'] ?? 0,
        ]);

        return back()->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $facility = Facility::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'image' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $facility->update($validated);

        return back()->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->delete();
        return back()->with('success', 'Fasilitas berhasil dihapus.');
    }
}
