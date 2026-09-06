@extends('admin.layouts.admin')

@section('title', 'Pusat Checklist & Verifikasi Dokumen Kesiapan Terbang ke Jepang')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-black tracking-wider uppercase border border-emerald-200">
                    Sending Organization (SO) Kemenaker RI
                </span>
                <span class="px-2.5 py-0.5 rounded-md bg-red-50 text-red-700 text-[10px] font-black tracking-wider uppercase border border-red-200">
                    Flight Readiness Tracker
                </span>
                <span class="text-slate-400 text-xs">•</span>
                <span class="text-xs text-slate-500 font-bold">SOP Verifikasi Terbang ke Jepang</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-1 flex items-center gap-2.5">
                <span>Flight Readiness Tracker - Checklist & Verifikasi Dokumen Terbang</span>
                <span class="text-base">✈️🇯🇵</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">
                Pantau kelengkapan 8 dokumen esensial siswa menuju Jepang (Paspor, MCU Fit, Sertifikat Bahasa/SSW, CoE, & Visa Kerja).
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <a 
                href="{{ route('admin.flight-readiness.export.pdf', request()->query()) }}" 
                target="_blank" 
                class="px-4 py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-sm flex items-center gap-2 transition cursor-pointer"
                title="Cetak Lembar Rekapitulasi Dokumen Resmi A4 Landscape"
            >
                <i data-lucide="printer" class="w-4 h-4 text-emerald-400"></i>
                <span>Cetak Rekap Kesiapan A4</span>
            </a>

            <a 
                href="{{ route('admin.students.index') }}" 
                class="px-4 py-2.5 rounded-2xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs shadow-xs flex items-center gap-2 transition"
            >
                <i data-lucide="users" class="w-4 h-4 text-slate-500"></i>
                <span>Master Data Siswa</span>
            </a>
        </div>
    </div>

    <!-- 4 KPI Metrics Card -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Kandidat Keberangkatan -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs space-y-1.5">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-500">Kandidat Terbang</span>
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i data-lucide="plane" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="text-2xl font-black text-slate-900">{{ number_format($totalCandidates) }} <span class="text-xs font-semibold text-slate-400">Siswa</span></h3>
            <p class="text-[11px] text-slate-400">Tahap wawancara, lolos matching & proses visa</p>
        </div>

        <!-- 2. Siap Terbang (100% Dokumen Lengkap) -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs space-y-1.5">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-emerald-700">100% Siap Terbang</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="text-2xl font-black text-emerald-700">{{ number_format($readyCount) }} <span class="text-xs font-semibold text-slate-400">Siswa</span></h3>
            <p class="text-[11px] text-emerald-600/80 font-medium">Paspor, MCU Fit, CoE & Visa lengkap</p>
        </div>

        <!-- 3. Menunggu Visa Kedutaan -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs space-y-1.5">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-blue-700">Menunggu Visa</span>
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i data-lucide="file-badge" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="text-2xl font-black text-blue-700">{{ number_format($waitingVisaCount) }} <span class="text-xs font-semibold text-slate-400">Siswa</span></h3>
            <p class="text-[11px] text-slate-400">CoE telah terbit, proses pengajuan visa</p>
        </div>

        <!-- 4. Menunggu CoE Imigrasi Jepang -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs space-y-1.5">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-amber-700">Menunggu CoE</span>
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="text-2xl font-black text-amber-700">{{ number_format($waitingCoeCount) }} <span class="text-xs font-semibold text-slate-400">Siswa</span></h3>
            <p class="text-[11px] text-slate-400">Lolos seleksi, berkas diajukan ke Jepang</p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs">
        <form action="{{ route('admin.flight-readiness.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <!-- Search -->
            <div class="lg:col-span-2">
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Pencarian Siswa / Kaisha:</label>
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-3"></i>
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="Nama siswa, NIS, Kaisha, No Paspor..." 
                        class="w-full pl-9 pr-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>
            </div>

            <!-- Program -->
            <div>
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Program:</label>
                <select name="program" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-white">
                    <option value="all">Semua Program</option>
                    @foreach($programs as $p)
                        <option value="{{ $p }}" {{ request('program') === $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tahapan Kesiapan -->
            <div>
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Status Kesiapan:</label>
                <select name="flight_stage" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-white">
                    <option value="all" {{ request('flight_stage') === 'all' ? 'selected' : '' }}>Semua Tahapan</option>
                    <option value="ready" {{ request('flight_stage') === 'ready' ? 'selected' : '' }}>✈️ 100% Siap Terbang</option>
                    <option value="waiting_visa" {{ request('flight_stage') === 'waiting_visa' ? 'selected' : '' }}>🛂 Menunggu Visa</option>
                    <option value="waiting_coe" {{ request('flight_stage') === 'waiting_coe' ? 'selected' : '' }}>⏳ Menunggu CoE</option>
                    <option value="incomplete" {{ request('flight_stage') === 'incomplete' ? 'selected' : '' }}>⚠️ Dokumen Kurang</option>
                </select>
            </div>

            <!-- Tombol Aksi Filter -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2 px-3.5 rounded-xl bg-japan-600 hover:bg-japan-700 text-white font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-xs">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>Terapkan</span>
                </button>
                <a href="{{ route('admin.flight-readiness.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition" title="Reset Filter">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Alert Banner Feedback -->
    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
    </div>
    @endif

    <!-- Checklist Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-extrabold text-slate-900">Matriks 8 Dokumen Keberangkatan Siswa</h3>
                <p class="text-xs text-slate-400">Klik ikon dokumen untuk melihat pratinjau atau tombol upload cepat untuk memperbarui berkas.</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span> Lengkap</span>
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-slate-200 inline-block"></span> Belum Ada</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-[11px] font-extrabold uppercase tracking-wider">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Kandidat Siswa</th>
                        <th class="py-3.5 px-4">Penempatan Jepang</th>
                        <th class="py-3.5 px-3 text-center" title="Kartu Tanda Penduduk">KTP</th>
                        <th class="py-3.5 px-3 text-center" title="Kartu Keluarga">KK</th>
                        <th class="py-3.5 px-3 text-center" title="Ijazah Terakhir">Ijazah</th>
                        <th class="py-3.5 px-3 text-center" title="Paspor RI">Paspor</th>
                        <th class="py-3.5 px-3 text-center" title="Sertifikat JLPT/JFT">Bahasa</th>
                        <th class="py-3.5 px-3 text-center" title="Sertifikat SSW/Keahlian">SSW</th>
                        <th class="py-3.5 px-3 text-center" title="MCU Fit to Fly">MCU</th>
                        <th class="py-3.5 px-3 text-center" title="CoE & Visa Kerja">CoE & Visa</th>
                        <th class="py-3.5 px-4 text-center">Kesiapan (%)</th>
                        <th class="py-3.5 px-4 text-center">Status Terbang</th>
                        <th class="py-3.5 px-4 text-center">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($students as $idx => $st)
                        @php
                            $docs = [
                                'ktp' => !empty($st->document_ktp),
                                'kk' => !empty($st->document_kk),
                                'ijazah' => !empty($st->document_ijazah),
                                'passport' => !empty($st->document_passport),
                                'cert' => !empty($st->document_certificate),
                                'ssw' => !empty($st->document_ssw),
                                'mcu' => !empty($st->document_mcu) && $st->mcu_result === 'fit',
                                'coe_visa' => !empty($st->document_coe_visa) || (!empty($st->coe_number) && !empty($st->visa_number)),
                            ];
                            $completedCount = count(array_filter($docs));
                            $pct = round(($completedCount / 8) * 100);

                            // Label Status Kesiapan
                            $flightStatus = 'PRE-DEPARTURE';
                            $flightColor = 'bg-slate-100 text-slate-700 border-slate-200';
                            if ($completedCount === 8 || $st->status === 'ready_to_depart') {
                                $flightStatus = 'READY TO FLY ✈️';
                                $flightColor = 'bg-emerald-100 text-emerald-800 border-emerald-300 font-black';
                            } elseif (!empty($st->coe_number) && empty($st->visa_number)) {
                                $flightStatus = 'WAITING VISA 🛂';
                                $flightColor = 'bg-blue-50 text-blue-700 border-blue-200';
                            } elseif ($st->status === 'passed_interview' && empty($st->coe_number)) {
                                $flightStatus = 'WAITING COE ⏳';
                                $flightColor = 'bg-amber-50 text-amber-700 border-amber-200';
                            }
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-4 text-center font-mono text-slate-400">
                                {{ $students->firstItem() + $idx }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center font-black text-slate-600 text-xs overflow-hidden flex-shrink-0">
                                        @if(!empty($st->photo))
                                            <img src="{{ $st->photo }}" alt="{{ $st->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span>{{ strtoupper(substr($st->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.students.show', $st->id) }}" class="font-extrabold text-slate-900 hover:text-japan-600 transition block">
                                            {{ $st->name }}
                                        </a>
                                        <div class="flex items-center gap-1.5 text-[10px] text-slate-400 font-mono">
                                            <span>{{ $st->nis }}</span>
                                            <span>•</span>
                                            <span class="font-sans text-japan-600 font-bold">{{ $st->program }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                @if(!empty($st->destination_company))
                                    <span class="font-bold text-slate-800 block truncate max-w-[150px]" title="{{ $st->destination_company }}">
                                        {{ $st->destination_company }}
                                    </span>
                                    <span class="text-[10px] text-slate-500 flex items-center gap-1">
                                        <i data-lucide="map-pin" class="w-3 h-3 text-red-500"></i>
                                        <span>{{ $st->destination_prefecture ?: 'Jepang' }}</span>
                                        @if($st->departure_date)
                                            <span class="text-slate-400">• {{ \Carbon\Carbon::parse($st->departure_date)->format('d/m/y') }}</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-[11px] text-slate-400 italic">Belum matching kaisha</span>
                                @endif
                            </td>

                            <!-- 1. KTP -->
                            <td class="py-3 px-3 text-center">
                                @if(!empty($st->document_ktp))
                                    <button type="button" onclick="previewDoc('KTP Siswa - {{ addslashes($st->name) }}', '{{ $st->document_ktp }}')" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center mx-auto transition" title="Lihat KTP">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                @else
                                    <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-300 flex items-center justify-center mx-auto text-[10px] font-bold">-</span>
                                @endif
                            </td>

                            <!-- 2. KK -->
                            <td class="py-3 px-3 text-center">
                                @if(!empty($st->document_kk))
                                    <button type="button" onclick="previewDoc('Kartu Keluarga - {{ addslashes($st->name) }}', '{{ $st->document_kk }}')" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center mx-auto transition" title="Lihat Kartu Keluarga">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                @else
                                    <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-300 flex items-center justify-center mx-auto text-[10px] font-bold">-</span>
                                @endif
                            </td>

                            <!-- 3. Ijazah -->
                            <td class="py-3 px-3 text-center">
                                @if(!empty($st->document_ijazah))
                                    <button type="button" onclick="previewDoc('Ijazah Terakhir - {{ addslashes($st->name) }}', '{{ $st->document_ijazah }}')" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center mx-auto transition" title="Lihat Ijazah">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                @else
                                    <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-300 flex items-center justify-center mx-auto text-[10px] font-bold">-</span>
                                @endif
                            </td>

                            <!-- 4. Paspor -->
                            <td class="py-3 px-3 text-center">
                                @if(!empty($st->document_passport))
                                    <button type="button" onclick="previewDoc('Paspor RI - {{ addslashes($st->name) }}', '{{ $st->document_passport }}')" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center mx-auto transition" title="Paspor: {{ $st->passport_number ?: 'Tersedia' }} (Exp: {{ $st->passport_expiry ? \Carbon\Carbon::parse($st->passport_expiry)->format('d/m/Y') : '-' }})">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                @else
                                    <span class="w-6 h-6 rounded-md bg-rose-50 text-rose-300 flex items-center justify-center mx-auto text-[10px] font-bold" title="Paspor belum diunggah">&times;</span>
                                @endif
                            </td>

                            <!-- 5. Bahasa -->
                            <td class="py-3 px-3 text-center">
                                @if(!empty($st->document_certificate))
                                    <button type="button" onclick="previewDoc('Sertifikat Bahasa - {{ addslashes($st->name) }}', '{{ $st->document_certificate }}')" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center mx-auto transition" title="Sertifikat {{ $st->japanese_level ?: 'Bahasa' }}">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                @else
                                    <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-300 flex items-center justify-center mx-auto text-[10px] font-bold">-</span>
                                @endif
                            </td>

                            <!-- 6. SSW -->
                            <td class="py-3 px-3 text-center">
                                @if(!empty($st->document_ssw))
                                    <button type="button" onclick="previewDoc('Sertifikat SSW - {{ addslashes($st->name) }}', '{{ $st->document_ssw }}')" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center mx-auto transition" title="Sertifikat Keahlian: {{ $st->ssw_certificate ?: 'Ada' }}">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                @else
                                    <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-300 flex items-center justify-center mx-auto text-[10px] font-bold">-</span>
                                @endif
                            </td>

                            <!-- 7. MCU -->
                            <td class="py-3 px-3 text-center">
                                @if(!empty($st->document_mcu) && $st->mcu_result === 'fit')
                                    <button type="button" onclick="previewDoc('MCU Fit to Fly - {{ addslashes($st->name) }}', '{{ $st->document_mcu }}')" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center mx-auto transition" title="MCU: FIT (Klinik: {{ $st->mcu_clinic ?: '-' }})">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                @elseif(!empty($st->document_mcu))
                                    <button type="button" onclick="previewDoc('Hasil MCU ({{ $st->mcu_result }}) - {{ addslashes($st->name) }}', '{{ $st->document_mcu }}')" class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 flex items-center justify-center mx-auto transition" title="MCU: {{ strtoupper($st->mcu_result) }}">
                                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    </button>
                                @else
                                    <span class="w-6 h-6 rounded-md bg-rose-50 text-rose-300 flex items-center justify-center mx-auto text-[10px] font-bold" title="Belum ada berkas MCU">&times;</span>
                                @endif
                            </td>

                            <!-- 8. CoE & Visa -->
                            <td class="py-3 px-3 text-center">
                                @if(!empty($st->document_coe_visa))
                                    <button type="button" onclick="previewDoc('CoE & Visa Kerja - {{ addslashes($st->name) }}', '{{ $st->document_coe_visa }}')" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center mx-auto transition" title="CoE: {{ $st->coe_number ?: 'Ada' }} • Visa: {{ $st->visa_number ?: 'Ada' }}">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                @else
                                    <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-300 flex items-center justify-center mx-auto text-[10px] font-bold">-</span>
                                @endif
                            </td>

                            <!-- Kesiapan Progress Bar -->
                            <td class="py-3 px-4 text-center">
                                <div class="w-20 mx-auto space-y-1">
                                    <div class="flex items-center justify-between text-[10px] font-mono font-bold">
                                        <span class="{{ $pct === 100 ? 'text-emerald-700' : 'text-slate-600' }}">{{ $completedCount }}/8</span>
                                        <span class="{{ $pct === 100 ? 'text-emerald-700' : 'text-slate-500' }}">{{ $pct }}%</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $pct === 100 ? 'bg-emerald-500' : ($pct >= 60 ? 'bg-blue-500' : 'bg-amber-500') }}" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            </td>

                            <!-- Status Terbang -->
                            <td class="py-3 px-4 text-center">
                                <span class="inline-block px-2.5 py-1 rounded-full text-[10px] border {{ $flightColor }}">
                                    {{ $flightStatus }}
                                </span>
                            </td>

                            <!-- Aksi Cepat -->
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Quick Upload Document -->
                                    <button 
                                        type="button" 
                                        onclick="openQuickUploadModal('{{ $st->id }}', '{{ addslashes($st->name) }}', '{{ $st->nis }}')" 
                                        class="p-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold transition cursor-pointer"
                                        title="Upload Cepat Dokumen Keberangkatan"
                                    >
                                        <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                                    </button>

                                    <!-- Update Status & Kaisha -->
                                    <button 
                                        type="button" 
                                        onclick='openUpdateStatusModal({{ $st->id }}, "{{ addslashes($st->name) }}", @json($st))' 
                                        class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold transition cursor-pointer"
                                        title="Perbarui Data Kaisha, CoE, Visa & Status"
                                    >
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    </button>

                                    <!-- Cetak Lembar Profil Siswa -->
                                    <a 
                                        href="{{ route('admin.students.print', $st->id) }}" 
                                        target="_blank" 
                                        class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition"
                                        title="Cetak Dossier Lengkap Siswa (PDF)"
                                    >
                                        <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="p-8 text-center text-slate-400 italic">
                                Belum ada data siswa kandidat keberangkatan yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $students->links() }}
        </div>
        @endif
    </div>

