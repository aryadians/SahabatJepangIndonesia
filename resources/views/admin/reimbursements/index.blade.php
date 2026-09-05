@extends('admin.layouts.admin')

@section('title', 'Klaim Reimburse & Kasbon Dinas')
@section('page_title', 'Reimbursement & Uang Muka Dinas (Cash Advance)')

@section('content')
<div class="space-y-6">

    <!-- 1. Top KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Reimburse Dicairkan</p>
                <h3 class="text-xl font-black text-slate-900 mt-0.5">Rp {{ number_format($stats['total_reimbursed'], 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                <i data-lucide="plane-takeoff" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Uang Muka Berjalan (Kasbon)</p>
                <h3 class="text-xl font-black text-purple-600 mt-0.5">Rp {{ number_format($stats['active_advances'], 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Menunggu Verifikasi</p>
                <h3 class="text-2xl font-black text-amber-600 mt-0.5">{{ number_format($stats['pending_count']) }} Berkas</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                <i data-lucide="file-check" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Kasbon Belum SPJ</p>
                <h3 class="text-2xl font-black text-rose-600 mt-0.5">{{ number_format($stats['unsettled_advances_count']) }} Dinas</h3>
            </div>
        </div>

    </div>

    <!-- 2. Action & Filter Bar -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            <!-- Type Tabs -->
            <div class="flex items-center gap-1.5 p-1 bg-slate-100 rounded-xl max-w-fit">
                <a 
                    href="{{ route('admin.reimbursements.index') }}" 
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ !request('type') ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}"
                >
                    Semua Transaksi
                </a>
                <a 
                    href="{{ route('admin.reimbursements.index', ['type' => 'reimbursement']) }}" 
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ request('type') === 'reimbursement' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}"
                >
                    Klaim Reimburse
                </a>
                <a 
                    href="{{ route('admin.reimbursements.index', ['type' => 'cash_advance']) }}" 
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ request('type') === 'cash_advance' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}"
                >
                    Kasbon Dinas (Uang Muka)
                </a>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex items-center gap-2 flex-wrap">
                <a 
                    href="{{ route('admin.reimbursements.template') }}" 
                    class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                    title="Unduh format template CSV untuk pengisian data massal"
                >
                    <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i>
                    <span>Template CSV</span>
                </a>

                <button 
                    type="button" 
                    onclick="document.getElementById('importCsvModal').classList.remove('hidden')" 
                    class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                >
                    <i data-lucide="upload" class="w-4 h-4 text-blue-600"></i>
                    <span>Import File</span>
                </button>

                <a 
                    href="{{ route('admin.reimbursements.export', request()->all()) }}" 
                    class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                >
                    <i data-lucide="download" class="w-4 h-4 text-slate-600"></i>
                    <span>Export CSV</span>
                </a>

                <a 
                    href="{{ route('admin.reimbursements.export.pdf', request()->all()) }}" 
                    target="_blank"
                    class="px-3 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition flex items-center gap-1.5"
                >
                    <i data-lucide="printer" class="w-4 h-4 text-red-400"></i>
                    <span>Export PDF</span>
                </a>

                <button 
                    type="button" 
                    onclick="openCreateReimbursementModal()" 
                    class="btn-red-primary px-4 py-2 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5"
                >
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Buat Pengajuan Baru</span>
                </button>
            </div>

        </div>

        <!-- Filter Fields -->
        <form action="{{ route('admin.reimbursements.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 pt-2 border-t border-slate-100">
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif

            <div class="relative">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="No. Dokumen / Judul / Nama..." 
                    class="w-full pl-9 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"
                >
            </div>

            <select name="status" class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                <option value="">Semua Status</option>
                <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Dana Dicairkan</option>
                <option value="settled" {{ request('status') === 'settled' ? 'selected' : '' }}>Selesai (SPJ Valid)</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>

            <select name="category" class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                <option value="">Semua Kategori</option>
                <option value="mou_perjalanan_dinas" {{ request('category') === 'mou_perjalanan_dinas' ? 'selected' : '' }}>Perjalanan Dinas MoU</option>
                <option value="transportasi" {{ request('category') === 'transportasi' ? 'selected' : '' }}>Transportasi (Tiket/Bensin)</option>
                <option value="akomodasi_hotel" {{ request('category') === 'akomodasi_hotel' ? 'selected' : '' }}>Akomodasi Hotel</option>
                <option value="konsumsi_meeting" {{ request('category') === 'konsumsi_meeting' ? 'selected' : '' }}>Konsumsi & Jamuan</option>
                <option value="operasional_kantor" {{ request('category') === 'operasional_kantor' ? 'selected' : '' }}>Operasional Lembaga</option>
            </select>

            <input 
                type="date" 
                name="date_from" 
                value="{{ request('date_from') }}" 
                title="Tanggal Dari"
                class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"
            >

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition">
                    Cari
                </button>
                @if(request()->anyFilled(['search', 'status', 'category', 'date_from']))
                    <a href="{{ route('admin.reimbursements.index', ['type' => request('type')]) }}" class="p-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600" title="Reset">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>

    </div>

    <!-- 3. Reimbursements Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-extrabold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3.5">Dokumen & Transaksi</th>
                        <th class="px-4 py-3.5">Karyawan / Pemohon</th>
                        <th class="px-4 py-3.5">Keperluan & Tujuan Dinas</th>
                        <th class="px-4 py-3.5 text-right">Diajukan</th>
                        <th class="px-4 py-3.5 text-right">Disetujui / Kasbon</th>
                        <th class="px-4 py-3.5 text-right">Realisasi (SPJ)</th>
                        <th class="px-4 py-3.5 text-center">Status</th>
                        <th class="px-4 py-3.5 text-center">Aksi Bendahara</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reimbursements as $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Dokumen & Transaksi -->
                            <td class="px-4 py-3.5 space-y-1">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-mono font-bold text-slate-900">{{ $item->reimbursement_no }}</span>
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-black border {{ $item->type_badge['bg'] }}">
                                        {{ $item->type_badge['short_label'] }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-400 font-medium">
                                    {{ $item->created_at->format('d M Y H:i') }}
                                </p>
                            </td>

                            <!-- Karyawan -->
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center font-bold text-slate-600 text-xs flex-shrink-0">
                                        @if($item->employee && $item->employee->photo)
                                            <img src="{{ $item->employee->photo }}" alt="{{ $item->employee_name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($item->employee_name, 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-900 leading-tight">{{ $item->employee_name }}</h5>
                                        <p class="text-[11px] text-slate-400">{{ $item->employee ? ($item->employee->position_title ?: $item->employee->role_badge['label']) : 'Karyawan' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Keperluan & Tujuan -->
                            <td class="px-4 py-3.5 max-w-xs space-y-1">
                                <h6 class="font-bold text-slate-800 leading-snug truncate" title="{{ $item->title }}">
                                    {{ $item->title }}
                                </h6>
                                <div class="flex items-center gap-2 text-[11px] text-slate-500">
                                    @if($item->destination)
                                        <span class="flex items-center gap-1 text-slate-600 font-semibold">
                                            <i data-lucide="map-pin" class="w-3 h-3 text-red-500"></i>
                                            <span>{{ $item->destination }}</span>
                                        </span>
                                    @endif
                                    @if($item->start_date)
                                        <span>• {{ $item->start_date->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                                @if(!empty($item->receipts_data))
                                    <div class="pt-0.5">
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-japan-600 bg-red-50 px-2 py-0.5 rounded-full border border-red-100">
                                            <i data-lucide="paperclip" class="w-3 h-3"></i>
                                            <span>{{ count($item->receipts_data) }} Nota Fisik (Base64)</span>
                                        </span>
                                    </div>
                                @endif
                            </td>

                            <!-- Nominal Diajukan -->
                            <td class="px-4 py-3.5 text-right font-bold text-slate-700">
                                Rp {{ number_format($item->amount_requested, 0, ',', '.') }}
                            </td>

                            <!-- Nominal Disetujui / Uang Muka -->
                            <td class="px-4 py-3.5 text-right font-black {{ $item->amount_approved > 0 ? 'text-slate-900' : 'text-slate-400' }}">
                                Rp {{ number_format($item->amount_approved, 0, ',', '.') }}
                            </td>

                            <!-- Realisasi SPJ & Selisih -->
                            <td class="px-4 py-3.5 text-right space-y-0.5">
                                @if($item->type === 'cash_advance')
                                    <span class="font-black text-slate-900 block">
                                        Rp {{ number_format($item->amount_spent, 0, ',', '.') }}
                                    </span>
                                    @if($item->status === 'settled')
                                        @if($item->amount_diff > 0)
                                            <span class="text-[10px] font-bold text-rose-600 block">
                                                Kurang Bayar Rp {{ number_format($item->amount_diff, 0, ',', '.') }}
                                            </span>
                                        @elseif($item->amount_diff < 0)
                                            <span class="text-[10px] font-bold text-emerald-600 block">
                                                Lebih Bayar Rp {{ number_format(abs($item->amount_diff), 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-[10px] font-bold text-slate-400 block">Pas (Sesuai)</span>
                                        @endif
                                    @endif
                                @else
                                    <span class="text-slate-400 font-medium">-</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3.5 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $item->status_badge['bg'] }}">
                                    <i data-lucide="{{ $item->status_badge['icon'] }}" class="w-3 h-3"></i>
                                    <span>{{ $item->status_badge['label'] }}</span>
                                </span>
                            </td>

                            <!-- Aksi Bendahara -->
                            <td class="px-4 py-3.5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    
                                    <!-- Print Lembar SPJ / Kuitansi -->
                                    <a 
                                        href="{{ route('admin.reimbursements.print', $item->id) }}" 
                                        target="_blank"
                                        class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition"
                                        title="Cetak Lembar Pertanggungjawaban SPJ Resmi (A4)"
                                    >
                                        <i data-lucide="printer" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Verifikasi Status: Approve / Pay -->
                                    @if($item->status === 'submitted')
                                        <form action="{{ route('admin.reimbursements.status', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <input type="hidden" name="amount_approved" value="{{ $item->amount_requested }}">
                                            <button 
                                                type="submit" 
                                                class="p-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold transition"
                                                title="Setujui Dokumen Pengajuan"
                                            >
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @elseif($item->status === 'approved')
                                        <form action="{{ route('admin.reimbursements.status', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="pay">
                                            <button 
                                                type="submit" 
                                                class="px-2 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] transition flex items-center gap-1 shadow-xs"
                                                title="Cairkan Uang Reimburse / Kasbon ke Karyawan"
                                            >
                                                <i data-lucide="banknote" class="w-3.5 h-3.5"></i>
                                                <span>Cairkan</span>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Input Realisasi Kasbon (Settlement) -->
                                    @if($item->type === 'cash_advance' && in_array($item->status, ['paid', 'approved']))
                                        <button 
                                            type="button" 
                                            onclick="openSettlementModal('{{ $item->id }}', '{{ $item->reimbursement_no }}', '{{ $item->amount_approved }}', '{{ addslashes($item->employee_name) }}')"
                                            class="px-2 py-1 rounded-lg bg-purple-100 hover:bg-purple-200 text-purple-800 font-bold text-[11px] transition flex items-center gap-1"
                                            title="Laporkan Nota Realisasi Pengeluaran SPJ Kasbon"
                                        >
                                            <i data-lucide="clipboard-check" class="w-3.5 h-3.5"></i>
                                            <span>SPJ</span>
                                        </button>
                                    @endif

                                    <!-- Hapus Dokumen -->
                                    <form action="{{ route('admin.reimbursements.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengajuan {{ $item->reimbursement_no }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold transition" title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-16 text-center text-slate-400">
                                <div class="w-14 h-14 rounded-2xl bg-slate-50 text-slate-400 mx-auto flex items-center justify-center mb-3">
                                    <i data-lucide="receipt" class="w-7 h-7"></i>
                                </div>
                                <h4 class="font-extrabold text-slate-800 text-sm">Belum Ada Transaksi Reimburse atau Kasbon</h4>
                                <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Buat Pengajuan Baru" atau "Import File" untuk menambahkan data dinas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reimbursements->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $reimbursements->links() }}
            </div>
        @endif
    </div>

</div>

<!-- MODAL 1: FORM PENGAJUAN BARU (REIMBURSE & CASH ADVANCE) -->
<div id="createReimbursementModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] flex flex-col shadow-2xl border border-slate-100 overflow-hidden">
        
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-japan-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-900 text-sm leading-tight">Pengajuan Reimburse & Kasbon Dinas Baru</h3>
                    <p class="text-[11px] text-slate-500">Pilih jenis klaim nota biasa atau uang muka perjalanan dinas MoU</p>
                </div>
            </div>
            <button type="button" onclick="closeCreateReimbursementModal()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form action="{{ route('admin.reimbursements.store') }}" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto p-6 space-y-5">
            @csrf

            <!-- Tipe Transaksi: Tab Selector -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Tipe Pengajuan <span class="text-rose-500">*</span></label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="p-3 rounded-2xl border-2 cursor-pointer transition flex items-start gap-3 border-sky-500 bg-sky-50/40 text-slate-900" id="labelTypeReimburse">
                        <input type="radio" name="type" value="reimbursement" checked onchange="toggleTypeNotice('reimbursement')" class="mt-0.5 text-japan-600 focus:ring-japan-500">
                        <div>
                            <span class="font-extrabold text-xs block">Reimburse (Klaim Balik)</span>
                            <span class="text-[10px] text-slate-500 block mt-0.5">Karyawan talangi dahulu, diganti oleh bendahara setelah nota disetujui.</span>
                        </div>
                    </label>

                    <label class="p-3 rounded-2xl border-2 cursor-pointer transition flex items-start gap-3 border-slate-200 hover:border-purple-300 text-slate-900" id="labelTypeAdvance">
                        <input type="radio" name="type" value="cash_advance" onchange="toggleTypeNotice('cash_advance')" class="mt-0.5 text-purple-600 focus:ring-purple-500">
                        <div>
                            <span class="font-extrabold text-xs block">Uang Muka Dinas (Kasbon)</span>
                            <span class="text-[10px] text-slate-500 block mt-0.5">Uang muka dicairkan sebelum dinas luar kota, diselesaikan dengan SPJ nota.</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Pilih Pegawai / Pemohon -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Karyawan / Pejabat Pemohon <span class="text-rose-500">*</span></label>
                    <select name="teacher_id" id="selectEmployee" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                        <option value="">-- Pilih dari Daftar SDM & Karyawan --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">
                                {{ $emp->name }} ({{ $emp->position_title ?: $emp->role_badge['label'] }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Kategori Pengeluaran <span class="text-rose-500">*</span></label>
                    <select name="category" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                        <option value="mou_perjalanan_dinas">Perjalanan Dinas MoU Poltekkes & SMK</option>
                        <option value="transportasi">Transportasi (Tiket Pesawat / Kereta / Bensin / Tol)</option>
                        <option value="akomodasi_hotel">Akomodasi / Penginapan Hotel Dinas</option>
                        <option value="konsumsi_meeting">Konsumsi & Jamuan Meeting Mitra Kaisha</option>
                        <option value="operasional_kantor">Operasional Kantor & Pelatihan Siswa</option>
                        <option value="lainnya">Keperluan Dinas Lainnya</option>
                    </select>
                </div>
            </div>

            <!-- Keperluan & Tujuan -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Keperluan / Agenda Dinas <span class="text-rose-500">*</span></label>
                <input 
                    type="text" 
                    name="title" 
                    required 
                    placeholder="Contoh: Perjalanan Dinas Penandatanganan MoU dengan Rektor Poltekkes Semarang" 
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600"
                >
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Kota / Lokasi Tujuan</label>
                    <input 
                        type="text" 
                        name="destination" 
                        placeholder="Semarang & Solo" 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600 font-semibold"
                    >
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Tanggal Mulai</label>
                    <input 
                        type="date" 
                        name="start_date" 
                        value="{{ date('Y-m-d') }}" 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                    >
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Tanggal Selesai</label>
                    <input 
                        type="date" 
                        name="end_date" 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                    >
                </div>
            </div>

            <!-- Nominal Diajukan -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Nominal yang Diajukan (Rp) <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-xs text-slate-400">Rp</span>
                    <input 
                        type="number" 
                        name="amount_requested" 
                        required 
                        min="1" 
                        placeholder="Contoh: 2500000" 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-black text-slate-900 focus:outline-none focus:border-japan-600"
                    >
                </div>
            </div>

            <!-- Upload Nota Fisik Berbasis Base64 (LONGTEXT) -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-extrabold text-xs text-slate-900">Lampirkan Foto Nota / Kuitansi Fisik (Base64)</h4>
                        <p class="text-[10px] text-slate-500">Tersimpan aman di database tanpa risiko file hilang saat migrasi server</p>
                    </div>
                    <button type="button" onclick="addReceiptUploadRow()" class="px-2.5 py-1 rounded-lg bg-japan-50 hover:bg-japan-100 text-japan-700 text-xs font-bold transition flex items-center gap-1">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        <span>Tambah Nota</span>
                    </button>
                </div>

                <div id="receiptUploadContainer" class="space-y-2">
                    <div class="p-3 bg-white rounded-xl border border-slate-200 grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                        <input type="text" name="receipt_titles[]" placeholder="Nama Nota (cth: Tiket Kereta PP)" class="px-3 py-1.5 text-xs rounded-lg border border-slate-200">
                        <input type="number" name="receipt_amounts[]" placeholder="Nominal Rp" class="px-3 py-1.5 text-xs rounded-lg border border-slate-200">
                        <input type="file" name="receipt_files[]" accept="image/*,application/pdf" class="text-xs file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-japan-600 file:text-white">
                    </div>
                </div>
            </div>

            <!-- Catatan Tambahan -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Catatan / Keterangan Tambahan</label>
                <textarea 
                    name="notes" 
                    rows="2" 
                    placeholder="Rincian agenda dinas MoU, kontak mitra yang dikunjungi, dll..." 
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                ></textarea>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeCreateReimbursementModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-bold transition">
                    Batal
                </button>
                <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md">
                    Kirim Pengajuan
                </button>
            </div>

        </form>

    </div>
</div>

<!-- MODAL 2: SETTLEMENT REALISASI KASBON SPJ -->
<div id="settlementModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full max-h-[90vh] flex flex-col shadow-2xl border border-slate-100 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-purple-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center font-bold">
                    <i data-lucide="clipboard-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-900 text-sm">Penyelesaian Realisasi SPJ (Settlement)</h3>
                    <p class="text-[11px] text-slate-500" id="modalSettlementDocNo">ADV-SJI/...</p>
                </div>
            </div>
            <button type="button" onclick="closeSettlementModal()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form id="settlementForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="action" value="settle">

            <div class="p-3 bg-purple-50 rounded-xl border border-purple-100 text-xs space-y-1">
                <div class="flex justify-between">
                    <span class="text-slate-500">Nama Karyawan:</span>
                    <span class="font-bold text-slate-800" id="modalSettlementName">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Uang Muka Diterima:</span>
                    <span class="font-black text-purple-700" id="modalSettlementApproved">-</span>
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Total Pengeluaran Aktual SPJ (Rp) <span class="text-rose-500">*</span></label>
                <input 
                    type="number" 
                    name="amount_spent" 
                    id="modalAmountSpent" 
                    required 
                    min="0" 
                    placeholder="Masukkan nominal realisasi pengeluaran" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-black text-slate-900 focus:outline-none focus:border-purple-600"
                >
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Unggah Nota / Bukti Realisasi Tambahan</label>
                <input 
                    type="file" 
                    name="settlement_receipts[]" 
                    multiple 
                    accept="image/*,application/pdf" 
                    class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs file:mr-2 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-[11px] file:font-bold file:bg-purple-600 file:text-white"
                >
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Catatan Penyelesaian Rekonsiliasi</label>
                <textarea 
                    name="settlement_notes" 
                    rows="2" 
                    placeholder="Sisa uang kasbon telah dikembalikan ke kasir / kuitansi lengkap..." 
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-purple-600"
                ></textarea>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeSettlementModal()" class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-bold">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold shadow-md">
                    Simpan Settlement SPJ
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 3: IMPORT FILE CSV/EXCEL -->
<div id="importCsvModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h3 class="font-black text-slate-900 text-sm">Import Data Reimburse / Kasbon CSV</h3>
            <button type="button" onclick="document.getElementById('importCsvModal').classList.add('hidden')" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form action="{{ route('admin.reimbursements.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700">Pilih File CSV/Excel</label>
                <input 
                    type="file" 
                    name="csv_file" 
                    required 
                    accept=".csv,.txt" 
                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white"
                >
                <p class="text-[11px] text-slate-400">
                    Pastikan kolom sesuai dengan <a href="{{ route('admin.reimbursements.template') }}" class="text-japan-600 font-bold underline">Template CSV</a> kami.
                </p>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="document.getElementById('importCsvModal').classList.add('hidden')" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold">
                    Mulai Import
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateReimbursementModal() {
        document.getElementById('createReimbursementModal').classList.remove('hidden');
    }

    function closeCreateReimbursementModal() {
        document.getElementById('createReimbursementModal').classList.add('hidden');
    }

    function toggleTypeNotice(type) {
        const lblReim = document.getElementById('labelTypeReimburse');
        const lblAdv = document.getElementById('labelTypeAdvance');
        if (type === 'reimbursement') {
            lblReim.className = 'p-3 rounded-2xl border-2 cursor-pointer transition flex items-start gap-3 border-sky-500 bg-sky-50/40 text-slate-900';
            lblAdv.className = 'p-3 rounded-2xl border-2 cursor-pointer transition flex items-start gap-3 border-slate-200 hover:border-purple-300 text-slate-900';
        } else {
            lblAdv.className = 'p-3 rounded-2xl border-2 cursor-pointer transition flex items-start gap-3 border-purple-500 bg-purple-50/40 text-slate-900';
            lblReim.className = 'p-3 rounded-2xl border-2 cursor-pointer transition flex items-start gap-3 border-slate-200 hover:border-sky-300 text-slate-900';
        }
    }

    function addReceiptUploadRow() {
        const container = document.getElementById('receiptUploadContainer');
        const count = container.children.length + 1;
        const row = document.createElement('div');
        row.className = 'p-3 bg-white rounded-xl border border-slate-200 grid grid-cols-1 sm:grid-cols-3 gap-2 items-center';
        row.innerHTML = `
            <input type="text" name="receipt_titles[]" placeholder="Nota ${count}" class="px-3 py-1.5 text-xs rounded-lg border border-slate-200">
            <input type="number" name="receipt_amounts[]" placeholder="Nominal Rp" class="px-3 py-1.5 text-xs rounded-lg border border-slate-200">
            <input type="file" name="receipt_files[]" accept="image/*,application/pdf" class="text-xs file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-japan-600 file:text-white">
        `;
        container.appendChild(row);
    }

    function openSettlementModal(id, docNo, approvedAmount, employeeName) {
        const form = document.getElementById('settlementForm');
        form.action = `/admin/reimbursements/${id}/status`;
        document.getElementById('modalSettlementDocNo').textContent = docNo;
        document.getElementById('modalSettlementName').textContent = employeeName;
        document.getElementById('modalSettlementApproved').textContent = 'Rp ' + Number(approvedAmount).toLocaleString('id-ID');
        document.getElementById('modalAmountSpent').value = approvedAmount;
        document.getElementById('settlementModal').classList.remove('hidden');
    }

    function closeSettlementModal() {
        document.getElementById('settlementModal').classList.add('hidden');
    }
</script>
@endsection
