<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $transaction->type === 'income' ? 'Bukti Kas Masuk (BKM)' : 'Bukti Kas Keluar (BKK)' }} - {{ $transaction->transaction_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Noto+Sans+JP:wght@500;700;900&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        .font-japanese {
            font-family: 'Noto Sans JP', sans-serif;
        }
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
                border: 1px solid #CBD5E1 !important;
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
    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('admin.cash-book.index') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-50 transition flex items-center gap-1.5 shadow-xs">
            &larr; Kembali ke Buku Kas Umum
        </a>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-5 py-2 rounded-xl bg-slate-900 text-white text-xs font-black hover:bg-slate-800 transition shadow-md flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak Lembar Voucher Kas (A4)</span>
            </button>
        </div>
    </div>

    <!-- Official Voucher Paper (A4 Canvas) -->
    <div class="page-container max-w-3xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8 sm:p-12 relative overflow-hidden">
        
        <!-- Watermark LPK SJI -->
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none select-none">
            <span class="text-9xl font-black font-japanese">友好日本</span>
        </div>

        <!-- 1. Official Kop Surat -->
        @include('components.kop-surat', [
            'code' => $transaction->transaction_number,
            'status' => 'TERBUKUKAN',
            'date' => \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('d F Y')
        ])

        <!-- 2. Document Title Banner -->
        <div class="text-center pb-4 pt-1">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full {{ $transaction->type === 'income' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200' }} text-xs font-black uppercase tracking-wider mb-2">
                <span>{{ $transaction->type === 'income' ? '📥 BUKTI KAS MASUK (BKM)' : '📤 BUKTI KAS KELUAR (BKK)' }}</span>
            </div>
            <h2 class="text-base font-black text-slate-900 tracking-tight">
                {{ $transaction->type === 'income' ? 'VOUCHER PENERIMAAN KAS & BANK' : 'VOUCHER PENGELUARAN KAS & BANK' }}
            </h2>
            <p class="text-[11px] text-slate-500 font-mono">
                No. Register: <strong>{{ $transaction->transaction_number }}</strong>
            </p>
        </div>

        <!-- 3. Voucher Transaction Details Table -->
        <div class="py-4 space-y-4">
            <table class="w-full text-xs sm:text-sm">
                <!-- Pihak Terkait -->
                <tr class="border-b border-slate-100">
                    <td class="py-3 font-bold text-slate-400 w-44">
                        {{ $transaction->type === 'income' ? 'Diterima Dari' : 'Dibayarkan Kepada' }}
                    </td>
                    <td class="py-3 font-bold text-slate-900">
                        @if($transaction->student)
                            <span class="text-sm font-black">{{ $transaction->student->name }}</span>
                            <span class="text-xs text-slate-500 font-mono ml-2">(NIS: {{ $transaction->student->nis }} • {{ $transaction->student->program }})</span>
                        @elseif($transaction->teacher)
                            <span class="text-sm font-black">{{ $transaction->teacher->name }}</span>
                            <span class="text-xs text-slate-500 font-mono ml-2">({{ $transaction->teacher->nip }} • {{ $transaction->teacher->position_title ?: 'Sensei' }})</span>
                        @elseif($transaction->affiliate)
                            <span class="text-sm font-black">{{ $transaction->affiliate->coordinator_name }}</span>
                            <span class="text-xs text-slate-500 ml-2">({{ $transaction->affiliate->school_institution_name }})</span>
                        @elseif($transaction->reimbursement)
                            <span class="text-sm font-black">{{ $transaction->reimbursement->employee_name }}</span>
                            <span class="text-xs text-slate-500 font-mono ml-2">(SPJ No: {{ $transaction->reimbursement->reimbursement_no }})</span>
                        @else
                            <span class="text-sm font-black">{{ $transaction->title }}</span>
                        @endif
                    </td>
                </tr>

                <!-- Akun Kas / Bank -->
                <tr class="border-b border-slate-100">
                    <td class="py-3 font-bold text-slate-400">Akun Kas / Bank</td>
                    <td class="py-3 font-semibold text-slate-800 flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-800 font-mono font-bold text-xs">
                            {{ $transaction->payment_method_label }}
                        </span>
                        <span class="text-xs text-slate-400">
                            ({{ in_array($transaction->payment_method, ['cash', 'petty_cash']) ? 'Kas Tunai Kasir' : 'Rekening Bank Resmi LPK' }})
                        </span>
                    </td>
                </tr>

                <!-- Kategori Akun Keuangan -->
                <tr class="border-b border-slate-100">
                    <td class="py-3 font-bold text-slate-400">Pos / Kategori Akun</td>
                    <td class="py-3 font-semibold text-slate-800">
                        <span class="font-bold text-slate-900">{{ $transaction->category_label }}</span>
                        <span class="text-xs text-slate-400 ml-2">({{ $transaction->type === 'income' ? 'Akun Pendapatan / Debit' : 'Akun Beban Operasional / Kredit' }})</span>
                    </td>
                </tr>

                <!-- Tanggal Transaksi -->
                <tr class="border-b border-slate-100">
                    <td class="py-3 font-bold text-slate-400">Tanggal Transaksi</td>
                    <td class="py-3 font-semibold text-slate-800 font-mono">
                        {{ \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('l, d F Y') }}
                    </td>
                </tr>

                <!-- Uraian Keperluan -->
                <tr class="border-b border-slate-100">
                    <td class="py-3 font-bold text-slate-400">Uraian / Keterangan</td>
                    <td class="py-3 text-slate-800 font-medium leading-relaxed">
                        <div class="font-bold text-slate-900">{{ $transaction->title }}</div>
                        @if($transaction->notes)
                            <p class="text-xs text-slate-500 mt-1 italic">Memo: "{{ $transaction->notes }}"</p>
                        @endif
                    </td>
                </tr>

                <!-- Nominal Transaksi -->
                <tr class="border-b border-slate-100">
                    <td class="py-3 font-bold text-slate-400">Jumlah Uang</td>
                    <td class="py-3">
                        <span class="text-2xl font-black {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }} font-mono">
                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </span>
                    </td>
                </tr>

                <!-- Terbilang -->
                <tr class="border-b border-slate-100 bg-slate-50/70">
                    <td class="py-3 px-3 font-bold text-slate-500">Terbilang</td>
                    <td class="py-3 px-3 italic font-semibold text-slate-800">
                        "{{ $terbilang }}"
                    </td>
                </tr>
            </table>

            <!-- Lampiran Bukti Fisik / Nota Transfer jika ada -->
            @if(!empty($transaction->proof_file))
                <div class="mt-4 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <h4 class="text-xs font-black uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                        <span>📎 Lampiran Bukti Transaksi / Nota / Slip Transfer</span>
                    </h4>
                    @if(str_starts_with($transaction->proof_file, 'data:image/') || str_ends_with($transaction->proof_file, '.jpg') || str_ends_with($transaction->proof_file, '.png') || str_ends_with($transaction->proof_file, '.jpeg'))
                        <div class="max-h-48 overflow-hidden rounded-xl border border-slate-200 bg-white inline-block">
                            <img src="{{ $transaction->proof_file }}" alt="Bukti Kas {{ $transaction->transaction_number }}" class="max-h-48 object-contain">
                        </div>
                    @else
                        <div class="text-xs text-slate-600 font-mono">
                            Dokumen terlampir: File PDF / Arsip Digital Transaksi Kas.
                        </div>
                    @endif
                </div>
            @endif

            <!-- 4. Lembar Otorisasi & Tanda Tangan Resmi (3 Pihak) -->
            <div class="pt-8 mt-6 border-t border-slate-200">
                <div class="text-right text-xs text-slate-500 mb-6">
                    Jakarta, {{ \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('d F Y') }}
                </div>

                <div class="grid grid-cols-3 gap-6 text-center text-xs">
                    <!-- Kolom 1: Mengetahui / Pimpinan -->
                    <div class="flex flex-col justify-between h-36">
                        <div>
                            <p class="font-bold text-slate-500 uppercase text-[11px]">Mengetahui,</p>
                            <p class="text-[10px] text-slate-400">Pimpinan / Direktur LPK</p>
                        </div>
                        <div>
                            <div class="border-b border-slate-900 mx-auto w-4/5 pb-1 font-bold text-slate-900">
                                Direktur Utama
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1">LPK Sahabat Jepang Indonesia</p>
                        </div>
                    </div>

                    <!-- Kolom 2: Diperiksa & Dibukukan / Keuangan -->
                    <div class="flex flex-col justify-between h-36">
                        <div>
                            <p class="font-bold text-slate-500 uppercase text-[11px]">Diperiksa & Dibukukan,</p>
                            <p class="text-[10px] text-slate-400">Bagian Keuangan / Kasir</p>
                        </div>
                        <div>
                            <div class="border-b border-slate-900 mx-auto w-4/5 pb-1 font-bold text-slate-900">
                                {{ $transaction->recorded_by ?: 'Admin Keuangan' }}
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1">Staf Pembukuan Kas</p>
                        </div>
                    </div>

                    <!-- Kolom 3: Penyetor / Penerima Dana -->
                    <div class="flex flex-col justify-between h-36">
                        <div>
                            <p class="font-bold text-slate-500 uppercase text-[11px]">
                                {{ $transaction->type === 'income' ? 'Penyetor Dana,' : 'Penerima Dana,' }}
                            </p>
                            <p class="text-[10px] text-slate-400">Tanda Tangan & Nama Terang</p>
                        </div>
                        <div>
                            <div class="border-b border-slate-900 mx-auto w-4/5 pb-1 font-bold text-slate-900">
                                @if($transaction->student)
                                    {{ $transaction->student->name }}
                                @elseif($transaction->teacher)
                                    {{ $transaction->teacher->name }}
                                @elseif($transaction->affiliate)
                                    {{ $transaction->affiliate->coordinator_name }}
                                @elseif($transaction->reimbursement)
                                    {{ $transaction->reimbursement->employee_name }}
                                @else
                                    ( ........................................ )
                                @endif
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1">Pihak Bersangkutan</p>
                        </div>
                    </div>
                </div>

                <!-- Footer Peruntukan Lembar Dokumen -->
                <div class="mt-8 pt-4 border-t border-dashed border-slate-200 flex items-center justify-between text-[10px] text-slate-400">
                    <span>Dokumen Sah Sistem Akuntansi LPK Sahabat Jepang Indonesia</span>
                    <span>Lembar 1: Arsip Pembukuan Keuangan • Lembar 2: Pihak Terkait</span>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