</div>

<!-- Modal 1: Quick Upload Document -->
<div id="quickUploadModal" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs hidden items-center justify-center p-4" onclick="if(event.target === this) closeQuickUploadModal()">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i data-lucide="upload-cloud" class="w-5 h-5 text-emerald-600"></i>
                </div>
                <div>
                    <h4 class="text-sm font-extrabold text-slate-900">Upload Cepat Dokumen Siswa</h4>
                    <p class="text-[11px] text-slate-400"><span id="quModalStudentName">Nama Siswa</span> (<span id="quModalStudentNis">NIS</span>)</p>
                </div>
            </div>
            <button type="button" onclick="closeQuickUploadModal()" class="text-slate-400 hover:text-slate-700 text-xl font-bold p-1">&times;</button>
        </div>

        <form action="" method="POST" id="quickUploadForm" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Jenis Dokumen:</label>
                <select name="doc_type" id="quDocType" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-white font-medium">
                    <option value="passport">🛂 Paspor RI (Halaman Identitas)</option>
                    <option value="mcu">🏥 Hasil MCU Fit to Fly</option>
                    <option value="coe_visa">📜 Certificate of Eligibility (CoE) & Visa</option>
                    <option value="certificate">🎓 Sertifikat Bahasa (JLPT / JFT-Basic)</option>
                    <option value="ssw">🛠️ Sertifikat Keahlian SSW / Magang</option>
                    <option value="ktp">🪪 Kartu Tanda Penduduk (KTP)</option>
                    <option value="kk">👨‍👩‍👧‍👦 Kartu Keluarga (KK)</option>
                    <option value="ijazah">📜 Ijazah Terakhir</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Berkas Fisik (PDF / JPG / PNG / WEBP):</label>
                <input 
                    type="file" 
                    name="file" 
                    required 
                    accept=".jpg,.jpeg,.png,.webp,.pdf"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-dashed border-slate-300 text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer"
                >
                <p class="text-[10px] text-slate-400 mt-1">Otomatis dikompresi proporsional dan tersimpan ke Arsip Digital lembaga.</p>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeQuickUploadModal()" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-md flex items-center gap-1.5">
                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    <span>Simpan Dokumen</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Update Status & Keberangkatan -->
