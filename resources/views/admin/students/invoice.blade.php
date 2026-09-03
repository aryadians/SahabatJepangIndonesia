<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Tagihan Biaya - {{ $student->name }} ({{ $invoiceNo }})</title>
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
            <a href="{{ auth()->check() ? route('admin.students.receipt', $student->id) : route('student.public.receipt', $student->nis) }}" class="px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold hover:bg-emerald-100 transition">
                Cetak Kwitansi Pembayaran
            </a>
            <button onclick="window.print()" class="px-5 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition shadow-md flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak Invoice Tagihan</span>
            </button>
        </div>
    </div>

    <!-- Official Invoice Paper (A4 Canvas) -->
    <div class="page-container max-w-3xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8 sm:p-12 relative overflow-hidden">
        
        <!-- Watermark LPK SJI -->
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none select-none">
            <span class="text-9xl font-black">友好日本</span>
        </div>

        <!-- Official Header (Kop Surat) -->
        <div class="border-b-2 border-slate-900 pb-6 flex items-start justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="w-16 h-16 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-bold text-3xl shadow-md flex-shrink-0">
                    友
                </div>
                <div>
                    <h1 class="text-xl font-black tracking-tight text-slate-900 uppercase leading-none">
                        {{ $settings['site_name'] ?? 'LPK SAHABAT JEPANG INDONESIA' }}
                    </h1>
                    <p class="text-xs font-bold text-slate-700 mt-1">
                        Invoice Tagihan Resmi Biaya Pelatihan & Penyaluran Kerja Jepang
                    </p>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                        Izin SO Kemnaker RI: KEP.224/LATTAS/XII/2023 • Akreditasi Lembaga: LA-LPK A<br>
                        Jl. Sakura Raya No. 88, Jakarta Selatan • Telp: +62 812-3456-7890
                    </p>
                </div>
            </div>

            <!-- Invoice Meta -->
            <div class="text-right flex-shrink-0">
                <span class="inline-block px-3 py-1 bg-slate-100 text-slate-800 text-xs font-black rounded-lg uppercase tracking-wider mb-2">
                    INVOICE TAGIHAN
                </span>
                <p class="text-xs font-mono font-bold text-slate-900">{{ $invoiceNo }}</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Tanggal Tagihan: {{ date('d F Y') }}</p>
            </div>
        </div>

        <!-- Bill To Section -->
        <div class="py-6 border-b border-slate-100 grid grid-cols-2 gap-6">
            <div>
                <p class="text-[11px] font-bold uppercase text-slate-400 tracking-wider">Ditagihkan Kepada:</p>
                <h3 class="text-base font-black text-slate-900 mt-1">{{ $student->name }}</h3>
                <p class="text-xs text-slate-600 mt-0.5">Nomor Induk Siswa (NIS): <span class="font-mono font-bold">{{ $student->nis }}</span></p>
                <p class="text-xs text-slate-600">No. WhatsApp: {{ $student->phone ?? '-' }}</p>
                <p class="text-xs text-slate-600">Kota Asal: {{ $student->city ?? 'Indonesia' }}</p>
            </div>

            <div class="text-right">
                <p class="text-[11px] font-bold uppercase text-slate-400 tracking-wider">Rincian Program & Angkatan:</p>
                <p class="text-xs font-bold text-slate-900 mt-1">{{ $student->program }}</p>
                <p class="text-xs text-slate-600">Angkatan / Batch: {{ $student->batch ?? 'Batch Reguler' }}</p>
                <p class="text-xs text-slate-600">Skema Biaya: <span class="font-bold uppercase text-japan-600">{{ $student->payment_scheme }}</span></p>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="py-6 space-y-4">
            <table class="w-full text-xs sm:text-sm">
                <thead>
                    <tr class="border-b-2 border-slate-200 text-slate-500 font-bold uppercase text-[10px]">
                        <th class="py-2.5 text-left">Komponen Pembiayaan</th>
                        <th class="py-2.5 text-right">Nominal (IDR)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="py-3">
                            <p class="font-bold text-slate-900">Total Paket Biaya Pelatihan & Penempatan Jepang</p>
                            <p class="text-xs text-slate-500">Mencakup modul bahasa Jepang N5/N4, asrama, bimbingan wawancara kaisha, sertifikat SSW, pengurusan CoE dan Visa kerja resmi Kemnaker RI.</p>
                        </td>
                        <td class="py-3 text-right font-bold text-slate-900 font-mono">
                            Rp {{ number_format($student->total_cost, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="bg-emerald-50/50">
                        <td class="py-3 text-emerald-800 font-bold">
                            Telah Dibayar (Total Realized Payment)
                        </td>
                        <td class="py-3 text-right font-black text-emerald-700 font-mono">
                            - Rp {{ number_format($student->paid_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="border-t-2 border-slate-900 bg-slate-50">
                        <td class="py-4 font-black text-sm text-slate-900 uppercase">
                            Sisa Tagihan yang Harus Dibayar
                        </td>
                        <td class="py-4 text-right font-black text-lg text-red-600 font-mono">
                            Rp {{ number_format($student->remaining_balance, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>

            @if($student->remaining_balance > 0)
                <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-xs italic text-amber-900">
                    Terbilang sisa tagihan: "<b>{{ $terbilangRemaining }}</b>"
                </div>
            @endif
        </div>

        <!-- Payment Instructions & Bank Transfer Details -->
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <h4 class="text-xs font-black uppercase text-slate-900 tracking-wider">Instruksi Pembayaran Resmi:</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-3 bg-white rounded-xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Rekening Bank Mandiri</span>
                    <p class="font-mono font-black text-sm text-slate-900 mt-0.5">123-00-9876543-2</p>
                    <p class="text-[11px] text-slate-500">a.n. LPK SAHABAT JEPANG INDONESIA</p>
                </div>
                <div class="p-3 bg-white rounded-xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Rekening Bank BCA</span>
                    <p class="font-mono font-black text-sm text-slate-900 mt-0.5">889-0123-456</p>
                    <p class="text-[11px] text-slate-500">a.n. LPK SAHABAT JEPANG INDONESIA</p>
                </div>
            </div>
            <p class="text-[11px] text-slate-500">Harap cantumkan keterangan transfer: <b>NIS {{ $student->nis }} - {{ $student->name }}</b> dan konfirmasikan bukti transfer ke WhatsApp Keuangan LPK (+62 812-3456-7890).</p>
        </div>

        <!-- Signature Section -->
        <div class="border-t border-slate-200 pt-6 mt-6 flex items-end justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('document.verify', ['code' => str_replace('/', '-', $invoiceNo)]) }}" target="_blank" class="block w-20 h-20 border border-slate-200 rounded-xl p-1 bg-white flex items-center justify-center hover:border-red-500 transition shadow-2xs" title="Klik untuk verifikasi keaslian invoice">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('document.verify', ['code' => str_replace('/', '-', $invoiceNo)])) }}" alt="QR Verifikasi" class="w-full h-full object-contain">
                </a>
                <div class="text-[10px] text-slate-500 max-w-xs leading-tight">
                    <a href="{{ route('document.verify', ['code' => str_replace('/', '-', $invoiceNo)]) }}" target="_blank" class="font-bold text-slate-800 hover:text-red-600 block">
                        Scan / Cek Keaslian Invoice &rarr;
                    </a>
                    <p class="text-slate-400 mt-0.5">Invoice ini sah & terdaftar secara digital di basis data server resmi LPK Sahabat Jepang Indonesia.</p>
                </div>
            </div>

            <div class="text-center w-56 space-y-1">
                <p class="text-xs text-slate-500">Jakarta, {{ date('d F Y') }}</p>
                <p class="text-xs font-bold text-slate-700">Manajemen Keuangan LPK</p>
                <div class="h-16 flex items-center justify-center">
                    <span class="text-xs font-japanese font-bold text-slate-400">[Official Digital Seal]</span>
                </div>
                <p class="text-xs font-black text-slate-900 underline underline-offset-4">LPK Sahabat Jepang</p>
            </div>
        </div>

    </div>

</body>
</html>
