<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran - {{ $student->name }} ({{ $receiptNo }})</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                padding: 0 !important;
            }
            .page-container {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 font-sans p-4 sm:p-8">

    <!-- Top Action Bar (No-Print) -->
    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ auth()->check() ? route('admin.students.index') : route('student.portal') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-50 transition flex items-center gap-1.5 shadow-xs">
            &larr; {{ auth()->check() ? 'Kembali ke Data Siswa' : 'Kembali ke Portal Siswa' }}
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ auth()->check() ? route('admin.students.invoice', $student->id) : route('student.public.invoice', $student->nis) }}" class="px-4 py-2 rounded-xl bg-blue-50 text-blue-700 border border-blue-200 text-xs font-bold hover:bg-blue-100 transition">
                Cetak Invoice Tagihan
            </a>
            <button onclick="window.print()" class="px-5 py-2 rounded-xl bg-red-600 text-white text-xs font-bold hover:bg-red-700 transition shadow-md flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- Official Receipt Paper (A4 Canvas) -->
    <div class="page-container max-w-3xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8 sm:p-12 relative overflow-hidden">
        
        <!-- Watermark LPK SJI -->
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none select-none">
            <span class="text-9xl font-black">友好日本</span>
        </div>

        <!-- Official Header (Kop Surat) -->
        <div class="border-b-2 border-slate-900 pb-6 flex items-start justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="w-16 h-16 rounded-2xl bg-red-600 text-white flex items-center justify-center font-bold text-3xl shadow-md flex-shrink-0">
                    友
                </div>
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
                <p class="text-xs font-mono font-bold text-slate-900">{{ $receiptNo }}</p>
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
                        <span class="text-xs text-slate-500 font-mono ml-2">(NIS: {{ $student->nis }})</span>
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
                
                <!-- Digital Stamp Badge -->
                <div class="h-20 flex items-center justify-center relative">
                    <div class="w-28 h-16 rounded-full border-2 border-red-600/80 text-red-600 font-bold text-[10px] flex flex-col items-center justify-center rotate-[-6deg] select-none bg-red-50/40">
                        <span class="tracking-widest uppercase text-[9px] font-black">LPK SAHABAT JEPANG</span>
                        <span class="text-xs font-black">LUNAS / VERIFIED</span>
                        <span class="text-[8px] tracking-tight">KEMNAKER RI</span>
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

</body>
</html>