<div id="updateStatusModal" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs hidden items-center justify-center p-4" onclick="if(event.target === this) closeUpdateStatusModal()">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i data-lucide="plane" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div>
                    <h4 class="text-sm font-extrabold text-slate-900">Perbarui Status & Data Keberangkatan</h4>
                    <p class="text-[11px] text-slate-400" id="usModalTitle">Nama Siswa</p>
                </div>
            </div>
            <button type="button" onclick="closeUpdateStatusModal()" class="text-slate-400 hover:text-slate-700 text-xl font-bold p-1">&times;</button>
        </div>

        <form action="" method="POST" id="updateStatusForm" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Perusahaan Kaisha (Jepang):</label>
                    <input type="text" name="destination_company" id="usCompany" placeholder="Contoh: Toyota Boshoku Corp" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Prefektur Penempatan:</label>
                    <input type="text" name="destination_prefecture" id="usPrefecture" placeholder="Contoh: Aichi / Tokyo / Osaka" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Target Tanggal Terbang (Departure):</label>
                    <input type="date" name="departure_date" id="usDepartureDate" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Keberangkatan:</label>
                    <select name="status" id="usStudentStatus" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="active">Aktif Belajar (Kelas)</option>
                        <option value="interview">Sedang Wawancara Kaisha</option>
                        <option value="passed_interview">Lolos Wawancara (Matching)</option>
                        <option value="visa_processing">Proses CoE / Visa Kerja</option>
                        <option value="ready_to_depart">Siap Terbang (Ready to Fly)</option>
                        <option value="departed">Sudah Berangkat ke Jepang</option>
                    </select>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                <h5 class="text-xs font-black uppercase tracking-wider text-slate-800">Detail Paspor, MCU & Visa</h5>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-0.5">Nomor Paspor:</label>
                        <input type="text" name="passport_number" id="usPassportNo" placeholder="Contoh: X1234567" class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-0.5">Masa Berlaku Paspor:</label>
                        <input type="date" name="passport_expiry" id="usPassportExp" class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-0.5">Hasil MCU:</label>
                        <select name="mcu_result" id="usMcuResult" class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs bg-white">
                            <option value="">Belum MCU</option>
                            <option value="fit">Fit / Layak Terbang ✅</option>
                            <option value="unfit">Unfit / Tidak Lolos ❌</option>
                            <option value="follow_up">Perlu Tindak Lanjut ⚠️</option>
                            <option value="pending">Menunggu Hasil ⏳</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-0.5">Klinik / RS Rujukan MCU:</label>
                        <input type="text" name="mcu_clinic" id="usMcuClinic" placeholder="Contoh: RS Pelabuhan Jakarta" class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-0.5">Nomor CoE:</label>
                        <input type="text" name="coe_number" id="usCoeNo" placeholder="Contoh: COE-2026-TOKYO-..." class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-0.5">Nomor Visa Kerja:</label>
                        <input type="text" name="visa_number" id="usVisaNo" placeholder="Contoh: V-JAP-2026-..." class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeUpdateStatusModal()" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-md flex items-center gap-1.5">
                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    <span>Simpan Pembaruan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 3: Document Preview Modal -->
