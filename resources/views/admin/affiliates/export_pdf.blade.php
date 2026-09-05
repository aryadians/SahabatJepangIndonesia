<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Kemitraan SMK & BKK - LPK Sahabat Jepang Indonesia</title>
    
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
        <a href="{{ route('admin.affiliates.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            &larr; Kembali ke Panel Kemitraan SMK & BKK
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Simpan PDF</span>
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
                    Dokumen Resmi Eksekutif
                </div>
                <p class="text-xs font-bold text-slate-800">Rekapitulasi Kemitraan SMK & BKK</p>
                <p class="text-[10px] text-slate-500 font-mono">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- 3 Executive Summary Cards -->
        <div class="grid grid-cols-3 gap-4">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Total Mitra Kerjasama</span>
                <h3 class="text-xl font-black text-slate-900 mt-1">{{ number_format($totalAffiliates) }} Lembaga</h3>
                <p class="text-[10px] text-slate-400">SMK, BKK, Poltekkes & Komunitas</p>
            </div>
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200">
                <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Total Siswa Rujukan</span>
                <h3 class="text-xl font-black text-emerald-800 mt-1">{{ number_format($totalStudents) }} Siswa</h3>
                <p class="text-[10px] text-emerald-600 font-medium">Siswa terdaftar melalui referral mitra</p>
            </div>
            <div class="p-4 rounded-xl bg-blue-50 border border-blue-200">
                <span class="text-[10px] font-bold text-blue-700 uppercase tracking-wider">Total Akumulasi Komisi</span>
                <h3 class="text-xl font-black text-blue-800 mt-1">Rp {{ number_format($totalCommission) }}</h3>
                <p class="text-[10px] text-blue-600 font-medium">Insentif keberhasilan penyaluran karir</p>
            </div>
        </div>

        <!-- Table of Partners -->
        <div class="border border-slate-200 rounded-xl overflow-hidden">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-200 text-slate-600 text-[10px] uppercase font-black">
                        <th class="py-2.5 px-3">No</th>
                        <th class="py-2.5 px-3">Kode Ref</th>
                        <th class="py-2.5 px-3">Instansi / SMK / BKK</th>
                        <th class="py-2.5 px-3">Koordinator</th>
                        <th class="py-2.5 px-3">Kategori</th>
                        <th class="py-2.5 px-3">WhatsApp</th>
                        <th class="py-2.5 px-3 text-center">Leads</th>
                        <th class="py-2.5 px-3 text-center">Siswa</th>
                        <th class="py-2.5 px-3 text-right">Insentif/Siswa</th>
                        <th class="py-2.5 px-3 text-right">Total Komisi</th>
                        <th class="py-2.5 px-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($affiliates as $idx => $a)
                        <tr class="hover:bg-slate-50">
                            <td class="py-2 px-3 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                            <td class="py-2 px-3 font-mono font-bold text-indigo-700">{{ $a->code }}</td>
                            <td class="py-2 px-3 font-bold text-slate-900">{{ $a->institution_name ?: '-' }}</td>
                            <td class="py-2 px-3 text-slate-700">{{ $a->name }}</td>
                            <td class="py-2 px-3 text-slate-600">{{ $a->type_label }}</td>
                            <td class="py-2 px-3 font-mono text-slate-600">{{ $a->phone }}</td>
                            <td class="py-2 px-3 text-center font-bold text-slate-600">{{ $a->consultations_count }}</td>
                            <td class="py-2 px-3 text-center font-black text-emerald-700">{{ $a->students_count }}</td>
                            <td class="py-2 px-3 text-right font-mono text-slate-600">Rp {{ number_format($a->reward_per_lead) }}</td>
                            <td class="py-2 px-3 text-right font-mono font-black text-slate-900">Rp {{ number_format($a->total_reward_earned) }}</td>
                            <td class="py-2 px-3 text-center">
                                <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ $a->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $a->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="py-8 text-center text-slate-400 text-xs italic">Belum ada data kemitraan SMK/BKK terdata.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Official Signatures -->
        <div class="pt-6 grid grid-cols-2 gap-8 text-center text-xs">
            <div class="space-y-16">
                <p class="font-bold text-slate-600">Kepala Bagian Kerjasama & BKK</p>
                <div>
                    <p class="font-bold text-slate-900 underline">Koordinator Hubungan Industri</p>
                    <p class="text-[10px] text-slate-400 font-mono">Divisi Kemitraan SMK & Perguruan Tinggi</p>
                </div>
            </div>
            <div class="space-y-16">
                <p class="font-bold text-slate-600">Mengetahui, Direktur Utama LPK</p>
                <div>
                    <p class="font-bold text-slate-900 underline">Pimpinan LPK Sahabat Jepang Indonesia</p>
                    <p class="text-[10px] text-slate-400 font-mono">SO Kemenaker RI KEP.224/LATTAS/XII/2023</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
