@extends('admin.layouts.admin')

@section('title', 'Galeri Kunjungan Kampus & Program Pemerintah')
@section('page_title', 'Kelola Foto Carousel Kunjungan Kampus & Program Pemerintah')

@section('content')
<div class="space-y-6">

    <!-- 1. Top Mini Dashboard KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Foto Galeri -->
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs hover:border-slate-300 transition flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Dokumentasi</span>
                <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                    <i data-lucide="camera" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="mt-3">
                <p class="text-2xl sm:text-3xl font-black text-slate-900 leading-none">{{ number_format($stats['total']) }}</p>
                <p class="text-[11px] text-slate-400 mt-1 font-medium">Foto kegiatan kemitraan</p>
            </div>
        </div>

        <!-- SMILE Project (Kemenkes & Poltekkes) -->
        <div class="p-5 rounded-2xl bg-white border border-emerald-200 shadow-xs hover:border-emerald-300 transition flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">SMILE Project (Kemenkes)</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i data-lucide="award" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="mt-3">
                <p class="text-2xl sm:text-3xl font-black text-emerald-600 leading-none">{{ number_format($stats['smile_project']) }}</p>
                <p class="text-[11px] text-emerald-700/80 mt-1 font-medium">Poltekkes & STIKes Kaigo</p>
            </div>
        </div>

        <!-- SMK Go Japan -->
        <div class="p-5 rounded-2xl bg-white border border-blue-200 shadow-xs hover:border-blue-300 transition flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">SMK Go Japan</span>
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i data-lucide="flag" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="mt-3">
                <p class="text-2xl sm:text-3xl font-black text-blue-600 leading-none">{{ number_format($stats['smk_go_japan']) }}</p>
                <p class="text-[11px] text-blue-700/80 mt-1 font-medium">Vokasi industri anak SMK</p>
            </div>
        </div>

        <!-- Foto Aktif Tampil -->
        <div class="p-5 rounded-2xl bg-white border border-rose-200 shadow-xs hover:border-rose-300 transition flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-japan-600 uppercase tracking-wider">Aktif di Carousel</span>
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="mt-3">
                <p class="text-2xl sm:text-3xl font-black text-japan-600 leading-none">{{ number_format($stats['active']) }}</p>
                <p class="text-[11px] text-rose-700/80 mt-1 font-medium">Tayang di beranda tamu</p>
            </div>
        </div>

    </div>

    <!-- 2. Structured 2-Tier Filter & Action Toolbar -->
    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs space-y-4">
        
        <!-- TIER 1: Search & Filter Form -->
        <form action="{{ route('admin.campus-galleries.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
            
            <!-- Live Search Bar (Span 5) -->
            <div class="md:col-span-5 relative">
                <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input 
                    type="text" 
                    id="gallerySearchInput" 
                    name="q" 
                    value="{{ request('q') }}" 
                    placeholder="Cari kegiatan, nama kampus (Poltekkes, SMK), atau caption..." 
                    oninput="filterGalleryLive()" 
                    class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600 bg-slate-50/70 focus:bg-white transition"
                >
            </div>

            <!-- Program Tag Dropdown (Span 4) -->
            <div class="md:col-span-4">
                <select 
                    name="tag" 
                    onchange="this.form.submit()" 
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-slate-50/70 focus:bg-white focus:outline-none focus:border-japan-600 transition"
                >
                    <option value="all">Semua Program & Tag</option>
                    <option value="SMILE Project" {{ request('tag') === 'SMILE Project' ? 'selected' : '' }}>SMILE Project (Kemenkes Kaigo)</option>
                    <option value="SMK Go Japan" {{ request('tag') === 'SMK Go Japan' ? 'selected' : '' }}>SMK Go Japan (Vokasi)</option>
                    <option value="MoU Kampus" {{ request('tag') === 'MoU Kampus' ? 'selected' : '' }}>MoU Poltekkes & STIKes</option>
                    <option value="Campus Job Fair" {{ request('tag') === 'Campus Job Fair' ? 'selected' : '' }}>Bursa Kerja Khusus (Job Fair)</option>
                    <option value="Pelepasan Terbang" {{ request('tag') === 'Pelepasan Terbang' ? 'selected' : '' }}>Pelepasan Terbang Siswa</option>
                </select>
            </div>

            <!-- Buttons (Span 3) -->
            <div class="md:col-span-3 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition flex items-center justify-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>Terapkan</span>
                </button>
                @if(request()->anyFilled(['q', 'tag']))
                    <a href="{{ route('admin.campus-galleries.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition" title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>

        </form>

        <!-- TIER 2: Live Counter & Action Buttons -->
        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
            
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold">
                    <i data-lucide="layers" class="w-3.5 h-3.5 text-slate-500"></i>
                    <span>Menampilkan: <b id="displayedGalleryCount" class="text-slate-900">{{ $galleries->count() }}</b> dari {{ $galleries->total() }} Foto</span>
                </span>
            </div>

            <div class="flex items-center gap-2.5">
                <a 
                    href="{{ url('/#kemitraan') }}" 
                    target="_blank" 
                    class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5" 
                    title="Lihat Tampilan Carousel di Beranda"
                >
                    <i data-lucide="external-link" class="w-3.5 h-3.5 text-slate-500"></i>
                    <span>Lihat di Beranda</span>
                </a>
                
                <button 
                    type="button" 
                    onclick="openModal('addGalleryModal')" 
                    class="btn-red-primary px-4 py-2 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5"
                >
                    <i data-lucide="upload" class="w-4 h-4"></i>
                    <span>Upload Foto Galeri Baru</span>
                </button>
            </div>

        </div>

    </div>

    <!-- 3. Photo Cards Grid (Visual & Responsive) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="galleryCardsGrid">
        @forelse($galleries as $item)
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between gallery-card group" data-title="{{ strtolower($item->title) }}" data-inst="{{ strtolower($item->institution) }}" data-tag="{{ strtolower($item->program_tag) }}">
                
                <!-- Image Header -->
                <div class="h-48 relative bg-slate-900 overflow-hidden">
                    <img 
                        src="{{ $item->image }}" 
                        alt="{{ $item->title }}" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                        onerror="this.src='https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=800&q=80'"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent"></div>

                    <!-- Top Badge: Program Tag -->
                    <div class="absolute top-3 left-3 flex items-center gap-1.5">
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border shadow-sm {{ $item->tag_badge['bg'] }}">
                            {{ $item->program_tag }}
                        </span>
                    </div>

                    <!-- Top Right: Order Pill -->
                    <div class="absolute top-3 right-3">
                        <span class="px-2 py-0.5 rounded-md bg-slate-900/80 text-white font-mono text-[10px] font-bold backdrop-blur-xs">
                            Urutan #{{ $item->order }}
                        </span>
                    </div>

                    <!-- Bottom Right: Institution Label -->
                    <div class="absolute bottom-2.5 right-3 text-[11px] font-mono font-bold text-white/90 drop-shadow">
                        {{ $item->institution ?: 'Kemitraan LPK SJI' }}
                    </div>
                </div>

                <!-- Content Body -->
                <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2">
                            @if($item->badge_text)
                                <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    ★ {{ $item->badge_text }}
                                </span>
                            @endif
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-sm leading-snug group-hover:text-japan-600 transition">
                            {{ $item->title }}
                        </h4>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $item->description ?: 'Dokumentasi kegiatan resmi LPK Sahabat Jepang Indonesia.' }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                        <span>{{ $item->sub_text_left ?: 'Program Pemerintah' }}</span>
                        <span class="font-bold text-emerald-600">{{ $item->sub_text_right ?: 'Terverifikasi' }}</span>
                    </div>
                </div>

                <!-- Footer Action Bar -->
                <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                    
                    <!-- Toggle Active Status -->
                    <form action="{{ route('admin.campus-galleries.toggle', $item->id) }}" method="POST">
                        @csrf
                        <button 
                            type="submit" 
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold transition {{ $item->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-200 text-slate-600 hover:bg-slate-300' }}"
                            title="Klik untuk mengubah status tampil"
                        >
                            <span class="w-2 h-2 rounded-full {{ $item->is_active ? 'bg-emerald-600 animate-pulse' : 'bg-slate-400' }}"></span>
                            <span>{{ $item->is_active ? 'Aktif Tayang' : 'Draft Non-Aktif' }}</span>
                        </button>
                    </form>

                    <!-- Edit & Delete Buttons -->
                    <div class="flex items-center gap-1.5">
                        <button 
                            type="button" 
                            data-gallery='@json($item)'
                            onclick="openEditGalleryFromBtn(this)"
                            class="p-2 rounded-xl text-blue-600 bg-blue-50 hover:bg-blue-100 transition" 
                            title="Edit Foto & Keterangan"
                        >
                            <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                        </button>

                        <form action="{{ route('admin.campus-galleries.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus foto kegiatan {{ addslashes($item->title) }} dari carousel?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus Foto">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>

                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-3xl border border-slate-200">
                <i data-lucide="camera-off" class="w-10 h-10 mx-auto mb-2 opacity-50"></i>
                <p class="font-bold text-slate-700 text-sm">Belum ada foto galeri kunjungan kampus</p>
                <p class="text-xs text-slate-400 mt-1">Klik tombol "Upload Foto Galeri Baru" untuk menambahkan dokumentasi.</p>
            </div>
        @endforelse
    </div>

    @if($galleries->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-slate-200">
            {{ $galleries->links() }}
        </div>
    @endif

</div>

<!-- ==============================================================
     MODAL 1: TAMBAH / UPLOAD FOTO GALERI BARU
     ============================================================== -->
<div id="addGalleryModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-5 max-h-[90vh] overflow-y-auto">
        
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="camera" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900">Upload Foto Galeri Kampus</h3>
                    <p class="text-xs text-slate-400">Dokumentasi kegiatan program pemerintah</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('addGalleryModal')" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('admin.campus-galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Judul Kegiatan -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Judul Kegiatan / Dokumentasi <span class="text-rose-500">*</span></label>
                <input type="text" name="title" required placeholder="Contoh: MoU Kerjasama Penyaluran Lulusan Keperawatan" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
            </div>

            <!-- Nama Kampus / Institusi -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Nama Kampus / Sekolah / Lokasi</label>
                <input type="text" name="institution" placeholder="Contoh: Poltekkes Kemenkes Semarang, SMKN 1 Surabaya" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
            </div>

            <!-- Program Tag & Badge -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Program / Kategori <span class="text-rose-500">*</span></label>
                    <select name="program_tag" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:border-japan-600">
                        <option value="SMILE Project">SMILE Project (Kemenkes Kaigo)</option>
                        <option value="SMK Go Japan">SMK Go Japan (Vokasi)</option>
                        <option value="MoU Kampus">MoU Poltekkes & STIKes</option>
                        <option value="Campus Job Fair">Bursa Kerja Khusus (Job Fair)</option>
                        <option value="Pelepasan Terbang">Pelepasan Terbang</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Badge Label Foto</label>
                    <input type="text" name="badge_text" placeholder="Penandatanganan MoU, Job Fair" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <!-- Deskripsi Singkat -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Deskripsi / Caption Kegiatan</label>
                <textarea name="description" rows="2" placeholder="Ceritakan ringkasan kegiatan kunjungan atau MoU ini..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"></textarea>
            </div>

            <!-- Subtext Baris Bawah -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Keterangan Kiri Bawah</label>
                    <input type="text" name="sub_text_left" placeholder="Auditorium Kampus / Beasiswa Kemenkes" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Keterangan Kanan Bawah</label>
                    <input type="text" name="sub_text_right" placeholder="120+ Peserta / Resmi Terverifikasi" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <!-- Upload File Gambar atau URL -->
            <div class="space-y-2 pt-1 border-t border-slate-100">
                <!-- Preview Gambar Baru -->
                <div id="addPreviewBox" class="h-32 rounded-2xl bg-slate-900 overflow-hidden relative hidden">
                    <img id="addImagePreview" src="" alt="Pratinjau" class="w-full h-full object-cover">
                    <span class="absolute bottom-2 left-2 px-2 py-0.5 rounded bg-slate-950/80 text-[10px] text-white font-mono">Pratinjau Foto Baru</span>
                </div>

                <label class="block text-xs font-bold text-slate-700">Upload File Foto (Maks. 10MB)</label>
                <input type="file" name="image_file" accept=".png,.jpg,.jpeg,.webp" onchange="previewImageFile(this, 'addImagePreview', 'addPreviewBox')" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-japan-700 hover:file:bg-red-100 cursor-pointer">
                <p class="text-[10px] text-slate-400">Atau gunakan URL gambar jika foto sudah di-host online:</p>
                <input type="text" name="image_url" placeholder="https://..." oninput="previewUrlImage(this, 'addImagePreview', 'addPreviewBox')" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-mono focus:outline-none focus:border-japan-600">
            </div>

            <!-- Urutan Tampil & Status -->
            <div class="grid grid-cols-2 gap-3 pt-2">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Urutan Tampil (Order)</label>
                    <input type="number" name="order" value="1" min="0" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-mono font-bold focus:outline-none focus:border-japan-600">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" name="is_active" id="isActiveAddCheck" value="1" checked class="rounded text-japan-600 focus:ring-0">
                    <label for="isActiveAddCheck" class="text-xs font-bold text-slate-700 cursor-pointer">Aktif di Carousel</label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('addGalleryModal')" class="px-4 py-2 rounded-xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="btn-red-primary px-5 py-2 rounded-xl text-xs font-bold shadow-md">
                    Simpan Foto
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ==============================================================
     MODAL 2: EDIT FOTO GALERI
     ============================================================== -->
<div id="editGalleryModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-5 max-h-[90vh] overflow-y-auto">
        
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900">Edit Foto Galeri Kampus</h3>
                    <p class="text-xs text-slate-400">Perbarui data dokumentasi kegiatan</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('editGalleryModal')" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="editGalleryForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Preview Gambar Saat Ini -->
            <div class="h-36 rounded-2xl bg-slate-900 overflow-hidden relative">
                <img id="editImagePreview" src="" alt="Preview" class="w-full h-full object-cover">
                <span class="absolute bottom-2 left-2 px-2 py-0.5 rounded bg-slate-950/80 text-[10px] text-white font-mono">Foto Dokumentasi</span>
            </div>

            <!-- Judul Kegiatan -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Judul Kegiatan <span class="text-rose-500">*</span></label>
                <input type="text" id="editTitle" name="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
            </div>

            <!-- Nama Kampus -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Nama Kampus / Sekolah / Lokasi</label>
                <input type="text" id="editInstitution" name="institution" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
            </div>

            <!-- Program Tag & Badge -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Program / Kategori <span class="text-rose-500">*</span></label>
                    <select id="editProgramTag" name="program_tag" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:border-japan-600">
                        <option value="SMILE Project">SMILE Project (Kemenkes Kaigo)</option>
                        <option value="SMK Go Japan">SMK Go Japan (Vokasi)</option>
                        <option value="MoU Kampus">MoU Poltekkes & STIKes</option>
                        <option value="Campus Job Fair">Bursa Kerja Khusus (Job Fair)</option>
                        <option value="Pelepasan Terbang">Pelepasan Terbang</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Badge Label Foto</label>
                    <input type="text" id="editBadgeText" name="badge_text" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <!-- Deskripsi Singkat -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Deskripsi / Caption Kegiatan</label>
                <textarea id="editDescription" name="description" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"></textarea>
            </div>

            <!-- Subtext Baris Bawah -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Keterangan Kiri Bawah</label>
                    <input type="text" id="editSubTextLeft" name="sub_text_left" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Keterangan Kanan Bawah</label>
                    <input type="text" id="editSubTextRight" name="sub_text_right" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <!-- Ganti Gambar -->
            <div class="space-y-2 pt-1 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-700">Ganti File Foto (Opsional)</label>
                <input type="file" name="image_file" accept=".png,.jpg,.jpeg,.webp" onchange="previewImageFile(this, 'editImagePreview')" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                <input type="text" id="editImageUrl" name="image_url" placeholder="Atau ganti URL gambar: https://..." oninput="previewUrlImage(this, 'editImagePreview')" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-mono focus:outline-none focus:border-japan-600">
            </div>

            <!-- Urutan Tampil & Status -->
            <div class="grid grid-cols-2 gap-3 pt-2">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Urutan Tampil (Order)</label>
                    <input type="number" id="editOrder" name="order" min="0" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-mono font-bold focus:outline-none focus:border-japan-600">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" name="is_active" id="editIsActive" value="1" class="rounded text-japan-600 focus:ring-0">
                    <label for="editIsActive" class="text-xs font-bold text-slate-700 cursor-pointer">Aktif di Carousel</label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('editGalleryModal')" class="px-4 py-2 rounded-xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="btn-red-primary px-5 py-2 rounded-xl text-xs font-bold shadow-md">
                    Perbarui Foto
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    function openEditGalleryFromBtn(btn) {
        try {
            const data = JSON.parse(btn.getAttribute('data-gallery'));
            document.getElementById('editGalleryForm').action = '/admin/campus-galleries/' + data.id;
            document.getElementById('editTitle').value = data.title || '';
            document.getElementById('editInstitution').value = data.institution || '';
            document.getElementById('editProgramTag').value = data.program_tag || 'MoU Kampus';
            document.getElementById('editBadgeText').value = data.badge_text || '';
            document.getElementById('editDescription').value = data.description || '';
            document.getElementById('editSubTextLeft').value = data.sub_text_left || '';
            document.getElementById('editSubTextRight').value = data.sub_text_right || '';
            document.getElementById('editImagePreview').src = data.image || '';
            document.getElementById('editImageUrl').value = (data.image && !data.image.startsWith('data:')) ? data.image : '';
            document.getElementById('editOrder').value = data.order !== undefined ? data.order : 0;
            document.getElementById('editIsActive').checked = Boolean(data.is_active);
            openModal('editGalleryModal');
        } catch (e) {
            console.error('Failed to parse gallery item:', e);
        }
    }

    function previewImageFile(input, imgId, boxId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(imgId);
                if (img) img.src = e.target.result;
                if (boxId) {
                    const box = document.getElementById(boxId);
                    if (box) box.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewUrlImage(input, imgId, boxId) {
        const url = (input.value || '').trim();
        if (url.startsWith('http://') || url.startsWith('https://')) {
            const img = document.getElementById(imgId);
            if (img) img.src = url;
            if (boxId) {
                const box = document.getElementById(boxId);
                if (box) box.classList.remove('hidden');
            }
        }
    }

    // Client-side Instant Filter
    function filterGalleryLive() {
        const query = (document.getElementById('gallerySearchInput').value || '').toLowerCase().trim();
        const cards = document.querySelectorAll('.gallery-card');
        let count = 0;

        cards.forEach(card => {
            const title = card.getAttribute('data-title') || '';
            const inst = card.getAttribute('data-inst') || '';
            const tag = card.getAttribute('data-tag') || '';

            const match = !query || title.includes(query) || inst.includes(query) || tag.includes(query);
            if (match) {
                card.style.display = '';
                count++;
            } else {
                card.style.display = 'none';
            }
        });

        const countEl = document.getElementById('displayedGalleryCount');
        if (countEl) countEl.textContent = count;
    }
</script>
@endsection