<div id="docPreviewModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-xs hidden items-center justify-center p-4" onclick="if(event.target === this) closeDocPreviewModal()">
    <div class="bg-white rounded-3xl max-w-3xl w-full p-6 shadow-2xl border border-slate-200 space-y-4 max-h-[90vh] flex flex-col">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i data-lucide="file-text" class="w-4 h-4 text-emerald-600"></i>
                </div>
                <div>
                    <h4 class="text-sm font-extrabold text-slate-900" id="dpDocTitle">Pratinjau Dokumen</h4>
                    <p class="text-[10px] text-slate-400">Verifikasi Dokumen Resmi Keberangkatan</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="downloadPreviewedDoc()" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    <span>Unduh</span>
                </button>
                <button type="button" onclick="closeDocPreviewModal()" class="text-slate-400 hover:text-slate-700 text-xl font-bold p-1">&times;</button>
            </div>
        </div>

        <div id="dpContentContainer" class="flex-1 overflow-auto flex items-center justify-center bg-slate-900/5 rounded-2xl p-4 min-h-[300px]">
            <!-- Content Injected via JS -->
        </div>
    </div>
</div>

<script>
    let currentPreviewUrl = null;
    let currentPreviewTitle = null;

    function previewDoc(title, url) {
        currentPreviewUrl = url;
        currentPreviewTitle = title;
        document.getElementById('dpDocTitle').textContent = title;
        const container = document.getElementById('dpContentContainer');
        container.innerHTML = '';

        if (url.startsWith('data:application/pdf')) {
            container.innerHTML = `<iframe src="${url}" class="w-full h-[60vh] rounded-xl border border-slate-200"></iframe>`;
        } else if (url.startsWith('data:image/') || url.startsWith('http')) {
            container.innerHTML = `<img src="${url}" alt="${title}" class="max-h-[60vh] max-w-full object-contain rounded-xl shadow-md border border-slate-200 bg-white">`;
        } else {
            container.innerHTML = `<div class="text-center p-8 text-slate-400 text-xs font-medium">Format dokumen tidak didukung untuk pratinjau langsung. Silakan klik tombol Unduh.</div>`;
        }

        const modal = document.getElementById('docPreviewModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        if (window.lucide) lucide.createIcons();
    }

    function closeDocPreviewModal() {
        const modal = document.getElementById('docPreviewModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function downloadPreviewedDoc() {
        if (!currentPreviewUrl) return;
        const a = document.createElement('a');
        a.href = currentPreviewUrl;
        a.download = (currentPreviewTitle || 'Dokumen').replace(/[^a-zA-Z0-9_-]/g, '_') + '.jpg';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    function openQuickUploadModal(id, name, nis) {
        const form = document.getElementById('quickUploadForm');
        form.action = `/admin/flight-readiness/${id}/upload-doc`;
        document.getElementById('quModalStudentName').textContent = name;
        document.getElementById('quModalStudentNis').textContent = nis;

        const modal = document.getElementById('quickUploadModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        if (window.lucide) lucide.createIcons();
    }

    function closeQuickUploadModal() {
        const modal = document.getElementById('quickUploadModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openUpdateStatusModal(id, name, student) {
        const form = document.getElementById('updateStatusForm');
        form.action = `/admin/flight-readiness/${id}/status`;
        document.getElementById('usModalTitle').textContent = `${name} (${student.nis || ''})`;

        document.getElementById('usCompany').value = student.destination_company || '';
        document.getElementById('usPrefecture').value = student.destination_prefecture || '';
        document.getElementById('usDepartureDate').value = student.departure_date ? student.departure_date.substring(0, 10) : '';
        document.getElementById('usStudentStatus').value = student.status || 'active';

        document.getElementById('usPassportNo').value = student.passport_number || '';
        document.getElementById('usPassportExp').value = student.passport_expiry ? student.passport_expiry.substring(0, 10) : '';
        document.getElementById('usMcuResult').value = student.mcu_result || '';
        document.getElementById('usMcuClinic').value = student.mcu_clinic || '';
        document.getElementById('usCoeNo').value = student.coe_number || '';
        document.getElementById('usVisaNo').value = student.visa_number || '';

        const modal = document.getElementById('updateStatusModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        if (window.lucide) lucide.createIcons();
    }

    function closeUpdateStatusModal() {
        const modal = document.getElementById('updateStatusModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection
