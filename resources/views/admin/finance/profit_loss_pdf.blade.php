<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi Resmi - LPK Sahabat Jepang Indonesia ({{ $docNumber }})</title>
    
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
                padding: 20px 24px !important;
                max-width: 100% !important;
                border-radius: 0 !important;
            }
            tr {
                page-break-inside: avoid;
            }
            .page-break {
                page-break-before: always;
            }
        }
        @page {
            size: A4 portrait;
            margin: 8mm 12mm;
        }
        .hanko-stamp-cfo {
            border: 2px solid #DC2626;
            color: #DC2626;
            transform: rotate(-3deg);
            background: rgba(254, 242, 242, 0.45);
            box-shadow: 0 0 0 1px #DC2626 inset;
        }
        .hanko-stamp-ceo {
            border: 2px solid #DC2626;
            color: #DC2626;
            transform: rotate(2deg);
            background: rgba(254, 242, 242, 0.45);
            box-shadow: 0 0 0 1px #DC2626 inset;
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-900 p-4 sm:p-8 antialiased">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.pl', request()->query()) }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
                &larr; Kembali ke Laporan Laba Rugi
            </a>
            <span class="text-slate-300">|</span>
            <a href="{{ route('admin.finance.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                Dashboard Keuangan
            </a>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-japan-600 hover:bg-japan-700 text-white font-bold text-xs shadow-md flex items-center gap-2 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Simpan PDF (A4 Portrait)</span>
            </button>
        </div>
    </div>

    <!-- Official Printable Document Sheet (A4 Portrait) -->
    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-slate-200 print-page space-y-6 relative overflow-hidden">
        
        <!-- Subtle Japanese Watermark -->
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.02] pointer-events-none select-none">
            <span class="text-9xl font-black">損益計算書</span>
        </div>

        <!-- Official KOP Surat -->
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
                    Dokumen Resmi
                </span>
                <p class="text-[11px] font-mono font-bold text-slate-700 mt-2">No: {{ $docNumber }}</p>
                <p class="text-[10px] text-slate-400">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- Document Title & Kanji Header -->
        <div class="text-center py-1 border-b border-slate-200">
            <h2 class="text-base font-black text-slate-900 uppercase tracking-wider">
                LAPORAN LABA RUGI OPERASIONAL LEMBAGA (損益計算書)
            </h2>
            <p class="text-xs font-semibold text-slate-600 mt-1">
                Periode Pembukuan: <span class="font-bold text-slate-900 font-mono">{{ $periodLabel }}</span> ({{ $periodKanji }})
            </p>
            <p class="text-[10px] text-slate-400 mt-0.5">
                Tanggal: {{ $startDate->translatedFormat('d F Y') }} s/d {{ $endDate->translatedFormat('d F Y') }} • Mata Uang: Rupiah (IDR)
            </p>
        </div>

        <!-- 4 Key Executive Performance Indicators -->
        <div class="grid grid-cols-4 gap-3 text-center text-xs">
            <div class="p-3 rounded-2xl bg-emerald-50 border border-emerald-200">
                <span class="text-[10px] font-bold text-emerald-800 uppercase block">Pendapatan Bruto (A)</span>
                <p class="text-sm sm:text-base font-black text-emerald-700 font-mono mt-1">Rp {{ number_format($grossRevenue, 0, ',', '.') }}</p>
                <span class="text-[9px] text-emerald-600">Revenues / 売上高</span>
            </div>
            <div class="p-3 rounded-2xl bg-teal-50 border border-teal-200">
                <span class="text-[10px] font-bold text-teal-800 uppercase block">HPP Pendidikan (B)</span>
                <p class="text-sm sm:text-base font-black text-teal-700 font-mono mt-1">Rp {{ number_format($totalCogs, 0, ',', '.') }}</p>
                <span class="text-[9px] text-teal-600">COGS / 売上原価</span>
            </div>
            <div class="p-3 rounded-2xl bg-rose-50 border border-rose-200">
                <span class="text-[10px] font-bold text-rose-800 uppercase block">Beban OPEX (C)</span>
                <p class="text-sm sm:text-base font-black text-rose-700 font-mono mt-1">Rp {{ number_format($totalOpex, 0, ',', '.') }}</p>
                <span class="text-[9px] text-rose-600">OPEX / 販管費</span>
            </div>
            <div class="p-3 rounded-2xl {{ $netProfit >= 0 ? 'bg-blue-50 border-blue-200' : 'bg-red-50 border-red-200' }}">
                <span class="text-[10px] font-bold {{ $netProfit >= 0 ? 'text-blue-800' : 'text-red-800' }} uppercase block">
                    {{ $netProfit >= 0 ? 'Laba Bersih' : 'Defisit Bersih' }}
                </span>
                <p class="text-sm sm:text-base font-black {{ $netProfit >= 0 ? 'text-blue-700' : 'text-red-700' }} font-mono mt-1">
                    {{ $netProfit >= 0 ? '+' : '' }}Rp {{ number_format($netProfit, 0, ',', '.') }}
                </p>
                <span class="text-[9px] {{ $netProfit >= 0 ? 'text-blue-600' : 'text-red-600' }}">Net Margin: {{ $netMargin }}%</span>
            </div>
        </div>

        <!-- Rincian Laporan Finansial Multi-Step (Format Standar Akuntansi) -->
        <div class="space-y-4">
            
            <!-- I. PENDAPATAN OPERASIONAL -->
            <div>
                <div class="flex items-center justify-between pb-1 border-b-2 border-emerald-600">
                    <h3 class="text-xs font-black text-emerald-950 uppercase tracking-wide">
                        I. PENDAPATAN OPERASIONAL (REVENUES / 売上高)
                    </h3>
                    <span class="text-[10px] font-bold text-emerald-800">Kode Akun Debet Kas Masuk</span>
                </div>
                <table class="w-full text-xs border-collapse">
                    <thead>
                        <tr class="bg-emerald-50 text-emerald-900 border-b border-emerald-200 text-[10px]">
                            <th class="py-1.5 px-3 text-left w-10 font-bold">No</th>
                            <th class="py-1.5 px-3 text-left font-bold">Klasifikasi Pos Pendapatan</th>
                            <th class="py-1.5 px-3 text-center w-28 font-bold">Kode</th>
                            <th class="py-1.5 px-3 text-right w-24 font-bold">Porsi (%)</th>
                            <th class="py-1.5 px-3 text-right w-36 font-bold">Jumlah (IDR)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($incomeItems as $idx => $item)
                            @php
                                $pct = $grossRevenue > 0 ? round(($item['amount'] / $grossRevenue) * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td class="py-1.5 px-3 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                <td class="py-1.5 px-3 font-semibold text-slate-800">{{ $item['label'] }}</td>
                                <td class="py-1.5 px-3 text-center font-mono text-[10px] text-slate-500 uppercase">{{ $item['key'] }}</td>
                                <td class="py-1.5 px-3 text-right font-mono text-slate-500">{{ $pct }}%</td>
                                <td class="py-1.5 px-3 text-right font-bold text-emerald-700 font-mono">
                                    Rp {{ number_format($item['amount'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-2 text-center text-slate-400 italic">Tidak ada transaksi pendapatan pada periode ini.</td>
                            </tr>
                        @endforelse
                        <tr class="bg-emerald-100/70 font-black text-emerald-950 border-t-2 border-emerald-600">
                            <td colspan="4" class="py-2 px-3 uppercase tracking-wider text-[11px]">TOTAL PENDAPATAN OPERASIONAL (A)</td>
                            <td class="py-2 px-3 text-right font-mono text-xs">Rp {{ number_format($grossRevenue, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- II. BEBAN POKOK PENDIDIKAN (HPP) -->
            <div>
                <div class="flex items-center justify-between pb-1 border-b-2 border-teal-600">
                    <h3 class="text-xs font-black text-teal-950 uppercase tracking-wide">
                        II. BEBAN POKOK PENDIDIKAN / HPP (COST OF GOODS SOLD / 売上原価)
                    </h3>
                    <span class="text-[10px] font-bold text-teal-800">Biaya Langsung Modul & Seragam</span>
                </div>
                <table class="w-full text-xs border-collapse">
                    <thead>
                        <tr class="bg-teal-50 text-teal-900 border-b border-teal-200 text-[10px]">
                            <th class="py-1.5 px-3 text-left w-10 font-bold">No</th>
                            <th class="py-1.5 px-3 text-left font-bold">Klasifikasi Pos HPP</th>
                            <th class="py-1.5 px-3 text-center w-28 font-bold">Kode</th>
                            <th class="py-1.5 px-3 text-right w-24 font-bold">Porsi (%)</th>
                            <th class="py-1.5 px-3 text-right w-36 font-bold">Jumlah (IDR)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($cogsItems as $idx => $item)
                            @php
                                $pct = $grossRevenue > 0 ? round(($item['amount'] / $grossRevenue) * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td class="py-1.5 px-3 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                <td class="py-1.5 px-3 font-semibold text-slate-800">{{ $item['label'] }}</td>
                                <td class="py-1.5 px-3 text-center font-mono text-[10px] text-slate-500 uppercase">{{ $item['key'] }}</td>
                                <td class="py-1.5 px-3 text-right font-mono text-slate-500">{{ $pct }}%</td>
                                <td class="py-1.5 px-3 text-right font-bold text-teal-700 font-mono">
                                    Rp {{ number_format($item['amount'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-2 text-center text-slate-400 italic">Tidak ada alokasi langsung HPP pada periode ini.</td>
                            </tr>
                        @endforelse
                        <tr class="bg-teal-100/70 font-black text-teal-950 border-t-2 border-teal-600">
                            <td colspan="4" class="py-2 px-3 uppercase tracking-wider text-[11px]">TOTAL BEBAN POKOK PENDIDIKAN (B)</td>
                            <td class="py-2 px-3 text-right font-mono text-xs">Rp {{ number_format($totalCogs, 0, ',', '.') }}</td>
                        </tr>
                        <!-- GROSS PROFIT ROW -->
                        <tr class="bg-slate-100 border-y-2 border-slate-400 font-black text-slate-900">
                            <td colspan="3" class="py-2 px-3 uppercase tracking-wider text-[11px]">
                                LABA KOTOR LEMBAGA (GROSS PROFIT / 売上総利益 = A - B)
                            </td>
                            <td class="py-2 px-3 text-right font-mono text-teal-800">{{ $grossMargin }}% Marjin</td>
                            <td class="py-2 px-3 text-right font-mono text-xs text-teal-800">
                                Rp {{ number_format($grossProfit, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- III. BEBAN OPERASIONAL & UMUM (OPEX) -->
            <div>
                <div class="flex items-center justify-between pb-1 border-b-2 border-rose-600">
                    <h3 class="text-xs font-black text-rose-950 uppercase tracking-wide">
                        III. BEBAN OPERASIONAL & UMUM (OPEX / 販売費及び一般管理費)
                    </h3>
                    <span class="text-[10px] font-bold text-rose-800">Kode Akun Kredit Kas Keluar</span>
                </div>
                <table class="w-full text-xs border-collapse">
                    <thead>
                        <tr class="bg-rose-50 text-rose-900 border-b border-rose-200 text-[10px]">
                            <th class="py-1.5 px-3 text-left w-10 font-bold">No</th>
                            <th class="py-1.5 px-3 text-left font-bold">Klasifikasi Pos Beban Usaha</th>
                            <th class="py-1.5 px-3 text-center w-28 font-bold">Kode</th>
                            <th class="py-1.5 px-3 text-right w-24 font-bold">Porsi (%)</th>
                            <th class="py-1.5 px-3 text-right w-36 font-bold">Jumlah (IDR)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($opexItems as $idx => $item)
                            @php
                                $pct = $grossRevenue > 0 ? round(($item['amount'] / $grossRevenue) * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td class="py-1.5 px-3 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                <td class="py-1.5 px-3 font-semibold text-slate-800">{{ $item['label'] }}</td>
                                <td class="py-1.5 px-3 text-center font-mono text-[10px] text-slate-500 uppercase">{{ $item['key'] }}</td>
                                <td class="py-1.5 px-3 text-right font-mono text-slate-500">{{ $pct }}%</td>
                                <td class="py-1.5 px-3 text-right font-bold text-rose-700 font-mono">
                                    Rp {{ number_format($item['amount'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-2 text-center text-slate-400 italic">Tidak ada transaksi beban operasional pada periode ini.</td>
                            </tr>
                        @endforelse
                        <tr class="bg-rose-100/70 font-black text-rose-950 border-t-2 border-rose-600">
                            <td colspan="4" class="py-2 px-3 uppercase tracking-wider text-[11px]">TOTAL BEBAN OPERASIONAL (C)</td>
                            <td class="py-2 px-3 text-right font-mono text-xs">Rp {{ number_format($totalOpex, 0, ',', '.') }}</td>
                        </tr>
                        <!-- OPERATING PROFIT ROW -->
                        <tr class="bg-indigo-50 border-y-2 border-indigo-300 font-black text-indigo-950">
                            <td colspan="3" class="py-2 px-3 uppercase tracking-wider text-[11px]">
                                LABA OPERASIONAL / EBITDA (OPERATING PROFIT / 営業利益 = Gross Profit - C)
                            </td>
                            <td class="py-2 px-3 text-right font-mono text-indigo-800">{{ $operatingMargin }}% Marjin</td>
                            <td class="py-2 px-3 text-right font-mono text-xs text-indigo-800">
                                {{ $operatingProfit >= 0 ? '+' : '' }}Rp {{ number_format($operatingProfit, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- IV. FINAL: LABA BERSIH TAHUN BERJALAN -->
            <div class="p-4 rounded-2xl {{ $netProfit >= 0 ? 'bg-blue-50 border-2 border-blue-400' : 'bg-red-50 border-2 border-red-400' }} flex items-center justify-between">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider {{ $netProfit >= 0 ? 'text-blue-950' : 'text-red-950' }} block">
                        IV. LABA / (RUGI) BERSIH TAHUN BERJALAN (NET INCOME / 当期純利益)
                    </span>
                    <p class="text-[11px] text-slate-600 mt-0.5">
                        {{ $netProfit >= 0 ? 'Lembaga berhasil merealisasikan surplus operasional bersih positif sesuai standar tata kelola keuangan.' : 'Lembaga mencatatkan pengeluaran beban yang melebihi perolehan kas masuk pada periode ini.' }}
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-base sm:text-xl font-black font-mono {{ $netProfit >= 0 ? 'text-blue-700' : 'text-rose-700' }}">
                        {{ $netProfit >= 0 ? '+' : '' }}Rp {{ number_format($netProfit, 0, ',', '.') }}
                    </span>
                    <p class="text-[10px] font-bold text-slate-500 mt-0.5 font-mono">Net Profit Margin: {{ $netMargin }}%</p>
                </div>
            </div>

        </div>

        <!-- Catatan Kepatuhan Finansial & Audit Internal -->
        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-[10px] text-slate-500 space-y-1">
            <p class="font-bold text-slate-700 uppercase tracking-wider">Catatan atas Laporan Keuangan (Notes to Financial Statement):</p>
            <ol class="list-decimal list-inside space-y-0.5 pl-1 leading-relaxed">
                <li>Seluruh angka pendapatan berbasis kas nyata (cash basis) yang telah terverifikasi di rekening koran bank atau kasir lembaga.</li>
                <li>Biaya penggajian Sensei dan karyawan bersumber langsung dari pencatatan honorarium dan transfer bank terverifikasi.</li>
                <li>Laporan ini disusun secara otomatis oleh Sistem Finansial Terpadu LPK SJI untuk keperluan evaluasi yayasan dan pelaporan berkala Kemenaker RI.</li>
            </ol>
        </div>

        <!-- Official Dual-Hanko Signature Block (Indonesian & Japanese Business Standards) -->
        <div class="pt-6 border-t-2 border-slate-900 grid grid-cols-2 gap-8 text-center text-xs">
            
            <!-- Left: CFO / Bendahara Keuangan -->
            <div>
                <p class="text-slate-500 text-[11px]">Disusun & Diperiksa Oleh:</p>
                <p class="font-bold text-slate-800 mt-0.5">Kepala Bagian Keuangan & Kasir</p>
                <p class="text-[9px] text-slate-400 font-japanese">出納責任者 / 財務担当</p>
                
                <!-- CFO Hanko Seal -->
                <div class="h-20 flex items-center justify-center my-1">
                    <div class="hanko-stamp-cfo w-28 h-14 rounded-full flex flex-col items-center justify-center select-none py-1">
                        <span class="tracking-widest uppercase text-[7px] font-black">LPK SAHABAT JEPANG</span>
                        <span class="text-[10px] font-black tracking-wider">出納之印</span>
                        <span class="text-[6px] tracking-tight">KASIR & BENDAHARA</span>
                    </div>
                </div>

                <p class="font-extrabold text-slate-900 underline underline-offset-4">{{ auth()->user()->name ?? 'Bendahara Keuangan LPK' }}</p>
                <p class="text-[10px] text-slate-400 font-mono">NIP: SJI-CFO-{{ $year }}</p>
            </div>

            <!-- Right: CEO / Direktur Utama LPK -->
            <div>
                <p class="text-slate-500 text-[11px]">Mengetahui & Disahkan Oleh:</p>
                <p class="font-bold text-slate-800 mt-0.5">Direktur Utama LPK Sahabat Jepang Indonesia</p>
                <p class="text-[9px] text-slate-400 font-japanese">代表理事 / 施設長</p>
                
                <!-- CEO Hanko Seal -->
                <div class="h-20 flex items-center justify-center my-1">
                    <div class="hanko-stamp-ceo w-28 h-14 rounded-full flex flex-col items-center justify-center select-none py-1">
                        <span class="tracking-widest uppercase text-[7px] font-black">LPK SAHABAT JEPANG</span>
                        <span class="text-[10px] font-black tracking-wider">代表理事印</span>
                        <span class="text-[6px] tracking-tight">DIREKTUR EKSEKUTIF</span>
                    </div>
                </div>

                <p class="font-extrabold text-slate-900 underline underline-offset-4">Direktur Utama Lembaga</p>
                <p class="text-[10px] text-slate-400 font-mono">NIP: SJI-DIR-{{ $year }}</p>
            </div>

        </div>

        <!-- Official Disclaimer -->
        <div class="pt-3 border-t border-slate-100 text-[9px] text-slate-400 text-center leading-relaxed">
            Dokumen Laporan Laba Rugi Operasional ini diterbitkan secara sah dan terlindungi oleh sistem informasi akuntansi LPK Sahabat Jepang Indonesia (Sending Organization Kemenaker RI: KEP.224/LATTAS/XII/2023).
        </div>

    </div>

</body>
</html>
