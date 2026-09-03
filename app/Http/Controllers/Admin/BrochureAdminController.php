<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brochure;
use App\Models\Consultation;
use Illuminate\Http\Request;

class BrochureAdminController extends Controller
{
    /**
     * Tampilkan Manajemen Brosur & Materi Unduhan
     */
    public function index(Request $request)
    {
        $program = $request->query('program', 'all');

        $query = Brochure::orderBy('order')->orderBy('id', 'desc');

        if ($program !== 'all') {
            $query->where('program', $program);
        }

        $brochures = $query->paginate(10);

        $stats = [
            'total_brochures' => Brochure::count(),
            'total_downloads' => Brochure::sum('download_count'),
            'active_brochures' => Brochure::where('is_active', true)->count(),
            'leads_from_brochures' => Consultation::where('admin_notes', 'LIKE', '%brosur%')->count(),
        ];

        return view('admin.brochures.index', compact('brochures', 'stats', 'program'));
    }

    /**
     * Simpan / Upload Brosur Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'program' => 'required|string|max:100',
            'badge_text' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'brochure_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:20480', // Maksimal 20MB
            'is_active' => 'nullable|boolean',
        ]);

        $filePath = null;
        $fileName = null;
        $fileSize = null;

        if ($request->hasFile('brochure_file')) {
            $file = $request->file('brochure_file');
            $fileName = $file->getClientOriginalName();
            $bytes = $file->getSize();
            $fileSize = $this->formatFileSize($bytes);

            // Simpan sebagai Base64 Data URI untuk persistensi mandiri tanpa dependensi filesystem eksternal
            $data = file_get_contents($file->getRealPath());
            $mime = $file->getMimeType();
            $filePath = 'data:' . $mime . ';base64,' . base64_encode($data);
        } else {
            // Default file name generator jika admin tidak upload file fisik
            $fileName = 'Brosur-' . \Str::slug($validated['title']) . '-LPK-SJI.pdf';
            $fileSize = '2.5 MB';
        }

        Brochure::create([
            'title' => $validated['title'],
            'program' => $validated['program'],
            'badge_text' => $validated['badge_text'] ?? 'Update 2026',
            'description' => $validated['description'],
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'is_active' => $request->boolean('is_active', true),
            'order' => Brochure::max('order') + 1,
        ]);

        return redirect()->route('admin.brochures.index')->with('success', 'Brosur materi program ' . $validated['title'] . ' berhasil diunggah.');
    }

    /**
     * Perbarui Data Brosur
     */
    public function update(Request $request, $id)
    {
        $brochure = Brochure::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'program' => 'required|string|max:100',
            'badge_text' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'brochure_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:20480',
            'is_active' => 'nullable|boolean',
        ]);

        $payload = [
            'title' => $validated['title'],
            'program' => $validated['program'],
            'badge_text' => $validated['badge_text'],
            'description' => $validated['description'],
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('brochure_file')) {
            $file = $request->file('brochure_file');
            $payload['file_name'] = $file->getClientOriginalName();
            $payload['file_size'] = $this->formatFileSize($file->getSize());
            $data = file_get_contents($file->getRealPath());
            $payload['file_path'] = 'data:' . $file->getMimeType() . ';base64,' . base64_encode($data);
        }

        $brochure->update($payload);

        return redirect()->route('admin.brochures.index')->with('success', 'Brosur ' . $brochure->title . ' berhasil diperbarui.');
    }

    /**
     * Hapus Brosur
     */
    public function destroy($id)
    {
        $brochure = Brochure::findOrFail($id);
        $title = $brochure->title;
        $brochure->delete();

        return redirect()->route('admin.brochures.index')->with('success', 'Brosur ' . $title . ' berhasil dihapus.');
    }

    /**
     * Format Ukuran File ke KB / MB
     */
    private function formatFileSize($bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        } elseif ($bytes >= 1024) {
            return round($bytes / 1024, 0) . ' KB';
        }
        return $bytes . ' B';
    }
}
