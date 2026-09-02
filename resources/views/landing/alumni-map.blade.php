@extends('layouts.app')

@section('title', 'Peta Interaktif Sebaran Alumni di Seluruh Jepang - LPK Sahabat Jepang Indonesia')

@section('content')
<div class="bg-slate-950 text-white min-h-screen py-10 sm:py-16 relative overflow-hidden">

    <!-- Japanese Red & Sakura Ambient Glows -->
    <div class="absolute -top-40 -left-40 w-[35rem] h-[35rem] rounded-full bg-red-600/15 blur-[140px] pointer-events-none"></div>
    <div class="absolute top-1/3 -right-40 w-[30rem] h-[30rem] rounded-full bg-rose-600/10 blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-10 left-1/3 w-[35rem] h-[35rem] rounded-full bg-blue-600/10 blur-[140px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-12">

        <!-- Top Header Hero -->
        <div class="text-center space-y-4 max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold font-japanese shadow-sm">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                <span>日本全国の卒業生ネットワーク • 47 Prefektur Jepang</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                Peta Sebaran Alumni di Seluruh Jepang
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-2xl mx-auto">
                Ratusan alumni LPK Sahabat Jepang Indonesia telah resmi berkarir dan tersebar di 8 wilayah utama dan 47 prefektur Jepang, dari Tokyo, Nagoya, Osaka, hingga Fukuoka dan Hokkaido.
            </p>

            <!-- Quick Live Counter Stats -->
            <div class="pt-6 grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-3xl mx-auto">
                <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 backdrop-blur-md text-center hover:border-red-500/50 transition">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Total Alumni Bekerja</span>
                    <h3 class="text-3xl font-black text-japan-500 mt-1">{{ $totalAlumniCount }}+</h3>
                    <p class="text-[10px] text-slate-500 mt-0.5">Peserta Aktif di Jepang</p>
                </div>
                <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 backdrop-blur-md text-center hover:border-emerald-500/50 transition">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Cakupan Wilayah</span>
                    <h3 class="text-3xl font-black text-emerald-400 mt-1">47 Prefektur</h3>
                    <p class="text-[10px] text-slate-500 mt-0.5">8 Region Utama</p>
                </div>
                <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 backdrop-blur-md text-center hover:border-blue-500/50 transition">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Mitra Kaisha</span>
                    <h3 class="text-3xl font-black text-blue-400 mt-1">85+ Perusahaan</h3>
                    <p class="text-[10px] text-slate-500 mt-0.5">Kerjasama Resmi SO</p>
                </div>
                <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 backdrop-blur-md text-center hover:border-amber-500/50 transition">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Tingkat Kelulusan</span>
                    <h3 class="text-3xl font-black text-amber-400 mt-1">99.4%</h3>
                    <p class="text-[10px] text-slate-500 mt-0.5">Visa & COE Terbit</p>
                </div>
            </div>
        </div>

        <!-- Sektor Karir Filter Pills -->
        <div class="flex items-center justify-center gap-2 flex-wrap bg-slate-900/80 p-2 rounded-3xl border border-slate-800/80 max-w-4xl mx-auto backdrop-blur-md">
            <a 
                href="{{ route('alumni.map') }}" 
                class="px-4 py-2 rounded-2xl text-xs font-black transition {{ empty($selectedSector) ? 'bg-japan-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}"
            >
                Semua Sektor Karir
            </a>
            @foreach(['Kaigo' => 'Kaigo / Caregiver', 'Makanan' => 'Pengolahan Makanan', 'Manufaktur' => 'Manufaktur Mesin', 'Pertanian' => 'Pertanian (Nougyou)', 'Konstruksi' => 'Konstruksi', 'Perhotelan' => 'Perhotelan'] as $secKey => $secLbl)
                <a 
                    href="{{ route('alumni.map', ['sector' => $secKey]) }}" 
                    class="px-4 py-2 rounded-2xl text-xs font-black transition {{ $selectedSector === $secKey ? 'bg-japan-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}"
                >
                    {{ $secLbl }}
                </a>
            @endforeach
        </div>

        <!-- 8 Regions Japan Matrix Showcase -->
        <div class="space-y-5">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <div>
                    <h3 class="text-xl font-black text-white flex items-center gap-2">
                        <i data-lucide="map" class="w-5 h-5 text-japan-500"></i>
                        <span>Sebaran 8 Wilayah & Prefektur di Jepang</span>
                    </h3>
                    <p class="text-xs text-slate-400">Peta konsentrasi penempatan kerja alumni LPK Sahabat Jepang Indonesia</p>
                </div>
                <span class="font-japanese text-xs text-red-400 font-bold hidden sm:inline">日本全国 8地方ネットワーク</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($regions as $regKey => $reg)
                    <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 hover:border-japan-600 transition-all duration-300 group space-y-4 flex flex-col justify-between shadow-lg hover:shadow-red-600/10">
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
                                <h4 class="font-black text-white text-base group-hover:text-red-400 transition">{{ $reg['name'] }}</h4>
                                <p class="text-xs text-japan-400 font-bold font-japanese mt-0.5">{{ $reg['hub'] }}</p>
                            </div>

                            <div class="pt-2 flex flex-wrap gap-1.5">
                                @foreach($reg['prefectures'] as $pref)
                                    <span class="px-2.5 py-1 rounded-lg bg-slate-800/90 border border-slate-700/60 text-[10px] text-slate-300 font-medium">
                                        {{ $pref }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-800 flex items-center justify-between text-xs text-slate-400">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>Status: Aktif</span>
                            </span>
                            <span class="text-japan-400 font-bold font-mono">100% Legal</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Real Alumni Stories & Verified Kaisha Placements -->
        <div class="space-y-6 pt-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-800 pb-4">
                <div>
                    <h3 class="text-2xl font-black text-white flex items-center gap-2">
                        <i data-lucide="award" class="w-6 h-6 text-amber-500"></i>
                        <span>Kisah Sukses & Penempatan Kaisha Alumni</span>
                    </h3>
                    <p class="text-xs text-slate-400">Bukti nyata alumni yang telah sukses bekerja di berbagai kota dan perusahaan di Jepang</p>
                </div>
                <button onclick="openModal('consultationModal')" class="btn-red-primary px-5 py-2.5 rounded-2xl text-xs font-black flex items-center gap-2 shadow-lg shadow-red-600/30">
                    <i data-lucide="sparkles" class="w-4 h-4 text-amber-200"></i>
                    <span>Ikuti Jejak Mereka Sekarang</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($testimonials as $t)
                    <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 space-y-4 flex flex-col justify-between hover:border-red-500/60 transition-all duration-300 shadow-xl group">
                        <div class="space-y-4">
                            
                            <!-- Avatar & Location Header -->
                            <div class="flex items-center gap-3.5">
                                <img src="{{ $t->avatar }}" alt="{{ $t->name }}" class="w-14 h-14 rounded-2xl object-cover border-2 border-japan-600 shadow-md flex-shrink-0 group-hover:scale-105 transition">
                                <div>
                                    <h4 class="font-extrabold text-white text-base leading-tight">{{ $t->name }}</h4>
                                    <p class="text-xs text-red-400 font-bold font-japanese flex items-center gap-1 mt-0.5">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                        <span>{{ $t->prefecture }}, Jepang</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Placement Info Box -->
                            <div class="p-4 rounded-2xl bg-slate-800/80 border border-slate-700/80 text-xs space-y-1.5 font-mono">
                                <div class="flex justify-between text-slate-400">
                                    <span>Program:</span>
                                    <span class="text-white font-bold">{{ $t->program }}</span>
                                </div>
                                <div class="flex justify-between text-slate-400">
                                    <span>Perusahaan:</span>
                                    <span class="text-japan-300 font-bold font-japanese">{{ $t->company }}</span>
                                </div>
                                <div class="flex justify-between text-slate-400 border-t border-slate-700 pt-1.5">
                                    <span>Gaji Bersih / Bulan:</span>
                                    <span class="text-emerald-400 font-black text-sm">{{ $t->salary }}</span>
                                </div>
                            </div>

                            <!-- Quote -->
                            <p class="text-xs sm:text-sm text-slate-300 italic leading-relaxed">
                                "{{ $t->quote }}"
                            </p>
                        </div>

                        <!-- Footer Badge -->
                        <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-500 font-medium">
                            <span>Asal: {{ $t->origin }}</span>
                            <span class="px-2.5 py-0.5 rounded-full bg-red-500/20 text-red-400 font-bold text-[10px] border border-red-500/30">
                                {{ $t->tag ?? 'Alumni Sukses' }}
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
                <button onclick="openModal('consultationModal')" class="px-8 py-3.5 rounded-2xl bg-white text-japan-700 font-black text-xs sm:text-sm hover:bg-red-50 transition shadow-xl shadow-black/30 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-4 h-4 text-amber-500"></i>
                    <span>Daftar Konsultasi Karir Gratis Sekarang</span>
                </button>

                <a href="{{ route('exam.simulator') }}" class="px-6 py-3.5 rounded-2xl bg-red-800/80 hover:bg-red-800 text-white font-bold text-xs sm:text-sm transition border border-red-400/30 flex items-center gap-2">
                    <i data-lucide="file-check" class="w-4 h-4"></i>
                    <span>Coba Tryout JLPT Online</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
