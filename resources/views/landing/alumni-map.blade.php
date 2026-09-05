@extends('layouts.app')

@section('title', 'Peta Interaktif Sebaran Alumni di Seluruh Jepang - LPK Sahabat Jepang Indonesia')
@section('meta_description', 'Jelajahi peta persebaran alumni LPK Sahabat Jepang Indonesia di 47 prefektur Jepang (Tokyo, Osaka, Aichi, Kanagawa, dll) di sektor Kaigo, Manufaktur, dan Pengolahan Makanan.')
@section('meta_keywords', 'peta alumni jepang, sebaran magang jepang di 47 prefektur, alumni ssw jepang, penempatan kerja jepang sahabat jepang indonesia')

@section('content')
<div class="bg-slate-950 text-white min-h-screen py-10 sm:py-16 relative overflow-hidden">

    <!-- Ambient Japanese Red Glows -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-red-600/15 blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/3 -right-32 w-96 h-96 rounded-full bg-rose-600/10 blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-10 left-1/3 w-96 h-96 rounded-full bg-red-800/10 blur-[120px] pointer-events-none"></div>

    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 relative z-10 space-y-12">

        <!-- Top Header Hero -->
        <div class="text-center space-y-4 max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold font-japanese shadow-xs">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                <span>日本全国の卒業生ネットワーク • Sebaran 47 Prefektur Jepang</span>
            </div>
            
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                Peta Sebaran Alumni di Seluruh Jepang
            </h1>
            
            <p class="text-xs sm:text-sm md:text-base text-slate-300 leading-relaxed max-w-2xl mx-auto">
                Ratusan alumni LPK Sahabat Jepang Indonesia telah resmi bekerja dan tersebar di 8 wilayah utama dan 47 prefektur Jepang, mulai dari Tokyo, Nagoya, Osaka, hingga Fukuoka dan Hokkaido.
            </p>

            <!-- Quick Live Counter 4 Stats Boxes -->
            <div class="pt-4 grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-5 max-w-4xl mx-auto">
                
                <!-- Stat 1 -->
                <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 backdrop-blur-md text-center hover:border-red-500/50 transition shadow-lg flex flex-col justify-between min-h-[120px]">
                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider block">Total Alumni Bekerja</span>
                    <h3 class="text-3xl sm:text-4xl font-black text-japan-500 my-1 font-mono leading-none">{{ $totalAlumniCount }}+</h3>
                    <p class="text-[11px] text-slate-400 font-medium">Peserta Aktif di Jepang</p>
                </div>

                <!-- Stat 2 -->
                <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 backdrop-blur-md text-center hover:border-emerald-500/50 transition shadow-lg flex flex-col justify-between min-h-[120px]">
                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider block">Cakupan Wilayah</span>
                    <h3 class="text-3xl sm:text-4xl font-black text-emerald-400 my-1 font-mono leading-none">47</h3>
                    <p class="text-[11px] text-slate-400 font-medium">Prefektur di 8 Region</p>
                </div>

                <!-- Stat 3 -->
                <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 backdrop-blur-md text-center hover:border-blue-500/50 transition shadow-lg flex flex-col justify-between min-h-[120px]">
                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider block">Mitra Kaisha</span>
                    <h3 class="text-3xl sm:text-4xl font-black text-blue-400 my-1 font-mono leading-none">85+</h3>
                    <p class="text-[11px] text-slate-400 font-medium">Perusahaan Resmi SO</p>
                </div>

                <!-- Stat 4 -->
                <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 backdrop-blur-md text-center hover:border-amber-500/50 transition shadow-lg flex flex-col justify-between min-h-[120px]">
                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider block">Tingkat Kelulusan</span>
                    <h3 class="text-3xl sm:text-4xl font-black text-amber-400 my-1 font-mono leading-none">99.4%</h3>
                    <p class="text-[11px] text-slate-400 font-medium">Visa & COE Terbit</p>
                </div>

            </div>
        </div>

        <!-- Sektor Karir Filter Bar (Single Horizontal Line / Clean Wrap) -->
        <div class="max-w-5xl mx-auto space-y-4">
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-2 px-3 bg-slate-900/90 rounded-2xl border border-slate-800 backdrop-blur-md justify-start md:justify-center shadow-lg">
                <a 
                    href="{{ route('alumni.map') }}" 
                    class="px-4 py-2 rounded-xl text-xs font-black whitespace-nowrap flex-shrink-0 transition {{ empty($selectedSector) ? 'bg-japan-600 text-white shadow-md shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}"
                >
                    Semua Sektor Karir
                </a>
                @foreach(['Kaigo' => 'Kaigo / Caregiver', 'Makanan' => 'Pengolahan Makanan', 'Manufaktur' => 'Manufaktur Mesin', 'Pertanian' => 'Pertanian (Nougyou)', 'Konstruksi' => 'Konstruksi', 'Perhotelan' => 'Perhotelan'] as $secKey => $secLbl)
                    <a 
                        href="{{ route('alumni.map', ['sector' => $secKey]) }}" 
                        class="px-4 py-2 rounded-xl text-xs font-black whitespace-nowrap flex-shrink-0 transition {{ $selectedSector === $secKey ? 'bg-japan-600 text-white shadow-md shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}"
                    >
                        {{ $secLbl }}
                    </a>
                @endforeach
            </div>

            <!-- Instant Real-Time Search Bar -->
            <div class="max-w-2xl mx-auto">
                <div class="relative">
                    <input 
                        type="text" 
                        id="alumniSearchInput" 
                        oninput="filterAlumniDatabase()" 
                        placeholder="🔍 Cari nama siswa, prefektur (Tokyo, Osaka, Aichi...), atau Kaisha..." 
                        class="w-full px-5 py-3.5 pl-11 pr-20 rounded-2xl bg-slate-900/90 border border-slate-700 text-white placeholder-slate-400 text-xs sm:text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 shadow-xl transition"
                    >
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <button 
                        type="button" 
                        id="clearSearchBtn" 
                        onclick="clearAlumniSearch()" 
                        class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white text-xs px-2.5 py-1 rounded-xl bg-slate-800 border border-slate-700 transition"
                    >
                        Reset
                    </button>
                </div>
                <!-- Active Prefecture Filter Badge -->
                <div id="activePrefectureFilterBadge" class="hidden items-center gap-1.5 px-3 py-1 rounded-xl bg-japan-600/20 text-red-400 border border-red-500/40 text-xs font-bold w-fit mt-2 animate-fadeIn">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                    <span>Filter Aktif: <strong id="activePrefectureFilterName" class="text-white">Tokyo</strong></span>
                    <button type="button" onclick="clearAlumniSearch()" class="hover:text-white ml-1 text-slate-400">&times;</button>
                </div>
                <div class="flex items-center justify-between text-[11px] text-slate-400 mt-2 px-2">
                    <span id="alumniSearchCount">Menampilkan semua alumni & siswa terverifikasi</span>
                    <span class="text-japan-400 font-bold hidden sm:inline">Klik nama prefektur untuk filter instan</span>
                </div>
            </div>
        </div>

        <!-- 8 Regions Japan Matrix Showcase -->
        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border-b border-slate-800 pb-4">
                <div>
                    <h3 class="text-xl sm:text-2xl font-black text-white flex items-center gap-2.5">
                        <i data-lucide="map" class="w-6 h-6 text-japan-500"></i>
                        <span>Sebaran 8 Wilayah & Prefektur di Jepang</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Klik wilayah untuk melihat detail sebaran, estimasi gaji, dan alumni yang bertugas</p>
                </div>
                <span class="font-japanese text-xs text-red-400 font-bold bg-red-500/10 px-3 py-1 rounded-full border border-red-500/20 whitespace-nowrap">
                    日本全国 8地方ネットワーク
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($regions as $regKey => $reg)
                    <div 
                        onclick="openRegionSpotlight('{{ $regKey }}')" 
                        class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 hover:border-japan-600 transition-all duration-300 group flex flex-col justify-between shadow-lg hover:shadow-red-600/10 min-h-[220px] cursor-pointer active:scale-[0.98]"
                        title="Klik untuk melihat spotlight {{ $reg['name'] }}"
                    >
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase text-white shadow-xs {{ $reg['color'] }}">
                                    {{ $reg['count'] }} Alumni
                                </span>
                                <div class="w-8 h-8 rounded-xl bg-slate-800 group-hover:bg-red-500/20 text-red-400 flex items-center justify-center transition">
                                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                                </div>
                            </div>

                            <div>
                                <h4 class="font-black text-white text-base group-hover:text-red-400 transition flex items-center justify-between">
                                    <span>{{ $reg['name'] }}</span>
                                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-600 group-hover:text-red-400 group-hover:translate-x-0.5 transition"></i>
                                </h4>
                                <p class="text-xs text-japan-400 font-bold font-japanese mt-0.5">{{ $reg['hub'] }}</p>
                            </div>

                            <div class="pt-1 flex flex-wrap gap-1.5">
                                @foreach($reg['prefectures'] as $pref)
                                    <span 
                                        onclick="event.stopPropagation(); filterByPrefecture('{{ $pref }}')" 
                                        class="px-2.5 py-0.5 rounded-lg bg-slate-800 hover:bg-red-950/80 hover:border-red-500/60 border border-slate-700 text-[10px] text-slate-300 font-medium transition cursor-pointer"
                                        title="Filter siswa di {{ $pref }}"
                                    >
                                        {{ $pref }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-3 mt-4 border-t border-slate-800 flex items-center justify-between text-xs text-slate-400">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>Status: Aktif</span>
                            </span>
                            <span class="text-japan-400 font-bold font-mono text-[11px] group-hover:underline">Lihat Detail &rarr;</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Live Database Feed: Alumni & Siswa Penempatan Terkini -->
        @if($departedStudents->count() > 0)
            <div class="space-y-6 pt-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-800 pb-4">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-black text-white flex items-center gap-2.5">
                            <i data-lucide="plane-takeoff" class="w-6 h-6 text-red-500"></i>
                            <span>Data Siswa & Alumni Penempatan Terkini</span>
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">Daftar siswa terverifikasi di database resmi LPK SJI yang telah lolos dan bertugas di Jepang</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Sinkronisasi Database Aktif</span>
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="departedStudentsGrid">
                    @foreach($departedStudents as $st)
                        <div 
                            class="student-card p-5 rounded-3xl bg-slate-900/90 border border-slate-800 hover:border-japan-500 transition-all duration-300 shadow-lg group space-y-3"
                            data-name="{{ strtolower($st->name) }}"
                            data-jpname="{{ strtolower($st->japanese_name ?: '') }}"
                            data-prefecture="{{ strtolower($st->destination_prefecture ?: '') }}"
                            data-company="{{ strtolower($st->destination_company ?: '') }}"
                            data-program="{{ strtolower($st->sector ?: $st->program) }}"
                        >
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-slate-800 border-2 border-slate-700 overflow-hidden flex-shrink-0">
                                    @if($st->photo)
                                        <img src="{{ $st->photo }}" alt="{{ $st->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400 font-bold font-japanese">友</div>
                                    @endif
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="font-black text-white text-sm truncate leading-tight group-hover:text-red-400 transition">{{ $st->name }}</h4>
                                    <p class="text-[11px] text-japan-400 font-japanese truncate">{{ $st->japanese_name ?: '-' }}</p>
                                    <span class="text-[9px] font-mono text-slate-400 block">{{ $st->nis }}</span>
                                </div>
                            </div>

                            <div class="p-3 rounded-2xl bg-slate-800/80 border border-slate-700/60 text-xs space-y-1.5">
                                <div class="flex justify-between items-center text-slate-400">
                                    <span class="text-[11px]">Penempatan:</span>
                                    <span 
                                        onclick="filterByPrefecture('{{ $st->destination_prefecture }}')" 
                                        class="font-bold text-white text-[11px] truncate max-w-[120px] hover:text-red-400 cursor-pointer"
                                        title="Filter siswa di {{ $st->destination_prefecture }}"
                                    >
                                        {{ $st->destination_prefecture ?: 'Jepang' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center text-slate-400">
                                    <span class="text-[11px]">Kaisha:</span>
                                    <span class="font-bold text-japan-300 text-[11px] truncate max-w-[120px]">{{ $st->destination_company ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center text-slate-400 border-t border-slate-700/60 pt-1.5">
                                    <span class="text-[11px]">Program:</span>
                                    <span class="font-bold text-emerald-400 text-[11px] truncate max-w-[120px]">{{ $st->sector ?: $st->program }}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-[11px] pt-1 text-slate-400">
                                <span>Status:</span>
                                @if($st->status === 'departed')
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 font-bold text-[10px]">Di Jepang</span>
                                @elseif($st->status === 'passed_interview')
                                    <span class="px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-400 font-bold text-[10px]">Lolos User</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-blue-500/20 text-blue-400 font-bold text-[10px]">{{ ucfirst($st->status) }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Real Alumni Stories & Verified Kaisha Placements -->
        <div class="space-y-6 pt-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-800 pb-4">
                <div>
                    <h3 class="text-2xl font-black text-white flex items-center gap-2.5">
                        <i data-lucide="award" class="w-6 h-6 text-amber-500"></i>
                        <span>Kisah Sukses & Penempatan Kaisha Alumni</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Bukti nyata alumni yang telah sukses bekerja di berbagai kota dan perusahaan di Jepang</p>
                </div>
                <button onclick="openModal('consultationModal')" class="btn-red-primary px-5 py-2.5 rounded-2xl text-xs font-black flex items-center gap-2 shadow-lg shadow-red-600/30 whitespace-nowrap active:scale-[0.97]">
                    <i data-lucide="sparkles" class="w-4 h-4 text-amber-200"></i>
                    <span>Ikuti Jejak Mereka Sekarang</span>
                </button>
            </div>

            <!-- Empty State if Search results are 0 -->
            <div id="noAlumniFoundState" class="hidden p-10 rounded-3xl bg-slate-900/60 border border-slate-800 text-center space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-slate-800 text-slate-400 flex items-center justify-center mx-auto text-xl">🔍</div>
                <h4 class="font-bold text-white text-base">Tidak ada data yang cocok dengan pencarian</h4>
                <p class="text-xs text-slate-400 max-w-sm mx-auto">Coba gunakan kata kunci prefektur seperti Tokyo, Aichi, Osaka, atau kosongkan kolom pencarian.</p>
                <button type="button" onclick="clearAlumniSearch()" class="px-4 py-2 rounded-xl bg-japan-600 text-white font-bold text-xs">Reset Pencarian</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="testimonialsGrid">
                @foreach($testimonials as $t)
                    <div 
                        class="testimonial-card p-6 rounded-3xl bg-slate-900 border border-slate-800 flex flex-col justify-between hover:border-red-500/60 hover:-translate-y-1.5 transition-all duration-300 shadow-xl hover:shadow-red-600/10 group space-y-4 cursor-pointer"
                        data-name="{{ strtolower($t->name) }}"
                        data-prefecture="{{ strtolower($t->prefecture) }}"
                        data-company="{{ strtolower($t->company) }}"
                        data-program="{{ strtolower($t->program) }}"
                        onclick='openAlumniStory(@json($t))'
                        title="Klik untuk membaca kisah lengkap & profil {{ $t->name }}"
                    >
                        <div class="space-y-4">
                            
                            <!-- Avatar & Location Header -->
                            <div class="flex items-center gap-3.5">
                                <img src="{{ $t->avatar }}" alt="{{ $t->name }}" class="w-14 h-14 rounded-2xl object-cover border-2 border-japan-600 shadow-md flex-shrink-0 group-hover:scale-105 transition">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-extrabold text-white text-base leading-tight group-hover:text-red-400 transition">{{ $t->name }}</h4>
                                        <span class="w-2 h-2 rounded-full bg-emerald-400" title="Alumni Aktif"></span>
                                    </div>
                                    <p 
                                        onclick="event.stopPropagation(); filterByPrefecture('{{ $t->prefecture }}')" 
                                        class="text-xs text-red-400 font-bold font-japanese flex items-center gap-1 mt-0.5 cursor-pointer hover:underline"
                                        title="Filter di prefektur {{ $t->prefecture }}"
                                    >
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-japan-500"></i>
                                        <span>{{ $t->prefecture }}, Jepang</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Placement Info Box -->
                            <div class="p-4 rounded-2xl bg-slate-800/90 border border-slate-700/80 text-xs space-y-2 font-mono">
                                <div class="flex justify-between items-center text-slate-400">
                                    <span>Program:</span>
                                    <span class="text-white font-bold bg-slate-700 px-2 py-0.5 rounded text-[11px]">{{ $t->program }}</span>
                                </div>
                                <div class="flex justify-between items-center text-slate-400">
                                    <span>Perusahaan:</span>
                                    <span class="text-japan-300 font-bold font-japanese text-[11px] truncate max-w-[150px]">{{ $t->company }}</span>
                                </div>
                                <div class="flex justify-between items-center text-slate-400 border-t border-slate-700/80 pt-2">
                                    <span>Gaji Bersih / Bulan:</span>
                                    <span class="text-emerald-400 font-black text-sm">{{ $t->salary }}</span>
                                </div>
                            </div>

                            <!-- Quote -->
                            <p class="text-xs sm:text-sm text-slate-300 italic leading-relaxed line-clamp-3">
                                "{{ $t->quote }}"
                            </p>
                        </div>

                        <!-- Footer Badge -->
                        <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-500 font-medium">
                            <span class="text-[11px]">Asal: <strong class="text-slate-300">{{ $t->origin }}</strong></span>
                            <span class="text-japan-400 group-hover:text-white text-[11px] font-bold flex items-center gap-1 transition">
                                <span>Detail Kisah</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition"></i>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Bottom Japanese Call to Action Card -->
        <div class="p-8 sm:p-12 rounded-3xl bg-gradient-to-r from-japan-900 via-japan-800 to-red-600 text-white text-center space-y-5 shadow-2xl relative overflow-hidden">
            <div class="space-y-2 max-w-2xl mx-auto">
                <span class="font-japanese text-xs text-red-200 uppercase tracking-widest font-bold block">あなたの日本への道 • Jalan Menuju Karir Jepang Anda</span>
                <h2 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    Wujudkan Impian Berkarir di Jepang Bersama LPK Sahabat Jepang Indonesia
                </h2>
                <p class="text-xs sm:text-sm text-red-100 max-w-xl mx-auto leading-relaxed">
                    Dapatkan bimbingan intensif dari Sensei profesional, kepastian penempatan kerja di Kaisha resmi, dan proses 100% legal terakreditasi Kemenaker RI.
                </p>
            </div>
            
            <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                <button onclick="openModal('consultationModal')" class="px-8 py-3.5 rounded-2xl bg-white text-japan-700 font-black text-xs sm:text-sm hover:bg-red-50 transition shadow-xl shadow-black/30 flex items-center gap-2 active:scale-[0.97]">
                    <i data-lucide="sparkles" class="w-4 h-4 text-amber-500"></i>
                    <span>Daftar Konsultasi Karir Gratis Sekarang</span>
                </button>

                <a href="{{ route('exam.simulator') }}" class="px-6 py-3.5 rounded-2xl bg-red-800/80 hover:bg-red-800 text-white font-bold text-xs sm:text-sm transition border border-red-400/30 flex items-center gap-2 active:scale-[0.97]">
                    <i data-lucide="file-check" class="w-4 h-4"></i>
                    <span>Coba Tryout JLPT Online</span>
                </a>
            </div>
        </div>

    </div>
</div>

<!-- Interactive Region Spotlight Modal -->
<div id="regionSpotlightModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md transition-opacity">
    <div class="bg-slate-900 border border-slate-700 text-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl space-y-5 relative overflow-hidden animate-fadeIn">
        <button 
            type="button" 
            onclick="closeRegionSpotlight()" 
            class="absolute top-4 right-4 text-slate-400 hover:text-white p-2 rounded-xl bg-slate-800 hover:bg-slate-700 transition"
        >
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <div class="space-y-1">
            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase text-white bg-japan-600 inline-block" id="modalRegionBadge">
                Region Spotlight
            </span>
            <h3 class="text-2xl font-black text-white" id="modalRegionName">Nama Region</h3>
            <p class="text-xs text-japan-400 font-bold font-japanese" id="modalRegionHub">Hub Perkotaan</p>
        </div>

        <div class="grid grid-cols-2 gap-3 py-2">
            <div class="p-3.5 rounded-2xl bg-slate-800/90 border border-slate-700/80 text-center">
                <span class="text-[10px] font-bold text-slate-400 uppercase block">Total Alumni Ditempatkan</span>
                <h4 class="text-xl font-black text-japan-500 mt-0.5" id="modalRegionCount">0 Alumni</h4>
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-800/90 border border-slate-700/80 text-center">
                <span class="text-[10px] font-bold text-slate-400 uppercase block">Estimasi Gaji Bersih</span>
                <h4 class="text-sm font-black text-emerald-400 mt-1" id="modalRegionSalary">¥175,000 - ¥230,000</h4>
            </div>
        </div>

        <div class="space-y-2">
            <span class="text-xs font-bold text-slate-300 block">Daftar Prefektur di Wilayah Ini:</span>
            <div class="flex flex-wrap gap-1.5" id="modalPrefecturesList">
                <!-- Injected via JS -->
            </div>
            <p class="text-[11px] text-slate-400 italic mt-1">💡 Klik pada salah satu prefektur di atas untuk memfilter data siswa yang bekerja di sana.</p>
        </div>

        <div class="pt-2 flex items-center justify-between gap-3 border-t border-slate-800">
            <button 
                type="button" 
                onclick="closeRegionSpotlight()" 
                class="px-4 py-2.5 rounded-xl border border-slate-700 text-slate-300 hover:bg-slate-800 text-xs font-bold transition"
            >
                Tutup
            </button>
            <button 
                type="button" 
                onclick="closeRegionSpotlight(); openModal('consultationModal')" 
                class="btn-red-primary px-5 py-2.5 rounded-xl text-xs font-bold shadow-lg shadow-red-600/30 flex items-center gap-1.5 active:scale-[0.97]"
            >
                <i data-lucide="sparkles" class="w-4 h-4"></i>
                <span>Daftar Penempatan Sini</span>
            </button>
        </div>
    </div>
</div>

<!-- Interactive Alumni Story Spotlight Modal -->
<div id="alumniStoryModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md transition-opacity">
    <div class="bg-slate-900 border border-slate-700 text-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl space-y-5 relative overflow-hidden animate-fadeIn">
        <button 
            type="button" 
            onclick="closeAlumniStory()" 
            class="absolute top-4 right-4 text-slate-400 hover:text-white p-2 rounded-xl bg-slate-800 hover:bg-slate-700 transition"
        >
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <div class="flex items-center gap-4">
            <img id="storyModalAvatar" src="" alt="Alumni" class="w-16 h-16 rounded-2xl object-cover border-2 border-japan-600 shadow-lg flex-shrink-0">
            <div>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase text-red-400 bg-red-500/20 border border-red-500/30 inline-block mb-1" id="storyModalTag">
                    Alumni Sukses
                </span>
                <h3 class="text-xl font-black text-white" id="storyModalName">Nama Alumni</h3>
                <p class="text-xs text-japan-400 font-bold font-japanese flex items-center gap-1 mt-0.5">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-japan-500"></i>
                    <span id="storyModalPrefecture">Prefektur, Jepang</span>
                </p>
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-slate-800/80 border border-slate-700/80 text-xs space-y-2">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <span class="text-slate-400 text-[10px] uppercase font-bold block">Program</span>
                    <strong class="text-white text-xs font-mono" id="storyModalProgram">-</strong>
                </div>
                <div>
                    <span class="text-slate-400 text-[10px] uppercase font-bold block">Kaisha / Perusahaan</span>
                    <strong class="text-japan-300 text-xs font-japanese font-bold" id="storyModalCompany">-</strong>
                </div>
                <div class="col-span-2 pt-1 border-t border-slate-700/60 flex items-center justify-between">
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Gaji Bersih / Bulan</span>
                        <strong class="text-emerald-400 text-sm font-black" id="storyModalSalary">-</strong>
                    </div>
                    <div class="text-right">
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Asal Daerah</span>
                        <strong class="text-slate-200 text-xs" id="storyModalOrigin">-</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Quote -->
        <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800 relative">
            <i data-lucide="quote" class="w-6 h-6 text-red-500/20 absolute top-2 right-3 pointer-events-none"></i>
            <p class="text-xs sm:text-sm text-slate-200 italic leading-relaxed" id="storyModalQuote">
                "..."
            </p>
        </div>

        <div class="pt-2 flex items-center justify-between gap-3 border-t border-slate-800">
            <button 
                type="button" 
                onclick="closeAlumniStory()" 
                class="px-4 py-2.5 rounded-xl border border-slate-700 text-slate-300 hover:bg-slate-800 text-xs font-bold transition"
            >
                Tutup
            </button>
            <a 
                id="storyModalWaBtn"
                href="#"
                target="_blank"
                class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-lg shadow-emerald-600/30 flex items-center gap-1.5 transition active:scale-[0.97]"
            >
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                <span>Tanya Alur Lolos Seperti Ini</span>
            </a>
        </div>
    </div>
</div>

<script>
    const regionsData = @json($regions);

    function openRegionSpotlight(regKey) {
        const reg = regionsData[regKey];
        if (!reg) return;

        document.getElementById('modalRegionBadge').innerText = `${reg.count} Alumni Bekerja`;
        document.getElementById('modalRegionName').innerText = reg.name;
        document.getElementById('modalRegionHub').innerText = `Hub: ${reg.hub}`;
        document.getElementById('modalRegionCount').innerText = `${reg.count} Siswa`;

        // Approximate regional salary benchmark
        const salaryMap = {
            'kanto': '¥190,000 - ¥245,000 (~Rp 20-26 jt)',
            'chubu': '¥185,000 - ¥235,000 (~Rp 19-25 jt)',
            'kansai': '¥180,000 - ¥230,000 (~Rp 19-24 jt)',
            'kyushu': '¥170,000 - ¥215,000 (~Rp 18-23 jt)',
            'tohoku': '¥165,000 - ¥210,000 (~Rp 17-22 jt)',
            'chugoku': '¥170,000 - ¥220,000 (~Rp 18-23 jt)',
            'shikoku': '¥165,000 - ¥210,000 (~Rp 17-22 jt)',
            'hokkaido': '¥170,000 - ¥215,000 (~Rp 18-23 jt)',
        };
        document.getElementById('modalRegionSalary').innerText = salaryMap[regKey] || '¥175,000 - ¥225,000';

        // Render prefectures tags
        const prefContainer = document.getElementById('modalPrefecturesList');
        prefContainer.innerHTML = '';
        reg.prefectures.forEach(pref => {
            const span = document.createElement('button');
            span.type = 'button';
            span.className = 'px-3 py-1 rounded-xl bg-slate-800 hover:bg-japan-600 hover:text-white border border-slate-700 text-xs text-slate-200 font-medium transition active:scale-[0.97]';
            span.innerText = pref;
            span.onclick = () => {
                closeRegionSpotlight();
                filterByPrefecture(pref);
            };
            prefContainer.appendChild(span);
        });

        const modal = document.getElementById('regionSpotlightModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        lucide.createIcons();
    }

    function closeRegionSpotlight() {
        const modal = document.getElementById('regionSpotlightModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Alumni Story Spotlight Modal handlers
    function openAlumniStory(t) {
        if (!t) return;

        document.getElementById('storyModalAvatar').src = t.avatar || '/images/default-avatar.png';
        document.getElementById('storyModalTag').innerText = t.tag || 'Alumni Sukses';
        document.getElementById('storyModalName').innerText = t.name;
        document.getElementById('storyModalPrefecture').innerText = `${t.prefecture}, Jepang`;
        document.getElementById('storyModalProgram').innerText = t.program;
        document.getElementById('storyModalCompany').innerText = t.company;
        document.getElementById('storyModalSalary').innerText = t.salary;
        document.getElementById('storyModalOrigin').innerText = t.origin;
        document.getElementById('storyModalQuote').innerText = `"${t.quote}"`;

        @php
            $cleanWaMap = preg_replace('/[^0-9]/', '', $settings['contact_whatsapp'] ?? '6281234567890');
            if (str_starts_with($cleanWaMap, '0')) $cleanWaMap = '62' . substr($cleanWaMap, 1);
        @endphp
        const waMsg = encodeURIComponent(`Halo Sensei LPK Sahabat Jepang Indonesia! Saya membaca kisah sukses alumni atas nama ${t.name} di ${t.company} (${t.prefecture}, program ${t.program}). Saya ingin konsultasi alur pendaftaran dan persiapan seleksi agar bisa berkarir seperti ${t.name}.`);
        document.getElementById('storyModalWaBtn').href = `https://api.whatsapp.com/send?phone={{ $cleanWaMap }}&text=${waMsg}`;

        const modal = document.getElementById('alumniStoryModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        if (window.lucide) lucide.createIcons();
    }

    function closeAlumniStory() {
        const modal = document.getElementById('alumniStoryModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Filter by clicking prefecture tag
    function filterByPrefecture(prefName) {
        if (!prefName) return;
        const searchInput = document.getElementById('alumniSearchInput');
        if (searchInput) {
            searchInput.value = prefName;
            filterAlumniDatabase();
            searchInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    // Real-time client-side live filter
    function filterAlumniDatabase() {
        const q = (document.getElementById('alumniSearchInput')?.value || '').toLowerCase().trim();
        const clearBtn = document.getElementById('clearSearchBtn');
        const countText = document.getElementById('alumniSearchCount');
        const emptyState = document.getElementById('noAlumniFoundState');
        const filterBadge = document.getElementById('activePrefectureFilterBadge');
        const filterBadgeName = document.getElementById('activePrefectureFilterName');

        if (clearBtn) {
            if (q.length > 0) clearBtn.classList.remove('hidden');
            else clearBtn.classList.add('hidden');
        }

        if (filterBadge && filterBadgeName) {
            if (q.length > 0) {
                filterBadgeName.innerText = q.charAt(0).toUpperCase() + q.slice(1);
                filterBadge.classList.remove('hidden');
                filterBadge.classList.add('inline-flex');
            } else {
                filterBadge.classList.add('hidden');
                filterBadge.classList.remove('inline-flex');
            }
        }

        let studentMatches = 0;
        let testimonialMatches = 0;

        // Filter student cards
        document.querySelectorAll('.student-card').forEach(card => {
            const name = card.getAttribute('data-name') || '';
            const jpname = card.getAttribute('data-jpname') || '';
            const pref = card.getAttribute('data-prefecture') || '';
            const company = card.getAttribute('data-company') || '';
            const program = card.getAttribute('data-program') || '';

            const isMatch = !q || name.includes(q) || jpname.includes(q) || pref.includes(q) || company.includes(q) || program.includes(q);
            if (isMatch) {
                card.classList.remove('hidden');
                studentMatches++;
            } else {
                card.classList.add('hidden');
            }
        });

        // Filter testimonial cards
        document.querySelectorAll('.testimonial-card').forEach(card => {
            const name = card.getAttribute('data-name') || '';
            const pref = card.getAttribute('data-prefecture') || '';
            const company = card.getAttribute('data-company') || '';
            const program = card.getAttribute('data-program') || '';

            const isMatch = !q || name.includes(q) || pref.includes(q) || company.includes(q) || program.includes(q);
            if (isMatch) {
                card.classList.remove('hidden');
                testimonialMatches++;
            } else {
                card.classList.add('hidden');
            }
        });

        const totalVisible = studentMatches + testimonialMatches;
        if (countText) {
            if (q.length > 0) {
                countText.innerText = `Ditemukan ${totalVisible} hasil untuk "${q}"`;
            } else {
                countText.innerText = 'Menampilkan semua alumni & siswa terverifikasi';
            }
        }

        if (emptyState) {
            if (totalVisible === 0 && q.length > 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }
    }

    function clearAlumniSearch() {
        const searchInput = document.getElementById('alumniSearchInput');
        if (searchInput) {
            searchInput.value = '';
            filterAlumniDatabase();
        }
    }
</script>
@endsection
