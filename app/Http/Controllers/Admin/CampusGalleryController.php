<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampusGallery;
use Illuminate\Http\Request;

class CampusGalleryController extends Controller
{
    /**
     * Tampilkan Daftar Foto Galeri Kunjungan Kampus & Program Pemerintah
     */
    public function index(Request $request)
    {
        $query = CampusGallery::query();

        // 1. Search Query
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function($sq) use ($q) {
                $sq->where('title', 'like', "%{$q}%")
                   ->orWhere('institution', 'like', "%{$q}%")
                   ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // 2. Filter Tag Program
        if ($request->filled('tag') && $request->tag !== 'all') {
            $query->where('program_tag', $request->tag);
        }

        $galleries = $query->orderBy('order', 'asc')
                           ->orderByDesc('id')
                           ->paginate(12)
                           ->withQueryString();

        $stats = [
            'total' => CampusGallery::count(),
            'smile_project' => CampusGallery::where('program_tag', 'like', '%SMILE%')->count(),
            'smk_go_japan' => CampusGallery::where('program_tag', 'like', '%SMK%')->count(),
            'active' => CampusGallery::where('is_active', true)->count(),
        ];

        return view('admin.campus_galleries.index', compact('galleries', 'stats'));
    }

    /**
     * Simpan Foto Galeri Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'program_tag' => 'required|string|max:100',
            'badge_text' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sub_text_left' => 'nullable|string|max:100',
            'sub_text_right' => 'nullable|string|max:100',
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:10240',
            'image_url' => 'nullable|string|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $imageData = $request->image_url ?: 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=800&q=80';

        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $file = $request->file('image_file');
            $mime = $file->getMimeType();
            $base64 = base64_encode(file_get_contents($file->getRealPath()));
            $imageData = "data:{$mime};base64,{$base64}";
        }

        CampusGallery::create([
            'title' => $validated['title'],
            'institution' => $validated['institution'] ?? null,
            'program_tag' => $validated['program_tag'],
            'badge_text' => $validated['badge_text'] ?? 'Dokumentasi Resmi',
            'description' => $validated['description'] ?? null,
            'sub_text_left' => $validated['sub_text_left'] ?? 'LPK SJI Kunjungan',
            'sub_text_right' => $validated['sub_text_right'] ?? 'Resmi Terverifikasi',
            'image' => $imageData,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.campus-galleries.index')
                         ->with('success', 'Foto galeri kegiatan kunjungan kampus berhasil ditambahkan!');
    }

    /**
     * Perbarui Data Foto Galeri
     */
    public function update(Request $request, $id)
    {
        $gallery = CampusGallery::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'program_tag' => 'required|string|max:100',
            'badge_text' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sub_text_left' => 'nullable|string|max:100',
            'sub_text_right' => 'nullable|string|max:100',
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:10240',
            'image_url' => 'nullable|string|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'institution' => $validated['institution'] ?? $gallery->institution,
            'program_tag' => $validated['program_tag'],
            'badge_text' => $validated['badge_text'] ?? $gallery->badge_text,
            'description' => $validated['description'] ?? $gallery->description,
            'sub_text_left' => $validated['sub_text_left'] ?? $gallery->sub_text_left,
            'sub_text_right' => $validated['sub_text_right'] ?? $gallery->sub_text_right,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $file = $request->file('image_file');
            $mime = $file->getMimeType();
            $base64 = base64_encode(file_get_contents($file->getRealPath()));
            $updateData['image'] = "data:{$mime};base64,{$base64}";
        } elseif (!empty($request->image_url)) {
            $updateData['image'] = $request->image_url;
        }

        $gallery->update($updateData);

        return redirect()->route('admin.campus-galleries.index')
                         ->with('success', 'Foto galeri berhasil diperbarui!');
    }

    /**
     * Hapus Foto Galeri
     */
    public function destroy($id)
    {
        $gallery = CampusGallery::findOrFail($id);
        $gallery->delete();

        return redirect()->route('admin.campus-galleries.index')
                         ->with('success', 'Foto galeri berhasil dihapus!');
    }

    /**
     * Toggle Status Tampil
     */
    public function toggleActive($id)
    {
        $gallery = CampusGallery::findOrFail($id);
        $gallery->is_active = !$gallery->is_active;
        $gallery->save();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $gallery->is_active,
                'message' => $gallery->is_active ? 'Foto diaktifkan di homepage' : 'Foto dinonaktifkan'
            ]);
        }

        return back()->with('success', 'Status foto galeri berhasil diubah!');
    }
}
