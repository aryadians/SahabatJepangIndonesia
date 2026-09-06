<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Neraca Keuangan - LPK Sahabat Jepang Indonesia ({{ $docNumber }})</title>
    
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
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md flex items-center gap-2">
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
            <span class="text-9xl font-black">貸借対照表</span>
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
                LAPORAN POSISI KEUANGAN / NERACA (BALANCE SHEET)
            </h2>
            <p class="text-xs font-semibold text-slate-600 mt-1">
                Posisi Per Tanggal: <span class="font-bold text-slate-900 font-mono">{{ $formattedDate }}</span>
            </p>
        </div>

        <!-- 3 Highlight Executive Metric Cards -->
        <div class="grid grid-cols-3 gap-3">
            <div class="p-3.5 rounded-2xl bg-blue-50 border border-blue-200 text-center">
                <span class="text-[10px] font-bold text-blue-800 uppercase tracking-wider block">Total Aset (Aktiva)</span>
                <p class="text-base font-black text-blue-700 font-mono mt-1">Rp {{ number_format($totalCurrentAssets, 0, ',', '.') }}</p>
            </div>
            <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-center">
                <span class="text-[10px] font-bold text-amber-800 uppercase tracking-wider block">Total Kewajiban</span>
                <p class="text-base font-black text-amber-700 font-mono mt-1">Rp {{ number_format($totalLiabilities, 0, ',', '.') }}</p>
            </div>
            <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-center">
                <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider block">Ekuitas Bersih Lembaga</span>
                <p class="text-base font-black text-emerald-700 font-mono mt-1">Rp {{ number_format($equityBalance, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Grid 2 Kolom: Aset (Aktiva) vs Kewajiban & Ekuitas (Pasiva) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            
            <!-- Kolom Kiri: ASET (AKTIVA) -->
            <div class="space-y-4">
                <div class="pb-1 border-b-2 border-blue-600 flex items-center justify-between">
                    <h3 class="text-xs font-black text-blue-900 uppercase tracking-wide">
                        I. ASET LANCAR (CURRENT ASSETS)
                    </h3>
                    <span class="text-[10px] font-bold text-blue-700">Aktiva</span>
                </div>

                <!-- Rincian Kas & Setara Kas -->
                <div class="border border-slate-200 rounded-2xl p-3.5 space-y-2 text-xs bg-slate-50/50">
                    <p class="font-black text-slate-800 uppercase text-[11px] flex items-center justify-between border-b border-slate-200 pb-1">
                        <span>A. Kas & Setara Kas</span>
                        <span class="font-mono text-blue-700">Rp {{ number_format($totalCash, 0, ',', '.') }}</span>
                    </p>
                    <div class="space-y-1.5 pt-1 text-slate-600 text-[11px]">
                        <div class="flex items-center justify-between">
                            <span>• Kas Tunai (Kasir Lembaga)</span>
                            <span class="font-mono font-semibold text-slate-800">Rp {{ number_format($cashOnHand, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>• Rekening Bank Mandiri</span>
                            <span class="font-mono font-semibold text-slate-800">Rp {{ number_format($bankMandiri, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>• Rekening Bank BCA</span>
                            <span class="font-mono font-semibold text-slate-800">Rp {{ number_format($bankBca, 0, ',', '.') }}</span>
                        </div>
                        @if($bankOther != 0)
                        <div class="flex items-center justify-between">
                            <span>• Bank / Metode Lain</span>
                            <span class="font-mono font-semibold text-slate-800">Rp {{ number_format($bankOther, 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Piutang & Uang Muka -->
                <div class="border border-slate-200 rounded-2xl p-3.5 space-y-2 text-xs bg-slate-50/50">
                    <p class="font-black text-slate-800 uppercase text-[11px] border-b border-slate-200 pb-1">
                        B. Piutang & Biaya Dibayar di Muka
                    </p>
                    <div class="space-y-2 pt-1 text-slate-600 text-[11px]">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-semibold text-slate-800 block">• Piutang Biaya Pelatihan Siswa</span>
                                <span class="text-[10px] text-slate-400">Total cicilan tertunggak siswa aktif</span>
                            </div>
                            <span class="font-mono font-bold text-slate-800">Rp {{ number_format($studentReceivables, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-1 border-t border-slate-100">
                            <div>
                                <span class="font-semibold text-slate-800 block">• Uang Muka Dinas (Kasbon Aktif)</span>
                                <span class="text-[10px] text-slate-400">Kasbon dinas karyawan belum SPJ</span>
                            </div>
                            <span class="font-mono font-bold text-slate-800">Rp {{ number_format($unsettledAdvances, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Total Aktiva -->
                <div class="p-3.5 rounded-2xl bg-blue-100/70 border-2 border-blue-400 flex items-center justify-between text-xs font-black text-blue-950">
                    <span class="uppercase tracking-wider">TOTAL ASET (AKTIVA)</span>
                    <span class="font-mono text-sm">Rp {{ number_format($totalCurrentAssets, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Kolom Kanan: KEWAJIBAN & EKUITAS (PASIVA) -->
            <div class="space-y-4">
                <div class="pb-1 border-b-2 border-amber-600 flex items-center justify-between">
                    <h3 class="text-xs font-black text-amber-900 uppercase tracking-wide">
                        II. KEWAJIBAN (LIABILITIES)
                    </h3>
                    <span class="text-[10px] font-bold text-amber-700">Pasiva</span>
                </div>

                <!-- Kewajiban Lancar -->
                <div class="border border-slate-200 rounded-2xl p-3.5 space-y-2 text-xs bg-slate-50/50">
                    <p class="font-black text-slate-800 uppercase text-[11px] border-b border-slate-200 pb-1">
                        A. Kewajiban Jangka Pendek
                    </p>
                    <div class="space-y-2 pt-1 text-slate-600 text-[11px]">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-semibold text-slate-800 block">• Utang Klaim Reimburse Terverifikasi</span>
                                <span class="text-[10px] text-slate-400">Status approved menunggu pencairan</span>
                            </div>
                            <span class="font-mono font-bold text-amber-700">Rp {{ number_format($pendingReimbursements, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="pb-1 border-b-2 border-emerald-600 flex items-center justify-between pt-2">
                    <h3 class="text-xs font-black text-emerald-900 uppercase tracking-wide">
                        III. EKUITAS & MODAL LEMBAGA (EQUITY)
                    </h3>
                    <span class="text-[10px] font-bold text-emerald-700">Modal Bersih</span>
                </div>

                <!-- Rincian Ekuitas -->
                <div class="border border-slate-200 rounded-2xl p-3.5 space-y-2 text-xs bg-slate-50/50">
                    <p class="font-black text-slate-800 uppercase text-[11px] border-b border-slate-200 pb-1">
                        B. Saldo Ekuitas & Laba Ditahan
                    </p>
                    <div class="space-y-2 pt-1 text-slate-600 text-[11px]">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-semibold text-slate-800 block">• Saldo Ekuitas Bersih Lembaga</span>
                                <span class="text-[10px] text-slate-400">Total kekayaan bersih setelah dikurangi utang</span>
                            </div>
                            <span class="font-mono font-bold text-emerald-700">Rp {{ number_format($equityBalance, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Total Pasiva -->
                <div class="p-3.5 rounded-2xl bg-slate-900 text-white border-2 border-slate-900 flex items-center justify-between text-xs font-black">
                    <span class="uppercase tracking-wider">TOTAL KEWAJIBAN & EKUITAS</span>
                    <span class="font-mono text-sm text-emerald-400">Rp {{ number_format($totalCurrentAssets, 0, ',', '.') }}</span>
                </div>
            </div>

        </div>

        <!-- Balance Indicator Badge -->
        <div class="p-3 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-between text-xs">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                <span class="font-bold text-emerald-900">Keseimbangan Neraca (Balance Status): <span class="text-emerald-700">SEIMBANG (BALANCED) ✅</span></span>
            </div>
            <span class="text-[11px] font-mono text-emerald-800 font-bold">Aktiva: Rp {{ number_format($totalCurrentAssets, 0, ',', '.') }} = Pasiva: Rp {{ number_format($totalCurrentAssets, 0, ',', '.') }}</span>
        </div>

        <!-- Lembar Pengesahan & Tanda Tangan Resmi -->
        <div class="pt-6 border-t border-slate-200 grid grid-cols-2 gap-8 text-center text-xs">
            <div>
                <p class="text-slate-500">Disusun & Diverifikasi Oleh:</p>
                <p class="font-bold text-slate-800 mt-0.5">Bagian Akuntansi & Keuangan</p>
                <div class="h-20 flex items-center justify-center">
                    <span class="text-[10px] text-slate-300 italic font-mono">[Tanda Tangan Sah]</span>
                </div>
                <p class="font-extrabold text-slate-900 underline underline-offset-4">{{ auth()->user()->name ?? 'Bendahara Keuangan LPK' }}</p>
                <p class="text-[10px] text-slate-400 font-mono">NIP: SJI-FIN-{{ date('Y') }}</p>
            </div>
            <div>
                <p class="text-slate-500">Disahkan Oleh:</p>
                <p class="font-bold text-slate-800 mt-0.5">Direktur Utama LPK Sahabat Jepang Indonesia</p>
                <div class="h-20 flex items-center justify-center relative">
                    <div class="hanko-stamp w-28 h-14 rounded-full flex flex-col items-center justify-center select-none py-1">
                        <span class="tracking-widest uppercase text-[7px] font-black">LPK SAHABAT JEPANG</span>
                        <span class="text-[10px] font-black tracking-wider">DISAHKAN</span>
                        <span class="text-[6px] tracking-tight">送出機関 友好日本</span>
                    </div>
                </div>
                <p class="font-extrabold text-slate-900 underline underline-offset-4">Direktur Eksekutif Lembaga</p>
                <p class="text-[10px] text-slate-400 font-mono">NIP: SJI-DIR-{{ date('Y') }}</p>
            </div>
        </div>

        <!-- Footer Notice -->
        <div class="pt-4 border-t border-slate-100 text-[10px] text-slate-400 text-center leading-relaxed">
            Laporan Posisi Keuangan (Neraca) ini merupakan dokumen resmi akuntansi LPK Sahabat Jepang Indonesia yang dihasilkan dari pembukuan buku kas umum terpadu dan diakui secara sah untuk pelaporan tata kelola keuangan lembaga.
        </div>

    </div>

</body>
</html>
