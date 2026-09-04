@extends('admin.layouts.admin')

@section('title', 'Executive Financial & Cashflow Forecasting')
@section('page_title', 'Eksekutif Dashboard Keuangan & Proyeksi Arus Kas')

@section('content')
<div class="space-y-8">
    
    <!-- Top Executive KPI Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Pendapatan Masuk -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-bold uppercase tracking-wider">Kas Masuk (Realized)</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="text-2xl font-black text-emerald-600">Rp {{ number_format($totalRealizedRevenue) }}</h3>
            <p class="text-[11px] text-slate-400 font-medium">Dari total omset Rp {{ number_format($totalPotentialRevenue) }}</p>
        </div>

        <!-- Total Piutang Siswa -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-bold uppercase tracking-wider">Piutang (Receivables)</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 text-japan-600 flex items-center justify-center">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="text-2xl font-black text-japan-600">Rp {{ number_format($totalReceivables) }}</h3>
            <p class="text-[11px] text-rose-500 font-bold">Tanggungan cicilan yang belum lunas</p>
        </div>

        <!-- Rasio Kolektibilitas Kas -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-bold uppercase tracking-wider">Rasio Pelunasan</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="pie-chart" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="text-2xl font-black text-blue-600">{{ $collectionRate }}%</h3>
            
            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $collectionRate }}%"></div>
            </div>
        </div>

        <!-- Siswa Status Pelunasan -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-bold uppercase tracking-wider">Status Pelunasan</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i data-lucide="users" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="flex items-center gap-2 pt-1">
                <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-xs font-black">{{ $statusCounts['lunas'] }} Lunas</span>
                <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800 text-xs font-black">{{ $statusCounts['sebagian'] }} Cicil</span>
                <span class="px-2 py-0.5 rounded bg-rose-100 text-rose-800 text-xs font-black">{{ $statusCounts['belum'] }} Belum</span>
            </div>
            <p class="text-[10px] text-slate-400">Total data siswa terdaftar</p>
        </div>

    </div>

    <!-- Cashflow Inflow Forecasting (30, 60, 90 Days) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Proyeksi Penerimaan Kas Masuk (Cash Inflow Forecast)</h3>
                    <p class="text-xs text-slate-400">Estimasi pencairan dana dari termin cicilan dan jadwal terbang siswa ke Jepang</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a 
                    href="{{ route('admin.finance.export.pdf') }}" 
                    target="_blank"
                    class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition shadow-xs flex items-center gap-1.5"
                    title="Cetak Laporan Eksekutif Keuangan & Proyeksi Arus Kas ke PDF"
                >
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    <span>Export PDF Keuangan</span>
                </a>
                <span class="px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100 hidden sm:inline-block">
                    Otomatis Berbasis Jadwal
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            
            <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50/50 border border-blue-100 space-y-2">
                <div class="flex items-center justify-between text-blue-700">
                    <span class="text-xs font-black uppercase">Proyeksi 30 Hari</span>
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div>
                <h4 class="text-2xl font-black text-slate-900">Rp {{ number_format($forecast30Days) }}</h4>
                <p class="text-[11px] text-slate-500">Estimasi pelunasan termin 1 dari siswa kelas pelatihan aktif.</p>
            </div>

            <div class="p-6 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50/50 border border-emerald-100 space-y-2">
                <div class="flex items-center justify-between text-emerald-700">
                    <span class="text-xs font-black uppercase">Proyeksi 60 Hari</span>
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div>
                <h4 class="text-2xl font-black text-slate-900">Rp {{ number_format($forecast60Days) }}</h4>
                <p class="text-[11px] text-slate-500">Estimasi pelunasan termin 2 & seleksi wawancara Kaisha.</p>
            </div>

            <div class="p-6 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-50/50 border border-amber-100 space-y-2">
                <div class="flex items-center justify-between text-amber-700">
                    <span class="text-xs font-black uppercase">Proyeksi 90 Hari</span>
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div>
                <h4 class="text-2xl font-black text-slate-900">Rp {{ number_format($forecast90Days) }}</h4>
                <p class="text-[11px] text-slate-500">Pelunasan penuh saat COE / Visa terbit menjelang terbang.</p>
            </div>

        </div>
    </div>

    <!-- Program Revenue Matrix Breakdown -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Komposisi Pendapatan per Program Karir</h3>
                <p class="text-xs text-slate-400">Analisis kinerja pendapatan berdasarkan jenis program pelatihan</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3.5 px-4">Program Karir</th>
                        <th class="py-3.5 px-4 text-center">Jumlah Siswa</th>
                        <th class="py-3.5 px-4">Potensi Omset</th>
                        <th class="py-3.5 px-4">Sudah Masuk (Kas)</th>
                        <th class="py-3.5 px-4">Sisa Piutang</th>
                        <th class="py-3.5 px-4 text-center">Progress Pelunasan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($programRevenue as $pr)
                        @php
                            $rate = $pr->total_potential > 0 ? round(($pr->total_collected / $pr->total_potential) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $pr->program }}
                            </td>
                            <td class="py-3.5 px-4 text-center font-extrabold text-blue-600">
                                {{ $pr->student_count }} Siswa
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-700">
                                Rp {{ number_format($pr->total_potential) }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-emerald-600">
                                Rp {{ number_format($pr->total_collected) }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-japan-600">
                                Rp {{ number_format($pr->total_outstanding) }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-20 bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $rate }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700">{{ $rate }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">Belum ada data keuangan program.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Outstanding Receivables Table (Daftar Siswa dengan Sisa Tanggungan Biaya) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Daftar Tanggungan Biaya Siswa (Aging Receivables)</h3>
                <p class="text-xs text-slate-400">Daftar siswa yang belum melunasi biaya dengan aksi pengingat WhatsApp</p>
            </div>
            <a href="{{ route('admin.students.export') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5">
                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                <span>Export Laporan CSV</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3.5 px-4">Nama Siswa</th>
                        <th class="py-3.5 px-4">Program</th>
                        <th class="py-3.5 px-4">Total Biaya</th>
                        <th class="py-3.5 px-4">Sudah Bayar</th>
                        <th class="py-3.5 px-4">Sisa Tanggungan</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi Follow-up</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($outstandingStudents as $s)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $s->name }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">NIS: {{ $s->nis }} • {{ $s->phone }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-semibold">{{ $s->program }}</td>
                            <td class="py-3.5 px-4 text-slate-600 font-mono">Rp {{ number_format($s->total_cost) }}</td>
                            <td class="py-3.5 px-4 text-emerald-600 font-bold font-mono">Rp {{ number_format($s->paid_amount) }}</td>
                            <td class="py-3.5 px-4 text-japan-600 font-black font-mono">Rp {{ number_format($s->remaining_balance) }}</td>
                            <td class="py-3.5 px-4">
                                @if(in_array($s->payment_status, ['partial', 'sebagian']))
                                    <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 font-black text-[10px]">Cicilan</span>
                                @elseif(in_array($s->payment_status, ['paid', 'lunas']))
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px]">Lunas</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800 font-black text-[10px]">Belum Bayar</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @php
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $s->phone);
                                    if (str_starts_with($cleanPhone, '0')) $cleanPhone = '62' . substr($cleanPhone, 1);
                                    $msg = "Halo Kak {$s->name} (NIS: {$s->nis}), kami informasikan sisa tanggungan biaya program {$s->program} sebesar Rp " . number_format($s->remaining_balance) . ". Harap melakukan konfirmasi pembayaran ya Kak. Terima kasih!";
                                @endphp
                                <a 
                                    href="https://api.whatsapp.com/send?phone={{ $cleanPhone }}&text={{ urlencode($msg) }}" 
                                    target="_blank" 
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-xs transition"
                                    title="Kirim Pengingat WhatsApp"
                                >
                                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                    <span>Ingatkan WA</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-xs">Semua biaya siswa telah lunas!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($outstandingStudents->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $outstandingStudents->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
