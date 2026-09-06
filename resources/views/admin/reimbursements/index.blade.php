@extends('admin.layouts.admin')

@section('title', 'Klaim Reimburse & Kasbon Dinas')
@section('page_title', 'Reimbursement & Uang Muka Dinas (Cash Advance)')

@section('content')
<div class="space-y-6">

    <!-- 1. Top KPI Summary Cards -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-bold border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Auto-Sync Realtime Aktif</span>
            </span>
            <span id="rmbLastSyncNotice" class="text-[11px] text-slate-400">Sinkronisasi otomatis aktif</span>
        </div>
        <button type="button" onclick="syncReimbursementStats()" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition flex items-center gap-1">
            <i data-lucide="refresh-cw" class="w-3.5 h-3.5" id="rmbRefreshIcon"></i>
            <span>Refresh Data</span>
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold shrink-0">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
            <div class="min-w-0">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider truncate">Total Reimburse Dicairkan</p>
                <h3 id="rmbStatReimbursed" class="text-xl font-black text-slate-900 mt-0.5 truncate">Rp {{ number_format($stats['total_reimbursed'], 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold shrink-0">
                <i data-lucide="plane-takeoff" class="w-6 h-6"></i>
            </div>
            <div class="min-w-0">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider truncate">Uang Muka Berjalan (Kasbon)</p>
                <h3 id="rmbStatAdvances" class="text-xl font-black text-purple-600 mt-0.5 truncate">Rp {{ number_format($stats['active_advances'], 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold shrink-0">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
            <div class="min-w-0">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider truncate">Menunggu Verifikasi</p>
                <h3 id="rmbStatPending" class="text-2xl font-black text-amber-600 mt-0.5 truncate">{{ number_format($stats['pending_count']) }} Berkas</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold shrink-0">
                <i data-lucide="file-check" class="w-6 h-6"></i>
            </div>
            <div class="min-w-0">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider truncate">Kasbon Belum SPJ</p>
                <h3 id="rmbStatUnsettled" class="text-2xl font-black text-rose-600 mt-0.5 truncate">{{ number_format($stats['unsettled_advances_count']) }} Dinas</h3>
            </div>
        </div>

    </div>

    <!-- 2. Action & Filter Bar -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            <!-- Type Tabs -->
            <div class="flex items-center gap-1.5 p-1 bg-slate-100 rounded-xl max-w-fit">
                <a 
                    href="{{ route('admin.reimbursements.index') }}" 
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ !request('type') ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}"
                >
                    Semua Transaksi
                </a>
                <a 
                    href="{{ route('admin.reimbursements.index', ['type' => 'reimbursement']) }}" 
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ request('type') === 'reimbursement' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}"
                >
                    Klaim Reimburse
                </a>
                <a 
                    href="{{ route('admin.reimbursements.index', ['type' => 'cash_advance']) }}" 
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ request('type') === 'cash_advance' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}"
                >
                    Kasbon Dinas (Uang Muka)
                </a>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex items-center gap-2 flex-wrap">
                <a 
                    href="{{ route('admin.reimbursements.template') }}" 
                    class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                    title="Unduh format template CSV untuk pengisian data massal"
                >
                    <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i>
                    <span>Template CSV</span>
                </a>

                <button 
                    type="button" 
                    onclick="document.getElementById('importCsvModal').classList.remove('hidden')" 
                    class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                >
                    <i data-lucide="upload" class="w-4 h-4 text-blue-600"></i>
                    <span>Import File</span>
                </button>

                <a 
                    href="{{ route('admin.reimbursements.export', request()->all()) }}" 
                    class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                >
                    <i data-lucide="download" class="w-4 h-4 text-slate-600"></i>
                    <span>Export CSV</span>
                </a>

                <a 
                    href="{{ route('admin.reimbursements.export.pdf', request()->all()) }}" 
                    target="_blank"
                    class="px-3 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition flex items-center gap-1.5"
                >
                    <i data-lucide="printer" class="w-4 h-4 text-red-400"></i>
                    <span>Export PDF</span>
                </a>

                <button 
                    type="button" 
                    onclick="openCreateReimbursementModal()" 
                    class="btn-red-primary px-4 py-2 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5"
                >
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Buat Pengajuan Baru</span>
                </button>
            </div>

        </div>

        <!-- Quick Period Filter Pills -->
        <div class="flex items-center justify-between flex-wrap gap-2 pt-2 border-t border-slate-100">
            <div class="flex items-center gap-1.5 flex-wrap">
                <span class="text-[11px] font-black uppercase tracking-wider text-slate-400 mr-1 flex items-center gap-1">
                    <i data-lucide="calendar-range" class="w-3.5 h-3.5"></i>
                    <span>Periode:</span>
                </span>

                @php
                    $currPeriod = request('period');
                    $baseParams = request()->except(['period', 'page']);
                @endphp

                <a 
                    href="{{ route('admin.reimbursements.index', array_merge($baseParams, ['period' => ''])) }}"
                    class="px-2.5 py-1 rounded-lg text-xs font-bold transition {{ !$currPeriod && !request('date_from') && !request('date_to') ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}"
                >
                    Semua Waktu
                </a>

                <a 
                    href="{{ route('admin.reimbursements.index', array_merge($baseParams, ['period' => 'today'])) }}"
                    class="px-2.5 py-1 rounded-lg text-xs font-bold transition {{ $currPeriod === 'today' ? 'bg-japan-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}"
                >
                    Hari Ini (Harian)
                </a>

                <a 
                    href="{{ route('admin.reimbursements.index', array_merge($baseParams, ['period' => 'weekly'])) }}"
                    class="px-2.5 py-1 rounded-lg text-xs font-bold transition {{ $currPeriod === 'weekly' ? 'bg-japan-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}"
                >
                    Minggu Ini
                </a>

                <a 
                    href="{{ route('admin.reimbursements.index', array_merge($baseParams, ['period' => 'monthly'])) }}"
                    class="px-2.5 py-1 rounded-lg text-xs font-bold transition {{ $currPeriod === 'monthly' ? 'bg-japan-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}"
                >
                    Bulan Ini
                </a>

                @if(request('date_from') || request('date_to'))
                    <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 text-[10px] font-black uppercase tracking-wider">
                        Rentang Kustom Aktif
                    </span>
                @endif
            </div>

            <div class="text-[11px] text-slate-400 font-medium">
                Total data terfilter: <span class="font-bold text-slate-700">{{ $reimbursements->total() }}</span>
            </div>
        </div>

        <!-- Filter Fields Form -->
        <form action="{{ route('admin.reimbursements.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-2.5 pt-2 border-t border-slate-100">
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            @if(request('period'))
                <input type="hidden" name="period" value="{{ request('period') }}">
            @endif

            <!-- Search -->
            <div class="relative lg:col-span-3">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="No. Dokumen / Judul / Nama..." 
                    class="w-full pl-9 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-medium"
                >
            </div>

            <!-- Status -->
            <div class="lg:col-span-2">
                <select name="status" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600 bg-white">
                    <option value="">Semua Status</option>
                    <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Dana Dicairkan</option>
                    <option value="settled" {{ request('status') === 'settled' ? 'selected' : '' }}>Selesai (SPJ Valid)</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Kategori -->
            <div class="lg:col-span-2">
                <select name="category" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600 bg-white">
                    <option value="">Semua Kategori</option>
                    <option value="mou_perjalanan_dinas" {{ request('category') === 'mou_perjalanan_dinas' ? 'selected' : '' }}>Perjalanan Dinas MoU</option>
                    <option value="transportasi" {{ request('category') === 'transportasi' ? 'selected' : '' }}>Transportasi (Tiket/Bensin)</option>
                    <option value="akomodasi_hotel" {{ request('category') === 'akomodasi_hotel' ? 'selected' : '' }}>Akomodasi Hotel</option>
                    <option value="konsumsi_meeting" {{ request('category') === 'konsumsi_meeting' ? 'selected' : '' }}>Konsumsi & Jamuan</option>
                    <option value="operasional_kantor" {{ request('category') === 'operasional_kantor' ? 'selected' : '' }}>Operasional Lembaga</option>
                </select>
            </div>

            <!-- Rentang Tanggal Dari -->
            <div class="lg:col-span-2">
                <div class="relative">
                    <input 
                        type="date" 
                        name="date_from" 
                        value="{{ request('date_from') }}" 
                        title="Tanggal Mulai / Dari"
                        class="w-full px-2.5 py-1.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 bg-white font-medium"
                    >
                </div>
            </div>

            <!-- Rentang Tanggal Sampai -->
            <div class="lg:col-span-2">
                <div class="relative">
                    <input 
                        type="date" 
                        name="date_to" 
                        value="{{ request('date_to') }}" 
                        title="Tanggal Selesai / Sampai"
                        class="w-full px-2.5 py-1.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 bg-white font-medium"
                    >
                </div>
            </div>

            <!-- Actions -->
            <div class="lg:col-span-1 flex items-center gap-1.5">
                <button type="submit" class="flex-1 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition shadow-xs">
                    Cari
                </button>
                @if(request()->anyFilled(['search', 'status', 'category', 'date_from', 'date_to', 'period']))
                    <a href="{{ route('admin.reimbursements.index', ['type' => request('type')]) }}" class="p-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition" title="Reset Semua Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>

    </div>

    <!-- 3. Reimbursements Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-extrabold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3.5">Dokumen & Transaksi</th>
                        <th class="px-4 py-3.5">Karyawan / Pemohon</th>
                        <th class="px-4 py-3.5">Keperluan & Tujuan Dinas</th>
                        <th class="px-4 py-3.5 text-right">Diajukan</th>
                        <th class="px-4 py-3.5 text-right">Disetujui / Kasbon</th>
                        <th class="px-4 py-3.5 text-right">Realisasi (SPJ)</th>
                        <th class="px-4 py-3.5 text-center">Status</th>
                        <th class="px-4 py-3.5 text-center">Aksi Bendahara</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reimbursements as $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Dokumen & Transaksi -->
                            <td class="px-4 py-3.5 space-y-1">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-mono font-bold text-slate-900">{{ $item->reimbursement_no }}</span>
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-black border {{ $item->type_badge['bg'] }}">
                                        {{ $item->type_badge['short_label'] }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-400 font-medium">
                                    {{ $item->created_at->format('d M Y H:i') }}
                                </p>
                            </td>

                            <!-- Karyawan -->
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center font-bold text-slate-600 text-xs flex-shrink-0">
                                        @if($item->employee && $item->employee->photo)
                                            <img src="{{ $item->employee->photo }}" alt="{{ $item->employee_name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($item->employee_name, 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-900 leading-tight">{{ $item->employee_name }}</h5>
                                        <p class="text-[11px] text-slate-400">{{ $item->employee ? ($item->employee->position_title ?: $item->employee->role_badge['label']) : 'Karyawan' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Keperluan & Tujuan -->
                            <td class="px-4 py-3.5 max-w-xs space-y-1">
                                <h6 class="font-bold text-slate-800 leading-snug truncate" title="{{ $item->title }}">
                                    {{ $item->title }}
                                </h6>
                                <div class="flex items-center gap-2 text-[11px] text-slate-500">
                                    @if($item->destination)
                                        <span class="flex items-center gap-1 text-slate-600 font-semibold">
                                            <i data-lucide="map-pin" class="w-3 h-3 text-red-500"></i>
                                            <span>{{ $item->destination }}</span>
                                        </span>
                                    @endif
                                    @if($item->start_date)
                                        <span>• {{ $item->start_date->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                                @if(!empty($item->receipts_data) && count($item->receipts_data) > 0)
                                    <div class="pt-1">
                                        <button 
                                            type="button" 
                                            onclick='openReceiptViewerModal({{ $item->id }}, "{{ $item->reimbursement_no }}", "{{ addslashes($item->employee_name) }}", "{{ addslashes($item->title) }}", @json($item->receipts_data))' 
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold text-japan-700 bg-red-50 hover:bg-red-100 border border-red-200 transition cursor-pointer shadow-2xs group"
                                            title="Lihat, Unduh & Simpan ke Arsip Digital"
                                        >
                                            <i data-lucide="eye" class="w-3.5 h-3.5 text-japan-600 group-hover:scale-110 transition"></i>
                                            <span>{{ count($item->receipts_data) }} Bukti Nota Fisik</span>
                                        </button>
                                    </div>
                                @endif
                            </td>

                            <!-- Nominal Diajukan -->
                            <td class="px-4 py-3.5 text-right font-bold text-slate-700">
                                Rp {{ number_format($item->amount_requested, 0, ',', '.') }}
                            </td>

                            <!-- Nominal Disetujui / Uang Muka -->
                            <td class="px-4 py-3.5 text-right font-black {{ $item->amount_approved > 0 ? 'text-slate-900' : 'text-slate-400' }}">
                                Rp {{ number_format($item->amount_approved, 0, ',', '.') }}
                            </td>

                            <!-- Realisasi SPJ & Selisih -->
                            <td class="px-4 py-3.5 text-right space-y-0.5">
                                @if($item->type === 'cash_advance')
                                    <span class="font-black text-slate-900 block">
                                        Rp {{ number_format($item->amount_spent, 0, ',', '.') }}
                                    </span>
                                    @if($item->status === 'settled')
                                        @if($item->amount_diff > 0)
                                            <span class="text-[10px] font-bold text-rose-600 block">
                                                Kurang Bayar Rp {{ number_format($item->amount_diff, 0, ',', '.') }}
                                            </span>
                                        @elseif($item->amount_diff < 0)
                                            <span class="text-[10px] font-bold text-emerald-600 block">
                                                Lebih Bayar Rp {{ number_format(abs($item->amount_diff), 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-[10px] font-bold text-slate-400 block">Pas (Sesuai)</span>
                                        @endif
                                    @endif
                                @else
                                    <span class="text-slate-400 font-medium">-</span>
                                @endif
                            </td>

                            <!-- Status & Sinkronisasi Buku Kas -->
                            <td class="px-4 py-3.5 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $item->status_badge['bg'] }}">
                                    <i data-lucide="{{ $item->status_badge['icon'] }}" class="w-3 h-3"></i>
                                    <span>{{ $item->status_badge['label'] }}</span>
                                </span>
                                @php
                                    $expenseTrx = $item->cashTransactions ? $item->cashTransactions->where('type', 'expense')->first() : null;
                                    $returnTrx = $item->cashTransactions ? $item->cashTransactions->where('type', 'income')->first() : null;
                                @endphp
                                @if($expenseTrx)
                                    <div class="mt-1">
                                        <a href="{{ route('admin.cash-book.index', ['search' => $expenseTrx->transaction_number]) }}" 
                                           class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200 hover:bg-emerald-100 transition"
                                           title="Buka transaksi di Buku Kas & Jurnal">
                                            <i data-lucide="book-check" class="w-2.5 h-2.5"></i>
                                            <span>Kas: {{ $expenseTrx->transaction_number }}</span>
                                        </a>
                                    </div>
                                @endif
                                @if($returnTrx)
                                    <div class="mt-0.5">
                                        <a href="{{ route('admin.cash-book.index', ['search' => $returnTrx->transaction_number]) }}" 
                                           class="inline-flex items-center gap-1 text-[10px] font-bold text-sky-700 bg-sky-50 px-2 py-0.5 rounded-md border border-sky-200 hover:bg-sky-100 transition"
                                           title="Sisa Kasbon Masuk ke Buku Kas">
                                            <i data-lucide="arrow-down-left" class="w-2.5 h-2.5"></i>
                                            <span>Sisa: {{ $returnTrx->transaction_number }}</span>
                                        </a>
                                    </div>
                                @endif
                            </td>

                            <!-- Aksi Bendahara -->
                            <td class="px-4 py-3.5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    
                                    <!-- Print Lembar SPJ / Kuitansi -->
                                    <a 
                                        href="{{ route('admin.reimbursements.print', $item->id) }}" 
                                        target="_blank"
                                        class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition"
                                        title="Cetak Lembar Pertanggungjawaban SPJ Resmi (A4)"
                                    >
                                        <i data-lucide="printer" class="w-4 h-4"></i>
                                    </a>

                                    @if(!empty($item->receipts_data) && count($item->receipts_data) > 0)
                                        <!-- Lihat & Unduh Nota Fisik (Arsip Digital) -->
                                        <button 
                                            type="button" 
                                            onclick='openReceiptViewerModal({{ $item->id }}, "{{ $item->reimbursement_no }}", "{{ addslashes($item->employee_name) }}", "{{ addslashes($item->title) }}", @json($item->receipts_data))' 
                                            class="p-1.5 rounded-lg bg-japan-50 hover:bg-japan-100 text-japan-600 font-bold transition cursor-pointer"
                                            title="Lihat & Unduh Nota Fisik (Arsip Digital)"
                                        >
                                            <i data-lucide="receipt" class="w-4 h-4"></i>
                                        </button>
                                    @endif

                                    @if($expenseTrx)
                                        <!-- Cetak Lembar Voucher Kas Keluar (BKK) -->
                                        <a 
                                            href="{{ route('admin.cash-book.print', $expenseTrx->id) }}" 
                                            target="_blank"
                                            class="p-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold transition"
                                            title="Cetak Voucher Kas Keluar (BKK: {{ $expenseTrx->transaction_number }})"
                                        >
                                            <i data-lucide="file-text" class="w-4 h-4"></i>
                                        </a>
                                    @endif

                                    <!-- Verifikasi Status: Approve / Pay (Cairkan) -->
                                    @if($item->status === 'submitted')
                                        <form action="{{ route('admin.reimbursements.status', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <input type="hidden" name="amount_approved" value="{{ $item->amount_requested }}">
                                            <button 
                                                type="submit" 
                                                class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold transition"
                                                title="Setujui Dokumen (Plafon Disetujui)"
                                            >
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                            </button>
                                        </form>

                                        <button 
                                            type="button" 
                                            onclick="openPayModal('{{ $item->id }}', '{{ $item->reimbursement_no }}', '{{ addslashes($item->employee_name) }}', '{{ $item->amount_requested }}', '{{ addslashes($item->title) }}', '{{ $item->type }}')"
                                            class="px-2 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] transition flex items-center gap-1 shadow-xs cursor-pointer"
                                            title="Setujui & Langsung Cairkan Kas/Bank"
                                        >
                                            <i data-lucide="banknote" class="w-3.5 h-3.5"></i>
                                            <span>Cairkan</span>
                                        </button>
                                    @elseif($item->status === 'approved')
                                        <button 
                                            type="button" 
                                            onclick="openPayModal('{{ $item->id }}', '{{ $item->reimbursement_no }}', '{{ addslashes($item->employee_name) }}', '{{ $item->amount_approved > 0 ? $item->amount_approved : $item->amount_requested }}', '{{ addslashes($item->title) }}', '{{ $item->type }}')"
                                            class="px-2 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] transition flex items-center gap-1 shadow-xs cursor-pointer"
                                            title="Cairkan Uang Reimburse / Kasbon ke Karyawan (Catat ke Buku Kas)"
                                        >
                                            <i data-lucide="banknote" class="w-3.5 h-3.5"></i>
                                            <span>Cairkan</span>
                                        </button>
                                    @endif

                                    <!-- Input Realisasi Kasbon (Settlement) -->
                                    @if($item->type === 'cash_advance' && in_array($item->status, ['paid', 'approved']))
                                        <button 
                                            type="button" 
                                            onclick="openSettlementModal('{{ $item->id }}', '{{ $item->reimbursement_no }}', '{{ $item->amount_approved }}', '{{ addslashes($item->employee_name) }}', '{{ addslashes($item->title) }}')"
                                            class="px-2 py-1 rounded-lg bg-purple-100 hover:bg-purple-200 text-purple-800 font-bold text-[11px] transition flex items-center gap-1 cursor-pointer"
                                            title="Laporkan Nota Realisasi Pengeluaran SPJ Kasbon"
                                        >
                                            <i data-lucide="clipboard-check" class="w-3.5 h-3.5"></i>
                                            <span>SPJ</span>
                                        </button>
                                    @endif

                                    <!-- Kirim Notifikasi WhatsApp Fonnte -->
                                    @php
                                        $empPhone = $item->employee ? $item->employee->phone : '';
                                    @endphp
                                    <button 
                                        type="button" 
                                        onclick="openWaModal('{{ $item->id }}', '{{ $item->reimbursement_no }}', '{{ addslashes($item->employee_name) }}', '{{ $empPhone }}', '{{ addslashes($item->title) }}')"
                                        class="p-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-600 font-bold transition cursor-pointer" 
                                        title="Kirim Notifikasi WhatsApp Pemohon via Fonnte"
                                    >
                                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                                    </button>

                                    <!-- Hapus Dokumen -->
                                    <form action="{{ route('admin.reimbursements.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengajuan {{ $item->reimbursement_no }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold transition cursor-pointer" title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-16 text-center text-slate-400">
                                <div class="w-14 h-14 rounded-2xl bg-slate-50 text-slate-400 mx-auto flex items-center justify-center mb-3">
                                    <i data-lucide="receipt" class="w-7 h-7"></i>
                                </div>
                                <h4 class="font-extrabold text-slate-800 text-sm">Belum Ada Transaksi Reimburse atau Kasbon</h4>
                                <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Buat Pengajuan Baru" atau "Import File" untuk menambahkan data dinas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reimbursements->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $reimbursements->links() }}
            </div>
        @endif
    </div>

</div>

<!-- MODAL 1: FORM PENGAJUAN BARU (REIMBURSE & CASH ADVANCE) -->
<div id="createReimbursementModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 flex items-center justify-center p-3 sm:p-5 hidden" onclick="handleBackdropClick(event, 'createReimbursementModal')">
    <div class="bg-white rounded-3xl max-w-4xl w-full max-h-[94vh] flex flex-col shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        
        <!-- Header Modal -->
        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-red-50/60 via-white to-slate-50">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-japan-600 text-white flex items-center justify-center font-bold shadow-lg shadow-japan-600/25">
                    <i data-lucide="receipt" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-black text-slate-900 text-base sm:text-lg tracking-tight">Form Pengajuan Biaya & Uang Muka Dinas</h3>
                        <span class="px-2 py-0.5 rounded-full bg-japan-50 text-japan-700 text-[10px] font-bold border border-japan-200">経費精算</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">Klaim penggantian nota riil atau permohonan modal kasbon pra-perjalanan dinas</p>
                </div>
            </div>
            <button type="button" onclick="closeCreateReimbursementModal()" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Form Body -->
        <form action="{{ route('admin.reimbursements.store') }}" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto p-5 sm:p-7 space-y-6">
            @csrf

            <!-- Section 1: Tipe Pengajuan Keuangan -->
            <div class="space-y-2.5">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-700 text-[11px] font-black flex items-center justify-center">1</span>
                        <span>Pilih Tipe Pengajuan Keuangan</span>
                        <span class="text-rose-500">*</span>
                    </label>
                    <span class="text-[11px] text-slate-400 font-medium">Pilih salah satu metode</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <!-- Option 1: Reimburse -->
                    <label class="relative p-4 rounded-2xl border-2 cursor-pointer transition-all flex items-start gap-3.5 border-sky-500 bg-sky-50/40 text-slate-900 shadow-sm" id="labelTypeReimburse">
                        <input type="radio" name="type" value="reimbursement" checked onchange="toggleTypeNotice('reimbursement')" class="mt-1 text-sky-600 focus:ring-sky-500">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <span class="font-black text-xs sm:text-sm text-slate-900">Klaim Reimburse (Klaim Balik)</span>
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-sky-100 text-sky-800 border border-sky-200">Pasca Dinas</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                Karyawan telah menalangi biaya dinas terlebih dahulu. Penggantian dana dicairkan setelah bukti nota diverifikasi oleh bendahara.
                            </p>
                        </div>
                    </label>

                    <!-- Option 2: Cash Advance -->
                    <label class="relative p-4 rounded-2xl border-2 cursor-pointer transition-all flex items-start gap-3.5 border-slate-200 hover:border-purple-300 text-slate-900" id="labelTypeAdvance">
                        <input type="radio" name="type" value="cash_advance" onchange="toggleTypeNotice('cash_advance')" class="mt-1 text-purple-600 focus:ring-purple-500">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <span class="font-black text-xs sm:text-sm text-slate-900">Uang Muka Dinas (Kasbon)</span>
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-purple-100 text-purple-800 border border-purple-200">Pra Dinas</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                Dana dicairkan di muka sebelum dinas keluar kota. Bukti pengeluaran dan nota fisik dipertanggungjawabkan (SPJ) setelah dinas.
                            </p>
                        </div>
                    </label>
                </div>

                <!-- Dynamic Guide Notice -->
                <div id="typeNoticeBox" class="p-3 bg-sky-50 border border-sky-200/80 rounded-2xl flex items-start gap-2.5 text-xs text-sky-900">
                    <i data-lucide="info" class="w-4 h-4 text-sky-600 shrink-0 mt-0.5"></i>
                    <span id="typeNoticeText">
                        <strong>Panduan Reimburse:</strong> Harap lampirkan bukti foto nota/kuitansi fisik pada bagian bawah. Setelah disetujui, bendahara akan langsung mencairkan dana ke kas/rekening Anda.
                    </span>
                </div>
            </div>

            <!-- Section 2 & 3: 2-Column Responsive Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Left Column: Data Pemohon, Kategori & Agenda -->
                <div class="space-y-4">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-700 text-[11px] font-black flex items-center justify-center">2</span>
                        <span>Informasi Pemohon & Kategori</span>
                    </label>

                    <div class="space-y-3.5 bg-slate-50/70 p-4 rounded-2xl border border-slate-200/80">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Karyawan / Pejabat Pemohon <span class="text-rose-500">*</span></label>
                            <select name="teacher_id" id="selectEmployee" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600 focus:ring-1 focus:ring-japan-600 transition bg-white shadow-xs">
                                <option value="">-- Pilih Karyawan / Direksi / Sensei --</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">
                                        {{ $emp->name }} ({{ $emp->position_title ?: $emp->role_badge['label'] }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Pos Kategori Pengeluaran <span class="text-rose-500">*</span></label>
                            <select name="category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600 focus:ring-1 focus:ring-japan-600 transition bg-white shadow-xs">
                                <option value="mou_perjalanan_dinas">🤝 Perjalanan Dinas MoU Poltekkes & SMK</option>
                                <option value="transportasi">🚄 Transportasi (Tiket Pesawat / Kereta / Bensin / Tol)</option>
                                <option value="akomodasi_hotel">🏨 Akomodasi / Penginapan Hotel Dinas</option>
                                <option value="konsumsi_meeting">🍱 Konsumsi & Jamuan Meeting Mitra Kaisha</option>
                                <option value="operasional_kantor">🏢 Operasional Kantor & Pelatihan Siswa</option>
                                <option value="lainnya">📦 Keperluan Dinas Lainnya</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Agenda / Keperluan Dinas <span class="text-rose-500">*</span></label>
                            <input 
                                type="text" 
                                name="title" 
                                required 
                                placeholder="Contoh: MoU Kemitraan Poltekkes Semarang & Pelatihan Interview" 
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600 focus:ring-1 focus:ring-japan-600 transition bg-white shadow-xs"
                            >
                        </div>
                    </div>
                </div>

                <!-- Right Column: Lokasi, Jadwal & Nominal -->
                <div class="space-y-4">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-700 text-[11px] font-black flex items-center justify-center">3</span>
                        <span>Lokasi, Jadwal & Anggaran</span>
                    </label>

                    <div class="space-y-3.5 bg-slate-50/70 p-4 rounded-2xl border border-slate-200/80">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Kota / Lokasi Tujuan</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-rose-500"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="destination" 
                                    placeholder="Contoh: Semarang, Solo & Yogyakarta" 
                                    class="w-full pl-9 pr-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-none focus:border-japan-600 bg-white shadow-xs"
                                >
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Tanggal Mulai</label>
                                <input 
                                    type="date" 
                                    name="start_date" 
                                    id="inputStartDate"
                                    value="{{ date('Y-m-d') }}" 
                                    onchange="updateTripDuration()"
                                    class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-none focus:border-japan-600 bg-white shadow-xs"
                                >
                            </div>

                            <div class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <label class="block text-xs font-bold text-slate-700">Tanggal Selesai</label>
                                    <span id="tripDurationBadge" class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">1 Hari</span>
                                </div>
                                <input 
                                    type="date" 
                                    name="end_date" 
                                    id="inputEndDate"
                                    value="{{ date('Y-m-d') }}" 
                                    onchange="updateTripDuration()"
                                    class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-none focus:border-japan-600 bg-white shadow-xs"
                                >
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nominal yang Diajukan (Rp) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-xs text-slate-400">Rp</span>
                                <input 
                                    type="number" 
                                    name="amount_requested" 
                                    id="inputAmountRequested"
                                    required 
                                    min="1" 
                                    oninput="updateAmountPreview(this.value)"
                                    placeholder="Contoh: 2500000" 
                                    class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-black text-slate-900 focus:outline-none focus:border-japan-600 focus:ring-1 focus:ring-japan-600 transition bg-white shadow-xs"
                                >
                            </div>
                            <div id="amountPreviewText" class="text-[11px] font-semibold text-japan-700 mt-1 min-h-[16px]"></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Section 4: Catatan Tambahan (Full Width) -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Catatan / Keterangan Khusus (Opsional)</label>
                <textarea 
                    name="notes" 
                    rows="2" 
                    placeholder="Rincian agenda mitra kaisha yang dikunjungi, kontak PIC, atau alasan urgensi dinas..." 
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600 transition bg-white"
                ></textarea>
            </div>

            <!-- Section 5: Lampiran Multi-Nota Fisik Base64 -->
            <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3.5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="font-extrabold text-xs text-slate-900 flex items-center gap-1.5">
                                <i data-lucide="paperclip" class="w-4 h-4 text-japan-600"></i>
                                <span>Lampiran Bukti Nota & Kuitansi Pengeluaran</span>
                            </h4>
                            <span id="receiptSummaryBadge" class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">1 Nota</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-0.5">Tersimpan aman di database base64 tanpa risiko hilang saat hosting berpindah</p>
                    </div>
                    <button type="button" onclick="addReceiptUploadRow()" class="px-3.5 py-1.5 rounded-xl bg-japan-50 hover:bg-japan-100 text-japan-700 text-xs font-bold transition flex items-center gap-1.5 shadow-xs border border-japan-200 cursor-pointer self-start sm:self-auto">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        <span>Tambah Baris Nota</span>
                    </button>
                </div>

                <div id="receiptUploadContainer" class="space-y-2.5">
                    <div class="receipt-row p-3 bg-white rounded-xl border border-slate-200 grid grid-cols-1 sm:grid-cols-12 gap-2.5 items-center shadow-xs">
                        <div class="sm:col-span-5">
                            <input type="text" name="receipt_titles[]" placeholder="Nama Nota 1 (cth: Tiket Kereta PP / Hotel)" class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-200 focus:border-japan-500 focus:outline-none">
                        </div>
                        <div class="sm:col-span-3">
                            <div class="relative">
                                <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-[10px] font-bold text-slate-400">Rp</span>
                                <input type="number" name="receipt_amounts[]" oninput="calculateTotalReceipts()" placeholder="Nominal Rp" class="receipt-amount-input w-full pl-7 pr-2 py-1.5 text-xs rounded-lg border border-slate-200 focus:border-japan-500 focus:outline-none font-semibold">
                            </div>
                        </div>
                        <div class="sm:col-span-3 flex items-center gap-2">
                            <input type="file" name="receipt_files[]" accept="image/*,application/pdf" onchange="handleReceiptPreview(this)" class="w-full text-xs file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-japan-600 file:text-white hover:file:bg-japan-700 file:cursor-pointer cursor-pointer">
                            <div class="receipt-preview-thumb hidden w-7 h-7 rounded bg-slate-100 border border-slate-200 overflow-hidden shrink-0"></div>
                        </div>
                        <div class="sm:col-span-1 text-center">
                            <button type="button" onclick="removeReceiptRow(this)" class="p-1.5 text-slate-300 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition cursor-pointer" title="Hapus baris ini">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Total Nota Live Calculation -->
                <div class="pt-2 border-t border-slate-200/80 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">Total Akumulasi Nota Terlampir:</span>
                    <span id="totalReceiptsFormatted" class="font-black text-slate-900 font-mono">Rp 0</span>
                </div>
            </div>

            <!-- Footer Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3 sticky bottom-0 bg-white/95 backdrop-blur-xs py-2">
                <button type="button" onclick="closeCreateReimbursementModal()" class="px-5 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-bold transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="btn-red-primary px-7 py-2.5 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>Kirim Pengajuan Keuangan</span>
                </button>
            </div>

        </form>

    </div>
</div>

<!-- MODAL 2: SETTLEMENT REALISASI KASBON SPJ -->
<div id="settlementModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 flex items-center justify-center p-3 sm:p-5 hidden" onclick="handleBackdropClick(event, 'settlementModal')">
    <div class="bg-white rounded-3xl max-w-xl w-full max-h-[92vh] flex flex-col shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        
        <!-- Header Modal -->
        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-purple-50 via-white to-purple-50/40">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-purple-600 text-white flex items-center justify-center font-bold shadow-lg shadow-purple-600/25">
                    <i data-lucide="clipboard-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-black text-slate-900 text-base leading-tight">Penyelesaian Realisasi SPJ Kasbon</h3>
                        <span class="px-2 py-0.5 rounded-full bg-purple-100 text-purple-800 text-[10px] font-bold border border-purple-200">仮払金精算</span>
                    </div>
                    <p class="text-[11px] text-slate-500 font-mono mt-0.5" id="modalSettlementDocNo">ADV-SJI/...</p>
                </div>
            </div>
            <button type="button" onclick="closeSettlementModal()" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form id="settlementForm" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto p-5 sm:p-6 space-y-4">
            @csrf
            <input type="hidden" name="action" value="settle">

            <!-- Card Informasi Pengajuan Awal -->
            <div class="p-4 bg-gradient-to-br from-purple-50/80 to-slate-50 rounded-2xl border border-purple-100 text-xs space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-slate-500">Nama Pemohon:</span>
                    <span class="font-bold text-slate-800" id="modalSettlementName">-</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500">Agenda / Keperluan:</span>
                    <span class="font-semibold text-slate-700 truncate max-w-[260px]" id="modalSettlementTitle">-</span>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-purple-200/50">
                    <span class="font-bold text-purple-900">Plafon Uang Muka Diterima:</span>
                    <span class="font-black text-purple-700 text-sm font-mono" id="modalSettlementApproved">-</span>
                </div>
            </div>

            <!-- Input Realisasi Pengeluaran Aktual -->
            <div class="space-y-1.5">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-700">
                    Total Pengeluaran Aktual Riil (Rp) <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-xs text-slate-400">Rp</span>
                    <input 
                        type="number" 
                        name="amount_spent" 
                        id="modalAmountSpent" 
                        required 
                        min="0" 
                        oninput="calculateSettlementDiff()"
                        placeholder="Masukkan total nominal pengeluaran riil" 
                        class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-base font-black text-slate-900 focus:outline-none focus:border-purple-600 focus:ring-1 focus:ring-purple-600 transition shadow-xs"
                    >
                </div>
                <p class="text-[10px] text-slate-400">Isi sesuai total penjumlahan seluruh nota kuitansi fisik pengeluaran dinas.</p>
            </div>

            <!-- Dynamic Live Calculation Difference Box -->
            <div id="settlementCalcCard" class="p-3.5 rounded-2xl border transition-all text-xs space-y-1.5 bg-slate-50 border-slate-200">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-slate-600" id="calcDiffLabel">Status Selisih Kas:</span>
                    <span class="font-black font-mono text-sm text-slate-800" id="calcDiffBadge">Rp 0</span>
                </div>
                <p class="text-[11px] text-slate-500 leading-relaxed" id="calcDiffExplanation">
                    Masukkan nominal pengeluaran aktual di atas untuk melihat status pengembalian atau penggantian dana.
                </p>
            </div>

            <!-- Akun Kas Rekonsiliasi & Tanggal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Akun Kas / Bank Rekonsiliasi <span class="text-rose-500">*</span></label>
                    <select name="settlement_payment_method" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-purple-600 bg-white shadow-xs">
                        <option value="cash_kasir">Kas Tunai (Kasir LPK)</option>
                        <option value="bank_mandiri">Transfer Bank Mandiri</option>
                        <option value="bank_bca">Transfer Bank BCA</option>
                        <option value="bank_bni">Transfer Bank BNI</option>
                        <option value="qris_transfer">QRIS / Digital Transfer</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Tanggal Rekonsiliasi SPJ <span class="text-rose-500">*</span></label>
                    <input 
                        type="date" 
                        name="settlement_date" 
                        value="{{ date('Y-m-d') }}" 
                        required 
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-none focus:border-purple-600 bg-white shadow-xs"
                    >
                </div>
            </div>

            <!-- Unggah Nota Realisasi SPJ Tambahan -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Unggah Nota / Kuitansi Realisasi Tambahan</label>
                <input 
                    type="file" 
                    name="settlement_receipts[]" 
                    multiple 
                    accept="image/*,application/pdf" 
                    class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs file:mr-2 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-[11px] file:font-bold file:bg-purple-600 file:text-white hover:file:bg-purple-700 cursor-pointer"
                >
                <p class="text-[10px] text-slate-400">Bisa memilih lebih dari 1 file gambar / PDF (tiket pesawat, hotel, bensin, dll).</p>
            </div>

            <!-- Catatan SPJ -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Catatan Penyelesaian Rekonsiliasi</label>
                <textarea 
                    name="settlement_notes" 
                    rows="2" 
                    placeholder="Sisa uang kasbon telah disetorkan tunai ke kasir / seluruh bukti perjalanan lengkap..." 
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-purple-600 transition"
                ></textarea>
            </div>

            <!-- Checkbox Notifikasi WhatsApp -->
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="notify_wa" value="1" checked class="w-4 h-4 rounded text-japan-600 focus:ring-japan-500">
                    <span class="text-xs font-semibold text-slate-700">Kirim laporan penyelesaian SPJ ke WhatsApp pemohon</span>
                </label>
            </div>

            <!-- Accounting Notice -->
            <div class="p-3 bg-purple-50/50 rounded-xl border border-purple-200/60 flex items-start gap-2.5">
                <i data-lucide="info" class="w-4 h-4 text-purple-600 shrink-0 mt-0.5"></i>
                <p class="text-[11px] text-purple-900 leading-relaxed">
                    <strong>Sinkronisasi Jurnal Buku Kas:</strong> Jika terdapat sisa uang kasbon, otomatis tercatat sebagai <strong>Kas Masuk (BKM)</strong>. Jika pengeluaran aktual melebihi uang muka, otomatis tercatat sebagai <strong>Kas Keluar (BKK)</strong>.
                </p>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2 sticky bottom-0 bg-white py-2">
                <button type="button" onclick="closeSettlementModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-bold transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer">
                    <i data-lucide="clipboard-check" class="w-4 h-4"></i>
                    <span>Simpan Settlement SPJ</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 2.5: PENCAIRAN DANA REIMBURSE & KASBON (BUKU KAS & JURNAL) -->
<div id="payDisbursementModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden" onclick="handleBackdropClick(event, 'payDisbursementModal')">
    <div class="bg-white rounded-3xl max-w-lg w-full max-h-[92vh] flex flex-col shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        
        <!-- Header Modal -->
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-emerald-50 via-teal-50/30 to-emerald-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold shadow-md shadow-emerald-600/20">
                    <i data-lucide="banknote" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-black text-slate-900 text-sm">Pencairan Dana (Buku Kas & Jurnal)</h3>
                        <span class="px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold">Otomatis BKK</span>
                    </div>
                    <p class="text-[11px] text-slate-500 font-mono" id="modalPayDocNo">-</p>
                </div>
            </div>
            <button type="button" onclick="closePayModal()" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition shadow-xs">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Form Body -->
        <form id="payDisbursementForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 overflow-y-auto">
            @csrf
            <input type="hidden" name="action" value="pay">

            <!-- Summary Ringkasan Pengajuan -->
            <div class="p-3.5 bg-emerald-50/60 rounded-2xl border border-emerald-100/80 text-xs space-y-1.5">
                <div class="flex justify-between items-center">
                    <span class="text-slate-500">Penerima / Pemohon:</span>
                    <span class="font-bold text-slate-800" id="modalPayEmployee">-</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500">Perihal / Keperluan:</span>
                    <span class="font-semibold text-slate-700 truncate max-w-[240px]" id="modalPayTitle">-</span>
                </div>
                <div class="flex justify-between items-center pt-1 border-t border-emerald-200/50">
                    <span class="text-slate-500 font-bold">Jenis Pengajuan:</span>
                    <span class="font-black text-emerald-800" id="modalPayType">-</span>
                </div>
            </div>

            <!-- Nominal Pencairan -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Nominal yang Dicairkan (Rp) <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-xs text-slate-400">Rp</span>
                    <input 
                        type="number" 
                        name="amount_approved" 
                        id="modalPayAmount" 
                        required 
                        min="1" 
                        class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-black text-slate-900 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition"
                    >
                </div>
            </div>

            <!-- Metode Pembayaran & Tanggal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Rekening Kas Pembayar <span class="text-rose-500">*</span></label>
                    <select name="payment_method" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-emerald-600 bg-white">
                        <option value="cash_kasir">Kas Tunai (Kasir LPK)</option>
                        <option value="bank_mandiri">Transfer Bank Mandiri</option>
                        <option value="bank_bca">Transfer Bank BCA</option>
                        <option value="bank_bni">Transfer Bank BNI</option>
                        <option value="qris_transfer">QRIS / Digital Transfer</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Tanggal Pencairan <span class="text-rose-500">*</span></label>
                    <input 
                        type="date" 
                        name="payment_date" 
                        value="{{ date('Y-m-d') }}" 
                        required 
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-none focus:border-emerald-600"
                    >
                </div>
            </div>

            <!-- Bukti Transfer / Pencairan (Opsional) -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Bukti Transfer / Struk Pencairan <span class="text-[10px] text-slate-400 font-normal">(Opsional)</span></label>
                <input 
                    type="file" 
                    name="payment_proof" 
                    accept="image/*,application/pdf" 
                    class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs file:mr-2 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-[11px] file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer"
                >
                <p class="text-[10px] text-slate-400">Jika dikosongkan, sistem otomatis menautkan nota dari pengajuan pemohon.</p>
            </div>

            <!-- Catatan Tambahan / Ref No -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Catatan / No. Referensi Transfer <span class="text-[10px] text-slate-400 font-normal">(Opsional)</span></label>
                <input 
                    type="text" 
                    name="payment_notes" 
                    placeholder="Contoh: Ref Mandiri M-Banking #94821 / Kasir Tunai Kantor" 
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-emerald-600"
                >
            </div>

            <!-- Checkbox Notifikasi WhatsApp -->
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="notify_wa" value="1" checked class="w-4 h-4 rounded text-japan-600 focus:ring-japan-500">
                    <span class="text-xs font-semibold text-slate-700">Kirim notifikasi pencairan dana ke WhatsApp pemohon via Fonnte</span>
                </label>
            </div>

            <!-- Accounting Auto-Record Info Box -->
            <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-200/60 flex items-start gap-2.5">
                <i data-lucide="info" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                <p class="text-[11px] text-emerald-900 leading-relaxed">
                    <strong>Integrasi Buku Kas & Jurnal:</strong> Pengeluaran dana ini akan langsung membukukan nomor <strong>BKK (Bukti Kas Keluar)</strong> ke Buku Kas Umum & Jurnal Pengeluaran LPK.
                </p>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closePayModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-bold transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span>Cairkan & Catat ke Buku Kas</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- MODAL 3: IMPORT FILE CSV/EXCEL -->
<div id="importCsvModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden" onclick="handleBackdropClick(event, 'importCsvModal')">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h3 class="font-black text-slate-900 text-sm">Import Data Reimburse / Kasbon CSV</h3>
            <button type="button" onclick="closeImportModal()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form action="{{ route('admin.reimbursements.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700">Pilih File CSV/Excel</label>
                <input 
                    type="file" 
                    name="csv_file" 
                    required 
                    accept=".csv,.txt" 
                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white"
                >
                <p class="text-[11px] text-slate-400">
                    Pastikan kolom sesuai dengan <a href="{{ route('admin.reimbursements.template') }}" class="text-japan-600 font-bold underline">Template CSV</a> kami.
                </p>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeImportModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold">
                    Mulai Import
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 4: KIRIM NOTIFIKASI WHATSAPP MANUAL -->
<div id="sendWaModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden" onclick="handleBackdropClick(event, 'sendWaModal')">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-emerald-50/70">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-900 text-sm">Kirim Notifikasi WhatsApp</h3>
                    <p class="text-[10px] text-emerald-800 font-semibold">Integrasi Gateway Fonnte</p>
                </div>
            </div>
            <button type="button" onclick="closeWaModal()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form id="sendWaForm" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs space-y-1">
                <div class="flex justify-between">
                    <span class="text-slate-500">No. Dokumen:</span>
                    <span class="font-black text-slate-800 font-mono" id="modalWaDocNo">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Pemohon:</span>
                    <span class="font-bold text-slate-800" id="modalWaName">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Perihal:</span>
                    <span class="font-medium text-slate-700 truncate max-w-[200px]" id="modalWaTitle">-</span>
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Nomor WhatsApp Tujuan <span class="text-rose-500">*</span></label>
                <input 
                    type="text" 
                    name="phone" 
                    id="modalWaPhone" 
                    required 
                    placeholder="Contoh: 08123456789 atau 628123456789" 
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-mono font-bold text-slate-900 focus:outline-none focus:border-emerald-600"
                >
                <p class="text-[10px] text-slate-400">Pastikan nomor aktif di WhatsApp.</p>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Catatan Tambahan (Opsional)</label>
                <textarea 
                    name="custom_notes" 
                    id="modalWaNotes" 
                    rows="2" 
                    placeholder="Contoh: Dana sudah ditransfer ke rekening BCA Anda..." 
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-emerald-600"
                ></textarea>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeWaModal()" class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-bold">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md flex items-center gap-1.5">
                    <i data-lucide="send" class="w-3.5 h-3.5"></i>
                    <span>Kirim Pesan WA</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 5: VIEWER & DOWNLOAD NOTA FISIK / ARSIP DIGITAL -->
<div id="receiptViewerModal" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-50 flex items-center justify-center p-3 sm:p-5 hidden" onclick="handleBackdropClick(event, 'receiptViewerModal')">
    <div class="bg-white rounded-3xl max-w-4xl w-full max-h-[94vh] flex flex-col shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        
        <!-- Header Modal -->
        <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 via-white to-red-50/40">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-japan-600 text-white flex items-center justify-center font-bold shadow-md shadow-japan-600/20">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-black text-slate-900 text-sm sm:text-base">Berkas Nota & Kuitansi Pengeluaran</h3>
                        <span id="rvTotalCountBadge" class="px-2 py-0.5 rounded-full bg-japan-50 text-japan-700 text-[10px] font-bold border border-japan-200">0 Nota</span>
                    </div>
                    <p class="text-[11px] text-slate-500 font-mono mt-0.5" id="rvDocSubtitle">-</p>
                </div>
            </div>
            <button type="button" onclick="closeReceiptViewerModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Body: 2 Columns on Desktop (List/Tabs + Big Preview) -->
        <div class="flex-1 overflow-hidden flex flex-col md:flex-row">
            <!-- Left Column: Receipt Selector List -->
            <div class="w-full md:w-72 border-b md:border-b-0 md:border-r border-slate-100 bg-slate-50/70 p-3.5 space-y-2 overflow-y-auto max-h-44 md:max-h-none">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-1">Daftar Nota Terlampir</p>
                <div id="rvReceiptList" class="space-y-1.5">
                    <!-- Populated by JS -->
                </div>
            </div>

            <!-- Right Column: Canvas Viewport & Action Bar -->
            <div class="flex-1 flex flex-col bg-slate-900/5 overflow-hidden">
                <!-- Preview Canvas Container -->
                <div id="rvPreviewCanvas" class="flex-1 overflow-auto p-4 flex items-center justify-center min-h-[300px] max-h-[50vh] md:max-h-[60vh] bg-slate-950/5">
                    <!-- Image or Iframe injected by JS -->
                </div>

                <!-- Action Toolbar Footer -->
                <div class="p-3.5 sm:p-4 bg-white border-t border-slate-100 flex flex-wrap items-center justify-between gap-2.5">
                    <div class="flex items-center gap-2">
                        <span id="rvCurrentFileName" class="text-xs font-bold text-slate-800 truncate max-w-[180px] sm:max-w-xs">-</span>
                        <span id="rvCurrentFileSize" class="text-[10px] font-mono text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">-</span>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap">
                        <!-- Direct Server Download Link -->
                        <a id="rvServerDownloadLink" href="#" class="hidden"></a>

                        <!-- Download Button -->
                        <button type="button" id="rvDownloadBtn" onclick="downloadCurrentReceipt()" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                            <span>Unduh Berkas</span>
                        </button>

                        <!-- Archive to Digital Archive Button -->
                        <button type="button" id="rvArchiveBtn" onclick="archiveCurrentReceiptToDigital()" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i data-lucide="folder-archive" class="w-3.5 h-3.5"></i>
                            <span id="rvArchiveBtnText">Taruh di Arsip Digital</span>
                        </button>

                        <!-- Open in New Tab -->
                        <button type="button" id="rvNewTabBtn" onclick="openCurrentReceiptInNewTab()" class="p-2 rounded-xl border border-slate-200 hover:bg-slate-100 text-slate-600 transition cursor-pointer" title="Buka di Tab Baru">
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Global Backdrop & Keyboard Navigation Handlers
    function handleBackdropClick(e, modalId) {
        if (e.target.id === modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modals = ['createReimbursementModal', 'settlementModal', 'payDisbursementModal', 'importCsvModal', 'sendWaModal', 'receiptViewerModal'];
            modals.forEach(id => {
                const el = document.getElementById(id);
                if (el && !el.classList.contains('hidden')) {
                    el.classList.add('hidden');
                }
            });
        }
    });

    // Form Pengajuan Baru Reimburse & Kasbon
    function openCreateReimbursementModal() {
        document.getElementById('createReimbursementModal').classList.remove('hidden');
        updateTripDuration();
        calculateTotalReceipts();
        if (window.lucide) lucide.createIcons();
    }

    function closeCreateReimbursementModal() {
        document.getElementById('createReimbursementModal').classList.add('hidden');
    }

    function toggleTypeNotice(type) {
        const lblReim = document.getElementById('labelTypeReimburse');
        const lblAdv = document.getElementById('labelTypeAdvance');
        const noticeBox = document.getElementById('typeNoticeBox');
        const noticeText = document.getElementById('typeNoticeText');

        if (type === 'reimbursement') {
            if (lblReim) lblReim.className = 'relative p-4 rounded-2xl border-2 cursor-pointer transition-all flex items-start gap-3.5 border-sky-500 bg-sky-50/40 text-slate-900 shadow-sm';
            if (lblAdv) lblAdv.className = 'relative p-4 rounded-2xl border-2 cursor-pointer transition-all flex items-start gap-3.5 border-slate-200 hover:border-purple-300 text-slate-900';
            if (noticeBox) noticeBox.className = 'p-3 bg-sky-50 border border-sky-200/80 rounded-2xl flex items-start gap-2.5 text-xs text-sky-900';
            if (noticeText) {
                noticeText.innerHTML = '<strong>Panduan Reimburse:</strong> Harap lampirkan bukti foto nota/kuitansi fisik pada bagian bawah. Setelah diverifikasi bendahara, penggantian dana akan langsung dicairkan ke kas/rekening Anda.';
            }
        } else {
            if (lblAdv) lblAdv.className = 'relative p-4 rounded-2xl border-2 cursor-pointer transition-all flex items-start gap-3.5 border-purple-500 bg-purple-50/40 text-slate-900 shadow-sm';
            if (lblReim) lblReim.className = 'relative p-4 rounded-2xl border-2 cursor-pointer transition-all flex items-start gap-3.5 border-slate-200 hover:border-sky-300 text-slate-900';
            if (noticeBox) noticeBox.className = 'p-3 bg-purple-50 border border-purple-200/80 rounded-2xl flex items-start gap-2.5 text-xs text-purple-900';
            if (noticeText) {
                noticeText.innerHTML = '<strong>Panduan Kasbon Dinas (Uang Muka):</strong> Dana akan dicairkan bendahara di awal sebelum perjalanan. Setelah dinas selesai, wajib melakukan SPJ (Surat Pertanggungjawaban) untuk rekonsiliasi pengeluaran riil.';
            }
        }
    }

    function updateTripDuration() {
        const start = document.getElementById('inputStartDate')?.value;
        const end = document.getElementById('inputEndDate')?.value;
        const badge = document.getElementById('tripDurationBadge');
        if (!badge || !start || !end) return;

        const startDate = new Date(start);
        const endDate = new Date(end);
        const diffDays = Math.round((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;

        if (diffDays > 0) {
            badge.textContent = diffDays + ' Hari';
            badge.className = 'text-[10px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200';
        } else {
            badge.textContent = 'Tanggal Tidak Valid';
            badge.className = 'text-[10px] font-bold text-rose-700 bg-rose-50 px-1.5 py-0.5 rounded border border-rose-200';
        }
    }

    function updateAmountPreview(val) {
        const preview = document.getElementById('amountPreviewText');
        if (!preview) return;
        const num = parseFloat(val);
        if (!isNaN(num) && num > 0) {
            preview.textContent = '≈ Rp ' + num.toLocaleString('id-ID');
        } else {
            preview.textContent = '';
        }
    }

    function updateReceiptCountBadge() {
        const container = document.getElementById('receiptUploadContainer');
        const badge = document.getElementById('receiptSummaryBadge');
        if (container && badge) {
            const count = container.querySelectorAll('.receipt-row').length;
            badge.textContent = count + ' Nota';
        }
    }

    function calculateTotalReceipts() {
        const inputs = document.querySelectorAll('.receipt-amount-input');
        let total = 0;
        inputs.forEach(input => {
            const val = parseFloat(input.value);
            if (!isNaN(val) && val > 0) total += val;
        });
        const totalEl = document.getElementById('totalReceiptsFormatted');
        if (totalEl) {
            totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    }

    function addReceiptUploadRow() {
        const container = document.getElementById('receiptUploadContainer');
        const count = container.querySelectorAll('.receipt-row').length + 1;
        const row = document.createElement('div');
        row.className = 'receipt-row p-3 bg-white rounded-xl border border-slate-200 grid grid-cols-1 sm:grid-cols-12 gap-2.5 items-center shadow-xs animate-in fade-in duration-200';
        row.innerHTML = `
            <div class="sm:col-span-5">
                <input type="text" name="receipt_titles[]" placeholder="Nama Nota ${count} (cth: Hotel / Bensin)" class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-200 focus:border-japan-500 focus:outline-none">
            </div>
            <div class="sm:col-span-3">
                <div class="relative">
                    <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-[10px] font-bold text-slate-400">Rp</span>
                    <input type="number" name="receipt_amounts[]" oninput="calculateTotalReceipts()" placeholder="Nominal Rp" class="receipt-amount-input w-full pl-7 pr-2 py-1.5 text-xs rounded-lg border border-slate-200 focus:border-japan-500 focus:outline-none font-semibold">
                </div>
            </div>
            <div class="sm:col-span-3 flex items-center gap-2">
                <input type="file" name="receipt_files[]" accept="image/*,application/pdf" onchange="handleReceiptPreview(this)" class="w-full text-xs file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-japan-600 file:text-white hover:file:bg-japan-700 file:cursor-pointer cursor-pointer">
                <div class="receipt-preview-thumb hidden w-7 h-7 rounded bg-slate-100 border border-slate-200 overflow-hidden shrink-0"></div>
            </div>
            <div class="sm:col-span-1 text-center">
                <button type="button" onclick="removeReceiptRow(this)" class="p-1.5 text-slate-300 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition cursor-pointer" title="Hapus baris ini">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        updateReceiptCountBadge();
        if (window.lucide) lucide.createIcons();
    }

    function removeReceiptRow(btn) {
        const row = btn.closest('.receipt-row');
        if (row) {
            row.remove();
            updateReceiptCountBadge();
            calculateTotalReceipts();
        }
    }

    function handleReceiptPreview(input) {
        const row = input.closest('.receipt-row');
        if (!row) return;
        const thumb = row.querySelector('.receipt-preview-thumb');
        if (!thumb) return;

        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    thumb.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    thumb.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                thumb.innerHTML = `<span class="flex items-center justify-center w-full h-full text-[9px] font-bold text-slate-500 bg-slate-100">PDF</span>`;
                thumb.classList.remove('hidden');
            }
        } else {
            thumb.classList.add('hidden');
            thumb.innerHTML = '';
        }
    }

    // SPJ Realisasi Kasbon Modal Logic
    let currentSettlementApproved = 0;

    function openSettlementModal(id, docNo, approvedAmount, employeeName, title) {
        const form = document.getElementById('settlementForm');
        form.action = `/admin/reimbursements/${id}/status`;
        document.getElementById('modalSettlementDocNo').textContent = docNo;
        document.getElementById('modalSettlementName').textContent = employeeName;
        document.getElementById('modalSettlementTitle').textContent = title || 'Perjalanan Dinas';
        
        currentSettlementApproved = parseFloat(approvedAmount) || 0;
        document.getElementById('modalSettlementApproved').textContent = 'Rp ' + currentSettlementApproved.toLocaleString('id-ID');
        document.getElementById('modalAmountSpent').value = currentSettlementApproved;
        
        calculateSettlementDiff();
        document.getElementById('settlementModal').classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }

    function closeSettlementModal() {
        document.getElementById('settlementModal').classList.add('hidden');
    }

    function calculateSettlementDiff() {
        const spentInput = document.getElementById('modalAmountSpent');
        const card = document.getElementById('settlementCalcCard');
        const badge = document.getElementById('calcDiffBadge');
        const label = document.getElementById('calcDiffLabel');
        const explanation = document.getElementById('calcDiffExplanation');

        if (!spentInput || !card || !badge || !label || !explanation) return;

        const spent = parseFloat(spentInput.value);
        if (isNaN(spent) || spent < 0) {
            card.className = 'p-3.5 rounded-2xl border transition-all text-xs space-y-1.5 bg-slate-50 border-slate-200';
            label.textContent = 'Status Selisih Kas:';
            label.className = 'font-bold text-slate-600';
            badge.textContent = 'Rp 0';
            badge.className = 'font-black font-mono text-sm text-slate-800';
            explanation.textContent = 'Masukkan nominal pengeluaran aktual di atas untuk melihat status pengembalian atau penggantian dana.';
            return;
        }

        const diff = spent - currentSettlementApproved;

        if (diff < 0) {
            // Sisa Uang Kasbon (Harus Dikembalikan ke Kasir)
            const sisa = Math.abs(diff);
            card.className = 'p-3.5 rounded-2xl border transition-all text-xs space-y-1.5 bg-emerald-50 border-emerald-300 text-emerald-950 shadow-xs';
            label.textContent = 'Status: Sisa Kasbon (Kembalikan ke Kasir LPK)';
            label.className = 'font-black text-emerald-800';
            badge.textContent = '+ Rp ' + sisa.toLocaleString('id-ID');
            badge.className = 'font-black font-mono text-base text-emerald-700';
            explanation.innerHTML = `<strong>Terdapat sisa uang kasbon sebesar Rp ${sisa.toLocaleString('id-ID')}</strong> yang wajib disetor kembali ke kasir / rekening LPK. Sistem akan membukukan transaksi ini ke <strong>Kas Masuk (BKM)</strong>.`;
        } else if (diff > 0) {
            // Kurang Bayar / Kelebihan Pengeluaran (LPK ganti ke Karyawan)
            const kurang = diff;
            card.className = 'p-3.5 rounded-2xl border transition-all text-xs space-y-1.5 bg-rose-50 border-rose-300 text-rose-950 shadow-xs';
            label.textContent = 'Status: Kurang Bayar (LPK Wajib Mengganti ke Karyawan)';
            label.className = 'font-black text-rose-800';
            badge.textContent = '- Rp ' + kurang.toLocaleString('id-ID');
            badge.className = 'font-black font-mono text-base text-rose-700';
            explanation.innerHTML = `Pengeluaran riil melebihi plafon awal sebesar <strong>Rp ${kurang.toLocaleString('id-ID')}</strong>. LPK wajib mencairkan kekurangan dana ini kepada pemohon. Sistem akan membukukan transaksi ini ke <strong>Kas Keluar (BKK)</strong>.`;
        } else {
            // Pas (Nihil)
            card.className = 'p-3.5 rounded-2xl border transition-all text-xs space-y-1.5 bg-sky-50 border-sky-300 text-sky-950 shadow-xs';
            label.textContent = 'Status: Pengeluaran Pas (Sesuai Plafon)';
            label.className = 'font-black text-sky-800';
            badge.textContent = 'Rp 0 (Nihil)';
            badge.className = 'font-black font-mono text-base text-sky-700';
            explanation.innerHTML = 'Total pengeluaran riil sama persis dengan uang muka kasbon yang diterima. Tidak ada pengembalian maupun pembayaran kompensasi tambahan.';
        }
    }

    // Modal Pencairan Dana (BKK)
    function openPayModal(id, docNo, employee, amount, title, type) {
        const form = document.getElementById('payDisbursementForm');
        form.action = `/admin/reimbursements/${id}/status`;
        document.getElementById('modalPayDocNo').textContent = docNo;
        document.getElementById('modalPayEmployee').textContent = employee;
        document.getElementById('modalPayTitle').textContent = title;
        document.getElementById('modalPayType').textContent = type === 'cash_advance' ? 'Kasbon Dinas (Uang Muka)' : 'Klaim Reimbursement';
        document.getElementById('modalPayAmount').value = amount;
        document.getElementById('payDisbursementModal').classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }

    function closePayModal() {
        document.getElementById('payDisbursementModal').classList.add('hidden');
    }

    // Modal Import CSV
    function closeImportModal() {
        document.getElementById('importCsvModal').classList.add('hidden');
    }

    // Modal WhatsApp Gateway
    function openWaModal(id, docNo, name, phone, title) {
        const form = document.getElementById('sendWaForm');
        form.action = `/admin/reimbursements/${id}/send-wa`;
        document.getElementById('modalWaDocNo').textContent = docNo;
        document.getElementById('modalWaName').textContent = name;
        document.getElementById('modalWaTitle').textContent = title;
        document.getElementById('modalWaPhone').value = phone || '';
        document.getElementById('modalWaNotes').value = '';
        document.getElementById('sendWaModal').classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }

    function closeWaModal() {
        document.getElementById('sendWaModal').classList.add('hidden');
    }

    // Modal 5: Viewer & Download Nota Fisik (Arsip Digital)
    let currentReceiptViewerItem = null;
    let currentReceiptViewerIndex = 0;

    function openReceiptViewerModal(id, docNo, employee, title, receipts) {
        currentReceiptViewerItem = { id, docNo, employee, title, receipts: receipts || [] };
        currentReceiptViewerIndex = 0;

        const modal = document.getElementById('receiptViewerModal');
        const subtitle = document.getElementById('rvDocSubtitle');
        const countBadge = document.getElementById('rvTotalCountBadge');

        if (subtitle) subtitle.textContent = `${docNo} • ${employee} • ${title}`;
        if (countBadge) countBadge.textContent = `${currentReceiptViewerItem.receipts.length} Nota Terlampir`;

        renderReceiptViewerList();
        selectReceiptViewerIndex(0);

        modal.classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }

    function closeReceiptViewerModal() {
        document.getElementById('receiptViewerModal').classList.add('hidden');
    }

    function renderReceiptViewerList() {
        const container = document.getElementById('rvReceiptList');
        if (!container) return;
        container.innerHTML = '';

        const receipts = currentReceiptViewerItem?.receipts || [];
        if (receipts.length === 0) {
            container.innerHTML = '<p class="text-xs text-slate-400 italic p-2">Tidak ada berkas nota terlampir.</p>';
            return;
        }

        receipts.forEach((rc, idx) => {
            const itemBtn = document.createElement('button');
            itemBtn.type = 'button';
            itemBtn.className = `w-full text-left p-2.5 rounded-xl border text-xs transition cursor-pointer flex flex-col gap-1 ${
                idx === currentReceiptViewerIndex 
                    ? 'bg-white border-japan-500 shadow-sm ring-1 ring-japan-300' 
                    : 'bg-white/60 hover:bg-white border-slate-200'
            }`;
            itemBtn.onclick = () => selectReceiptViewerIndex(idx);

            const amountFormatted = rc.amount ? ('Rp ' + Number(rc.amount).toLocaleString('id-ID')) : '';
            itemBtn.innerHTML = `
                <div class="flex items-center justify-between">
                    <span class="font-black text-slate-800 truncate">${rc.title || 'Nota ' + (idx + 1)}</span>
                    ${amountFormatted ? `<span class="font-bold text-japan-600 font-mono text-[11px]">${amountFormatted}</span>` : ''}
                </div>
                <div class="flex items-center justify-between text-[10px] text-slate-400">
                    <span class="truncate">${rc.file_name || 'Lampiran'}</span>
                    <span>${rc.file_size || ''}</span>
                </div>
            `;
            container.appendChild(itemBtn);
        });
    }

    function selectReceiptViewerIndex(idx) {
        currentReceiptViewerIndex = idx;
        renderReceiptViewerList();

        const rc = currentReceiptViewerItem?.receipts[idx];
        if (!rc) return;

        const canvas = document.getElementById('rvPreviewCanvas');
        const nameEl = document.getElementById('rvCurrentFileName');
        const sizeEl = document.getElementById('rvCurrentFileSize');
        const archiveBtnText = document.getElementById('rvArchiveBtnText');
        const archiveBtn = document.getElementById('rvArchiveBtn');

        if (nameEl) nameEl.textContent = rc.title || rc.file_name || 'Nota ' + (idx + 1);
        if (sizeEl) sizeEl.textContent = rc.file_size || 'Base64';

        if (archiveBtnText) archiveBtnText.textContent = 'Taruh di Arsip Digital';
        if (archiveBtn) {
            archiveBtn.className = 'px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer';
            archiveBtn.disabled = false;
            archiveBtn.onclick = archiveCurrentReceiptToDigital;
        }

        if (canvas) {
            canvas.innerHTML = '';
            const base64 = rc.base64_image || '';
            if (base64.startsWith('data:application/pdf')) {
                canvas.innerHTML = `<iframe src="${base64}" class="w-full h-96 rounded-2xl border border-slate-300 shadow-md bg-white"></iframe>`;
            } else if (base64) {
                canvas.innerHTML = `<img src="${base64}" alt="${rc.title || 'Nota'}" class="max-h-[50vh] md:max-h-[55vh] max-w-full object-contain rounded-2xl shadow-xl border border-slate-200 bg-white">`;
            } else {
                canvas.innerHTML = '<div class="text-center p-8 text-slate-400 text-xs font-semibold">Berkas nota fisik tidak dapat dimuat atau telah dihapus.</div>';
            }
        }
    }

    function downloadCurrentReceipt() {
        const rc = currentReceiptViewerItem?.receipts[currentReceiptViewerIndex];
        if (!rc || !rc.base64_image) {
            alert('Berkas nota fisik tidak tersedia untuk diunduh.');
            return;
        }

        const docNoClean = (currentReceiptViewerItem.docNo || 'DOC').replace(/[^a-zA-Z0-9_-]/g, '-');
        const titleClean = (rc.title || 'Nota').replace(/[^a-zA-Z0-9_-]/g, '_');
        const ext = rc.file_type && rc.file_type.includes('pdf') ? 'pdf' : 'jpg';
        const filename = `${docNoClean}_${titleClean}.${ext}`;

        downloadBase64File(rc.base64_image, filename);
    }

    function openCurrentReceiptInNewTab() {
        const rc = currentReceiptViewerItem?.receipts[currentReceiptViewerIndex];
        if (!rc || !rc.base64_image) return;

        if (rc.base64_image.startsWith('data:image/')) {
            const w = window.open('');
            w.document.write(`
                <html>
                    <head><title>${rc.title || 'Nota Fisik'}</title></head>
                    <body style="margin:0;display:flex;justify-content:center;align-items:center;background:#0f172a;min-height:100vh;">
                        <img src="${rc.base64_image}" style="max-width:95vw;max-height:95vh;object-fit:contain;border-radius:12px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);">
                    </body>
                </html>
            `);
        } else {
            const w = window.open('');
            w.location.href = rc.base64_image;
        }
    }

    async function archiveCurrentReceiptToDigital() {
        const rc = currentReceiptViewerItem?.receipts[currentReceiptViewerIndex];
        if (!rc || !rc.base64_image) return;

        const btn = document.getElementById('rvArchiveBtn');
        const btnText = document.getElementById('rvArchiveBtnText');
        if (btn) btn.disabled = true;
        if (btnText) btnText.textContent = 'Menyimpan...';

        try {
            const payload = {
                title: `Bukti [${currentReceiptViewerItem.docNo}] - ${rc.title || 'Nota ' + (currentReceiptViewerIndex + 1)}`,
                file_base64: rc.base64_image,
                file_name: rc.file_name || `Nota_${currentReceiptViewerItem.docNo}_${currentReceiptViewerIndex + 1}.jpg`,
                category: 'nota_reimburse',
                folder_name: 'Nota & Kuitansi Reimburse',
                reimbursement_id: currentReceiptViewerItem.id,
                uploader_name: currentReceiptViewerItem.employee,
                notes: `Lampiran nota: ${currentReceiptViewerItem.title}`,
            };

            const res = await fetch('{{ route("admin.digital-archives.archive.receipt") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json();
            if (data.success) {
                if (btn) btn.className = 'px-3.5 py-2 rounded-xl bg-teal-600 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer';
                if (btnText) btnText.textContent = '✓ Tersimpan di Arsip (Buka)';
                if (btn) {
                    btn.disabled = false;
                    btn.onclick = () => window.open(data.archive_url, '_blank');
                }
            } else {
                alert(data.message || 'Gagal menyimpan berkas ke arsip digital.');
                if (btnText) btnText.textContent = 'Taruh di Arsip Digital';
                if (btn) btn.disabled = false;
            }
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan saat mengarsipkan berkas.');
            if (btnText) btnText.textContent = 'Taruh di Arsip Digital';
            if (btn) btn.disabled = false;
        }
    }

    // Universal Base64 Blob Downloader
    function downloadBase64File(base64Data, filename) {
        try {
            if (!base64Data.startsWith('data:')) {
                base64Data = 'data:image/jpeg;base64,' + base64Data;
            }
            const parts = base64Data.split(';base64,');
            const contentType = parts[0].replace('data:', '') || 'application/octet-stream';
            const byteCharacters = atob(parts[1]);
            const byteNumbers = new Array(byteCharacters.length);
            for (let i = 0; i < byteCharacters.length; i++) {
                byteNumbers[i] = byteCharacters.charCodeAt(i);
            }
            const byteArray = new Uint8Array(byteNumbers);
            const blob = new Blob([byteArray], { type: contentType });
            const blobUrl = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = blobUrl;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            setTimeout(() => URL.revokeObjectURL(blobUrl), 1000);
        } catch (err) {
            console.error('Blob download error, fallback to direct download:', err);
            const a = document.createElement('a');
            a.href = base64Data;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    }

    // Auto-Sync Mini Dashboard Realtime via AJAX
    async function syncReimbursementStats() {
        const refreshIcon = document.getElementById('rmbRefreshIcon');
        const syncNotice = document.getElementById('rmbLastSyncNotice');
        if (refreshIcon) refreshIcon.classList.add('animate-spin');

        try {
            const res = await fetch('{{ route("admin.reimbursements.stats") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const data = await res.json();
            if (data.success && data.stats) {
                const s = data.stats;
                const elReimbursed = document.getElementById('rmbStatReimbursed');
                const elAdvances = document.getElementById('rmbStatAdvances');
                const elPending = document.getElementById('rmbStatPending');
                const elUnsettled = document.getElementById('rmbStatUnsettled');

                if (elReimbursed) elReimbursed.textContent = s.total_reimbursed_formatted;
                if (elAdvances) elAdvances.textContent = s.active_advances_formatted;
                if (elPending) elPending.textContent = Number(s.pending_count).toLocaleString('id-ID') + ' Berkas';
                if (elUnsettled) elUnsettled.textContent = Number(s.unsettled_advances_count).toLocaleString('id-ID') + ' Dinas';

                if (syncNotice) {
                    const now = new Date();
                    syncNotice.textContent = 'Sinkron ' + now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                }
            }
        } catch (err) {
            console.warn('[Reimbursement Auto-Sync]', err);
        } finally {
            if (refreshIcon) {
                setTimeout(() => refreshIcon.classList.remove('animate-spin'), 600);
            }
        }
    }

    // Interval Auto-Sync setiap 20 detik
    setInterval(syncReimbursementStats, 20000);
</script>
@endsection
