@extends('admin.layouts.admin')

@section('title', 'Pengaturan Konten Website & Logo')
@section('page_title', 'Pengaturan Website & Logo Header')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8 max-w-5xl">
    @csrf

    <!-- Quick Sticky Navigation Sub-Bar (Docked right below h-16 Topbar) -->
    <div class="sticky top-16 z-20 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-2.5 bg-slate-100/95 backdrop-blur-md border-b border-slate-200/80 mb-6 flex items-center justify-between gap-3 overflow-x-auto select-none shadow-xs">
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
    <div id="sec-logo" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6 scroll-mt-32">
        <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="image" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Logo Website (Header & Footer)</h3>
                    <p class="text-xs text-slate-500">Ubah logo brand website yang tampil di header atas dan footer (disimpan sebagai Base64)</p>
                </div>
            </div>

            <!-- Brand Mini Live Simulation Pill -->
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-xs shadow-2xs">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Simulasi Header:</span>
                <div class="flex items-center gap-2 font-black text-slate-800">
                    <div class="h-6 w-6 rounded-lg bg-japan-600 text-white flex items-center justify-center font-japanese text-xs overflow-hidden" id="headerSimBox">
                        @if(!empty($settings['site_logo']))
                            <img id="headerSimImg" src="{{ $settings['site_logo'] }}" class="h-full w-full object-contain" alt="Logo">
                        @else
                            <span id="headerSimKanji">友</span>
                        @endif
                    </div>
                    <div class="text-left leading-tight">
                        <span id="previewBrandName" class="block font-black text-xs text-slate-800">{{ $settings['site_name'] ?? 'SAHABAT JEPANG' }}</span>
                        <span id="previewBrandTagline" class="block text-[9px] text-slate-400 font-medium">{{ $settings['site_tagline'] ?? 'Penyalur Resmi Kemenaker' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            
            <!-- Logo Preview Box -->
            <div class="md:col-span-4 p-5 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col items-center justify-center text-center space-y-3">
                <div class="flex items-center justify-between w-full">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Preview Logo Aktif</p>
                    <button 
                        type="button" 
                        onclick="resetToDefaultLogoBadge()" 
                        class="text-[10px] font-bold text-slate-500 hover:text-japan-600 transition underline decoration-slate-300"
                        title="Kembalikan ke badge kanji default 友"
                    >
                        Gunakan Default 友
                    </button>
                </div>
                <div class="h-24 w-full flex items-center justify-center bg-white p-2 rounded-xl border border-slate-200 shadow-inner overflow-hidden relative">
                    <img 
                        id="logoPreviewImg" 
                        src="{{ $settings['site_logo'] ?? '' }}" 
                        alt="Logo LPK" 
                        class="max-h-full max-w-full object-contain {{ empty($settings['site_logo']) ? 'hidden' : '' }}"
                    >
                    <div id="logoDefaultBadge" class="flex items-center gap-2.5 {{ !empty($settings['site_logo']) ? 'hidden' : '' }}">
                        <div class="w-12 h-12 rounded-2xl bg-japan-600 text-white flex items-center justify-center font-japanese font-black text-xl shadow-sm">
                            友
                        </div>
                        <div class="text-left">
                            <span class="block font-black text-slate-800 text-xs">Badge Default</span>
                            <span class="block text-[10px] text-slate-400 font-medium font-japanese">Kanji 友 (Tomo - Sahabat)</span>
                        </div>
                    </div>
                </div>
                <p class="text-[10px] text-slate-400">Format: PNG transparan, JPG, WEBP, atau SVG</p>
            </div>

            <!-- Upload & Input Controls -->
            <div class="md:col-span-8 space-y-4">
                
                <!-- Drag and Drop Dropzone -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">1. Unggah File Logo Baru (Drag & Drop atau Klik)</label>
                    <div 
                        id="logoDropZone" 
                        class="border-2 border-dashed border-slate-200 hover:border-japan-400 bg-slate-50/60 hover:bg-japan-50/20 rounded-2xl p-4 transition text-center cursor-pointer relative group"
                    >
                        <input 
                            type="file" 
                            id="siteLogoFileInput"
                            name="site_logo_file" 
                            accept="image/*" 
                            onchange="previewImageFile(this, 'logoPreviewImg')"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                        >
                        <div class="flex flex-col items-center justify-center space-y-1.5 pointer-events-none">
                            <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-japan-600 flex items-center justify-center group-hover:scale-110 transition shadow-2xs">
                                <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-700">Tarik & Lepaskan file logo di sini, atau <span class="text-japan-600 underline">pilih berkas</span></p>
                                <p id="logoFileFeedback" class="text-[10px] text-slate-400 mt-0.5">Maksimal 2 MB (Otomatis dikonversi ke Base64 format aman)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">2. Atau Masukkan URL / Data Base64 Manual</label>
                    <input 
                        type="text" 
                        id="siteLogoTextInput"
                        name="site_logo" 
                        value="{{ $settings['site_logo'] ?? '' }}" 
                        placeholder="https://... atau data:image/png;base64,..." 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-mono"
                    >
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase">Nama Brand Header</label>
                        <input 
                            type="text" 
                            id="inputSiteName"
                            name="site_name" 
                            value="{{ $settings['site_name'] ?? 'SAHABAT JEPANG' }}" 
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-bold"
                        >
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase">Tagline / Subtitle Header</label>
                        <input 
                            type="text" 
                            id="inputSiteTagline"
                            name="site_tagline" 
                            value="{{ $settings['site_tagline'] ?? 'Penyalur Resmi Kemenaker' }}" 
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"
                        >
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- 2. Top Announcement Bar Settings -->
    <div id="sec-announcement" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 scroll-mt-32">
        <div class="border-b border-slate-100 pb-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="megaphone" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Top Announcement Bar (Banner Pengumuman Atas)</h3>
                <p class="text-xs text-slate-500">Teks berjalan atau promosi yang berada di paling atas website</p>
            </div>
        </div>

        <!-- Live Announcement Bar Preview Mockup -->
        <div class="rounded-xl bg-gradient-to-r from-slate-900 via-slate-850 to-slate-900 text-white p-3 border border-slate-800 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2.5 flex-wrap">
                <span id="previewAnnouncementBadge" class="px-2.5 py-0.5 rounded-full bg-japan-600 text-white font-bold text-[10px] tracking-wide shadow-2xs">
                    {{ $settings['announcement_badge'] ?? 'Batch Baru 2026 Dibuka' }}
                </span>
                <span id="previewAnnouncementText" class="text-slate-200 font-medium text-xs">
                    {{ $settings['announcement_text'] ?? '🌸 Pendaftaran Gelombang Khusus Tokutei Ginou & Magang Jepang Telah Dibuka! Kuota Terbatas.' }}
                </span>
            </div>
            <span class="text-[10px] text-slate-400 font-semibold bg-slate-800/80 px-2 py-0.5 rounded-md flex-shrink-0 border border-slate-700 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-japan-500 animate-pulse"></span>
                Live Top Bar Preview
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Badge Label</label>
                <input 
                    type="text" 
                    id="inputAnnouncementBadge"
                    name="announcement_badge" 
                    value="{{ $settings['announcement_badge'] ?? 'Batch Baru 2026 Dibuka' }}" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold"
                >
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Teks Pengumuman Promo / Batch</label>
                <input 
                    type="text" 
                    id="inputAnnouncementText"
                    name="announcement_text" 
                    value="{{ $settings['announcement_text'] ?? '🌸 Pendaftaran Gelombang Khusus Tokutei Ginou & Magang Jepang Telah Dibuka! Kuota Terbatas.' }}" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600"
                >
            </div>
        </div>
    </div>

    <!-- 3. Hero Section Settings -->
    <div id="sec-hero" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6 scroll-mt-32">
        <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="sparkles" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Konten Hero Section (Beranda Utama)</h3>
                    <p class="text-xs text-slate-500">Judul utama (headline), sub-judul penjelas, dan gambar banner visual</p>
                </div>
            </div>
            
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-japan-50 text-japan-700 text-xs font-bold border border-japan-200 shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-japan-600 animate-pulse"></span>
                <span>Preview Interaktif Beranda</span>
            </div>
        </div>

        <!-- Live Hero Preview Banner (Interactive Frontend Mockup) -->
        <div class="rounded-3xl bg-gradient-to-br from-slate-900 via-slate-850 to-japan-950 p-6 sm:p-7 text-white border border-slate-700/80 shadow-xl relative overflow-hidden group">
            <!-- Background Kanji & Glow decoration -->
            <div class="absolute -right-10 -bottom-10 w-52 h-52 bg-japan-600/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute top-4 right-6 font-japanese text-4xl font-black text-white/5 select-none pointer-events-none">日本夢</div>
            
            <div class="flex items-center justify-between pb-3.5 border-b border-slate-700/60 mb-5">
                <div class="flex items-center gap-2 text-xs font-bold text-japan-300">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <i data-lucide="eye" class="w-3.5 h-3.5 text-emerald-400"></i>
                    <span class="tracking-wide">LIVE PREVIEW HERO BERANDA (FRONT-END)</span>
                </div>
                <span class="text-[10px] text-emerald-300 bg-emerald-950/80 px-2.5 py-0.5 rounded-full border border-emerald-800/80 flex items-center gap-1.5 font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Real-time Sync
                </span>
            </div>

            <!-- Mini Preview Render Canvas -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                <div class="lg:col-span-8 space-y-4">
                    <!-- Motto Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold text-japan-200">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                        <span class="font-japanese text-xs text-red-400 font-bold">夢をつかめ</span>
                        <span class="text-white/30">|</span>
                        <span id="previewHeroMotto" class="text-white font-medium">{{ $settings['hero_motto'] ?? 'LPK & SO Resmi Kemenaker RI' }}</span>
                    </div>

                    <!-- Headline -->
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-black tracking-tight leading-snug">
                        <span id="previewHeroTitle1" class="text-white">{{ $settings['hero_title_1'] ?? 'Jembatan Emas Menuju' }}</span> <br>
                        <span id="previewHeroTitleHighlight" class="bg-gradient-to-r from-red-400 via-rose-400 to-amber-300 bg-clip-text text-transparent">
                            {{ $settings['hero_title_highlight'] ?? 'Karir Gemilang di Jepang' }}
                        </span>
                    </h2>

                    <!-- Subtitle -->
                    <p id="previewHeroSubtitle" class="text-xs sm:text-sm text-slate-300 leading-relaxed line-clamp-3">
                        {{ $settings['hero_subtitle'] ?? 'Wujudkan impian berpenghasilan Rp 18 - 35 Juta/bulan di Jepang. Program Tokutei Ginou (SSW) & Magang Resmi dengan bimbingan bahasa intensif dari nol, asrama representatif, hingga penempatan kerja terpercaya di seluruh prefektur Jepang.' }}
                    </p>

                    <!-- Preview Action Buttons -->
                    <div class="flex items-center gap-2.5 pt-1 opacity-90 pointer-events-none select-none">
                        <div class="px-3.5 py-2 rounded-xl bg-japan-600 text-white text-xs font-bold shadow-xs flex items-center gap-1.5">
                            <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-200"></i>
                            <span>Mulai Konsultasi Gratis</span>
                        </div>
                        <div class="px-3.5 py-2 rounded-xl bg-white/10 text-white text-xs font-bold border border-white/15">
                            <span>Pilihan Program</span>
                        </div>
                    </div>
                </div>

                <!-- Mini Hero Banner Preview Thumbnail -->
                <div class="lg:col-span-4 flex flex-col items-center justify-center">
                    <div class="w-full h-40 rounded-2xl border border-slate-700/80 overflow-hidden bg-slate-800 relative group/thumb shadow-inner flex items-center justify-center">
                        <img 
                            id="previewHeroImg" 
                            src="{{ !empty($settings['hero_image']) ? $settings['hero_image'] : 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?auto=format&fit=crop&w=600&q=80' }}" 
                            alt="Banner Preview" 
                            class="w-full h-full object-cover opacity-85 group-hover/thumb:scale-105 transition-transform duration-500"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                        <span class="absolute bottom-2.5 left-2.5 text-[10px] font-bold text-slate-200 bg-slate-900/85 px-2.5 py-1 rounded-lg backdrop-blur-xs border border-slate-700/80 flex items-center gap-1">
                            <i data-lucide="image" class="w-3 h-3 text-japan-400"></i>
                            <span>Banner Visual Aktif</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4 pt-1">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Motto Badge Atas Judul</label>
                <input 
                    type="text" 
                    id="inputHeroMotto"
                    name="hero_motto" 
                    value="{{ $settings['hero_motto'] ?? 'LPK & SO Resmi Kemenaker RI' }}" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold"
                >
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Headline Bagian 1</label>
                    <input 
                        type="text" 
                        id="inputHeroTitle1"
                        name="hero_title_1" 
                        value="{{ $settings['hero_title_1'] ?? 'Jembatan Emas Menuju' }}" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold"
                    >
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Headline Teks Highlight (Merah Gradient)</label>
                    <input 
                        type="text" 
                        id="inputHeroTitleHighlight"
                        name="hero_title_highlight" 
                        value="{{ $settings['hero_title_highlight'] ?? 'Karir Gemilang di Jepang' }}" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold text-japan-600"
                    >
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Deskripsi / Subtitle Hero</label>
                <textarea 
                    id="inputHeroSubtitle"
                    name="hero_subtitle" 
                    rows="3" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 leading-relaxed"
                >{{ $settings['hero_subtitle'] ?? '' }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-1">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Upload Gambar Banner Hero (Base64)</label>
                    <input 
                        type="file" 
                        name="hero_image_file" 
                        accept="image/*" 
                        onchange="previewImageFile(this, 'previewHeroImg')"
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:outline-none focus:border-japan-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-japan-600 file:text-white hover:file:bg-japan-700 cursor-pointer"
                    >
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Atau URL Gambar Hero</label>
                    <input 
                        type="text" 
                        id="inputHeroImage"
                        name="hero_image" 
                        value="{{ $settings['hero_image'] ?? '' }}" 
                        placeholder="https://images.unsplash.com/..." 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-mono"
                    >
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Stat Counters Settings -->
    <div id="sec-stats" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6 scroll-mt-32">
        <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="bar-chart-2" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Angka Pencapaian (Statistik Banner)</h3>
                    <p class="text-xs text-slate-500">4 kotak statistik yang ditampilkan di bawah Hero beranda</p>
                </div>
            </div>

            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold border border-blue-200 shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                <span>Kalkulasi Otomatis Beranda</span>
            </div>
        </div>

        <!-- Live Stat Counter Preview Bar -->
        <div class="p-5 rounded-2xl bg-gradient-to-r from-slate-900 via-slate-850 to-slate-900 text-white border border-slate-800 shadow-lg space-y-3">
            <div class="flex items-center justify-between text-xs font-bold text-japan-300">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <i data-lucide="bar-chart-2" class="w-3.5 h-3.5 text-blue-400"></i>
                    <span class="tracking-wider">LIVE DISPLAY COUNTER BERANDA</span>
                </div>
                <span class="text-[10px] text-slate-400 bg-slate-800 px-2 py-0.5 rounded-full border border-slate-700">Format Live</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center">
                <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700/80 shadow-2xs">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">1. Alumni Berangkat</p>
                    <p id="previewStatAlumni" class="text-xl font-black text-white mt-1">
                        {{ ($settings['stat_alumni_count'] ?? '500') . ($settings['stat_alumni_suffix'] ?? '+') }}
                    </p>
                </div>
                <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700/80 shadow-2xs">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">2. Mitra Kaisha</p>
                    <p id="previewStatPartners" class="text-xl font-black text-white mt-1">
                        {{ ($settings['stat_partners_count'] ?? '50') . ($settings['stat_partners_suffix'] ?? '+') }}
                    </p>
                </div>
                <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700/80 shadow-2xs">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">3. Tingkat Lulus</p>
                    <p id="previewStatPass" class="text-xl font-black text-japan-400 mt-1">
                        {{ ($settings['stat_pass_rate_count'] ?? '98') . ($settings['stat_pass_rate_suffix'] ?? '%') }}
                    </p>
                </div>
                <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700/80 shadow-2xs">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">4. Legalitas</p>
                    <p id="previewStatLegal" class="text-xl font-black text-emerald-400 mt-1">
                        {{ ($settings['stat_legal_count'] ?? '100') . ($settings['stat_legal_suffix'] ?? '%') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-2 hover:border-japan-300 transition">
                <p class="text-[11px] font-extrabold text-slate-700">1. Alumni Berangkat</p>
                <input 
                    type="number" 
                    id="inputStatAlumniCount"
                    name="stat_alumni_count" 
                    value="{{ $settings['stat_alumni_count'] ?? '500' }}" 
                    class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-sm font-bold focus:outline-none focus:border-japan-600 bg-white"
                >
                <input 
                    type="text" 
                    id="inputStatAlumniSuffix"
                    name="stat_alumni_suffix" 
                    value="{{ $settings['stat_alumni_suffix'] ?? '+' }}" 
                    placeholder="Suffix (+)" 
                    class="w-full px-3 py-1 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-japan-600 bg-white"
                >
            </div>

            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-2 hover:border-japan-300 transition">
                <p class="text-[11px] font-extrabold text-slate-700">2. Mitra Kaisha</p>
                <input 
                    type="number" 
                    id="inputStatPartnersCount"
                    name="stat_partners_count" 
                    value="{{ $settings['stat_partners_count'] ?? '50' }}" 
                    class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-sm font-bold focus:outline-none focus:border-japan-600 bg-white"
                >
                <input 
                    type="text" 
                    id="inputStatPartnersSuffix"
                    name="stat_partners_suffix" 
                    value="{{ $settings['stat_partners_suffix'] ?? '+' }}" 
                    placeholder="Suffix (+)" 
                    class="w-full px-3 py-1 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-japan-600 bg-white"
                >
            </div>

            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-2 hover:border-japan-300 transition">
                <p class="text-[11px] font-extrabold text-slate-700">3. Tingkat Lulus Ujian</p>
                <input 
                    type="number" 
                    id="inputStatPassCount"
                    name="stat_pass_rate_count" 
                    value="{{ $settings['stat_pass_rate_count'] ?? '98' }}" 
                    class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-sm font-bold focus:outline-none focus:border-japan-600 bg-white"
                >
                <input 
                    type="text" 
                    id="inputStatPassSuffix"
                    name="stat_pass_rate_suffix" 
                    value="{{ $settings['stat_pass_rate_suffix'] ?? '%' }}" 
                    placeholder="Suffix (%)" 
                    class="w-full px-3 py-1 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-japan-600 bg-white"
                >
            </div>

            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-2 hover:border-japan-300 transition">
                <p class="text-[11px] font-extrabold text-slate-700">4. Legalitas Kemenaker</p>
                <input 
                    type="number" 
                    id="inputStatLegalCount"
                    name="stat_legal_count" 
                    value="{{ $settings['stat_legal_count'] ?? '100' }}" 
                    class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-sm font-bold focus:outline-none focus:border-japan-600 bg-white"
                >
                <input 
                    type="text" 
                    id="inputStatLegalSuffix"
                    name="stat_legal_suffix" 
                    value="{{ $settings['stat_legal_suffix'] ?? '%' }}" 
                    placeholder="Suffix (%)" 
                    class="w-full px-3 py-1 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-japan-600 bg-white"
                >
            </div>

        </div>
    </div>

    <!-- 5. Contact & Footer Settings -->
    <div id="sec-contact" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 scroll-mt-32">
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
    <div id="sec-ticker" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6 scroll-mt-32">
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
    <div id="sec-fonnte" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6 scroll-mt-32">
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
                    <div class="flex items-center gap-3">
                        <button 
                            type="button" 
                            id="btnCopyFonnteToken"
                            onclick="copyFonnteToken()" 
                            class="text-[11px] font-bold text-slate-600 hover:text-emerald-700 flex items-center gap-1 transition px-2 py-0.5 rounded-lg bg-white border border-slate-200 hover:border-emerald-300 shadow-2xs"
                            title="Salin token ke clipboard"
                        >
                            <i data-lucide="copy" class="w-3.5 h-3.5 text-emerald-600"></i>
                            <span id="copyTokenLabel">Salin Token</span>
                        </button>
                        <a href="https://fonnte.com" target="_blank" class="text-[11px] font-bold text-emerald-600 hover:underline flex items-center gap-1">
                            <span>Buka Dashboard Fonnte</span>
                            <i data-lucide="external-link" class="w-3 h-3"></i>
                        </a>
                    </div>
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

    <!-- Floating Unsaved Changes Notification Dock (Glassmorphism Bottom Bar) -->
    <div id="unsavedChangesDock" class="fixed bottom-6 inset-x-0 mx-auto max-w-xl z-50 px-4 transition-all duration-300 transform translate-y-24 opacity-0 pointer-events-none">
        <div class="bg-slate-900/95 backdrop-blur-md text-white rounded-2xl p-3 sm:px-5 sm:py-3.5 border border-slate-700/80 shadow-2xl flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 min-w-0">
                <span class="flex h-2.5 w-2.5 relative flex-shrink-0">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                </span>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-slate-100 truncate">Terdapat perubahan belum disimpan</p>
                    <p class="text-[10px] text-slate-400 hidden sm:block">Tekan <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-amber-300 font-mono text-[10px] border border-slate-700">Ctrl + S</kbd> untuk simpan instan</p>
                </div>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">
                <button 
                    type="button" 
                    onclick="resetFormChanges()" 
                    class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition border border-slate-700"
                >
                    Urungkan
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-1.5 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-md shadow-red-900/40"
                >
                    <i data-lucide="save" class="w-3.5 h-3.5"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </div>
    </div>

</form>

<script>
    function previewImageFile(input, targetImgId) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
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
                if (targetImgId === 'logoPreviewImg') {
                    const headerBox = document.getElementById('headerSimBox');
                    if (headerBox) {
                        headerBox.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-contain" alt="Logo">`;
                    }
                    const feedback = document.getElementById('logoFileFeedback');
                    if (feedback) {
                        const sizeKb = Math.round(file.size / 1024);
                        feedback.innerHTML = `<span class="text-emerald-600 font-bold">✓ Terpilih: ${file.name} (${sizeKb} KB)</span>`;
                    }
                }
                if (typeof checkFormDirty === 'function') {
                    checkFormDirty();
                }
            };
            reader.readAsDataURL(file);
        }
    }

    function resetToDefaultLogoBadge() {
        const fileInput = document.getElementById('siteLogoFileInput');
        const textInput = document.getElementById('siteLogoTextInput');
        const img = document.getElementById('logoPreviewImg');
        const defaultBadge = document.getElementById('logoDefaultBadge');
        const headerBox = document.getElementById('headerSimBox');
        const feedback = document.getElementById('logoFileFeedback');

        if (fileInput) fileInput.value = '';
        if (textInput) textInput.value = '';
        if (img) {
            img.src = '';
            img.classList.add('hidden');
        }
        if (defaultBadge) {
            defaultBadge.classList.remove('hidden');
        }
        if (headerBox) {
            headerBox.innerHTML = `<span id="headerSimKanji">友</span>`;
        }
        if (feedback) {
            feedback.innerHTML = `<span class="text-amber-600 font-bold">✓ Menggunakan Badge Default Kanji 友</span>`;
        }
        if (typeof checkFormDirty === 'function') {
            checkFormDirty();
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
       FONNTE TOKEN CLIPBOARD COPY
       ========================================================== */
    function copyFonnteToken() {
        const input = document.getElementById('fonnteApiTokenInput');
        const label = document.getElementById('copyTokenLabel');
        if (!input) return;
        const val = input.value.trim();
        if (!val) {
            alert('Token Fonnte masih kosong. Silakan isi terlebih dahulu.');
            input.focus();
            return;
        }
        navigator.clipboard.writeText(val).then(() => {
            if (label) {
                const orig = label.textContent;
                label.textContent = '✓ Tersalin!';
                label.classList.add('text-emerald-700', 'font-black');
                setTimeout(() => {
                    label.textContent = orig;
                    label.classList.remove('text-emerald-700', 'font-black');
                }, 2200);
            }
        }).catch(() => {
            input.select();
            document.execCommand('copy');
            if (label) {
                label.textContent = '✓ Tersalin!';
                setTimeout(() => { label.textContent = 'Salin Token'; }, 2000);
            }
        });
    }

    /* ==========================================================
       DRAG AND DROP LOGO UPLOAD ZONE
       ========================================================== */
    function initLogoDropZone() {
        const dropZone = document.getElementById('logoDropZone');
        const fileInput = document.getElementById('siteLogoFileInput');
        if (!dropZone || !fileInput) return;

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.add('border-japan-500', 'bg-japan-50/70', 'ring-2', 'ring-japan-200');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('border-japan-500', 'bg-japan-50/70', 'ring-2', 'ring-japan-200');
            }, false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            if (dt && dt.files && dt.files.length > 0) {
                fileInput.files = dt.files;
                previewImageFile(fileInput, 'logoPreviewImg');
            }
        }, false);
    }

    /* ==========================================================
       REAL-TIME LIVE PREVIEW FOR HERO SECTION
       ========================================================== */
    function initHeroLivePreview() {
        const mottoIn = document.getElementById('inputHeroMotto');
        const title1In = document.getElementById('inputHeroTitle1');
        const highlightIn = document.getElementById('inputHeroTitleHighlight');
        const subtitleIn = document.getElementById('inputHeroSubtitle');
        const imageIn = document.getElementById('inputHeroImage');

        const pMotto = document.getElementById('previewHeroMotto');
        const pTitle1 = document.getElementById('previewHeroTitle1');
        const pHighlight = document.getElementById('previewHeroTitleHighlight');
        const pSubtitle = document.getElementById('previewHeroSubtitle');
        const pImage = document.getElementById('previewHeroImg');

        if (mottoIn && pMotto) {
            mottoIn.addEventListener('input', () => {
                pMotto.textContent = mottoIn.value.trim() || 'LPK & SO Resmi Kemenaker RI';
            });
        }
        if (title1In && pTitle1) {
            title1In.addEventListener('input', () => {
                pTitle1.textContent = title1In.value.trim() || 'Jembatan Emas Menuju';
            });
        }
        if (highlightIn && pHighlight) {
            highlightIn.addEventListener('input', () => {
                pHighlight.textContent = highlightIn.value.trim() || 'Karir Gemilang di Jepang';
            });
        }
        if (subtitleIn && pSubtitle) {
            subtitleIn.addEventListener('input', () => {
                pSubtitle.textContent = subtitleIn.value.trim() || 'Wujudkan impian berpenghasilan Rp 18 - 35 Juta/bulan di Jepang...';
            });
        }
        if (imageIn && pImage) {
            imageIn.addEventListener('input', () => {
                const val = imageIn.value.trim();
                if (val) {
                    pImage.src = val;
                }
            });
        }
    }

    /* ==========================================================
       REAL-TIME LIVE PREVIEW FOR STAT COUNTERS
       ========================================================== */
    function initStatsLivePreview() {
        const cAlumni = document.getElementById('inputStatAlumniCount');
        const sAlumni = document.getElementById('inputStatAlumniSuffix');
        const pAlumni = document.getElementById('previewStatAlumni');

        const cPartners = document.getElementById('inputStatPartnersCount');
        const sPartners = document.getElementById('inputStatPartnersSuffix');
        const pPartners = document.getElementById('previewStatPartners');

        const cPass = document.getElementById('inputStatPassCount');
        const sPass = document.getElementById('inputStatPassSuffix');
        const pPass = document.getElementById('previewStatPass');

        const cLegal = document.getElementById('inputStatLegalCount');
        const sLegal = document.getElementById('inputStatLegalSuffix');
        const pLegal = document.getElementById('previewStatLegal');

        function updateStatPreviews() {
            if (pAlumni && cAlumni) pAlumni.textContent = (cAlumni.value || '0') + (sAlumni ? sAlumni.value : '+');
            if (pPartners && cPartners) pPartners.textContent = (cPartners.value || '0') + (sPartners ? sPartners.value : '+');
            if (pPass && cPass) pPass.textContent = (cPass.value || '0') + (sPass ? sPass.value : '%');
            if (pLegal && cLegal) pLegal.textContent = (cLegal.value || '0') + (sLegal ? sLegal.value : '%');
        }

        [cAlumni, sAlumni, cPartners, sPartners, cPass, sPass, cLegal, sLegal].forEach(el => {
            if (el) el.addEventListener('input', updateStatPreviews);
        });
    }

    /* ==========================================================
       REAL-TIME LIVE PREVIEW FOR ANNOUNCEMENT & BRAND
       ========================================================== */
    function initAnnouncementAndBrandLivePreview() {
        const aBadge = document.getElementById('inputAnnouncementBadge');
        const aText = document.getElementById('inputAnnouncementText');
        const pBadge = document.getElementById('previewAnnouncementBadge');
        const pText = document.getElementById('previewAnnouncementText');

        if (aBadge && pBadge) {
            aBadge.addEventListener('input', () => {
                pBadge.textContent = aBadge.value.trim() || 'Pengumuman';
            });
        }
        if (aText && pText) {
            aText.addEventListener('input', () => {
                pText.textContent = aText.value.trim() || 'Pendaftaran Gelombang Khusus Dibuka';
            });
        }

        const bName = document.getElementById('inputSiteName');
        const bTagline = document.getElementById('inputSiteTagline');
        const pName = document.getElementById('previewBrandName');
        const pTagline = document.getElementById('previewBrandTagline');

        if (bName && pName) {
            bName.addEventListener('input', () => {
                pName.textContent = bName.value.trim() || 'SAHABAT JEPANG';
            });
        }
        if (bTagline && pTagline) {
            bTagline.addEventListener('input', () => {
                pTagline.textContent = bTagline.value.trim() || 'Penyalur Resmi Kemenaker';
            });
        }
    }

    /* ==========================================================
       UNSAVED CHANGES TRACKER & KEYBOARD SHORTCUT (CTRL+S)
       ========================================================== */
    let initialFormState = '';
    let formIsSubmitting = false;

    function getFormSerialized() {
        const form = document.querySelector('form');
        if (!form) return '';
        const formData = new FormData(form);
        const pairs = [];
        for (let [k, v] of formData.entries()) {
            if (k === '_token' || (v instanceof File)) continue;
            pairs.push(k + '=' + v);
        }
        return pairs.sort().join('&');
    }

    function checkFormDirty() {
        const dock = document.getElementById('unsavedChangesDock');
        if (!dock) return;
        const current = getFormSerialized();
        const isDirty = current !== initialFormState;

        if (isDirty) {
            dock.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
            dock.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
        } else {
            dock.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
            dock.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
        }
    }

    function resetFormChanges() {
        const form = document.querySelector('form');
        if (form) {
            form.reset();
            setTimeout(() => {
                renderTickerRows();
                initHeroLivePreview();
                initStatsLivePreview();
                initAnnouncementAndBrandLivePreview();
                checkFormDirty();
            }, 50);
        }
    }

    function initUnsavedChangesTracker() {
        const form = document.querySelector('form');
        if (!form) return;

        initialFormState = getFormSerialized();

        form.addEventListener('input', checkFormDirty);
        form.addEventListener('change', checkFormDirty);

        form.addEventListener('submit', () => {
            formIsSubmitting = true;
        });

        window.addEventListener('beforeunload', (e) => {
            if (formIsSubmitting) return;
            if (getFormSerialized() !== initialFormState) {
                e.preventDefault();
                e.returnValue = 'Perubahan belum disimpan. Yakin ingin meninggalkan halaman?';
            }
        });

        // Global Ctrl+S / Cmd+S Shortcut
        window.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && (e.key === 's' || e.key === 'S')) {
                e.preventDefault();
                form.submit();
            }
        });
    }

    /* ==========================================================
       STICKY SUB-NAV SCROLLSPY & SMOOTH NAVIGATION
       ========================================================== */
    function initSettingScrollspy() {
        const pills = document.querySelectorAll('.setting-pill');
        const sections = ['sec-logo', 'sec-hero', 'sec-stats', 'sec-contact', 'sec-ticker', 'sec-fonnte']
            .map(id => document.getElementById(id))
            .filter(Boolean);

        const scrollContainer = document.querySelector('.overflow-y-auto') || document.querySelector('main') || window;

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

        // Smooth scroll on click
        pills.forEach(pill => {
            pill.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = pill.getAttribute('href').replace('#', '');
                const targetEl = document.getElementById(targetId);
                if (targetEl) {
                    targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        scrollContainer.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderTickerRows();
        initLogoDropZone();
        initHeroLivePreview();
        initStatsLivePreview();
        initAnnouncementAndBrandLivePreview();
        initUnsavedChangesTracker();
        initSettingScrollspy();
    });
</script>
@endsection
