@extends('admin.layouts.admin')

@section('title', 'Arsip Digital Nota & Dokumen')
@section('page_title', 'Panel Arsip Digital Dokumen & Nota Penting (Base64)')

@section('content')
<div class="space-y-6">

    <!-- 1. Top KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                <i data-lucide="folder-archive" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Berkas Tersimpan</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ number_format($stats['total_archives']) }} Dokumen</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="receipt" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Nota Reimburse Fisik</p>
                <h3 class="text-2xl font-black text-emerald-600 mt-0.5">{{ number_format($stats['total_receipts']) }} Berkas</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                <i data-lucide="file-signature" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Naskah MoU Kemitraan</p>
                <h3 class="text-2xl font-black text-purple-600 mt-0.5">{{ number_format($stats['total_mou']) }} Berkas</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <i data-lucide="plane" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Tiket & Kuitansi Hotel</p>
                <h3 class="text-2xl font-black text-blue-600 mt-0.5">{{ number_format($stats['total_tickets']) }} Berkas</h3>
            </div>
        </div>

    </div>

    <!-- 2. Action & Filter Bar -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <form action="{{ route('admin.digital-archives.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 flex-1">
                <div class="relative min-w-[240px] flex-1">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari Nomor Dokumen, Judul, atau Nama Pengunggah..." 
                        class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"
                    >
                </div>

                <select name="category" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                    <option value="">Semua Kategori</option>
                    <option value="nota_reimburse" {{ request('category') === 'nota_reimburse' ? 'selected' : '' }}>Nota & Kuitansi Reimburse</option>
                    <option value="kuitansi_hotel_tiket" {{ request('category') === 'kuitansi_hotel_tiket' ? 'selected' : '' }}>Tiket & Hotel Dinas</option>
                    <option value="dokumen_mou" {{ request('category') === 'dokumen_mou' ? 'selected' : '' }}>Naskah MoU Kemitraan</option>
                    <option value="surat_tugas" {{ request('category') === 'surat_tugas' ? 'selected' : '' }}>Surat Tugas Dinas</option>
                    <option value="legalitas_izin" {{ request('category') === 'legalitas_izin' ? 'selected' : '' }}>Legalitas & Izin Lembaga</option>
                    <option value="lainnya" {{ request('category') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>

                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition">
                    Cari
                </button>

                @if(request()->anyFilled(['search', 'category']))
                    <a href="{{ route('admin.digital-archives.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold" title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </form>

            <button 
                type="button" 
                onclick="document.getElementById('uploadArchiveModal').classList.remove('hidden')"
                class="btn-red-primary px-4 py-2 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5 flex-shrink-0"
            >
                <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                <span>Unggah Dokumen Baru (Base64)</span>
            </button>
        </div>

    </div>

    <!-- 3. Digital Archive Gallery Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @forelse($archives as $item)
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                
                <div class="space-y-3">
                    <!-- Thumbnail with Base64 Preview -->
                    <div 
                        onclick="openArchiveLightbox('{{ addslashes($item->title) }}', '{{ $item->file_base64 }}', '{{ $item->archive_no }}', '{{ $item->document_date ? $item->document_date->format('d/m/Y') : '-' }}', '{{ $item->isImage() ? 'image' : 'file' }}')"
                        class="h-40 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 relative cursor-pointer flex items-center justify-center group-hover:border-japan-500/60 transition"
                    >
                        @if($item->isImage())
                            <img src="{{ $item->file_base64 }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="text-center p-3 text-slate-400">
                                <i data-lucide="file-text" class="w-10 h-10 mx-auto mb-1 text-slate-400"></i>
                                <span class="text-[10px] font-bold font-mono uppercase">{{ $item->file_type ?: 'DOKUMEN' }}</span>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-bold gap-1.5 backdrop-blur-2xs">
                            <i data-lucide="zoom-in" class="w-4 h-4"></i>
                            <span>Perbesar Nota</span>
                        </div>

                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider border {{ $item->category_badge['bg'] }}">
                            {{ $item->category_badge['label'] }}
                        </span>
                    </div>

                    <!-- Details -->
                    <div class="space-y-1">
                        <div class="flex items-center justify-between text-[10px] text-slate-400 font-mono">
                            <span>{{ $item->archive_no }}</span>
                            <span>{{ $item->document_date ? $item->document_date->format('d M Y') : '-' }}</span>
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-xs leading-snug line-clamp-2" title="{{ $item->title }}">
                            {{ $item->title }}
                        </h4>
                        @if($item->uploader_name)
                            <p class="text-[11px] text-slate-500 truncate">
                                Oleh: <span class="font-bold text-slate-700">{{ $item->uploader_name }}</span>
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="pt-3 mt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-[10px] font-mono text-slate-400 font-medium">
                        {{ $item->file_size ?: 'Base64' }}
                    </span>

                    <div class="flex items-center gap-1">
                        <!-- Open Lightbox / Print -->
                        <button 
                            type="button" 
                            onclick="openArchiveLightbox('{{ addslashes($item->title) }}', '{{ $item->file_base64 }}', '{{ $item->archive_no }}', '{{ $item->document_date ? $item->document_date->format('d/m/Y') : '-' }}', '{{ $item->isImage() ? 'image' : 'file' }}')"
                            class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition"
                            title="Buka / Cetak Nota"
                        >
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        </button>

                        <!-- Delete -->
                        <form action="{{ route('admin.digital-archives.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus arsip digital {{ $item->archive_no }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold transition" title="Hapus Arsip">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200 p-8">
                <div class="w-16 h-16 rounded-2xl bg-red-50 text-japan-600 mx-auto flex items-center justify-center mb-3">
                    <i data-lucide="folder-archive" class="w-8 h-8"></i>
                </div>
                <h3 class="font-extrabold text-slate-900 text-base">Belum Ada Dokumen / Nota di Arsip Digital</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Seluruh nota kuitansi yang dilampirkan dari klaim reimburse dan berkas MoU otomatis tersimpan aman di sini dalam format Base64.</p>
                <div class="mt-4">
                    <button type="button" onclick="document.getElementById('uploadArchiveModal').classList.remove('hidden')" class="btn-red-primary px-5 py-2.5 rounded-xl text-xs font-bold inline-flex items-center gap-2">
                        <i data-lucide="upload" class="w-4 h-4"></i>
                        <span>Unggah Arsip Pertama</span>
                    </button>
                </div>
            </div>
        @endforelse
    </div>

    @if($archives->hasPages())
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
            {{ $archives->links() }}
        </div>
    @endif

</div>

<!-- LIGHTBOX MODAL PREVIEW & ZOOM DOKUMEN BASE64 -->
<div id="archiveLightboxModal" class="fixed inset-0 bg-slate-950/85 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-3xl w-full max-h-[92vh] flex flex-col shadow-2xl overflow-hidden">
        
        <div class="p-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <div>
                <h4 class="font-black text-slate-900 text-sm" id="lightboxTitle">Preview Dokumen</h4>
                <p class="text-[11px] text-slate-500 font-mono" id="lightboxSubtitle">DOC-SJI/...</p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="printLightboxDoc()" class="px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition flex items-center gap-1.5">
                    <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                    <span>Cetak Nota</span>
                </button>
                <button type="button" onclick="closeArchiveLightbox()" class="w-8 h-8 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 flex items-center justify-center">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-auto p-4 bg-slate-900 flex items-center justify-center min-h-[300px]">
            <img id="lightboxImage" src="" alt="Full Preview" class="max-w-full max-h-[70vh] object-contain rounded-lg shadow-lg">
            <iframe id="lightboxFrame" src="" class="w-full h-[65vh] rounded-lg hidden"></iframe>
        </div>

    </div>
</div>

<!-- MODAL UNGGAH DOKUMEN ARSIP BARU -->
<div id="uploadArchiveModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden">
        
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h3 class="font-black text-slate-900 text-sm">Unggah Arsip Digital Baru (Base64)</h3>
            <button type="button" onclick="document.getElementById('uploadArchiveModal').classList.add('hidden')" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form action="{{ route('admin.digital-archives.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Judul / Nama Dokumen <span class="text-rose-500">*</span></label>
                <input 
                    type="text" 
                    name="title" 
                    required 
                    placeholder="Contoh: Nota Hotel Aston Cirebon MoU / Scan SK Izin SO" 
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600"
                >
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Kategori Berkas <span class="text-rose-500">*</span></label>
                    <select name="category" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                        <option value="nota_reimburse">Nota & Kuitansi Reimburse</option>
                        <option value="kuitansi_hotel_tiket">Tiket & Hotel Dinas</option>
                        <option value="dokumen_mou">Naskah MoU Kemitraan</option>
                        <option value="surat_tugas">Surat Tugas Dinas Luar Kota</option>
                        <option value="legalitas_izin">Legalitas & Izin Lembaga</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Tanggal Dokumen</label>
                    <input 
                        type="date" 
                        name="document_date" 
                        value="{{ date('Y-m-d') }}" 
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                    >
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Pilih Berkas Dokumen (Foto / PDF) <span class="text-rose-500">*</span></label>
                <input 
                    type="file" 
                    name="document_file" 
                    required 
                    accept="image/*,application/pdf" 
                    class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-slate-50 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-japan-600 file:text-white cursor-pointer"
                >
                <p class="text-[10px] text-slate-400">Berkas akan dikonversi ke Base64 (LONGTEXT) dan disimpan langsung di database.</p>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Catatan Tambahan</label>
                <textarea 
                    name="notes" 
                    rows="2" 
                    placeholder="Keterangan pengesahan, pihak terkait, dll..." 
                    class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                ></textarea>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="document.getElementById('uploadArchiveModal').classList.add('hidden')" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">
                    Batal
                </button>
                <button type="submit" class="btn-red-primary px-5 py-2 rounded-xl text-xs font-bold shadow-md">
                    Simpan ke Arsip Digital
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let activeLightboxBase64 = '';

    function openArchiveLightbox(title, base64, docNo, date, type) {
        activeLightboxBase64 = base64;
        document.getElementById('lightboxTitle').textContent = title;
        document.getElementById('lightboxSubtitle').textContent = docNo + ' • ' + date;

        const img = document.getElementById('lightboxImage');
        const frame = document.getElementById('lightboxFrame');

        if (type === 'image' || base64.startsWith('data:image/')) {
            img.src = base64;
            img.classList.remove('hidden');
            frame.classList.add('hidden');
        } else {
            frame.src = base64;
            frame.classList.remove('hidden');
            img.classList.add('hidden');
        }

        document.getElementById('archiveLightboxModal').classList.remove('hidden');
    }

    function closeArchiveLightbox() {
        document.getElementById('archiveLightboxModal').classList.add('hidden');
        document.getElementById('lightboxImage').src = '';
        document.getElementById('lightboxFrame').src = '';
        activeLightboxBase64 = '';
    }

    function printLightboxDoc() {
        if (!activeLightboxBase64) return;
        const win = window.open('');
        win.document.write(`
            <html>
                <head><title>Cetak Nota Arsip</title></head>
                <body style="margin:0; display:flex; justify-content:center; align-items:center; min-height:100vh;">
                    <img src="${activeLightboxBase64}" style="max-width:100%; max-height:100%; object-contain:contain;" onload="window.print();window.close();"/>
                </body>
            </html>
        `);
        win.document.close();
    }
</script>
@endsection
