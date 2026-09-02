@extends('admin.layouts.admin')

@section('title', 'Pengaturan Konten Website & Logo')
@section('page_title', 'Pengaturan Website & Logo Header')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8 max-w-5xl">
    @csrf

    <!-- 1. Logo & Brand Identity Settings (Base64 LONGTEXT) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="image" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Logo Website (Header & Footer)</h3>
                <p class="text-xs text-slate-500">Ubah logo brand website yang tampil di header atas dan footer (disimpan sebagai Base64)</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            
            <!-- Logo Preview Box -->
            <div class="md:col-span-4 p-5 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col items-center justify-center text-center space-y-3">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Preview Logo Aktif</p>
                <div class="h-20 w-full flex items-center justify-center bg-white p-2 rounded-xl border border-slate-200 shadow-inner overflow-hidden">
                    @if(!empty($settings['site_logo']))
                        <img id="logoPreviewImg" src="{{ $settings['site_logo'] }}" alt="Logo LPK" class="max-h-full max-w-full object-contain">
                    @else
                        <div id="logoDefaultBadge" class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-xl bg-japan-600 text-white flex items-center justify-center font-japanese font-black text-lg">
                                友
                            </div>
                            <span class="font-extrabold text-slate-800 text-xs text-left">Badge Default (Kanji 友)</span>
                        </div>
                    @endif
                </div>
                <p class="text-[10px] text-slate-400">Format: PNG transparan, JPG, WEBP, atau SVG</p>
            </div>

            <!-- Upload & Input Controls -->
            <div class="md:col-span-8 space-y-4">
                
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">1. Unggah File Logo Baru (Otomatis Tersimpan Base64)</label>
                    <input 
                        type="file" 
                        name="site_logo_file" 
                        accept="image/*" 
                        onchange="previewImageFile(this, 'logoPreviewImg')"
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:outline-none focus:border-japan-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-japan-600 file:text-white hover:file:bg-japan-700 cursor-pointer"
                    >
                    <p class="text-[10px] text-slate-400">File langsung dikonversi ke Base64 format tanpa memerlukan hosting eksternal.</p>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">2. Atau Masukkan URL / Data Base64 Manual</label>
                    <input type="text" name="site_logo" value="{{ $settings['site_logo'] ?? '' }}" placeholder="https://... atau data:image/png;base64,..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-mono">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase">Nama Brand Header</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'SAHABAT JEPANG' }}" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-bold">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase">Tagline / Subtitle Header</label>
                        <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? 'Penyalur Resmi Kemenaker' }}" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- 2. Top Announcement Bar Settings -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
        <div class="border-b border-slate-100 pb-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="megaphone" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Top Announcement Bar (Banner Pengumuman Atas)</h3>
                <p class="text-xs text-slate-500">Teks berjalan atau promosi yang berada di paling atas website</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Badge Label</label>
                <input type="text" name="announcement_badge" value="{{ $settings['announcement_badge'] ?? 'Batch Baru 2026 Dibuka' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Teks Pengumuman Promo / Batch</label>
                <input type="text" name="announcement_text" value="{{ $settings['announcement_text'] ?? '🌸 Pendaftaran Gelombang Khusus Tokutei Ginou & Magang Jepang Telah Dibuka! Kuota Terbatas.' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>
        </div>
    </div>

    <!-- 3. Hero Section Settings -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
        <div class="border-b border-slate-100 pb-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="sparkles" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Konten Hero Section (Beranda Utama)</h3>
                <p class="text-xs text-slate-500">Judul utama (headline), sub-judul penjelas, dan gambar banner visual</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Motto Badge Atas Judul</label>
                <input type="text" name="hero_motto" value="{{ $settings['hero_motto'] ?? 'LPK & SO Resmi Kemenaker RI' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Headline Bagian 1</label>
                    <input type="text" name="hero_title_1" value="{{ $settings['hero_title_1'] ?? 'Jembatan Emas Menuju' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Headline Teks Highlight (Merah)</label>
                    <input type="text" name="hero_title_highlight" value="{{ $settings['hero_title_highlight'] ?? 'Karir Gemilang di Jepang' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold text-japan-600">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Deskripsi / Subtitle Hero</label>
                <textarea name="hero_subtitle" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Upload Gambar Banner Hero (Base64)</label>
                    <input 
                        type="file" 
                        name="hero_image_file" 
                        accept="image/*" 
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:outline-none focus:border-japan-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-japan-600 file:text-white hover:file:bg-japan-700 cursor-pointer"
                    >
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Atau URL Gambar Hero</label>
                    <input type="text" name="hero_image" value="{{ $settings['hero_image'] ?? '' }}" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-mono">
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Stat Counters Settings -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
        <div class="border-b border-slate-100 pb-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="bar-chart-2" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Angka Pencapaian (Statistik Banner)</h3>
                <p class="text-xs text-slate-500">4 kotak statistik yang ditampilkan di bawah Hero beranda</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                <p class="text-[11px] font-extrabold text-slate-700">1. Alumni Berangkat</p>
                <input type="number" name="stat_alumni_count" value="{{ $settings['stat_alumni_count'] ?? '500' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-sm font-bold">
                <input type="text" name="stat_alumni_suffix" value="{{ $settings['stat_alumni_suffix'] ?? '+' }}" placeholder="Suffix (+)" class="w-full px-3 py-1 rounded-lg border border-slate-200 text-xs">
            </div>

            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                <p class="text-[11px] font-extrabold text-slate-700">2. Mitra Kaisha</p>
                <input type="number" name="stat_partners_count" value="{{ $settings['stat_partners_count'] ?? '50' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-sm font-bold">
                <input type="text" name="stat_partners_suffix" value="{{ $settings['stat_partners_suffix'] ?? '+' }}" placeholder="Suffix (+)" class="w-full px-3 py-1 rounded-lg border border-slate-200 text-xs">
            </div>

            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                <p class="text-[11px] font-extrabold text-slate-700">3. Tingkat Lulus Ujian</p>
                <input type="number" name="stat_pass_rate_count" value="{{ $settings['stat_pass_rate_count'] ?? '98' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-sm font-bold">
                <input type="text" name="stat_pass_rate_suffix" value="{{ $settings['stat_pass_rate_suffix'] ?? '%' }}" placeholder="Suffix (%)" class="w-full px-3 py-1 rounded-lg border border-slate-200 text-xs">
            </div>

            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                <p class="text-[11px] font-extrabold text-slate-700">4. Legalitas Kemenaker</p>
                <input type="number" name="stat_legal_count" value="{{ $settings['stat_legal_count'] ?? '100' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-sm font-bold">
                <input type="text" name="stat_legal_suffix" value="{{ $settings['stat_legal_suffix'] ?? '%' }}" placeholder="Suffix (%)" class="w-full px-3 py-1 rounded-lg border border-slate-200 text-xs">
            </div>

        </div>
    </div>

    <!-- 5. Contact & Footer Settings -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
        <div class="border-b border-slate-100 pb-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="phone" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Informasi Kontak & Footer</h3>
                <p class="text-xs text-slate-500">Nomor telepon kantor, WhatsApp follow up, email resmi, dan jam operasional</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nomor WhatsApp Resmi (Format: 628xxx)</label>
                <input type="text" name="contact_whatsapp" value="{{ $settings['contact_whatsapp'] ?? '6281234567890' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold text-emerald-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Telepon Kantor</label>
                <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '+62 812-3456-7890 / (021) 7890-1234' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Email Resmi</label>
                <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'info@sahabatjepangindonesia.com' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Jam Operasional</label>
                <input type="text" name="contact_hours" value="{{ $settings['contact_hours'] ?? 'Senin - Sabtu: 08.00 - 17.00 WIB' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Alamat Kantor / Training Center</label>
                <textarea name="contact_address" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">{{ $settings['contact_address'] ?? 'Jl. Sakura Raya No. 88, Kawasan Pendidikan & Pelatihan Karir Jepang, Jakarta' }}</textarea>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="sticky bottom-6 z-20 flex justify-end">
        <button type="submit" class="btn-red-primary px-8 py-4 rounded-2xl font-bold text-sm shadow-xl flex items-center gap-2">
            <i data-lucide="save" class="w-5 h-5"></i>
            <span>Simpan Semua Perubahan</span>
        </button>
    </div>

</form>

<script>
    function previewImageFile(input, targetImgId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(targetImgId);
                const defaultBadge = document.getElementById('logoDefaultBadge');
                if (img) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                }
                if (defaultBadge) {
                    defaultBadge.classList.add('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
