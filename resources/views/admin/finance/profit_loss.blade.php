@extends('admin.layouts.admin')

@section('title', 'Laporan Eksekutif Laba Rugi (P&L Statement)')
@section('page_title', 'Laporan Eksekutif Laba Rugi LPK (損益計算書)')

@section('content')
<div class="space-y-8">

    <!-- Top Period & Actions Filter Bar -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-japan-600 to-japan-800 text-white flex items-center justify-center shadow-md shadow-japan-900/10">
                    <i data-lucide="calculator" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg font-black text-slate-900">Executive Profit & Loss Statement</h2>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-japan-100 text-japan-800 border border-japan-200">
                            {{ $periodKanji }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Ringkasan performa finansial, marjin laba kotor, beban operasional, dan laba bersih resmi LPK Sahabat Jepang Indonesia.
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <a 
                    href="{{ route('admin.finance.pl.export', request()->query()) }}" 
                    target="_blank"
                    class="px-4 py-2.5 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-bold transition flex items-center gap-2 shadow-sm shadow-japan-900/10"
                >
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    <span>Cetak Dokumen Resmi A4 (PDF)</span>
                </a>
                <a 
                    href="{{ route('admin.finance.index') }}" 
                    class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-2 border border-slate-200"
                >
                    <i data-lucide="trending-up" class="w-4 h-4 text-slate-500"></i>
                    <span>Proyeksi Kas</span>
                </a>
                <a 
                    href="{{ route('admin.cash-book.index') }}" 
                    class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-2 border border-slate-200"
                >
                    <i data-lucide="book-open" class="w-4 h-4 text-emerald-600"></i>
                    <span>Buku Kas Umum</span>
                </a>
            </div>
        </div>

        <!-- Period Selector Controls -->
        <form method="GET" action="{{ route('admin.finance.pl') }}" class="space-y-3" id="periodForm">
            <div class="flex flex-wrap items-center gap-3">
                <!-- Year Picker -->
                <div class="flex items-center gap-2">
                    <label for="yearSelect" class="text-xs font-extrabold text-slate-500 uppercase tracking-wider">Tahun Buku:</label>
                    <select 
                        id="yearSelect" 
                        name="year" 
                        onchange="document.getElementById('periodForm').submit()" 
                        class="px-3 py-1.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-japan-500 focus:border-japan-500 bg-slate-50"
                    >
                        @foreach($availableYears as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="h-4 w-px bg-slate-200 hidden sm:block"></div>

                <!-- Quarter Pills -->
                <div class="flex items-center gap-1.5">
                    <span class="text-[11px] font-bold text-slate-400 mr-1 hidden sm:inline">Kuartal:</span>
                    <a 
                        href="{{ route('admin.finance.pl', ['year' => $year]) }}" 
                        class="px-3 py-1 rounded-lg text-xs font-bold transition {{ (empty($quarter) && empty($month)) ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        Semua (1 Tahun)
                    </a>
                    @foreach(['Q1' => 'Q1 (Jan-Mar)', 'Q2' => 'Q2 (Apr-Jun)', 'Q3' => 'Q3 (Jul-Sep)', 'Q4' => 'Q4 (Okt-Des)'] as $qKey => $qLabel)
                        <a 
                            href="{{ route('admin.finance.pl', ['year' => $year, 'quarter' => $qKey]) }}" 
                            class="px-2.5 py-1 rounded-lg text-xs font-bold transition {{ ($quarter === $qKey && empty($month)) ? 'bg-japan-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                        >
                            {{ $qKey }}
                        </a>
                    @endforeach
                </div>

                <div class="h-4 w-px bg-slate-200 hidden md:block"></div>

                <!-- Current Active Period Badge -->
                <div class="ml-auto text-xs font-bold text-slate-600 flex items-center gap-1.5 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200">
                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-japan-600"></i>
                    <span>Rentang: <strong>{{ $startDate->translatedFormat('d M Y') }}</strong> s/d <strong>{{ $endDate->translatedFormat('d M Y') }}</strong></span>
                </div>
            </div>

            <!-- Month Quick Filter Bar -->
            <div class="flex items-center gap-1 overflow-x-auto pb-1 text-xs">
                <span class="text-[11px] font-bold text-slate-400 mr-1 flex-shrink-0">Bulan:</span>
                @php
                    $monthNames = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];
                @endphp
                @foreach($monthNames as $mNum => $mLabel)
                    <a 
                        href="{{ route('admin.finance.pl', ['year' => $year, 'month' => $mNum]) }}" 
                        class="px-2.5 py-1 rounded-lg font-bold transition flex-shrink-0 {{ ($month == $mNum) ? 'bg-japan-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        {{ $mLabel }}
                    </a>
                @endforeach
                @if(!empty($month) || !empty($quarter))
                    <a 
                        href="{{ route('admin.finance.pl', ['year' => $year]) }}" 
                        class="px-2 py-1 rounded-lg text-rose-600 hover:bg-rose-50 font-bold transition flex items-center gap-1 ml-2 flex-shrink-0 text-[11px]"
                        title="Reset filter bulan/kuartal"
                    >
                        <i data-lucide="x" class="w-3 h-3"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- 4 High-Impact KPI Financial Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- 1. Pendapatan Bruto (Gross Revenue) -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-3 relative overflow-hidden group hover:border-emerald-300 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black uppercase tracking-wider text-slate-400">Total Pendapatan (売上高)</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i data-lucide="arrow-down-left" class="w-4 h-4"></i>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-emerald-600 font-mono tracking-tight">
                    Rp {{ number_format($grossRevenue, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-slate-400 font-medium mt-0.5">Total kas masuk periode ini</p>
            </div>
            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-500 font-bold">{{ count($incomeItems) }} Pos Penerimaan Aktif</span>
                <span class="text-emerald-700 font-black">100% Bruto</span>
            </div>
        </div>

        <!-- 2. Beban Pokok Pendidikan (HPP / COGS) -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-3 relative overflow-hidden group hover:border-teal-300 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black uppercase tracking-wider text-slate-400">HPP Pendidikan (売上原価)</span>
                <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold">
                    <i data-lucide="book-open" class="w-4 h-4"></i>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-teal-700 font-mono tracking-tight">
                    Rp {{ number_format($totalCogs, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-slate-400 font-medium mt-0.5">Biaya modul, seragam & sertifikasi</p>
            </div>
            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-500 font-bold">Laba Kotor:</span>
                <span class="text-teal-800 font-black font-mono">Rp {{ number_format($grossProfit, 0, ',', '.') }} ({{ $grossMargin }}%)</span>
            </div>
        </div>

        <!-- 3. Beban Operasional Usaha (OPEX) -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-3 relative overflow-hidden group hover:border-rose-300 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black uppercase tracking-wider text-slate-400">Beban OPEX (販売管理費)</span>
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-rose-700 font-mono tracking-tight">
                    Rp {{ number_format($totalOpex, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-slate-400 font-medium mt-0.5">Gaji sensei, sewa, utilitas, iklan, reimburse</p>
            </div>
            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-500 font-bold">Rasio Beban:</span>
                <span class="text-rose-700 font-black">{{ $expenseRatio }}% dari Omset</span>
            </div>
        </div>

        <!-- 4. Laba / (Rugi) Bersih Operasional (Net Profit) -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-3 relative overflow-hidden group hover:border-blue-300 transition {{ $netProfit >= 0 ? 'bg-gradient-to-b from-white to-blue-50/20' : 'bg-gradient-to-b from-white to-rose-50/20' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black uppercase tracking-wider {{ $netProfit >= 0 ? 'text-blue-900' : 'text-rose-900' }}">
                    Laba Bersih (当期純利益)
                </span>
                <div class="w-9 h-9 rounded-xl {{ $netProfit >= 0 ? 'bg-blue-50 text-blue-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center font-bold">
                    <i data-lucide="{{ $netProfit >= 0 ? 'trending-up' : 'trending-down' }}" class="w-4 h-4"></i>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black {{ $netProfit >= 0 ? 'text-blue-700' : 'text-rose-700' }} font-mono tracking-tight">
                    {{ $netProfit >= 0 ? '+' : '' }}Rp {{ number_format($netProfit, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] font-medium mt-0.5 {{ $netProfit >= 0 ? 'text-blue-600' : 'text-rose-500' }}">
                    {{ $netProfit >= 0 ? 'Surplus operasional bersih' : 'Defisit operasional periode ini' }}
                </p>
            </div>
            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-500 font-bold">Net Profit Margin:</span>
                <span class="font-black {{ $netProfit >= 0 ? 'text-blue-700' : 'text-rose-700' }}">{{ $netMargin }}%</span>
            </div>
        </div>
    </div>

    <!-- Formal Financial Table: Laporan Laba Rugi Berjenjang (Multi-Step Income Statement) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="text-base sm:text-lg font-black text-slate-900">
                        Struktur Laporan Laba Rugi Berjenjang (Multi-Step Statement)
                    </h3>
                    <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase bg-slate-100 text-slate-700">
                        PSAK & J-GAAP Standard
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">
                    Rincian klasifikasi pos pendapatan kotor, beban langsung pendidikan, dan biaya umum operasional LPK.
                </p>
            </div>

            <div class="flex items-center gap-2 text-xs">
                <span class="text-slate-400">Periode:</span>
                <span class="px-3 py-1 rounded-xl bg-slate-100 text-slate-800 font-extrabold border border-slate-200">
                    {{ $periodLabel }}
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white uppercase text-[10px] font-black tracking-wider">
                        <th class="py-3 px-4 rounded-l-xl">No</th>
                        <th class="py-3 px-4">Klasifikasi Pos Finansial</th>
                        <th class="py-3 px-4 text-center">Kode Akun</th>
                        <th class="py-3 px-4 text-right">Rasio (%)</th>
                        <th class="py-3 px-4 text-right rounded-r-xl">Nominal (IDR)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    
                    <!-- BAGIAN I: PENDAPATAN OPERASIONAL -->
                    <tr class="bg-emerald-50/70 border-t-2 border-emerald-500 font-black text-emerald-950">
                        <td colspan="4" class="py-2.5 px-4 uppercase tracking-wider text-[11px]">
                            I. PENDAPATAN OPERASIONAL & PENDIDIKAN (REVENUES / 売上高)
                        </td>
                        <td class="py-2.5 px-4 text-right font-mono text-sm text-emerald-800">
                            Rp {{ number_format($grossRevenue, 0, ',', '.') }}
                        </td>
                    </tr>
                    @forelse($incomeItems as $idx => $item)
                        @php
                            $pct = $grossRevenue > 0 ? round(($item['amount'] / $grossRevenue) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-2.5 px-4 text-slate-400 font-mono pl-6">{{ $idx + 1 }}</td>
                            <td class="py-2.5 px-4 font-bold text-slate-800 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>{{ $item['label'] }}</span>
                            </td>
                            <td class="py-2.5 px-4 text-center font-mono text-[11px] text-slate-500 uppercase">{{ $item['key'] }}</td>
                            <td class="py-2.5 px-4 text-right font-mono text-slate-600">{{ $pct }}%</td>
                            <td class="py-2.5 px-4 text-right font-mono font-bold text-emerald-700">
                                Rp {{ number_format($item['amount'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-slate-400 italic">Belum ada transaksi pendapatan pada periode terpilih.</td>
                        </tr>
                    @endforelse

                    <!-- BAGIAN II: BEBAN POKOK PENDIDIKAN (HPP / COGS) -->
                    <tr class="bg-teal-50/70 border-t-2 border-teal-500 font-black text-teal-950">
                        <td colspan="4" class="py-2.5 px-4 uppercase tracking-wider text-[11px]">
                            II. BEBAN POKOK PENDIDIKAN / HPP (COST OF GOODS SOLD / 売上原価)
                        </td>
                        <td class="py-2.5 px-4 text-right font-mono text-sm text-teal-800">
                            Rp {{ number_format($totalCogs, 0, ',', '.') }}
                        </td>
                    </tr>
                    @forelse($cogsItems as $idx => $item)
                        @php
                            $pct = $grossRevenue > 0 ? round(($item['amount'] / $grossRevenue) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-2.5 px-4 text-slate-400 font-mono pl-6">{{ $idx + 1 }}</td>
                            <td class="py-2.5 px-4 font-bold text-slate-800 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                                <span>{{ $item['label'] }}</span>
                            </td>
                            <td class="py-2.5 px-4 text-center font-mono text-[11px] text-slate-500 uppercase">{{ $item['key'] }}</td>
                            <td class="py-2.5 px-4 text-right font-mono text-slate-600">{{ $pct }}%</td>
                            <td class="py-2.5 px-4 text-right font-mono font-bold text-teal-700">
                                Rp {{ number_format($item['amount'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-3 text-center text-slate-400 italic">Tidak ada alokasi langsung HPP perlengkapan pada periode ini.</td>
                        </tr>
                    @endforelse

                    <!-- HIGHLIGHT: LABA KOTOR (GROSS PROFIT) -->
                    <tr class="bg-slate-100 border-y-2 border-slate-300 font-black text-slate-900">
                        <td colspan="3" class="py-3 px-4 uppercase tracking-wider text-xs">
                            LABA KOTOR LEMBAGA (GROSS PROFIT / 売上総利益 = I - II)
                        </td>
                        <td class="py-3 px-4 text-right font-mono text-teal-800">{{ $grossMargin }}% Marjin</td>
                        <td class="py-3 px-4 text-right font-mono text-base text-teal-800">
                            Rp {{ number_format($grossProfit, 0, ',', '.') }}
                        </td>
                    </tr>

                    <!-- BAGIAN III: BEBAN OPERASIONAL & UMUM (OPEX) -->
                    <tr class="bg-rose-50/70 border-t-2 border-rose-500 font-black text-rose-950">
                        <td colspan="4" class="py-2.5 px-4 uppercase tracking-wider text-[11px]">
                            III. BEBAN USAHA & ADMINISTRASI UMUM (OPEX / 販売費及び一般管理費)
                        </td>
                        <td class="py-2.5 px-4 text-right font-mono text-sm text-rose-800">
                            Rp {{ number_format($totalOpex, 0, ',', '.') }}
                        </td>
                    </tr>
                    @forelse($opexItems as $idx => $item)
                        @php
                            $pct = $grossRevenue > 0 ? round(($item['amount'] / $grossRevenue) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-2.5 px-4 text-slate-400 font-mono pl-6">{{ $idx + 1 }}</td>
                            <td class="py-2.5 px-4 font-bold text-slate-800 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                <span>{{ $item['label'] }}</span>
                            </td>
                            <td class="py-2.5 px-4 text-center font-mono text-[11px] text-slate-500 uppercase">{{ $item['key'] }}</td>
                            <td class="py-2.5 px-4 text-right font-mono text-slate-600">{{ $pct }}%</td>
                            <td class="py-2.5 px-4 text-right font-mono font-bold text-rose-700">
                                Rp {{ number_format($item['amount'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-3 text-center text-slate-400 italic">Tidak ada beban operasional tercatat pada periode ini.</td>
                        </tr>
                    @endforelse

                    <!-- HIGHLIGHT: LABA OPERASIONAL / EBITDA -->
                    <tr class="bg-indigo-50/70 border-t-2 border-indigo-300 font-black text-indigo-950">
                        <td colspan="3" class="py-3 px-4 uppercase tracking-wider text-xs">
                            LABA OPERASIONAL USAHA / EBITDA (OPERATING INCOME / 営業利益)
                        </td>
                        <td class="py-3 px-4 text-right font-mono text-indigo-800">{{ $operatingMargin }}% Marjin</td>
                        <td class="py-3 px-4 text-right font-mono text-base text-indigo-800">
                            {{ $operatingProfit >= 0 ? '+' : '' }}Rp {{ number_format($operatingProfit, 0, ',', '.') }}
                        </td>
                    </tr>

                    <!-- FINAL: LABA BERSIH BERJALAN (NET INCOME) -->
                    <tr class="{{ $netProfit >= 0 ? 'bg-gradient-to-r from-blue-900 to-indigo-950 text-white' : 'bg-gradient-to-r from-red-900 to-rose-950 text-white' }} font-black">
                        <td colspan="3" class="py-4 px-4 uppercase tracking-widest text-xs rounded-l-xl">
                            IV. LABA / (RUGI) BERSIH TAHUN BERJALAN (NET PROFIT / 当期純利益)
                        </td>
                        <td class="py-4 px-4 text-right font-mono text-sm text-yellow-300">{{ $netMargin }}% Net</td>
                        <td class="py-4 px-4 text-right font-mono text-lg text-yellow-300 rounded-r-xl">
                            {{ $netProfit >= 0 ? '+' : '' }}Rp {{ number_format($netProfit, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Monthly Historical Velocity (12 Months Comparison for Year) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-base sm:text-lg font-black text-slate-900">
                    Tren Kinerja Bulanan Tahun Buku {{ $year }} (Cashflow & Profit Velocity)
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Historis arus kas masuk (penerimaan), arus kas keluar (beban), dan laba bersih per bulan.
                </p>
            </div>
            <div class="flex items-center gap-4 text-xs font-bold">
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded bg-emerald-500"></span>
                    <span class="text-slate-600">Kas Masuk</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded bg-rose-500"></span>
                    <span class="text-slate-600">Kas Keluar</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded bg-blue-600"></span>
                    <span class="text-slate-600">Net Profit</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
            @foreach($monthlyTrends as $mt)
                <div class="p-3.5 rounded-2xl border border-slate-200 {{ $mt['net'] >= 0 ? 'bg-slate-50 hover:border-emerald-300' : 'bg-rose-50/40 hover:border-rose-300' }} transition space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-slate-800 uppercase">{{ $mt['name'] }}</span>
                        <span class="text-[10px] font-mono px-1.5 py-0.5 rounded {{ $mt['net'] >= 0 ? 'bg-emerald-100 text-emerald-800 font-bold' : 'bg-rose-100 text-rose-800 font-bold' }}">
                            {{ $mt['net'] >= 0 ? 'Surplus' : 'Defisit' }}
                        </span>
                    </div>
                    <div class="space-y-1 text-[11px]">
                        <div class="flex items-center justify-between text-slate-500">
                            <span>Masuk:</span>
                            <span class="font-mono font-bold text-emerald-700">Rp {{ number_format($mt['inflow'] / 1000000, 1) }}M</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-500">
                            <span>Keluar:</span>
                            <span class="font-mono font-bold text-rose-700">Rp {{ number_format($mt['outflow'] / 1000000, 1) }}M</span>
                        </div>
                        <div class="pt-1 border-t border-slate-200 flex items-center justify-between font-bold">
                            <span class="text-slate-700">Net:</span>
                            <span class="font-mono {{ $mt['net'] >= 0 ? 'text-blue-700' : 'text-rose-700' }}">
                                {{ $mt['net'] >= 0 ? '+' : '' }}Rp {{ number_format($mt['net'] / 1000000, 1) }}M
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
