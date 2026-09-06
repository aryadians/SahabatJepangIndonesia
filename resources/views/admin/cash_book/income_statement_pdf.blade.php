<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi Operasional - LPK Sahabat Jepang Indonesia ({{ $docNumber }})</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Noto+Sans+JP:wght@400;700;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
                color: black !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
            .print-page {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                padding: 24px !important;
                max-width: 100% !important;
                border-radius: 0 !important;
            }
            tr {
                page-break-inside: avoid;
            }
        }
        @page {
            size: A4 portrait;
            margin: 10mm 15mm;
        }
        .hanko-stamp {
            border: 2px solid #DC2626;
            color: #DC2626;
            transform: rotate(-4deg);
            background: rgba(254, 242, 242, 0.4);
            box-shadow: 0 0 0 1px #DC2626 inset;
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-900 p-4 sm:p-8 antialiased">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
        <a href="{{ route('admin.cash-book.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            &larr; Kembali ke Buku Kas Umum
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Simpan PDF (A4 Portrait)</span>
            </button>
        </div>
    </div>

    <!-- Printable Sheet (A4 Portrait Format) -->
    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-lg border border-slate-200 print-page space-y-6 relative overflow-hidden">
        
        <!-- Watermark LPK SJI -->
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.02] pointer-events-none select-none">
            <span class="text-9xl font-black">決算報告</span>
        </div>

        <!-- Official Header (KOP Surat) -->
        <div class="border-b-2 border-slate-900 pb-5 flex items-start justify-between gap-6">
            <div class="flex items-start gap-4">
                @if(!empty($settings['site_logo']))
                    <div class="h-16 w-16 rounded-2xl bg-white border border-slate-200 p-1 flex items-center justify-center shadow-xs overflow-hidden flex-shrink-0">
                        <img src="{{ $settings['site_logo'] }}" alt="Logo" class="max-h-full max-w-full object-contain">
                    </div>
                @else
                    <div class="h-16 w-16 rounded-2xl bg-red-600 text-white flex flex-col items-center justify-center font-black shadow-xs flex-shrink-0">
                        <span class="text-xl leading-none">日</span>
                        <span class="text-[9px] tracking-tighter uppercase font-bold mt-0.5">SJI</span>
                    </div>
                @endif
                <div>
                    <h1 class="text-lg font-black text-slate-900 tracking-tight uppercase">
                        {{ $settings['site_title'] ?? 'LPK SAHABAT JEPANG INDONESIA' }}
                    </h1>
                    <p class="text-[11px] font-bold text-red-600 uppercase tracking-widest mt-0.5">
                        Sending Organization (SO) Kemenaker RI: KEP.224/LATTAS/XII/2023
                    </p>
                    <p class="text-[10px] text-slate-500 mt-1 leading-relaxed max-w-lg">
                        {{ $settings['contact_address'] ?? 'Jl. Raya Pendidikan No. 88, Jakarta Selatan, Indonesia' }} • Telp: {{ $settings['contact_phone'] ?? '0812-3456-7890' }} • Email: {{ $settings['contact_email'] ?? 'keuangan@sahabatjepang.co.id' }}
                    </p>
                </div>
            </div>
            <div class="text-right flex-shrink-0">
                <span class="inline-block px-3 py-1 rounded-full bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest">
                    Laporan Resmi
                </span>
                <p class="text-[11px] font-mono font-bold text-slate-700 mt-2">No: {{ $docNumber }}</p>
                <p class="text-[10px] text-slate-400">Dicetak: {{ date('d/m/Y H:i') }} WIB</p>
            </div>
        </div>

        <!-- Report Title & Period Banner -->
        <div class="text-center py-2 border-b border-slate-200">
            <h2 class="text-base font-black text-slate-900 uppercase tracking-wider">
                LAPORAN LABA RUGI OPERASIONAL (INCOME STATEMENT / P&L)
            </h2>
            <p class="text-xs font-semibold text-slate-600 mt-1">
                Periode Pembukuan: <span class="font-bold text-slate-900 font-mono">{{ $periodLabel }}</span>
            </p>
        </div>

        <!-- 3 Highlight Executive Metric Cards -->
        <div class="grid grid-cols-3 gap-3">
            <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-center">
                <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider block">Total Pendapatan (A)</span>
                <p class="text-base font-black text-emerald-700 font-mono mt-1">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
            <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-center">
                <span class="text-[10px] font-bold text-rose-800 uppercase tracking-wider block">Total Beban Usaha (B)</span>
                <p class="text-base font-black text-rose-700 font-mono mt-1">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
            </div>
            <div class="p-3.5 rounded-2xl {{ $netProfit >= 0 ? 'bg-blue-50 border-blue-200' : 'bg-red-50 border-red-200' }} text-center">
                <span class="text-[10px] font-bold {{ $netProfit >= 0 ? 'text-blue-800' : 'text-red-800' }} uppercase tracking-wider block">
                    {{ $netProfit >= 0 ? 'Laba Bersih Operasional' : 'Defisit Usaha Operasional' }}
                </span>
                <p class="text-base font-black {{ $netProfit >= 0 ? 'text-blue-700' : 'text-red-700' }} font-mono mt-1">
                    {{ $netProfit >= 0 ? '+' : '' }}Rp {{ number_format($netProfit, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Financial Performance Indicators -->
        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between text-xs font-semibold text-slate-700">
            <div>
                <span>Operating Profit Margin:</span>
                <span class="font-bold ml-1 {{ $profitMargin >= 0 ? 'text-emerald-700' : 'text-rose-700' }}">{{ $profitMargin }}%</span>
            </div>
            <div>
                <span>Operating Expense Ratio:</span>
                <span class="font-bold text-slate-900 ml-1">{{ $expenseRatio }}%</span>
            </div>
            <div>
                <span>Status Kinerja:</span>
                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black {{ $netProfit >= 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                    {{ $netProfit >= 0 ? 'SURPLUS / SEHAT' : 'DEFISIT / PERLU EFISIENSI' }}
                </span>
            </div>
        </div>

        <!-- Tabel 1: Pendapatan Operasional -->
        <div class="space-y-2">
            <div class="flex items-center justify-between pb-1 border-b-2 border-emerald-600">
                <h3 class="text-xs font-black text-emerald-900 uppercase tracking-wide">
                    I. PENDAPATAN OPERASIONAL & PENDIDIKAN (REVENUES)
                </h3>
                <span class="text-[11px] font-bold text-emerald-800">Kode Akun Kas Masuk (Debet)</span>
            </div>
            <table class="w-full text-xs border-collapse">
                <thead>
                    <tr class="bg-emerald-50 text-emerald-900 border-y border-emerald-200 text-[11px]">
                        <th class="py-2 px-3 text-left w-12 font-extrabold">No</th>
                        <th class="py-2 px-3 text-left font-extrabold">Klasifikasi Pos Pendapatan</th>
                        <th class="py-2 px-3 text-right w-36 font-extrabold">Porsi (%)</th>
                        <th class="py-2 px-3 text-right w-44 font-extrabold">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($incomeItems as $idx => $item)
                        @php
                            $pct = $totalIncome > 0 ? round(($item['amount'] / $totalIncome) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="py-2 px-3 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                            <td class="py-2 px-3 font-semibold text-slate-800">{{ $item['label'] }}</td>
                            <td class="py-2 px-3 text-right font-mono text-slate-500">{{ $pct }}%</td>
                            <td class="py-2 px-3 text-right font-bold text-emerald-700 font-mono">
                                Rp {{ number_format($item['amount'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-3 text-center text-slate-400 italic">Tidak ada transaksi pendapatan pada periode ini.</td>
                        </tr>
                    @endforelse
                    <tr class="bg-emerald-100/60 font-black text-emerald-950 border-t-2 border-emerald-600">
                        <td colspan="3" class="py-2.5 px-3 uppercase tracking-wider">TOTAL PENDAPATAN OPERASIONAL (A)</td>
                        <td class="py-2.5 px-3 text-right font-mono text-sm">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabel 2: Beban Usaha Lembaga -->
        <div class="space-y-2 pt-2">
            <div class="flex items-center justify-between pb-1 border-b-2 border-rose-600">
                <h3 class="text-xs font-black text-rose-900 uppercase tracking-wide">
                    II. BEBAN OPERASIONAL & UMUM (OPERATING EXPENSES)
                </h3>
                <span class="text-[11px] font-bold text-rose-800">Kode Akun Kas Keluar (Kredit)</span>
            </div>
            <table class="w-full text-xs border-collapse">
                <thead>
                    <tr class="bg-rose-50 text-rose-900 border-y border-rose-200 text-[11px]">
                        <th class="py-2 px-3 text-left w-12 font-extrabold">No</th>
                        <th class="py-2 px-3 text-left font-extrabold">Klasifikasi Pos Beban Usaha</th>
                        <th class="py-2 px-3 text-right w-36 font-extrabold">Porsi (%)</th>
                        <th class="py-2 px-3 text-right w-44 font-extrabold">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($expenseItems as $idx => $item)
                        @php
                            $pct = $totalExpense > 0 ? round(($item['amount'] / $totalExpense) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="py-2 px-3 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                            <td class="py-2 px-3 font-semibold text-slate-800">{{ $item['label'] }}</td>
                            <td class="py-2 px-3 text-right font-mono text-slate-500">{{ $pct }}%</td>
                            <td class="py-2 px-3 text-right font-bold text-rose-700 font-mono">
                                Rp {{ number_format($item['amount'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-3 text-center text-slate-400 italic">Tidak ada transaksi beban usaha pada periode ini.</td>
                        </tr>
                    @endforelse
                    <tr class="bg-rose-100/60 font-black text-rose-950 border-t-2 border-rose-600">
                        <td colspan="3" class="py-2.5 px-3 uppercase tracking-wider">TOTAL BEBAN OPERASIONAL (B)</td>
                        <td class="py-2.5 px-3 text-right font-mono text-sm">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Ringkasan Laba Bersih Akhir -->
        <div class="p-4 rounded-2xl {{ $netProfit >= 0 ? 'bg-blue-50 border-2 border-blue-300' : 'bg-red-50 border-2 border-red-300' }} flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider {{ $netProfit >= 0 ? 'text-blue-800' : 'text-red-800' }} block">
                    III. LABA / (DEFISIT) BERSIH OPERASIONAL LEMBAGA (A - B)
                </span>
                <p class="text-[11px] text-slate-600 mt-0.5">
                    {{ $netProfit >= 0 ? 'Lembaga membukukan surplus operasional bersih positif pada periode laporan ini.' : 'Lembaga membukukan defisit pengeluaran yang melebihi penerimaan pada periode ini.' }}
                </p>
            </div>
            <div class="text-right">
                <span class="text-lg sm:text-xl font-black font-mono {{ $netProfit >= 0 ? 'text-blue-700' : 'text-rose-700' }}">
                    {{ $netProfit >= 0 ? '+' : '' }}Rp {{ number_format($netProfit, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Lembar Pengesahan & Tanda Tangan Resmi -->
        <div class="pt-6 border-t border-slate-200 grid grid-cols-2 gap-8 text-center text-xs">
            <div>
                <p class="text-slate-500">Disusun & Diperiksa Oleh:</p>
                <p class="font-bold text-slate-800 mt-0.5">Bagian Keuangan & Kasir Lembaga</p>
                <div class="h-20 flex items-center justify-center">
                    <!-- Tanda tangan / stempel digital -->
                    <span class="text-[10px] text-slate-300 italic font-mono">[Tanda Tangan Sah]</span>
                </div>
                <p class="font-extrabold text-slate-900 underline underline-offset-4">{{ auth()->user()->name ?? 'Bendahara Keuangan LPK' }}</p>
                <p class="text-[10px] text-slate-400 font-mono">NIP: SJI-FIN-{{ date('Y') }}</p>
            </div>
            <div>
                <p class="text-slate-500">Mengetahui & Menyetujui:</p>
                <p class="font-bold text-slate-800 mt-0.5">Direktur Utama LPK Sahabat Jepang Indonesia</p>
                <div class="h-20 flex items-center justify-center relative">
                    <div class="hanko-stamp w-28 h-14 rounded-full flex flex-col items-center justify-center select-none py-1">
                        <span class="tracking-widest uppercase text-[7px] font-black">LPK SAHABAT JEPANG</span>
                        <span class="text-[10px] font-black tracking-wider">DISETUJUI</span>
                        <span class="text-[6px] tracking-tight">送出機関 友好日本</span>
                    </div>
                </div>
                <p class="font-extrabold text-slate-900 underline underline-offset-4">Direktur Eksekutif Lembaga</p>
                <p class="text-[10px] text-slate-400 font-mono">NIP: SJI-DIR-{{ date('Y') }}</p>
            </div>
        </div>

        <!-- Footer Notice -->
        <div class="pt-4 border-t border-slate-100 text-[10px] text-slate-400 text-center leading-relaxed">
            Dokumen Laporan Laba Rugi Operasional ini sah diterbitkan secara digital oleh Sistem Akuntansi & Buku Kas LPK Sahabat Jepang Indonesia dan diakui untuk keperluan audit internal, pelaporan yayasan, dan pertanggungjawaban legalitas dinas.
        </div>

    </div>

</body>
</html>
