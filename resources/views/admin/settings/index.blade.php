@extends('admin.layouts.admin')

@section('title', 'Pengaturan Konten Website')
@section('page_title', 'Pengaturan Website & Teks Hero')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8 max-w-5xl">
    @csrf

    <!-- 1. General & Top Bar Settings -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
        <div class="border-b border-slate-100 pb-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="globe" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Identitas Website & Top Announcement Bar</h3>
                <p class="text-xs text-slate-500">Nama lembaga, logo subtitle, dan teks pengumuman di bagian paling atas website</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Lembaga (Brand)</label>
                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'LPK Sahabat Jepang Indonesia' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Tagline / Subtitle Brand</label>
                <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? '友好日本インドネシア • Penyalur Resmi RI' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Badge Pengumuman Atas</label>
                <input type="text" name="announcement_badge" value="{{ $settings['announcement_badge'] ?? 'Batch Baru 2026 Dibuka' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Teks Pengumuman Promo / Batch</label>
                <input type="text" name="announcement_text" value="{{ $settings['announcement_text'] ?? '🌸 Pendaftaran Gelombang Khusus Tokutei Ginou & Magang Jepang Telah Dibuka! Kuota Terbatas.' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>
        </div>
    </div>

    <!-- 2. Hero Section Settings -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
        <div class="border-b border-slate-100 pb-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="sparkles" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Konten Hero Section (Beranda Utama)</h3>
                <p class="text-xs text-slate-500">Judul utama (headline), sub-judul penjelas, dan gambar banner depan</p>
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

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">URL Gambar Utama Hero</label>
                <input type="text" name="hero_image" value="{{ $settings['hero_image'] ?? 'https://images.unsplash.com/photo-1528164344705-475426879c0d?auto=format&fit=crop&w=900&q=80' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                <p class="text-[11px] text-slate-400">Masukkan link URL gambar yang ingin ditampilkan di kartu visual hero beranda.</p>
            </div>
        </div>
    </div>

    <!-- 3. Stat Counters Settings -->
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

    <!-- 4. Contact & Footer Settings -->
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
@endsection
