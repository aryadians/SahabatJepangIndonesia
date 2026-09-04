<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Dewan Pengajar & Sensei - LPK Sahabat Jepang Indonesia</title>
    
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
        <a href="{{ route('admin.teachers.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            &larr; Kembali ke Data Sensei
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
            'code' => 'TEACHER-ROSTER-' . date('Ym'),
            'status' => 'DEWAN PENGAJAR',
            'date' => date('d F Y')
        ])

        <!-- Document Title -->
        <div class="text-center py-1">
            <h2 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide underline underline-offset-4">
                DAFTAR RESMI DEWAN PENGAJAR & SENSEI BAHASA JEPANG
            </h2>
            <p class="text-xs text-slate-500 mt-0.5 font-japanese">日本語教師・指導員名簿シート</p>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-3 gap-3 text-center text-xs">
            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200">
                <span class="text-[10px] text-slate-400 font-bold block uppercase">Total Tenaga Pengajar</span>
                <span class="text-lg font-black text-slate-900 block mt-0.5">{{ number_format($teachers->count()) }} Orang</span>
            </div>
            <div class="p-3 rounded-2xl bg-emerald-50 border border-emerald-200">
                <span class="text-[10px] text-emerald-700 font-bold block uppercase">Aktif Mengajar</span>
                <span class="text-lg font-black text-emerald-700 block mt-0.5">{{ number_format($teachers->where('status', 'active')->count()) }} Orang</span>
            </div>
            <div class="p-3 rounded-2xl bg-red-50 border border-red-200">
                <span class="text-[10px] text-japan-600 font-bold block uppercase">Kualifikasi JLPT N1 / Native</span>
                <span class="text-lg font-black text-japan-600 block mt-0.5">{{ number_format($teachers->filter(fn($t) => str_contains($t->jlpt_level, 'N1') || str_contains($t->jlpt_level, 'Native'))->count()) }} Orang</span>
            </div>
        </div>

        <!-- Teachers Table -->
        <div class="overflow-x-auto border border-slate-200 rounded-2xl">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white uppercase text-[10px] font-black tracking-wider">
                        <th class="py-2.5 px-3 text-center w-8">No</th>
                        <th class="py-2.5 px-3">NIP</th>
                        <th class="py-2.5 px-3">Nama Sensei</th>
                        <th class="py-2.5 px-3">Level JLPT</th>
                        <th class="py-2.5 px-3">Spesialisasi Mengajar</th>
                        <th class="py-2.5 px-3">Pengalaman Jepang</th>
                        <th class="py-2.5 px-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-700">
                    @forelse($teachers as $idx => $tc)
                        <tr class="{{ $idx % 2 === 0 ? 'bg-white' : 'bg-slate-50/60' }}">
                            <td class="py-2.5 px-3 text-center font-mono font-bold text-slate-400">{{ $idx + 1 }}</td>
                            <td class="py-2.5 px-3 font-mono font-bold text-slate-900">{{ $tc->nip }}</td>
                            <td class="py-2.5 px-3">
                                <p class="font-black text-slate-900 uppercase">{{ $tc->name }}</p>
                                @if($tc->romaji_name)
                                    <p class="text-[10px] text-japan-600 font-japanese">{{ $tc->romaji_name }}</p>
                                @endif
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $tc->phone ?: '-' }}</p>
                            </td>
                            <td class="py-2.5 px-3">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-black bg-red-100 text-red-800 border border-red-200">
                                    {{ $tc->jlpt_level }}
                                </span>
                            </td>
                            <td class="py-2.5 px-3 font-medium text-slate-800">{{ $tc->specialization }}</td>
                            <td class="py-2.5 px-3 text-slate-600">{{ $tc->japan_experience ?: 'Lulusan S1 Sastra Jepang' }}</td>
                            <td class="py-2.5 px-3 text-center">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-black uppercase {{ $tc->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $tc->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-slate-400 italic">Belum ada data tenaga pengajar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Document Sign-off Footer -->
        <div class="pt-8 flex justify-between items-end text-xs">
            <div class="text-[10px] text-slate-400 max-w-sm">
                * Dokumen resmi pengajar LPK Sahabat Jepang Indonesia terdaftar di sistem akreditasi Kemnaker RI LA-LPK.
            </div>
            <div class="text-center w-56 space-y-12">
                <p class="font-bold text-slate-700">Direktur Lembaga Pelatihan,</p>
                <div>
                    <p class="font-black text-slate-900 uppercase underline underline-offset-2">{{ auth()->user()->name ?? 'Kepala LPK SJI' }}</p>
                    <p class="text-[10px] text-slate-500">Pimpinan Lembaga & Sending Organization</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
