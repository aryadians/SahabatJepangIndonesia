@extends('admin.layouts.admin')

@section('title', 'Windows File Explorer - Arsip Digital')
@section('page_title', 'Arsip Digital & Dokumen Penting (Windows File Explorer)')

@section('content')
<div class="space-y-6" id="explorerApp">

    <!-- 1. Auto-Syncing Mini Dashboard KPI -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-sm flex items-center gap-3.5 group hover:border-blue-400 transition">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold group-hover:scale-105 transition">
                <i data-lucide="files" class="w-5 h-5"></i>
            </div>
            <div class="min-w-0">
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider truncate">Total Berkas</p>
                <h3 id="statTotalFiles" class="text-lg sm:text-xl font-black text-slate-900 mt-0.5">{{ number_format($stats['total_files']) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-sm flex items-center gap-3.5 group hover:border-amber-400 transition">
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold group-hover:scale-105 transition">
                <i data-lucide="folder" class="w-5 h-5"></i>
            </div>
            <div class="min-w-0">
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider truncate">Total Folder</p>
                <h3 id="statTotalFolders" class="text-lg sm:text-xl font-black text-amber-600 mt-0.5">{{ number_format($stats['total_folders']) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-sm flex items-center gap-3.5 group hover:border-emerald-400 transition">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold group-hover:scale-105 transition">
                <i data-lucide="receipt" class="w-5 h-5"></i>
            </div>
            <div class="min-w-0">
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider truncate">Nota Reimburse</p>
                <h3 id="statTotalReceipts" class="text-lg sm:text-xl font-black text-emerald-600 mt-0.5">{{ number_format($stats['total_receipts']) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-sm flex items-center gap-3.5 group hover:border-purple-400 transition">
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold group-hover:scale-105 transition">
                <i data-lucide="file-signature" class="w-5 h-5"></i>
            </div>
            <div class="min-w-0">
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider truncate">Naskah MoU</p>
                <h3 id="statTotalMou" class="text-lg sm:text-xl font-black text-purple-600 mt-0.5">{{ number_format($stats['total_mou']) }}</h3>
            </div>
        </div>

        <!-- 5. Status & Sisa Kapasitas Penyimpanan (Hosting / Cloud / Lokal) -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-sm flex flex-col justify-between group hover:border-japan-400 transition col-span-2 sm:col-span-1 relative overflow-hidden">
            <div class="flex items-start justify-between gap-2">
                <div class="flex items-center gap-3 min-w-0">
                    <div id="statDriverIconWrap" class="w-10 h-10 rounded-xl bg-japan-50 text-japan-600 flex items-center justify-center font-bold flex-shrink-0 group-hover:scale-105 transition">
                        <i id="statDriverIcon" data-lucide="{{ $stats['storage']['driver_icon'] ?? 'server' }}" class="w-5 h-5"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span id="statDriverBadge" class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                                {{ ($stats['storage']['driver'] ?? 'hosting') === 'cloud' ? 'Cloud S3' : (($stats['storage']['driver'] ?? 'hosting') === 'local' ? 'Lokal Disk' : 'Hosting Web') }}
                            </span>
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider truncate">Sisa Kuota</span>
                        </div>
                        <h3 id="statFreeStorage" class="text-base sm:text-lg font-black text-slate-900 mt-0.5 tracking-tight truncate" title="Sisa ruang penyimpanan yang dapat digunakan">
                            Sisa {{ $stats['storage']['free_formatted'] ?? '0 MB' }}
                        </h3>
                    </div>
                </div>
                <button 
                    type="button" 
                    onclick="openStorageConfigModal()" 
                    class="p-1.5 rounded-lg text-slate-400 hover:text-japan-600 hover:bg-japan-50 transition active:scale-95" 
                    title="Konfigurasi Driver Penyimpanan (Hosting, Cloud, atau Lokal)"
                >
                    <i data-lucide="settings-2" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Detail & Progress Bar -->
            <div class="mt-3 pt-2.5 border-t border-slate-100">
                <div class="flex items-center justify-between text-[11px] text-slate-500 font-medium">
                    <span id="statStorageDetail">Terpakai <b id="statTotalSize" class="text-slate-800 font-bold">{{ $stats['storage']['used_formatted'] ?? $stats['total_size_mb'] }}</b> dari {{ $stats['storage']['total_quota_formatted'] ?? '5 GB' }}</span>
                    <span id="statStoragePercent" class="font-black {{ ($stats['storage']['used_percentage'] ?? 0) > 85 ? 'text-red-500' : 'text-slate-700' }}">
                        {{ $stats['storage']['used_percentage'] ?? 0 }}%
                    </span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mt-1.5 overflow-hidden">
                    <div 
                        id="statStorageBar" 
                        class="h-full rounded-full transition-all duration-500 {{ ($stats['storage']['used_percentage'] ?? 0) > 90 ? 'bg-red-500' : (($stats['storage']['used_percentage'] ?? 0) > 75 ? 'bg-amber-500' : 'bg-japan-600') }}" 
                        style="width: {{ min(100, $stats['storage']['used_percentage'] ?? 0) }}%"
                    ></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Windows Explorer Window Container -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl overflow-hidden flex flex-col min-h-[680px]">

        <!-- Windows Ribbon / Toolbar Header -->
        <div class="bg-slate-50/90 border-b border-slate-200 px-4 py-3 flex flex-wrap items-center justify-between gap-3">
            <!-- Left Command Actions -->
            <div class="flex items-center gap-2 flex-wrap">
                <!-- New Folder Button -->
                <button 
                    type="button" 
                    onclick="promptCreateFolder()"
                    class="px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold shadow-sm hover:shadow transition flex items-center gap-1.5 active:scale-95"
                    title="Buat folder baru di direktori saat ini"
                >
                    <i data-lucide="folder-plus" class="w-4 h-4"></i>
                    <span>Folder Baru</span>
                </button>

                <!-- Upload File Button -->
                <label 
                    class="px-3.5 py-2 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-bold shadow-sm hover:shadow transition flex items-center gap-1.5 cursor-pointer active:scale-95"
                    title="Unggah berkas foto/PDF ke arsip digital Base64"
                >
                    <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                    <span>Unggah Berkas</span>
                    <input 
                        type="file" 
                        id="explorerFileInput" 
                        multiple 
                        accept="image/*,application/pdf" 
                        onchange="handleExplorerFilesUpload(this.files)" 
                        class="hidden"
                    >
                </label>

                <div class="h-6 w-px bg-slate-300 mx-1 hidden sm:block"></div>

                <!-- Category Quick Filter Dropdown -->
                <select 
                    id="categoryFilterSelect" 
                    onchange="onCategoryFilterChange(this.value)"
                    class="px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs font-semibold text-slate-700 focus:outline-none focus:border-japan-500 shadow-2xs"
                >
                    <option value="all">📁 Semua Kategori</option>
                    <option value="nota_reimburse">🧾 Nota & Kuitansi Reimburse</option>
                    <option value="dokumen_mou">📜 Naskah Kerjasama MoU</option>
                    <option value="kuitansi_hotel_tiket">✈️ Tiket & Hotel Dinas</option>
                    <option value="surat_tugas">📋 Surat Tugas Dinas</option>
                    <option value="legalitas_izin">🏛️ Legalitas Lembaga</option>
                    <option value="lainnya">📦 Berkas Lainnya</option>
                </select>

                <!-- Refresh Explorer Button -->
                <button 
                    type="button" 
                    onclick="loadExplorerData(currentFolderId)"
                    class="p-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-600 transition shadow-2xs"
                    title="Muat ulang tampilan folder"
                >
                    <i data-lucide="rotate-cw" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Right Controls: View Switch & Search -->
            <div class="flex items-center gap-2.5 flex-1 sm:flex-initial justify-end">
                <!-- Search Box -->
                <div class="relative min-w-[200px] sm:min-w-[240px] flex-1">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        id="explorerSearchInput" 
                        oninput="debounceSearch(this.value)"
                        placeholder="Cari file atau folder..." 
                        class="w-full pl-9 pr-3 py-1.5 rounded-xl bg-white border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-japan-500 shadow-2xs"
                    >
                </div>

                <!-- View Toggle: Grid vs List -->
                <div class="flex items-center bg-white border border-slate-200 rounded-xl p-0.5 shadow-2xs">
                    <button 
                        type="button" 
                        id="btnViewGrid" 
                        onclick="switchViewMode('grid')"
                        class="p-1.5 rounded-lg text-slate-700 bg-slate-100 hover:text-japan-600 transition"
                        title="Tampilan Ikon Besar / Grid"
                    >
                        <i data-lucide="layout-grid" class="w-4 h-4"></i>
                    </button>
                    <button 
                        type="button" 
                        id="btnViewList" 
                        onclick="switchViewMode('list')"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-japan-600 transition"
                        title="Tampilan Rincian / List"
                    >
                        <i data-lucide="list" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Windows Explorer Address Bar & Breadcrumbs -->
        <div class="bg-white border-b border-slate-200/90 px-4 py-2 flex items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-1.5 overflow-x-auto py-0.5 flex-1 select-none scrollbar-none" id="breadcrumbBar">
                <button 
                    type="button" 
                    onclick="loadExplorerData(null)"
                    class="px-2.5 py-1 rounded-lg hover:bg-slate-100 text-slate-700 font-bold flex items-center gap-1.5 transition flex-shrink-0"
                >
                    <i data-lucide="hard-drive" class="w-3.5 h-3.5 text-blue-600"></i>
                    <span>Arsip Utama</span>
                </button>
            </div>

            <!-- Item Counter Status in Current Directory -->
            <div class="text-[11px] text-slate-400 font-medium flex-shrink-0 flex items-center gap-1">
                <span id="currentFolderStats">0 item</span>
            </div>
        </div>

        <!-- Two-Pane Layout: Left Directory Tree & Right Content Canvas -->
        <div class="flex-1 grid grid-cols-1 md:grid-cols-12 overflow-hidden min-h-[520px]">
            
            <!-- Left Pane: Quick Access & Folders Tree -->
            <div class="md:col-span-3 border-r border-slate-200 bg-slate-50/50 p-4 space-y-4 overflow-y-auto max-h-[640px]">
                
                <!-- Quick Access Navigation -->
                <div class="space-y-1">
                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-400 px-2">Akses Cepat</p>
                    
                    <button 
                        type="button" 
                        onclick="loadExplorerData(null); onCategoryFilterChange('all');"
                        class="w-full px-2.5 py-2 rounded-xl text-left text-xs font-bold text-slate-700 hover:bg-white hover:shadow-2xs transition flex items-center justify-between group"
                    >
                        <span class="flex items-center gap-2">
                            <i data-lucide="hard-drive" class="w-4 h-4 text-blue-600"></i>
                            <span>Semua Berkas (Root)</span>
                        </span>
                        <span id="badgeRootCount" class="text-[10px] text-slate-400 font-semibold">...</span>
                    </button>

                    <button 
                        type="button" 
                        onclick="onCategoryFilterChange('nota_reimburse')"
                        class="w-full px-2.5 py-1.5 rounded-xl text-left text-xs font-semibold text-slate-600 hover:bg-white hover:text-emerald-700 transition flex items-center gap-2"
                    >
                        <i data-lucide="receipt" class="w-4 h-4 text-emerald-600"></i>
                        <span>Nota &amp; Kuitansi SPJ</span>
                    </button>

                    <button 
                        type="button" 
                        onclick="onCategoryFilterChange('dokumen_mou')"
                        class="w-full px-2.5 py-1.5 rounded-xl text-left text-xs font-semibold text-slate-600 hover:bg-white hover:text-purple-700 transition flex items-center gap-2"
                    >
                        <i data-lucide="file-signature" class="w-4 h-4 text-purple-600"></i>
                        <span>Naskah MoU Mitra</span>
                    </button>

                    <button 
                        type="button" 
                        onclick="onCategoryFilterChange('kuitansi_hotel_tiket')"
                        class="w-full px-2.5 py-1.5 rounded-xl text-left text-xs font-semibold text-slate-600 hover:bg-white hover:text-blue-700 transition flex items-center gap-2"
                    >
                        <i data-lucide="plane" class="w-4 h-4 text-blue-600"></i>
                        <span>Tiket &amp; Hotel Dinas</span>
                    </button>

                    <button 
                        type="button" 
                        onclick="onCategoryFilterChange('surat_tugas')"
                        class="w-full px-2.5 py-1.5 rounded-xl text-left text-xs font-semibold text-slate-600 hover:bg-white hover:text-amber-700 transition flex items-center gap-2"
                    >
                        <i data-lucide="file-text" class="w-4 h-4 text-amber-600"></i>
                        <span>Surat Tugas Resmi</span>
                    </button>
                </div>

                <div class="border-t border-slate-200/80 pt-3 space-y-1">
                    <div class="flex items-center justify-between px-2">
                        <p class="text-[10px] font-black uppercase tracking-wider text-slate-400">Pohon Folder</p>
                        <button type="button" onclick="promptCreateFolder()" class="text-amber-600 hover:text-amber-700 text-xs" title="Tambah Folder">+</button>
                    </div>
                    
                    <div id="folderTreeList" class="space-y-0.5 pt-1 text-xs">
                        <!-- Populated by JS -->
                        <div class="text-[11px] text-slate-400 p-2 italic">Memuat folder...</div>
                    </div>
                </div>

            </div>

            @if(isset($recentArchives) && count($recentArchives) > 0)
                <div class="sr-only" aria-hidden="true" id="ssrRecentArchives">
                    @foreach($recentArchives as $rec)
                        <div>
                            <span>{{ $rec->title }}</span>
                            <span>{{ $rec->file_name }}</span>
                            <span>{{ $rec->archive_no }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Right Pane: File Canvas & Interactive Drop Zone -->
            <div 
                id="explorerCanvas" 
                class="md:col-span-9 p-5 overflow-y-auto max-h-[640px] relative transition-all duration-200"
                ondragover="handleCanvasDragOver(event)"
                ondragleave="handleCanvasDragLeave(event)"
                ondrop="handleCanvasDrop(event)"
            >
                <!-- Drag-over Drop Overlay -->
                <div 
                    id="canvasDropOverlay" 
                    class="absolute inset-0 bg-blue-50/90 border-2 border-dashed border-blue-400 rounded-2xl m-3 flex flex-col items-center justify-center pointer-events-none hidden z-30 backdrop-blur-2xs transition-all"
                >
                    <div class="w-16 h-16 rounded-2xl bg-blue-500 text-white flex items-center justify-center shadow-lg animate-bounce">
                        <i data-lucide="arrow-down-to-line" class="w-8 h-8"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-base mt-3">Lepaskan Berkas di Sini</h4>
                    <p class="text-xs text-slate-500 mt-1">Berkas otomatis dikonversi ke Base64 dan disimpan ke folder ini</p>
                </div>

                <!-- Empty State -->
                <div id="explorerEmptyState" class="hidden flex-col items-center justify-center py-16 text-center space-y-3">
                    <div class="w-16 h-16 rounded-3xl bg-slate-100 border border-slate-200 text-slate-400 flex items-center justify-center">
                        <i data-lucide="folder-open" class="w-8 h-8 opacity-60"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-700 text-sm">Folder Ini Masih Kosong</h4>
                        <p class="text-xs text-slate-400 max-w-sm mt-1">Tarik dan lepaskan berkas nota, scan MoU, atau kuitansi langsung ke area ini, atau klik tombol "Unggah Berkas".</p>
                    </div>
                    <label class="px-4 py-2 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-bold shadow-md cursor-pointer transition">
                        <span>Pilih Berkas Sekarang</span>
                        <input type="file" multiple accept="image/*,application/pdf" onchange="handleExplorerFilesUpload(this.files)" class="hidden">
                    </label>
                </div>

                <!-- Content Container: Folders & Files -->
                <div id="explorerContentArea" class="space-y-6">
                    
                    <!-- Sub-Folders Section -->
                    <div id="foldersContainerSection" class="space-y-2.5">
                        <div class="flex items-center justify-between text-xs text-slate-400 font-bold">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="folder" class="w-3.5 h-3.5 text-amber-500"></i>
                                <span>Folder (<span id="foldersCountBadge">0</span>)</span>
                            </span>
                        </div>
                        <div id="foldersGrid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- Files Section -->
                    <div id="filesContainerSection" class="space-y-2.5 pt-2">
                        <div class="flex items-center justify-between text-xs text-slate-400 font-bold">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="file-text" class="w-3.5 h-3.5 text-blue-500"></i>
                                <span>Dokumen &amp; Berkas (<span id="filesCountBadge">0</span>)</span>
                            </span>
                        </div>
                        
                        <!-- Grid View Container -->
                        <div id="filesGrid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                            <!-- Populated by JS -->
                        </div>

                        <!-- List View Container (Hidden by default) -->
                        <div id="filesList" class="hidden bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-black uppercase text-slate-400">
                                        <th class="p-3 pl-4">Nama Dokumen</th>
                                        <th class="p-3">Kategori</th>
                                        <th class="p-3">Tanggal</th>
                                        <th class="p-3">Ukuran</th>
                                        <th class="p-3 text-right pr-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="filesListBody" class="divide-y divide-slate-100">
                                    <!-- Populated by JS -->
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Windows Explorer Status Bar -->
        <div class="bg-slate-100/90 border-t border-slate-200/80 px-4 py-2 flex items-center justify-between text-[11px] text-slate-500 font-medium select-none">
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span id="statusBarState">File Explorer Siap</span>
                </span>
                <span class="text-slate-300">|</span>
                <span id="statusBarItems">0 item ditampilkan</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-slate-400 font-mono">Format: Base64 LONGTEXT</span>
                <span class="text-slate-300">|</span>
                <span class="text-slate-500 font-semibold">Zero-Migration-Loss Ready ✅</span>
            </div>
        </div>

    </div>

</div>

<!-- Lightbox Zoom & Document Preview Modal -->
<div id="explorerPreviewModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-hidden shadow-2xl flex flex-col">
        <!-- Header -->
        <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0 pr-4">
                <div id="previewModalIcon" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 font-bold">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                </div>
                <div class="min-w-0">
                    <h3 id="previewModalTitle" class="text-sm sm:text-base font-extrabold text-slate-900 truncate">Preview Dokumen</h3>
                    <p id="previewModalSubtitle" class="text-[11px] text-slate-400 mt-0.5">DOC-SJI/...</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button 
                    type="button" 
                    id="previewPrintBtn" 
                    onclick="printCurrentPreview()"
                    class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition"
                    title="Cetak Berkas"
                >
                    <i data-lucide="printer" class="w-4 h-4"></i>
                </button>
                <a 
                    id="previewDownloadBtn" 
                    href="#" 
                    download="arsip_dokumen.jpg"
                    class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition"
                    title="Unduh Berkas Asli"
                >
                    <i data-lucide="download" class="w-4 h-4"></i>
                </a>
                <button 
                    type="button" 
                    onclick="closeExplorerPreview()"
                    class="p-2 rounded-xl bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-400 transition"
                    title="Tutup"
                >
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- Canvas Body -->
        <div class="flex-1 p-4 bg-slate-900 overflow-auto flex items-center justify-center min-h-[360px] max-h-[60vh] relative">
            <div id="previewMediaContainer" class="max-w-full max-h-full flex items-center justify-center">
                <!-- Image or Iframe PDF populated dynamically -->
            </div>
        </div>

        <!-- Footer Info -->
        <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span id="previewModalMeta">Format: Base64</span>
            <button 
                type="button" 
                onclick="closeExplorerPreview()" 
                class="px-4 py-1.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold transition"
            >
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Move File Modal -->
<div id="moveFileModal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
            <h3 class="font-extrabold text-slate-900 text-base flex items-center gap-2">
                <i data-lucide="folder-input" class="w-5 h-5 text-amber-500"></i>
                <span>Pindahkan Berkas</span>
            </h3>
            <button type="button" onclick="document.getElementById('moveFileModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">&times;</button>
        </div>
        <p class="text-xs text-slate-500">Pilih folder tujuan untuk berkas <strong id="moveFileTitleName" class="text-slate-800"></strong>:</p>
        <select id="moveFileFolderSelect" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-500">
            <option value="">📁 Arsip Utama (Root)</option>
            <!-- Populated by JS -->
        </select>
        <div class="flex items-center justify-end gap-2 pt-2">
            <button type="button" onclick="document.getElementById('moveFileModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold">Batal</button>
            <button type="button" id="confirmMoveBtn" class="px-4 py-2 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-bold">Pindahkan</button>
        </div>
    </div>
</div>

<!-- Storage Configuration Modal (Hosting / Cloud / Lokal) -->
<div id="storageConfigModal" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-5 shadow-2xl border border-slate-100 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-japan-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="hard-drive-download" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Target & Kuota Penyimpanan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Pilih acuan penyimpanan: Hosting, Cloud, atau Lokal Server</p>
                </div>
            </div>
            <button type="button" onclick="closeStorageConfigModal()" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form id="storageConfigForm" onsubmit="handleStorageConfigSubmit(event)" class="space-y-4">
            <!-- Driver Selection Cards -->
            <div class="space-y-2.5">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500">Pilih Target Acuan Penyimpanan</label>
                
                <div class="grid grid-cols-1 gap-2.5">
                    <!-- Option 1: Hosting Web (cPanel/VPS) -->
                    <label class="flex items-start gap-3 p-3.5 rounded-2xl border-2 border-slate-200 cursor-pointer transition has-checked:border-japan-600 has-checked:bg-japan-50/40 hover:border-slate-300">
                        <input type="radio" name="storage_driver" value="hosting" class="mt-1 accent-japan-600" {{ ($stats['storage']['driver'] ?? 'hosting') === 'hosting' ? 'checked' : '' }} onchange="onDriverRadioChange(this.value)">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-extrabold text-slate-900 flex items-center gap-1.5">
                                    <i data-lucide="server" class="w-3.5 h-3.5 text-japan-600"></i>
                                    <span>Hosting Server Web (cPanel / VPS)</span>
                                </span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase">Shared Quota</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                Mengacu pada kuota paket hosting atau shared disk cPanel tempat website berjalan.
                            </p>
                        </div>
                    </label>

                    <!-- Option 2: Cloud Object Storage -->
                    <label class="flex items-start gap-3 p-3.5 rounded-2xl border-2 border-slate-200 cursor-pointer transition has-checked:border-blue-600 has-checked:bg-blue-50/40 hover:border-slate-300">
                        <input type="radio" name="storage_driver" value="cloud" class="mt-1 accent-blue-600" {{ ($stats['storage']['driver'] ?? '') === 'cloud' ? 'checked' : '' }} onchange="onDriverRadioChange(this.value)">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-extrabold text-slate-900 flex items-center gap-1.5">
                                    <i data-lucide="cloud" class="w-3.5 h-3.5 text-blue-600"></i>
                                    <span>Cloud Object Storage (S3 / Wasabi / GCS)</span>
                                </span>
                                <span class="text-[10px] font-bold text-blue-500 uppercase">Cloud Tier</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                Mengacu pada batas kuota bucket cloud storage eksternal (AWS S3, Google Cloud, Cloudflare R2).
                            </p>
                        </div>
                    </label>

                    <!-- Option 3: Lokal Server Disk -->
                    <label class="flex items-start gap-3 p-3.5 rounded-2xl border-2 border-slate-200 cursor-pointer transition has-checked:border-emerald-600 has-checked:bg-emerald-50/40 hover:border-slate-300">
                        <input type="radio" name="storage_driver" value="local" class="mt-1 accent-emerald-600" {{ ($stats['storage']['driver'] ?? '') === 'local' ? 'checked' : '' }} onchange="onDriverRadioChange(this.value)">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-extrabold text-slate-900 flex items-center gap-1.5">
                                    <i data-lucide="hard-drive" class="w-3.5 h-3.5 text-emerald-600"></i>
                                    <span>Penyimpanan Lokal Disk Server</span>
                                </span>
                                <span class="text-[10px] font-bold text-emerald-600 uppercase">Disk Fisik</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                Membaca ruang kosong hard disk / SSD fisik server langsung secara otomatis.
                            </p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Quota Limit Input & Quick Presets -->
            <div id="quotaInputWrapper" class="space-y-2 pt-2 border-t border-slate-100">
                <div class="flex items-center justify-between">
                    <label for="storageQuotaMb" class="text-xs font-black uppercase tracking-wider text-slate-600">Batas Kuota Kapasitas (MB)</label>
                    <span id="quotaHumanPreview" class="text-xs font-bold text-japan-600">5.00 GB</span>
                </div>
                <div class="relative">
                    <input 
                        type="number" 
                        id="storageQuotaMb" 
                        name="quota_mb" 
                        min="100" 
                        max="1048576" 
                        step="100"
                        value="{{ round(($stats['storage']['total_quota_bytes'] ?? 5368709120) / (1024 * 1024)) }}" 
                        oninput="previewQuotaGB(this.value)"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-500"
                        required
                    >
                    <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">MB</span>
                </div>

                <!-- Quick Presets -->
                <div class="flex items-center gap-1.5 flex-wrap pt-1">
                    <span class="text-[10px] font-semibold text-slate-400">Pilihan Cepat:</span>
                    <button type="button" onclick="setQuotaPreset(1024)" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-[11px] font-bold text-slate-700 transition">1 GB</button>
                    <button type="button" onclick="setQuotaPreset(2048)" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-[11px] font-bold text-slate-700 transition">2 GB</button>
                    <button type="button" onclick="setQuotaPreset(5120)" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-[11px] font-bold text-slate-700 transition">5 GB</button>
                    <button type="button" onclick="setQuotaPreset(10240)" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-[11px] font-bold text-slate-700 transition">10 GB</button>
                    <button type="button" onclick="setQuotaPreset(20480)" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-[11px] font-bold text-slate-700 transition">20 GB</button>
                    <button type="button" onclick="setQuotaPreset(51200)" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-[11px] font-bold text-slate-700 transition">50 GB</button>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button 
                    type="button" 
                    onclick="closeStorageConfigModal()" 
                    class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition"
                >
                    Batal
                </button>
                <button 
                    type="submit" 
                    id="saveStorageConfigBtn"
                    class="px-4 py-2 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-bold shadow-md transition flex items-center gap-1.5 active:scale-95"
                >
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Terapkan Konfigurasi</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    /**
     * Windows File Explorer SPA Engine (Vanilla JavaScript, 0 Page Reloads)
     */
    let currentFolderId = null;
    let currentCategory = 'all';
    let currentSearchTerm = '';
    let currentViewMode = 'grid'; // 'grid' or 'list'
    let currentData = { folders: [], files: [], tree: [], stats: {} };
    let searchDebounceTimeout = null;

    // 1. Load Folder Data via AJAX
    function loadExplorerData(folderId = null) {
        currentFolderId = folderId;
        const statusEl = document.getElementById('statusBarState');
        if (statusEl) statusEl.textContent = 'Memuat direktori...';

        const url = new URL('{{ route('admin.digital-archives.explorer.data') }}', window.location.origin);
        if (folderId) url.searchParams.set('folder_id', folderId);
        if (currentCategory && currentCategory !== 'all') url.searchParams.set('category', currentCategory);
        if (currentSearchTerm) url.searchParams.set('search', currentSearchTerm);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (!res.success) return;
            currentData = res;
            renderBreadcrumbs(res.breadcrumbs);
            renderFolderTree(res.tree, folderId);
            renderContent(res.folders, res.files);
            updateMiniDashboard(res.stats);
            if (statusEl) statusEl.textContent = 'File Explorer Siap';
        })
        .catch(err => {
            console.error('Error loading explorer:', err);
            if (statusEl) statusEl.textContent = 'Gagal memuat berkas';
        });
    }

    // 2. Render Breadcrumbs
    function renderBreadcrumbs(crumbs) {
        const bar = document.getElementById('breadcrumbBar');
        if (!bar) return;
        bar.innerHTML = '';

        crumbs.forEach((crumb, index) => {
            const isLast = index === crumbs.length - 1;
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = `px-2 py-1 rounded-lg text-xs font-bold flex items-center gap-1.5 transition flex-shrink-0 ${
                isLast ? 'bg-slate-100 text-slate-900' : 'hover:bg-slate-100 text-slate-600'
            }`;
            btn.innerHTML = `
                <i data-lucide="${crumb.id ? 'folder' : 'hard-drive'}" class="w-3.5 h-3.5 ${crumb.id ? 'text-amber-500' : 'text-blue-600'}"></i>
                <span>${crumb.name}</span>
            `;
            btn.onclick = () => loadExplorerData(crumb.id);
            bar.appendChild(btn);

            if (!isLast) {
                const sep = document.createElement('span');
                sep.className = 'text-slate-300 font-mono text-xs px-0.5';
                sep.textContent = '>';
                bar.appendChild(sep);
            }
        });

        if (window.lucide) lucide.createIcons();
    }

    // 3. Render Left Pane Folder Tree
    function renderFolderTree(tree, activeId) {
        const list = document.getElementById('folderTreeList');
        if (!list) return;
        list.innerHTML = '';

        if (!tree || tree.length === 0) {
            list.innerHTML = '<div class="text-[11px] text-slate-400 p-2 italic">Belum ada folder</div>';
            return;
        }

        tree.forEach(f => {
            const isActive = activeId === f.id;
            const item = document.createElement('div');
            item.className = 'space-y-0.5';
            item.innerHTML = `
                <button 
                    type="button" 
                    onclick="loadExplorerData(${f.id})"
                    class="w-full px-2.5 py-1.5 rounded-xl text-left text-xs font-bold flex items-center justify-between transition ${
                        isActive ? 'bg-amber-100/70 text-amber-900 shadow-2xs font-extrabold' : 'text-slate-700 hover:bg-white hover:text-amber-700'
                    }"
                >
                    <span class="flex items-center gap-2 truncate">
                        <i data-lucide="folder" class="w-3.5 h-3.5 text-amber-500 flex-shrink-0"></i>
                        <span class="truncate">${f.name}</span>
                    </span>
                    <span class="text-[10px] text-slate-400 font-semibold">${f.archives_count || 0}</span>
                </button>
            `;
            list.appendChild(item);
        });

        if (window.lucide) lucide.createIcons();
    }

    // 4. Render Main Content Canvas (Folders & Files)
    function renderContent(folders, files) {
        const emptyState = document.getElementById('explorerEmptyState');
        const contentArea = document.getElementById('explorerContentArea');
        const foldersSection = document.getElementById('foldersContainerSection');
        const foldersGrid = document.getElementById('foldersGrid');
        const filesGrid = document.getElementById('filesGrid');
        const filesListBody = document.getElementById('filesListBody');
        const foldersBadge = document.getElementById('foldersCountBadge');
        const filesBadge = document.getElementById('filesCountBadge');
        const folderStats = document.getElementById('currentFolderStats');
        const statusItems = document.getElementById('statusBarItems');

        const totalItems = folders.length + files.length;
        if (folderStats) folderStats.textContent = `${totalItems} item (${folders.length} folder, ${files.length} file)`;
        if (statusItems) statusItems.textContent = `${totalItems} item`;

        if (totalItems === 0) {
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
            contentArea.classList.add('hidden');
            return;
        }

        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
        contentArea.classList.remove('hidden');

        // Render Folders
        if (foldersBadge) foldersBadge.textContent = folders.length;
        if (folders.length === 0) {
            foldersSection.classList.add('hidden');
        } else {
            foldersSection.classList.remove('hidden');
            foldersGrid.innerHTML = '';
            folders.forEach(f => {
                const card = document.createElement('div');
                card.className = 'p-3.5 rounded-2xl bg-amber-50/50 hover:bg-amber-100/70 border border-amber-200/80 transition cursor-pointer flex items-center justify-between group shadow-2xs hover:shadow hover:-translate-y-0.5 select-none relative';
                card.setAttribute('ondragover', 'handleFolderDragOver(event)');
                card.setAttribute('ondragleave', 'handleFolderDragLeave(event)');
                card.setAttribute('ondrop', `handleFolderDrop(event, ${f.id})`);
                
                card.innerHTML = `
                    <div class="flex items-center gap-2.5 min-w-0 flex-1" onclick="loadExplorerData(${f.id})">
                        <div class="w-9 h-9 rounded-xl bg-amber-400 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                            <i data-lucide="folder" class="w-5 h-5 fill-white/80"></i>
                        </div>
                        <div class="min-w-0">
                            <h5 class="text-xs font-black text-slate-800 truncate group-hover:text-amber-900">${f.name}</h5>
                            <p class="text-[10px] text-slate-500 font-medium">${f.archives_count || 0} berkas</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition flex-shrink-0">
                        <button type="button" onclick="event.stopPropagation(); promptRenameFolder(${f.id}, '${addslashes(f.name)}')" class="p-1 text-slate-400 hover:text-amber-700" title="Ganti Nama">
                            <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                        </button>
                        <button type="button" onclick="event.stopPropagation(); confirmDeleteFolder(${f.id}, '${addslashes(f.name)}')" class="p-1 text-slate-400 hover:text-rose-600" title="Hapus Folder">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                `;
                foldersGrid.appendChild(card);
            });
        }

        // Render Files
        if (filesBadge) filesBadge.textContent = files.length;
        filesGrid.innerHTML = '';
        filesListBody.innerHTML = '';

        files.forEach(file => {
            // 1. Grid Card View
            const card = document.createElement('div');
            card.className = 'bg-white rounded-2xl border border-slate-200/90 hover:border-blue-400 shadow-sm hover:shadow-md transition flex flex-col justify-between overflow-hidden group cursor-pointer relative';
            card.draggable = true;
            card.ondragstart = (e) => handleFileDragStart(e, file.id, file.title);
            card.onclick = () => openExplorerPreview(file);

            const isImg = file.is_image;
            const thumbHtml = isImg ? `
                <div class="w-full h-32 bg-slate-100 overflow-hidden relative flex items-center justify-center">
                    <img src="${file.file_base64}" alt="${file.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <span class="absolute top-2 right-2 px-1.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-slate-900/80 text-white backdrop-blur-xs">
                        ${file.file_size}
                    </span>
                </div>
            ` : `
                <div class="w-full h-32 bg-gradient-to-br from-slate-50 to-slate-100 flex flex-col items-center justify-center p-3 relative">
                    <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center shadow-xs">
                        <i data-lucide="file-text" class="w-6 h-6"></i>
                    </div>
                    <span class="text-[10px] font-bold text-slate-500 uppercase mt-2">${file.file_type ? file.file_type.split('/')[1] : 'PDF'}</span>
                    <span class="absolute top-2 right-2 px-1.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-slate-900/80 text-white">
                        ${file.file_size}
                    </span>
                </div>
            `;

            card.innerHTML = `
                ${thumbHtml}
                <div class="p-3.5 space-y-2 flex-1 flex flex-col justify-between">
                    <div>
                        <span class="inline-block px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider ${file.category_badge ? file.category_badge.bg : 'bg-slate-100 text-slate-700'}">
                            ${file.category_badge ? file.category_badge.label : file.category}
                        </span>
                        <h4 class="font-bold text-slate-900 text-xs mt-1.5 line-clamp-2 leading-snug group-hover:text-blue-600 transition" title="${file.title}">
                            ${file.title}
                        </h4>
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-400">
                        <span>${file.document_date}</span>
                        <div class="flex items-center gap-1.5" onclick="event.stopPropagation()">
                            <button type="button" onclick="promptRenameFile(${file.id}, '${addslashes(file.title)}')" class="p-1 hover:text-blue-600" title="Ganti Judul">
                                <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                            </button>
                            <button type="button" onclick="openMoveModal(${file.id}, '${addslashes(file.title)}')" class="p-1 hover:text-amber-600" title="Pindah Folder">
                                <i data-lucide="folder-input" class="w-3.5 h-3.5"></i>
                            </button>
                            <button type="button" onclick="confirmDeleteFile(${file.id}, '${addslashes(file.title)}')" class="p-1 hover:text-rose-600" title="Hapus Berkas">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            filesGrid.appendChild(card);

            // 2. List Row View
            const row = document.createElement('tr');
            row.className = 'hover:bg-blue-50/40 cursor-pointer transition';
            row.onclick = () => openExplorerPreview(file);
            row.innerHTML = `
                <td class="p-3 pl-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg ${isImg ? 'bg-blue-100 text-blue-600' : 'bg-rose-100 text-rose-600'} flex items-center justify-center flex-shrink-0">
                            <i data-lucide="${isImg ? 'image' : 'file-text'}" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block truncate max-w-xs sm:max-w-md">${file.title}</span>
                            <span class="text-[10px] text-slate-400 font-mono">${file.archive_no} • ${file.file_name}</span>
                        </div>
                    </div>
                </td>
                <td class="p-3">
                    <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider ${file.category_badge ? file.category_badge.bg : 'bg-slate-100 text-slate-700'}">
                        ${file.category_badge ? file.category_badge.label : file.category}
                    </span>
                </td>
                <td class="p-3 text-slate-500 font-medium">${file.document_date}</td>
                <td class="p-3 text-slate-500 font-mono">${file.file_size}</td>
                <td class="p-3 pr-4 text-right" onclick="event.stopPropagation()">
                    <div class="inline-flex items-center gap-1">
                        <button type="button" onclick="promptRenameFile(${file.id}, '${addslashes(file.title)}')" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-blue-600" title="Ganti Judul">
                            <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                        </button>
                        <button type="button" onclick="openMoveModal(${file.id}, '${addslashes(file.title)}')" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-amber-600" title="Pindah Folder">
                            <i data-lucide="folder-input" class="w-3.5 h-3.5"></i>
                        </button>
                        <button type="button" onclick="confirmDeleteFile(${file.id}, '${addslashes(file.title)}')" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-rose-600" title="Hapus Berkas">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                </td>
            `;
            filesListBody.appendChild(row);
        });

        if (window.lucide) lucide.createIcons();
    }

    // 5. Update Mini Dashboard KPI Elements
    function updateMiniDashboard(stats) {
        if (!stats) return;
        const setVal = (id, val) => {
            const el = document.getElementById(id);
            if (el && val !== undefined) el.textContent = typeof val === 'number' ? Number(val).toLocaleString('id-ID') : val;
        };
        setVal('statTotalFiles', stats.total_files);
        setVal('statTotalFolders', stats.total_folders);
        setVal('statTotalReceipts', stats.total_receipts);
        setVal('statTotalMou', stats.total_mou);
        setVal('statTotalSize', stats.total_size_mb);
        setVal('badgeRootCount', stats.total_files);
    }

    // 6. View Switch: Grid vs List
    function switchViewMode(mode) {
        currentViewMode = mode;
        const gridEl = document.getElementById('filesGrid');
        const listEl = document.getElementById('filesList');
        const btnGrid = document.getElementById('btnViewGrid');
        const btnList = document.getElementById('btnViewList');

        if (mode === 'grid') {
            gridEl.classList.remove('hidden');
            listEl.classList.add('hidden');
            btnGrid.classList.add('bg-slate-100', 'text-slate-700');
            btnList.classList.remove('bg-slate-100', 'text-slate-700');
            btnList.classList.add('text-slate-400');
        } else {
            gridEl.classList.add('hidden');
            listEl.classList.remove('hidden');
            btnList.classList.add('bg-slate-100', 'text-slate-700');
            btnGrid.classList.remove('bg-slate-100', 'text-slate-700');
            btnGrid.classList.add('text-slate-400');
        }
    }

    // 7. Search & Filter Handlers
    function debounceSearch(val) {
        clearTimeout(searchDebounceTimeout);
        searchDebounceTimeout = setTimeout(() => {
            currentSearchTerm = val.trim();
            loadExplorerData(currentFolderId);
        }, 300);
    }

    function onCategoryFilterChange(val) {
        currentCategory = val;
        const sel = document.getElementById('categoryFilterSelect');
        if (sel) sel.value = val;
        loadExplorerData(currentFolderId);
    }

    // 8. Create Folder (AJAX)
    function promptCreateFolder() {
        Swal.fire({
            title: 'Buat Folder Baru',
            text: 'Masukkan nama folder direktori arsip:',
            input: 'text',
            inputPlaceholder: 'Misal: Nota MoU Bandung 2026',
            showCancelButton: true,
            confirmButtonText: 'Buat Folder',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#F59E0B',
            inputValidator: (val) => {
                if (!val || !val.trim()) return 'Nama folder tidak boleh kosong!';
            }
        }).then(res => {
            if (res.isConfirmed && res.value) {
                fetch('{{ route('admin.digital-archives.folder.create') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        name: res.value.trim(),
                        parent_id: currentFolderId
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 1500, showConfirmButton: false });
                        loadExplorerData(currentFolderId);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Terjadi kesalahan.' });
                    }
                });
            }
        });
    }

    // 9. Rename Folder (AJAX)
    function promptRenameFolder(id, oldName) {
        Swal.fire({
            title: 'Ganti Nama Folder',
            input: 'text',
            inputValue: oldName,
            showCancelButton: true,
            confirmButtonText: 'Simpan Nama',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#F59E0B',
            inputValidator: (val) => {
                if (!val || !val.trim()) return 'Nama folder tidak boleh kosong!';
            }
        }).then(res => {
            if (res.isConfirmed && res.value) {
                fetch(`{{ url('/admin/digital-archives/folders') }}/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ name: res.value.trim() })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        loadExplorerData(currentFolderId);
                    }
                });
            }
        });
    }

    // 10. Delete Folder (AJAX)
    function confirmDeleteFolder(id, name) {
        Swal.fire({
            title: 'Hapus Folder?',
            text: `Yakin ingin menghapus folder "${name}"? Berkas di dalamnya akan otomatis dipindahkan ke folder induk agar tidak hilang.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus Folder',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#DC2626'
        }).then(res => {
            if (res.isConfirmed) {
                fetch(`{{ url('/admin/digital-archives/folders') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        loadExplorerData(currentFolderId);
                    }
                });
            }
        });
    }

    // 11. Rename File (AJAX)
    function promptRenameFile(id, oldTitle) {
        Swal.fire({
            title: 'Ganti Judul Dokumen',
            input: 'text',
            inputValue: oldTitle,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563EB',
            inputValidator: (val) => {
                if (!val || !val.trim()) return 'Judul tidak boleh kosong!';
            }
        }).then(res => {
            if (res.isConfirmed && res.value) {
                fetch(`{{ url('/admin/digital-archives') }}/${id}/rename`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ title: res.value.trim() })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        loadExplorerData(currentFolderId);
                    }
                });
            }
        });
    }

    // 12. Delete File (AJAX)
    function confirmDeleteFile(id, title) {
        Swal.fire({
            title: 'Hapus Dokumen Arsip?',
            text: `Yakin ingin menghapus dokumen "${title}" secara permanen?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#DC2626'
        }).then(res => {
            if (res.isConfirmed) {
                fetch(`{{ url('/admin/digital-archives') }}/${id}/ajax`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        loadExplorerData(currentFolderId);
                    }
                });
            }
        });
    }

    // 13. Drag & Drop File Upload & Canvas Drop Handlers
    function handleCanvasDragOver(e) {
        e.preventDefault();
        e.stopPropagation();
        const overlay = document.getElementById('canvasDropOverlay');
        if (overlay) overlay.classList.remove('hidden');
    }

    function handleCanvasDragLeave(e) {
        e.preventDefault();
        e.stopPropagation();
        const overlay = document.getElementById('canvasDropOverlay');
        if (overlay) overlay.classList.add('hidden');
    }

    function handleCanvasDrop(e) {
        e.preventDefault();
        e.stopPropagation();
        const overlay = document.getElementById('canvasDropOverlay');
        if (overlay) overlay.classList.add('hidden');

        const dt = e.dataTransfer;
        if (dt && dt.files && dt.files.length > 0) {
            handleExplorerFilesUpload(dt.files);
        }
    }

    // 14. Upload Files directly to current folder via AJAX
    function handleExplorerFilesUpload(files) {
        if (!files || files.length === 0) return;

        Swal.fire({
            title: 'Mengunggah Berkas...',
            html: `Sedang mengonversi ${files.length} berkas ke Base64 dan menyimpan ke arsip...`,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const formData = new FormData();
        formData.append('folder_id', currentFolderId || '');
        formData.append('category', currentCategory !== 'all' ? currentCategory : 'nota_reimburse');

        for (let i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        fetch('{{ route('admin.digital-archives.upload.ajax') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Unggah Berhasil!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                loadExplorerData(currentFolderId);
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Gagal mengunggah.' });
            }
        })
        .catch(err => {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat mengunggah.' });
        });
    }

    // 15. Drag File into Folder (Moving)
    function handleFileDragStart(e, fileId, fileTitle) {
        e.dataTransfer.setData('text/plain', JSON.stringify({ fileId, fileTitle }));
        e.dataTransfer.effectAllowed = 'move';
    }

    function handleFolderDragOver(e) {
        e.preventDefault();
        e.stopPropagation();
        e.currentTarget.classList.add('ring-2', 'ring-blue-500', 'bg-blue-100');
    }

    function handleFolderDragLeave(e) {
        e.preventDefault();
        e.stopPropagation();
        e.currentTarget.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-100');
    }

    function handleFolderDrop(e, targetFolderId) {
        e.preventDefault();
        e.stopPropagation();
        e.currentTarget.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-100');

        const raw = e.dataTransfer.getData('text/plain');
        if (!raw) return;

        try {
            const data = JSON.parse(raw);
            if (data && data.fileId) {
                fetch(`{{ url('/admin/digital-archives') }}/${data.fileId}/move`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ target_folder_id: targetFolderId })
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        loadExplorerData(currentFolderId);
                    }
                });
            }
        } catch (err) {}
    }

    // 16. Move File via Modal
    let pendingMoveFileId = null;
    function openMoveModal(fileId, title) {
        pendingMoveFileId = fileId;
        const nameEl = document.getElementById('moveFileTitleName');
        const sel = document.getElementById('moveFileFolderSelect');
        const modal = document.getElementById('moveFileModal');
        if (nameEl) nameEl.textContent = `"${title}"`;

        // Populate folders in select
        if (sel && currentData.tree) {
            sel.innerHTML = '<option value="">📁 Arsip Utama (Root)</option>';
            function appendOptions(folders, prefix = '') {
                folders.forEach(f => {
                    sel.innerHTML += `<option value="${f.id}">${prefix}📁 ${f.name}</option>`;
                    if (f.children && f.children.length > 0) {
                        appendOptions(f.children, prefix + '— ');
                    }
                });
            }
            appendOptions(currentData.tree);
        }

        const confirmBtn = document.getElementById('confirmMoveBtn');
        if (confirmBtn) {
            confirmBtn.onclick = () => {
                const targetId = sel.value || null;
                fetch(`{{ url('/admin/digital-archives') }}/${pendingMoveFileId}/move`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ target_folder_id: targetId })
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        modal.classList.add('hidden');
                        loadExplorerData(currentFolderId);
                    }
                });
            };
        }

        modal.classList.remove('hidden');
    }

    // 17. Lightbox Preview & Print
    let currentPreviewData = null;
    function openExplorerPreview(file) {
        currentPreviewData = file;
        const modal = document.getElementById('explorerPreviewModal');
        const titleEl = document.getElementById('previewModalTitle');
        const subtitleEl = document.getElementById('previewModalSubtitle');
        const container = document.getElementById('previewMediaContainer');
        const downloadBtn = document.getElementById('previewDownloadBtn');
        const metaEl = document.getElementById('previewModalMeta');

        if (titleEl) titleEl.textContent = file.title;
        if (subtitleEl) subtitleEl.textContent = `${file.archive_no} • ${file.uploader_name || 'Admin'} • ${file.document_date}`;
        if (downloadBtn) {
            downloadBtn.href = file.file_base64;
            downloadBtn.download = file.file_name || `${file.title}.jpg`;
        }
        if (metaEl) metaEl.textContent = `Kategori: ${file.category} | Ukuran: ${file.file_size} | Dibuat: ${file.created_at}`;

        if (container) {
            container.innerHTML = '';
            if (file.is_image) {
                const img = document.createElement('img');
                img.src = file.file_base64;
                img.className = 'max-h-[55vh] max-w-full object-contain rounded-xl shadow-2xl';
                container.appendChild(img);
            } else {
                const iframe = document.createElement('iframe');
                iframe.src = file.file_base64;
                iframe.className = 'w-[800px] h-[55vh] rounded-xl border border-slate-700 bg-white';
                container.appendChild(iframe);
            }
        }

        modal.classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }

    function closeExplorerPreview() {
        const modal = document.getElementById('explorerPreviewModal');
        if (modal) modal.classList.add('hidden');
    }

    function printCurrentPreview() {
        if (!currentPreviewData) return;
        const w = window.open('');
        if (currentPreviewData.is_image) {
            w.document.write(`
                <html>
                    <head><title>Cetak Dokumen - ${currentPreviewData.title}</title></head>
                    <body style="margin:0;display:flex;justify-content:center;align-items:center;min-height:100vh;">
                        <img src="${currentPreviewData.file_base64}" style="max-width:95%;max-height:95vh;object-contain:contain;" onload="window.print();window.close();">
                    </body>
                </html>
            `);
        } else {
            w.document.write(`
                <html>
                    <head><title>Cetak Dokumen - ${currentPreviewData.title}</title></head>
                    <body style="margin:0;">
                        <iframe src="${currentPreviewData.file_base64}" style="width:100%;height:100vh;border:none;" onload="window.print();window.close();"></iframe>
                    </body>
                </html>
            `);
        }
        w.document.close();
    }

    function addslashes(str) {
        return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
    }

    // 18. Mini Dashboard Stats Synchronizer
    function updateMiniDashboard(stats) {
        if (!stats) return;
        const statFiles = document.getElementById('statTotalFiles');
        const statFolders = document.getElementById('statTotalFolders');
        const statReceipts = document.getElementById('statTotalReceipts');
        const statMou = document.getElementById('statTotalMou');
        const statSize = document.getElementById('statTotalSize');
        const statFree = document.getElementById('statFreeStorage');
        const statDetail = document.getElementById('statStorageDetail');
        const statPercent = document.getElementById('statStoragePercent');
        const statBar = document.getElementById('statStorageBar');
        const driverBadge = document.getElementById('statDriverBadge');
        const driverIcon = document.getElementById('statDriverIcon');

        if (statFiles && stats.total_files !== undefined) statFiles.textContent = Number(stats.total_files).toLocaleString('id-ID');
        if (statFolders && stats.total_folders !== undefined) statFolders.textContent = Number(stats.total_folders).toLocaleString('id-ID');
        if (statReceipts && stats.total_receipts !== undefined) statReceipts.textContent = Number(stats.total_receipts).toLocaleString('id-ID');
        if (statMou && stats.total_mou !== undefined) statMou.textContent = Number(stats.total_mou).toLocaleString('id-ID');

        if (stats.storage) {
            const st = stats.storage;
            if (statSize) statSize.textContent = st.used_formatted;
            if (statFree) statFree.textContent = `Sisa ${st.free_formatted}`;
            if (statDetail) {
                statDetail.innerHTML = `Terpakai <b id="statTotalSize" class="text-slate-800 font-bold">${st.used_formatted}</b> dari ${st.total_quota_formatted}`;
            }
            if (statPercent) {
                statPercent.textContent = `${st.used_percentage}%`;
                statPercent.className = `font-black ${st.used_percentage > 85 ? 'text-red-500' : 'text-slate-700'}`;
            }
            if (statBar) {
                statBar.style.width = `${Math.min(100, st.used_percentage)}%`;
                statBar.className = `h-full rounded-full transition-all duration-500 ${st.used_percentage > 90 ? 'bg-red-500' : (st.used_percentage > 75 ? 'bg-amber-500' : 'bg-japan-600')}`;
            }
            if (driverBadge) {
                driverBadge.textContent = st.driver === 'cloud' ? 'Cloud S3' : (st.driver === 'local' ? 'Lokal Disk' : 'Hosting Web');
            }
            if (driverIcon && st.driver_icon) {
                driverIcon.setAttribute('data-lucide', st.driver_icon);
                if (window.lucide) lucide.createIcons();
            }
        } else if (statSize && stats.total_size_mb) {
            statSize.textContent = stats.total_size_mb;
        }
    }

    // 19. Storage Configuration Modal Handlers
    function openStorageConfigModal() {
        const modal = document.getElementById('storageConfigModal');
        if (modal) modal.classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }

    function closeStorageConfigModal() {
        const modal = document.getElementById('storageConfigModal');
        if (modal) modal.classList.add('hidden');
    }

    function onDriverRadioChange(driver) {
        const quotaInput = document.getElementById('storageQuotaMb');
        if (!quotaInput) return;

        if (driver === 'cloud' && (!quotaInput.value || quotaInput.value == '5120')) {
            quotaInput.value = 10240; // 10 GB
        } else if (driver === 'hosting' && (!quotaInput.value || quotaInput.value == '10240')) {
            quotaInput.value = 5120; // 5 GB
        } else if (driver === 'local' && (!quotaInput.value || quotaInput.value == '5120')) {
            quotaInput.value = 20480; // 20 GB
        }
        previewQuotaGB(quotaInput.value);
    }

    function setQuotaPreset(mb) {
        const quotaInput = document.getElementById('storageQuotaMb');
        if (quotaInput) {
            quotaInput.value = mb;
            previewQuotaGB(mb);
        }
    }

    function previewQuotaGB(mb) {
        const previewEl = document.getElementById('quotaHumanPreview');
        if (!previewEl) return;
        const num = parseFloat(mb) || 0;
        if (num >= 1024) {
            previewEl.textContent = (num / 1024).toFixed(2) + ' GB';
        } else {
            previewEl.textContent = num + ' MB';
        }
    }

    function handleStorageConfigSubmit(event) {
        event.preventDefault();
        const btn = document.getElementById('saveStorageConfigBtn');
        const originalBtnHtml = btn ? btn.innerHTML : '';
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = `<span class="animate-spin mr-1">⏳</span> Menerapkan...`;
        }

        const form = document.getElementById('storageConfigForm');
        const formData = new FormData(form);
        const payload = {
            driver: formData.get('storage_driver'),
            quota_mb: formData.get('quota_mb'),
        };

        fetch('{{ route('admin.digital-archives.storage.config') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                closeStorageConfigModal();
                showArchiveToast(res.message || 'Konfigurasi penyimpanan berhasil diperbarui.');
                if (res.stats) {
                    updateMiniDashboard(res.stats);
                }
            } else {
                showArchiveToast(res.message || 'Gagal menyimpan konfigurasi.', 'error');
            }
        })
        .catch(err => {
            console.error('Storage config error:', err);
            showArchiveToast('Terjadi kesalahan saat menghubungi server.', 'error');
        })
        .finally(() => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
            }
        });
    }

    // 20. Simple Toast Notification
    function showArchiveToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-5 right-5 z-[100] px-4 py-3 rounded-2xl shadow-xl border text-xs font-bold flex items-center gap-2 transform transition-all duration-300 translate-y-2 opacity-0 ${
            type === 'error' 
                ? 'bg-rose-50 border-rose-200 text-rose-800' 
                : 'bg-slate-900 border-slate-800 text-white'
        }`;
        toast.innerHTML = `
            <span>${type === 'error' ? '⚠️' : '✅'}</span>
            <span>${message}</span>
        `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('translate-y-2', 'opacity-0');
        }, 10);

        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }

    // Initialize Explorer on load
    document.addEventListener('DOMContentLoaded', () => {
        loadExplorerData(null);
        // Periodic background sync every 20 seconds for mini dashboard stats
        setInterval(() => {
            fetch('{{ route('admin.digital-archives.stats') }}', {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success && res.stats) {
                    updateMiniDashboard(res.stats);
                }
            })
            .catch(() => {});
        }, 20000);
    });
</script>
@endsection
