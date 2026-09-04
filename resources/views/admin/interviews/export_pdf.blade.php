<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Riwayat & Agenda Wawancara Kaisha - LPK Sahabat Jepang Indonesia</title>
    
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
            .interview-block {
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
        <a href="{{ route('admin.interviews.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            &larr; Kembali ke Agenda Wawancara
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
            'code' => 'INTERVIEW-REPORT-' . date('Ymd'),
            'status' => 'LAPORAN USER',
            'date' => date('d F Y')
        ])

        <!-- Document Title -->
        <div class="text-center py-1">
            <h2 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide underline underline-offset-4">
                LAPORAN RIWAYAT WAWANCARA KERJA KAISHA & JOB MATCHING
            </h2>
            <p class="text-xs text-slate-500 mt-0.5 font-japanese">面接履歴・企業マッチング選考結果シート</p>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-4 gap-3 text-center text-xs">
            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200">
                <span class="text-[10px] text-slate-400 font-bold block uppercase">Total Agenda</span>
                <span class="text-lg font-black text-slate-900 block mt-0.5">{{ number_format($interviews->count()) }} Sesi</span>
            </div>
            <div class="p-3 rounded-2xl bg-blue-50 border border-blue-200">
                <span class="text-[10px] text-blue-700 font-bold block uppercase">Terjadwal</span>
                <span class="text-lg font-black text-blue-800 block mt-0.5">{{ number_format($interviews->where('status', 'scheduled')->count()) }} Sesi</span>
            </div>
            <div class="p-3 rounded-2xl bg-purple-50 border border-purple-200">
                <span class="text-[10px] text-purple-700 font-bold block uppercase">Kandidat Terdaftar</span>
                <span class="text-lg font-black text-purple-800 block mt-0.5">{{ number_format($totalCandidates) }} Orang</span>
            </div>
            <div class="p-3 rounded-2xl bg-emerald-50 border border-emerald-200">
                <span class="text-[10px] text-emerald-700 font-bold block uppercase">Lolos Seleksi User</span>
                <span class="text-lg font-black text-emerald-800 block mt-0.5">{{ number_format($passedCandidates) }} Orang</span>
            </div>
        </div>

        <!-- Interviews & Candidates List -->
        <div class="space-y-6 pt-2">
            @forelse($interviews as $idx => $it)
                <div class="interview-block border border-slate-200 rounded-2xl p-4 bg-white space-y-3">
                    
                    <!-- Header Info Kaisha -->
                    <div class="flex items-start justify-between border-b border-slate-100 pb-2.5">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-red-100 text-red-700 text-xs font-black flex items-center justify-center font-mono">
                                    {{ $idx + 1 }}
                                </span>
                                <h3 class="text-sm font-black text-slate-900 uppercase">
                                    {{ $it->company_name }}
                                </h3>
                                @if($it->japanese_company_name)
                                    <span class="text-xs text-japan-600 font-japanese font-bold">
                                        ({{ $it->japanese_company_name }})
                                    </span>
                                @endif
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1 flex items-center gap-2">
                                <span>Prefektur: <b>{{ $it->prefecture }}</b></span>
                                <span>•</span>
                                <span>Sektor: <b>{{ $it->sector }}</b></span>
                                <span>•</span>
                                <span>Gaji: <b>{{ $it->salary_range ?: 'Standar UMR' }}</b></span>
                            </p>
                        </div>

                        <div class="text-right">
                            <span class="inline-block px-2.5 py-0.5 rounded text-[10px] font-black uppercase border
                                {{ $it->status === 'completed' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : '' }}
                                {{ $it->status === 'scheduled' ? 'bg-blue-100 text-blue-800 border-blue-200' : '' }}
                                {{ $it->status === 'ongoing' ? 'bg-amber-100 text-amber-800 border-amber-200' : '' }}
                                {{ $it->status === 'cancelled' ? 'bg-rose-100 text-rose-800 border-rose-200' : '' }}
                            ">
                                {{ $it->status }}
                            </span>
                            <p class="text-[11px] font-mono font-bold text-slate-800 mt-1">
                                {{ $it->interview_date->format('d/m/Y H:i') }} WIB
                            </p>
                        </div>
                    </div>

                    <!-- Candidates in this Interview -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border border-slate-100 rounded-xl overflow-hidden">
                            <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold">
                                <tr>
                                    <th class="py-2 px-3">NIS</th>
                                    <th class="py-2 px-3">Nama Siswa Kandidat</th>
                                    <th class="py-2 px-3">Level Bahasa</th>
                                    <th class="py-2 px-3 text-center">Hasil Seleksi</th>
                                    <th class="py-2 px-3 text-center">Skor / Nilai</th>
                                    <th class="py-2 px-3">Feedback Pewawancara</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @forelse($it->candidates as $c)
                                    <tr>
                                        <td class="py-1.5 px-3 font-mono text-[11px]">{{ $c->student->nis ?? '-' }}</td>
                                        <td class="py-1.5 px-3 font-bold text-slate-900 uppercase">{{ $c->student->name ?? 'Siswa' }}</td>
                                        <td class="py-1.5 px-3">{{ $c->student->japanese_level ?? '-' }}</td>
                                        <td class="py-1.5 px-3 text-center">
                                            <span class="inline-block px-2 py-0.5 rounded text-[9px] font-black uppercase
                                                {{ $c->result === 'passed' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                                {{ $c->result === 'failed' ? 'bg-rose-100 text-rose-800' : '' }}
                                                {{ $c->result === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                                {{ $c->result === 'rescheduled' ? 'bg-purple-100 text-purple-800' : '' }}
                                            ">
                                                {{ $c->result }}
                                            </span>
                                        </td>
                                        <td class="py-1.5 px-3 text-center font-mono font-bold">{{ $c->interview_score ? $c->interview_score . '/100' : '-' }}</td>
                                        <td class="py-1.5 px-3 text-[11px] text-slate-500 italic">{{ $c->interviewer_feedback ?: 'Belum ada catatan evaluasi.' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-2.5 px-3 text-center text-slate-400 italic">Belum ada kandidat siswa yang dimatchingkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            @empty
                <div class="text-center py-8 text-slate-400 italic">
                    Belum ada data wawancara kerja yang tercatat.
                </div>
            @endforelse
        </div>

        <!-- Document Sign-off Footer -->
        <div class="pt-8 flex justify-between items-end text-xs">
            <div class="text-[10px] text-slate-400 max-w-sm">
                * Dokumen riwayat wawancara ini resmi dikeluarkan oleh divisi Job Matching Kaisha LPK Sahabat Jepang Indonesia.
            </div>
            <div class="text-center w-56 space-y-12">
                <p class="font-bold text-slate-700">Koordinator Job Matching Kaisha,</p>
                <div>
                    <p class="font-black text-slate-900 uppercase underline underline-offset-2">{{ auth()->user()->name ?? 'Job Matching Lead' }}</p>
                    <p class="text-[10px] text-slate-500">Divisi Hubungan Industri Jepang LPK SJI</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
