@extends('layouts.app')

@section('title', 'Profil SJI Group • PT SAHABAT JEPANG INDONESIA GROUP - Penyalur Resmi & Holding Sending Organization')
@section('meta_description', 'Profil resmi PT Sahabat Jepang Indonesia Group (SJI Group) - Holding Sending Organization resmi Tokutei Ginou, Ginou Jisshusei, dan jaringan 9 cabang & kantor terpadu di Indonesia dan Jepang.')

@section('content')
<!-- Header Hero Banner (Japanese Zen Luxury) -->
<section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white overflow-hidden pt-24 pb-20 border-b border-slate-800">
    <!-- Traditional Japanese Pattern Overlay -->
    <div class="absolute inset-0 bg-seigaiha opacity-10 pointer-events-none"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-japan-600/20 border border-japan-500/40 text-red-400 text-xs font-black tracking-wider uppercase">
                    <span class="font-japanese text-sm text-red-500">友好日本</span>
                    <span>•</span>
                    <span>SAHABAT JEPANG INDONESIA GROUP (SJI GROUP)</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                    PT SAHABAT JEPANG INDONESIA GROUP
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-red-400 via-rose-300 to-amber-300 text-2xl sm:text-3xl lg:text-4xl mt-1 font-extrabold">
                        Sending Organization & Akademi Vokasi Terpadu Jepang
                    </span>
                </h1>

                <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl">
                    Lembaga induk pengirim resmi pekerja migran Indonesia (PMI) berketerampilan khusus (Tokutei Ginou / SSW) dan pemagang teknis (Ginou Jisshusei) berizin Kemenaker RI, menaungi {{ $indonesiaBranches->count() }} cabang lembaga pendidikan di Indonesia serta {{ $japanBranches->count() }} kantor perwakilan & balai karantina resmi di {{ $corporate['japan_offices'] }}, Jepang.
                </p>

                <!-- Official Badges Row -->
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-xs text-slate-200">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-400"></i>
                        <span>{{ $corporate['alumni_sent'] }} Alumni Sukses di Jepang</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-xs text-slate-200">
                        <i data-lucide="building-2" class="w-4 h-4 text-red-400"></i>
                        <span>Kantor Resmi di {{ $corporate['japan_offices'] }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-xs text-slate-200">
                        <i data-lucide="graduation-cap" class="w-4 h-4 text-amber-400"></i>
                        <span>{{ $corporate['mou_label'] }}</span>
                    </span>
                </div>
            </div>

            <!-- Quick Action / Official Accreditation Card -->
            <div class="w-full md:w-auto flex-shrink-0 bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-6 space-y-4 max-w-sm">
                <div class="flex items-center gap-3 pb-3 border-b border-white/10">
                    <div class="w-12 h-12 rounded-2xl bg-japan-600 flex items-center justify-center font-bold text-white text-xl shadow-lg shadow-red-600/30">
                        友
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium uppercase">Ekosistem Korporasi SJI</p>
                        <p class="text-sm font-extrabold text-white">SJI Group Ecosystem</p>
                    </div>
                </div>

                <div class="space-y-2.5 text-xs">
                    <div class="p-3 rounded-2xl bg-white/5 border border-white/10 space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Status Legalitas:</span>
                            <span class="font-bold text-emerald-400 flex items-center gap-1">
                                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                                Resmi & Terdaftar
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-300">Sending Organization (SO) Kemnaker RI & Pengawasan OTIT/JITCO Jepang</p>
                    </div>

                    <a href="{{ route('education.curriculum') }}" class="flex items-center justify-between p-3 rounded-2xl bg-gradient-to-r from-red-600/30 to-amber-600/30 hover:from-red-600/40 hover:to-amber-600/40 text-white transition group border border-red-500/30">
                        <span class="font-bold flex items-center gap-2">
                            <i data-lucide="book-open" class="w-4 h-4 text-amber-400"></i>
                            <span>Kurikulum & Edukasi Terpadu</span>
                        </span>
                        <i data-lucide="arrow-right" class="w-4 h-4 text-slate-300 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="#network" class="flex items-center justify-between p-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-slate-200 hover:text-white transition group border border-white/5">
                        <span class="font-semibold flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-red-400"></i>
                            <span>{{ $indonesiaBranches->count() }} Cabang Indonesia & {{ $japanBranches->count() }} Kantor Jepang</span>
                        </span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </div>

                <a href="{{ $corporate['whatsapp_link'] }}" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center gap-2 transition shadow-md shadow-emerald-600/20">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Hubungi CS WhatsApp SJI Group</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Interactive Section Tabs Navigation -->
<div class="sticky top-20 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-2xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-2 overflow-x-auto py-3 no-scrollbar select-none text-xs sm:text-sm font-bold text-slate-600">
            <div class="flex items-center gap-2">
                <a href="#about" class="px-3.5 py-1.5 rounded-xl bg-red-50 text-japan-600 border border-red-200/80 hover:bg-red-100 transition flex items-center gap-1.5 whitespace-nowrap">
                    <i data-lucide="user" class="w-4 h-4"></i>
                    <span>Pimpinan & Visi Misi</span>
                </a>
                <a href="#network" class="px-3.5 py-1.5 rounded-xl hover:bg-slate-100 hover:text-slate-900 transition flex items-center gap-1.5 whitespace-nowrap">
                    <i data-lucide="map-pin" class="w-4 h-4 text-japan-600"></i>
                    <span>Jaringan Cabang ({{ $allBranches->count() }})</span>
                </a>
                <a href="#strengths" class="px-3.5 py-1.5 rounded-xl hover:bg-slate-100 hover:text-slate-900 transition flex items-center gap-1.5 whitespace-nowrap">
                    <i data-lucide="star" class="w-4 h-4 text-amber-500"></i>
                    <span>Keunggulan Korporasi</span>
                </a>
                <a href="#kaisha-guide" class="px-3.5 py-1.5 rounded-xl hover:bg-slate-100 hover:text-slate-900 transition flex items-center gap-1.5 whitespace-nowrap">
                    <i data-lucide="book-heart" class="w-4 h-4 text-emerald-600"></i>
                    <span>Panduan Perusahaan Jepang (Kaisha)</span>
                </a>
            </div>
            <a href="{{ route('education.curriculum') }}" class="flex-shrink-0 inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-japan-600 hover:bg-japan-700 text-white transition font-bold shadow-xs whitespace-nowrap">
                <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                <span>Kurikulum & Edukasi &rarr;</span>
            </a>
        </div>
    </div>
</div>

<main class="space-y-20 py-12 bg-slate-50">

    <!-- 1. About & Leadership (Sambutan Pimpinan & Visi Misi) -->
    <section id="about" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-36">
        <div class="space-y-10">
            <!-- Header Section -->
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-100 text-japan-700 text-xs font-black uppercase tracking-wider font-japanese">
                    <span>代表挨拶 • Leadership & Vision</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Pimpinan & Visi Strategis SJI Group
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Mendedikasikan diri untuk masa depan generasi muda Indonesia di panggung industri berteknologi tinggi Jepang.
                </p>
            </div>

            <!-- Leadership Main Box: Photo & Greetings Side-by-Side -->
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- Leader Photo Card (Executive Japanese Style) -->
                    <div class="lg:col-span-4 flex flex-col items-center">
                        <div class="relative w-full max-w-xs mx-auto">
                            <!-- Background Aura -->
                            <div class="absolute -inset-2 bg-gradient-to-tr from-red-600 to-amber-500 rounded-3xl blur-lg opacity-25"></div>
                            
                            <div class="relative rounded-3xl overflow-hidden border-4 border-white shadow-xl bg-slate-900 aspect-[4/5] group">
                                @if(!empty($corporate['leader_photo']))
                                    <img src="{{ $corporate['leader_photo'] }}" alt="{{ $corporate['leader_name'] }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-b from-slate-800 to-slate-950 text-white p-6 text-center">
                                        <div class="w-20 h-20 rounded-full bg-japan-600/30 border-2 border-japan-500 flex items-center justify-center text-3xl font-japanese font-black text-red-400 mb-3 shadow-inner">
                                            吉
                                        </div>
                                        <p class="text-base font-extrabold text-white">{{ $corporate['leader_name'] }}</p>
                                        <p class="text-xs text-japan-300 font-medium mt-1">{{ $corporate['leader_title'] }}</p>
                                        <span class="mt-4 px-3 py-1 rounded-full bg-white/10 text-[10px] text-slate-300 border border-white/10">Foto Resmi Pimpinan</span>
                                    </div>
                                @endif

                                <!-- Gold Kanji Seal Badge Overlay -->
                                <div class="absolute top-3 right-3 px-3 py-1.5 rounded-xl bg-japan-700/90 backdrop-blur-md border border-red-400/40 text-white font-japanese text-xs font-black shadow-lg">
                                    代表取締役会長
                                </div>

                                <!-- Name Pill at Bottom -->
                                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent p-5 text-white">
                                    <p class="text-xs text-amber-400 font-bold uppercase tracking-wider font-japanese">SJI GROUP 代表</p>
                                    <h3 class="text-lg font-black tracking-tight text-white">{{ $corporate['leader_name'] }}</h3>
                                    <p class="text-xs text-slate-300">{{ $corporate['leader_title'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Greetings Content -->
                    <div class="lg:col-span-8 space-y-6">
                        <div class="flex items-center gap-2 text-japan-600 text-xs font-black tracking-widest uppercase">
                            <span class="w-2 h-2 rounded-full bg-japan-600"></span>
                            <span>Amanat Direktur Utama & Chairman</span>
                        </div>

                        <!-- Quote Box -->
                        <div class="p-6 rounded-2xl bg-gradient-to-br from-red-50/80 via-white to-amber-50/40 border border-red-100 text-slate-800 space-y-4">
                            <i data-lucide="quote" class="w-8 h-8 text-japan-400"></i>
                            <p class="text-sm sm:text-base leading-relaxed italic text-slate-700 font-serif">
                                "{{ $corporate['leader_message'] }}"
                            </p>
                            <div class="pt-3 border-t border-red-100/60 flex items-center justify-between">
                                <div>
                                    <p class="font-black text-slate-900 text-sm">{{ $corporate['leader_name'] }}</p>
                                    <p class="text-xs text-slate-500">{{ $corporate['leader_title'] }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-japan-600 text-white flex items-center justify-center font-japanese font-black shadow-md">
                                    吉
                                </div>
                            </div>
                        </div>

                        <div class="text-xs sm:text-sm text-slate-600 space-y-3 leading-relaxed">
                            <p>
                                <strong>PT SAHABAT JEPANG INDONESIA GROUP (SJI Group)</strong> telah memperoleh izin resmi pemerintah untuk memberangkatkan pekerja migran Indonesia (PMI) berketerampilan khusus (Tokutei Ginou / SSW) dan pemagang teknis (Ginou Jisshusei) ke berbagai prefektur di Jepang. Hingga saat ini, SJI Group telah sukses mendidik dan menerbangkan <strong>lebih dari {{ $corporate['alumni_sent'] }} pemuda-pemudi Indonesia</strong> ke Jepang.
                            </p>
                            <p>
                                Kami telah meresmikan kemitraan pendidikan komprehensif dengan universitas dan politeknik terkemuka di Indonesia, memungkinkan kami mencetak sumber daya manusia berkeahlian tinggi untuk segera mengisi kebutuhan industri vital Jepang. Kantor perwakilan kami di Tokyo dan balai karantina di Chiba menjamin pendampingan penuh secara akurat dan cepat sejak hari pertama pendaratan.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Vision & Mission Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Vision Card (Left 5 Cols) -->
                <div class="lg:col-span-5 bg-gradient-to-br from-slate-900 to-slate-950 text-white rounded-3xl p-6 sm:p-8 shadow-md border border-slate-800 space-y-4">
                    <div class="flex items-center gap-2 text-amber-400 text-xs font-bold uppercase tracking-wider">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                        <span>Visi Korporasi (VISION)</span>
                    </div>
                    <h3 class="text-lg font-black text-white">Menjadi Mitra Terdepan & Terpercaya Pengiriman Talenta Unggul</h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        {{ $corporate['vision'] }}
                    </p>
                </div>

                <!-- Mission Card (Right 7 Cols) -->
                <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center gap-2 text-japan-600 text-xs font-bold uppercase tracking-wider">
                        <i data-lucide="target" class="w-4 h-4"></i>
                        <span>4 Pilar Misi Perusahaan (MISSION)</span>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900">Komitmen Mutu & Profesionalisme Berkelanjutan</h3>
                    
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm text-slate-600">
                        <li class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="w-6 h-6 rounded-full bg-red-100 text-japan-600 flex items-center justify-center text-xs font-extrabold flex-shrink-0 mt-0.5">1</span>
                            <span>Mendorong pengembangan kompetensi SDM Indonesia secara konsisten dan terukur.</span>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="w-6 h-6 rounded-full bg-red-100 text-japan-600 flex items-center justify-center text-xs font-extrabold flex-shrink-0 mt-0.5">2</span>
                            <span>Perlindungan hukum dan peningkatan kesejahteraan pekerja selama bertugas di Jepang.</span>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="w-6 h-6 rounded-full bg-red-100 text-japan-600 flex items-center justify-center text-xs font-extrabold flex-shrink-0 mt-0.5">3</span>
                            <span>Membangun sistem kerjasama internasional yang kokoh, transparan, dan berkesinambungan.</span>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="w-6 h-6 rounded-full bg-red-100 text-japan-600 flex items-center justify-center text-xs font-extrabold flex-shrink-0 mt-0.5">4</span>
                            <span>Komitmen teguh pada tanggung jawab sosial (CSR) serta etika kemanusiaan.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. SJI Group Network & Entities (Direktori 9 Cabang & Kantor) -->
    <section id="network" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-36">
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-50 border border-red-200 text-japan-600 text-xs font-extrabold uppercase tracking-wider">
                <i data-lucide="network" class="w-3.5 h-3.5"></i>
                <span>Jaringan Lembaga & Kantor Cabang SJI Group</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                {{ $indonesiaBranches->count() }} Kampus di Indonesia & {{ $japanBranches->count() }} Kantor Representatif di Jepang
            </h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Semua entitas di bawah naungan PT SAHABAT JEPANG INDONESIA GROUP beroperasi dengan kurikulum terstandarisasi, fasilitas asrama representatif, dan pendampingan resmi langsung di Jepang.
            </p>
        </div>

        <!-- Filter Tab (Indonesia vs Jepang) -->
        <div class="flex items-center justify-center gap-2 mb-8">
            <button type="button" onclick="filterBranches('all')" id="btnFilterAll" class="branch-filter-btn px-4 py-2 rounded-xl bg-japan-600 text-white text-xs font-extrabold shadow-sm transition">
                Semua Lokasi ({{ $allBranches->count() }})
            </button>
            <button type="button" onclick="filterBranches('ID')" id="btnFilterId" class="branch-filter-btn px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-japan-600 text-xs font-extrabold shadow-2xs transition">
                🇮🇩 Indonesia ({{ $indonesiaBranches->count() }})
            </button>
            <button type="button" onclick="filterBranches('JP')" id="btnFilterJp" class="branch-filter-btn px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-japan-600 text-xs font-extrabold shadow-2xs transition">
                🇯🇵 Jepang ({{ $japanBranches->count() }})
            </button>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="branchesGrid">
            @foreach($allBranches as $branch)
                <div class="branch-card bg-white rounded-3xl p-6 border border-slate-200 hover:border-japan-300 hover:shadow-lg transition-all duration-300 flex flex-col justify-between group" data-country="{{ $branch->country }}">
                    
                    <div class="space-y-4">
                        <!-- Top Badges -->
                        <div class="flex items-start justify-between gap-3">
                            <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider {{ $branch->country === 'JP' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-red-100 text-japan-800 border border-red-200' }}">
                                {{ $branch->country === 'JP' ? '🇯🇵 Kantor Jepang' : '🇮🇩 Kampus Indonesia' }}
                            </span>

                            <span class="text-[10px] font-bold text-slate-400 uppercase font-mono">
                                #{{ str_pad($branch->sort_order, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <!-- Entity Name & Japanese Category -->
                        <div>
                            <h3 class="font-black text-slate-900 text-base group-hover:text-japan-600 transition leading-snug">
                                {{ $branch->name }}
                            </h3>
                            @if($branch->category_jp)
                                <p class="text-xs font-bold text-japan-600 font-japanese mt-0.5">
                                    {{ $branch->category_jp }}
                                </p>
                            @endif
                            @if($branch->category_id)
                                <p class="text-[11px] text-slate-500 mt-1">
                                    {{ $branch->category_id }}
                                </p>
                            @endif
                        </div>

                        <!-- Address Info -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2 text-xs text-slate-600">
                            <div class="flex items-start gap-2">
                                <i data-lucide="map-pin" class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5"></i>
                                <span class="leading-relaxed">{{ $branch->address }}</span>
                            </div>

                            @if($branch->phone)
                                <div class="flex items-center gap-2 pt-1 border-t border-slate-200/60 font-semibold text-slate-800">
                                    <i data-lucide="phone-call" class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0"></i>
                                    <span>{{ $branch->phone }}</span>
                                </div>
                            @endif

                            @if($branch->secondary_phone)
                                <div class="flex items-center gap-2 text-[11px] text-slate-500">
                                    <i data-lucide="phone" class="w-3 h-3 text-slate-400 flex-shrink-0"></i>
                                    <span>Telp Alternatif: {{ $branch->secondary_phone }}</span>
                                </div>
                            @endif
                        </div>

                        @if($branch->description)
                            <p class="text-xs text-slate-500 leading-relaxed">
                                {{ $branch->description }}
                            </p>
                        @endif
                    </div>

                    <!-- Action Button -->
                    <div class="pt-5 border-t border-slate-100 mt-4 flex items-center justify-between gap-2">
                        @if($branch->phone)
                            <a 
                                href="https://wa.me/{{ $branch->clean_whatsapp }}?text={{ urlencode('Halo ' . $branch->name . ', saya ingin konsultasi program kerja ke Jepang.') }}" 
                                target="_blank"
                                class="w-full py-2 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold transition flex items-center justify-center gap-1.5 border border-emerald-200"
                            >
                                <i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Hubungi Cabang</span>
                            </a>
                        @endif

                        <a 
                            href="https://www.google.com/maps/search/?api=1&query={{ urlencode($branch->name . ' ' . $branch->address) }}" 
                            target="_blank"
                            class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition flex items-center justify-center flex-shrink-0"
                            title="Buka Lokasi di Google Maps"
                        >
                            <i data-lucide="navigation" class="w-4 h-4"></i>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    </section>

    <!-- 3. SJI Strengths & Unique Characteristics (Keunggulan SJI Group) -->
    <section id="strengths" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-36">
        <div class="bg-gradient-to-br from-slate-900 via-slate-950 to-slate-900 rounded-3xl p-8 sm:p-12 text-white border border-slate-800 shadow-xl space-y-10">
            
            <div class="max-w-3xl space-y-3">
                <span class="px-3.5 py-1 rounded-full bg-red-600/30 text-red-400 border border-red-500/40 text-xs font-extrabold uppercase font-japanese">
                    SJIグループの特徴と強み
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight">
                    Keunggulan Utama PT SAHABAT JEPANG INDONESIA GROUP
                </h2>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Komitmen kami adalah menghadirkan tenaga kerja siap pakai (sokusenryoku) yang dibekali etika kerja Jepang (Shingitai), kemahiran bahasa, dan keahlian teknis presisi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Strength 1 -->
                <div class="p-6 rounded-2xl bg-white/5 border border-white/10 space-y-3 hover:bg-white/10 transition">
                    <div class="w-10 h-10 rounded-xl bg-red-600/30 text-red-400 flex items-center justify-center font-bold">
                        <i data-lucide="handshake" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-extrabold text-white text-base">Kerjasama Universitas & SMK Bergengsi</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Kami menjalin MoU resmi dengan universitas dan SMK vokasi ternama di seluruh Indonesia. Rekrutmen lulusan teknik mesin, elektronika, dan kendaraan ringan memastikan kandidat berproduktivitas tinggi sejak hari pertama.
                    </p>
                </div>

                <!-- Strength 2 -->
                <div class="p-6 rounded-2xl bg-white/5 border border-white/10 space-y-3 hover:bg-white/10 transition">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/30 text-amber-300 flex items-center justify-center font-bold">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-extrabold text-white text-base">20 Staf Manajemen & 3 Native Japanese</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Didukung 20 staf pengajar profesional: 3 instruktur penutur asli Jepang (native), 3 instruktur berlisensi The Japan Foundation Japanese Language Institute (Urawa, Saitama), dan 4 staf tata usaha.
                    </p>
                </div>

                <!-- Strength 3 -->
                <div class="p-6 rounded-2xl bg-white/5 border border-white/10 space-y-3 hover:bg-white/10 transition">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/30 text-blue-300 flex items-center justify-center font-bold">
                        <i data-lucide="heart-pulse" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-extrabold text-white text-base">Kemitraan Poltekkes Kemenkes RI (Kaigo)</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Kerjasama strategis dengan Politeknik Kesehatan Kementerian Kesehatan RI memungkinkan rekrutmen perawat lansia (caregiver) yang terlatih secara medis dan siap bertugas di fasilitas lansia Jepang.
                    </p>
                </div>

                <!-- Strength 4 -->
                <div class="p-6 rounded-2xl bg-white/5 border border-white/10 space-y-3 hover:bg-white/10 transition">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/30 text-emerald-300 flex items-center justify-center font-bold">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-extrabold text-white text-base">Pendampingan Penuh di Jepang</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Melalui kantor perwakilan di Tokyo dan balai pelatihan Chiba, tim kami siap siaga membantu kebutuhan adaptasi harian, tempat tinggal, dan konsultasi kerja peserta saat berada di Jepang.
                    </p>
                </div>

                <!-- Strength 5 -->
                <div class="p-6 rounded-2xl bg-white/5 border border-white/10 space-y-3 hover:bg-white/10 transition">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/30 text-purple-300 flex items-center justify-center font-bold">
                        <i data-lucide="layers" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-extrabold text-white text-base">Kurikulum Seragam SJI Standard</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Materi ajar dan silabus pembelajaran di seluruh cabang LPK SJI Group ditentukan secara terpusat, menghilangkan disparitas kualitas antara cabang satu dengan lainnya.
                    </p>
                </div>

                <!-- Strength 6 -->
                <div class="p-6 rounded-2xl bg-white/5 border border-white/10 space-y-3 hover:bg-white/10 transition">
                    <div class="w-10 h-10 rounded-xl bg-rose-500/30 text-rose-300 flex items-center justify-center font-bold">
                        <i data-lucide="wrench" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-extrabold text-white text-base">Bengkel Praktikum Autentik</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Ruang praktikum kejuruan dilengkapi mesin dan alat kerja riil yang digunakan di industri Jepang, menjembatani gap antara teori di kelas dengan kenyataan kerja di lapangan.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- Dedicated Education & Curriculum Feature Banner -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-red-950 text-white p-8 sm:p-12 border border-slate-800 shadow-xl">
            <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-japan-600/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
                <div class="space-y-4 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-japan-600/30 border border-japan-500/40 text-red-300 text-xs font-black uppercase tracking-wider font-japanese">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-400"></i>
                        <span>SJI 教育システム • Dedicated Page</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        Kurikulum Bahasa Jepang & Sistem Edukasi Terpadu
                    </h2>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        Kunjungi halaman khusus untuk mempelajari alur pendidikan 4 jenjang (Screening, N5, N4, N3/Kaigo), profil 20 tenaga pendidik profesional & 3 native sensei Jepang, fasilitas bengkel kerja autentik, asrama mandiri, serta jadwal disiplin harian (04.00 - 22.00).
                    </p>
                    <div class="flex flex-wrap items-center gap-3 pt-2 text-xs text-slate-300">
                        <span class="flex items-center gap-1.5"><i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i> 4-Tier Language Roadmap</span>
                        <span class="flex items-center gap-1.5"><i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i> 3 Native Sensei Jepang</span>
                        <span class="flex items-center gap-1.5"><i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i> Laboratorium Praktikum & Asrama</span>
                    </div>
                </div>

                <div class="flex-shrink-0">
                    <a href="{{ route('education.curriculum') }}" class="inline-flex items-center gap-3 px-6 py-4 rounded-2xl bg-japan-600 hover:bg-japan-700 text-white font-black text-sm transition shadow-lg shadow-red-600/30 hover:scale-[1.02] active:scale-[0.98]">
                        <i data-lucide="book-open" class="w-5 h-5"></i>
                        <span>Buka Kurikulum & Edukasi</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Guide for Japanese Companies / Kaisha (Panduan Budaya & Puasa Ramadan) -->
    <section id="kaisha-guide" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-36">
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm space-y-12">
            
            <div class="border-b border-slate-100 pb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2 max-w-2xl">
                    <span class="px-3.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-extrabold uppercase font-japanese">
                        受入企業様向け • インドネシア共和国と文化の理解
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Panduan untuk Perusahaan Penerima di Jepang (Kaisha)
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Pengenalan demografi Indonesia, toleransi beragama, dan petunjuk praktis pendampingan pekerja muslim selama bulan suci Ramadan agar lingkungan kerja tetap produktif, aman, dan harmonis.
                    </p>
                </div>

                <div class="flex-shrink-0">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                        <span>Zero Work Accidents Record</span>
                    </span>
                </div>
            </div>

            <!-- Country Basic Facts Table -->
            <div class="space-y-4">
                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <i data-lucide="globe" class="w-4 h-4 text-japan-600"></i>
                    <span>Fakta Geografis & Ekonomi Republik Indonesia (2026)</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
                    @foreach($countryGuide as $k => $v)
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">
                                {{ ucwords(str_replace('_', ' ', $k)) }}
                            </p>
                            <p class="text-xs font-extrabold text-slate-800 leading-snug">
                                {{ $v }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Islamic Understanding & Workplace Flexibility (Puasa Ramadan) -->
            <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-emerald-50/50 via-white to-teal-50/30 border border-emerald-200/80 space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold">
                        <i data-lucide="moon" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Tentang Islam di Indonesia & Ibadah Puasa (Ramadan)</h3>
                        <p class="text-xs text-slate-500 font-japanese">インドネシアのイスラム教とラマダン（断食）について</p>
                    </div>
                </div>

                <div class="text-xs sm:text-sm text-slate-700 space-y-4 leading-relaxed">
                    <p>
                        Sekitar 90% penduduk Indonesia beragama Islam, menjadikannya populasi muslim terbesar di dunia. Namun, karakteristik utama Islam di Indonesia adalah <strong>Islam modern yang damai, santun, dan toleran</strong>. Pemakaian hijab bersifat sukarela, hidup berdampingan secara damai dengan agama lain, serta menempatkan bakti kepada orang tua dan membalas budi kebaikan sebagai nilai tertinggi.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                        
                        <!-- Puasa Fleksibel -->
                        <div class="p-4 rounded-2xl bg-white border border-emerald-150 space-y-2 shadow-2xs">
                            <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-600"></i>
                                <span>Ibadah Puasa Bersifat Sangat Fleksibel</span>
                            </h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Puasa hanya diperuntukkan bagi yang bertubuh dan berjiwa sehat. Pekerja yang sedang tidak enak badan, sakit, atau mengalami kelelahan berat diperbolehkan menunda puasanya dan menggantinya di lain hari. Tidak pernah memaksakan diri di luar batas fisik.
                            </p>
                        </div>

                        <!-- Peran Perusahaan -->
                        <div class="p-4 rounded-2xl bg-white border border-emerald-150 space-y-2 shadow-2xs">
                            <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm flex items-center gap-2">
                                <i data-lucide="heart" class="w-4 h-4 text-rose-500"></i>
                                <span>Rekomendasi Penyesuaian di Tempat Kerja</span>
                            </h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Tidak ada tindakan khusus yang dipaksakan kepada perusahaan. Cukup berikan jeda istirahat minum air saat matahari terbenam (sekitar pukul 18.00). Sikap perhatian sederhana dari pimpinan seperti menyapa dengan hangat akan membangkitkan loyalitas tinggi peserta untuk membalas budi perusahaan.
                            </p>
                        </div>

                    </div>

                    <div class="p-4 rounded-2xl bg-emerald-100/70 border border-emerald-200 text-emerald-950 text-xs leading-relaxed">
                        <strong>Catatan Keamanan Kerja:</strong> Selama bertahun-tahun memberangkatkan ratusan pekerja, <strong>belum pernah ada laporan kecelakaan kerja ataupun penurunan produktivitas yang disebabkan oleh ibadah puasa</strong>. Siswa telah dilatih ketahanan fisiknya selama masa pelatihan di asrama SJI Group.
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Bottom Call To Action & Social Media Connect -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <div class="bg-gradient-to-r from-japan-700 via-japan-600 to-rose-600 rounded-3xl p-8 sm:p-12 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-3 max-w-xl text-center md:text-left">
                <span class="px-3 py-1 rounded-full bg-white/20 text-white text-xs font-black uppercase tracking-wider font-japanese">
                    SJI GROUP • GO TO JAPAN
                </span>
                <h2 class="text-2xl sm:text-3xl font-black">Siap Membangun Karir Cemerlang di Jepang?</h2>
                <p class="text-xs sm:text-sm text-red-100 leading-relaxed">
                    Konsultasikan pilihan program Tokutei Ginou (SSW), Magang Teknis, ataupun kursus bahasa Jepang bersama konselor resmi SJI Group.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto flex-shrink-0">
                <a href="{{ $corporate['whatsapp_link'] }}" target="_blank" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-white hover:bg-slate-100 text-japan-700 font-extrabold text-xs sm:text-sm transition flex items-center justify-center gap-2 shadow-lg">
                    <i data-lucide="message-circle" class="w-4 h-4 text-emerald-600"></i>
                    <span>Konsultasi WA Sekarang</span>
                </a>
                <a href="{{ route('home') }}#program" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-japan-800/60 hover:bg-japan-900 text-white font-extrabold text-xs sm:text-sm transition flex items-center justify-center gap-2 border border-white/20">
                    <i data-lucide="briefcase" class="w-4 h-4"></i>
                    <span>Lihat Katalog Program</span>
                </a>
            </div>
        </div>
    </section>

</main>

<script>
    function filterBranches(country) {
        const cards = document.querySelectorAll('.branch-card');
        const btns = document.querySelectorAll('.branch-filter-btn');

        btns.forEach(btn => {
            btn.classList.remove('bg-japan-600', 'text-white');
            btn.classList.add('bg-white', 'text-slate-700', 'border', 'border-slate-200');
        });

        if (country === 'all') {
            document.getElementById('btnFilterAll').classList.add('bg-japan-600', 'text-white');
            document.getElementById('btnFilterAll').classList.remove('bg-white', 'text-slate-700');
        } else if (country === 'ID') {
            document.getElementById('btnFilterId').classList.add('bg-japan-600', 'text-white');
            document.getElementById('btnFilterId').classList.remove('bg-white', 'text-slate-700');
        } else if (country === 'JP') {
            document.getElementById('btnFilterJp').classList.add('bg-japan-600', 'text-white');
            document.getElementById('btnFilterJp').classList.remove('bg-white', 'text-slate-700');
        }

        cards.forEach(card => {
            const cardCountry = card.getAttribute('data-country');
            if (country === 'all' || cardCountry === country) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }
</script>
@endsection
