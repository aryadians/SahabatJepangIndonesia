@extends('admin.layouts.admin')

@section('title', 'Executive Financial & Cashflow Forecasting')
@section('page_title', 'Eksekutif Dashboard Keuangan & Proyeksi Arus Kas')

@section('content')
<div class="space-y-8">
    
    <!-- Top Executive KPI Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Pendapatan Masuk -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-bold uppercase tracking-wider">Kas Masuk (Realized)</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="text-2xl font-black text-emerald-600">Rp {{ number_format($totalRealizedRevenue) }}</h3>
            <p class="text-[11px] text-slate-400 font-medium">Dari total omset Rp {{ number_format($totalPotentialRevenue) }}</p>
        </div>

        <!-- Total Piutang Siswa -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-bold uppercase tracking-wider">Piutang (Receivables)</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 text-japan-600 flex items-center justify-center">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="text-2xl font-black text-japan-600">Rp {{ number_format($totalReceivables) }}</h3>
            <p class="text-[11px] text-rose-500 font-bold">Tanggungan cicilan yang belum lunas</p>
        </div>

        <!-- Rasio Kolektibilitas Kas -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-bold uppercase tracking-wider">Rasio Pelunasan</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="pie-chart" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="text-2xl font-black text-blue-600">{{ $collectionRate }}%</h3>
            
            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $collectionRate }}%"></div>
            </div>
        </div>

        <!-- Siswa Status Pelunasan -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-bold uppercase tracking-wider">Status Pelunasan</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i data-lucide="users" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="flex items-center gap-2 pt-1">
                <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-xs font-black">{{ $statusCounts['lunas'] }} Lunas</span>
                <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800 text-xs font-black">{{ $statusCounts['sebagian'] }} Cicil</span>
                <span class="px-2 py-0.5 rounded bg-rose-100 text-rose-800 text-xs font-black">{{ $statusCounts['belum'] }} Belum</span>
            </div>
            <p class="text-[10px] text-slate-400">Total data siswa terdaftar</p>
        </div>

    <!-- Centralized Cashflow Comparison (Inflow Siswa vs Outflow Reimburse & Kasbon) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-japan-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="scale" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base sm:text-lg">Pusat Rekapitulasi & Grafik Arus Kas Komparatif</h3>
                    <p class="text-xs text-slate-400">Perbandingan realisasi kas masuk pendaftaran siswa vs pengeluaran operasional (reimburse & kasbon dinas)</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200 flex items-center gap-1.5">
                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-500"></i>
                    <span>Tahun Kalender {{ now()->year }}</span>
                </span>
                <a 
                    href="{{ route('admin.reimbursements.index') }}" 
                    class="px-3 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition flex items-center gap-1.5"
                >
                    <i data-lucide="receipt" class="w-3.5 h-3.5 text-red-400"></i>
                    <span>Buka Reimburse</span>
                </a>
            </div>
        </div>

        <!-- 4 Comparative Cash Flow Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- 1. Total Inflow -->
            <div class="p-5 rounded-2xl bg-emerald-50/60 border border-emerald-200/80 space-y-2">
                <div class="flex items-center justify-between text-emerald-800">
                    <span class="text-[11px] font-black uppercase tracking-wider">Total Kas Masuk (Inflow)</span>
                    <i data-lucide="arrow-down-left" class="w-4 h-4"></i>
                </div>
                <h4 class="text-xl sm:text-2xl font-black text-emerald-700">Rp {{ number_format($totalRealizedRevenue) }}</h4>
                <p class="text-[11px] text-emerald-800 font-medium">Realisasi pendaftaran & cicilan siswa</p>
            </div>

            <!-- 2. Total Outflow -->
            <div class="p-5 rounded-2xl bg-rose-50/60 border border-rose-200/80 space-y-2">
                <div class="flex items-center justify-between text-rose-800">
                    <span class="text-[11px] font-black uppercase tracking-wider">Total Pengeluaran (Outflow)</span>
                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                </div>
                <h4 class="text-xl sm:text-2xl font-black text-rose-700">Rp {{ number_format($totalOutflow) }}</h4>
                <div class="text-[11px] text-rose-800 flex items-center justify-between font-semibold">
                    <span>Reimburse: Rp {{ number_format($totalReimbursements) }}</span>
                    <span>Kasbon: Rp {{ number_format($totalCashAdvances) }}</span>
                </div>
            </div>

            <!-- 3. Net Cash Flow -->
            <div class="p-5 rounded-2xl {{ $netCashflow >= 0 ? 'bg-blue-50/60 border-blue-200/80 text-blue-900' : 'bg-red-50/60 border-red-200/80 text-red-900' }} border space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-black uppercase tracking-wider">Arus Kas Bersih (Net)</span>
                    <span class="px-2 py-0.5 rounded-md {{ $netCashflow >= 0 ? 'bg-blue-200/70 text-blue-900' : 'bg-red-200/70 text-red-900' }} text-[10px] font-black uppercase">
                        {{ $netCashflow >= 0 ? 'Surplus Kas' : 'Defisit Kas' }}
                    </span>
                </div>
                <h4 class="text-xl sm:text-2xl font-black {{ $netCashflow >= 0 ? 'text-blue-800' : 'text-rose-700' }}">
                    {{ $netCashflow >= 0 ? '+' : '' }}Rp {{ number_format($netCashflow) }}
                </h4>
                <p class="text-[11px] font-medium opacity-80">Saldo operasional tersisa setelah klaim dinas</p>
            </div>

            <!-- 4. Expense Ratio -->
            <div class="p-5 rounded-2xl bg-purple-50/60 border border-purple-200/80 space-y-2">
                <div class="flex items-center justify-between text-purple-800">
                    <span class="text-[11px] font-black uppercase tracking-wider">Beban Pengeluaran</span>
                    <i data-lucide="percent" class="w-4 h-4"></i>
                </div>
                <h4 class="text-xl sm:text-2xl font-black text-purple-700">{{ $expenseRatio }}%</h4>
                <div class="w-full bg-purple-200/60 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-purple-600 h-full rounded-full" style="width: {{ min(100, $expenseRatio) }}%"></div>
                </div>
                <p class="text-[10px] text-purple-800 font-medium">Persentase kas keluar terhadap penerimaan</p>
            </div>
        </div>

        <!-- Monthly Comparative Visual Bars & Summary Table -->
        <div class="pt-4 border-t border-slate-100 space-y-4">
            <div class="flex items-center justify-between flex-wrap gap-2">
                <h4 class="text-xs font-black uppercase tracking-wider text-slate-700 flex items-center gap-2">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 text-japan-600"></i>
                    <span>Grafik Komparasi Bulanan (Inflow vs Outflow {{ now()->year }})</span>
                </h4>
                <div class="flex items-center gap-4 text-xs font-bold">
                    <span class="flex items-center gap-1.5 text-emerald-700"><span class="w-3 h-3 rounded-sm bg-emerald-500 inline-block"></span> Kas Masuk Siswa</span>
                    <span class="flex items-center gap-1.5 text-rose-700"><span class="w-3 h-3 rounded-sm bg-rose-500 inline-block"></span> Pengeluaran Operasional</span>
                </div>
            </div>

            <!-- Visual Bar Grid -->
            @php
                $maxVal = 1;
                foreach($monthlyComparison as $m) {
                    $maxVal = max($maxVal, $m['inflow'], $m['outflow']);
                }
            @endphp
            <div class="grid grid-cols-6 sm:grid-cols-12 gap-2 pt-2 items-end h-48 bg-slate-50/70 p-4 rounded-2xl border border-slate-200/70">
                @foreach($monthlyComparison as $m)
                    @php
                        $inflowHeight = round(($m['inflow'] / $maxVal) * 100);
                        $outflowHeight = round(($m['outflow'] / $maxVal) * 100);
                    @endphp
                    <div class="flex flex-col items-center h-full justify-end group relative">
                        <!-- Tooltip -->
                        <div class="absolute -top-12 z-20 hidden group-hover:flex flex-col items-center bg-slate-900 text-white text-[10px] p-2 rounded-xl shadow-lg whitespace-nowrap pointer-events-none">
                            <span class="font-bold">{{ $m['month_name'] }}:</span>
                            <span class="text-emerald-300">In: Rp {{ number_format($m['inflow']) }}</span>
                            <span class="text-rose-300">Out: Rp {{ number_format($m['outflow']) }}</span>
                        </div>
                        <div class="flex items-end gap-1 w-full justify-center h-32">
                            <!-- Inflow Bar -->
                            <div class="w-2.5 sm:w-3.5 bg-emerald-500 rounded-t-md hover:bg-emerald-600 transition" style="height: {{ max(4, $inflowHeight) }}%" title="Inflow: Rp {{ number_format($m['inflow']) }}"></div>
                            <!-- Outflow Bar -->
                            <div class="w-2.5 sm:w-3.5 bg-rose-500 rounded-t-md hover:bg-rose-600 transition" style="height: {{ max(4, $outflowHeight) }}%" title="Outflow: Rp {{ number_format($m['outflow']) }}"></div>
                        </div>
                        <span class="text-[10px] font-bold text-slate-600 mt-2">{{ $m['month_name'] }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Collapsible Monthly Table -->
            <div class="overflow-x-auto rounded-2xl border border-slate-200">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-[10px] uppercase font-black">
                            <th class="py-2.5 px-3">Bulan</th>
                            <th class="py-2.5 px-3 text-right">Kas Masuk Siswa</th>
                            <th class="py-2.5 px-3 text-right">Reimburse Cair</th>
                            <th class="py-2.5 px-3 text-right">Kasbon Dinas</th>
                            <th class="py-2.5 px-3 text-right">Total Kas Keluar</th>
                            <th class="py-2.5 px-3 text-right">Net Cashflow</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-mono text-[11px]">
                        @foreach($monthlyComparison as $m)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-2 px-3 font-sans font-bold text-slate-800">{{ $m['month_name'] }} {{ now()->year }}</td>
                                <td class="py-2 px-3 text-right font-bold text-emerald-600">Rp {{ number_format($m['inflow']) }}</td>
                                <td class="py-2 px-3 text-right text-slate-600">Rp {{ number_format($m['outflow_reimburse']) }}</td>
                                <td class="py-2 px-3 text-right text-slate-600">Rp {{ number_format($m['outflow_advance']) }}</td>
                                <td class="py-2 px-3 text-right font-bold text-rose-600">Rp {{ number_format($m['outflow']) }}</td>
                                <td class="py-2 px-3 text-right font-black {{ $m['net'] >= 0 ? 'text-blue-600' : 'text-rose-600' }}">
                                    {{ $m['net'] >= 0 ? '+' : '' }}Rp {{ number_format($m['net']) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Cashflow Inflow Forecasting (30, 60, 90 Days) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Proyeksi Penerimaan Kas Masuk (Cash Inflow Forecast)</h3>
                    <p class="text-xs text-slate-400">Estimasi pencairan dana dari termin cicilan dan jadwal terbang siswa ke Jepang</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a 
                    href="{{ route('admin.finance.export.pdf') }}" 
                    target="_blank"
                    class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition shadow-xs flex items-center gap-1.5"
                    title="Cetak Laporan Eksekutif Keuangan & Proyeksi Arus Kas ke PDF"
                >
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    <span>Export PDF Keuangan</span>
                </a>
                <span class="px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100 hidden sm:inline-block">
                    Otomatis Berbasis Jadwal
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            
            <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50/50 border border-blue-100 space-y-2">
                <div class="flex items-center justify-between text-blue-700">
                    <span class="text-xs font-black uppercase">Proyeksi 30 Hari</span>
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div>
                <h4 class="text-2xl font-black text-slate-900">Rp {{ number_format($forecast30Days) }}</h4>
                <p class="text-[11px] text-slate-500">Estimasi pelunasan termin 1 dari siswa kelas pelatihan aktif.</p>
            </div>

            <div class="p-6 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50/50 border border-emerald-100 space-y-2">
                <div class="flex items-center justify-between text-emerald-700">
                    <span class="text-xs font-black uppercase">Proyeksi 60 Hari</span>
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div>
                <h4 class="text-2xl font-black text-slate-900">Rp {{ number_format($forecast60Days) }}</h4>
                <p class="text-[11px] text-slate-500">Estimasi pelunasan termin 2 & seleksi wawancara Kaisha.</p>
            </div>

            <div class="p-6 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-50/50 border border-amber-100 space-y-2">
                <div class="flex items-center justify-between text-amber-700">
                    <span class="text-xs font-black uppercase">Proyeksi 90 Hari</span>
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div>
                <h4 class="text-2xl font-black text-slate-900">Rp {{ number_format($forecast90Days) }}</h4>
                <p class="text-[11px] text-slate-500">Pelunasan penuh saat COE / Visa terbit menjelang terbang.</p>
            </div>

        </div>
    </div>

    <!-- Program Revenue Matrix Breakdown -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Komposisi Pendapatan per Program Karir</h3>
                <p class="text-xs text-slate-400">Analisis kinerja pendapatan berdasarkan jenis program pelatihan</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3.5 px-4">Program Karir</th>
                        <th class="py-3.5 px-4 text-center">Jumlah Siswa</th>
                        <th class="py-3.5 px-4">Potensi Omset</th>
                        <th class="py-3.5 px-4">Sudah Masuk (Kas)</th>
                        <th class="py-3.5 px-4">Sisa Piutang</th>
                        <th class="py-3.5 px-4 text-center">Progress Pelunasan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($programRevenue as $pr)
                        @php
                            $rate = $pr->total_potential > 0 ? round(($pr->total_collected / $pr->total_potential) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $pr->program }}
                            </td>
                            <td class="py-3.5 px-4 text-center font-extrabold text-blue-600">
                                {{ $pr->student_count }} Siswa
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-700">
                                Rp {{ number_format($pr->total_potential) }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-emerald-600">
                                Rp {{ number_format($pr->total_collected) }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-japan-600">
                                Rp {{ number_format($pr->total_outstanding) }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-20 bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $rate }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700">{{ $rate }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">Belum ada data keuangan program.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Outstanding Receivables Table (Daftar Siswa dengan Sisa Tanggungan Biaya) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Daftar Tanggungan Biaya Siswa (Aging Receivables)</h3>
                <p class="text-xs text-slate-400">Daftar siswa yang belum melunasi biaya dengan aksi pengingat WhatsApp</p>
            </div>
            <a href="{{ route('admin.students.export') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5">
                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                <span>Export Laporan CSV</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3.5 px-4">Nama Siswa</th>
                        <th class="py-3.5 px-4">Program</th>
                        <th class="py-3.5 px-4">Total Biaya</th>
                        <th class="py-3.5 px-4">Sudah Bayar</th>
                        <th class="py-3.5 px-4">Sisa Tanggungan</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi Follow-up</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($outstandingStudents as $s)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $s->name }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">NIS: {{ $s->nis }} • {{ $s->phone }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-semibold">{{ $s->program }}</td>
                            <td class="py-3.5 px-4 text-slate-600 font-mono">Rp {{ number_format($s->total_cost) }}</td>
                            <td class="py-3.5 px-4 text-emerald-600 font-bold font-mono">Rp {{ number_format($s->paid_amount) }}</td>
                            <td class="py-3.5 px-4 text-japan-600 font-black font-mono">Rp {{ number_format($s->remaining_balance) }}</td>
                            <td class="py-3.5 px-4">
                                @if(in_array($s->payment_status, ['partial', 'sebagian']))
                                    <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 font-black text-[10px]">Cicilan</span>
                                @elseif(in_array($s->payment_status, ['paid', 'lunas']))
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px]">Lunas</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800 font-black text-[10px]">Belum Bayar</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @php
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $s->phone);
                                    if (str_starts_with($cleanPhone, '0')) $cleanPhone = '62' . substr($cleanPhone, 1);
                                    $msg = "Halo Kak {$s->name} (NIS: {$s->nis}), kami informasikan sisa tanggungan biaya program {$s->program} sebesar Rp " . number_format($s->remaining_balance) . ". Harap melakukan konfirmasi pembayaran ya Kak. Terima kasih!";
                                @endphp
                                <a 
                                    href="https://api.whatsapp.com/send?phone={{ $cleanPhone }}&text={{ urlencode($msg) }}" 
                                    target="_blank" 
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-xs transition"
                                    title="Kirim Pengingat WhatsApp"
                                >
                                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                    <span>Ingatkan WA</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-xs">Semua biaya siswa telah lunas!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($outstandingStudents->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $outstandingStudents->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
