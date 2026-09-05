<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Buku Kas Umum & Jurnal Keuangan - LPK Sahabat Jepang Indonesia</title>
    
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
            }
            .no-print {
                display: none !important;
            }
            .print-page {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            tr {
                page-break-inside: avoid;
            }
        }
        @page {
            size: A4 landscape;
            margin: 1cm;
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-900 p-4 sm:p-8 antialiased">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-6xl mx-auto mb-6 flex items-center justify-between no-print bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
        <a href="{{ route('admin.cash-book.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            &larr; Kembali ke Buku Kas Umum
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Simpan PDF (A4 Landscape)</span>
            </button>
        </div>
    </div>

    <!-- Printable Sheet (A4 Landscape Format) -->
    <div class="max-w-6xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-lg border border-slate-200 print-page space-y-6">
        
        <!-- Official Header (KOP Surat LPK) -->
        <div class="flex items-center justify-between border-b-2 border-slate-900 pb-5">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-red-600 text-white flex items-center justify-center font-black text-2xl shadow-md">
                    友
                </div>
                <div>
                    <h1 class="text-xl font-black tracking-tight text-slate-900 uppercase">LPK Sahabat Jepang Indonesia</h1>
                    <p class="text-xs text-slate-600 font-medium">Lembaga Pelatihan Kerja & Sending Organization (SO) Resmi Kemenaker RI</p>
                    <p class="text-[10px] text-slate-400 font-mono mt-0.5">Izin Kemenaker: KEP.224/LATTAS/XII/2023 • VIN: 2102320101</p>
                </div>
            </div>
            <div class="text-right">
                <div class="inline-block px-3 py-1 bg-red-50 text-red-700 font-black text-xs uppercase rounded-full border border-red-100 mb-1">
                    Dokumen Pembukuan Resmi
                </div>
                <p class="text-xs font-bold text-slate-800">Buku Kas Umum & Jurnal Keuangan</p>
                <p class="text-[10px] text-slate-500 font-mono">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- 3 Executive Summary Cards -->
        <div class="grid grid-cols-3 gap-4">
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200">
                <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider">Total Kas Masuk (Debit)</span>
                <h3 class="text-xl font-black text-emerald-700 mt-1">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-emerald-600 font-medium">Pelunasan siswa, pendaftaran & dana masuk</p>
            </div>
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200">
                <span class="text-[10px] font-bold text-rose-800 uppercase tracking-wider">Total Kas Keluar (Kredit)</span>
                <h3 class="text-xl font-black text-rose-700 mt-1">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-rose-600 font-medium">Gaji, sewa, utilitas, klaim reimburse & kasbon</p>
            </div>
            <div class="p-4 rounded-xl {{ $netCashflow >= 0 ? 'bg-blue-50 border-blue-200' : 'bg-red-50 border-red-200' }} border">
                <span class="text-[10px] font-bold uppercase tracking-wider {{ $netCashflow >= 0 ? 'text-blue-800' : 'text-red-800' }}">
                    Arus Kas Bersih ({{ $netCashflow >= 0 ? 'Surplus' : 'Defisit' }})
                </span>
                <h3 class="text-xl font-black mt-1 {{ $netCashflow >= 0 ? 'text-blue-800' : 'text-rose-700' }}">
                    {{ $netCashflow >= 0 ? '+' : '' }}Rp {{ number_format($netCashflow, 0, ',', '.') }}
                </h3>
                <p class="text-[10px] text-slate-500 font-medium">Saldo kas operasional bersih periode laporan</p>
            </div>
        </div>

        <!-- Table of Cash Transactions with Running Balance -->
        <div class="border border-slate-200 rounded-xl overflow-hidden">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-200 text-slate-700 text-[10px] uppercase font-black">
                        <th class="py-2.5 px-3">No</th>
                        <th class="py-2.5 px-3">No. Bukti</th>
                        <th class="py-2.5 px-3">Tanggal</th>
                        <th class="py-2.5 px-3">Uraian / Deskripsi Transaksi</th>
                        <th class="py-2.5 px-3">Kategori Akun</th>
                        <th class="py-2.5 px-3">Metode Bayar</th>
                        <th class="py-2.5 px-3 text-right">Debet (Rp)</th>
                        <th class="py-2.5 px-3 text-right">Kredit (Rp)</th>
                        <th class="py-2.5 px-3 text-right">Saldo Berjalan (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $running = 0;
                    @endphp
                    @forelse($transactions as $idx => $t)
                        @php
                            $debet = $t->type === 'income' ? (float) $t->amount : 0;
                            $kredit = $t->type === 'expense' ? (float) $t->amount : 0;
                            $running += ($debet - $kredit);
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="py-2 px-3 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                            <td class="py-2 px-3 font-mono font-bold {{ $t->type === 'income' ? 'text-emerald-700' : 'text-rose-700' }}">{{ $t->transaction_number }}</td>
                            <td class="py-2 px-3 text-slate-600 font-medium">{{ $t->transaction_date->format('d/m/Y') }}</td>
                            <td class="py-2 px-3 font-semibold text-slate-900">{{ $t->title }}</td>
                            <td class="py-2 px-3 text-slate-600">{{ $t->category_label }}</td>
                            <td class="py-2 px-3 text-slate-600 font-mono text-[11px]">{{ $t->payment_method_label }}</td>
                            <td class="py-2 px-3 text-right font-mono font-bold text-emerald-700">
                                {{ $debet > 0 ? number_format($debet, 0, ',', '.') : '-' }}
                            </td>
                            <td class="py-2 px-3 text-right font-mono font-bold text-rose-700">
                                {{ $kredit > 0 ? number_format($kredit, 0, ',', '.') : '-' }}
                            </td>
                            <td class="py-2 px-3 text-right font-mono font-black text-slate-900">
                                {{ number_format($running, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-6 text-center text-slate-400 italic">Belum ada transaksi pada periode laporan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Official Signatures -->
        <div class="pt-6 grid grid-cols-2 gap-8 text-center text-xs">
            <div class="space-y-16">
                <p class="font-bold text-slate-600">Disusun & Diperiksa oleh, Bendahara LPK</p>
                <div>
                    <p class="font-bold text-slate-900 underline">{{ auth()->user()->name ?? 'Divisi Keuangan LPK' }}</p>
                    <p class="text-[10px] text-slate-400 font-mono">Kepala Bagian Keuangan & Perbendaharaan</p>
                </div>
            </div>
            <div class="space-y-16">
                <p class="font-bold text-slate-600">Mengetahui & Menyetujui, Direktur Utama</p>
                <div>
                    <p class="font-bold text-slate-900 underline">Pimpinan LPK Sahabat Jepang Indonesia</p>
                    <p class="text-[10px] text-slate-400 font-mono">SO Kemenaker RI KEP.224/LATTAS/XII/2023</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
