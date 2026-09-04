@extends('admin.layouts.admin')

@section('title', 'Pengaturan Konten Website & Logo')
@section('page_title', 'Pengaturan Website & Logo Header')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8 max-w-5xl">
    @csrf

    <!-- Quick Sticky Navigation Sub-Bar -->
    <div class="sticky top-0 z-30 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-2.5 bg-slate-100/95 backdrop-blur-md border-b border-slate-200/80 mb-6 flex items-center justify-between gap-3 overflow-x-auto select-none">
        <div class="flex items-center gap-2 flex-nowrap min-w-max text-xs font-bold">
            <a href="#sec-logo" class="setting-pill px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-japan-400 hover:text-japan-600 text-slate-700 transition flex items-center gap-1.5 shadow-2xs">
                <i data-lucide="image" class="w-3.5 h-3.5 text-japan-600"></i>
                <span>Logo & Brand</span>
            </a>
            <a href="#sec-hero" class="setting-pill px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-japan-400 hover:text-japan-600 text-slate-700 transition flex items-center gap-1.5 shadow-2xs">
                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-500"></i>
                <span>Hero & Banner</span>
            </a>
            <a href="#sec-stats" class="setting-pill px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-japan-400 hover:text-japan-600 text-slate-700 transition flex items-center gap-1.5 shadow-2xs">
                <i data-lucide="bar-chart-2" class="w-3.5 h-3.5 text-blue-500"></i>
                <span>Statistik</span>
            </a>
            <a href="#sec-contact" class="setting-pill px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-japan-400 hover:text-japan-600 text-slate-700 transition flex items-center gap-1.5 shadow-2xs">
                <i data-lucide="phone" class="w-3.5 h-3.5 text-emerald-500"></i>
                <span>Kontak & CS</span>
            </a>
            <a href="#sec-ticker" class="setting-pill px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-japan-400 hover:text-japan-600 text-slate-700 transition flex items-center gap-1.5 shadow-2xs">
                <i data-lucide="bell" class="w-3.5 h-3.5 text-purple-500"></i>
                <span>Social Proof Ticker</span>
            </a>
            <a href="#sec-fonnte" class="setting-pill px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-emerald-400 hover:text-emerald-700 text-slate-700 transition flex items-center gap-1.5 shadow-2xs">
                <i data-lucide="message-square-code" class="w-3.5 h-3.5 text-emerald-600"></i>
                <span>WhatsApp Fonnte</span>
                @if(($settings['fonnte_enabled'] ?? '0') === '1' && !empty($settings['fonnte_api_token']))
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                @endif
            </a>
        </div>

        <button type="submit" class="px-4 py-1.5 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm flex-shrink-0">
            <i data-lucide="save" class="w-3.5 h-3.5"></i>
            <span>Simpan</span>
        </button>
    </div>

    <!-- 1. Logo & Brand Identity Settings (Base64 LONGTEXT) -->
    <div id="sec-logo" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6 scroll-mt-20">
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
    <div id="sec-announcement" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 scroll-mt-20">
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
    <div id="sec-hero" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 scroll-mt-20">
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
    <div id="sec-stats" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 scroll-mt-20">
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
    <div id="sec-contact" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 scroll-mt-20">
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

    <!-- 6. Bottom-Left Pop-Up Notification (Live Social Proof Ticker) Settings -->
    @php
        $defaultTickerItems = [
            [
                'icon' => '🌸',
                'title' => 'CoE Resmi Terbit!',
                'desc' => 'Siswa Budi Santoso (Kaigo Tokyo) baru saja terbit Certificate of Eligibility.',
                'time' => '2m lalu'
            ],
            [
                'icon' => '📥',
                'title' => 'Brosur 2026 Terunduh',
                'desc' => '1 Calon siswa asal Jawa Timur baru saja mengunduh Katalog Biaya Resmi.',
                'time' => '5m lalu'
            ],
            [
                'icon' => '🎉',
                'title' => 'Lolos Wawancara Kaisha',
                'desc' => '3 Siswa lulusan Poltekkes lolos seleksi user rumah sakit lansia di Osaka.',
                'time' => '12m lalu'
            ],
            [
                'icon' => '✈️',
                'title' => 'Terbang ke Narita',
                'desc' => 'Peserta Gelombang 4 SMILE Project (Poltekkes MoU) sukses bertolak ke Jepang hari ini.',
                'time' => '24m lalu'
            ],
            [
                'icon' => '📝',
                'title' => 'Tryout JLPT CBT Online',
                'desc' => 'Seorang siswa meraih nilai 96/100 (合格 - Lulus) simulasi JLPT N4.',
                'time' => '38m lalu'
            ],
            [
                'icon' => '🤝',
                'title' => 'MoU Kampus Baru',
                'desc' => 'LPK SJI meresmikan kerjasama beasiswa Kaigo dengan Poltekkes Kemenkes.',
                'time' => '1j lalu'
            ]
        ];
        $activeTickerItems = $defaultTickerItems;
        if (!empty($settings['popup_ticker_items'])) {
            $decoded = json_decode($settings['popup_ticker_items'], true);
            if (is_array($decoded) && count($decoded) > 0) {
                $activeTickerItems = $decoded;
            }
        }
    @endphp
    <div id="sec-ticker" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6 scroll-mt-20">
        <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    <i data-lucide="bell-ring" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Notifikasi Pop-up Aktivitas (Pojok Kiri Bawah)</h3>
                    <p class="text-xs text-slate-500">Atur kemunculan, jeda interval, serta seluruh isi pesan notifikasi melayang (Social Proof Ticker) di website pengunjung</p>
                </div>
            </div>

            <!-- Master Toggle Switch -->
            <label class="inline-flex items-center gap-2 cursor-pointer bg-slate-50 hover:bg-slate-100 px-4 py-2 rounded-xl border border-slate-200 transition select-none">
                <input type="checkbox" name="popup_ticker_enabled" value="1" {{ ($settings['popup_ticker_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="sr-only peer">
                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600 relative"></div>
                <span class="text-xs font-black text-slate-800 uppercase tracking-wider">Aktifkan Pop-up</span>
            </label>
        </div>

        <!-- Interval and Settings -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            <div class="md:col-span-4 space-y-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Jeda Interval Kemunculan (Detik)</label>
                    <div class="flex items-center gap-2">
                        <input type="number" name="popup_ticker_interval" value="{{ $settings['popup_ticker_interval'] ?? '28' }}" min="5" max="180" class="w-28 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold text-center">
                        <span class="text-xs text-slate-500 font-medium">detik (Default: 28s)</span>
                    </div>
                    <p class="text-[10px] text-slate-400">Jeda waktu antar notifikasi muncul bergantian di layar pengunjung.</p>
                </div>

                <!-- Live Preview Card -->
                <div class="p-4 rounded-2xl bg-slate-900 text-white space-y-2.5 shadow-lg border border-slate-800">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black uppercase text-amber-400 tracking-wider">Live Preview di Layar Pengunjung</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    </div>
                    
                    <div id="tickerPreviewCard" class="p-3 rounded-xl bg-white/95 text-slate-900 border border-red-200 shadow-xl flex items-start gap-2.5 relative overflow-hidden select-none">
                        <div id="previewIcon" class="w-7 h-7 rounded-lg bg-red-100 flex items-center justify-center text-sm flex-shrink-0 mt-0.5">
                            🌸
                        </div>
                        <div class="flex-1 min-w-0 pr-3">
                            <div class="flex items-center justify-between gap-1">
                                <span id="previewTitle" class="text-[9px] font-black uppercase text-japan-700 tracking-wider font-mono">CoE Resmi Terbit!</span>
                                <span id="previewTime" class="text-[8px] text-slate-400 font-medium">2m lalu</span>
                            </div>
                            <p id="previewDesc" class="text-[11px] text-slate-700 leading-snug mt-0.5 font-medium">Siswa Budi Santoso (Kaigo Tokyo) baru saja terbit Certificate of Eligibility.</p>
                        </div>
                        <span class="text-slate-300 text-xs absolute top-1 right-1">&times;</span>
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-100">
                            <div class="h-full bg-japan-600 w-2/3"></div>
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 text-center">Tampil melayang di pojok kiri bawah perangkat desktop & mobile.</p>
                </div>
            </div>

            <!-- Repeater / List Editor -->
            <div class="md:col-span-8 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider">Daftar Isi Notifikasi Pop-Up</h4>
                        <p class="text-[11px] text-slate-400">Notifikasi akan dirotasi secara otomatis satu per satu.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="resetToDefaultTicker()" class="text-[11px] font-bold text-slate-500 hover:text-slate-800 px-3 py-1.5 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 transition">
                            Reset Default
                        </button>
                        <button type="button" onclick="addNewTickerItem()" class="text-[11px] font-bold text-white px-3 py-1.5 rounded-lg bg-japan-600 hover:bg-japan-700 transition flex items-center gap-1 shadow-xs">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Tambah Item</span>
                        </button>
                    </div>
                </div>

                <!-- Hidden Input Containing JSON String -->
                <input type="hidden" name="popup_ticker_items" id="popupTickerItemsInput" value="{{ json_encode($activeTickerItems, JSON_UNESCAPED_UNICODE) }}">

                <!-- Dynamic Item Container -->
                <div id="tickerItemsContainer" class="space-y-3 max-h-[500px] overflow-y-auto pr-1">
                    <!-- Javascript will render rows here -->
                </div>
            </div>
        </div>
    </div>

    <!-- 7. WhatsApp Gateway API (Fonnte) Settings (No .ENV Needed) -->
    <div id="sec-fonnte" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6 scroll-mt-20">
        <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold shadow-xs">
                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-extrabold text-slate-900 text-base">Integrasi WhatsApp Gateway API (Fonnte)</h3>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase tracking-wider">No .ENV Needed</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">Kirim pesan notifikasi otomatis langsung dari database tanpa perlu mengedit file environment server</p>
                </div>
            </div>

            <!-- Active Status Badge -->
            <div class="flex items-center gap-2">
                @if(($settings['fonnte_enabled'] ?? '0') === '1' && !empty($settings['fonnte_api_token']))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Gateway Aktif (Auto-Dispatch)</span>
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-600 border border-slate-200 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                        <span>Mode Manual (Direct Link & Log)</span>
                    </span>
                @endif
            </div>
        </div>

        <!-- Toggle Switch -->
        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between gap-4">
            <div class="space-y-0.5">
                <label for="fonnteEnabledCheckbox" class="text-xs font-bold text-slate-800 cursor-pointer flex items-center gap-2">
                    <span>Aktifkan Pengiriman WhatsApp Otomatis via Fonnte</span>
                </label>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Bila diaktifkan, setiap calon siswa yang mengunduh brosur atau mengisi form konsultasi akan langsung menerima WhatsApp otomatis di nomor mereka.
                </p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                <input 
                    type="checkbox" 
                    id="fonnteEnabledCheckbox" 
                    name="fonnte_enabled" 
                    value="1" 
                    class="sr-only peer"
                    {{ ($settings['fonnte_enabled'] ?? '0') === '1' ? 'checked' : '' }}
                >
                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
            </label>
        </div>

        <!-- Token & Credentials Form -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
            
            <!-- API Token Field (Span 8) -->
            <div class="md:col-span-8 space-y-1.5">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-slate-700 uppercase">
                        Fonnte Device API Token <span class="text-rose-500">*</span>
                    </label>
                    <a href="https://fonnte.com" target="_blank" class="text-[11px] font-bold text-emerald-600 hover:underline flex items-center gap-1">
                        <span>Buka Dashboard Fonnte</span>
                        <i data-lucide="external-link" class="w-3 h-3"></i>
                    </a>
                </div>
                <div class="relative">
                    <input 
                        type="password" 
                        id="fonnteApiTokenInput"
                        name="fonnte_api_token" 
                        value="{{ $settings['fonnte_api_token'] ?? '' }}" 
                        placeholder="Contoh: p6V...#8s@aQzX9" 
                        class="w-full pl-4 pr-12 py-2.5 rounded-xl border border-slate-200 text-xs font-mono font-bold bg-white focus:outline-none focus:border-emerald-600 shadow-2xs"
                    >
                    <button 
                        type="button" 
                        onclick="toggleTokenVisibility()"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1"
                        title="Tampilkan / Sembunyikan Token"
                    >
                        <i id="tokenEyeIcon" data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                </div>
                <p class="text-[10px] text-slate-400">
                    Token disimpan aman di database. Anda tidak perlu mengubah berkas <code>.env</code> di server.
                </p>
            </div>

            <!-- Country Code Field (Span 4) -->
            <div class="md:col-span-4 space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kode Negara Default</label>
                <div class="relative">
                    <input 
                        type="text" 
                        name="fonnte_country_code" 
                        value="{{ $settings['fonnte_country_code'] ?? '62' }}" 
                        placeholder="62" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold font-mono focus:outline-none focus:border-emerald-600"
                    >
                </div>
                <p class="text-[10px] text-slate-400">Standar Indonesia: <b>62</b> (otomatis mengubah 0812 ke 62812)</p>
            </div>

        </div>

        <!-- Interactive Fonnte Diagnostic & Test Box -->
        <div class="p-5 rounded-2xl bg-emerald-50/50 border border-emerald-200/80 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="activity" class="w-4 h-4 text-emerald-600"></i>
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider">Uji Koneksi & Status Device Fonnte</h4>
                </div>
                <button 
                    type="button" 
                    onclick="checkFonnteDeviceStatus()" 
                    class="px-3 py-1.5 rounded-xl bg-white border border-emerald-300 text-emerald-700 hover:bg-emerald-50 text-[11px] font-bold transition flex items-center gap-1.5 shadow-2xs"
                >
                    <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                    <span>Cek Status Device</span>
                </button>
            </div>

            <!-- Diagnostic Input & Button -->
            <div class="flex flex-col sm:flex-row items-center gap-2.5">
                <div class="relative flex-1 w-full">
                    <i data-lucide="phone" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        id="testFonnteTargetPhone" 
                        placeholder="Masukkan nomor WA uji coba (contoh: 08123456789)..." 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold bg-white focus:outline-none focus:border-emerald-600 font-mono"
                    >
                </div>
                <button 
                    type="button" 
                    id="btnSendTestFonnte"
                    onclick="sendTestFonnteMessage()" 
                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm flex-shrink-0"
                >
                    <i data-lucide="send" class="w-3.5 h-3.5"></i>
                    <span>Kirim Pesan Uji Coba</span>
                </button>
            </div>

            <!-- Diagnostic Live Response Output Box -->
            <div id="fonnteTestResultBox" class="hidden p-3.5 rounded-xl text-xs space-y-1 transition-all">
                <!-- Result will be inserted here -->
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

    /* ==========================================================
       POP-UP TICKER (SOCIAL PROOF) INTERACTIVE REPEATER
       ========================================================== */
    const defaultTickerItemsList = @json($defaultTickerItems);
    let tickerItems = [];

    try {
        const rawJson = document.getElementById('popupTickerItemsInput').value;
        tickerItems = JSON.parse(rawJson);
        if (!Array.isArray(tickerItems) || tickerItems.length === 0) {
            tickerItems = [...defaultTickerItemsList];
        }
    } catch (e) {
        tickerItems = [...defaultTickerItemsList];
    }

    function renderTickerRows() {
        const container = document.getElementById('tickerItemsContainer');
        if (!container) return;

        if (tickerItems.length === 0) {
            container.innerHTML = `
                <div class="p-6 text-center rounded-2xl border-2 border-dashed border-slate-200 text-slate-400">
                    <p class="text-xs">Belum ada item notifikasi. Klik tombol <b>+ Tambah Item</b> atau <b>Reset Default</b>.</p>
                </div>
            `;
            syncTickerJson();
            return;
        }

        container.innerHTML = tickerItems.map((item, idx) => `
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2.5 relative group hover:border-japan-300 transition">
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-japan-100 text-japan-700 text-[10px] font-black flex items-center justify-center">${idx + 1}</span>
                        <!-- Quick Emoji Selector -->
                        <div class="flex items-center gap-1">
                            <input 
                                type="text" 
                                value="${item.icon || '🌸'}" 
                                maxlength="4"
                                oninput="updateTickerItem(${idx}, 'icon', this.value)"
                                class="w-10 h-8 text-center text-base rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-japan-600 shadow-2xs"
                                title="Icon / Emoji"
                            >
                            <div class="flex items-center gap-0.5">
                                ${['🌸', '📥', '🎉', '✈️', '📝', '🤝', '🏥', '💼'].map(em => `
                                    <button type="button" onclick="updateTickerItem(${idx}, 'icon', '${em}')" class="text-xs p-1 rounded hover:bg-white text-slate-600 transition">
                                        ${em}
                                    </button>
                                `).join('')}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Waktu:</span>
                            <input 
                                type="text" 
                                value="${item.time || '2m lalu'}" 
                                oninput="updateTickerItem(${idx}, 'time', this.value)"
                                placeholder="2m lalu"
                                class="w-20 px-2 py-1 text-[11px] rounded-lg border border-slate-200 bg-white font-medium focus:outline-none focus:border-japan-600"
                            >
                        </div>
                        <button type="button" onclick="deleteTickerItem(${idx})" class="text-slate-400 hover:text-red-600 p-1 rounded-lg hover:bg-red-50 transition" title="Hapus Notifikasi">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
                    <div class="sm:col-span-4">
                        <input 
                            type="text" 
                            value="${item.title || ''}" 
                            oninput="updateTickerItem(${idx}, 'title', this.value)"
                            placeholder="Judul (e.g. CoE Resmi Terbit!)"
                            class="w-full px-3 py-1.5 text-xs font-bold rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-japan-600 text-japan-700 font-mono"
                        >
                    </div>
                    <div class="sm:col-span-8">
                        <input 
                            type="text" 
                            value="${item.desc || ''}" 
                            oninput="updateTickerItem(${idx}, 'desc', this.value)"
                            placeholder="Rincian deskripsi notifikasi..."
                            class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-japan-600 text-slate-700"
                        >
                    </div>
                </div>
            </div>
        `).join('');

        if (window.lucide) {
            lucide.createIcons();
        }

        syncTickerJson();
        updateLivePreview();
    }

    function updateTickerItem(idx, key, val) {
        if (tickerItems[idx]) {
            tickerItems[idx][key] = val;
            syncTickerJson();
            if (idx === 0) updateLivePreview();
        }
    }

    function addNewTickerItem() {
        tickerItems.push({
            icon: '🎉',
            title: 'Siswa Baru Lolos!',
            desc: 'Calon kandidat sukses menyelesaikan tahap wawancara kerja.',
            time: 'Baru saja'
        });
        renderTickerRows();
    }

    function deleteTickerItem(idx) {
        if (confirm('Hapus item notifikasi ini?')) {
            tickerItems.splice(idx, 1);
            renderTickerRows();
        }
    }

    function resetToDefaultTicker() {
        if (confirm('Kembalikan ke 6 notifikasi pop-up default bawaan?')) {
            tickerItems = JSON.parse(JSON.stringify(defaultTickerItemsList));
            renderTickerRows();
        }
    }

    function syncTickerJson() {
        const input = document.getElementById('popupTickerItemsInput');
        if (input) {
            input.value = JSON.stringify(tickerItems);
        }
    }

    function updateLivePreview() {
        if (tickerItems.length > 0) {
            const first = tickerItems[0];
            const pIcon = document.getElementById('previewIcon');
            const pTitle = document.getElementById('previewTitle');
            const pDesc = document.getElementById('previewDesc');
            const pTime = document.getElementById('previewTime');
            if (pIcon) pIcon.textContent = first.icon || '🌸';
            if (pTitle) pTitle.textContent = first.title || 'Judul Notifikasi';
            if (pDesc) pDesc.textContent = first.desc || 'Deskripsi notifikasi';
            if (pTime) pTime.textContent = first.time || 'Baru saja';
        }
    }

    /* ==========================================================
       FONNTE WHATSAPP GATEWAY DIAGNOSTICS & HELPERS
       ========================================================== */
    function toggleTokenVisibility() {
        const input = document.getElementById('fonnteApiTokenInput');
        const icon = document.getElementById('tokenEyeIcon');
        if (!input) return;
        if (input.type === 'password') {
            input.type = 'text';
            if (icon) icon.setAttribute('data-lucide', 'eye-off');
        } else {
            input.type = 'password';
            if (icon) icon.setAttribute('data-lucide', 'eye');
        }
        if (window.lucide) lucide.createIcons();
    }

    async function checkFonnteDeviceStatus() {
        const resultBox = document.getElementById('fonnteTestResultBox');
        if (!resultBox) return;

        resultBox.classList.remove('hidden', 'bg-emerald-50', 'text-emerald-900', 'border-emerald-300', 'bg-rose-50', 'text-rose-900', 'border-rose-300');
        resultBox.classList.add('block', 'bg-blue-50', 'text-blue-900', 'border', 'border-blue-200');
        resultBox.innerHTML = `
            <div class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span class="font-bold">Memeriksa status perangkat ke server Fonnte...</span>
            </div>
        `;

        try {
            const res = await fetch("{{ route('admin.settings.device.fonnte') }}", {
                headers: {
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();

            resultBox.classList.remove('bg-blue-50', 'text-blue-900', 'border-blue-200');

            if (data.success) {
                resultBox.classList.add('bg-emerald-50', 'text-emerald-900', 'border', 'border-emerald-300');
                const dev = data.device || {};
                resultBox.innerHTML = `
                    <div class="flex items-start gap-2">
                        <span class="font-bold text-emerald-700">✓ Berhasil:</span>
                        <div>
                            <p class="font-bold">${data.message || 'Perangkat terhubung aktif'}</p>
                            ${dev.device ? `<p class="text-[11px] text-emerald-800">Nomor Perangkat: <b>${dev.device}</b> | Kuota: <b>${dev.quota ?? 'Aktif'}</b></p>` : ''}
                        </div>
                    </div>
                `;
            } else {
                resultBox.classList.add('bg-rose-50', 'text-rose-900', 'border', 'border-rose-300');
                resultBox.innerHTML = `
                    <div class="flex items-start gap-2">
                        <span class="font-bold text-rose-700">✕ Gagal:</span>
                        <div>
                            <p class="font-bold">${data.message || 'Gagal menghubungi perangkat Fonnte'}</p>
                            <p class="text-[11px] text-rose-700 mt-0.5">Pastikan token API Fonnte telah disimpan dan perangkat di web Fonnte berstatus <em>Connected</em>.</p>
                        </div>
                    </div>
                `;
            }
        } catch (err) {
            resultBox.classList.remove('bg-blue-50', 'text-blue-900', 'border-blue-200');
            resultBox.classList.add('bg-rose-50', 'text-rose-900', 'border', 'border-rose-300');
            resultBox.innerHTML = `
                <span class="font-bold text-rose-700">✕ Error:</span> ${err.message || 'Terjadi kesalahan sistem'}
            `;
        }
    }

    async function sendTestFonnteMessage() {
        const phoneInput = document.getElementById('testFonnteTargetPhone');
        const tokenInput = document.getElementById('fonnteApiTokenInput');
        const resultBox = document.getElementById('fonnteTestResultBox');
        const sendBtn = document.getElementById('btnSendTestFonnte');
        
        const targetPhone = phoneInput ? phoneInput.value.trim() : '';
        const currentToken = tokenInput ? tokenInput.value.trim() : '';

        if (!targetPhone) {
            alert('Silakan masukkan nomor WhatsApp tujuan uji coba terlebih dahulu.');
            if (phoneInput) phoneInput.focus();
            return;
        }

        if (sendBtn) {
            sendBtn.disabled = true;
            sendBtn.classList.add('opacity-70', 'cursor-not-allowed');
        }

        resultBox.classList.remove('hidden', 'bg-emerald-50', 'text-emerald-900', 'border-emerald-300', 'bg-rose-50', 'text-rose-900', 'border-rose-300');
        resultBox.classList.add('block', 'bg-blue-50', 'text-blue-900', 'border', 'border-blue-200');
        resultBox.innerHTML = `
            <div class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span class="font-bold">Mengirim pesan uji coba ke ${targetPhone}...</span>
            </div>
        `;

        try {
            const res = await fetch("{{ route('admin.settings.test.fonnte') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    target_phone: targetPhone,
                    token: currentToken
                })
            });

            const data = await res.json();
            resultBox.classList.remove('bg-blue-50', 'text-blue-900', 'border-blue-200');

            if (data.success) {
                resultBox.classList.add('bg-emerald-50', 'text-emerald-900', 'border', 'border-emerald-300');
                resultBox.innerHTML = `
                    <div class="flex items-start gap-2">
                        <span class="font-bold text-emerald-700">✓ Pesan Terkirim:</span>
                        <div>
                            <p class="font-bold">${data.message || 'Pesan uji coba WhatsApp berhasil dikirim!'}</p>
                            <p class="text-[11px] text-emerald-800 mt-0.5">Silakan periksa aplikasi WhatsApp di nomor penerima.</p>
                        </div>
                    </div>
                `;
            } else {
                resultBox.classList.add('bg-rose-50', 'text-rose-900', 'border', 'border-rose-300');
                resultBox.innerHTML = `
                    <div class="flex items-start gap-2">
                        <span class="font-bold text-rose-700">✕ Pengiriman Gagal:</span>
                        <div>
                            <p class="font-bold">${data.message || 'Gagal mengirim pesan uji coba'}</p>
                            <p class="text-[11px] text-rose-700 mt-0.5">Pastikan token valid dan nomor tujuan terdaftar di WhatsApp.</p>
                        </div>
                    </div>
                `;
            }
        } catch (err) {
            resultBox.classList.remove('bg-blue-50', 'text-blue-900', 'border-blue-200');
            resultBox.classList.add('bg-rose-50', 'text-rose-900', 'border', 'border-rose-300');
            resultBox.innerHTML = `
                <span class="font-bold text-rose-700">✕ Error:</span> ${err.message || 'Terjadi kesalahan sistem saat menghubungi server.'}
            `;
        } finally {
            if (sendBtn) {
                sendBtn.disabled = false;
                sendBtn.classList.remove('opacity-70', 'cursor-not-allowed');
            }
        }
    }

    /* ==========================================================
       STICKY SUB-NAV SCROLLSPY
       ========================================================== */
    function initSettingScrollspy() {
        const pills = document.querySelectorAll('.setting-pill');
        const sections = ['sec-logo', 'sec-hero', 'sec-stats', 'sec-contact', 'sec-ticker', 'sec-fonnte']
            .map(id => document.getElementById(id))
            .filter(Boolean);

        const scrollContainer = document.querySelector('main') || window;

        function onScroll() {
            let currentSecId = sections[0] ? sections[0].id : '';
            const offset = 180;
            sections.forEach(sec => {
                const rect = sec.getBoundingClientRect();
                if (rect.top <= offset) {
                    currentSecId = sec.id;
                }
            });

            pills.forEach(pill => {
                const href = pill.getAttribute('href');
                if (href === '#' + currentSecId) {
                    pill.classList.add('bg-japan-50', 'border-japan-500', 'text-japan-700', 'font-black', 'ring-1', 'ring-japan-400');
                    pill.classList.remove('bg-white', 'text-slate-700', 'border-slate-200');
                } else {
                    pill.classList.remove('bg-japan-50', 'border-japan-500', 'text-japan-700', 'font-black', 'ring-1', 'ring-japan-400');
                    pill.classList.add('bg-white', 'text-slate-700', 'border-slate-200');
                }
            });
        }

        scrollContainer.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderTickerRows();
        initSettingScrollspy();
    });
</script>
@endsection
