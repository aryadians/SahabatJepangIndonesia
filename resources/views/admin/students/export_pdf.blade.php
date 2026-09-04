<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Rekapitulasi Data Siswa Pelatihan - LPK Sahabat Jepang Indonesia</title>
    
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
    <div class="max-w-7xl mx-auto mb-6 flex items-center justify-between no-print bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
        <a href="{{ route('admin.students.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            &larr; Kembali ke Data Siswa
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
    <div class="max-w-7xl mx-auto bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-slate-200 print-page space-y-5">
        
        <!-- Header Kop Surat Dinamis & Terintegrasi Logo -->
        @include('components.kop-surat', [
            'code' => 'STUDENT-ROSTER-' . date('Ymd-Hi'),
            'status' => 'BUKU INDUK SISWA',
            'date' => date('d F Y')
        ])

        <!-- Document Title -->
        <div class="text-center py-1">
            <h2 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide underline underline-offset-4">
                REKAPITULASI BUKU INDUK SISWA PELATIHAN KERJA & MAGANG JEPANG
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">
                Total Siswa Terdata: <strong>{{ number_format($students->count()) }} Orang</strong> • Filter Terpilih: {{ request('program') ? strtoupper(request('program')) : 'SEMUA PROGRAM' }}
            </p>
        </div>

        <!-- Metric Summary Chips -->
        <div class="grid grid-cols-5 gap-3 text-center text-xs no-print sm:grid">
            <div class="p-2.5 rounded-xl border border-slate-200 bg-slate-50">
                <span class="text-[10px] text-slate-400 font-bold block uppercase">Total Siswa</span>
                <span class="text-lg font-black text-slate-900">{{ number_format($students->count()) }}</span>
            </div>
            <div class="p-2.5 rounded-xl border border-blue-200 bg-blue-50/60">
                <span class="text-[10px] text-blue-700 font-bold block uppercase">Aktif Belajar</span>
                <span class="text-lg font-black text-blue-800">{{ number_format($students->where('status', 'active')->count()) }}</span>
            </div>
            <div class="p-2.5 rounded-xl border border-amber-200 bg-amber-50/60">
                <span class="text-[10px] text-amber-700 font-bold block uppercase">Lolos User (Tunggu CoE)</span>
                <span class="text-lg font-black text-amber-800">{{ number_format($students->where('status', 'passed_interview')->count()) }}</span>
            </div>
            <div class="p-2.5 rounded-xl border border-emerald-200 bg-emerald-50/60">
                <span class="text-[10px] text-emerald-700 font-bold block uppercase">Sudah Terbang</span>
                <span class="text-lg font-black text-emerald-800">{{ number_format($students->where('status', 'departed')->count()) }}</span>
            </div>
            <div class="p-2.5 rounded-xl border border-purple-200 bg-purple-50/60">
                <span class="text-[10px] text-purple-700 font-bold block uppercase">Lunas Biaya</span>
                <span class="text-lg font-black text-purple-800">{{ number_format($students->where('payment_status', 'paid')->count()) }}</span>
            </div>
        </div>

        <!-- Student Data Table -->
        <div class="overflow-x-auto border border-slate-200 rounded-2xl">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white uppercase text-[10px] font-black tracking-wider">
                        <th class="py-2.5 px-3 text-center w-8">No</th>
                        <th class="py-2.5 px-3">NIS</th>
                        <th class="py-2.5 px-3">Nama Lengkap & Katakana</th>
                        <th class="py-2.5 px-3">Gender / Usia</th>
                        <th class="py-2.5 px-3">WhatsApp / HP</th>
                        <th class="py-2.5 px-3">Program & Sektor</th>
                        <th class="py-2.5 px-3">Penempatan Jepang</th>
                        <th class="py-2.5 px-3 text-center">Status Pelatihan</th>
                        <th class="py-2.5 px-3 text-right">Sisa Biaya</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-700">
                    @forelse($students as $idx => $st)
                        <tr class="{{ $idx % 2 === 0 ? 'bg-white' : 'bg-slate-50/60' }}">
                            <td class="py-2 px-3 text-center font-mono font-bold text-slate-400">{{ $idx + 1 }}</td>
                            <td class="py-2 px-3 font-mono font-bold text-slate-900">{{ $st->nis }}</td>
                            <td class="py-2 px-3">
                                <p class="font-bold text-slate-900 uppercase">{{ $st->name }}</p>
                                @if($st->japanese_name)
                                    <p class="text-[10px] text-japan-600 font-japanese">{{ $st->japanese_name }}</p>
                                @endif
                            </td>
                            <td class="py-2 px-3">{{ $st->gender }} • {{ $st->birth_date ? $st->birth_date->age . ' Thn' : '-' }}</td>
                            <td class="py-2 px-3 font-mono text-[11px]">{{ $st->phone ?: '-' }}</td>
                            <td class="py-2 px-3">
                                <p class="font-bold text-slate-800">{{ $st->program }}</p>
                                <p class="text-[10px] text-slate-500">{{ $st->sector ?: '-' }}</p>
                            </td>
                            <td class="py-2 px-3">
                                @if($st->destination_company || $st->destination_prefecture)
                                    <p class="font-bold text-slate-900">{{ $st->destination_company ?: '-' }}</p>
                                    <p class="text-[10px] text-japan-600 font-semibold">{{ $st->destination_prefecture ?: '' }}</p>
                                @else
                                    <span class="text-slate-400 italic">Matching proses</span>
                                @endif
                            </td>
                            <td class="py-2 px-3 text-center">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-black uppercase
                                    {{ $st->status === 'departed' || $st->status === 'graduated' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $st->status === 'passed_interview' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $st->status === 'interview' ? 'bg-amber-100 text-amber-800' : '' }}
                                    {{ $st->status === 'active' ? 'bg-slate-100 text-slate-700' : '' }}
                                ">
                                    {{ str_replace('_', ' ', $st->status) }}
                                </span>
                            </td>
                            <td class="py-2 px-3 text-right font-mono font-bold {{ ($st->total_cost - $st->paid_amount) > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                {{ ($st->total_cost - $st->paid_amount) > 0 ? 'Rp ' . number_format($st->total_cost - $st->paid_amount) : 'LUNAS' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-6 text-center text-slate-400 italic">Belum ada data siswa yang cocok dengan kriteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Document Sign-off Footer -->
        <div class="pt-6 flex justify-between items-end text-xs">
            <div class="text-[10px] text-slate-400 max-w-sm">
                * Rekapitulasi resmi database siswa LPK Sahabat Jepang Indonesia terdaftar di sistem ERP dan Kemenaker RI.
            </div>
            <div class="text-center w-56 space-y-12">
                <p class="font-bold text-slate-700">Kepala Bagian Akademik & Kesiswaan,</p>
                <div>
                    <p class="font-black text-slate-900 uppercase underline underline-offset-2">{{ auth()->user()->name ?? 'Sensei Koordinator' }}</p>
                    <p class="text-[10px] text-slate-500">Divisi Pelatihan Bahasa & Budaya Jepang</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
