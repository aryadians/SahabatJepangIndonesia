@extends('admin.layouts.admin')

@section('title', 'Data Diri Siswa & Keuangan')
@section('page_title', 'Database Siswa & Manajemen Keuangan LPK')

@section('content')
<div class="space-y-6">

    <!-- 1. Top KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Siswa -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                <i data-lucide="graduation-cap" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Siswa</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ number_format($stats['total_students']) }}</h3>
            </div>
        </div>

        <!-- Siswa Aktif -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="book-open" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Aktif Belajar</p>
                <h3 class="text-2xl font-black text-emerald-600 mt-0.5">{{ number_format($stats['active_students']) }}</h3>
            </div>
        </div>

        <!-- Sudah di Jepang -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="plane" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Sudah di Jepang</p>
                <h3 class="text-2xl font-black text-japan-600 mt-0.5">{{ number_format($stats['departed_students']) }}</h3>
            </div>
        </div>

        <!-- Total Tanggungan Belum Lunas -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Sisa Tanggungan</p>
                <h3 class="text-base sm:text-lg font-black text-amber-600 mt-0.5">Rp {{ number_format($stats['total_receivables'], 0, ',', '.') }}</h3>
            </div>
        </div>

    </div>

    <!-- 2. Action & Filter Bar -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            <!-- Search & Filters Form -->
            <form action="{{ route('admin.students.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 flex-1">
                <div class="relative min-w-[200px] flex-1">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="Cari NIS, Nama, NIK, No WA, Kaisha..." 
                        class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"
                    >
                </div>

                <!-- Filter Program -->
                <select name="program" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                    <option value="all">Semua Program</option>
                    <option value="Tokutei Ginou (SSW)" {{ request('program') === 'Tokutei Ginou (SSW)' ? 'selected' : '' }}>Tokutei Ginou (SSW)</option>
                    <option value="Ginou Jisshusei (Magang)" {{ request('program') === 'Ginou Jisshusei (Magang)' ? 'selected' : '' }}>Magang (Jisshusei)</option>
                    <option value="Engineer & Profesional" {{ request('program') === 'Engineer & Profesional' ? 'selected' : '' }}>Engineer / Pro</option>
                    <option value="Kursus Bahasa Jepang" {{ request('program') === 'Kursus Bahasa Jepang' ? 'selected' : '' }}>Kursus Bahasa</option>
                </select>

                <!-- Filter Status -->
                <select name="status" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                    <option value="all">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif Belajar</option>
                    <option value="interview" {{ request('status') === 'interview' ? 'selected' : '' }}>Wawancara</option>
                    <option value="passed_interview" {{ request('status') === 'passed_interview' ? 'selected' : '' }}>Lolos User</option>
                    <option value="departed" {{ request('status') === 'departed' ? 'selected' : '' }}>Di Jepang</option>
                    <option value="graduated" {{ request('status') === 'graduated' ? 'selected' : '' }}>Alumni</option>
                    <option value="dropout" {{ request('status') === 'dropout' ? 'selected' : '' }}>Keluar / DO</option>
                </select>

                <!-- Filter Pembayaran -->
                <select name="payment_status" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                    <option value="all">Semua Bayar</option>
                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Lunas</option>
                    <option value="partial" {{ request('payment_status') === 'partial' ? 'selected' : '' }}>Ada Tanggungan</option>
                    <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                </select>

                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                    Filter
                </button>

                @if(request()->anyFilled(['q', 'program', 'status', 'payment_status']))
                    <a href="{{ route('admin.students.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold" title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </form>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 flex-shrink-0">
                <a 
                    href="{{ route('admin.students.export') }}" 
                    class="px-3.5 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                >
                    <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i>
                    <span>Export CSV</span>
                </a>

                <a 
                    href="{{ route('admin.students.create') }}" 
                    class="btn-red-primary px-4 py-2 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5"
                >
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span>Tambah Siswa</span>
                </a>
            </div>

        </div>
    </div>

    <!-- 3. Students Table (Clean & Aligned) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-[11px] uppercase font-bold">
                        <th class="py-3 px-4">Siswa</th>
                        <th class="py-3 px-4">Program</th>
                        <th class="py-3 px-4">Penempatan</th>
                        <th class="py-3 px-4">Masuk / Terbang</th>
                        <th class="py-3 px-4">Level</th>
                        <th class="py-3 px-4">Keuangan</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $st)
                        <tr class="hover:bg-slate-50/80 transition">
                            
                            <!-- Foto & Siswa Info -->
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                        @if($st->photo)
                                            <img src="{{ $st->photo }}" alt="{{ $st->name }}" class="w-full h-full object-cover">
                                        @else
                                            <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 leading-tight">{{ $st->name }}</h4>
                                        <span class="inline-block text-[10px] font-mono text-slate-500">
                                            {{ $st->nis }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Program & Sektor -->
                            <td class="py-3 px-4">
                                <p class="font-bold text-slate-900">{{ $st->program }}</p>
                                <p class="text-[11px] text-japan-600">{{ $st->sector ?: 'Umum' }}</p>
                            </td>

                            <!-- Penempatan Kaisha -->
                            <td class="py-3 px-4">
                                <p class="font-bold text-slate-800">{{ $st->destination_company ?: '-' }}</p>
                                <p class="text-[10px] text-slate-500">{{ $st->destination_prefecture ?: '-' }}</p>
                            </td>

                            <!-- Tanggal Masuk / Terbang -->
                            <td class="py-3 px-4 text-slate-600">
                                <p>In: <span class="font-semibold text-slate-800">{{ $st->entry_date ? $st->entry_date->format('d/m/Y') : '-' }}</span></p>
                                <p class="text-[10px] text-japan-600 font-bold">Fly: {{ $st->departure_date ? $st->departure_date->format('d/m/Y') : '-' }}</p>
                            </td>

                            <!-- Level Bahasa -->
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-md bg-red-50 text-japan-700 font-bold text-[11px]">
                                    {{ $st->japanese_level ?: '-' }}
                                </span>
                            </td>

                            <!-- Keuangan & Tanggungan -->
                            <td class="py-3 px-4">
                                <div class="space-y-0.5">
                                    <p class="font-bold text-emerald-600">{{ $st->formatted_paid_amount }}</p>
                                    @if($st->remaining_balance > 0)
                                        <p class="text-[10px] text-rose-600 font-black">Sisa: {{ $st->formatted_remaining_balance }}</p>
                                    @else
                                        <span class="text-[10px] text-emerald-600 font-bold">Lunas</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Status Pelatihan -->
                            <td class="py-3 px-4">
                                @if($st->status === 'active')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">Aktif</span>
                                @elseif($st->status === 'interview')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800">Interview</span>
                                @elseif($st->status === 'passed_interview')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Lolos User</span>
                                @elseif($st->status === 'departed')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Di Jepang</span>
                                @elseif($st->status === 'graduated')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">Alumni</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">DO</span>
                                @endif
                            </td>

                            <!-- Aksi Aligned Buttons -->
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-center">
                                    
                                    <!-- Catat Pembayaran -->
                                    <button 
                                        type="button" 
                                        data-id="{{ $st->id }}"
                                        data-name="{{ $st->name }}"
                                        data-total="{{ (float)$st->total_cost }}"
                                        data-paid="{{ (float)$st->paid_amount }}"
                                        onclick="openQuickPaymentFromBtn(this)" 
                                        class="px-2 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-bold hover:bg-emerald-100 text-[11px] flex items-center gap-1 transition" 
                                        title="Catat Pembayaran"
                                    >
                                        <i data-lucide="wallet" class="w-3.5 h-3.5"></i>
                                        <span>Bayar</span>
                                    </button>

                                    <!-- Cetak Lembar Profil -->
                                    <a 
                                        href="{{ route('admin.students.print', $st->id) }}" 
                                        target="_blank" 
                                        class="p-1.5 rounded-lg text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition" 
                                        title="Cetak Lembar Profil (PDF)"
                                    >
                                        <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a 
                                        href="{{ route('admin.students.edit', $st->id) }}" 
                                        class="p-1.5 rounded-lg text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 transition" 
                                        title="Edit Lengkap"
                                    >
                                        <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.students.destroy', $st->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data siswa {{ $st->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 transition" title="Hapus">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400 mb-2">
                                    <i data-lucide="users" class="w-6 h-6"></i>
                                </div>
                                <p class="font-bold text-slate-700">Belum ada data siswa</p>
                                <p class="text-xs">Klik "Tambah Siswa" untuk menginput data baru</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $students->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Quick Payment Modal -->
<div id="quickPaymentModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('quickPaymentModal')"></div>
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10">
        
        <div class="bg-gradient-to-r from-emerald-800 to-emerald-700 text-white p-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-white/20 text-white flex items-center justify-center font-bold">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-white">Catat Pembayaran Siswa</h3>
                    <p id="paymentStudentName" class="text-[11px] text-emerald-200">-</p>
                </div>
            </div>
            <button onclick="closeModal('quickPaymentModal')" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm">
                &times;
            </button>
        </div>

        <form id="quickPaymentForm" method="POST" class="p-5 space-y-4">
            @csrf
            
            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 grid grid-cols-2 gap-2 text-xs">
                <div>
                    <span class="text-slate-400 text-[10px] uppercase font-bold">Total Biaya:</span>
                    <p id="paymentTotalCost" class="font-black text-slate-900 text-xs">Rp 0</p>
                </div>
                <div>
                    <span class="text-slate-400 text-[10px] uppercase font-bold">Sisa Tanggungan:</span>
                    <p id="paymentRemaining" class="font-black text-rose-600 text-xs">Rp 0</p>
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Jumlah Terbayar Sekarang (IDR) *</label>
                <input type="number" name="paid_amount" id="inputPaidAmount" required min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-black text-emerald-600 focus:outline-none focus:border-emerald-600">
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Catatan Termin / Bukti Transfer</label>
                <textarea name="payment_notes" rows="2" placeholder="Contoh: Transfer BCA pelunasan termin 2..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-emerald-600"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('quickPaymentModal')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md flex items-center gap-1.5">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Simpan Pembayaran</span>
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    function openQuickPaymentFromBtn(btn) {
        const studentId = btn.getAttribute('data-id');
        const name = btn.getAttribute('data-name');
        const totalCost = parseFloat(btn.getAttribute('data-total')) || 0;
        const paidAmount = parseFloat(btn.getAttribute('data-paid')) || 0;

        document.getElementById('paymentStudentName').textContent = name;
        document.getElementById('paymentTotalCost').textContent = 'Rp ' + totalCost.toLocaleString('id-ID');
        
        const remaining = Math.max(0, totalCost - paidAmount);
        document.getElementById('paymentRemaining').textContent = 'Rp ' + remaining.toLocaleString('id-ID');
        document.getElementById('inputPaidAmount').value = paidAmount;

        const form = document.getElementById('quickPaymentForm');
        form.action = `/admin/students/${studentId}/payment`;

        openModal('quickPaymentModal');
    }
</script>
@endsection
