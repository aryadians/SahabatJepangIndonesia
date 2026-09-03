@extends('admin.layouts.admin')

@section('title', 'Manajemen Brosur & Materi Unduhan')
@section('page_title', 'Kelola Brosur Resmi & Materi Kurikulum LPK')

@section('content')
<div class="space-y-6">

    <!-- 1. Top Mini Dashboard KPI Cards (Live Real-Time Synced) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Brosur -->
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Brosur Terdata</p>
                <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                    <i data-lucide="book-open" class="w-4 h-4"></i>
                </div>
            </div>
            <p data-admin-stat="brochures_total" class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">{{ number_format($stats['total_brochures']) }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Katalog materi publik</p>
        </div>

        <!-- Total Diunduh Guest -->
        <div class="p-5 rounded-2xl bg-white border border-emerald-200 shadow-xs hover:border-emerald-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Total Diunduh Tamu</p>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i data-lucide="download-cloud" class="w-4 h-4"></i>
                </div>
            </div>
            <p data-admin-stat="brochures_downloads" class="text-2xl sm:text-3xl font-black text-emerald-600 mt-2">{{ number_format($stats['total_downloads']) }}</p>
            <p class="text-[11px] text-emerald-700/80 mt-0.5 font-medium">Akumulasi unduhan pengunjung</p>
        </div>

        <!-- Brosur Aktif -->
        <div class="p-5 rounded-2xl bg-white border border-blue-200 shadow-xs hover:border-blue-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">Brosur Aktif Tampil</p>
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                </div>
            </div>
            <p data-admin-stat="brochures_active" class="text-2xl sm:text-3xl font-black text-blue-600 mt-2">{{ number_format($stats['active_brochures']) }}</p>
            <p class="text-[11px] text-blue-700/80 mt-0.5 font-medium">Tersedia di halaman /brosur</p>
        </div>

        <!-- Leads Terkumpul -->
        <div class="p-5 rounded-2xl bg-white border border-rose-200 shadow-xs hover:border-rose-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-japan-600 uppercase tracking-wider">Pendaftar Dari Brosur</p>
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="users" class="w-4 h-4"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-japan-600 mt-2">{{ number_format($stats['leads_from_brochures']) }}</p>
            <p class="text-[11px] text-rose-700/80 mt-0.5 font-medium">Konversi lead magnet</p>
        </div>

    </div>

    <!-- 2. Action & Filter Bar -->
    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex flex-wrap items-center justify-between gap-4">
        
        <!-- Filter Form -->
        <form action="{{ route('admin.brochures.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
            <select name="program" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-slate-50 focus:bg-white focus:outline-none focus:border-japan-600">
                <option value="all">Semua Program / Kelas</option>
                <option value="Tokutei Ginou (SSW)" {{ $program === 'Tokutei Ginou (SSW)' ? 'selected' : '' }}>Tokutei Ginou (SSW)</option>
                <option value="Ginou Jisshusei (Magang)" {{ $program === 'Ginou Jisshusei (Magang)' ? 'selected' : '' }}>Magang (Jisshusei)</option>
                <option value="Engineer & Profesional" {{ $program === 'Engineer & Profesional' ? 'selected' : '' }}>Engineer / Pro</option>
                <option value="Kursus Bahasa Jepang" {{ $program === 'Kursus Bahasa Jepang' ? 'selected' : '' }}>Kursus Bahasa</option>
                <option value="Panduan Biaya & Umum" {{ $program === 'Panduan Biaya & Umum' ? 'selected' : '' }}>Panduan Biaya & Umum</option>
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                Filter
            </button>

            @if($program !== 'all')
                <a href="{{ route('admin.brochures.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold" title="Reset Filter">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                </a>
            @endif
        </form>

        <!-- Tambah / Import Brosur Button -->
        <div class="flex items-center gap-2">
            <a href="{{ route('brochure.index') }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5" title="Lihat Tampilan Publik Brosur">
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                <span>Lihat Halaman Publik</span>
            </a>
            <button 
                type="button" 
                onclick="openModal('uploadBrochureModal')" 
                class="btn-red-primary px-4 py-2 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5"
            >
                <i data-lucide="upload" class="w-4 h-4"></i>
                <span>Upload / Buat Brosur Baru</span>
            </button>
        </div>

    </div>

    <!-- 3. Brochures Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-black text-slate-900 text-base">Daftar Brosur & Materi Siap Unduh</h3>
                <p class="text-xs text-slate-400">Pengunjung akan mengunduh brosur sesuai kategori dan program yang dipilih</p>
            </div>
            <span class="text-xs text-slate-500 font-bold">Total: {{ $brochures->total() }} Brosur</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] uppercase font-bold">
                        <th class="py-3.5 px-4">Judul Brosur / Materi</th>
                        <th class="py-3.5 px-4">Program / Kategori</th>
                        <th class="py-3.5 px-4">File Fisik</th>
                        <th class="py-3.5 px-4 text-center">Diunduh</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($brochures as $b)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $b->title }}</div>
                                <div class="text-[11px] text-slate-400 max-w-md truncate">{{ $b->description ?: '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $b->theme['badge_bg'] }}">
                                    {{ $b->program }}
                                </span>
                                @if($b->badge_text)
                                    <span class="ml-1 px-1.5 py-0.2 rounded text-[9px] font-bold bg-amber-100 text-amber-800">
                                        {{ $b->badge_text }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-1.5 font-mono text-[11px] text-slate-700">
                                    <i data-lucide="file-text" class="w-3.5 h-3.5 text-japan-600"></i>
                                    <span class="truncate max-w-[150px]">{{ $b->file_name ?: 'Brosur-Resmi.pdf' }}</span>
                                    <span class="text-[10px] text-slate-400">({{ $b->file_size ?: '2 MB' }})</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-center font-black text-emerald-600 font-mono">
                                {{ number_format($b->download_count) }}x
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($b->is_active)
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-bold text-[10px]">Draft</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Unduh / Test File -->
                                    <a 
                                        href="{{ route('brochure.download.file', $b->id) }}" 
                                        class="p-1.5 rounded-lg text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition" 
                                        title="Unduh / Buka File Brosur"
                                    >
                                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <!-- Edit Button -->
                                    <button 
                                        type="button" 
                                        onclick="openEditBrochureModal({{ $b->id }}, '{{ addslashes($b->title) }}', '{{ addslashes($b->program) }}', '{{ addslashes($b->badge_text ?? '') }}', '{{ addslashes($b->description ?? '') }}', {{ $b->is_active ? 1 : 0 }})"
                                        class="p-1.5 rounded-lg text-blue-600 bg-blue-50 hover:bg-blue-100 transition" 
                                        title="Edit Brosur"
                                    >
                                        <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                    </button>

                                    <!-- Hapus -->
                                    <form action="{{ route('admin.brochures.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Hapus brosur ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">Belum ada data brosur yang diunggah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($brochures->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $brochures->links() }}
            </div>
        @endif
    </div>

</div>

<!-- ==============================================================
     MODAL 1: UNGGAH / IMPORT BROSUR BARU
     ============================================================== -->
<div id="uploadBrochureModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-6">
        
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900">Upload Brosur Materi LPK</h3>
                    <p class="text-xs text-slate-400">Pilih program dan upload file PDF / Dokumen</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('uploadBrochureModal')" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('admin.brochures.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Judul Brosur -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Judul Brosur / E-Book <span class="text-rose-500">*</span></label>
                <input type="text" name="title" required placeholder="Contoh: Brosur Resmi Tokutei Ginou Kaigo 2026" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
            </div>

            <!-- Program / Kategori -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Program / Jenis Kelas <span class="text-rose-500">*</span></label>
                <select name="program" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                    <option value="Tokutei Ginou (SSW)">Tokutei Ginou (SSW) - Visa Kerja Keahlian</option>
                    <option value="Ginou Jisshusei (Magang)">Ginou Jisshusei (Magang Kerja 3 Tahun)</option>
                    <option value="Engineer & Profesional">Engineer & Profesional (Lulusan D3/S1)</option>
                    <option value="Kursus Bahasa Jepang">Kursus Persiapan Bahasa Jepang</option>
                    <option value="Panduan Biaya & Umum">Panduan Biaya & Alur Penyaluran Umum</option>
                </select>
            </div>

            <!-- Badge Text -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Badge Label Tambahan</label>
                <input type="text" name="badge_text" placeholder="Contoh: Paling Diminati, Gaji Tinggi, Update 2026" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-semibold">
            </div>

            <!-- Deskripsi Singkat -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Deskripsi Singkat Brosur</label>
                <textarea name="description" rows="2" placeholder="Jelaskan ringkasan materi yang ada di dalam brosur..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"></textarea>
            </div>

            <!-- File Upload PDF -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Unggah File Brosur (PDF / Dokumen)</label>
                <input type="file" name="brochure_file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-japan-700 hover:file:bg-red-100">
                <p class="text-[10px] text-slate-400">Format PDF disarankan (maks. 20MB). Jika tidak diunggah, sistem akan menggunakan template standar resmi.</p>
            </div>

            <!-- Status Tampil -->
            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" name="is_active" id="isActiveCheck" value="1" checked class="rounded text-japan-600 focus:ring-0">
                <label for="isActiveCheck" class="text-xs font-bold text-slate-700 cursor-pointer">Aktifkan dan tampilkan langsung di halaman publik</label>
            </div>

            <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('uploadBrochureModal')" class="px-4 py-2 rounded-xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="btn-red-primary px-5 py-2 rounded-xl text-xs font-bold shadow-md">
                    Simpan Brosur
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ==============================================================
     MODAL 2: EDIT BROSUR
     ============================================================== -->
<div id="editBrochureModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-6">
        
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900">Edit Data Brosur</h3>
                    <p class="text-xs text-slate-400">Perbarui informasi materi</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('editBrochureModal')" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="editBrochureForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Judul Brosur <span class="text-rose-500">*</span></label>
                <input type="text" id="editTitle" name="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Program / Kategori <span class="text-rose-500">*</span></label>
                <select id="editProgram" name="program" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                    <option value="Tokutei Ginou (SSW)">Tokutei Ginou (SSW)</option>
                    <option value="Ginou Jisshusei (Magang)">Ginou Jisshusei (Magang)</option>
                    <option value="Engineer & Profesional">Engineer & Profesional</option>
                    <option value="Kursus Bahasa Jepang">Kursus Bahasa Jepang</option>
                    <option value="Panduan Biaya & Umum">Panduan Biaya & Umum</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Badge Label</label>
                <input type="text" id="editBadge" name="badge_text" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-semibold">
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Deskripsi</label>
                <textarea id="editDescription" name="description" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"></textarea>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Ganti File Brosur (Opsional)</label>
                <input type="file" name="brochure_file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" name="is_active" id="editIsActive" value="1" class="rounded text-japan-600 focus:ring-0">
                <label for="editIsActive" class="text-xs font-bold text-slate-700 cursor-pointer">Brosur Aktif Tampil</label>
            </div>

            <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('editBrochureModal')" class="px-4 py-2 rounded-xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="btn-red-primary px-5 py-2 rounded-xl text-xs font-bold shadow-md">
                    Perbarui Brosur
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    function openEditBrochureModal(id, title, program, badge, desc, isActive) {
        document.getElementById('editBrochureForm').action = '/admin/brochures/' + id;
        document.getElementById('editTitle').value = title;
        document.getElementById('editProgram').value = program;
        document.getElementById('editBadge').value = badge || '';
        document.getElementById('editDescription').value = desc || '';
        document.getElementById('editIsActive').checked = isActive === 1;
        openModal('editBrochureModal');
    }
</script>
@endsection
