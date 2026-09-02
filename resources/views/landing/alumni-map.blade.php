@extends('layouts.app')

@section('title', 'Peta Interaktif Sebaran Alumni di Seluruh Jepang - LPK Sahabat Jepang Indonesia')

@section('content')
<div class="bg-slate-950 text-white min-h-screen py-12 relative overflow-hidden">

    <!-- Background Accents -->
    <div class="absolute -top-40 -left-40 w-[35rem] h-[35rem] rounded-full bg-red-600/15 blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[30rem] h-[30rem] rounded-full bg-blue-600/10 blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-12">

        <!-- Top Header Hero -->
        <div class="text-center space-y-3 max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold font-japanese">
                <span>日本全国の卒業生ネットワーク • 47 Prefektur</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                Peta Sebaran Alumni di Seluruh Jepang
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Ratusan alumni LPK Sahabat Jepang Indonesia telah berkarya di berbagai kota dan prefektur di Jepang, mulai dari Tokyo, Osaka, Aichi, hingga Hokkaido.
            </p>

            <!-- Quick Live Counter Stats -->
            <div class="pt-6 grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-2xl mx-auto">
                <div class="p-4 rounded-2xl bg-slate-900/90 border border-slate-800 backdrop-blur-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Total Alumni Aktif</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-japan-500 mt-0.5">{{ $totalAlumniCount }}+</h3>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900/90 border border-slate-800 backdrop-blur-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Cakupan Prefektur</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-emerald-400 mt-0.5">47 Wilayah</h3>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900/90 border border-slate-800 backdrop-blur-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Mitra Kaisha</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-blue-400 mt-0.5">85+ PT</h3>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900/90 border border-slate-800 backdrop-blur-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Kelulusan SSW/Visa</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-amber-400 mt-0.5">99.4%</h3>
                </div>
            </div>
        </div>

        <!-- Sector Filters -->
        <div class="flex items-center justify-center gap-2 flex-wrap">
            <a 
                href="{{ route('alumni.map') }}" 
                class="px-4 py-2 rounded-xl text-xs font-extrabold transition {{ empty($selectedSector) ? 'bg-japan-600 text-white shadow-lg shadow-red-600/30' : 'bg-slate-900 border border-slate-800 text-slate-400 hover:text-white' }}"
            >
                Semua Sektor Karir
            </a>
            @foreach(['Kaigo' => 'Kaigo / Caregiver', 'Makanan' => 'Pengolahan Makanan', 'Manufaktur' => 'Manufaktur Mesin', 'Pertanian' => 'Pertanian (Nougyou)', 'Konstruksi' => 'Konstruksi', 'Perhotelan' => 'Perhotelan'] as $secKey => $secLbl)
                <a 
                    href="{{ route('alumni.map', ['sector' => $secKey]) }}" 
                    class="px-4 py-2 rounded-xl text-xs font-extrabold transition {{ $selectedSector === $secKey ? 'bg-japan-600 text-white shadow-lg shadow-red-600/30' : 'bg-slate-900 border border-slate-800 text-slate-400 hover:text-white' }}"
                >
                    {{ $secLbl }}
                </a>
            @endforeach
        </div>

        <!-- 8 Regions Interactive Showcase Grid -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-black text-white">Wilayah & Konsentrasi Alumni di Jepang</h3>
                    <p class="text-xs text-slate-400">Pilih wilayah untuk melihat sebaran penempatan kerja</p>
                </div>
                <span class="font-japanese text-xs text-red-400">日本全国 8地方</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($regions as $regKey => $reg)
                    <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 hover:border-japan-600 transition-all duration-200 group space-y-3 flex flex-col justify-between">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase text-white {{ $reg['color'] }}">
                                    {{ $reg['count'] }} Alumni
                                </span>
                                <i data-lucide="map-pin" class="w-4 h-4 text-red-400 group-hover:scale-110 transition"></i>
                            </div>

                            <h4 class="font-black text-white text-base group-hover:text-red-400 transition">{{ $reg['name'] }}</h4>
                            <p class="text-xs text-slate-300 font-semibold font-japanese">{{ $reg['hub'] }}</p>

                            <div class="pt-2 flex flex-wrap gap-1">
                                @foreach($reg['prefectures'] as $pref)
                                    <span class="px-2 py-0.5 rounded bg-slate-800 text-[10px] text-slate-400">
                                        {{ $pref }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-400">
                            <span>Status: Aktif Bekerja</span>
                            <span class="text-japan-400 font-bold">100% Legal</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Alumni Stories & Real Placement Showcase -->
        <div class="space-y-6 pt-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-black text-white">Kisah Sukses & Penempatan Kaisha Alumni</h3>
                    <p class="text-xs text-slate-400">Kandidat yang telah resmi terbang dan bekerja di berbagai prefektur Jepang</p>
                </div>
                <button onclick="openModal('consultationModal')" class="hidden sm:flex btn-red-primary px-4 py-2 rounded-xl text-xs font-bold items-center gap-1.5 shadow-md">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    <span>Ikuti Jejak Mereka</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($testimonials as $t)
                    <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 space-y-4 flex flex-col justify-between hover:border-slate-700 transition">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $t->avatar }}" alt="{{ $t->name }}" class="w-12 h-12 rounded-2xl object-cover border-2 border-japan-600 flex-shrink-0">
                                <div>
                                    <h4 class="font-extrabold text-white text-sm">{{ $t->name }}</h4>
                                    <p class="text-[11px] text-red-400 font-semibold font-japanese flex items-center gap-1">
                                        <i data-lucide="map-pin" class="w-3 h-3"></i>
                                        <span>{{ $t->prefecture }}, Jepang</span>
                                    </p>
                                </div>
                            </div>

                            <div class="p-3 rounded-2xl bg-slate-800/60 border border-slate-700/60 text-xs space-y-1 font-mono">
                                <div class="flex justify-between text-slate-400">
                                    <span>Program:</span>
                                    <span class="text-white font-bold">{{ $t->program }}</span>
                                </div>
                                <div class="flex justify-between text-slate-400">
                                    <span>Kaisha:</span>
                                    <span class="text-white font-bold">{{ $t->company }}</span>
                                </div>
                                <div class="flex justify-between text-slate-400">
                                    <span>Gaji Bersih:</span>
                                    <span class="text-emerald-400 font-bold">{{ $t->salary }}</span>
                                </div>
                            </div>

                            <p class="text-xs text-slate-300 italic leading-relaxed">
                                "{{ $t->quote }}"
                            </p>
                        </div>

                        <div class="pt-3 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Asal: {{ $t->origin }}</span>
                            <span class="text-japan-400 font-bold">{{ $t->tag ?? 'Alumni Sukses' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- CTA Bottom Card -->
        <div class="p-8 sm:p-12 rounded-3xl bg-gradient-to-r from-japan-900 via-japan-700 to-red-600 text-white text-center space-y-4 shadow-2xl">
            <h2 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                Giliran Anda Bekerja & Berpenghasilan Puluhan Juta di Jepang
            </h2>
            <p class="text-xs sm:text-sm text-red-100 max-w-xl mx-auto">
                Konsultasikan kualifikasi dan pilihan sektor kerja yang Anda inginkan bersama tim konselor profesional LPK Sahabat Jepang Indonesia.
            </p>
            <div class="pt-2 flex items-center justify-center gap-3">
                <button onclick="openModal('consultationModal')" class="px-8 py-3.5 rounded-2xl bg-white text-japan-700 font-black text-xs sm:text-sm hover:bg-red-50 transition shadow-lg shadow-black/20 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-4 h-4 text-amber-500"></i>
                    <span>Daftar Konsultasi Karir Gratis</span>
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
