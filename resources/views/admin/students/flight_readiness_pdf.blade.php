<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Kesiapan Terbang Siswa ke Jepang - {{ $docNumber }}</title>
    
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
                padding: 16px !important;
                max-width: 100% !important;
                border-radius: 0 !important;
                margin: 0 !important;
            }
            tr {
                page-break-inside: avoid;
            }
        }
        @page {
            size: A4 landscape;
            margin: 8mm 10mm;
        }
        .hanko-stamp {
            border: 2px solid #DC2626;
            color: #DC2626;
            transform: rotate(-3deg);
            background: rgba(254, 242, 242, 0.4);
            box-shadow: 0 0 0 1px #DC2626 inset;
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-900 p-4 antialiased">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-[1200px] mx-auto mb-4 flex items-center justify-between no-print bg-white p-3.5 rounded-2xl shadow-sm border border-slate-200">
        <a href="{{ route('admin.flight-readiness.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Flight Readiness Tracker
        </a>
        <div class="flex items-center gap-3">
            <span class="text-xs text-slate-400 font-medium">Format: A4 Landscape</span>
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md flex items-center gap-2 transition hover:scale-105 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Ekspor PDF (A4 Landscape)</span>
            </button>
        </div>
    </div>

    <!-- Printable Sheet (A4 Landscape Format) -->
    <div class="max-w-[1200px] mx-auto bg-white p-6 sm:p-8 rounded-2xl shadow-lg border border-slate-200 print-page space-y-4 relative overflow-hidden">
        
        <!-- Watermark -->
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.02] pointer-events-none select-none">
            <span class="text-9xl font-black">渡航許可確認</span>
        </div>

        <!-- Official Header (KOP Surat) -->
        <div class="border-b-2 border-slate-900 pb-3 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                @if(!empty($settings['site_logo']))
                    <div class="h-14 w-14 rounded-xl bg-white border border-slate-200 p-1 flex items-center justify-center shadow-xs overflow-hidden flex-shrink-0">
                        <img src="{{ $settings['site_logo'] }}" alt="Logo" class="max-h-full max-w-full object-contain">
                    </div>
                @else
                    <div class="h-14 w-14 rounded-xl bg-red-600 text-white flex flex-col items-center justify-center font-black shadow-xs flex-shrink-0">
                        <span class="text-lg leading-none">日</span>
                        <span class="text-[8px] tracking-tighter uppercase font-bold mt-0.5">SJI</span>
                    </div>
                @endif
                <div>
                    <h1 class="text-base font-black text-slate-900 tracking-tight uppercase leading-none">
                        {{ $settings['site_title'] ?? 'LPK SAHABAT JEPANG INDONESIA' }}
                    </h1>
                    <p class="text-[10px] font-bold text-red-600 uppercase tracking-widest mt-1">
                        Sending Organization (SO) Kemenaker RI • Izin Penyelenggaraan Pemagangan Luar Negeri
                    </p>
                    <p class="text-[9px] text-slate-500 mt-0.5">
                        {{ $settings['contact_address'] ?? 'Jl. Raya Pendidikan No. 88, Jakarta Selatan, Indonesia' }} • Telp: {{ $settings['contact_phone'] ?? '0812-3456-7890' }} • Email: {{ $settings['contact_email'] ?? 'dokumen@sahabatjepang.co.id' }}
                    </p>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-block px-2.5 py-1 rounded bg-slate-100 border border-slate-200 text-[9px] font-mono font-bold text-slate-700">
                    {{ $docNumber }}
                </span>
                <p class="text-[9px] text-slate-500 mt-1">
                    Tanggal Cetak: <strong class="text-slate-800">{{ now()->translatedFormat('d F Y - H:i') }} WIB</strong>
                </p>
            </div>
        </div>

        <!-- Document Title & Stats Banner -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-2">
            <div>
                <h2 class="text-sm font-black text-slate-900 uppercase tracking-tight flex items-center gap-2">
                    <span>DAFTAR VERIFIKASI KESIAPAN KEBERANGKATAN SISWA (FLIGHT READINESS DOSSIER)</span>
                    <span class="text-[10px] text-red-600 font-bold font-mono">渡航前書類確認一覧表</span>
                </h2>
                <p class="text-[10px] text-slate-500">
                    Monitoring pemenuhan 8 berkas primer, paspor, medical check-up (MCU), CoE, dan visa kerja Republik Indonesia - Jepang.
                </p>
            </div>
            
            <!-- Quick Stats -->
            <div class="flex items-center gap-2 text-[10px] font-bold flex-wrap">
                <span class="px-2 py-1 rounded bg-slate-100 text-slate-700 border border-slate-200">
                    Total: <strong class="text-slate-900">{{ $students->count() }}</strong> Siswa
                </span>
                <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Siap Terbang: <strong>{{ $students->filter(fn($s) => !empty($s->document_passport) && !empty($s->document_coe_visa) && $s->mcu_result === 'fit')->count() }}</strong>
                </span>
                <span class="px-2 py-1 rounded bg-blue-50 text-blue-700 border border-blue-200">
                    Proses Visa: <strong>{{ $students->filter(fn($s) => !empty($s->coe_number) && empty($s->visa_number))->count() }}</strong>
                </span>
                <span class="px-2 py-1 rounded bg-amber-50 text-amber-700 border border-amber-200">
                    Tunggu CoE: <strong>{{ $students->filter(fn($s) => in_array($s->status, ['passed_interview', 'matched']) && empty($s->coe_number))->count() }}</strong>
                </span>
            </div>
        </div>

        <!-- Table Candidates -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-[9.5px]">
                <thead>
                    <tr class="bg-slate-900 text-white uppercase tracking-wider font-extrabold">
                        <th class="py-2 px-2 text-center w-7 border-r border-slate-800">No</th>
                        <th class="py-2 px-2.5 border-r border-slate-800">Siswa & NIS</th>
                        <th class="py-2 px-2.5 border-r border-slate-800">Program / Job</th>
                        <th class="py-2 px-2.5 border-r border-slate-800">Kaisha & Prefektur</th>
                        <th class="py-2 px-2 text-center border-r border-slate-800">Paspor RI</th>
                        <th class="py-2 px-2 text-center border-r border-slate-800">MCU Fit</th>
                        <th class="py-2 px-2 text-center border-r border-slate-800">CoE Jepang</th>
                        <th class="py-2 px-2 text-center border-r border-slate-800">Visa Kerja</th>
                        <th class="py-2 px-2 text-center border-r border-slate-800">8 Berkas</th>
                        <th class="py-2 px-2 text-center border-r border-slate-800">Tgl Terbang</th>
                        <th class="py-2 px-2 text-center">Status Kelayakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 border border-slate-200">
                    @forelse($students as $idx => $student)
                        @php
                            $docs = [
                                'KTP' => !empty($student->document_ktp),
                                'KK' => !empty($student->document_kk),
                                'Ijazah' => !empty($student->document_ijazah),
                                'Paspor' => !empty($student->document_passport),
                                'N5/N4' => !empty($student->document_certificate),
                                'SSW' => !empty($student->document_ssw),
                                'MCU' => !empty($student->document_mcu),
                                'CoE/Visa' => !empty($student->document_coe_visa),
                            ];
                            $completedCount = count(array_filter($docs));
                            $isReadyToFly = !empty($student->document_passport) && !empty($student->document_coe_visa) && $student->mcu_result === 'fit';
                            $isWaitingVisa = !empty($student->coe_number) && empty($student->visa_number);
                            $isWaitingCoe = in_array($student->status, ['passed_interview', 'matched']) && empty($student->coe_number);
                        @endphp
                        <tr class="hover:bg-slate-50 {{ $loop->even ? 'bg-slate-50/40' : 'bg-white' }}">
                            <td class="py-1.5 px-2 text-center font-bold text-slate-500 border-r border-slate-200">
                                {{ $idx + 1 }}
                            </td>
                            <td class="py-1.5 px-2.5 border-r border-slate-200">
                                <div class="font-bold text-slate-900 leading-tight">{{ $student->name }}</div>
                                <div class="text-[8px] font-mono text-slate-500">{{ $student->nis }}</div>
                            </td>
                            <td class="py-1.5 px-2.5 border-r border-slate-200">
                                <span class="font-semibold text-slate-800">{{ $student->program ?? 'Magang' }}</span>
                                @if($student->job_category)
                                    <div class="text-[8px] text-slate-500">{{ $student->job_category }}</div>
                                @endif
                            </td>
                            <td class="py-1.5 px-2.5 border-r border-slate-200">
                                <div class="font-semibold text-slate-900 leading-tight">{{ $student->destination_company ?: '-' }}</div>
                                <div class="text-[8px] font-bold text-red-600">{{ $student->destination_prefecture ?: '-' }}</div>
                            </td>
                            
                            <!-- Paspor -->
                            <td class="py-1.5 px-2 text-center border-r border-slate-200">
                                @if($student->passport_number)
                                    <span class="font-mono font-bold text-slate-800 block">{{ $student->passport_number }}</span>
                                    <span class="text-[7.5px] {{ !empty($student->document_passport) ? 'text-emerald-600 font-bold' : 'text-amber-600' }}">
                                        {{ !empty($student->document_passport) ? '✓ Terlampir' : '⚠️ No Doc' }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Belum Ada</span>
                                @endif
                            </td>

                            <!-- MCU -->
                            <td class="py-1.5 px-2 text-center border-r border-slate-200">
                                @if($student->mcu_result === 'fit')
                                    <span class="inline-block px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-extrabold text-[8px]">FIT</span>
                                @elseif($student->mcu_result === 'unfit')
                                    <span class="inline-block px-1.5 py-0.5 rounded bg-red-100 text-red-800 font-extrabold text-[8px]">UNFIT</span>
                                @elseif($student->mcu_result === 'follow_up')
                                    <span class="inline-block px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 font-extrabold text-[8px]">PND/FU</span>
                                @else
                                    <span class="text-slate-400 italic">-</span>
                                @endif
                            </td>

                            <!-- CoE -->
                            <td class="py-1.5 px-2 text-center border-r border-slate-200">
                                @if($student->coe_number)
                                    <span class="font-mono font-bold text-slate-800 text-[8px] block">{{ $student->coe_number }}</span>
                                    <span class="text-[7.5px] text-emerald-600 font-bold">✓ Terbit</span>
                                @else
                                    <span class="text-slate-400 italic">Proses</span>
                                @endif
                            </td>

                            <!-- Visa -->
                            <td class="py-1.5 px-2 text-center border-r border-slate-200">
                                @if($student->visa_number)
                                    <span class="font-mono font-bold text-slate-800 text-[8px] block">{{ $student->visa_number }}</span>
                                    <span class="text-[7.5px] text-emerald-600 font-bold">✓ Granted</span>
                                @else
                                    <span class="text-slate-400 italic">-</span>
                                @endif
                            </td>

                            <!-- 8 Berkas Progress -->
                            <td class="py-1.5 px-2 text-center border-r border-slate-200">
                                <span class="font-mono font-black {{ $completedCount === 8 ? 'text-emerald-700' : ($completedCount >= 5 ? 'text-blue-700' : 'text-amber-700') }}">
                                    {{ $completedCount }}/8
                                </span>
                                <div class="text-[7.5px] text-slate-400 font-mono mt-0.5">
                                    {{ round(($completedCount / 8) * 100) }}%
                                </div>
                            </td>

                            <!-- Tgl Terbang -->
                            <td class="py-1.5 px-2 text-center border-r border-slate-200 font-mono text-[8.5px]">
                                @if($student->departure_date)
                                    <strong class="text-slate-900">{{ \Carbon\Carbon::parse($student->departure_date)->format('d/m/Y') }}</strong>
                                @else
                                    <span class="text-slate-400 italic">TBA</span>
                                @endif
                            </td>

                            <!-- Status Badge -->
                            <td class="py-1.5 px-2 text-center">
                                @if($isReadyToFly)
                                    <span class="inline-block px-2 py-0.5 rounded bg-emerald-600 text-white font-black text-[8px] tracking-wide">
                                        READY TO FLY ✈️
                                    </span>
                                @elseif($isWaitingVisa)
                                    <span class="inline-block px-2 py-0.5 rounded bg-blue-100 text-blue-800 font-bold text-[8px]">
                                        WAITING VISA 🛂
                                    </span>
                                @elseif($isWaitingCoe)
                                    <span class="inline-block px-2 py-0.5 rounded bg-amber-100 text-amber-800 font-bold text-[8px]">
                                        WAITING COE ⏳
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium text-[8px]">
                                        PRE-DEPARTURE
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="py-6 text-center text-slate-400 italic">
                                Tidak ada data siswa yang cocok dengan kriteria filter saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footnote & Verification Notes -->
        <div class="grid grid-cols-2 gap-4 text-[9px] text-slate-500 border-t border-slate-200 pt-3">
            <div>
                <p class="font-bold text-slate-800 mb-1">Catatan Verifikasi SO Kemenaker:</p>
                <ul class="list-disc pl-4 space-y-0.5 leading-relaxed">
                    <li>Kandidat bertanda <strong class="text-emerald-700">READY TO FLY</strong> telah memenuhi syarat fisik, administrasi, dan dokumen izin tinggal sesuai standar OTIT/JITCO Jepang.</li>
                    <li>Tiket penerbangan hanya dapat diterbitkan setelah fisik Visa Kerja & E-KTKLN (BP2MI) diverifikasi oleh Divisi Keberangkatan.</li>
                </ul>
            </div>
            <div>
                <p class="font-bold text-slate-800 mb-1">Keterangan 8 Dokumen Primer:</p>
                <p class="leading-relaxed">
                    1. KTP Siswa • 2. Kartu Keluarga • 3. Ijazah Terakhir • 4. Paspor RI (Min. 12 bln) • 5. Sertifikat Bahasa (JLPT/JFT) • 6. SSW / Senmonkyuu • 7. Hasil MCU Fit to Fly • 8. CoE & Visa Kerja.
                </p>
            </div>
        </div>

        <!-- Official Signatures & Hanko Stamp -->
        <div class="pt-4 border-t border-slate-200 grid grid-cols-3 gap-6 text-center">
            <div>
                <p class="text-[9.5px] font-bold text-slate-600">Disiapkan & Diverifikasi Oleh:</p>
                <p class="text-[8.5px] text-slate-400">Koordinator Visa & Dokumen</p>
                <div class="h-16 flex items-center justify-center">
                    <span class="font-mono text-slate-300 text-[10px] italic">[ Tanda Tangan Digital ]</span>
                </div>
                <p class="text-[10px] font-bold text-slate-900 underline">{{ auth()->user()->name ?? 'Admin Dokumen SJI' }}</p>
                <p class="text-[8.5px] text-slate-500">Staf Divisi Penempatan Luar Negeri</p>
            </div>

            <div>
                <p class="text-[9.5px] font-bold text-slate-600">Diketahui & Disetujui Oleh:</p>
                <p class="text-[8.5px] text-slate-400">Kepala Bagian Operasional SO</p>
                <div class="h-16 flex items-center justify-center">
                    <span class="font-mono text-slate-300 text-[10px] italic">[ Tanda Tangan Digital ]</span>
                </div>
                <p class="text-[10px] font-bold text-slate-900 underline">Agus Pratama, S.Pd., M.Ed.</p>
                <p class="text-[8.5px] text-slate-500">NIP. SJI-2018-0042</p>
            </div>

            <div class="relative">
                <p class="text-[9.5px] font-bold text-slate-600">Pengesahan Institusi:</p>
                <p class="text-[8.5px] text-slate-400">Direktur Utama LPK SJI</p>
                <div class="h-16 flex items-center justify-center relative">
                    <!-- Hanko Inkan Stamp -->
                    <div class="h-14 w-14 rounded-full hanko-stamp flex flex-col items-center justify-center select-none font-serif">
                        <span class="text-[8px] font-bold tracking-widest leading-tight text-red-600">株式会社</span>
                        <span class="text-[11px] font-black leading-tight text-red-600">SJI印</span>
                        <span class="text-[7.5px] font-bold text-red-600">理事長</span>
                    </div>
                </div>
                <p class="text-[10px] font-black text-slate-900 underline">Direktur Utama LPK SJI</p>
                <p class="text-[8.5px] text-slate-500">Badan Penyelenggara Pemagangan Resmi</p>
            </div>
        </div>

    </div>

</body>
</html>
