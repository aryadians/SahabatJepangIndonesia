<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalArchive;
use App\Traits\UploadsImage;
use Illuminate\Http\Request;

class DigitalArchiveController extends Controller
{
    use UploadsImage;

    /**
     * Tampilkan Galeri Arsip Digital Nota & Dokumen Berbasis Base64
     */
    public function index(Request $request)
    {
        $query = DigitalArchive::with('reimbursement')->latest();

        // 1. Filter Kategori
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // 2. Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('archive_no', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('uploader_name', 'like', "%{$search}%");
            });
        }

        // 3. Filter Tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('document_date', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('document_date', '<=', $request->input('date_to'));
        }

        $archives = $query->paginate(24)->withQueryString();

        $stats = [
            'total_archives' => DigitalArchive::count(),
            'total_receipts' => DigitalArchive::where('category', 'nota_reimburse')->count(),
            'total_mou' => DigitalArchive::where('category', 'dokumen_mou')->count(),
            'total_tickets' => DigitalArchive::where('category', 'kuitansi_hotel_tiket')->count(),
        ];

        return view('admin.digital_archives.index', compact('archives', 'stats'));
    }

    /**
     * Unggah Berkas Arsip Digital Baru (Konversi Otomatis ke Base64 LONGTEXT)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:60',
            'document_date' => 'nullable|date',
            'document_file' => 'required|file|mimes:jpeg,png,jpg,webp,pdf|max:12288', // Maks 12MB
            'notes' => 'nullable|string|max:1000',
        ]);

        $file = $request->file('document_file');
        $mime = $file->getMimeType();
        $base64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));

        $archive = DigitalArchive::create([
            'archive_no' => DigitalArchive::generateNumber(),
            'title' => $validated['title'],
            'category' => $validated['category'],
            'uploader_name' => auth()->user()->name ?? 'Admin Keuangan',
            'document_date' => $validated['document_date'] ?? now()->toDateString(),
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $mime,
            'file_size' => round($file->getSize() / 1024, 1) . ' KB',
            'file_base64' => $base64,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.digital-archives.index')
            ->with('success', "Dokumen arsip {$archive->archive_no} berhasil disimpan dalam format Base64.");
    }

    /**
     * Hapus Dokumen Arsip
     */
    public function destroy($id)
    {
        $archive = DigitalArchive::findOrFail($id);
        $no = $archive->archive_no;
        $archive->delete();

        return redirect()->route('admin.digital-archives.index')
            ->with('success', "Dokumen arsip {$no} berhasil dihapus.");
    }
}
