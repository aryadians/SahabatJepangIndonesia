@extends('admin.layouts.admin')

@section('title', 'Dashboard Overview')
@section('page_title', 'Dashboard Ringkasan Eksekutif')

@section('content')
<div class="space-y-6">

    <!-- 1. Executive Welcome Banner -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
        <div class="space-y-2 relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/20 text-red-400 text-xs font-bold border border-red-500/30">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                <span>LPK Sahabat Jepang Indonesia • Portal Administrator</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                Selamat Datang, {{ auth()->user()->name ?? 'Administrator' }}! 👋
            </h2>
            <p class="text-xs sm:text-sm text-slate-400 max-w-xl">
                Pantau perkembangan pendaftar calon siswa, status pelatihan, keberangkatan ke Jepang, serta pengelolaan administrasi keuangan lembaga secara terpadu.
            </p>
        </div>

        <div class="flex items-center gap-3 relative z-10 flex-shrink-0">
            <a 
                href="{{ route('admin.students.create') }}" 
                class="btn-red-primary px-5 py-2.5 rounded-xl text-xs font-bold shadow-lg flex items-center gap-1.5"
            >
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>+ Siswa Baru</span>
            </a>
            <a 
                href="{{ route('home') }}" 
                target="_blank" 
                class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition flex items-center gap-1.5"
            >
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>Lihat Web</span>
            </a>
        </div>
    </div>

    <!-- 2. Primary KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Siswa -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:shadow-md hover:border-slate-300 transition-all duration-200 group relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Siswa</span>
                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[10px] font-bold">Terdata</span>
            </div>
            <div class="flex items-end justify-between mt-2">
                <div>
                    <h3 data-admin-stat="students_total" class="text-3xl font-black text-slate-900 leading-none">{{ number_format($counts['students']) }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Seluruh angkatan</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center font-bold group-hover:bg-slate-900 group-hover:text-white transition">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <a href="{{ route('admin.students.index') }}" class="font-bold text-japan-600 hover:underline">Kelola Data Siswa &rarr;</a>
                <span class="text-slate-400 font-mono text-[10px]">SO Aktif</span>
            </div>
        </div>

        <!-- Siswa Aktif Belajar -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:shadow-md hover:border-blue-300 transition-all duration-200 group relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Aktif Belajar</span>
                <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 text-[10px] font-bold">Pelatihan</span>
            </div>
            <div class="flex items-end justify-between mt-2">
                <div>
                    <h3 data-admin-stat="students_active" class="text-3xl font-black text-blue-600 leading-none">{{ number_format($counts['students_active']) }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Kelas N5 - N3 & Wawancara</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold group-hover:bg-blue-600 group-hover:text-white transition">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-500 font-medium">Pipeline Diklat</span>
                <span class="font-bold text-blue-600">{{ $counts['students'] > 0 ? round(($counts['students_active'] / $counts['students']) * 100) : 0 }}% total</span>
            </div>
        </div>

        <!-- Sudah di Jepang -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:shadow-md hover:border-emerald-300 transition-all duration-200 group relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Sudah di Jepang</span>
                <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Bekerja</span>
                </span>
            </div>
            <div class="flex items-end justify-between mt-2">
                <div>
                    <h3 data-admin-stat="students_departed" class="text-3xl font-black text-emerald-600 leading-none">{{ number_format($counts['students_departed']) }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1">47 Prefektur di Jepang</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold group-hover:bg-emerald-600 group-hover:text-white transition">
                    <i data-lucide="plane" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <a href="{{ route('alumni.map') }}" target="_blank" class="font-bold text-emerald-700 hover:underline">Lihat Peta Sebaran &rarr;</a>
                <span class="text-emerald-600 font-bold font-mono text-[10px]">100% Legal</span>
            </div>
        </div>

        <!-- Sisa Tanggungan / Piutang -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:shadow-md hover:border-amber-300 transition-all duration-200 group relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Sisa Piutang Biaya</span>
                <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 text-[10px] font-bold">{{ $counts['recovery_rate'] }}% Lunas</span>
            </div>
            <div class="flex items-end justify-between mt-2">
                <div>
                    <h3 data-admin-stat="receivables" class="text-xl sm:text-2xl font-black text-amber-600 leading-none">Rp {{ number_format($counts['receivables'], 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Dari total {{ number_format($counts['total_cost'] / 1000000, 1) }} jt</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold group-hover:bg-amber-600 group-hover:text-white transition">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <a href="{{ route('admin.students.index') }}" class="font-bold text-amber-700 hover:underline">Pantau Pembayaran &rarr;</a>
                <span class="text-slate-400 font-mono text-[10px]">Arus Kas</span>
            </div>
        </div>

    </div>

    <!-- 3. Visual Pipeline & Financial Analytics Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Chart 1: Visual Pipeline Keberangkatan & Distribusi Status (7 Cols) -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-5">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                        <i data-lucide="git-commit" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm">Pipeline & Perjalanan Status Siswa</h3>
                        <p class="text-[11px] text-slate-400">Distribusi peserta dari pendaftaran hingga bekerja di Jepang</p>
                    </div>
                </div>
                <span class="text-xs font-bold text-japan-600 bg-red-50 px-2.5 py-1 rounded-xl">
                    Total {{ $counts['students'] }} Siswa
                </span>
            </div>

            @php
                $stTotal = max(1, $counts['students']);
                $pctActive = round(($counts['pipe_active'] / $stTotal) * 100);
                $pctInterview = round(($counts['pipe_interview'] / $stTotal) * 100);
                $pctPassed = round(($counts['pipe_passed'] / $stTotal) * 100);
                $pctDeparted = round(($counts['pipe_departed'] / $stTotal) * 100);
                $pctGraduated = round(($counts['pipe_graduated'] / $stTotal) * 100);
            @endphp

            <!-- Visual Multi-Segment Pipeline Bar -->
            <div class="space-y-2">
                <div class="h-4 w-full bg-slate-100 rounded-full overflow-hidden flex shadow-inner">
                    <div style="width: {{ max(4, $pctActive) }}%" class="bg-blue-500 hover:opacity-90 transition" title="Aktif Belajar: {{ $counts['pipe_active'] }} ({{ $pctActive }}%)"></div>
                    <div style="width: {{ max(3, $pctInterview) }}%" class="bg-amber-500 hover:opacity-90 transition" title="Wawancara User: {{ $counts['pipe_interview'] }} ({{ $pctInterview }}%)"></div>
                    <div style="width: {{ max(3, $pctPassed) }}%" class="bg-indigo-500 hover:opacity-90 transition" title="Lolos / COE: {{ $counts['pipe_passed'] }} ({{ $pctPassed }}%)"></div>
                    <div style="width: {{ max(4, $pctDeparted) }}%" class="bg-emerald-500 hover:opacity-90 transition" title="Sudah di Jepang: {{ $counts['pipe_departed'] }} ({{ $pctDeparted }}%)"></div>
                    <div style="width: {{ max(2, $pctGraduated) }}%" class="bg-purple-500 hover:opacity-90 transition" title="Alumni Selesai: {{ $counts['pipe_graduated'] }} ({{ $pctGraduated }}%)"></div>
                </div>
                <div class="flex justify-between text-[10px] text-slate-400 font-mono">
                    <span>Mulai Belajar</span>
                    <span>Proses Wawancara & COE</span>
                    <span>Terbang & Karir di Jepang</span>
                </div>
            </div>

            <!-- Pipeline Status Cards Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-1">
                <div class="p-3 rounded-2xl bg-blue-50/60 border border-blue-100 space-y-1">
                    <div class="flex items-center gap-1.5 text-blue-700 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <span>Aktif Belajar</span>
                    </div>
                    <p class="text-xl font-black text-slate-900">{{ $counts['pipe_active'] }} <span class="text-xs font-normal text-slate-500">Siswa</span></p>
                    <span class="text-[10px] text-blue-600 font-medium font-mono">{{ $pctActive }}% dari total</span>
                </div>

                <div class="p-3 rounded-2xl bg-amber-50/60 border border-amber-100 space-y-1">
                    <div class="flex items-center gap-1.5 text-amber-700 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span>Tahap Interview</span>
                    </div>
                    <p class="text-xl font-black text-slate-900">{{ $counts['pipe_interview'] }} <span class="text-xs font-normal text-slate-500">Siswa</span></p>
                    <span class="text-[10px] text-amber-600 font-medium font-mono">{{ $pctInterview }}% siap wawancara</span>
                </div>

                <div class="p-3 rounded-2xl bg-indigo-50/60 border border-indigo-100 space-y-1">
                    <div class="flex items-center gap-1.5 text-indigo-700 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                        <span>Lolos / COE</span>
                    </div>
                    <p class="text-xl font-black text-slate-900">{{ $counts['pipe_passed'] }} <span class="text-xs font-normal text-slate-500">Siswa</span></p>
                    <span class="text-[10px] text-indigo-600 font-medium font-mono">{{ $pctPassed }}% pengurusan visa</span>
                </div>

                <div class="p-3 rounded-2xl bg-emerald-50/60 border border-emerald-100 space-y-1">
                    <div class="flex items-center gap-1.5 text-emerald-700 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Di Jepang</span>
                    </div>
                    <p class="text-xl font-black text-slate-900">{{ $counts['pipe_departed'] }} <span class="text-xs font-normal text-slate-500">Siswa</span></p>
                    <span class="text-[10px] text-emerald-600 font-medium font-mono">{{ $pctDeparted }}% resmi bekerja</span>
                </div>

                <div class="p-3 rounded-2xl bg-purple-50/60 border border-purple-100 space-y-1">
                    <div class="flex items-center gap-1.5 text-purple-700 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                        <span>Alumni Sukses</span>
                    </div>
                    <p class="text-xl font-black text-slate-900">{{ $counts['pipe_graduated'] }} <span class="text-xs font-normal text-slate-500">Alumni</span></p>
                    <span class="text-[10px] text-purple-600 font-medium font-mono">{{ $pctGraduated }}% selesai kontrak</span>
                </div>

                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col justify-between">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Success Rate</span>
                    <p class="text-xl font-black text-japan-600">99.4%</p>
                    <span class="text-[10px] text-slate-500">Visa terbit & terbang</span>
                </div>
            </div>
        </div>

        <!-- Chart 2: Visualisasi Intake & Pendaftaran Bulanan (5 Cols) -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4 flex flex-col justify-between">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm">Tren Intake 6 Bulan</h3>
                        <p class="text-[11px] text-slate-400">Siswa baru vs Leads masuk</p>
                    </div>
                </div>
                <span class="text-[11px] font-bold text-slate-400">Bulanan</span>
            </div>

            <!-- Bar Chart Display -->
            <div class="py-2">
                @php
                    $maxVal = 1;
                    foreach($monthlyIntake as $m) {
                        $maxVal = max($maxVal, $m['students'], $m['leads']);
                    }
                @endphp
                <div class="flex items-end justify-between gap-2 h-36 pt-4 px-2 border-b border-slate-100">
                    @foreach($monthlyIntake as $m)
                        @php
                            $stH = round(($m['students'] / $maxVal) * 100);
                            $ldH = round(($m['leads'] / $maxVal) * 100);
                        @endphp
                        <div class="flex-1 flex flex-col items-center h-full justify-end group relative">
                            <!-- Tooltip -->
                            <div class="absolute -top-10 hidden group-hover:flex flex-col items-center z-20 pointer-events-none">
                                <div class="bg-slate-900 text-white text-[10px] py-1 px-2 rounded-lg shadow-lg whitespace-nowrap">
                                    {{ $m['label'] }}: <strong>{{ $m['students'] }} Siswa</strong>, {{ $m['leads'] }} Leads
                                </div>
                                <div class="w-2 h-2 bg-slate-900 rotate-45 -mt-1"></div>
                            </div>

                            <div class="w-full flex items-end justify-center gap-1 h-28">
                                <!-- Student bar -->
                                <div 
                                    style="height: {{ max(10, $stH) }}%" 
                                    class="w-3 sm:w-3.5 bg-japan-600 rounded-t-md hover:bg-japan-700 transition-all duration-300" 
                                    title="Siswa: {{ $m['students'] }}"
                                ></div>
                                <!-- Leads bar -->
                                <div 
                                    style="height: {{ max(6, $ldH) }}%" 
                                    class="w-3 sm:w-3.5 bg-blue-300 rounded-t-md hover:bg-blue-400 transition-all duration-300" 
                                    title="Leads: {{ $m['leads'] }}"
                                ></div>
                            </div>
                            <span class="text-[10px] text-slate-400 font-bold mt-1.5">{{ $m['short'] }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Chart Legend -->
                <div class="flex items-center justify-center gap-6 pt-3 text-[11px] text-slate-500 font-medium">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded bg-japan-600"></span>
                        <span>Siswa Terdaftar</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded bg-blue-300"></span>
                        <span>Leads Pendaftar</span>
                    </div>
                </div>
            </div>

            <!-- Financial Recovery Gauge -->
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="font-bold text-slate-700">Tingkat Penagihan Kas (Recovery Rate)</span>
                    <strong class="font-black text-emerald-600">{{ $counts['recovery_rate'] }}%</strong>
                </div>
                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div style="width: {{ $counts['recovery_rate'] }}%" class="h-full bg-emerald-500 rounded-full"></div>
                </div>
                <div class="flex justify-between items-center text-[10px] text-slate-500">
                    <span>Masuk: Rp {{ number_format($counts['paid_amount'], 0, ',', '.') }}</span>
                    <span>Sisa: Rp {{ number_format($counts['receivables'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- 4. Secondary Metrics (Leads & Academics) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex items-center justify-between hover:border-slate-300 transition">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase">Leads Pendaftar</p>
                <h4 data-admin-stat="leads_total" data-suffix=" Orang" class="text-xl font-black text-slate-900 mt-0.5">{{ $counts['leads_total'] }} Orang</h4>
            </div>
            <a href="{{ route('admin.consultations.index') }}" class="p-2.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition" title="Buka Leads">
                <i data-lucide="users" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex items-center justify-between hover:border-amber-300 transition">
            <div>
                <p class="text-[11px] font-bold text-amber-500 uppercase">Perlu Dihubungi</p>
                <h4 data-admin-stat="leads_pending" data-suffix=" Leads" class="text-xl font-black text-amber-600 mt-0.5">{{ $counts['leads_pending'] }} Leads</h4>
            </div>
            <span class="w-3 h-3 rounded-full bg-amber-500 animate-ping" title="Ada leads belum dihubungi"></span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex items-center justify-between hover:border-slate-300 transition">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase">Tenaga Pengajar</p>
                <h4 class="text-xl font-black text-slate-900 mt-0.5">{{ $counts['teachers'] }} Sensei</h4>
            </div>
            <a href="{{ route('admin.teachers.index') }}" class="p-2.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition" title="Kelola Pengajar">
                <i data-lucide="user-check" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex items-center justify-between hover:border-slate-300 transition">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase">Jadwal Angkatan</p>
                <h4 class="text-xl font-black text-slate-900 mt-0.5">{{ $counts['schedules'] }} Gelombang</h4>
            </div>
            <a href="{{ route('admin.schedules.index') }}" class="p-2.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition" title="Kelola Jadwal">
                <i data-lucide="calendar" class="w-4 h-4"></i>
            </a>
        </div>
    </div>

    <!-- 4b. Executive Operational Finance & Digital Archives (Reimbursement & Arsip Explorer) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        
        <!-- Saldo Kas Umum (General Ledger) -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-2xl p-4 border border-slate-200 shadow-xs flex items-center justify-between hover:border-slate-300 transition">
            <div class="min-w-0">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full {{ $counts['cash_balance'] >= 0 ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                    <p class="text-[11px] font-bold text-slate-700 uppercase tracking-wider truncate">Saldo Kas Umum</p>
                </div>
                <h4 class="text-lg font-black {{ $counts['cash_balance'] >= 0 ? 'text-slate-900' : 'text-rose-600' }} mt-1 truncate">Rp {{ number_format($counts['cash_balance'], 0, ',', '.') }}</h4>
                <a href="{{ route('admin.cash-book.index') }}" class="text-[11px] font-bold text-japan-600 hover:underline inline-block mt-0.5">Buka Buku Kas &rarr;</a>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center font-bold shrink-0">
                <i data-lucide="book-open" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Reimburse Dicairkan -->
        <div class="bg-gradient-to-br from-white to-emerald-50/40 rounded-2xl p-4 border border-emerald-200/80 shadow-xs flex items-center justify-between hover:border-emerald-300 transition">
            <div class="min-w-0">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <p class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider truncate">Reimburse Cair</p>
                </div>
                <h4 class="text-lg font-black text-slate-900 mt-1 truncate">Rp {{ number_format($counts['reimbursements_paid'], 0, ',', '.') }}</h4>
                <a href="{{ route('admin.reimbursements.index', ['type' => 'reimbursement']) }}" class="text-[11px] font-bold text-emerald-700 hover:underline inline-block mt-0.5">Kelola Reimburse &rarr;</a>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold shrink-0">
                <i data-lucide="wallet" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Uang Muka / Kasbon Berjalan -->
        <div class="bg-gradient-to-br from-white to-purple-50/40 rounded-2xl p-4 border border-purple-200/80 shadow-xs flex items-center justify-between hover:border-purple-300 transition">
            <div class="min-w-0">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                    <p class="text-[11px] font-bold text-purple-800 uppercase tracking-wider truncate">Kasbon Dinas Aktif</p>
                </div>
                <h4 class="text-lg font-black text-purple-900 mt-1 truncate">Rp {{ number_format($counts['advances_active'], 0, ',', '.') }}</h4>
                <a href="{{ route('admin.reimbursements.index', ['type' => 'cash_advance']) }}" class="text-[11px] font-bold text-purple-700 hover:underline inline-block mt-0.5">{{ $counts['unsettled_advances'] }} Belum SPJ &rarr;</a>
            </div>
            <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold shrink-0">
                <i data-lucide="plane-takeoff" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Verifikasi Menunggu -->
        <div class="bg-gradient-to-br from-white to-amber-50/40 rounded-2xl p-4 border border-amber-200/80 shadow-xs flex items-center justify-between hover:border-amber-300 transition">
            <div class="min-w-0">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <p class="text-[11px] font-bold text-amber-800 uppercase tracking-wider truncate">Klaim Menunggu</p>
                </div>
                <h4 class="text-lg font-black text-amber-900 mt-1 truncate">{{ $counts['reimbursements_pending'] }} Berkas</h4>
                <a href="{{ route('admin.reimbursements.index', ['status' => 'submitted']) }}" class="text-[11px] font-bold text-amber-700 hover:underline inline-block mt-0.5">Verifikasi Segera &rarr;</a>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold shrink-0">
                <i data-lucide="clock" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Arsip Digital Explorer -->
        <div class="bg-gradient-to-br from-white to-blue-50/40 rounded-2xl p-4 border border-blue-200/80 shadow-xs flex items-center justify-between hover:border-blue-300 transition">
            <div class="min-w-0">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <p class="text-[11px] font-bold text-blue-800 uppercase tracking-wider truncate">Arsip Explorer SPA</p>
                </div>
                <h4 class="text-lg font-black text-slate-900 mt-1 truncate">{{ $counts['archives_total'] }} Berkas</h4>
                <a href="{{ route('admin.digital-archives.index') }}" class="text-[11px] font-bold text-blue-700 hover:underline inline-block mt-0.5">{{ $counts['folders_total'] }} Folder &rarr;</a>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold shrink-0">
                <i data-lucide="folder-git-2" class="w-5 h-5"></i>
            </div>
        </div>

    </div>

    <!-- 3b. Executive PDF Export Quick Hub (Pusat Cetak Dokumen Resmi) -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-6 text-white shadow-md border border-slate-700/50 space-y-4">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-b border-slate-700/60 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-red-600/20 border border-red-500/30 text-red-400 flex items-center justify-center font-bold">
                    <i data-lucide="printer" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider flex items-center gap-2">
                        <span>Pusat Cetak & Export Dokumen PDF Resmi LPK</span>
                        <span class="px-2 py-0.5 rounded-full bg-red-500/20 text-red-400 text-[10px] font-bold border border-red-500/30">Auto Logo Sync</span>
                    </h3>
                    <p class="text-xs text-slate-400">Unduh atau cetak laporan resmi berstempel dan kop surat standar Kemnaker RI dalam format A4</p>
                </div>
            </div>
            <span class="text-[11px] text-slate-400 font-mono hidden sm:inline">7 Laporan Tersedia</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
            
            <!-- 0. PDF Buku Kas Umum -->
            <a 
                href="{{ route('admin.cash-book.export.pdf') }}" 
                target="_blank"
                class="p-3.5 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-emerald-500/50 transition flex flex-col justify-between group space-y-2"
            >
                <div class="flex items-center justify-between">
                    <span class="w-7 h-7 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold">
                        <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                    </span>
                    <span class="text-[9px] font-mono font-bold text-slate-400 bg-white/5 px-1.5 py-0.5 rounded">A4-L</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-white group-hover:text-emerald-400 transition">Buku Kas Umum</p>
                    <p class="text-[10px] text-slate-400 mt-0.5 truncate">Jurnal mutasi kas & bank</p>
                </div>
            </a>
            
            <!-- 1. PDF Buku Induk Siswa -->
            <a 
                href="{{ route('admin.students.export.pdf') }}" 
                target="_blank"
                class="p-3.5 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-red-500/50 transition flex flex-col justify-between group space-y-2"
            >
                <div class="flex items-center justify-between">
                    <span class="w-7 h-7 rounded-xl bg-red-500/20 text-red-400 flex items-center justify-center text-xs font-bold">
                        <i data-lucide="graduation-cap" class="w-3.5 h-3.5"></i>
                    </span>
                    <span class="text-[9px] font-mono font-bold text-slate-400 bg-white/5 px-1.5 py-0.5 rounded">A4-L</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-white group-hover:text-red-400 transition">Buku Induk Siswa</p>
                    <p class="text-[10px] text-slate-400 mt-0.5 truncate">Database & status Jepang</p>
                </div>
            </a>

            <!-- 2. PDF Proyeksi Keuangan -->
            <a 
                href="{{ route('admin.finance.export.pdf') }}" 
                target="_blank"
                class="p-3.5 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-emerald-500/50 transition flex flex-col justify-between group space-y-2"
            >
                <div class="flex items-center justify-between">
                    <span class="w-7 h-7 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold">
                        <i data-lucide="wallet" class="w-3.5 h-3.5"></i>
                    </span>
                    <span class="text-[9px] font-mono font-bold text-slate-400 bg-white/5 px-1.5 py-0.5 rounded">A4-P</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-white group-hover:text-emerald-400 transition">Proyeksi Keuangan</p>
                    <p class="text-[10px] text-slate-400 mt-0.5 truncate">Arus kas & piutang biaya</p>
                </div>
            </a>

            <!-- 3. PDF Rekap Leads Pendaftar -->
            <a 
                href="{{ route('admin.consultations.export.pdf') }}" 
                target="_blank"
                class="p-3.5 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-blue-500/50 transition flex flex-col justify-between group space-y-2"
            >
                <div class="flex items-center justify-between">
                    <span class="w-7 h-7 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-xs font-bold">
                        <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                    </span>
                    <span class="text-[9px] font-mono font-bold text-slate-400 bg-white/5 px-1.5 py-0.5 rounded">A4-L</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-white group-hover:text-blue-400 transition">Rekapitulasi Leads</p>
                    <p class="text-[10px] text-slate-400 mt-0.5 truncate">Pendaftar konsultasi masuk</p>
                </div>
            </a>

            <!-- 4. PDF Riwayat Wawancara Kaisha -->
            <a 
                href="{{ route('admin.interviews.export.pdf') }}" 
                target="_blank"
                class="p-3.5 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-amber-500/50 transition flex flex-col justify-between group space-y-2"
            >
                <div class="flex items-center justify-between">
                    <span class="w-7 h-7 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-xs font-bold">
                        <i data-lucide="briefcase" class="w-3.5 h-3.5"></i>
                    </span>
                    <span class="text-[9px] font-mono font-bold text-slate-400 bg-white/5 px-1.5 py-0.5 rounded">A4-P</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-white group-hover:text-amber-400 transition">Riwayat Wawancara</p>
                    <p class="text-[10px] text-slate-400 mt-0.5 truncate">Hasil seleksi user Kaisha</p>
                </div>
            </a>

            <!-- 5. PDF Dewan Pengajar & Sensei -->
            <a 
                href="{{ route('admin.teachers.export.pdf') }}" 
                target="_blank"
                class="p-3.5 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-purple-500/50 transition flex flex-col justify-between group space-y-2"
            >
                <div class="flex items-center justify-between">
                    <span class="w-7 h-7 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center text-xs font-bold">
                        <i data-lucide="user-check" class="w-3.5 h-3.5"></i>
                    </span>
                    <span class="text-[9px] font-mono font-bold text-slate-400 bg-white/5 px-1.5 py-0.5 rounded">A4-P</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-white group-hover:text-purple-400 transition">Dewan Sensei</p>
                    <p class="text-[10px] text-slate-400 mt-0.5 truncate">Instruktur JLPT N1/Native</p>
                </div>
            </a>

            <!-- 6. PDF Rekapitulasi Reimburse & Kasbon SPJ -->
            <a 
                href="{{ route('admin.reimbursements.export.pdf') }}" 
                target="_blank"
                class="p-3.5 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-sky-500/50 transition flex flex-col justify-between group space-y-2"
            >
                <div class="flex items-center justify-between">
                    <span class="w-7 h-7 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center text-xs font-bold">
                        <i data-lucide="receipt" class="w-3.5 h-3.5"></i>
                    </span>
                    <span class="text-[9px] font-mono font-bold text-slate-400 bg-white/5 px-1.5 py-0.5 rounded">A4-P</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-white group-hover:text-sky-400 transition">Klaim Reimburse</p>
                    <p class="text-[10px] text-slate-400 mt-0.5 truncate">SPJ dinas & uang muka</p>
                </div>
            </a>

        </div>
    </div>

    <!-- 4. Side-by-Side Live Data Tables (Students + Leads) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Tabel 1: Siswa Terbaru Terdaftar -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                        <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm">Siswa Terbaru Terdaftar</h3>
                        <p class="text-[11px] text-slate-400">5 siswa pendaftaran terbaru</p>
                    </div>
                </div>
                <a href="{{ route('admin.students.index') }}" class="text-xs font-bold text-japan-600 hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase font-bold border-b border-slate-100">
                            <th class="py-2">Siswa</th>
                            <th class="py-2">Program</th>
                            <th class="py-2">Status Biaya</th>
                            <th class="py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($latestStudents as $st)
                            <tr class="hover:bg-slate-50/80">
                                <td class="py-2.5">
                                    <p class="font-bold text-slate-900 leading-tight">{{ $st->name }}</p>
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $st->nis }}</span>
                                </td>
                                <td class="py-2.5">
                                    <span class="text-[11px] font-semibold text-slate-700">{{ $st->program }}</span>
                                </td>
                                <td class="py-2.5">
                                    @if($st->remaining_balance > 0)
                                        <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 font-bold text-[10px]">
                                            Sisa: {{ $st->formatted_remaining_balance }}
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-bold text-[10px]">
                                            Lunas
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2.5 text-right">
                                    <a href="{{ route('admin.students.edit', $st->id) }}" class="p-1 rounded-lg text-blue-600 hover:bg-blue-50 inline-block" title="Edit">
                                        <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-400 text-xs">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel 2: Leads Pendaftar Konsultasi Terbaru -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <i data-lucide="message-square" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm">Leads Konsultasi Masuk</h3>
                        <p class="text-[11px] text-slate-400">5 pendaftar via website terbaru</p>
                    </div>
                </div>
                <a href="{{ route('admin.consultations.index') }}" class="text-xs font-bold text-japan-600 hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase font-bold border-b border-slate-100">
                            <th class="py-2">Pendaftar</th>
                            <th class="py-2">Program Minat</th>
                            <th class="py-2">Status</th>
                            <th class="py-2 text-right">Hubungi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($latestLeads as $lead)
                            <tr class="hover:bg-slate-50/80">
                                <td class="py-2.5">
                                    <p class="font-bold text-slate-900 leading-tight">{{ $lead->name }}</p>
                                    <span class="text-[10px] text-slate-400">{{ $lead->phone }}</span>
                                </td>
                                <td class="py-2.5">
                                    <span class="text-[11px] font-semibold text-slate-700">{{ $lead->program }}</span>
                                </td>
                                <td class="py-2.5">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold
                                        {{ $lead->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                        {{ $lead->status === 'contacted' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $lead->status === 'registered' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                        {{ $lead->status === 'cancelled' ? 'bg-slate-100 text-slate-600' : '' }}
                                    ">
                                        {{ ucfirst($lead->status) }}
                                    </span>
                                </td>
                                <td class="py-2.5 text-right">
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $lead->phone);
                                        if (str_starts_with($cleanPhone, '0')) $cleanPhone = '62' . substr($cleanPhone, 1);
                                        $waMsg = urlencode("Halo Kak {$lead->name}, terima kasih telah mendaftar di LPK Sahabat Jepang Indonesia. Kami ingin mengonfirmasi konsultasi pilihan program {$lead->program}.");
                                    @endphp
                                    <a 
                                        href="https://api.whatsapp.com/send?phone={{ $cleanPhone }}&text={{ $waMsg }}" 
                                        target="_blank" 
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold text-[11px] transition"
                                    >
                                        <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                        <span>WA</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-400 text-xs">Belum ada leads masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- 5. Quick CMS Navigation Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        
        <a href="{{ route('admin.programs.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-japan-600 transition flex flex-col items-center text-center group">
            <div class="w-9 h-9 rounded-xl bg-red-50 text-japan-600 group-hover:bg-japan-600 group-hover:text-white flex items-center justify-center transition">
                <i data-lucide="briefcase" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold text-slate-900 mt-2">Program Karir</p>
            <span class="text-[10px] text-slate-400">{{ $counts['programs'] }} Program</span>
        </a>

        <a href="{{ route('admin.schedules.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-japan-600 transition flex flex-col items-center text-center group">
            <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white flex items-center justify-center transition">
                <i data-lucide="calendar" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold text-slate-900 mt-2">Jadwal Kelas</p>
            <span class="text-[10px] text-slate-400">{{ $counts['schedules'] }} Angkatan</span>
        </a>

        <a href="{{ route('admin.facilities.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-japan-600 transition flex flex-col items-center text-center group">
            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white flex items-center justify-center transition">
                <i data-lucide="building" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold text-slate-900 mt-2">Fasilitas</p>
            <span class="text-[10px] text-slate-400">{{ $counts['facilities'] }} Foto</span>
        </a>

        <a href="{{ route('admin.testimonials.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-japan-600 transition flex flex-col items-center text-center group">
            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white flex items-center justify-center transition">
                <i data-lucide="message-square" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold text-slate-900 mt-2">Testimoni</p>
            <span class="text-[10px] text-slate-400">{{ $counts['testimonials'] }} Cerita</span>
        </a>

        <a href="{{ route('admin.articles.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-japan-600 transition flex flex-col items-center text-center group">
            <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white flex items-center justify-center transition">
                <i data-lucide="newspaper" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold text-slate-900 mt-2">Artikel Blog</p>
            <span class="text-[10px] text-slate-400">{{ $counts['articles'] }} Post</span>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-japan-600 transition flex flex-col items-center text-center group">
            <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 group-hover:bg-slate-900 group-hover:text-white flex items-center justify-center transition">
                <i data-lucide="sliders" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold text-slate-900 mt-2">Logo & Hero</p>
            <span class="text-[10px] text-slate-400">Pengaturan</span>
        </a>

    </div>

</div>
@endsection
