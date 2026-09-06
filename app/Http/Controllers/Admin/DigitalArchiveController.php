<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArchiveFolder;
use App\Models\DigitalArchive;
use App\Models\SiteSetting;
use App\Traits\UploadsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DigitalArchiveController extends Controller
{
    use UploadsImage;

    /**
     * Tampilkan Halaman Utama Windows File Explorer Arsip Digital
     */
    public function index(Request $request)
    {
        $rootFolders = ArchiveFolder::whereNull('parent_id')->withCount(['children', 'archives'])->orderBy('name', 'asc')->get();
        $allFolders = ArchiveFolder::withCount('archives')->orderBy('name', 'asc')->get();
        $recentArchives = DigitalArchive::latest()->take(30)->get();

        $stats = $this->calculateStats();

        return view('admin.digital_archives.index', compact('rootFolders', 'allFolders', 'recentArchives', 'stats'));
    }

    /**
     * Hitung Kapasitas & Sisa Penyimpanan Arsip Digital (Hosting / Cloud / Lokal Disk)
     */
    protected function calculateStorageInfo(): array
    {
        $driver = SiteSetting::get('archive_storage_driver', 'hosting'); // hosting, cloud, local

        // 1. Hitung total penggunaan data di database (Base64 LONGTEXT)
        $usedBytes = (float) (DigitalArchive::selectRaw('SUM(LENGTH(file_base64)) as total_bytes')->value('total_bytes') ?? 0);

        // 2. Tentukan Total Quota & Free Space sesuai Driver
        $totalQuotaBytes = 0;
        $freeBytes = 0;
        $driverLabel = '';
        $driverIcon = '';

        if ($driver === 'local') {
            $driverLabel = 'Penyimpanan Lokal Server';
            $driverIcon = 'hard-drive';
            $diskTotal = @disk_total_space(base_path());
            $diskFree = @disk_free_space(base_path());

            if ($diskTotal && $diskTotal > 0) {
                $totalQuotaBytes = (float) $diskTotal;
                $freeBytes = $diskFree ? max(0, (float) $diskFree) : max(0, $totalQuotaBytes - $usedBytes);
            } else {
                $quotaMb = (float) SiteSetting::get('archive_local_quota_mb', 20480); // 20 GB default
                $totalQuotaBytes = $quotaMb * 1024 * 1024;
                $freeBytes = max(0, $totalQuotaBytes - $usedBytes);
            }
        } elseif ($driver === 'cloud') {
            $driverLabel = 'Cloud Object Storage (S3 / Cloud Tier)';
            $driverIcon = 'cloud';
            $quotaMb = (float) SiteSetting::get('archive_cloud_quota_mb', 10240); // 10 GB default
            $totalQuotaBytes = $quotaMb * 1024 * 1024;
            $freeBytes = max(0, $totalQuotaBytes - $usedBytes);
        } else {
            // Default: Hosting Web / cPanel Shared Quota
            $driver = 'hosting';
            $driverLabel = 'Hosting Server Web (cPanel / VPS)';
            $driverIcon = 'server';
            $quotaMb = (float) SiteSetting::get('archive_hosting_quota_mb', 5120); // 5 GB default
            $totalQuotaBytes = $quotaMb * 1024 * 1024;
            $freeBytes = max(0, $totalQuotaBytes - $usedBytes);
        }

        $usedPercentage = $totalQuotaBytes > 0 ? min(100, round(($usedBytes / $totalQuotaBytes) * 100, 1)) : 0;
        $freePercentage = max(0, round(100 - $usedPercentage, 1));

        return [
            'driver' => $driver,
            'driver_label' => $driverLabel,
            'driver_icon' => $driverIcon,
            'used_bytes' => $usedBytes,
            'used_formatted' => $this->formatBytes($usedBytes),
            'free_bytes' => $freeBytes,
            'free_formatted' => $this->formatBytes($freeBytes),
            'total_quota_bytes' => $totalQuotaBytes,
            'total_quota_formatted' => $this->formatBytes($totalQuotaBytes),
            'used_percentage' => $usedPercentage,
            'free_percentage' => $freePercentage,
        ];
    }

    protected function formatBytes($bytes, $precision = 2): string
    {
        if ($bytes <= 0) return '0 MB';
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Hitung Statistik Mini Dashboard Arsip Digital
     */
    protected function calculateStats(): array
    {
        $totalFiles = DigitalArchive::count();
        $totalFolders = ArchiveFolder::count();
        $totalMou = DigitalArchive::where('category', 'dokumen_mou')->count();
        $totalReceipts = DigitalArchive::whereIn('category', ['nota_reimburse', 'nota_kas'])->count();

        $storage = $this->calculateStorageInfo();

        return [
            'total_files' => $totalFiles,
            'total_folders' => $totalFolders,
            'total_size_mb' => $storage['used_formatted'],
            'total_mou' => $totalMou,
            'total_receipts' => $totalReceipts,
            'total_base64_chars' => $storage['used_bytes'],
            'storage' => $storage,
        ];
    }

    /**
     * API: Update Konfigurasi Driver & Kuota Penyimpanan Arsip Digital
     */
    public function updateStorageConfig(Request $request)
    {
        $validated = $request->validate([
            'driver' => 'required|in:hosting,cloud,local',
            'quota_mb' => 'required|numeric|min:100|max:1048576',
        ]);

        SiteSetting::set('archive_storage_driver', $validated['driver'], 'archive');
        if ($validated['driver'] === 'hosting') {
            SiteSetting::set('archive_hosting_quota_mb', $validated['quota_mb'], 'archive');
        } elseif ($validated['driver'] === 'cloud') {
            SiteSetting::set('archive_cloud_quota_mb', $validated['quota_mb'], 'archive');
        } elseif ($validated['driver'] === 'local') {
            SiteSetting::set('archive_local_quota_mb', $validated['quota_mb'], 'archive');
        }

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi target & kuota penyimpanan berhasil diperbarui.',
            'stats' => $this->calculateStats(),
        ]);
    }

    /**
     * API: Operasi Massal Berkas & Folder (Bulk Delete / Bulk Move)
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,move',
            'file_ids' => 'nullable|array',
            'file_ids.*' => 'exists:digital_archives,id',
            'folder_ids' => 'nullable|array',
            'folder_ids.*' => 'exists:archive_folders,id',
            'target_folder_id' => 'nullable|exists:archive_folders,id',
        ]);

        $action = $validated['action'];
        $fileIds = $validated['file_ids'] ?? [];
        $folderIds = $validated['folder_ids'] ?? [];
        $targetFolderId = $validated['target_folder_id'] ?? null;

        $count = 0;
        if ($action === 'delete') {
            if (!empty($fileIds)) {
                $count += DigitalArchive::whereIn('id', $fileIds)->delete();
            }
            if (!empty($folderIds)) {
                foreach ($folderIds as $fid) {
                    $f = ArchiveFolder::find($fid);
                    if ($f) {
                        DigitalArchive::where('folder_id', $fid)->update(['folder_id' => $f->parent_id]);
                        $f->delete();
                        $count++;
                    }
                }
            }
            $msg = "{$count} item berhasil dihapus dari arsip.";
        } elseif ($action === 'move') {
            if (!empty($fileIds)) {
                $count += DigitalArchive::whereIn('id', $fileIds)->update(['folder_id' => $targetFolderId]);
            }
            $destName = $targetFolderId ? (ArchiveFolder::find($targetFolderId)->name ?? 'Folder') : 'Arsip Utama';
            $msg = "{$count} berkas berhasil dipindahkan ke {$destName}.";
        }

        return response()->json([
            'success' => true,
            'message' => $msg,
            'stats' => $this->calculateStats(),
        ]);
    }

    /**
     * Simpan Berkas Arsip Baru (Form Submit Standar)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'folder_id' => 'nullable|exists:archive_folders,id',
            'document_date' => 'nullable|date',
            'document_file' => 'required|file|mimes:jpeg,png,jpg,webp,pdf|max:15360',
            'notes' => 'nullable|string|max:1000',
        ]);

        $file = $request->file('document_file');
        $processed = $this->processUploadedFile($file);

        DigitalArchive::create([
            'archive_no' => DigitalArchive::generateNumber(),
            'folder_id' => $validated['folder_id'] ?? null,
            'title' => $validated['title'],
            'category' => $validated['category'],
            'uploader_name' => auth()->user()->name ?? 'Admin Keuangan',
            'document_date' => $validated['document_date'] ?? now()->toDateString(),
            'file_name' => $processed['file_name'],
            'file_type' => $processed['mime'],
            'file_size' => $processed['size_formatted'],
            'file_base64' => $processed['file_base64'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.digital-archives.index')
            ->with('success', 'Berkas arsip digital berhasil disimpan.');
    }

    /**
     * API: Ambil Data Konten Folder (Breadcrumbs, Subfolder, Berkas, Stats)
     */
    public function explorerData(Request $request)
    {
        $folderId = $request->query('folder_id');
        $search = $request->query('search');
        $category = $request->query('category');

        $currentFolder = null;
        $breadcrumbs = [
            ['id' => null, 'name' => 'Arsip Utama', 'icon' => 'hard-drive']
        ];

        if ($folderId) {
            $currentFolder = ArchiveFolder::find($folderId);
            if ($currentFolder) {
                $crumbs = $currentFolder->getBreadcrumbs();
                foreach ($crumbs as $c) {
                    $breadcrumbs[] = ['id' => $c['id'], 'name' => $c['name'], 'icon' => 'folder'];
                }
            }
        }

        // 1. Query Sub-Folders
        $folderQuery = ArchiveFolder::withCount(['children', 'archives']);
        if ($folderId) {
            $folderQuery->where('parent_id', $folderId);
        } else {
            $folderQuery->whereNull('parent_id');
        }

        if (!empty($search)) {
            $folderQuery->where('name', 'like', "%{$search}%");
        }
        $subFolders = $folderQuery->orderBy('name', 'asc')->get();

        // 2. Query Berkas dalam folder
        $fileQuery = DigitalArchive::with('folder');
        if (!empty($search)) {
            // Pencarian global jika mencari
            $fileQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%")
                  ->orWhere('archive_no', 'like', "%{$search}%")
                  ->orWhere('uploader_name', 'like', "%{$search}%");
            });
        } else {
            if ($folderId) {
                $fileQuery->where('folder_id', $folderId);
            } else {
                $fileQuery->whereNull('folder_id');
            }
        }

        if (!empty($category) && $category !== 'all') {
            $fileQuery->where('category', $category);
        }

        $files = $fileQuery->latest()->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'archive_no' => $item->archive_no,
                'title' => $item->title,
                'folder_id' => $item->folder_id,
                'category' => $item->category,
                'category_badge' => $item->category_badge,
                'file_name' => $item->file_name,
                'file_type' => $item->file_type,
                'file_size' => $item->file_size,
                'document_date' => $item->document_date ? $item->document_date->format('d M Y') : '-',
                'uploader_name' => $item->uploader_name,
                'is_image' => $item->isImage(),
                'file_base64' => $item->file_base64,
                'notes' => $item->notes,
                'created_at' => $item->created_at->format('d/m/Y H:i'),
            ];
        });

        // 3. Folder Tree untuk Sidebar
        $tree = ArchiveFolder::with(['children' => function ($q) {
            $q->withCount(['children', 'archives'])->orderBy('name', 'asc');
        }])
        ->whereNull('parent_id')
        ->withCount(['children', 'archives'])
        ->orderBy('name', 'asc')
        ->get();

        return response()->json([
            'success' => true,
            'current_folder_id' => $folderId ? (int)$folderId : null,
            'current_folder' => $currentFolder,
            'breadcrumbs' => $breadcrumbs,
            'folders' => $subFolders,
            'files' => $files,
            'tree' => $tree,
            'stats' => $this->calculateStats(),
        ]);
    }

    /**
     * API: Buat Folder Baru
     */
    public function createFolder(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'parent_id' => 'nullable|exists:archive_folders,id',
            'color' => 'nullable|string|max:50',
        ]);

        $folder = ArchiveFolder::create([
            'name' => trim($validated['name']),
            'parent_id' => $validated['parent_id'] ?? null,
            'color' => $validated['color'] ?? 'amber',
            'created_by' => auth()->user()->name ?? 'Admin',
        ]);

        return response()->json([
            'success' => true,
            'message' => "Folder \"{$folder->name}\" berhasil dibuat.",
            'folder' => $folder,
            'stats' => $this->calculateStats(),
        ]);
    }

    /**
     * API: Rename Folder
     */
    public function renameFolder(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
        ]);

        $folder = ArchiveFolder::findOrFail($id);
        $oldName = $folder->name;
        $folder->update(['name' => trim($validated['name'])]);

        return response()->json([
            'success' => true,
            'message' => "Folder \"{$oldName}\" diubah menjadi \"{$folder->name}\".",
            'folder' => $folder,
        ]);
    }

    /**
     * API: Hapus Folder
     */
    public function deleteFolder($id)
    {
        $folder = ArchiveFolder::findOrFail($id);
        $name = $folder->name;

        // Pindahkan berkas di dalam folder ini ke parent folder agar tidak hilang
        DigitalArchive::where('folder_id', $id)->update(['folder_id' => $folder->parent_id]);

        $folder->delete();

        return response()->json([
            'success' => true,
            'message' => "Folder \"{$name}\" berhasil dihapus.",
            'stats' => $this->calculateStats(),
        ]);
    }

    /**
     * API: Upload Berkas Drag & Drop / File Input Langsung ke Base64 (Tanpa Reload)
     */
    public function uploadAjax(Request $request)
    {
        try {
            if (DB::connection()->getDriverName() === 'mysql') {
                try { DB::statement('SET GLOBAL max_allowed_packet = 67108864'); } catch (\Throwable $e) {}
            }

            $folderId = $request->input('folder_id');
            if ($folderId === 'null' || empty($folderId)) {
                $folderId = null;
            }

            $category = $request->input('category', 'nota_reimburse');
            $title = $request->input('title');
            $notes = $request->input('notes');
            $docDate = $request->input('document_date', now()->toDateString());

            $createdArchives = [];

            // Kasus 1: Upload langsung via multipart files
            if ($request->hasFile('files') || $request->hasFile('file')) {
                $files = $request->file('files') ?: $request->file('file');
                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $file) {
                    $processed = $this->processUploadedFile($file);
                    $fileTitle = !empty($title) ? $title : pathinfo($processed['file_name'], PATHINFO_FILENAME);

                    $archive = DigitalArchive::create([
                        'archive_no' => DigitalArchive::generateNumber(),
                        'folder_id' => $folderId,
                        'title' => $fileTitle,
                        'category' => $category,
                        'uploader_name' => auth()->user()->name ?? 'Admin Keuangan',
                        'document_date' => $docDate,
                        'file_name' => $processed['file_name'],
                        'file_type' => $processed['mime'],
                        'file_size' => $processed['size_formatted'],
                        'file_base64' => $processed['file_base64'],
                        'notes' => $notes,
                    ]);

                    $createdArchives[] = $archive;
                }
            } elseif ($request->hasFile('document_file')) {
                $file = $request->file('document_file');
                $processed = $this->processUploadedFile($file);

                $archive = DigitalArchive::create([
                    'archive_no' => DigitalArchive::generateNumber(),
                    'folder_id' => $folderId,
                    'title' => $title ?: pathinfo($processed['file_name'], PATHINFO_FILENAME),
                    'category' => $category,
                    'uploader_name' => auth()->user()->name ?? 'Admin Keuangan',
                    'document_date' => $docDate,
                    'file_name' => $processed['file_name'],
                    'file_type' => $processed['mime'],
                    'file_size' => $processed['size_formatted'],
                    'file_base64' => $processed['file_base64'],
                    'notes' => $notes,
                ]);

                $createdArchives[] = $archive;
            } elseif ($request->filled('file_base64')) {
                // Kasus 2: Upload Base64 langsung dari client-side canvas / drag-drop reader
                $fileName = $request->input('file_name', 'berkas_arsip_' . time() . '.png');
                $base64 = $this->optimizeBase64String($request->input('file_base64'));

                $archive = DigitalArchive::create([
                    'archive_no' => DigitalArchive::generateNumber(),
                    'folder_id' => $folderId,
                    'title' => $title ?: pathinfo($fileName, PATHINFO_FILENAME),
                    'category' => $category,
                    'uploader_name' => auth()->user()->name ?? 'Admin Keuangan',
                    'document_date' => $docDate,
                    'file_name' => $fileName,
                    'file_type' => $request->input('file_type', 'image/png'),
                    'file_size' => round(strlen($base64) * 0.75 / 1024, 1) . ' KB',
                    'file_base64' => $base64,
                    'notes' => $notes,
                ]);

                $createdArchives[] = $archive;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada berkas yang diunggah.',
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => count($createdArchives) . ' berkas berhasil diunggah ke arsip digital.',
                'archive' => $createdArchives[0] ?? null,
                'archives' => $createdArchives,
                'stats' => $this->calculateStats(),
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Upload Ajax Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah berkas: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Rename Berkas
     */
    public function renameFile(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $archive = DigitalArchive::findOrFail($id);
        $archive->update(['title' => trim($validated['title'])]);

        return response()->json([
            'success' => true,
            'message' => "Nama dokumen berhasil diperbarui.",
            'archive' => $archive,
        ]);
    }

    /**
     * API: Pindahkan Berkas ke Folder Lain (Drag & Drop Move)
     */
    public function moveFile(Request $request, $id)
    {
        $targetFolderId = $request->input('target_folder_id');
        if ($targetFolderId === 'null' || empty($targetFolderId)) {
            $targetFolderId = null;
        }

        $archive = DigitalArchive::findOrFail($id);
        $archive->update(['folder_id' => $targetFolderId]);

        $destName = $targetFolderId ? (ArchiveFolder::find($targetFolderId)->name ?? 'Folder') : 'Arsip Utama';

        return response()->json([
            'success' => true,
            'message' => "Dokumen \"{$archive->title}\" berhasil dipindahkan ke {$destName}.",
            'archive' => $archive,
            'stats' => $this->calculateStats(),
        ]);
    }

    /**
     * API: Hapus Berkas via AJAX
     */
    public function deleteFileAjax($id)
    {
        $archive = DigitalArchive::findOrFail($id);
        $no = $archive->archive_no;
        $archive->delete();

        return response()->json([
            'success' => true,
            'message' => "Dokumen {$no} berhasil dihapus dari arsip.",
            'stats' => $this->calculateStats(),
        ]);
    }

    /**
     * API: Ambil Statistik Mini Dashboard Real-Time
     */
    public function stats()
    {
        return response()->json([
            'success' => true,
            'stats' => $this->calculateStats(),
        ]);
    }

    /**
     * API: 1-Click Simpan Nota / Bukti ke Arsip Digital
     */
    public function archiveReceipt(Request $request)
    {
        try {
            if (DB::connection()->getDriverName() === 'mysql') {
                try { DB::statement('SET GLOBAL max_allowed_packet = 67108864'); } catch (\Throwable $e) {}
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'file_base64' => 'required|string',
                'file_name' => 'nullable|string|max:255',
                'category' => 'nullable|string|max:60',
                'folder_name' => 'nullable|string|max:100',
                'reimbursement_id' => 'nullable|exists:reimbursements,id',
                'uploader_name' => 'nullable|string|max:150',
                'document_date' => 'nullable|date',
                'notes' => 'nullable|string|max:1000',
            ]);

            $folderName = $validated['folder_name'] ?? 'Nota & Kuitansi Keuangan';
            $folder = ArchiveFolder::firstOrCreate(
                ['name' => $folderName],
                ['color' => 'emerald', 'created_by' => 'Sistem Keuangan']
            );

            $base64 = $this->optimizeBase64String($validated['file_base64']);
            $mime = 'image/jpeg';
            if (str_starts_with($base64, 'data:')) {
                $header = explode(';base64,', $base64)[0];
                $mime = str_replace('data:', '', $header);
            }
            $ext = str_contains($mime, 'pdf') ? 'pdf' : (str_contains($mime, 'png') ? 'png' : 'jpg');
            $fileName = $validated['file_name'] ?? ('nota_' . time() . '.' . $ext);
            $rawLen = strlen($base64);
            $fileSize = round(($rawLen * 3 / 4) / 1024, 1) . ' KB';

            // Check if already archived by title and folder_id
            $existing = DigitalArchive::where('title', $validated['title'])
                ->where('folder_id', $folder->id)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => true,
                    'already_archived' => true,
                    'message' => 'Berkas ini sudah tersimpan di folder Arsip Digital (' . $folder->name . ').',
                    'archive' => $existing,
                    'archive_url' => route('admin.digital-archives.index', ['folder_id' => $folder->id]),
                ]);
            }

            $archive = DigitalArchive::create([
                'archive_no' => DigitalArchive::generateNumber(),
                'folder_id' => $folder->id,
                'title' => $validated['title'],
                'category' => $validated['category'] ?? 'nota_reimburse',
                'reimbursement_id' => $validated['reimbursement_id'] ?? null,
                'uploader_name' => $validated['uploader_name'] ?? (auth()->user()->name ?? 'Admin Keuangan'),
                'document_date' => $validated['document_date'] ?? now()->toDateString(),
                'file_name' => $fileName,
                'file_type' => $mime,
                'file_size' => $fileSize,
                'file_base64' => $base64,
                'notes' => $validated['notes'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'already_archived' => false,
                'message' => 'Nota fisik berhasil disimpan ke Arsip Digital (' . $folder->name . ')!',
                'archive' => $archive,
                'archive_url' => route('admin.digital-archives.index', ['folder_id' => $folder->id]),
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Archive Receipt Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengarsipkan nota: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download Berkas Arsip Digital Langsung
     */
    public function downloadFile($id)
    {
        $archive = DigitalArchive::findOrFail($id);
        $base64 = $archive->file_base64;
        if (empty($base64)) {
            return back()->with('error', 'Berkas arsip tidak ditemukan.');
        }

        // Jika tersimpan sebagai path storage publik (/storage/archives/...)
        if (str_starts_with($base64, '/storage/') || str_starts_with($base64, 'storage/')) {
            $relativePath = ltrim(str_replace(['/storage/', 'storage/'], '', $base64), '/');
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relativePath)) {
                return \Illuminate\Support\Facades\Storage::disk('public')->download($relativePath, $archive->file_name ?: basename($relativePath));
            }
        }

        if (str_contains($base64, ';base64,')) {
            [$header, $data] = explode(';base64,', $base64);
            $mime = str_replace('data:', '', $header);
        } else {
            $data = $base64;
            $mime = $archive->file_type ?: 'application/octet-stream';
        }

        $content = base64_decode($data);
        $filename = $archive->file_name ?: ($archive->archive_no . '.jpg');

        return response($content)
            ->header('Content-Type', $mime)
            ->header('Content-Disposition', 'attachment; filename="' . addslashes($filename) . '"');
    }

    /**
     * Memproses file yang diunggah: kompresi cerdas untuk gambar atau fallback aman ke disk storage jika file > 750KB
     */
    protected function processUploadedFile($file): array
    {
        $realPath = $file->getRealPath();
        $mime = $file->getMimeType() ?: 'application/octet-stream';
        $originalName = $file->getClientOriginalName();
        $sizeBytes = $file->getSize();

        // 1. Jika berkas merupakan gambar (JPEG, PNG, WEBP, JPG) dan GD aktif, lakukan kompresi cerdas
        if (extension_loaded('gd') && str_starts_with($mime, 'image/')) {
            $optimized = $this->compressImageForBase64($realPath, $mime);
            if ($optimized !== null) {
                $base64 = 'data:' . $optimized['mime'] . ';base64,' . base64_encode($optimized['data']);
                $len = strlen($optimized['data']);

                // Jika berkas hasil kompresi masih > 750KB (sangat jarang terjadi), simpan ke storage publik
                if ($len > 750000) {
                    $ext = str_contains($optimized['mime'], 'png') ? 'png' : 'jpg';
                    $storagePath = 'archives/' . date('Ym') . '/' . uniqid('arc_') . '.' . $ext;
                    \Illuminate\Support\Facades\Storage::disk('public')->put($storagePath, $optimized['data']);
                    return [
                        'file_base64' => '/storage/' . $storagePath,
                        'mime' => $optimized['mime'],
                        'size_formatted' => round($len / 1024, 1) . ' KB',
                        'file_name' => $originalName,
                    ];
                }

                return [
                    'file_base64' => $base64,
                    'mime' => $optimized['mime'],
                    'size_formatted' => round($len / 1024, 1) . ' KB',
                    'file_name' => $originalName,
                ];
            }
        }

        // 2. Berkas non-gambar (misal PDF) atau jika kompresi dilewati
        $data = file_get_contents($realPath);
        $len = strlen($data);

        // Jika ukuran berkas > 750KB, simpan ke disk public storage
        if ($len > 750000) {
            $ext = $file->getClientOriginalExtension() ?: (str_contains($mime, 'pdf') ? 'pdf' : 'bin');
            $storagePath = 'archives/' . date('Ym') . '/' . uniqid('arc_') . '.' . $ext;
            \Illuminate\Support\Facades\Storage::disk('public')->put($storagePath, $data);
            return [
                'file_base64' => '/storage/' . $storagePath,
                'mime' => $mime,
                'size_formatted' => round($len / 1024, 1) . ' KB',
                'file_name' => $originalName,
            ];
        }

        return [
            'file_base64' => 'data:' . $mime . ';base64,' . base64_encode($data),
            'mime' => $mime,
            'size_formatted' => round($len / 1024, 1) . ' KB',
            'file_name' => $originalName,
        ];
    }

    /**
     * Optimasi string Base64 gambar agar ukuran payload database ringkas (< 500KB)
     */
    protected function optimizeBase64String(string $base64): string
    {
        if (!str_starts_with($base64, 'data:image/')) {
            return $base64;
        }

        try {
            [$header, $encoded] = explode(';base64,', $base64);
            $mime = str_replace('data:', '', $header);
            $binary = base64_decode($encoded);

            // Jika ukuran biner sudah kecil (< 350KB), tidak perlu di-resize lagi
            if (strlen($binary) <= 358400) {
                return $base64;
            }

            if (!extension_loaded('gd')) {
                return $base64;
            }

            $img = @imagecreatefromstring($binary);
            if (!$img) {
                return $base64;
            }

            $width = imagesx($img);
            $height = imagesy($img);
            $maxDimension = 1600;

            $targetWidth = $width;
            $targetHeight = $height;

            if ($width > $maxDimension || $height > $maxDimension) {
                if ($width >= $height) {
                    $targetWidth = $maxDimension;
                    $targetHeight = (int) max(1, round(($height / $width) * $maxDimension));
                } else {
                    $targetHeight = $maxDimension;
                    $targetWidth = (int) max(1, round(($width / $height) * $maxDimension));
                }
            }

            $targetImg = imagecreatetruecolor($targetWidth, $targetHeight);
            imagecopyresampled($targetImg, $img, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

            ob_start();
            imagejpeg($targetImg, null, 82);
            $compressed = ob_get_clean();

            imagedestroy($img);
            imagedestroy($targetImg);

            if ($compressed && strlen($compressed) < strlen($binary)) {
                return 'data:image/jpeg;base64,' . base64_encode($compressed);
            }

            return $base64;
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Base64 optimization error: ' . $e->getMessage());
            return $base64;
        }
    }

    /**
     * Hapus Arsip Konvensional (Fallback)
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
