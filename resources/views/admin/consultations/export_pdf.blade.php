<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Data Calon Siswa (Leads) - LPK Sahabat Jepang Indonesia</title>
    
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
        <a href="{{ route('admin.consultations.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            &larr; Kembali ke Panel Leads
        </a>
        <div class="flex items-center gap-3">
            <span class="text-xs text-slate-500 font-medium">Orientasi cetak optimal: <b>Landscape (A4)</b></span>
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- Official Document Sheet (A4 Landscape) -->
    <div class="max-w-6xl mx-auto bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-slate-200 print-page space-y-5">
        
        <!-- Header Kop Surat Dinamis & Terintegrasi Logo -->
        @include('components.kop-surat', [
            'code' => 'LEADS-' . date('Ymd-Hi'),
            'status' => 'REKAP RESMI',
            'date' => date('d F Y')
        ])

        <!-- Document Title -->
        <div class="text-center py-1">
            <h2 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide underline underline-offset-4">
                LAPORAN DATA KONSULTASI & PENDAFTARAN CALON SISWA (LEADS)
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">
                Total Data: <strong>{{ number_format($consultations->count()) }} Calon Peserta</strong> • Filter: {{ request('status') ? strtoupper(request('status')) : 'SEMUA STATUS' }}
            </p>
        </div>

        <!-- Summary Metric Boxes -->
        <div class="grid grid-cols-4 gap-3 text-center text-xs no-print sm:grid">
            <div class="p-2.5 rounded-xl border border-slate-200 bg-slate-50">
                <span class="text-[10px] text-slate-400 font-bold block uppercase">Total Masuk</span>
                <span class="text-lg font-black text-slate-900">{{ number_format($consultations->count()) }}</span>
            </div>
            <div class="p-2.5 rounded-xl border border-amber-200 bg-amber-50/60">
                <span class="text-[10px] text-amber-700 font-bold block uppercase">Pending Konsultasi</span>
                <span class="text-lg font-black text-amber-800">{{ number_format($consultations->where('status', 'pending')->count()) }}</span>
            </div>
            <div class="p-2.5 rounded-xl border border-blue-200 bg-blue-50/60">
                <span class="text-[10px] text-blue-700 font-bold block uppercase">Sudah Dikontak</span>
                <span class="text-lg font-black text-blue-800">{{ number_format($consultations->where('status', 'contacted')->count()) }}</span>
            </div>
            <div class="p-2.5 rounded-xl border border-emerald-200 bg-emerald-50/60">
                <span class="text-[10px] text-emerald-700 font-bold block uppercase">Resmi Terdaftar</span>
                <span class="text-lg font-black text-emerald-800">{{ number_format($consultations->where('status', 'registered')->count()) }}</span>
            </div>
        </div>

        <!-- Table of Leads -->
        <div class="overflow-x-auto border border-slate-200 rounded-2xl">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white uppercase text-[10px] font-black tracking-wider">
                        <th class="py-2.5 px-3 w-8 text-center">No</th>
                        <th class="py-2.5 px-3">Nama Calon Siswa</th>
                        <th class="py-2.5 px-3">WhatsApp / HP</th>
                        <th class="py-2.5 px-3">Usia / Kota</th>
                        <th class="py-2.5 px-3">Pendidikan</th>
                        <th class="py-2.5 px-3">Program Pilihan</th>
                        <th class="py-2.5 px-3 text-center">Status</th>
                        <th class="py-2.5 px-3">Tgl Daftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-700">
                    @forelse($consultations as $idx => $lead)
                        <tr class="{{ $idx % 2 === 0 ? 'bg-white' : 'bg-slate-50/60' }}">
                            <td class="py-2 px-3 text-center font-mono font-bold text-slate-400">{{ $idx + 1 }}</td>
                            <td class="py-2 px-3 font-bold text-slate-900 uppercase">{{ $lead->name }}</td>
                            <td class="py-2 px-3 font-mono font-semibold">{{ $lead->phone }}</td>
                            <td class="py-2 px-3">{{ $lead->age ? $lead->age . ' Thn' : '-' }} • {{ $lead->city ?: '-' }}</td>
                            <td class="py-2 px-3">{{ $lead->education ?: '-' }}</td>
                            <td class="py-2 px-3 font-semibold text-slate-800">{{ $lead->program }}</td>
                            <td class="py-2 px-3 text-center">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-black uppercase
                                    {{ $lead->status === 'registered' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $lead->status === 'contacted' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $lead->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                    {{ $lead->status === 'cancelled' ? 'bg-slate-100 text-slate-500' : '' }}
                                ">
                                    {{ $lead->status }}
                                </span>
                            </td>
                            <td class="py-2 px-3 text-[11px] text-slate-500 font-mono whitespace-nowrap">{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-6 text-center text-slate-400 italic">Belum ada data pendaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Document Sign-off Footer -->
        <div class="pt-6 flex justify-between items-end text-xs">
            <div class="text-[10px] text-slate-400 max-w-sm">
                * Dokumen ini dibuat otomatis oleh Sistem ERP LPK Sahabat Jepang Indonesia dan sah untuk keperluan verifikasi operasional kantor.
            </div>
            <div class="text-center w-56 space-y-12">
                <p class="font-bold text-slate-700">Dicetak Oleh / Petugas Konselor,</p>
                <div>
                    <p class="font-black text-slate-900 uppercase underline underline-offset-2">{{ auth()->user()->name ?? 'Staff Admin ERP' }}</p>
                    <p class="text-[10px] text-slate-500">Divisi Admisi & Konseling LPK SJI</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
