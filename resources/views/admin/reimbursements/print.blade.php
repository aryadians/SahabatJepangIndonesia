<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar SPJ Reimbursement - {{ $reimbursement->reimbursement_no }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; font-size: 11pt; }
            @page { margin: 1.5cm; size: A4 portrait; }
        }
        @media screen {
            body { background: #f1f5f9; padding: 2rem; }
            .sheet {
                max-width: 210mm;
                margin: 0 auto;
                background: white;
                padding: 2.5cm;
                box-shadow: 0 4px 20px rgba(0,0,0,0.08);
                border-radius: 8px;
            }
        }
    </style>
</head>
<body class="text-slate-900 font-sans antialiased">

    <!-- Top Action Bar (No Print) -->
    <div class="no-print max-w-[210mm] mx-auto mb-6 flex items-center justify-between bg-slate-900 text-white px-6 py-3 rounded-2xl shadow-md">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.reimbursements.index') }}" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-xs font-bold transition flex items-center gap-1">
                ← Kembali
            </a>
            <span class="text-xs font-bold text-slate-300">Format Cetak Resmi SPJ (A4)</span>
        </div>
        <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-black shadow-md flex items-center gap-2 transition">
            🖨️ Cetak Lembar SPJ Sekarang
        </button>
    </div>

    <!-- Printable A4 Sheet -->
    <div class="sheet space-y-6">

        <!-- 1. Official Kop Surat -->
        @include('components.kop-surat')

        <!-- 2. Document Title -->
        <div class="text-center border-b-2 border-slate-900 pb-3 pt-2">
            <h2 class="text-lg font-black uppercase tracking-wider text-slate-900">
                SURAT PERTANGGUNGJAWABAN (SPJ) BIAYA PERJALANAN DINAS & KASBON
            </h2>
            <p class="text-xs font-mono font-bold text-slate-600 mt-1">
                Nomor: {{ $reimbursement->reimbursement_no }}
            </p>
        </div>

        <!-- 3. Employee & Trip Details -->
        <div class="grid grid-cols-2 gap-4 text-xs">
            <div class="space-y-1.5">
                <div class="flex">
                    <span class="w-32 font-bold text-slate-500">Nama Karyawan</span>
                    <span class="font-bold text-slate-900">: {{ $reimbursement->employee_name }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-bold text-slate-500">NIP / Jabatan</span>
                    <span class="font-medium text-slate-800">: {{ $reimbursement->employee ? ($reimbursement->employee->position_title ?: $reimbursement->employee->role_badge['label']) : '-' }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-bold text-slate-500">Divisi / Dept</span>
                    <span class="font-medium text-slate-800">: {{ $reimbursement->employee->department ?? 'Operasional & Kemitraan' }}</span>
                </div>
            </div>

            <div class="space-y-1.5">
                <div class="flex">
                    <span class="w-32 font-bold text-slate-500">Jenis Dokumen</span>
                    <span class="font-bold text-slate-900">: {{ $reimbursement->type_badge['label'] }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-bold text-slate-500">Tujuan Dinas</span>
                    <span class="font-medium text-slate-800">: {{ $reimbursement->destination ?: '-' }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-bold text-slate-500">Waktu Kegiatan</span>
                    <span class="font-medium text-slate-800">: 
                        {{ $reimbursement->start_date ? $reimbursement->start_date->format('d M Y') : '-' }} 
                        {{ $reimbursement->end_date ? ' s/d ' . $reimbursement->end_date->format('d M Y') : '' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Keperluan Kegiatan -->
        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs space-y-1">
            <span class="font-bold text-slate-500 uppercase tracking-wider text-[10px] block">Maksud / Keperluan Dinas:</span>
            <p class="font-bold text-slate-900 leading-relaxed">{{ $reimbursement->title }}</p>
            @if($reimbursement->notes)
                <p class="text-slate-600 text-[11px] pt-1 border-t border-slate-200 mt-1 whitespace-pre-line">{{ $reimbursement->notes }}</p>
            @endif
        </div>

        <!-- 4. Financial Calculation Table -->
        <div class="space-y-2">
            <h4 class="font-black text-xs uppercase tracking-wider text-slate-800">
                Rincian Rekonsiliasi Keuangan & Kas:
            </h4>
            <table class="w-full text-xs border border-slate-300">
                <thead class="bg-slate-100 text-slate-700 font-bold border-b border-slate-300">
                    <tr>
                        <th class="p-2 border-r border-slate-300 text-left">Deskripsi Komponen Biaya</th>
                        <th class="p-2 border-r border-slate-300 text-right w-44">Jumlah (Rupiah)</th>
                        <th class="p-2 text-left w-52">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr>
                        <td class="p-2 border-r border-slate-300 font-medium">1. Nominal Pengajuan Awal</td>
                        <td class="p-2 border-r border-slate-300 text-right font-bold">
                            Rp {{ number_format($reimbursement->amount_requested, 0, ',', '.') }}
                        </td>
                        <td class="p-2 text-slate-500">Estimasi biaya diajukan</td>
                    </tr>
                    <tr>
                        <td class="p-2 border-r border-slate-300 font-medium">2. Uang Muka / Dicairkan Bendahara</td>
                        <td class="p-2 border-r border-slate-300 text-right font-bold text-slate-900">
                            Rp {{ number_format($reimbursement->amount_approved, 0, ',', '.') }}
                        </td>
                        <td class="p-2 text-slate-500">Dana kas yang diserahkan</td>
                    </tr>
                    @if($reimbursement->type === 'cash_advance')
                        <tr>
                            <td class="p-2 border-r border-slate-300 font-medium">3. Realisasi Pengeluaran Aktual (SPJ)</td>
                            <td class="p-2 border-r border-slate-300 text-right font-bold text-slate-900">
                                Rp {{ number_format($reimbursement->amount_spent, 0, ',', '.') }}
                            </td>
                            <td class="p-2 text-slate-500">Berdasarkan lampiran kuitansi</td>
                        </tr>
                        <tr class="bg-slate-50 font-black">
                            <td class="p-2 border-r border-slate-300">
                                4. Selisih Uang Muka vs Realisasi
                            </td>
                            <td class="p-2 border-r border-slate-300 text-right {{ $reimbursement->amount_diff > 0 ? 'text-rose-600' : ($reimbursement->amount_diff < 0 ? 'text-emerald-700' : 'text-slate-900') }}">
                                Rp {{ number_format(abs($reimbursement->amount_diff), 0, ',', '.') }}
                            </td>
                            <td class="p-2 text-xs">
                                @if($reimbursement->amount_diff > 0)
                                    <span class="text-rose-600 font-bold">Kurang Bayar (Diganti Bendahara)</span>
                                @elseif($reimbursement->amount_diff < 0)
                                    <span class="text-emerald-700 font-bold">Lebih Bayar (Dikembalikan ke Kasir)</span>
                                @else
                                    <span class="text-slate-600">Sesuai / Pas (Nihil)</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- 5. Attached Receipts Base64 Display -->
        @if(!empty($reimbursement->receipts_data) && count($reimbursement->receipts_data) > 0)
            <div class="space-y-3 pt-2">
                <h4 class="font-black text-xs uppercase tracking-wider text-slate-800">
                    Lampiran Bukti Nota & Kuitansi Fisik (Arsip Digital):
                </h4>
                <div class="grid grid-cols-3 gap-3">
                    @foreach($reimbursement->receipts_data as $rc)
                        <div class="border border-slate-200 rounded-xl p-2 bg-slate-50 space-y-1.5 text-[10px]">
                            <div class="h-28 rounded-lg overflow-hidden bg-white border border-slate-200 flex items-center justify-center">
                                @if(!empty($rc['base64_image']) && str_starts_with($rc['base64_image'], 'data:image/'))
                                    <img src="{{ $rc['base64_image'] }}" alt="{{ $rc['title'] }}" class="w-full h-full object-contain">
                                @else
                                    <div class="text-center p-2 text-slate-400">
                                        <span>Dokumen PDF / Berkas</span>
                                    </div>
                                @endif
                            </div>
                            <p class="font-bold text-slate-800 truncate" title="{{ $rc['title'] }}">{{ $rc['title'] }}</p>
                            @if(!empty($rc['amount']))
                                <p class="font-mono text-slate-600">Rp {{ number_format($rc['amount'], 0, ',', '.') }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 6. Official 3 Signature Blocks -->
        <div class="pt-8">
            <div class="grid grid-cols-3 gap-4 text-center text-xs">
                
                <!-- 1. Yang Mengajukan -->
                <div class="space-y-16">
                    <p class="font-bold text-slate-600">Yang Mengajukan / Karyawan,</p>
                    <div>
                        <p class="font-black text-slate-900 underline">{{ $reimbursement->employee_name }}</p>
                        <p class="text-[10px] text-slate-500">Pemohon Dinas</p>
                    </div>
                </div>

                <!-- 2. Bendahara Keuangan -->
                <div class="space-y-16">
                    <p class="font-bold text-slate-600">Mengetahui & Verifikasi,</p>
                    <div>
                        <p class="font-black text-slate-900 underline">{{ $reimbursement->approved_by ?: 'Bendahara Keuangan' }}</p>
                        <p class="text-[10px] text-slate-500">Bagian Keuangan & Kas</p>
                    </div>
                </div>

                <!-- 3. Direktur / Pimpinan -->
                <div class="space-y-16">
                    <p class="font-bold text-slate-600">Menyetujui,</p>
                    <div>
                        <p class="font-black text-slate-900 underline">Direktur Utama</p>
                        <p class="text-[10px] text-slate-500">LPK Sahabat Jepang Indonesia</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="pt-6 border-t border-slate-200 text-center text-[10px] text-slate-400 font-mono">
            Dokumen resmi LPK Sahabat Jepang Indonesia • Dicetak otomatis pada {{ now()->format('d/m/Y H:i:s') }} WIB
        </div>

    </div>

</body>
</html>
