<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Eksekutif Keuangan & Proyeksi Arus Kas - LPK Sahabat Jepang Indonesia</title>
    
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
            size: A4 portrait;
            margin: 1.2cm;
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-900 p-4 sm:p-8 antialiased">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
        <a href="{{ route('admin.finance.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            &larr; Kembali ke Dashboard Keuangan
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Simpan PDF (A4)</span>
            </button>
        </div>
    </div>

    <!-- Official Document Sheet (A4 Portrait) -->
    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-slate-200 print-page space-y-6">
        
        <!-- Header Kop Surat Dinamis & Terintegrasi Logo -->
        @include('components.kop-surat', [
            'code' => 'FIN-' . date('Ym') . '-SJI',
            'status' => 'LAPORAN RESMI',
            'date' => date('d F Y')
        ])

        <!-- Document Title -->
        <div class="text-center py-1">
            <h2 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide underline underline-offset-4">
                LAPORAN EKSEKUTIF KEUANGAN & PROYEKSI ARUS KAS
            </h2>
            <p class="text-xs text-slate-500 mt-0.5 font-japanese">財務報告書およびキャッシュフロー予測シート</p>
        </div>

        <!-- 1. Ringkasan Kinerja Kas (KPI Card Grid) -->
        <div class="grid grid-cols-4 gap-3 text-xs">
            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200">
                <span class="text-[10px] text-slate-500 font-bold block uppercase">Total Omset Potensial</span>
                <span class="text-base font-black text-slate-900 block mt-1">Rp {{ number_format($totalPotentialRevenue) }}</span>
                <span class="text-[9px] text-slate-400">Total nilai seluruh siswa</span>
            </div>
            <div class="p-3 rounded-2xl bg-emerald-50 border border-emerald-200">
                <span class="text-[10px] text-emerald-700 font-bold block uppercase">Kas Masuk (Realized)</span>
                <span class="text-base font-black text-emerald-700 block mt-1">Rp {{ number_format($totalRealizedRevenue) }}</span>
                <span class="text-[9px] text-emerald-600">Pelunasan diterima</span>
            </div>
            <div class="p-3 rounded-2xl bg-rose-50 border border-rose-200">
                <span class="text-[10px] text-rose-700 font-bold block uppercase">Total Piutang Siswa</span>
                <span class="text-base font-black text-japan-600 block mt-1">Rp {{ number_format($totalReceivables) }}</span>
                <span class="text-[9px] text-rose-500">Tanggungan belum bayar</span>
            </div>
            <div class="p-3 rounded-2xl bg-blue-50 border border-blue-200">
                <span class="text-[10px] text-blue-700 font-bold block uppercase">Tingkat Kolektibilitas</span>
                <span class="text-base font-black text-blue-700 block mt-1">{{ $collectionRate }}%</span>
                <span class="text-[9px] text-blue-600">{{ $statusCounts['lunas'] }} Siswa Lunas</span>
            </div>
        </div>

        <!-- 2. Rekapitulasi Arus Kas Bersih (Comparative Cash Flow) -->
        <div class="space-y-3 pt-2">
            <div class="border-b border-slate-200 pb-1 flex items-center justify-between">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">
                    1. Rekapitulasi Arus Kas Riil & Rasio Operasional (Tahun {{ now()->year }})
                </h3>
                <span class="text-[10px] text-slate-500 font-bold font-mono">Inflow Siswa vs Outflow Dinas</span>
            </div>

            <div class="grid grid-cols-4 gap-3 text-xs">
                <div class="p-3 rounded-2xl bg-emerald-50/70 border border-emerald-200">
                    <span class="text-[10px] text-emerald-800 font-bold block uppercase">Kas Masuk Riil</span>
                    <span class="text-base font-black text-emerald-700 block mt-0.5">Rp {{ number_format($totalRealizedRevenue) }}</span>
                    <span class="text-[9px] text-emerald-600">Realisasi pembayaran siswa</span>
                </div>
                <div class="p-3 rounded-2xl bg-rose-50/70 border border-rose-200">
                    <span class="text-[10px] text-rose-800 font-bold block uppercase">Beban Operasional</span>
                    <span class="text-base font-black text-rose-700 block mt-0.5">Rp {{ number_format($totalOutflow) }}</span>
                    <span class="text-[9px] text-rose-600">Reimburse + Kasbon dinas</span>
                </div>
                <div class="p-3 rounded-2xl {{ $netCashflow >= 0 ? 'bg-blue-50/70 border-blue-200' : 'bg-red-50/70 border-red-200' }} border">
                    <span class="text-[10px] font-bold block uppercase {{ $netCashflow >= 0 ? 'text-blue-800' : 'text-red-800' }}">
                        Arus Kas Bersih ({{ $netCashflow >= 0 ? 'Surplus' : 'Defisit' }})
                    </span>
                    <span class="text-base font-black block mt-0.5 {{ $netCashflow >= 0 ? 'text-blue-800' : 'text-rose-700' }}">
                        {{ $netCashflow >= 0 ? '+' : '' }}Rp {{ number_format($netCashflow) }}
                    </span>
                    <span class="text-[9px] text-slate-500">Saldo kas operasional bersih</span>
                </div>
                <div class="p-3 rounded-2xl bg-purple-50/70 border border-purple-200">
                    <span class="text-[10px] text-purple-800 font-bold block uppercase">Rasio Beban Operasional</span>
                    <span class="text-base font-black text-purple-700 block mt-0.5">{{ $expenseRatio }}%</span>
                    <span class="text-[9px] text-purple-600">Persentase kas keluar / masuk</span>
                </div>
            </div>

            <!-- Tabel Komparasi Bulanan -->
            <table class="w-full text-left text-xs border border-slate-200 rounded-xl overflow-hidden mt-2">
                <thead class="bg-slate-100 text-slate-700 uppercase text-[9px] font-black tracking-wider">
                    <tr>
                        <th class="py-2 px-3">Bulan</th>
                        <th class="py-2 px-3 text-right">Kas Masuk Siswa</th>
                        <th class="py-2 px-3 text-right">Reimburse Cair</th>
                        <th class="py-2 px-3 text-right">Kasbon Dinas</th>
                        <th class="py-2 px-3 text-right">Total Outflow</th>
                        <th class="py-2 px-3 text-right">Net Cashflow</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-mono text-[10px]">
                    @foreach($monthlyComparison as $m)
                        <tr class="hover:bg-slate-50">
                            <td class="py-1.5 px-3 font-sans font-bold text-slate-800">{{ $m['month_name'] }} {{ now()->year }}</td>
                            <td class="py-1.5 px-3 text-right text-emerald-700 font-bold">Rp {{ number_format($m['inflow']) }}</td>
                            <td class="py-1.5 px-3 text-right text-slate-600">Rp {{ number_format($m['outflow_reimburse']) }}</td>
                            <td class="py-1.5 px-3 text-right text-slate-600">Rp {{ number_format($m['outflow_advance']) }}</td>
                            <td class="py-1.5 px-3 text-right text-rose-700 font-bold">Rp {{ number_format($m['outflow']) }}</td>
                            <td class="py-1.5 px-3 text-right font-black {{ $m['net'] >= 0 ? 'text-blue-700' : 'text-rose-700' }}">
                                {{ $m['net'] >= 0 ? '+' : '' }}Rp {{ number_format($m['net']) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 3. Proyeksi Penerimaan Kas Masuk (Inflow Forecasting) -->
        <div class="space-y-2 pt-2">
            <div class="border-b border-slate-200 pb-1 flex items-center justify-between">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">
                    2. Proyeksi Penerimaan Kas Masuk (Cashflow Inflow Forecast)
                </h3>
                <span class="text-[10px] text-slate-400">Estimasi Berbasis Termin Pembayaran</span>
            </div>
            <div class="grid grid-cols-3 gap-4 text-xs">
                <div class="p-4 rounded-2xl border border-blue-200 bg-blue-50/50 space-y-1">
                    <span class="text-[10px] font-bold text-blue-700 uppercase block">Proyeksi 30 Hari</span>
                    <p class="text-lg font-black text-slate-900">Rp {{ number_format($forecast30Days) }}</p>
                    <p class="text-[10px] text-slate-500">Estimasi pelunasan termin 1 (kelas pelatihan aktif).</p>
                </div>
                <div class="p-4 rounded-2xl border border-emerald-200 bg-emerald-50/50 space-y-1">
                    <span class="text-[10px] font-bold text-emerald-700 uppercase block">Proyeksi 60 Hari</span>
                    <p class="text-lg font-black text-slate-900">Rp {{ number_format($forecast60Days) }}</p>
                    <p class="text-[10px] text-slate-500">Estimasi pelunasan termin 2 (wawancara / matching user).</p>
                </div>
                <div class="p-4 rounded-2xl border border-purple-200 bg-purple-50/50 space-y-1">
                    <span class="text-[10px] font-bold text-purple-700 uppercase block">Proyeksi 90 Hari</span>
                    <p class="text-lg font-black text-slate-900">Rp {{ number_format($forecast90Days) }}</p>
                    <p class="text-[10px] text-slate-500">Pelunasan 100% sebelum keberangkatan / terbang.</p>
                </div>
            </div>
        </div>

        <!-- 3. Rincian Pendapatan per Program Pelatihan -->
        <div class="space-y-2 pt-2">
            <div class="border-b border-slate-200 pb-1">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">
                    2. Rincian Omset & Piutang per Program Pelatihan Karir
                </h3>
            </div>
            <table class="w-full text-left text-xs border border-slate-200 rounded-xl overflow-hidden">
                <thead class="bg-slate-900 text-white uppercase text-[10px] font-black tracking-wider">
                    <tr>
                        <th class="py-2.5 px-3">Program Studi</th>
                        <th class="py-2.5 px-3 text-center">Jumlah Siswa</th>
                        <th class="py-2.5 px-3 text-right">Potensi Omset (IDR)</th>
                        <th class="py-2.5 px-3 text-right">Kas Realisasi (IDR)</th>
                        <th class="py-2.5 px-3 text-right">Sisa Piutang (IDR)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($programRevenue as $pr)
                        <tr class="hover:bg-slate-50">
                            <td class="py-2 px-3 font-bold text-slate-800">{{ $pr->program }}</td>
                            <td class="py-2 px-3 text-center font-mono">{{ $pr->student_count }} Siswa</td>
                            <td class="py-2 px-3 text-right font-mono font-semibold">Rp {{ number_format($pr->total_potential) }}</td>
                            <td class="py-2 px-3 text-right font-mono font-bold text-emerald-700">Rp {{ number_format($pr->total_collected) }}</td>
                            <td class="py-2 px-3 text-right font-mono font-bold text-japan-600">Rp {{ number_format($pr->total_outstanding) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-slate-400 italic">Belum ada data keuangan program.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 4. Daftar Piutang Terbesar Siswa (Outstanding Balances) -->
        <div class="space-y-2 pt-2">
            <div class="border-b border-slate-200 pb-1 flex items-center justify-between">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">
                    3. Daftar Piutang Cicilan Siswa Terbesar
                </h3>
                <span class="text-[10px] text-slate-400">Prioritas Penagihan Keuangan</span>
            </div>
            <table class="w-full text-left text-xs border border-slate-200 rounded-xl overflow-hidden">
                <thead class="bg-slate-100 text-slate-700 uppercase text-[10px] font-black tracking-wider">
                    <tr>
                        <th class="py-2 px-3">NIS</th>
                        <th class="py-2 px-3">Nama Siswa</th>
                        <th class="py-2 px-3">Program</th>
                        <th class="py-2 px-3 text-right">Total Biaya</th>
                        <th class="py-2 px-3 text-right">Sudah Bayar</th>
                        <th class="py-2 px-3 text-right">Sisa Tagihan</th>
                        <th class="py-2 px-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($outstandingStudents as $idx => $st)
                        @if($idx < 10)
                            <tr class="hover:bg-slate-50">
                                <td class="py-2 px-3 font-mono text-[11px] font-bold text-slate-700">{{ $st->nis }}</td>
                                <td class="py-2 px-3 font-bold text-slate-900 uppercase">{{ $st->name }}</td>
                                <td class="py-2 px-3 text-slate-600">{{ $st->program }}</td>
                                <td class="py-2 px-3 text-right font-mono text-slate-700">Rp {{ number_format($st->total_cost) }}</td>
                                <td class="py-2 px-3 text-right font-mono text-emerald-700 font-semibold">Rp {{ number_format($st->paid_amount) }}</td>
                                <td class="py-2 px-3 text-right font-mono font-bold text-japan-600">Rp {{ number_format($st->total_cost - $st->paid_amount) }}</td>
                                <td class="py-2 px-3 text-center">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $st->payment_status === 'partial' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ $st->payment_status }}
                                    </span>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-slate-400 italic">Tidak ada piutang aktif. Seluruh siswa telah lunas!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Document Sign-off Footer -->
        <div class="pt-8 flex justify-between items-end text-xs">
            <div class="text-[10px] text-slate-400 max-w-sm">
                * Laporan resmi ini disahkan oleh bendahara dan direksi LPK Sahabat Jepang Indonesia. Seluruh nominal dalam Rupiah (IDR).
            </div>
            <div class="text-center w-56 space-y-12">
                <p class="font-bold text-slate-700">Kepala Bagian Keuangan & Direksi,</p>
                <div>
                    <p class="font-black text-slate-900 uppercase underline underline-offset-2">{{ auth()->user()->name ?? 'Finance Director' }}</p>
                    <p class="text-[10px] text-slate-500">Divisi Keuangan & Perbendaharaan LPK SJI</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
