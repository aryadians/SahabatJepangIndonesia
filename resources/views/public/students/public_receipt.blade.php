<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran Resmi - {{ $student->name }} ({{ $receiptNo }})</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Noto+Sans+JP:wght@400;700;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        @keyframes hankoStamp {
            0% {
                transform: scale(2.2) rotate(-25deg);
                opacity: 0;
            }
            65% {
                transform: scale(0.92) rotate(-3deg);
                opacity: 1;
            }
            85% {
                transform: scale(1.04) rotate(-3deg);
            }
            100% {
                transform: scale(1) rotate(-3deg);
                opacity: 1;
            }
        }
        .animate-hanko {
            animation: hankoStamp 0.75s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
        .washi-pattern {
            background-color: #ffffff;
            background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px);
            background-size: 14px 14px;
        }
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
        }
        @page {
            size: A4 portrait;
            margin: 12mm 15mm;
        }
        .hanko-stamp {
            border: 2.5px double #DC2626;
            color: #DC2626;
            transform: rotate(-3deg);
            background: rgba(254, 242, 242, 0.5);
            box-shadow: 0 0 0 1px #DC2626 inset, 0 0 12px rgba(220, 38, 38, 0.15);
        }
    </style>
</head>
<body class="bg-slate-100/80 font-sans text-slate-900 p-3 sm:p-8 antialiased">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-3xl mx-auto mb-6 flex flex-col sm:flex-row items-center justify-between gap-3 no-print bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ url('/') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 transition">
                <i data-lucide="home" class="w-4 h-4"></i>
                <span>Beranda</span>
            </a>
            <span class="text-slate-300">•</span>
            <a href="{{ route('public.flight.tracking', $student->nis) }}" class="text-xs font-bold text-red-600 hover:text-red-700 flex items-center gap-1.5 transition">
                <i data-lucide="plane" class="w-4 h-4"></i>
                <span>Cek Kesiapan Siswa</span>
            </a>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <!-- Share to WhatsApp -->
            @php
                $waText = "Halo, berikut Kwitansi Resmi Pembayaran Pendidikan & Pelatihan LPK Sahabat Jepang Indonesia atas nama *{$student->name}* ({$student->nis}): " . request()->url();
            @endphp
            <a 
                href="https://api.whatsapp.com/send?text={{ urlencode($waText) }}" 
                target="_blank" 
                class="px-3.5 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 font-bold text-xs flex items-center gap-1.5 transition shadow-2xs"
                title="Kirim tautan kwitansi ke WhatsApp"
            >
                <i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                <span>Bagikan WA</span>
            </a>

            <!-- Copy Link Button -->
            <button 
                type="button" 
                onclick="copyReceiptUrl(this)" 
                class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs flex items-center gap-1.5 transition shadow-2xs"
                title="Salin tautan kwitansi resmi"
            >
                <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                <span class="copy-label">Salin Tautan</span>
            </button>

            <!-- Print Button -->
            <button 
                onclick="window.print()" 
                class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md flex items-center gap-1.5 transition hover:scale-105 active:scale-95"
            >
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak / PDF</span>
            </button>
        </div>
    </div>

    <!-- Official Printable Sheet (A4 Portrait Format) -->
    <div class="max-w-3xl mx-auto bg-white p-6 sm:p-10 rounded-3xl shadow-lg border border-slate-200 print-page space-y-6 relative overflow-hidden">
        
        <!-- Watermark -->
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none select-none">
            <span class="text-8xl sm:text-9xl font-black">{{ $student->remaining_balance <= 0 ? 'LUNAS' : 'KWITANSI' }}</span>
        </div>

        <!-- Official Header (KOP Surat) -->
        <div class="border-b-2 border-slate-900 pb-4 flex items-start justify-between gap-4">
            <div class="flex items-start gap-3.5">
                @if(!empty($settings['site_logo']))
                    <div class="h-16 w-16 rounded-2xl bg-white border border-slate-200 p-1 flex items-center justify-center shadow-xs overflow-hidden flex-shrink-0">
                        <img src="{{ $settings['site_logo'] }}" alt="Logo" class="max-h-full max-w-full object-contain">
                    </div>
                @else
                    <div class="h-16 w-16 rounded-2xl bg-red-600 text-white flex flex-col items-center justify-center font-black shadow-xs flex-shrink-0">
                        <span class="text-2xl leading-none">日</span>
                        <span class="text-[9px] tracking-tighter uppercase font-bold mt-0.5">SJI</span>
                    </div>
                @endif
                <div>
                    <h1 class="text-base sm:text-lg font-black text-slate-900 tracking-tight uppercase leading-tight">
                        {{ $settings['site_title'] ?? 'LPK SAHABAT JEPANG INDONESIA' }}
                    </h1>
                    <p class="text-[10px] sm:text-[11px] font-bold text-red-600 uppercase tracking-widest mt-0.5">
                        Sending Organization (SO) Kemenaker RI • Legalitas Izin Penempatan Luar Negeri
                    </p>
                    <p class="text-[10px] text-slate-500 mt-1 leading-relaxed max-w-md">
                        {{ $settings['contact_address'] ?? 'Jl. Raya Pendidikan No. 88, Jakarta Selatan, Indonesia' }} • Telp: {{ $settings['contact_phone'] ?? '0812-3456-7890' }} • Email: {{ $settings['contact_email'] ?? 'info@sahabatjepang.co.id' }}
                    </p>
                </div>
            </div>
            <div class="text-right flex-shrink-0">
                <span class="inline-block px-2.5 py-1 rounded bg-slate-100 border border-slate-200 text-[10px] font-mono font-bold text-slate-700">
                    {{ $receiptNo }}
                </span>
                <p class="text-[10px] text-slate-400 mt-1">
                    Tanggal: <strong class="text-slate-700">{{ now()->translatedFormat('d F Y') }}</strong>
                </p>
            </div>
        </div>

        <!-- Title Banner -->
        <div class="text-center py-2 bg-slate-50 rounded-2xl border border-slate-200/80">
            <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">
                BUKTI PENERIMAAN PEMBAYARAN BIAYA PENDIDIKAN & PELATIHAN
            </h2>
            <p class="text-[11px] text-slate-500 mt-0.5 font-mono">
                領収書 (OFFICIAL PAYMENT RECEIPT)
            </p>
        </div>

        <!-- Student Identification Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs bg-slate-50/50 p-4 rounded-2xl border border-slate-100">
            <div class="space-y-1.5">
                <div class="flex justify-between">
                    <span class="text-slate-500 font-medium">Telah Terima Dari:</span>
                    <strong class="text-slate-900 text-right">{{ $student->name }}</strong>
                </div>
                @if($student->japanese_name)
                    <div class="flex justify-between">
                        <span class="text-slate-500 font-medium">Nama Kanji / Katakana:</span>
                        <span class="font-bold text-red-600 font-serif">{{ $student->japanese_name }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-slate-500 font-medium">Nomor Induk Siswa (NIS):</span>
                    <span class="font-mono font-bold text-slate-800">{{ $student->nis }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 font-medium">Program Pelatihan:</span>
                    <span class="font-semibold text-slate-800">{{ $student->program ?? 'Ginou Jisshusei' }}</span>
                </div>
            </div>
            <div class="space-y-1.5">
                <div class="flex justify-between">
                    <span class="text-slate-500 font-medium">Angkatan / Batch:</span>
                    <span class="font-semibold text-slate-800">{{ $student->batch ?? 'Angkatan Reguler' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 font-medium">Perusahaan Penerima (Kaisha):</span>
                    <span class="font-semibold text-slate-800">{{ $student->destination_company ?: '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 font-medium">Prefektur Tujuan:</span>
                    <span class="font-semibold text-slate-800">{{ $student->destination_prefecture ?: '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 font-medium">Skema Pembayaran:</span>
                    <span class="font-bold uppercase text-slate-800">{{ $student->payment_scheme ?: 'Mandiri' }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Breakdown Table -->
        <div class="border border-slate-200 rounded-2xl overflow-hidden text-xs">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white font-extrabold uppercase text-[10.5px]">
                        <th class="py-2.5 px-4">Deskripsi Pos Pembayaran</th>
                        <th class="py-2.5 px-4 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr>
                        <td class="py-3 px-4">
                            <strong class="text-slate-900">Total Biaya Pelatihan & Penempatan Kerja</strong>
                            <p class="text-[11px] text-slate-500 mt-0.5">Mencakup pelatihan bahasa, asrama, sertifikasi, pengurusan CoE, dan paspor.</p>
                        </td>
                        <td class="py-3 px-4 text-right font-mono font-bold text-slate-800 text-sm">
                            Rp {{ number_format($student->total_cost, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="bg-emerald-50/50">
                        <td class="py-3 px-4">
                            <strong class="text-emerald-900">Jumlah Akumulasi Telah Diterima (Paid)</strong>
                            <p class="text-[11px] text-emerald-700 mt-0.5">Tervalidasi di Buku Kas Umum LPK Sahabat Jepang Indonesia.</p>
                        </td>
                        <td class="py-3 px-4 text-right font-mono font-black text-emerald-700 text-base">
                            Rp {{ number_format($student->paid_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="bg-slate-50/80">
                        <td class="py-3 px-4">
                            <strong class="text-slate-800">Sisa Tanggungan Biaya (Remaining Balance)</strong>
                            <p class="text-[11px] text-slate-500 mt-0.5">
                                @if($student->remaining_balance <= 0)
                                    <span class="text-emerald-600 font-bold">✓ Seluruh kewajiban pembayaran telah lunas sepenuhnya.</span>
                                @else
                                    Dapat diangsur sesuai kesepakatan skema lembaga / talangan dana.
                                @endif
                            </p>
                        </td>
                        <td class="py-3 px-4 text-right font-mono font-bold {{ $student->remaining_balance <= 0 ? 'text-emerald-600' : 'text-amber-600' }} text-sm">
                            {{ $student->remaining_balance <= 0 ? 'LUNAS (Rp 0)' : 'Rp ' . number_format($student->remaining_balance, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Terbilang Box -->
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 text-xs">
            <span class="text-slate-500 font-bold block text-[10px] uppercase tracking-wider mb-1">Terbilang (Jumlah Diterima):</span>
            <p class="text-slate-900 font-extrabold italic text-sm">
                # {{ $terbilang }} #
            </p>
        </div>

        <!-- QR Code & Digital Verification -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4 border-t border-slate-200 items-center">
            
            <!-- QR Code -->
            <div class="flex items-center gap-3">
                <div class="p-1.5 bg-white border border-slate-200 rounded-xl shadow-xs flex-shrink-0">
                    <img 
                        src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&margin=0&data={{ urlencode($verificationUrl) }}" 
                        alt="QR Code Verifikasi" 
                        class="w-20 h-20"
                    >
                </div>
                <div>
                    <span class="px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-extrabold text-[9px] uppercase tracking-wider">
                        Terverifikasi Digital
                    </span>
                    <p class="text-[10.5px] text-slate-500 mt-1 leading-tight">
                        Pindai kode QR untuk memverifikasi keaslian kwitansi ini secara online di portal resmi SJI.
                    </p>
                </div>
            </div>

            <!-- Catatan Resmi -->
            <div class="text-[10px] text-slate-500 leading-relaxed border-l-0 sm:border-l sm:border-slate-200 sm:pl-4">
                <p class="font-bold text-slate-700 mb-0.5">Ketentuan Pembayaran:</p>
                <ul class="list-disc pl-3 space-y-0.5">
                    <li>Kuitansi digital ini merupakan bukti sah penerimaan dana pelatihan kerja.</li>
                    <li>Pembayaran non-tunai hanya diakui melalui rekening resmi LPK Sahabat Jepang Indonesia.</li>
                </ul>
            </div>

            <!-- Tanda Tangan & Stempel Hanko -->
            <div class="text-center relative sm:border-l sm:border-slate-200 sm:pl-4">
                <p class="text-[10px] font-bold text-slate-500">Jakarta, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="text-[11px] font-bold text-slate-700 mt-0.5">Bagian Keuangan & Kasir Lembaga</p>
                
                <div class="h-16 flex items-center justify-center relative my-1">
                    <!-- Stempel Hanko Jepang Beranimasi -->
                    <div class="h-14 w-14 rounded-full hanko-stamp animate-hanko flex flex-col items-center justify-center select-none font-serif cursor-pointer" title="Stempel Resmi Sahabat Jepang Indonesia" onclick="this.classList.remove('animate-hanko'); void this.offsetWidth; this.classList.add('animate-hanko');">
                        <span class="text-[7px] font-bold tracking-widest text-red-600">株式会社</span>
                        <span class="text-[10px] font-black text-red-600 tracking-tight leading-none">SJI印</span>
                        <span class="text-[6.5px] font-bold text-red-600">出納済</span>
                    </div>
                </div>

                <p class="text-xs font-black text-slate-900 underline">Bendahara LPK SJI</p>
                <p class="text-[9px] text-slate-400">Divisi Administrasi & Keuangan</p>
            </div>

        </div>

    </div>

    <script>
        if (window.lucide) {
            lucide.createIcons();
        }

        function copyReceiptUrl(btn) {
            const url = window.location.href;
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(() => {
                    const label = btn.querySelector('.copy-label');
                    const icon = btn.querySelector('svg');
                    if (label) label.textContent = 'Tersalin! ✓';
                    btn.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
                    setTimeout(() => {
                        if (label) label.textContent = 'Salin Tautan';
                        btn.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
                    }, 2000);
                }).catch(() => {});
            }
        }
    </script>
</body>
</html>
