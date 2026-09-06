<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Kesiapan Terbang & Dokumen Siswa ke Jepang - {{ $student ? $student->name : 'LPK Sahabat Jepang Indonesia' }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Noto+Sans+JP:wght@400;700;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .font-japanese {
            font-family: 'Noto Sans JP', sans-serif;
        }
        .perspective-1000 {
            perspective: 1000px;
        }
        @keyframes hankoFloat {
            0%, 100% { transform: rotate(-5deg) scale(1); }
            50% { transform: rotate(-8deg) scale(1.04); }
        }
        .animate-hanko-float {
            animation: hankoFloat 4s ease-in-out infinite;
        }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-900 min-h-screen antialiased flex flex-col justify-between">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-xs">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                @if(!empty($settings['site_logo']))
                    <img src="{{ $settings['site_logo'] }}" alt="Logo" class="h-9 w-auto object-contain">
                @else
                    <div class="h-9 w-9 rounded-xl bg-red-600 text-white flex items-center justify-center font-black text-sm shadow-xs">
                        日
                    </div>
                @endif
                <div>
                    <span class="font-extrabold text-sm sm:text-base text-slate-900 tracking-tight block leading-tight">
                        {{ $settings['site_title'] ?? 'LPK Sahabat Jepang Indonesia' }}
                    </span>
                    <span class="text-[10px] font-bold text-red-600 uppercase tracking-wider">
                        SO Kemenaker RI • Portal Kesiapan Terbang
                    </span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 hidden sm:flex items-center gap-1 transition">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-8 flex-1 w-full space-y-6">

        <!-- Search Bar Card -->
        <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-red-950 text-white p-6 sm:p-8 rounded-3xl shadow-xl relative overflow-hidden">
            <!-- Japanese Pattern Accent -->
            <div class="absolute -right-6 -bottom-6 text-white/[0.04] text-9xl font-black select-none pointer-events-none">
                渡航
            </div>

            <div class="relative z-10 max-w-2xl space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-red-300 text-xs font-bold backdrop-blur-md border border-white/10">
                    <i data-lucide="plane" class="w-3.5 h-3.5"></i>
                    <span>Flight Readiness Self-Service Portal</span>
                </div>
                <h1 class="text-xl sm:text-3xl font-black tracking-tight leading-tight">
                    Cek Status & Kesiapan Terbang Siswa ke Jepang
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-medium">
                    Pantau pemenuhan 8 dokumen primer, status izin tinggal CoE, visa kerja, dan tahapan resmi keberangkatan menuju perusahaan penerima di Jepang.
                </p>

                <!-- Search Form -->
                <form action="{{ route('public.flight.tracking') }}" method="GET" class="pt-2 flex flex-col sm:flex-row gap-2.5">
                    <div class="relative flex-1">
                        <i data-lucide="search" class="w-5 h-5 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input 
                            type="text" 
                            name="nis" 
                            value="{{ $queryNis }}"
                            placeholder="Masukkan NIS Siswa (contoh: SJI-2026-001) atau Nama..."
                            required
                            class="w-full pl-10 pr-4 py-3 rounded-2xl bg-white text-slate-900 font-bold text-sm shadow-inner placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-red-500"
                        >
                    </div>
                    <button type="submit" class="px-6 py-3 rounded-2xl bg-red-600 hover:bg-red-700 text-white font-extrabold text-sm shadow-lg flex items-center justify-center gap-2 transition hover:scale-105 active:scale-95 flex-shrink-0 cursor-pointer">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        <span>Lacak Kesiapan</span>
                    </button>
                </form>
            </div>
        </div>

        @if($searchPerformed && !$student)
            <!-- Not Found Alert -->
            <div class="bg-white p-8 rounded-3xl border border-slate-200 text-center space-y-3 shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto font-bold">
                    <i data-lucide="alert-circle" class="w-7 h-7"></i>
                </div>
                <h3 class="text-base font-black text-slate-900">Data Siswa Tidak Ditemukan</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    Kandidat dengan kata kunci <strong class="text-slate-800 font-mono">"{{ $queryNis }}"</strong> belum terdaftar atau NIS yang dimasukkan belum tepat. Pastikan format NIS sesuai dengan yang tercantum di kartu identitas siswa.
                </p>
                <div class="pt-2">
                    <a href="{{ route('public.flight.tracking') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs inline-flex items-center gap-1.5 transition">
                        <span>Reset Pencarian</span>
                    </a>
                </div>
            </div>
        @endif

        @if($student)
            <!-- Section: 3D Digital Student Identity Card (学生証) -->
            <div class="bg-gradient-to-b from-slate-900 to-slate-950 p-6 sm:p-8 rounded-3xl border border-slate-800 shadow-2xl space-y-4 no-print">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-800/80 pb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-red-600 text-white flex items-center justify-center font-bold text-xs shadow-md">
                            証
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-white flex items-center gap-2">
                                <span>Kartu Tanda Siswa Digital Resmi</span>
                                <span class="text-xs text-red-400 font-japanese font-bold">学生証</span>
                            </h3>
                            <p class="text-[11px] text-slate-400">Gerakkan kursor/sentuh layar untuk efek perspektif 3D interaktif.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap">
                        <button 
                            type="button" 
                            onclick="copyStudentNis('{{ $student->nis }}', this)" 
                            class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs flex items-center gap-1.5 transition border border-slate-700 cursor-pointer"
                            title="Salin NIS Siswa"
                        >
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                            <span class="nis-label">Salin NIS</span>
                        </button>
                        <button 
                            type="button" 
                            onclick="window.print()" 
                            class="px-3.5 py-1.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs flex items-center gap-1.5 transition shadow-sm cursor-pointer"
                        >
                            <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                            <span>Cetak Kartu</span>
                        </button>
                    </div>
                </div>

                <!-- 3D Card Interactive Stage -->
                <div id="cardContainer3d" class="perspective-1000 py-4 flex justify-center cursor-pointer">
                    <div 
                        id="studentIdCard3d" 
                        class="relative w-full max-w-md bg-gradient-to-br from-slate-900 via-slate-900 to-red-950 text-white rounded-3xl p-6 sm:p-7 shadow-2xl border border-red-500/30 overflow-hidden transform-gpu transition-transform duration-150 ease-out select-none"
                        style="box-shadow: 0 25px 50px -12px rgba(220, 38, 38, 0.25);"
                    >
                        <!-- Holographic / Japanese Kanji Watermark -->
                        <div class="absolute -right-8 -bottom-8 text-white/[0.03] text-9xl font-black font-japanese pointer-events-none select-none">
                            学生
                        </div>
                        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-bl from-red-600/20 via-transparent to-transparent pointer-events-none rounded-tr-3xl"></div>

                        <!-- Card Header -->
                        <div class="flex items-center justify-between border-b border-white/10 pb-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-red-600 text-white flex items-center justify-center font-black text-sm shadow-md">
                                    日
                                </div>
                                <div>
                                    <h4 class="text-[11px] font-black tracking-wider uppercase text-white leading-none">LPK SAHABAT JEPANG INDONESIA</h4>
                                    <p class="text-[9px] text-red-400 font-japanese font-bold tracking-widest mt-0.5">学生証 • STUDENT IDENTITY CARD</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 bg-white/10 backdrop-blur-md px-2 py-0.5 rounded-full border border-white/10 text-[10px] font-bold">
                                <span>🇮🇩</span>
                                <span class="text-white/40 text-[9px]">⇄</span>
                                <span>🇯🇵</span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="grid grid-cols-3 gap-3.5 pt-4 items-center">
                            <!-- Photo & Chip -->
                            <div class="col-span-1 flex flex-col items-center">
                                <div class="w-24 h-28 rounded-2xl bg-gradient-to-b from-slate-800 to-slate-950 border-2 border-amber-400/80 p-0.5 shadow-lg overflow-hidden flex items-center justify-center relative">
                                    @if(!empty($student->photo))
                                        <img src="{{ $student->photo }}" alt="{{ $student->name }}" class="w-full h-full object-cover rounded-xl">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-amber-300">
                                            <span class="text-3xl font-black">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                                            <span class="text-[8px] font-mono mt-1 text-slate-400">PASFOTO</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2 flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-[8.5px] font-extrabold uppercase font-mono">
                                    <i data-lucide="check" class="w-2.5 h-2.5 text-emerald-400"></i>
                                    <span>VERIFIED</span>
                                </div>
                            </div>

                            <!-- Student Info -->
                            <div class="col-span-2 space-y-2">
                                <div>
                                    <span class="text-[8.5px] text-slate-400 uppercase tracking-wider block font-medium">氏名 / CANDIDATE NAME</span>
                                    <h4 class="text-base sm:text-lg font-black text-white tracking-tight leading-tight">
                                        {{ $student->name }}
                                    </h4>
                                    @if($student->japanese_name)
                                        <span class="text-xs font-japanese font-bold text-red-400 block mt-0.5">{{ $student->japanese_name }}</span>
                                    @endif
                                </div>

                                <div class="grid grid-cols-2 gap-2 text-[10px] pt-1">
                                    <div>
                                        <span class="text-slate-400 block text-[8px] font-medium">学籍番号 / NIS</span>
                                        <strong class="font-mono text-amber-300 text-xs tracking-tight">{{ $student->nis }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[8px] font-medium">期生 / BATCH</span>
                                        <strong class="text-white text-[11px]">{{ $student->batch ?: 'Reguler' }}</strong>
                                    </div>
                                    <div class="col-span-2">
                                        <span class="text-slate-400 block text-[8px] font-medium">プログラム / PROGRAM</span>
                                        <strong class="text-slate-200 truncate block text-[10.5px]">{{ $student->program ?? 'Program Pemagangan' }}</strong>
                                    </div>
                                    @if($student->destination_company)
                                    <div class="col-span-2">
                                        <span class="text-slate-400 block text-[8px] font-medium">派遣先 / KAISHA JEPANG</span>
                                        <strong class="text-red-300 truncate block text-[10.5px]">{{ $student->destination_company }} ({{ $student->destination_prefecture ?: 'Jepang' }})</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Bar: QR + Hanko -->
                        <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 bg-white p-1 rounded-lg shadow-xs flex-shrink-0">
                                    <img 
                                        src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&margin=0&data={{ urlencode(route('public.flight.tracking', $student->nis)) }}" 
                                        alt="QR" 
                                        class="w-full h-full"
                                    >
                                </div>
                                <div class="text-[8.5px] text-slate-400 leading-tight">
                                    <span class="text-white font-bold block">VALIDATED DIGITAL ID</span>
                                    <span>SO Kemenaker RI • SJI</span>
                                </div>
                            </div>

                            <!-- Animated Hanko Stamp -->
                            <div class="h-11 w-11 rounded-full border-2 border-red-500 text-red-500 flex flex-col items-center justify-center font-japanese text-[6.5px] leading-none select-none animate-hanko-float bg-red-500/10 shadow-xs flex-shrink-0" title="Stempel Hanko Lembaga">
                                <span>協同</span>
                                <span class="font-black text-[8px] my-0.5">SJI</span>
                                <span>組合</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Candidate Overview Card -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-xs space-y-6">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-red-600 to-rose-700 text-white flex items-center justify-center font-black text-2xl shadow-md flex-shrink-0">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h2 class="text-lg sm:text-xl font-black text-slate-900 leading-tight">
                                    {{ $student->name }}
                                </h2>
                                @if($student->japanese_name)
                                    <span class="px-2 py-0.5 rounded-md bg-red-50 text-red-700 font-serif font-bold text-xs border border-red-100">
                                        {{ $student->japanese_name }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs font-mono font-bold text-slate-500 mt-1">
                                NIS: {{ $student->nis }} • {{ $student->program ?? 'Program Pemagangan' }}
                            </p>
                            <p class="text-xs text-slate-600 mt-0.5">
                                Perusahaan Penerima: <strong class="text-slate-900">{{ $student->destination_company ?: 'Dalam Proses Matching' }}</strong> (Prefektur {{ $student->destination_prefecture ?: '-' }})
                            </p>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="text-left sm:text-right space-y-2">
                        @php
                            $isReady = !empty($student->document_passport) && !empty($student->document_coe_visa) && $student->mcu_result === 'fit';
                            $isWaitingVisa = !empty($student->coe_number) && empty($student->visa_number);
                            $isWaitingCoe = in_array($student->status, ['passed_interview', 'matched']) && empty($student->coe_number);
                        @endphp
                        @if($isReady)
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-extrabold text-xs shadow-sm">
                                <i data-lucide="plane" class="w-4 h-4"></i>
                                <span>READY TO FLY ✈️</span>
                            </div>
                        @elseif($isWaitingVisa)
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-100 text-blue-800 font-bold text-xs border border-blue-200">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                                <span>WAITING VISA 🛂</span>
                            </div>
                        @elseif($isWaitingCoe)
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-100 text-amber-800 font-bold text-xs border border-amber-200">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                                <span>WAITING COE ⏳</span>
                            </div>
                        @else
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs border border-slate-200">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                <span>PROSES PEMBERKASAN 📋</span>
                            </div>
                        @endif

                        <div class="text-[11px] text-slate-400">
                            Est. Terbang: <strong class="text-slate-700">{{ $student->departure_date ? \Carbon\Carbon::parse($student->departure_date)->translatedFormat('d F Y') : 'Menunggu Jadwal' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar Kelengkapan 8 Dokumen -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-extrabold text-slate-700 flex items-center gap-1.5">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                            Kelengkapan 8 Dokumen Keberangkatan
                        </span>
                        <span class="font-mono font-black {{ $completedPercent === 100 ? 'text-emerald-600' : 'text-slate-800' }} text-sm">
                            {{ $completedPercent }}%
                        </span>
                    </div>
                    <div class="h-3 bg-slate-100 rounded-full overflow-hidden p-0.5 border border-slate-200">
                        <div 
                            class="h-full rounded-full transition-all duration-700 {{ $completedPercent === 100 ? 'bg-emerald-500' : ($completedPercent >= 60 ? 'bg-blue-600' : 'bg-amber-500') }}"
                            style="width: {{ $completedPercent }}%"
                        ></div>
                    </div>
                </div>

                <!-- 8 Documents Verification Matrix -->
                <div class="space-y-3">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">
                        Rincian Status Berkas Siswa
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach($docs as $key => $doc)
                            <div class="p-3.5 rounded-2xl border {{ $doc['status'] ? 'bg-emerald-50/40 border-emerald-200' : 'bg-slate-50 border-slate-200' }} flex items-start gap-3 transition">
                                <div class="w-7 h-7 rounded-xl {{ $doc['status'] ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-400' }} flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                                    <i data-lucide="{{ $doc['status'] ? 'check' : 'clock' }}" class="w-4 h-4"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-slate-900 truncate">{{ $doc['label'] }}</h4>
                                    <p class="text-[10px] text-slate-500 line-clamp-1 mt-0.5">{{ $doc['desc'] }}</p>
                                    <div class="mt-1.5 flex items-center gap-1.5">
                                        @if($doc['status'])
                                            <span class="px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-extrabold text-[9px]">
                                                Terverifikasi ✓
                                            </span>
                                        @else
                                            <span class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 font-bold text-[9px]">
                                                Dalam Proses ⏳
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Timeline Stages -->
                <div class="space-y-3 pt-2">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">
                        Tahapan Perjalanan Siswa (Road to Japan)
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($stages as $idx => $stage)
                            <div class="p-4 rounded-2xl border {{ $stage['status'] === 'completed' ? 'bg-white border-emerald-200 shadow-2xs' : ($stage['status'] === 'current' ? 'bg-blue-50/40 border-blue-300' : 'bg-slate-50 border-slate-200 opacity-70') }} space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-mono font-bold text-slate-400">TAHAP 0{{ $idx + 1 }}</span>
                                    @if($stage['status'] === 'completed')
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[9px] font-black">SELESAI ✓</span>
                                    @elseif($stage['status'] === 'current')
                                        <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[9px] font-black animate-pulse">BERJALAN ⏳</span>
                                    @elseif($stage['status'] === 'ready')
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-600 text-white text-[9px] font-black">SIAP TERBANG ✈️</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-slate-200 text-slate-600 text-[9px] font-bold">MENUNGGU</span>
                                    @endif
                                </div>
                                <h4 class="text-xs font-black text-slate-900">{{ $stage['title'] }}</h4>
                                <p class="text-[10.5px] text-slate-500 leading-relaxed">{{ $stage['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Digital Receipt Shortcut Banner -->
                <div class="bg-gradient-to-r from-red-50 via-rose-50 to-amber-50 p-4 sm:p-5 rounded-2xl border border-red-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center font-bold shadow-sm flex-shrink-0">
                            <i data-lucide="receipt" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-900">Kwitansi Pembayaran Resmi (Digital Receipt)</h4>
                            <p class="text-[11px] text-slate-600 mt-0.5">
                                Terbayar: <strong class="text-emerald-700">Rp {{ number_format($student->paid_amount, 0, ',', '.') }}</strong> • Status: <span class="font-bold {{ $student->remaining_balance <= 0 ? 'text-emerald-600' : 'text-amber-600' }}">{{ $student->remaining_balance <= 0 ? 'Lunas' : 'Belum Lunas' }}</span>
                            </p>
                        </div>
                    </div>
                    <a 
                        href="{{ route('student.public.receipt', $student->nis) }}" 
                        target="_blank"
                        class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-sm flex items-center gap-2 transition hover:scale-105 active:scale-95 flex-shrink-0"
                    >
                        <span>Buka Kwitansi Resmi</span>
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    </a>
                </div>

            </div>

            <!-- Departure Briefing Box -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 text-xs space-y-3 shadow-xs">
                <h4 class="font-black text-slate-900 text-sm flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-red-600"></i>
                    Panduan & Informasi Keberangkatan Siswa Menuju Jepang
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-slate-600 leading-relaxed">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <strong class="text-slate-900 block mb-1">1. Ketentuan Bagasi Penerbangan</strong>
                        Maksimal 2 koper bagasi check-in (maks 23 kg per koper) dan 1 tas kabin (maks 7 kg). Dilarang membawa makanan basah atau daging segar ke Jepang.
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <strong class="text-slate-900 block mb-1">2. Uang Saku Awal (Yen)</strong>
                        Disarankan membawa uang saku awal minimal ¥30.000 s/d ¥50.000 untuk keperluan hidup 1 bulan pertama sebelum penerimaan gaji perdana.
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <strong class="text-slate-900 block mb-1">3. Layanan Pendampingan LPK</strong>
                        Penjemputan di bandara kedatangan (Haneda, Narita, Kansai, dll) dikoordinasikan langsung bersama pihak Kumiai / Kaisha penerima.
                    </div>
                </div>
            </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <p class="font-semibold text-slate-700">
            {{ $settings['site_title'] ?? 'LPK Sahabat Jepang Indonesia' }}
        </p>
        <p class="text-[11px] text-slate-400 mt-1">
            Sending Organization (SO) Kemenaker RI • Legalitas Izin Penempatan Luar Negeri
        </p>
    </footer>

    <script>
        if (window.lucide) {
            lucide.createIcons();
        }

        // 3D Tilt Effect for Student Identity Card
        (function init3dCard() {
            const card = document.getElementById('studentIdCard3d');
            const container = document.getElementById('cardContainer3d');
            if (!card || !container) return;

            container.addEventListener('mousemove', (e) => {
                const rect = container.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                const rotateX = -(y / rect.height) * 18;
                const rotateY = (x / rect.width) * 18;
                card.style.transform = `perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) scale3d(1.02, 1.02, 1.02)`;
            });

            container.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
            });

            container.addEventListener('touchmove', (e) => {
                if (e.touches.length > 0) {
                    const touch = e.touches[0];
                    const rect = container.getBoundingClientRect();
                    const x = touch.clientX - rect.left - rect.width / 2;
                    const y = touch.clientY - rect.top - rect.height / 2;
                    const rotateX = -(y / rect.height) * 14;
                    const rotateY = (x / rect.width) * 14;
                    card.style.transform = `perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg)`;
                }
            }, { passive: true });

            container.addEventListener('touchend', () => {
                card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
            });
        })();

        // Copy Student NIS with visual feedback
        function copyStudentNis(nis, btn) {
            if (!nis) return;
            if (navigator.clipboard) {
                navigator.clipboard.writeText(nis).then(() => {
                    const label = btn.querySelector('.nis-label');
                    const originalText = label ? label.textContent : '';
                    if (label) label.textContent = 'Tersalin! ✓';
                    btn.classList.add('bg-emerald-700', 'text-white');
                    setTimeout(() => {
                        if (label) label.textContent = originalText || 'Salin NIS';
                        btn.classList.remove('bg-emerald-700', 'text-white');
                    }, 1800);
                }).catch(() => {});
            }
        }
    </script>
</body>
</html>
