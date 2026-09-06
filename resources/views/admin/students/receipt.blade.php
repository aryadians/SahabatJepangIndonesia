<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran - {{ $student->name }} ({{ $receiptNo }})</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
                padding: 0 !important;
                margin: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .page-container {
                border: 1px solid #E2E8F0 !important;
                box-shadow: none !important;
                padding: 24px !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                border-radius: 0 !important;
                page-break-inside: avoid !important;
            }
        }
        @page {
            size: A4 portrait;
            margin: 10mm 15mm;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 font-sans p-4 sm:p-8">

    <!-- Top Action Bar (No-Print) -->
    <div class="max-w-3xl mx-auto mb-6 flex flex-wrap items-center justify-between gap-3 no-print">
        <a href="{{ auth()->check() ? route('admin.students.index') : route('student.portal') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-50 transition flex items-center gap-1.5 shadow-xs">
            &larr; {{ auth()->check() ? 'Kembali ke Data Siswa' : 'Kembali ke Portal Siswa' }}
        </a>
        <div class="flex items-center gap-2 flex-wrap">
            @if(auth()->check())
            <button type="button" onclick="openWaModal()" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.698.075-2.031-.476-1.525-.63-2.502-2.181-2.58-2.283-.075-.102-.622-.829-.622-1.58 0-.752.394-1.121.534-1.27.144-.15.312-.187.417-.187.106 0 .211.002.302.007.098.006.228-.037.357.272.132.318.45 1.096.49 1.177.04.08.067.174.013.28-.053.107-.08.174-.16.267-.08.094-.17.209-.243.281-.08.079-.164.165-.07.327.094.162.417.688.895 1.114.614.547 1.132.716 1.293.796.162.08.256.067.352-.042.095-.11.408-.475.517-.638.11-.162.219-.136.368-.081.15.053.953.449 1.117.531.164.081.273.122.313.19.04.068.04.394-.104.799z"/></svg>
                <span>Kirim ke WhatsApp</span>
            </button>
            @endif
            <a href="{{ auth()->check() ? route('admin.students.invoice', $student->id) : route('student.public.invoice', $student->nis) }}" class="px-4 py-2 rounded-xl bg-blue-50 text-blue-700 border border-blue-200 text-xs font-bold hover:bg-blue-100 transition">
                Cetak Invoice
            </a>
            <button onclick="window.print()" class="px-5 py-2 rounded-xl bg-red-600 text-white text-xs font-bold hover:bg-red-700 transition shadow-md flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="max-w-3xl mx-auto mb-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between no-print shadow-xs">
        <div class="flex items-center gap-2">
            <span>✅ {{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
    </div>
    @endif

    @if(session('warning'))
    <div class="max-w-3xl mx-auto mb-4 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold flex items-center justify-between no-print shadow-xs">
        <div class="flex items-center gap-2">
            <span>⚠️ {{ session('warning') }}</span>
        </div>
        @if(session('wa_manual_url'))
            <a href="{{ session('wa_manual_url') }}" target="_blank" class="px-3 py-1 bg-emerald-600 text-white rounded-lg text-[11px] font-extrabold hover:bg-emerald-700">Buka WhatsApp Manual</a>
        @endif
    </div>
    @endif

    <!-- Official Receipt Paper (A4 Canvas) -->
    <div class="page-container max-w-3xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8 sm:p-12 relative overflow-hidden">
        
        <!-- Watermark LPK SJI -->
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none select-none">
            <span class="text-9xl font-black">友好日本</span>
        </div>

        <!-- Official Header (Kop Surat) -->
        <div class="border-b-2 border-slate-900 pb-6 flex items-start justify-between gap-6">
            <div class="flex items-start gap-4">
                @if(!empty($settings['site_logo']))
                    <div class="h-16 w-16 rounded-2xl bg-white border border-slate-200 p-1 flex items-center justify-center shadow-xs overflow-hidden flex-shrink-0">
                        <img src="{{ $settings['site_logo'] }}" alt="{{ $settings['site_name'] ?? 'LPK SJI' }}" class="max-h-full max-w-full object-contain">
                    </div>
                @else
                    <div class="w-16 h-16 rounded-2xl bg-red-600 text-white flex items-center justify-center font-bold text-3xl shadow-md flex-shrink-0 font-japanese">
                        友
                    </div>
                @endif
                <div>
                    <h1 class="text-xl font-black tracking-tight text-slate-900 uppercase leading-none">
                        {{ $settings['site_name'] ?? 'LPK SAHABAT JEPANG INDONESIA' }}
                    </h1>
                    <p class="text-xs font-bold text-red-600 mt-1">
                        Lembaga Pelatihan Kerja & Sending Organization Resmi Kemnaker RI
                    </p>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                        Izin SO Kemnaker RI: KEP.224/LATTAS/XII/2023 • Akreditasi Lembaga: LA-LPK A<br>
                        Jl. Sakura Raya No. 88, Jakarta Selatan • Telp: +62 812-3456-7890 • Email: info@sahabatjepangindonesia.com
                    </p>
                </div>
            </div>

            <!-- Receipt Meta -->
            <div class="text-right flex-shrink-0">
                <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-xs font-black rounded-lg uppercase tracking-wider mb-2">
                    Kwitansi Pembayaran Resmi
                </span>
                <p class="text-xs font-mono font-bold text-slate-900 flex items-center justify-end gap-1.5">
                    <span>{{ $receiptNo }}</span>
                    <button type="button" onclick="copyToClipboard('{{ $receiptNo }}', 'No. Kwitansi tersalin!')" class="no-print p-1 rounded hover:bg-slate-100 text-slate-400 hover:text-red-600 transition" title="Salin nomor kwitansi">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </button>
                </p>
                <p class="text-[11px] text-slate-400 mt-0.5">Tanggal: {{ date('d F Y') }}</p>
            </div>
        </div>

        <!-- Receipt Content Body -->
        <div class="py-8 space-y-6">
            
            <!-- Table of Receipt Details -->
            <table class="w-full text-xs sm:text-sm">
                <tr class="border-b border-slate-100">
                    <td class="py-3 font-semibold text-slate-400 w-44">Telah Diterima Dari</td>
                    <td class="py-3 font-bold text-slate-900">
                        <span class="text-base font-black">{{ $student->name }}</span>
                        <span class="text-xs text-slate-500 font-mono ml-2 inline-flex items-center gap-1">
                            (NIS: {{ $student->nis }})
                            <button type="button" onclick="copyToClipboard('{{ $student->nis }}', 'NIS Siswa tersalin!')" class="no-print p-0.5 rounded hover:bg-slate-100 text-slate-400 hover:text-red-600 transition" title="Salin NIS">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </button>
                        </span>
                    </td>
                </tr>

                <tr class="border-b border-slate-100">
                    <td class="py-3 font-semibold text-slate-400">Program / Angkatan</td>
                    <td class="py-3 font-semibold text-slate-800">
                        {{ $student->program }} {{ $student->batch ? '• ' . $student->batch : '' }}
                    </td>
                </tr>

                <tr class="border-b border-slate-100">
                    <td class="py-3 font-semibold text-slate-400">Uang Sejumlah</td>
                    <td class="py-3">
                        <span class="text-xl sm:text-2xl font-black text-red-600 font-mono">
                            Rp {{ number_format($student->paid_amount, 0, ',', '.') }}
                        </span>
                    </td>
                </tr>

                <tr class="border-b border-slate-100 bg-slate-50/50">
                    <td class="py-3 px-3 font-semibold text-slate-500">Terbilang</td>
                    <td class="py-3 px-3 italic font-semibold text-slate-800">
                        "{{ $terbilang }}"
                    </td>
                </tr>

                <tr class="border-b border-slate-100">
                    <td class="py-3 font-semibold text-slate-400">Untuk Pembayaran</td>
                    <td class="py-3 text-slate-800 font-medium leading-relaxed">
                        Biaya Administrasi Pelatihan Intensif Bahasa Jepang, Asrama, Pembekalan Budaya Kerja, dan Pengurusan Dokumen Kerja Jepang (Program {{ $student->program }}).
                        @if($student->payment_notes)
                            <br><span class="text-xs text-slate-500">Catatan: {{ $student->payment_notes }}</span>
                        @endif
                    </td>
                </tr>
            </table>

            <!-- Financial Summary Box -->
            <div class="grid grid-cols-3 gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                <div>
                    <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Total Biaya Program</span>
                    <p class="text-sm font-black text-slate-900 font-mono mt-0.5">Rp {{ number_format($student->total_cost, 0, ',', '.') }}</p>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase text-emerald-600 tracking-wider">Total Telah Dibayar</span>
                    <p class="text-sm font-black text-emerald-600 font-mono mt-0.5">Rp {{ number_format($student->paid_amount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase text-amber-600 tracking-wider">Sisa Tanggungan</span>
                    <p class="text-sm font-black text-amber-600 font-mono mt-0.5">Rp {{ number_format($student->remaining_balance, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Status Lunas / Cicilan Banner -->
            <div class="flex items-center justify-between p-3 rounded-xl {{ $student->remaining_balance <= 0 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }} text-xs font-bold">
                <span>Status Akun Keuangan Siswa:</span>
                <span class="uppercase tracking-wider font-black">
                    {{ $student->remaining_balance <= 0 ? 'LUNAS SEPENUHNYA (PAID IN FULL)' : 'CICILAN BERJALAN (TERBAYAR ' . $student->payment_percentage . '%)' }}
                </span>
            </div>

        </div>

        <!-- Signature & Stamp Section -->
        <div class="border-t border-slate-200 pt-6 mt-4 flex items-end justify-between">
            
            <!-- QR Code Security Stamp -->
            <div class="space-y-1.5 text-center">
                <a href="{{ route('document.verify', ['code' => str_replace('/', '-', $receiptNo)]) }}" target="_blank" class="block w-24 h-24 border border-slate-200 rounded-xl p-1 bg-white mx-auto flex items-center justify-center hover:border-red-500 transition shadow-2xs" title="Klik untuk cek keaslian dokumen">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('document.verify', ['code' => str_replace('/', '-', $receiptNo)])) }}" alt="QR Verifikasi" class="w-full h-full object-contain">
                </a>
                <a href="{{ route('document.verify', ['code' => str_replace('/', '-', $receiptNo)]) }}" target="_blank" class="text-[9px] font-mono font-bold text-slate-500 hover:text-red-600 block">
                    Scan / Cek Keaslian &rarr;
                </a>
            </div>

            <!-- Stempel & Tanda Tangan Kasir -->
            <div class="text-center w-60 space-y-1">
                <p class="text-xs text-slate-500">Jakarta, {{ date('d F Y') }}</p>
                <p class="text-xs font-bold text-slate-700">Bagian Keuangan & Kasir LPK</p>
                
                <!-- Digital Stamp Badge (Authentic Hanko Seal) -->
                <div class="h-20 flex items-center justify-center relative">
                    <div class="hanko-stamp w-32 h-16 rounded-full flex flex-col items-center justify-center select-none py-1">
                        <span class="tracking-widest uppercase text-[8px] font-black">LPK SAHABAT JEPANG</span>
                        <span class="text-xs font-black tracking-wider">LUNAS / VERIFIED</span>
                        <span class="text-[7px] tracking-tight font-japanese">送出機関 友好日本</span>
                    </div>
                </div>

                <p class="text-xs font-black text-slate-900 underline underline-offset-4">Bendahara Keuangan LPK</p>
                <p class="text-[10px] text-slate-400 font-mono">NIP: SJI-FIN-{{ date('Y') }}</p>
            </div>

        </div>

        <!-- Footer Notice -->
        <div class="mt-8 pt-4 border-t border-slate-100 text-[10px] text-slate-400 text-center leading-relaxed">
            Kwitansi ini merupakan bukti pembayaran resmi yang sah yang diterbitkan oleh sistem manajemen LPK Sahabat Jepang Indonesia. Harap simpan dokumen ini sebagai tanda bukti pembayaran yang sah.
        </div>

    </div>

    <!-- Modal Kirim WhatsApp (No-Print) -->
    <div id="waModal" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs hidden items-center justify-center p-4 no-print" onclick="if(event.target === this) closeWaModal()">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.698.075-2.031-.476-1.525-.63-2.502-2.181-2.58-2.283-.075-.102-.622-.829-.622-1.58 0-.752.394-1.121.534-1.27.144-.15.312-.187.417-.187.106 0 .211.002.302.007.098.006.228-.037.357.272.132.318.45 1.096.49 1.177.04.08.067.174.013.28-.053.107-.08.174-.16.267-.08.094-.17.209-.243.281-.08.079-.164.165-.07.327.094.162.417.688.895 1.114.614.547 1.132.716 1.293.796.162.08.256.067.352-.042.095-.11.408-.475.517-.638.11-.162.219-.136.368-.081.15.053.953.449 1.117.531.164.081.273.122.313.19.04.068.04.394-.104.799z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold text-slate-900">Kirim Kwitansi via WhatsApp</h4>
                        <p class="text-[11px] text-slate-400">Penerima: {{ $student->name }} ({{ $student->nis }})</p>
                    </div>
                </div>
                <button type="button" onclick="closeWaModal()" class="text-slate-400 hover:text-slate-700 text-xl font-bold p-1">&times;</button>
            </div>

            <form action="{{ route('admin.students.send.receipt.wa', $student->id) }}" method="POST" id="sendWaForm" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp Siswa / Wali:</label>
                    <input 
                        type="text" 
                        name="phone" 
                        id="waPhoneInput"
                        value="{{ $student->phone }}" 
                        placeholder="Contoh: 081234567890" 
                        required 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    >
                    <p class="text-[10px] text-slate-400 mt-1">Format 08... atau 628... akan otomatis dikonversi oleh sistem.</p>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-1.5">
                    <p class="font-bold text-slate-800">Isi Notifikasi yang Dikirim:</p>
                    <ul class="text-[11px] text-slate-600 space-y-1 list-disc list-inside">
                        <li>Nomor Kwitansi: <span class="font-mono font-bold">{{ $receiptNo }}</span></li>
                        <li>Total Dana Diterima: <span class="font-bold text-emerald-700">Rp {{ number_format($student->paid_amount, 0, ',', '.') }}</span></li>
                        <li>Sisa Tanggungan: <span class="font-bold">{{ $student->remaining_balance <= 0 ? 'LUNAS' : 'Rp ' . number_format($student->remaining_balance, 0, ',', '.') }}</span></li>
                        <li>Tautan Kwitansi Digital Resmi (QR & Stempel Sah)</li>
                    </ul>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                    <button type="button" onclick="closeWaModal()" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitWa" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-md flex items-center gap-1.5">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.698.075-2.031-.476-1.525-.63-2.502-2.181-2.58-2.283-.075-.102-.622-.829-.622-1.58 0-.752.394-1.121.534-1.27.144-.15.312-.187.417-.187.106 0 .211.002.302.007.098.006.228-.037.357.272.132.318.45 1.096.49 1.177.04.08.067.174.013.28-.053.107-.08.174-.16.267-.08.094-.17.209-.243.281-.08.079-.164.165-.07.327.094.162.417.688.895 1.114.614.547 1.132.716 1.293.796.162.08.256.067.352-.042.095-.11.408-.475.517-.638.11-.162.219-.136.368-.081.15.053.953.449 1.117.531.164.081.273.122.313.19.04.068.04.394-.104.799z"/></svg>
                        <span>Kirim Sekarang</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openWaModal() {
            const modal = document.getElementById('waModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }
        function closeWaModal() {
            const modal = document.getElementById('waModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }
    </script>

</body>
</html>
