<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Reimburse & Kasbon Dinas LPK SJI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; font-size: 10pt; }
            @page { margin: 1.2cm; size: A4 landscape; }
        }
        @media screen {
            body { background: #f8fafc; padding: 2rem; }
            .sheet {
                max-width: 297mm;
                margin: 0 auto;
                background: white;
                padding: 1.5cm;
                box-shadow: 0 4px 20px rgba(0,0,0,0.08);
                border-radius: 8px;
            }
        }
    </style>
</head>
<body class="text-slate-900 font-sans antialiased">

    <!-- Action Bar -->
    <div class="no-print max-w-[297mm] mx-auto mb-6 flex items-center justify-between bg-slate-900 text-white px-6 py-3 rounded-2xl shadow-md">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.reimbursements.index') }}" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-xs font-bold transition">
                ← Kembali ke Portal
            </a>
            <span class="text-xs font-bold text-slate-300">Rekapitulasi Keuangan Dinas (A4 Landscape)</span>
        </div>
        <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-black shadow-md flex items-center gap-2 transition">
            🖨️ Cetak / Simpan PDF
        </button>
    </div>

    <!-- Printable Sheet -->
    <div class="sheet space-y-5">
        
        <!-- Kop Surat -->
        @include('components.kop-surat')

        <div class="text-center border-b-2 border-slate-900 pb-2">
            <h2 class="text-base font-black uppercase tracking-wider text-slate-900">
                LAPORAN REKAPITULASI KLAIM REIMBURSEMENT & KASBON PERJALANAN DINAS
            </h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Periode Cetak: {{ now()->format('d F Y') }} • Total Data: {{ count($reimbursements) }} Transaksi
            </p>
        </div>

        <!-- Table -->
        <table class="w-full text-[11px] border border-slate-300">
            <thead class="bg-slate-100 text-slate-800 font-bold border-b border-slate-300">
                <tr>
                    <th class="p-2 border-r border-slate-300 text-center w-8">No</th>
                    <th class="p-2 border-r border-slate-300 text-left">No. Dokumen</th>
                    <th class="p-2 border-r border-slate-300 text-left">Tipe</th>
                    <th class="p-2 border-r border-slate-300 text-left">Nama Karyawan</th>
                    <th class="p-2 border-r border-slate-300 text-left">Keperluan & Tujuan Dinas</th>
                    <th class="p-2 border-r border-slate-300 text-right">Diajukan</th>
                    <th class="p-2 border-r border-slate-300 text-right">Disetujui / Kasbon</th>
                    <th class="p-2 border-r border-slate-300 text-right">Realisasi SPJ</th>
                    <th class="p-2 border-r border-slate-300 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @php
                    $totalRequested = 0;
                    $totalApproved = 0;
                    $totalSpent = 0;
                @endphp
                @forelse($reimbursements as $idx => $r)
                    @php
                        $totalRequested += $r->amount_requested;
                        $totalApproved += $r->amount_approved;
                        $totalSpent += $r->amount_spent;
                    @endphp
                    <tr>
                        <td class="p-2 border-r border-slate-300 text-center">{{ $idx + 1 }}</td>
                        <td class="p-2 border-r border-slate-300 font-mono font-bold">{{ $r->reimbursement_no }}</td>
                        <td class="p-2 border-r border-slate-300">{{ $r->type_badge['short_label'] }}</td>
                        <td class="p-2 border-r border-slate-300 font-bold">{{ $r->employee_name }}</td>
                        <td class="p-2 border-r border-slate-300">
                            <span class="font-semibold">{{ $r->title }}</span>
                            @if($r->destination)
                                <span class="text-slate-500 block text-[10px]">Tujuan: {{ $r->destination }}</span>
                            @endif
                        </td>
                        <td class="p-2 border-r border-slate-300 text-right">Rp {{ number_format($r->amount_requested, 0, ',', '.') }}</td>
                        <td class="p-2 border-r border-slate-300 text-right font-bold">Rp {{ number_format($r->amount_approved, 0, ',', '.') }}</td>
                        <td class="p-2 border-r border-slate-300 text-right">
                            {{ $r->type === 'cash_advance' && $r->amount_spent > 0 ? 'Rp ' . number_format($r->amount_spent, 0, ',', '.') : '-' }}
                        </td>
                        <td class="p-2 border-r border-slate-300 text-center font-bold">
                            {{ $r->status_badge['label'] }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-6 text-center text-slate-400">Tidak ada data transaksi.</td>
                    </tr>
                @endforelse
                <tr class="bg-slate-100 font-black">
                    <td colspan="5" class="p-2 text-right border-r border-slate-300 uppercase">Total Akumulasi:</td>
                    <td class="p-2 text-right border-r border-slate-300">Rp {{ number_format($totalRequested, 0, ',', '.') }}</td>
                    <td class="p-2 text-right border-r border-slate-300 text-japan-700">Rp {{ number_format($totalApproved, 0, ',', '.') }}</td>
                    <td class="p-2 text-right border-r border-slate-300">Rp {{ number_format($totalSpent, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- Signatures -->
        <div class="pt-6 grid grid-cols-2 gap-8 text-xs text-center">
            <div class="space-y-16">
                <p class="font-bold text-slate-600">Diverifikasi oleh Bendahara Keuangan,</p>
                <div>
                    <p class="font-black text-slate-900 underline">Bagian Keuangan & Kas</p>
                    <p class="text-[10px] text-slate-500">LPK Sahabat Jepang Indonesia</p>
                </div>
            </div>

            <div class="space-y-16">
                <p class="font-bold text-slate-600">Mengetahui & Menyetujui,</p>
                <div>
                    <p class="font-black text-slate-900 underline">Direktur Utama</p>
                    <p class="text-[10px] text-slate-500">LPK Sahabat Jepang Indonesia</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
