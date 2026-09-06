@extends('admin.layouts.admin')

@section('title', 'Data Diri Siswa & Keuangan')
@section('page_title', 'Database Siswa & Manajemen Keuangan LPK')

@section('content')
<div class="space-y-6">

    <!-- 1. Top KPI Summary Cards (Real-Time Live Synced) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Siswa -->
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Siswa Terdata</p>
                <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                    <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                </div>
            </div>
            <p data-admin-stat="students_total" class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">{{ number_format($stats['total_students']) }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Keseluruhan siswa & alumni</p>
        </div>

        <!-- Siswa Aktif Belajar -->
        <div class="p-5 rounded-2xl bg-white border border-emerald-200 shadow-xs hover:border-emerald-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Aktif Belajar / Seleksi</p>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i data-lucide="book-open" class="w-4 h-4"></i>
                </div>
            </div>
            <p data-admin-stat="students_active" class="text-2xl sm:text-3xl font-black text-emerald-600 mt-2">{{ number_format($stats['active_students']) }}</p>
            <p class="text-[11px] text-emerald-700/80 mt-0.5 font-medium">Tahap pelatihan intensif</p>
        </div>

        <!-- Sudah di Jepang -->
        <div class="p-5 rounded-2xl bg-white border border-rose-200 shadow-xs hover:border-rose-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-japan-600 uppercase tracking-wider">Sudah Berada di Jepang</p>
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="plane" class="w-4 h-4"></i>
                </div>
            </div>
            <p data-admin-stat="students_departed" class="text-2xl sm:text-3xl font-black text-japan-600 mt-2">{{ number_format($stats['departed_students']) }}</p>
            <p class="text-[11px] text-rose-700/80 mt-0.5 font-medium">Bekerja resmi di kaisha</p>
        </div>

        <!-- Total Tanggungan Belum Lunas -->
        <div class="p-5 rounded-2xl bg-white border border-amber-200 shadow-xs hover:border-amber-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-amber-600 uppercase tracking-wider">Sisa Tanggungan Biaya</p>
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                </div>
            </div>
            <p data-admin-stat="receivables" class="text-xl sm:text-2xl font-black text-amber-600 mt-2">Rp {{ number_format($stats['total_receivables'], 0, ',', '.') }}</p>
            <p class="text-[11px] text-amber-700/80 mt-0.5 font-medium">Belum lunas / proses cicilan</p>
        </div>

    </div>

    <!-- 2. Action & Filter Bar (2-Tier Clean Layout) -->
    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs space-y-4">
        
        <!-- Tier 1: Search and Dropdown Filters (Structured 2-Row Form) -->
        <form action="{{ route('admin.students.index') }}" method="GET" class="space-y-3">
            
            <!-- Row 1: Search Bar (Main) + Program + Jalur Siswa -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
                
                <!-- Search Bar (Span 5 on Desktop) -->
                <div class="sm:col-span-2 lg:col-span-5 relative">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input 
                        type="text" 
                        id="studentSearchInput"
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="Cari NIS, Nama Siswa, NIK, No. HP, Kaisha, atau No. CoE..." 
                        class="w-full pl-9 pr-10 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600 bg-slate-50/70 focus:bg-white transition"
                    >
                    <span class="hidden sm:inline-flex items-center absolute right-3 top-1/2 -translate-y-1/2 px-1.5 py-0.5 rounded border border-slate-300 bg-white text-[10px] text-slate-400 font-mono shadow-2xs cursor-pointer select-none" title="Tekan tombol '/' untuk mencari">/</span>
                </div>

                <!-- Filter Program (Span 3 on Desktop) -->
                <div class="sm:col-span-1 lg:col-span-3">
                    <select name="program" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 focus:outline-none focus:border-japan-600 bg-slate-50/70 focus:bg-white transition">
                        <option value="all">Semua Program</option>
                        <option value="Tokutei Ginou (SSW)" {{ request('program') === 'Tokutei Ginou (SSW)' ? 'selected' : '' }}>Tokutei Ginou (SSW)</option>
                        <option value="Ginou Jisshusei (Magang)" {{ request('program') === 'Ginou Jisshusei (Magang)' ? 'selected' : '' }}>Ginou Jisshusei (Magang)</option>
                        <option value="Engineer & Profesional" {{ request('program') === 'Engineer & Profesional' ? 'selected' : '' }}>Engineer & Profesional</option>
                        <option value="Kursus Bahasa Jepang" {{ request('program') === 'Kursus Bahasa Jepang' ? 'selected' : '' }}>Kursus Bahasa Jepang</option>
                    </select>
                </div>

                <!-- Filter Jalur / Kategori Siswa (Span 4 on Desktop) -->
                <div class="sm:col-span-1 lg:col-span-4">
                    <select name="registration_category" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 focus:outline-none focus:border-japan-600 bg-slate-50/70 focus:bg-white transition">
                        <option value="all">Semua Jalur Pendaftaran</option>
                        <option value="smk_go_japan" {{ request('registration_category') === 'smk_go_japan' ? 'selected' : '' }}>Program Pemerintah: SMK Go Japan</option>
                        <option value="smile_project" {{ in_array(request('registration_category'), ['smile_project', 'kemenkes_kaigo']) ? 'selected' : '' }}>Program Pemerintah: SMILE Project (Khusus Poltekkes MoU)</option>
                        <option value="umum" {{ request('registration_category') === 'umum' ? 'selected' : '' }}>Jalur Reguler / Umum</option>
                        <option value="bkk_smk" {{ request('registration_category') === 'bkk_smk' ? 'selected' : '' }}>Kemitraan BKK SMK</option>
                        <option value="poltekkes_kampus" {{ request('registration_category') === 'poltekkes_kampus' ? 'selected' : '' }}>Kemitraan Poltekkes & STIKes</option>
                    </select>
                </div>

            </div>

            <!-- Row 2: Secondary Status Filters + Submit & Reset -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center pt-2 border-t border-slate-100">
                
                <!-- Status Pelatihan (Span 4 on Desktop) -->
                <div class="sm:col-span-1 lg:col-span-4">
                    <div class="flex items-center gap-2">
                        <span class="text-[11px] font-bold text-slate-400 whitespace-nowrap hidden lg:inline">Status:</span>
                        <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 focus:outline-none focus:border-japan-600 bg-slate-50/70 focus:bg-white transition">
                            <option value="all">Semua Status Pelatihan</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif Belajar</option>
                            <option value="interview" {{ request('status') === 'interview' ? 'selected' : '' }}>Wawancara User (Kaisha)</option>
                            <option value="passed_interview" {{ request('status') === 'passed_interview' ? 'selected' : '' }}>Lolos User (Tunggu CoE/Visa)</option>
                            <option value="departed" {{ request('status') === 'departed' ? 'selected' : '' }}>Sudah Terbang / Di Jepang</option>
                            <option value="graduated" {{ request('status') === 'graduated' ? 'selected' : '' }}>Alumni Selesai Kontrak</option>
                            <option value="dropout" {{ request('status') === 'dropout' ? 'selected' : '' }}>Keluar / DO</option>
                        </select>
                    </div>
                </div>

                <!-- Status Pembayaran (Span 4 on Desktop) -->
                <div class="sm:col-span-1 lg:col-span-4">
                    <div class="flex items-center gap-2">
                        <span class="text-[11px] font-bold text-slate-400 whitespace-nowrap hidden lg:inline">Biaya:</span>
                        <select name="payment_status" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 focus:outline-none focus:border-japan-600 bg-slate-50/70 focus:bg-white transition">
                            <option value="all">Semua Status Pembayaran</option>
                            <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Lunas (Rp 0 Sisa)</option>
                            <option value="partial" {{ request('payment_status') === 'partial' ? 'selected' : '' }}>Ada Tanggungan Biaya</option>
                            <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Belum Ada Pembayaran</option>
                        </select>
                    </div>
                </div>

                <!-- Tombol Aksi (Span 4 on Desktop) -->
                <div class="sm:col-span-2 lg:col-span-4 flex items-center gap-2 justify-end">
                    <button type="submit" class="flex-1 lg:flex-none px-5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-xs">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                        <span>Terapkan Filter</span>
                    </button>
                    @if(request()->anyFilled(['q', 'program', 'status', 'payment_status', 'registration_category']))
                        <a href="{{ route('admin.students.index') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition flex items-center gap-1.5" title="Reset Semua Filter">
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                            <span class="hidden sm:inline">Reset</span>
                        </a>
                    @endif
                </div>

            </div>

        </form>

        <!-- Tier 2: Quick Actions & Batch Tools Bar -->
        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
            
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-slate-100 text-slate-700 font-bold text-[11px]">
                    <i data-lucide="database" class="w-3.5 h-3.5 text-japan-600"></i>
                    <span>Total Data: <b>{{ number_format($students->total()) }}</b> Siswa</span>
                </span>
                @if(request()->anyFilled(['q', 'program', 'status', 'payment_status', 'registration_category']))
                    <span class="text-[11px] text-japan-600 font-semibold">(Filter Diterapkan)</span>
                @endif
            </div>

            <!-- Action Buttons (Import, Template, Export, Tambah) -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Import CSV Button -->
                <button 
                    type="button"
                    onclick="openModal('importCsvModal')" 
                    class="px-3.5 py-2 rounded-xl border border-blue-200 bg-blue-50/60 hover:bg-blue-100/80 text-blue-800 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs"
                    title="Import Data Siswa Massal dari file CSV / Excel"
                >
                    <i data-lucide="upload-cloud" class="w-4 h-4 text-blue-600"></i>
                    <span>Import CSV</span>
                </button>

                <!-- Download Template CSV -->
                <a 
                    href="{{ route('admin.students.template') }}" 
                    class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs"
                    title="Unduh Template Format CSV Siap Isi"
                >
                    <i data-lucide="download" class="w-4 h-4 text-slate-500"></i>
                    <span>Template</span>
                </a>

                <!-- Export Database CSV -->
                <a 
                    href="{{ route('admin.students.export') }}" 
                    class="px-3.5 py-2 rounded-xl border border-emerald-200 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs"
                    title="Export Seluruh Database Siswa ke File CSV / Excel"
                >
                    <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i>
                    <span>Export CSV</span>
                </a>

                <!-- Export Database PDF -->
                <a 
                    href="{{ route('admin.students.export.pdf', request()->all()) }}" 
                    target="_blank"
                    class="px-3.5 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-2xs"
                    title="Cetak Rekapitulasi Buku Induk Siswa ke PDF Resmi"
                >
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    <span>Export PDF</span>
                </a>

                <!-- Tambah Siswa Baru -->
                <a 
                    href="{{ route('admin.students.create') }}" 
                    class="btn-red-primary px-4 py-2 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5"
                >
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span>Tambah Siswa</span>
                </a>
            </div>

        </div>

    </div>

    <!-- 3. Students Table (Clean, Aligned & Non-wrapping) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-[10px] uppercase font-black tracking-wider">
                        <th class="py-3.5 px-4 whitespace-nowrap min-w-[190px]">Siswa & NIS</th>
                        <th class="py-3.5 px-4 min-w-[200px]">Program & Sektor</th>
                        <th class="py-3.5 px-4 min-w-[160px]">Penempatan Jepang</th>
                        <th class="py-3.5 px-4 whitespace-nowrap min-w-[120px]">Masuk / Terbang</th>
                        <th class="py-3.5 px-4 whitespace-nowrap min-w-[140px]">Bahasa & Medikal</th>
                        <th class="py-3.5 px-4 whitespace-nowrap min-w-[130px]">Keuangan</th>
                        <th class="py-3.5 px-4 text-center whitespace-nowrap min-w-[110px]">Status</th>
                        <th class="py-3.5 px-4 text-center whitespace-nowrap min-w-[190px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $st)
                        <tr class="hover:bg-slate-50/70 transition">
                            
                            <!-- Foto & Siswa Info (NIS will NEVER wrap) -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                        @if($st->photo)
                                            <img src="{{ $st->photo }}" alt="{{ $st->name }}" class="w-full h-full object-cover">
                                        @else
                                            <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <button 
                                            type="button" 
                                            onclick="openStudentDetailModal({{ $st->id }})" 
                                            class="font-black text-slate-900 hover:text-japan-600 transition text-left text-xs leading-snug block group truncate max-w-[150px]"
                                            title="Klik untuk melihat profil lengkap & berkas"
                                        >
                                            <span class="group-hover:underline">{{ $st->name }}</span>
                                        </button>
                                        <span class="inline-block text-[11px] font-mono font-bold text-slate-500 whitespace-nowrap mt-0.5">
                                            {{ $st->nis }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Program, Sektor & Jalur Pendaftaran -->
                            <td class="py-3.5 px-4 min-w-[200px]">
                                <p class="font-extrabold text-slate-900 text-xs leading-snug">{{ $st->program }}</p>
                                <p class="text-[11px] text-japan-600 font-semibold leading-tight mt-0.5">{{ $st->sector ?: 'Umum' }}</p>
                                @if($st->registration_category && $st->registration_category !== 'umum')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-black border {{ $st->registration_category_badge['bg'] }} mt-1 whitespace-nowrap shadow-2xs">
                                        ★ {{ $st->registration_category_badge['label'] }}
                                    </span>
                                @endif
                            </td>

                            <!-- Penempatan Kaisha -->
                            <td class="py-3.5 px-4 min-w-[160px]">
                                <p class="font-bold text-slate-800 text-xs leading-snug">{{ $st->destination_company ?: '-' }}</p>
                                <p class="text-[11px] text-slate-400 font-medium mt-0.5">{{ $st->destination_prefecture ?: '-' }}</p>
                            </td>

                            <!-- Tanggal Masuk / Terbang -->
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs">
                                <p class="text-slate-600 font-medium">In: <span class="font-bold text-slate-800">{{ $st->entry_date ? $st->entry_date->format('d/m/Y') : '-' }}</span></p>
                                <p class="text-[11px] text-japan-600 font-bold mt-0.5">Fly: {{ $st->departure_date ? $st->departure_date->format('d/m/Y') : '-' }}</p>
                            </td>

                            <!-- Bahasa & Medikal / CoE -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="space-y-1">
                                    <span class="px-2 py-0.5 rounded-md bg-rose-50 border border-rose-200 text-japan-700 font-bold text-[10px] inline-block whitespace-nowrap">
                                        {{ $st->japanese_level ?: '-' }}
                                    </span>
                                    @if($st->mcu_result === 'fit')
                                        <span class="px-2 py-0.5 rounded text-[9px] font-black bg-emerald-100 text-emerald-800 block w-max whitespace-nowrap">MCU: Fit</span>
                                    @elseif($st->mcu_result === 'unfit')
                                        <span class="px-2 py-0.5 rounded text-[9px] font-black bg-rose-100 text-rose-800 block w-max whitespace-nowrap">MCU: Unfit</span>
                                    @elseif($st->mcu_result === 'follow_up')
                                        <span class="px-2 py-0.5 rounded text-[9px] font-black bg-amber-100 text-amber-800 block w-max whitespace-nowrap">MCU: Follow-up</span>
                                    @elseif($st->mcu_result === 'pending')
                                        <span class="px-2 py-0.5 rounded text-[9px] font-black bg-slate-100 text-slate-600 block w-max whitespace-nowrap">MCU: Pending</span>
                                    @endif
                                    @if($st->coe_number)
                                        <span class="text-[9px] font-mono text-slate-400 block truncate max-w-[130px] whitespace-nowrap" title="CoE: {{ $st->coe_number }}">
                                            CoE: {{ $st->coe_number }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Keuangan & Tanggungan -->
                            <td class="py-3.5 px-4 whitespace-nowrap font-mono text-xs">
                                <div class="space-y-0.5">
                                    <p class="font-bold text-emerald-600">{{ $st->formatted_paid_amount }}</p>
                                    @if($st->remaining_balance > 0)
                                        <p class="text-[10px] text-rose-600 font-black mt-0.5">Sisa: {{ $st->formatted_remaining_balance }}</p>
                                    @else
                                        <span class="text-[10px] text-emerald-600 font-bold font-sans">Lunas</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Status Pelatihan (With whitespace-nowrap - NO broken lines!) -->
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                @if($st->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-blue-50 text-blue-700 border border-blue-200 whitespace-nowrap">Aktif</span>
                                @elseif($st->status === 'interview')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-purple-50 text-purple-700 border border-purple-200 whitespace-nowrap">Interview</span>
                                @elseif($st->status === 'passed_interview')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-50 text-amber-800 border border-amber-200 whitespace-nowrap">Lolos User</span>
                                @elseif($st->status === 'departed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200 whitespace-nowrap">Di Jepang</span>
                                @elseif($st->status === 'graduated')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-slate-100 text-slate-700 border border-slate-200 whitespace-nowrap">Alumni</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-50 text-rose-700 border border-rose-200 whitespace-nowrap">DO</span>
                                @endif
                            </td>

                            <!-- Aksi (Sleek Compact Toolbar) -->
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-2 justify-center">
                                    
                                    <!-- Catat Pembayaran (Primary Action) -->
                                    <button 
                                        type="button" 
                                        data-id="{{ $st->id }}"
                                        data-name="{{ $st->name }}"
                                        data-total="{{ (float)$st->total_cost }}"
                                        data-paid="{{ (float)$st->paid_amount }}"
                                        onclick="openQuickPaymentFromBtn(this)" 
                                        class="px-2.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 font-bold text-xs flex items-center gap-1.5 transition shadow-2xs whitespace-nowrap" 
                                        title="Catat Pembayaran Masuk"
                                    >
                                        <i data-lucide="wallet" class="w-3.5 h-3.5"></i>
                                        <span>Bayar</span>
                                    </button>

                                    <!-- Toolbar Icons Group -->
                                    <div class="inline-flex items-center rounded-xl bg-slate-100/90 p-1 border border-slate-200/80 gap-1 shadow-2xs">
                                        
                                        <!-- Quick Detail Modal -->
                                        <button 
                                            type="button" 
                                            onclick="openStudentDetailModal({{ $st->id }})" 
                                            class="w-7 h-7 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-white flex items-center justify-center transition" 
                                            title="Lihat Detail Profil & Berkas Siswa"
                                        >
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        </button>

                                        <!-- Cetak Lembar Profil -->
                                        <a 
                                            href="{{ route('admin.students.print', $st->id) }}" 
                                            target="_blank" 
                                            class="w-7 h-7 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-white flex items-center justify-center transition" 
                                            title="Cetak Lembar Profil (PDF)"
                                        >
                                            <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                                        </a>

                                        <!-- Cetak Kwitansi Resmi -->
                                        <a 
                                            href="{{ route('admin.students.receipt', $st->id) }}" 
                                            target="_blank" 
                                            class="w-7 h-7 rounded-lg text-slate-500 hover:text-emerald-700 hover:bg-white flex items-center justify-center transition" 
                                            title="Cetak Kwitansi Pembayaran Resmi (PDF)"
                                        >
                                            <i data-lucide="receipt" class="w-3.5 h-3.5"></i>
                                        </a>

                                        <!-- Buka Portal Mandiri Siswa -->
                                        <a 
                                            href="{{ route('student.portal', ['keyword' => $st->nis]) }}" 
                                            target="_blank" 
                                            class="w-7 h-7 rounded-lg text-slate-500 hover:text-purple-600 hover:bg-white flex items-center justify-center transition" 
                                            title="Buka Portal Cek Status Siswa (Tampilan Siswa/Wali)"
                                        >
                                            <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                        </a>

                                        <!-- Edit Data Siswa -->
                                        <a 
                                            href="{{ route('admin.students.edit', $st->id) }}" 
                                            class="w-7 h-7 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-white flex items-center justify-center transition" 
                                            title="Edit Lengkap"
                                        >
                                            <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                        </a>

                                        <!-- Hapus Siswa -->
                                        <form action="{{ route('admin.students.destroy', $st->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa {{ addslashes($st->name) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-7 h-7 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-white flex items-center justify-center transition" title="Hapus">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>

                                    </div>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400 mb-2">
                                    <i data-lucide="users" class="w-6 h-6"></i>
                                </div>
                                <p class="font-bold text-slate-700">Belum ada data siswa</p>
                                <p class="text-xs">Klik "Tambah Siswa" untuk menginput data baru</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $students->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Quick Payment Modal -->
<div id="quickPaymentModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('quickPaymentModal')"></div>
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10">
        
        <div class="bg-gradient-to-r from-emerald-800 to-emerald-700 text-white p-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-white/20 text-white flex items-center justify-center font-bold">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-white">Catat Pembayaran Siswa</h3>
                    <p id="paymentStudentName" class="text-[11px] text-emerald-200">-</p>
                </div>
            </div>
            <button onclick="closeModal('quickPaymentModal')" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm">
                &times;
            </button>
        </div>

        <form id="quickPaymentForm" method="POST" enctype="multipart/form-data" class="p-5 space-y-3.5">
            @csrf
            
            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 grid grid-cols-2 gap-2 text-xs">
                <div>
                    <span class="text-slate-400 text-[10px] uppercase font-bold">Total Biaya:</span>
                    <p id="paymentTotalCost" class="font-black text-slate-900 text-xs">Rp 0</p>
                </div>
                <div>
                    <span class="text-slate-400 text-[10px] uppercase font-bold">Sisa Tanggungan:</span>
                    <p id="paymentRemaining" class="font-black text-rose-600 text-xs">Rp 0</p>
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Akumulasi Terbayar (IDR) *</label>
                <input type="number" name="paid_amount" id="inputPaidAmount" required min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-black text-emerald-600 focus:outline-none focus:border-emerald-600 font-mono">
                <p class="text-[10px] text-slate-400">Selisih penambahan akan otomatis dicatat sebagai Kas Masuk (BKM) di Buku Kas Umum.</p>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold text-slate-700">Akun Kas / Bank *</label>
                    <select name="payment_method" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-emerald-600 font-bold">
                        @foreach($paymentMethods ?? [] as $pmKey => $pmLabel)
                            <option value="{{ $pmKey }}">{{ $pmLabel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold text-slate-700">Tanggal Transaksi *</label>
                    <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold focus:outline-none focus:border-emerald-600">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-[11px] font-bold text-slate-700">Upload Bukti Transfer (Opsional)</label>
                <input type="file" name="proof_file" accept="image/*,.pdf" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Catatan Termin / Keterangan</label>
                <textarea name="payment_notes" rows="2" placeholder="Contoh: Transfer pelunasan termin 2..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-emerald-600"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('quickPaymentModal')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Simpan & Catat Kas Masuk</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Import CSV Modal -->
<div id="importCsvModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('importCsvModal')"></div>
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10">
        
        <div class="bg-gradient-to-r from-blue-900 to-slate-900 text-white p-6 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-2xl bg-white/10 text-white flex items-center justify-center font-bold">
                    <i data-lucide="upload-cloud" class="w-5 h-5 text-blue-400"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-white">Import Database Siswa (CSV)</h3>
                    <p class="text-xs text-slate-300">Upload data massal dari file Excel/CSV</p>
                </div>
            </div>
            <button onclick="closeModal('importCsvModal')" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition">
                &times;
            </button>
        </div>

        <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            
            <!-- Step Instructions & Template Download Link -->
            <div class="p-4 rounded-2xl bg-blue-50/80 border border-blue-100 space-y-2.5">
                <div class="flex items-start gap-2.5 text-xs text-blue-900">
                    <i data-lucide="info" class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="font-bold">Panduan Import Data Siswa:</p>
                        <ol class="list-decimal list-inside space-y-1 mt-1 text-slate-600 text-[11px]">
                            <li>Gunakan format kolom template resmi LPK.</li>
                            <li>Jika kolom <strong>NIS</strong> dikosongkan, sistem otomatis membuatkan NIS unik (<code>SJI-YYYY-XXXXX</code>).</li>
                            <li>Jika NIS sudah ada, data siswa tersebut otomatis diperbarui (*update in-place*).</li>
                            <li><strong>Kategori Pendaftaran:</strong> Mendukung <code>smile_project</code> (Khusus Poltekkes MoU), <code>smk_go_japan</code>, <code>bkk_smk</code>, <code>poltekkes_kampus</code>, dan <code>umum</code>.</li>
                            <li><strong>Otomatis Tersinkron:</strong> Portal Siswa (<code>/cek-status</code>), Kwitansi Digital, Invoice Resmi, Verifikasi QR, dan Peta Sebaran Alumni langsung aktif saat itu juga!</li>
                        </ol>
                    </div>
                </div>

                <div class="pt-2 border-t border-blue-200/60 flex items-center justify-between">
                    <span class="text-[11px] font-bold text-blue-800">Belum punya template CSV?</span>
                    <a 
                        href="{{ route('admin.students.template') }}" 
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white text-blue-700 hover:text-blue-900 border border-blue-200 font-bold text-xs shadow-xs hover:bg-blue-50 transition"
                    >
                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        <span>Unduh Template CSV</span>
                    </a>
                </div>
            </div>

            <!-- File Input Drag-and-Drop styled -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Pilih File CSV (.csv) <span class="text-rose-500">*</span></label>
                <div class="p-4 border-2 border-dashed border-slate-300 hover:border-blue-500 rounded-2xl bg-slate-50 text-center transition cursor-pointer relative">
                    <input 
                        type="file" 
                        name="csv_file" 
                        accept=".csv,text/csv,text/plain" 
                        required 
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        onchange="document.getElementById('selectedFileName').textContent = this.files[0] ? this.files[0].name : 'Belum ada file dipilih'"
                    >
                    <i data-lucide="file-spreadsheet" class="w-8 h-8 mx-auto text-blue-600 mb-1.5"></i>
                    <p class="text-xs font-bold text-slate-800">Klik untuk memilih file CSV atau drag & drop ke sini</p>
                    <p id="selectedFileName" class="text-[11px] text-slate-500 mt-1 font-mono font-semibold">Format: .csv (Maksimal 10MB)</p>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('importCsvModal')" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="btn-red-primary px-5 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i data-lucide="upload" class="w-4 h-4"></i>
                    <span>Mulai Proses Import</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Quick Detail Siswa & Berkas Modal -->
<div id="studentDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('studentDetailModal')"></div>
    <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10 flex flex-col max-h-[90vh]">
        
        <!-- Header Siswa -->
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-6 flex-shrink-0 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/10 border-2 border-white/20 overflow-hidden flex-shrink-0 flex items-center justify-center">
                    <img id="detailPhoto" src="" alt="Foto Siswa" class="w-full h-full object-cover hidden">
                    <div id="detailNoPhoto" class="text-white/60 flex items-center justify-center">
                        <i data-lucide="user" class="w-8 h-8"></i>
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-2.5">
                        <h2 id="detailName" class="text-base sm:text-lg font-black text-white leading-tight">Nama Siswa</h2>
                        <span id="detailStatusBadge" class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-japan-600 text-white">Status</span>
                    </div>
                    <p id="detailJapaneseName" class="text-xs text-japan-300 font-japanese mt-0.5">-</p>
                    <p class="text-[11px] text-slate-300 font-mono mt-1">
                        NIS: <span id="detailNis" class="font-bold text-white">-</span> • 
                        Program: <span id="detailProgram" class="font-bold text-white">-</span> • 
                        Jalur: <span id="detailRegistrationCategory" class="font-bold text-amber-300">-</span>
                    </p>
                </div>
            </div>
            <button onclick="closeModal('studentDetailModal')" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition">
                &times;
            </button>
        </div>

        <!-- Scrollable Detail Body -->
        <div class="p-6 overflow-y-auto space-y-6 flex-1 bg-slate-50/50">
            
            <!-- Grid 1: Identitas & Kontak -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i data-lucide="user" class="w-4 h-4 text-japan-600"></i>
                    <span>Identitas Pribadi & Kontak</span>
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Nomor NIK KTP:</span>
                        <p id="detailNik" class="font-mono font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Jenis Kelamin:</span>
                        <p id="detailGender" class="font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Tempat & Tanggal Lahir:</span>
                        <p id="detailBirth" class="font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Pendidikan Terakhir:</span>
                        <p id="detailEducation" class="font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">No. WhatsApp / HP:</span>
                        <div class="flex items-center gap-2">
                            <a id="detailPhoneLink" href="#" target="_blank" class="font-bold text-emerald-600 hover:underline flex items-center gap-1">
                                <span id="detailPhone">-</span>
                                <i data-lucide="external-link" class="w-3 h-3"></i>
                            </a>
                            <button 
                                type="button" 
                                onclick="toggleStudentWaBox()" 
                                class="px-2 py-0.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-extrabold text-[10px] flex items-center gap-1 transition"
                                title="Buka Template Pesan WhatsApp Cepat"
                            >
                                <i data-lucide="message-circle" class="w-3 h-3"></i>
                                <span>Template WA</span>
                            </button>
                        </div>
                    </div>

                    <!-- WhatsApp Templates Accordion Box -->
                    <div id="studentWaBox" class="col-span-2 sm:col-span-3 bg-emerald-50/70 border border-emerald-200/80 p-3 rounded-2xl hidden space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-black text-emerald-800 flex items-center gap-1.5">
                                <i data-lucide="send" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Pilih Template Pesan WhatsApp Cepat:</span>
                            </span>
                            <button type="button" onclick="toggleStudentWaBox()" class="text-slate-400 hover:text-slate-700 text-xs">&times;</button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                            <button 
                                type="button" 
                                onclick="sendStudentQuickWa('billing')" 
                                class="p-2.5 rounded-xl bg-white hover:bg-emerald-600 hover:text-white border border-emerald-200 text-left transition font-semibold flex items-center gap-2 shadow-xs group"
                            >
                                <span class="p-1.5 rounded-lg bg-emerald-100 text-emerald-700 group-hover:bg-white group-hover:text-emerald-700">💸</span>
                                <div>
                                    <p class="font-bold text-[11px]">Pengingat Tagihan Sisa Biaya</p>
                                    <p class="text-[10px] text-slate-500 group-hover:text-emerald-100 truncate">Rincian sisa biaya & rekening resmi LPK</p>
                                </div>
                            </button>
                            <button 
                                type="button" 
                                onclick="sendStudentQuickWa('mcu')" 
                                class="p-2.5 rounded-xl bg-white hover:bg-blue-600 hover:text-white border border-blue-200 text-left transition font-semibold flex items-center gap-2 shadow-xs group"
                            >
                                <span class="p-1.5 rounded-lg bg-blue-100 text-blue-700 group-hover:bg-white group-hover:text-blue-700">🏥</span>
                                <div>
                                    <p class="font-bold text-[11px]">Panggilan Medical Check-Up (MCU)</p>
                                    <p class="text-[10px] text-slate-500 group-hover:text-blue-100 truncate">Jadwal & panduan puasa sebelum MCU</p>
                                </div>
                            </button>
                            <button 
                                type="button" 
                                onclick="sendStudentQuickWa('interview')" 
                                class="p-2.5 rounded-xl bg-white hover:bg-amber-600 hover:text-white border border-amber-200 text-left transition font-semibold flex items-center gap-2 shadow-xs group"
                            >
                                <span class="p-1.5 rounded-lg bg-amber-100 text-amber-700 group-hover:bg-white group-hover:text-amber-700">🏢</span>
                                <div>
                                    <p class="font-bold text-[11px]">Jadwal Wawancara Kaisha</p>
                                    <p class="text-[10px] text-slate-500 group-hover:text-amber-100 truncate">Panggilan wawancara user di Jepang</p>
                                </div>
                            </button>
                            <button 
                                type="button" 
                                onclick="sendStudentQuickWa('coe')" 
                                class="p-2.5 rounded-xl bg-white hover:bg-purple-600 hover:text-white border border-purple-200 text-left transition font-semibold flex items-center gap-2 shadow-xs group"
                            >
                                <span class="p-1.5 rounded-lg bg-purple-100 text-purple-700 group-hover:bg-white group-hover:text-purple-700">✈️</span>
                                <div>
                                    <p class="font-bold text-[11px]">Kabar Baik CoE & Visa Terbit</p>
                                    <p class="text-[10px] text-slate-500 group-hover:text-purple-100 truncate">Pemberitahuan kelulusan izin tinggal Jepang</p>
                                </div>
                            </button>
                            <button 
                                type="button" 
                                onclick="sendStudentQuickWa('portal')" 
                                class="p-2.5 rounded-xl bg-white hover:bg-emerald-600 hover:text-white border border-emerald-200 text-left transition font-semibold flex items-center gap-2 shadow-xs group col-span-1 sm:col-span-2"
                            >
                                <span class="p-1.5 rounded-lg bg-emerald-100 text-emerald-700 group-hover:bg-white group-hover:text-emerald-700">📱</span>
                                <div>
                                    <p class="font-bold text-[11px]">Kirim Link Portal Tracking & Kwitansi Siswa</p>
                                    <p class="text-[10px] text-slate-500 group-hover:text-emerald-100 truncate">Kirim tautan portal mandiri agar siswa & orang tua bisa cek status dan cetak kwitansi</p>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Email:</span>
                        <p id="detailEmail" class="font-bold text-slate-800">-</p>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Alamat Domisili:</span>
                        <p id="detailAddress" class="font-medium text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Kontak Darurat (Wali):</span>
                        <p id="detailEmergency" class="font-bold text-slate-800">-</p>
                    </div>
                </div>
            </div>

            <!-- Grid 2: Penempatan Kerja & Pelatihan -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i data-lucide="briefcase" class="w-4 h-4 text-japan-600"></i>
                    <span>Pelatihan & Penempatan Kerja di Jepang</span>
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Angkatan (Batch):</span>
                        <p id="detailBatch" class="font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Sektor / Bidang:</span>
                        <p id="detailSector" class="font-bold text-japan-700">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Level Bahasa Jepang:</span>
                        <p id="detailJapaneseLevel" class="font-bold text-emerald-700">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Perusahaan Kaisha:</span>
                        <p id="detailCompany" class="font-black text-slate-900">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Prefektur Penempatan:</span>
                        <p id="detailPrefecture" class="font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Nomor Paspor:</span>
                        <p id="detailPassport" class="font-mono font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Tgl Masuk Belajar:</span>
                        <p id="detailEntryDate" class="font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Tgl / Target Terbang:</span>
                        <p id="detailDepartureDate" class="font-bold text-japan-600">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Sertifikat SSW Skill:</span>
                        <p id="detailSsw" class="font-bold text-slate-800">-</p>
                    </div>
                </div>
            </div>

            <!-- Grid 3: Medikal (MCU) & Legalitas CoE/Visa & Akademik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <!-- Medikal & Visa -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                        <i data-lucide="stethoscope" class="w-4 h-4 text-blue-600"></i>
                        <span>Medikal (MCU) & Dokumen Visa</span>
                    </h3>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Status Kelayakan MCU:</span>
                            <span id="detailMcuResult" class="font-black text-slate-900">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Klinik MCU:</span>
                            <span id="detailMcuClinic" class="font-bold text-slate-800">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Tanggal MCU:</span>
                            <span id="detailMcuDate" class="text-slate-800">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nomor CoE:</span>
                            <span id="detailCoeNumber" class="font-mono font-bold text-slate-800">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nomor Visa:</span>
                            <span id="detailVisaNumber" class="font-mono font-bold text-slate-800">-</span>
                        </div>
                    </div>
                </div>

                <!-- Akademik & Disiplin -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                        <i data-lucide="award" class="w-4 h-4 text-amber-600"></i>
                        <span>Evaluasi Akademik & Kehadiran</span>
                    </h3>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Rata-rata Nilai Ujian:</span>
                            <span id="detailExamScore" class="font-black text-slate-900">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Tingkat Kehadiran:</span>
                            <span id="detailAttendance" class="font-black text-emerald-600">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Grade Kedisiplinan:</span>
                            <span id="detailDiscipline" class="font-black text-japan-600">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Kelengkapan Berkas:</span>
                            <span id="detailDocsCount" class="font-bold text-slate-800">-</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Grid 4: Berkas & Dokumen Digital Siswa (8 Dokumen) -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="folder-check" class="w-4 h-4 text-japan-600"></i>
                        <span>Berkas Dokumen Pribadi (Digital Scan)</span>
                    </h3>
                    <span id="detailUploadedCountBadge" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">0 / 8 Berkas</span>
                </div>

                <div id="detailDocsGrid" class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-1">
                    <!-- Dynamic Document Items populated by JS -->
                </div>
            </div>

            <!-- Grid 5: Keuangan & Catatan Admin -->
            <div class="p-4 rounded-2xl bg-slate-900 text-white space-y-2 text-xs">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Total Biaya:</span>
                        <p id="detailTotalCost" class="font-black text-white text-sm">Rp 0</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Terbayar:</span>
                        <p id="detailPaidAmount" class="font-black text-emerald-400 text-sm">Rp 0</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Sisa Tanggungan:</span>
                        <p id="detailRemaining" class="font-black text-rose-400 text-sm">Rp 0</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Status & Skema:</span>
                        <p id="detailPaymentStatus" class="font-bold text-amber-300 uppercase text-xs">-</p>
                    </div>
                </div>
                <div id="detailAdminNotesBox" class="pt-2 border-t border-slate-800 text-[11px] text-slate-300 italic hidden">
                    Catatan: <span id="detailAdminNotes">-</span>
                </div>
            </div>

        </div>

        <!-- Footer Actions -->
        <div class="p-4 px-6 bg-white border-t border-slate-200 flex-shrink-0 flex items-center justify-between">
            <button type="button" onclick="closeModal('studentDetailModal')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 transition">
                Tutup
            </button>
            <div class="flex items-center gap-2">
                <button 
                    id="detailPaymentBtn" 
                    type="button" 
                    class="px-3.5 py-2 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-bold transition flex items-center gap-1.5"
                >
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                    <span>Catat Bayar</span>
                </button>
                <a 
                    id="detailPrintBtn" 
                    href="#" 
                    target="_blank" 
                    class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                    title="Cetak Lembar Profil Siswa (PDF)"
                >
                    <i data-lucide="printer" class="w-4 h-4 text-slate-600"></i>
                    <span>Lembar Profil</span>
                </a>
                <a 
                    id="detailReceiptBtn" 
                    href="#" 
                    target="_blank" 
                    class="px-3 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold transition flex items-center gap-1.5"
                    title="Cetak Kwitansi Pembayaran Resmi"
                >
                    <i data-lucide="receipt" class="w-4 h-4 text-emerald-600"></i>
                    <span>Kwitansi</span>
                </a>
                <a 
                    id="detailInvoiceBtn" 
                    href="#" 
                    target="_blank" 
                    class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                    title="Cetak Invoice Tagihan Biaya"
                >
                    <i data-lucide="file-text" class="w-4 h-4 text-slate-500"></i>
                    <span>Invoice</span>
                </a>
                <a 
                    id="detailPortalBtn" 
                    href="#" 
                    target="_blank" 
                    class="px-3 py-2 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 text-xs font-bold transition flex items-center gap-1.5"
                    title="Buka Halaman Cek Status Siswa (Tampilan Siswa/Wali)"
                >
                    <i data-lucide="external-link" class="w-4 h-4 text-purple-600"></i>
                    <span>Portal Siswa</span>
                </a>
                <a 
                    id="detailEditBtn" 
                    href="#" 
                    class="btn-red-primary px-4 py-2 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5"
                >
                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                    <span>Edit Lengkap</span>
                </a>
            </div>
        </div>

    </div>
</div>

<!-- Document Viewer Modal in Index -->
<div id="indexDocPreviewModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('indexDocPreviewModal')"></div>
    <div class="relative w-full max-w-3xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10 flex flex-col max-h-[90vh]">
        <div class="bg-slate-900 text-white p-4 px-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-japan-600/20 text-japan-400 flex items-center justify-center font-bold">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 id="indexDocPreviewTitle" class="text-sm font-bold text-white">Preview Dokumen</h3>
                    <p id="indexDocStudentSub" class="text-[11px] text-slate-400">Berkas pendaftaran resmi siswa</p>
                </div>
            </div>
            <div class="flex items-center flex-wrap gap-2">
                <!-- Unduh Berkas -->
                <button 
                    id="indexDocDownloadBtn" 
                    type="button" 
                    onclick="downloadCurrentStudentDoc()" 
                    class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold transition flex items-center gap-1.5 border border-slate-700 active:scale-95"
                    title="Unduh berkas ke perangkat"
                >
                    <i data-lucide="download" class="w-3.5 h-3.5 text-blue-400"></i>
                    <span>Unduh Berkas</span>
                </button>

                <!-- Taruh di Arsip Digital -->
                <button 
                    id="indexDocArchiveBtn" 
                    type="button" 
                    onclick="archiveCurrentStudentDocToDigital()" 
                    class="px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95"
                    title="Simpan berkas ini ke sistem Arsip Digital LPK"
                >
                    <i id="indexDocArchiveIcon" data-lucide="archive" class="w-3.5 h-3.5"></i>
                    <span id="indexDocArchiveText">Taruh di Arsip Digital</span>
                </button>

                <!-- Buka di Tab Baru -->
                <button 
                    id="indexDocNewTabBtn" 
                    type="button" 
                    onclick="openCurrentStudentDocInNewTab()" 
                    class="px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition flex items-center gap-1.5"
                    title="Buka pratinjau di tab browser baru"
                >
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">Tab Baru</span>
                </button>

                <button onclick="closeModal('indexDocPreviewModal')" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition">
                    &times;
                </button>
            </div>
        </div>
        <div id="indexDocContainer" class="p-4 overflow-y-auto flex items-center justify-center min-h-[350px] bg-slate-100 flex-1">
            <!-- Dynamic Content -->
        </div>
    </div>
</div>

<script>
    function openQuickPaymentFromBtn(btn) {
        const studentId = btn.getAttribute('data-id');
        const name = btn.getAttribute('data-name');
        const totalCost = parseFloat(btn.getAttribute('data-total')) || 0;
        const paidAmount = parseFloat(btn.getAttribute('data-paid')) || 0;

        document.getElementById('paymentStudentName').textContent = name;
        document.getElementById('paymentTotalCost').textContent = 'Rp ' + totalCost.toLocaleString('id-ID');
        
        const remaining = Math.max(0, totalCost - paidAmount);
        document.getElementById('paymentRemaining').textContent = 'Rp ' + remaining.toLocaleString('id-ID');
        document.getElementById('inputPaidAmount').value = paidAmount;

        const form = document.getElementById('quickPaymentForm');
        form.action = `/admin/students/${studentId}/payment`;

        openModal('quickPaymentModal');
    }

    let currentStudentObj = null;
    let currentStudentFinancialObj = null;

    // Open Student Quick Detail Modal
    function openStudentDetailModal(studentId) {
        fetch(`/admin/students/${studentId}?format=json`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const s = data.student;
            currentStudentObj = s;
            currentStudentFinancialObj = data;

            // Reset WhatsApp template accordion
            const waBox = document.getElementById('studentWaBox');
            if (waBox) waBox.classList.add('hidden');

            // Foto
            const photoImg = document.getElementById('detailPhoto');
            const noPhoto = document.getElementById('detailNoPhoto');
            if (s.photo) {
                photoImg.src = s.photo;
                photoImg.classList.remove('hidden');
                noPhoto.classList.add('hidden');
            } else {
                photoImg.classList.add('hidden');
                noPhoto.classList.remove('hidden');
            }

            // Identitas
            document.getElementById('detailName').textContent = s.name;
            document.getElementById('detailJapaneseName').textContent = s.japanese_name || '-';
            document.getElementById('detailNis').textContent = s.nis;
            document.getElementById('detailProgram').textContent = s.program;
            document.getElementById('detailRegistrationCategory').textContent = data.registration_category_label || 'Jalur Reguler';
            document.getElementById('detailStatusBadge').textContent = s.status.toUpperCase();
            document.getElementById('detailNik').textContent = s.nik || '-';
            document.getElementById('detailGender').textContent = s.gender;
            document.getElementById('detailBirth').textContent = (s.birth_place || '-') + ', ' + (s.birth_date ? s.birth_date.split('T')[0] : '-');
            document.getElementById('detailEducation').textContent = s.education || '-';
            document.getElementById('detailPhone').textContent = s.phone || '-';
            document.getElementById('detailPhoneLink').href = s.phone ? `https://wa.me/${s.phone.replace(/^0/, '62').replace(/[^0-9]/g, '')}` : '#';
            document.getElementById('detailEmail').textContent = s.email || '-';
            document.getElementById('detailAddress').textContent = (s.address || '-') + ' (' + (s.city || '-') + ')';
            document.getElementById('detailEmergency').textContent = (s.emergency_contact_name || '-') + ' (' + (s.emergency_contact_phone || '-') + ')';

            // Pelatihan
            document.getElementById('detailBatch').textContent = s.batch || '-';
            document.getElementById('detailSector').textContent = s.sector || '-';
            document.getElementById('detailJapaneseLevel').textContent = s.japanese_level || '-';
            document.getElementById('detailCompany').textContent = s.destination_company || 'Proses Penempatan';
            document.getElementById('detailPrefecture').textContent = s.destination_prefecture || '-';
            document.getElementById('detailPassport').textContent = s.passport_number || '-';
            document.getElementById('detailEntryDate').textContent = s.entry_date ? s.entry_date.split('T')[0] : '-';
            document.getElementById('detailDepartureDate').textContent = s.departure_date ? s.departure_date.split('T')[0] : '-';
            document.getElementById('detailSsw').textContent = s.ssw_certificate || '-';

            // Medikal & Visa
            document.getElementById('detailMcuResult').textContent = data.mcu_label;
            document.getElementById('detailMcuClinic').textContent = s.mcu_clinic || '-';
            document.getElementById('detailMcuDate').textContent = s.mcu_date ? s.mcu_date.split('T')[0] : '-';
            document.getElementById('detailCoeNumber').textContent = s.coe_number || '-';
            document.getElementById('detailVisaNumber').textContent = s.visa_number || '-';

            // Akademik
            document.getElementById('detailExamScore').textContent = s.exam_score ? s.exam_score + ' / 100' : '-';
            document.getElementById('detailAttendance').textContent = (s.attendance_percentage ?? 100) + '%';
            document.getElementById('detailDiscipline').textContent = 'Grade ' + (s.discipline_grade || 'A');
            document.getElementById('detailDocsCount').textContent = data.uploaded_docs_count + ' / 8 Dokumen';
            document.getElementById('detailUploadedCountBadge').textContent = data.uploaded_docs_count + ' / 8 Dokumen';

            // 8 Dokumen Digital Grid
            const docsList = [
                { key: 'document_ktp', label: 'e-KTP', val: s.document_ktp },
                { key: 'document_kk', label: 'Kartu Keluarga', val: s.document_kk },
                { key: 'document_ijazah', label: 'Ijazah Asli', val: s.document_ijazah },
                { key: 'document_passport', label: 'Paspor RI', val: s.document_passport },
                { key: 'document_certificate', label: 'JLPT / JFT', val: s.document_certificate },
                { key: 'document_ssw', label: 'Skill SSW', val: s.document_ssw },
                { key: 'document_mcu', label: 'Hasil MCU', val: s.document_mcu },
                { key: 'document_coe_visa', label: 'CoE & Visa', val: s.document_coe_visa },
            ];

            const docsGrid = document.getElementById('detailDocsGrid');
            docsGrid.innerHTML = '';
            docsList.forEach(d => {
                const hasDoc = !!d.val;
                const div = document.createElement('div');
                div.className = `p-2.5 rounded-xl border ${hasDoc ? 'border-emerald-200 bg-emerald-50/40' : 'border-slate-200 bg-slate-100/50'} text-xs space-y-1`;
                div.innerHTML = `
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-slate-800 text-[11px] truncate">${d.label}</span>
                        <span class="w-2 h-2 rounded-full ${hasDoc ? 'bg-emerald-500' : 'bg-slate-300'}"></span>
                    </div>
                    ${hasDoc ? `
                        <button type="button" onclick="viewDocFromDetailModal('${d.label}', '${d.val}')" class="w-full mt-1 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] flex items-center justify-center gap-1 transition">
                            <i data-lucide="eye" class="w-3 h-3"></i>
                            <span>Buka</span>
                        </button>
                    ` : `
                        <span class="block text-[10px] text-slate-400 italic">Belum ada</span>
                    `}
                `;
                docsGrid.appendChild(div);
            });

            // Keuangan
            document.getElementById('detailTotalCost').textContent = data.formatted_total_cost;
            document.getElementById('detailPaidAmount').textContent = data.formatted_paid_amount;
            document.getElementById('detailRemaining').textContent = data.formatted_remaining_balance;
            document.getElementById('detailPaymentStatus').textContent = `${s.payment_status} (${s.payment_scheme})`;

            // Catatan Admin
            const adminNotesBox = document.getElementById('detailAdminNotesBox');
            if (s.admin_notes) {
                document.getElementById('detailAdminNotes').textContent = s.admin_notes;
                adminNotesBox.classList.remove('hidden');
            } else {
                adminNotesBox.classList.add('hidden');
            }

            // Buttons
            document.getElementById('detailPrintBtn').href = `/admin/students/${s.id}/print`;
            document.getElementById('detailReceiptBtn').href = `/admin/students/${s.id}/receipt`;
            document.getElementById('detailInvoiceBtn').href = `/admin/students/${s.id}/invoice`;
            document.getElementById('detailPortalBtn').href = `/cek-status?keyword=${encodeURIComponent(s.nis)}`;
            document.getElementById('detailEditBtn').href = `/admin/students/${s.id}/edit`;
            
            const payBtn = document.getElementById('detailPaymentBtn');
            payBtn.onclick = function() {
                closeModal('studentDetailModal');
                document.getElementById('paymentStudentName').textContent = s.name;
                document.getElementById('paymentTotalCost').textContent = data.formatted_total_cost;
                document.getElementById('paymentRemaining').textContent = data.formatted_remaining_balance;
                document.getElementById('inputPaidAmount').value = s.paid_amount;
                document.getElementById('quickPaymentForm').action = `/admin/students/${s.id}/payment`;
                openModal('quickPaymentModal');
            };

            openModal('studentDetailModal');
            if (window.lucide) {
                lucide.createIcons();
            }
        })
        .catch(err => {
            console.error(err);
            if (window.Swal) {
                Swal.fire({ icon: 'error', title: 'Kesalahan', text: 'Gagal memuat detail data siswa.', confirmButtonColor: '#DC2626' });
            } else {
                alert('Gagal memuat detail data siswa.');
            }
        });
    }

    // Toggle Student WhatsApp Template Accordion
    function toggleStudentWaBox() {
        const box = document.getElementById('studentWaBox');
        if (box) {
            box.classList.toggle('hidden');
        }
    }

    // Send Quick WhatsApp to Student using Pre-Formatted Templates
    function sendStudentQuickWa(type) {
        if (!currentStudentObj) return;
        const s = currentStudentObj;
        const fin = currentStudentFinancialObj;

        let cleanPhone = (s.phone || '').replace(/[^0-9]/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '62' + cleanPhone.substring(1);
        }

        if (!cleanPhone) {
            if (window.Swal) {
                Swal.fire({ icon: 'warning', title: 'Nomor WhatsApp Kosong', text: 'Nomor WhatsApp siswa belum terdaftar di database.', confirmButtonColor: '#DC2626' });
            } else {
                alert('Nomor WhatsApp siswa belum terdaftar.');
            }
            return;
        }

        let msg = '';
        if (type === 'billing') {
            msg = `Halo Sdr/i *${s.name}* (NIS: ${s.nis}),\n\nSalam hangat dari Bagian Keuangan LPK Sahabat Jepang Indonesia 🌸\n\nKami menginformasikan status rincian biaya program *${s.program}* Anda saat ini:\n• Total Biaya: ${fin ? fin.formatted_total_cost : 'Rp -'}\n• Sudah Terbayar: ${fin ? fin.formatted_paid_amount : 'Rp -'}\n• Sisa Tanggungan: *${fin ? fin.formatted_remaining_balance : 'Rp -'}*\n\nMohon untuk menyelesaikan sisa pembayaran sebelum jadwal keberangkatan ke Jepang. Pembayaran dapat ditransfer ke rekening resmi LPK SJI. Terima kasih atas kerjasamanya.`;
        } else if (type === 'mcu') {
            msg = `Halo Sdr/i *${s.name}* (NIS: ${s.nis}),\n\nSalam dari Tim Keberangkatan LPK Sahabat Jepang Indonesia 🌸\n\nTahap persiapan kerja Anda ke Jepang telah memasuki jadwal *Medical Check-Up (MCU)*.\n• Klinik/RS Rekanan: *${s.mcu_clinic || 'RS / Klinik Rekanan LPK'}*\n• Tanggal Pelaksanaan: *${s.mcu_date ? s.mcu_date.split('T')[0] : 'Sesuai Jadwal'}*\n\n*Panduan Sebelum MCU:*\n1. Berpuasa 10-12 jam sebelum pemeriksaan darah (hanya boleh minum air putih).\n2. Istirahat cukup dan hindari begadang.\n3. Membawa e-KTP asli dan pasfoto 3x4.\n\nSemoga hasil MCU Fit dan lancar ya!`;
        } else if (type === 'interview') {
            msg = `Halo Sdr/i *${s.name}*,\n\nPemberitahuan dari Divisi Penempatan LPK Sahabat Jepang Indonesia 🌸\n\nJadwal wawancara kerja Anda dengan pihak user di Jepang telah ditetapkan:\n• Perusahaan (Kaisha): *${s.destination_company || 'Perusahaan Mitra Jepang'}*\n• Prefektur: *${s.destination_prefecture || 'Jepang'}*\n• Bidang Pekerjaan: *${s.sector || s.program}*\n\nHarap mempersiapkan *Jikoshoukai* (perkenalan diri dalam bahasa Jepang), mengenakan seragam kemeja putih rapi berkerah, dan hadir 30 menit sebelum sesi dimulai. Ganbatte kudasai!`;
        } else if (type === 'coe') {
            msg = `Omedetou gozaimasu Sdr/i *${s.name}*! 🎉🇯🇵\n\nKabar gembira dari LPK Sahabat Jepang Indonesia!\nDokumen *Certificate of Eligibility (CoE)* Anda dari Imigrasi Jepang telah terbit resmi${s.coe_number ? ' dengan nomor: *' + s.coe_number + '*' : ''}.\n\nTim kami saat ini sedang mempersiapkan pengajuan Visa Kerja ke Kedutaan Besar Jepang. Harap pastikan paspor asli Anda masih aktif. Selamat melangkah menuju karir di Jepang!`;
        } else if (type === 'portal') {
            const portalUrl = `${window.location.origin}/cek-status?keyword=${encodeURIComponent(s.nis)}`;
            msg = `Halo Sdr/i *${s.name}* (NIS: ${s.nis}) & Keluarga,\n\nSalam hangat dari LPK Sahabat Jepang Indonesia 🌸\n\nUntuk memudahkan Anda dan keluarga memantau progres berkas, hasil MCU, jadwal wawancara Kaisha, penerbitan CoE/Visa, serta mengunduh kwitansi pembayaran resmi secara mandiri, silakan akses portal tracking resmi berikut:\n\n👉 *${portalUrl}*\n\nData pada tautan ini tersinkronisasi langsung dengan sistem administrasi LPK. Terima kasih!`;
        }

        const waUrl = `https://api.whatsapp.com/send?phone=${cleanPhone}&text=${encodeURIComponent(msg)}`;
        window.open(waUrl, '_blank');
    }

    let currentActiveDoc = {
        title: '',
        url: '',
        student: null
    };

    // Helper: Unduh file Base64 dengan aman via Blob
    function downloadBase64File(dataUrl, filename) {
        if (!dataUrl) return;
        if (!dataUrl.startsWith('data:')) {
            const a = document.createElement('a');
            a.href = dataUrl;
            a.download = filename;
            a.target = '_blank';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            return;
        }

        try {
            const arr = dataUrl.split(',');
            const mime = arr[0].match(/:(.*?);/)[1];
            const bstr = atob(arr[1]);
            let n = bstr.length;
            const u8arr = new Uint8Array(n);
            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }
            const blob = new Blob([u8arr], { type: mime });
            const blobUrl = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = blobUrl;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            setTimeout(() => URL.revokeObjectURL(blobUrl), 1000);
        } catch (e) {
            console.error('Blob download fallback triggered', e);
            const a = document.createElement('a');
            a.href = dataUrl;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    }

    // View Doc from Detail Modal
    function viewDocFromDetailModal(title, docUrl) {
        currentActiveDoc.title = title;
        currentActiveDoc.url = docUrl;
        currentActiveDoc.student = currentStudentObj;

        document.getElementById('indexDocPreviewTitle').textContent = title;
        const sub = document.getElementById('indexDocStudentSub');
        if (sub && currentStudentObj) {
            sub.textContent = `${currentStudentObj.name} (NIS: ${currentStudentObj.nis || '-'})`;
        }

        // Reset archive button
        const archiveBtn = document.getElementById('indexDocArchiveBtn');
        const archiveText = document.getElementById('indexDocArchiveText');
        const archiveIcon = document.getElementById('indexDocArchiveIcon');
        if (archiveBtn && archiveText) {
            archiveBtn.className = "px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95";
            archiveBtn.disabled = false;
            archiveText.textContent = "Taruh di Arsip Digital";
            if (archiveIcon) archiveIcon.setAttribute('data-lucide', 'archive');
        }

        const container = document.getElementById('indexDocContainer');
        container.innerHTML = '';

        if (!docUrl) {
            container.innerHTML = '<p class="text-slate-400 text-sm">Tidak ada berkas yang dapat ditampilkan.</p>';
        } else if (docUrl.includes('data:application/pdf') || docUrl.endsWith('.pdf')) {
            container.innerHTML = `<iframe src="${docUrl}" class="w-full h-[65vh] rounded-xl border border-slate-300 shadow-sm" frameborder="0"></iframe>`;
        } else {
            container.innerHTML = `<img src="${docUrl}" alt="${title}" class="max-w-full max-h-[70vh] rounded-xl shadow-md object-contain border border-slate-200">`;
        }

        openModal('indexDocPreviewModal');
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    function downloadCurrentStudentDoc() {
        if (!currentActiveDoc.url) {
            alert('Berkas belum tersedia untuk diunduh.');
            return;
        }
        const s = currentActiveDoc.student || {};
        const safeNis = (s.nis || 'SISWA').replace(/[^a-zA-Z0-9_-]/g, '_');
        const safeName = (s.name || 'Dokumen').replace(/[^a-zA-Z0-9_-]/g, '_');
        const safeTitle = (currentActiveDoc.title || 'Berkas').replace(/[^a-zA-Z0-9_-]/g, '_');
        const ext = currentActiveDoc.url.includes('pdf') ? 'pdf' : (currentActiveDoc.url.includes('png') ? 'png' : 'jpg');
        const filename = `${safeNis}_${safeName}_${safeTitle}.${ext}`;

        downloadBase64File(currentActiveDoc.url, filename);
    }

    function openCurrentStudentDocInNewTab() {
        if (!currentActiveDoc.url) return;
        if (currentActiveDoc.url.startsWith('data:')) {
            try {
                const arr = currentActiveDoc.url.split(',');
                const mime = arr[0].match(/:(.*?);/)[1];
                const bstr = atob(arr[1]);
                let n = bstr.length;
                const u8arr = new Uint8Array(n);
                while (n--) {
                    u8arr[n] = bstr.charCodeAt(n);
                }
                const blob = new Blob([u8arr], { type: mime });
                const blobUrl = URL.createObjectURL(blob);
                window.open(blobUrl, '_blank');
                return;
            } catch (e) {
                console.error(e);
            }
        }
        window.open(currentActiveDoc.url, '_blank');
    }

    function archiveCurrentStudentDocToDigital() {
        if (!currentActiveDoc.url) {
            alert('Tidak ada berkas yang dapat diarsipkan.');
            return;
        }

        const s = currentActiveDoc.student || {};
        const safeTitle = `[${s.nis || 'SISWA'} - ${s.name || 'Siswa'}] - ${currentActiveDoc.title || 'Berkas'}`;
        const ext = currentActiveDoc.url.includes('pdf') ? 'pdf' : (currentActiveDoc.url.includes('png') ? 'png' : 'jpg');
        const fileName = `${(s.nis || 'SISWA')}_${(currentActiveDoc.title || 'dokumen').replace(/[^a-zA-Z0-9_-]/g, '_')}.${ext}`;

        const btn = document.getElementById('indexDocArchiveBtn');
        const btnText = document.getElementById('indexDocArchiveText');
        const originalText = btnText ? btnText.textContent : 'Taruh di Arsip Digital';

        if (btnText) btnText.textContent = 'Menyimpan...';
        if (btn) btn.disabled = true;

        fetch('/admin/digital-archives/archive-receipt', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                title: safeTitle,
                file_base64: currentActiveDoc.url,
                file_name: fileName,
                category: 'dokumen_siswa',
                folder_name: 'Dokumen & Berkas Siswa',
                uploader_name: 'Admin Siswa',
                notes: `Diarsipkan otomatis dari profil siswa ${s.name} (${s.nis || '-'})`
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (btn) {
                    btn.className = "px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm";
                    btn.disabled = false;
                }
                if (btnText) {
                    btnText.innerHTML = '<span>Tersimpan di Arsip ✓</span>';
                }

                if (window.Swal) {
                    Swal.fire({
                        icon: 'success',
                        title: data.already_archived ? 'Sudah Diarsipkan' : 'Berhasil Diarsipkan!',
                        html: `<p class="text-xs text-slate-600 mb-3">${data.message}</p><a href="${data.archive_url}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition">Buka di Arsip Digital &rarr;</a>`,
                        confirmButtonColor: '#059669',
                        confirmButtonText: 'Tutup'
                    });
                }
            } else {
                throw new Error(data.message || 'Gagal menyimpan ke arsip');
            }
        })
        .catch(err => {
            console.error('Error archiving student doc:', err);
            if (btn) btn.disabled = false;
            if (btnText) btnText.textContent = originalText;
            if (window.Swal) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengarsipkan',
                    text: err.message || 'Terjadi kesalahan saat menyimpan berkas ke Arsip Digital.',
                    confirmButtonColor: '#DC2626'
                });
            } else {
                alert('Gagal menyimpan ke Arsip Digital.');
            }
        });
    }
</script>
@endsection
