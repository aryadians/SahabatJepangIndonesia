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

            <!-- Action Buttons (Import, Template, Export, Tambah) -->
            <div class="flex flex-wrap items-center gap-2 flex-shrink-0">
                <!-- Import CSV Button -->
                <button 
                    type="button"
                    onclick="openModal('importCsvModal')" 
                    class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                    title="Import Data Siswa Massal dari file CSV / Excel"
                >
                    <i data-lucide="upload-cloud" class="w-4 h-4 text-blue-600"></i>
                    <span>Import CSV</span>
                </button>

                <!-- Download Template CSV -->
                <a 
                    href="{{ route('admin.students.template') }}" 
                    class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                    title="Unduh Template Format CSV Siap Isi"
                >
                    <i data-lucide="download" class="w-4 h-4 text-slate-500"></i>
                    <span>Template</span>
                </a>

                <!-- Export Database CSV -->
                <a 
                    href="{{ route('admin.students.export') }}" 
                    class="px-3.5 py-2 rounded-xl border border-emerald-200 bg-emerald-50/50 hover:bg-emerald-50 text-emerald-800 text-xs font-bold transition flex items-center gap-1.5"
                    title="Export Seluruh Database Siswa ke File CSV / Excel"
                >
                    <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i>
                    <span>Export CSV</span>
                </a>

                <!-- Tambah Siswa Baru -->
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
                        <th class="py-3 px-4">Siswa & NIS</th>
                        <th class="py-3 px-4">Program & Sektor</th>
                        <th class="py-3 px-4">Penempatan Jepang</th>
                        <th class="py-3 px-4">Masuk / Terbang</th>
                        <th class="py-3 px-4">Bahasa & Medikal</th>
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
                                        <button 
                                            type="button" 
                                            onclick="openStudentDetailModal({{ $st->id }})" 
                                            class="font-bold text-slate-900 hover:text-japan-600 transition text-left leading-tight block group"
                                            title="Klik untuk melihat profil lengkap & berkas"
                                        >
                                            <span class="group-hover:underline">{{ $st->name }}</span>
                                        </button>
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

                            <!-- Bahasa & Medikal / CoE -->
                            <td class="py-3 px-4">
                                <div class="space-y-1">
                                    <span class="px-2 py-0.5 rounded-md bg-red-50 text-japan-700 font-bold text-[11px] inline-block">
                                        {{ $st->japanese_level ?: '-' }}
                                    </span>
                                    @if($st->mcu_result === 'fit')
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 block w-max">MCU: Fit</span>
                                    @elseif($st->mcu_result === 'unfit')
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800 block w-max">MCU: Unfit</span>
                                    @elseif($st->mcu_result === 'follow_up')
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 block w-max">MCU: Follow-up</span>
                                    @elseif($st->mcu_result === 'pending')
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 block w-max">MCU: Pending</span>
                                    @endif
                                    @if($st->coe_number)
                                        <span class="text-[9px] font-mono text-slate-500 block truncate max-w-[110px]" title="CoE: {{ $st->coe_number }}">
                                            CoE: {{ $st->coe_number }}
                                        </span>
                                    @endif
                                </div>
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

                                    <!-- Quick Detail Modal -->
                                    <button 
                                        type="button" 
                                        onclick="openStudentDetailModal({{ $st->id }})" 
                                        class="p-1.5 rounded-lg text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 transition" 
                                        title="Lihat Detail Profil & Berkas Siswa"
                                    >
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
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

<!-- Import CSV Modal -->
<div id="importCsvModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('importCsvModal')"></div>
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10">
        
        <div class="bg-gradient-to-r from-blue-900 to-slate-900 text-white p-6 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-2xl bg-white/10 text-white flex items-center justify-center font-bold">
                    <i data-lucide="upload-cloud" class="w-5 h-5 text-blue-400"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-white">Import Database Siswa (CSV)</h3>
                    <p class="text-xs text-slate-300">Upload data massal dari file Excel/CSV</p>
                </div>
            </div>
            <button onclick="closeModal('importCsvModal')" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition">
                &times;
            </button>
        </div>

        <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            
            <!-- Step Instructions & Template Download Link -->
            <div class="p-4 rounded-2xl bg-blue-50/80 border border-blue-100 space-y-2.5">
                <div class="flex items-start gap-2.5 text-xs text-blue-900">
                    <i data-lucide="info" class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="font-bold">Panduan Import Data Siswa:</p>
                        <ol class="list-decimal list-inside space-y-1 mt-1 text-slate-600 text-[11px]">
                            <li>Gunakan format kolom template resmi LPK.</li>
                            <li>Jika kolom <strong>NIS</strong> dikosongkan, sistem akan membuatkan nomor NIS otomatis.</li>
                            <li>Jika NIS sudah ada, data siswa tersebut akan diperbarui (update otomatis).</li>
                        </ol>
                    </div>
                </div>

                <div class="pt-2 border-t border-blue-200/60 flex items-center justify-between">
                    <span class="text-[11px] font-bold text-blue-800">Belum punya template CSV?</span>
                    <a 
                        href="{{ route('admin.students.template') }}" 
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white text-blue-700 hover:text-blue-900 border border-blue-200 font-bold text-xs shadow-xs hover:bg-blue-50 transition"
                    >
                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        <span>Unduh Template CSV</span>
                    </a>
                </div>
            </div>

            <!-- File Input Drag-and-Drop styled -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Pilih File CSV (.csv) <span class="text-rose-500">*</span></label>
                <div class="p-4 border-2 border-dashed border-slate-300 hover:border-blue-500 rounded-2xl bg-slate-50 text-center transition cursor-pointer relative">
                    <input 
                        type="file" 
                        name="csv_file" 
                        accept=".csv,text/csv,text/plain" 
                        required 
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        onchange="document.getElementById('selectedFileName').textContent = this.files[0] ? this.files[0].name : 'Belum ada file dipilih'"
                    >
                    <i data-lucide="file-spreadsheet" class="w-8 h-8 mx-auto text-blue-600 mb-1.5"></i>
                    <p class="text-xs font-bold text-slate-800">Klik untuk memilih file CSV atau drag & drop ke sini</p>
                    <p id="selectedFileName" class="text-[11px] text-slate-500 mt-1 font-mono font-semibold">Format: .csv (Maksimal 10MB)</p>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('importCsvModal')" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="btn-red-primary px-5 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i data-lucide="upload" class="w-4 h-4"></i>
                    <span>Mulai Proses Import</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Quick Detail Siswa & Berkas Modal -->
<div id="studentDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('studentDetailModal')"></div>
    <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10 flex flex-col max-h-[90vh]">
        
        <!-- Header Siswa -->
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-6 flex-shrink-0 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/10 border-2 border-white/20 overflow-hidden flex-shrink-0 flex items-center justify-center">
                    <img id="detailPhoto" src="" alt="Foto Siswa" class="w-full h-full object-cover hidden">
                    <div id="detailNoPhoto" class="text-white/60 flex items-center justify-center">
                        <i data-lucide="user" class="w-8 h-8"></i>
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-2.5">
                        <h2 id="detailName" class="text-base sm:text-lg font-black text-white leading-tight">Nama Siswa</h2>
                        <span id="detailStatusBadge" class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-japan-600 text-white">Status</span>
                    </div>
                    <p id="detailJapaneseName" class="text-xs text-japan-300 font-japanese mt-0.5">-</p>
                    <p class="text-[11px] text-slate-300 font-mono mt-1">
                        NIS: <span id="detailNis" class="font-bold text-white">-</span> • 
                        Program: <span id="detailProgram" class="font-bold text-white">-</span>
                    </p>
                </div>
            </div>
            <button onclick="closeModal('studentDetailModal')" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition">
                &times;
            </button>
        </div>

        <!-- Scrollable Detail Body -->
        <div class="p-6 overflow-y-auto space-y-6 flex-1 bg-slate-50/50">
            
            <!-- Grid 1: Identitas & Kontak -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i data-lucide="user" class="w-4 h-4 text-japan-600"></i>
                    <span>Identitas Pribadi & Kontak</span>
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Nomor NIK KTP:</span>
                        <p id="detailNik" class="font-mono font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Jenis Kelamin:</span>
                        <p id="detailGender" class="font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Tempat & Tanggal Lahir:</span>
                        <p id="detailBirth" class="font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Pendidikan Terakhir:</span>
                        <p id="detailEducation" class="font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">No. WhatsApp / HP:</span>
                        <div class="flex items-center gap-2">
                            <a id="detailPhoneLink" href="#" target="_blank" class="font-bold text-emerald-600 hover:underline flex items-center gap-1">
                                <span id="detailPhone">-</span>
                                <i data-lucide="external-link" class="w-3 h-3"></i>
                            </a>
                            <button 
                                type="button" 
                                onclick="toggleStudentWaBox()" 
                                class="px-2 py-0.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-extrabold text-[10px] flex items-center gap-1 transition"
                                title="Buka Template Pesan WhatsApp Cepat"
                            >
                                <i data-lucide="message-circle" class="w-3 h-3"></i>
                                <span>Template WA</span>
                            </button>
                        </div>
                    </div>

                    <!-- WhatsApp Templates Accordion Box -->
                    <div id="studentWaBox" class="col-span-2 sm:col-span-3 bg-emerald-50/70 border border-emerald-200/80 p-3 rounded-2xl hidden space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-black text-emerald-800 flex items-center gap-1.5">
                                <i data-lucide="send" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Pilih Template Pesan WhatsApp Cepat:</span>
                            </span>
                            <button type="button" onclick="toggleStudentWaBox()" class="text-slate-400 hover:text-slate-700 text-xs">&times;</button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                            <button 
                                type="button" 
                                onclick="sendStudentQuickWa('billing')" 
                                class="p-2.5 rounded-xl bg-white hover:bg-emerald-600 hover:text-white border border-emerald-200 text-left transition font-semibold flex items-center gap-2 shadow-xs group"
                            >
                                <span class="p-1.5 rounded-lg bg-emerald-100 text-emerald-700 group-hover:bg-white group-hover:text-emerald-700">💸</span>
                                <div>
                                    <p class="font-bold text-[11px]">Pengingat Tagihan Sisa Biaya</p>
                                    <p class="text-[10px] text-slate-500 group-hover:text-emerald-100 truncate">Rincian sisa biaya & rekening resmi LPK</p>
                                </div>
                            </button>
                            <button 
                                type="button" 
                                onclick="sendStudentQuickWa('mcu')" 
                                class="p-2.5 rounded-xl bg-white hover:bg-blue-600 hover:text-white border border-blue-200 text-left transition font-semibold flex items-center gap-2 shadow-xs group"
                            >
                                <span class="p-1.5 rounded-lg bg-blue-100 text-blue-700 group-hover:bg-white group-hover:text-blue-700">🏥</span>
                                <div>
                                    <p class="font-bold text-[11px]">Panggilan Medical Check-Up (MCU)</p>
                                    <p class="text-[10px] text-slate-500 group-hover:text-blue-100 truncate">Jadwal & panduan puasa sebelum MCU</p>
                                </div>
                            </button>
                            <button 
                                type="button" 
                                onclick="sendStudentQuickWa('interview')" 
                                class="p-2.5 rounded-xl bg-white hover:bg-amber-600 hover:text-white border border-amber-200 text-left transition font-semibold flex items-center gap-2 shadow-xs group"
                            >
                                <span class="p-1.5 rounded-lg bg-amber-100 text-amber-700 group-hover:bg-white group-hover:text-amber-700">🏢</span>
                                <div>
                                    <p class="font-bold text-[11px]">Jadwal Wawancara Kaisha</p>
                                    <p class="text-[10px] text-slate-500 group-hover:text-amber-100 truncate">Panggilan wawancara user di Jepang</p>
                                </div>
                            </button>
                            <button 
                                type="button" 
                                onclick="sendStudentQuickWa('coe')" 
                                class="p-2.5 rounded-xl bg-white hover:bg-purple-600 hover:text-white border border-purple-200 text-left transition font-semibold flex items-center gap-2 shadow-xs group"
                            >
                                <span class="p-1.5 rounded-lg bg-purple-100 text-purple-700 group-hover:bg-white group-hover:text-purple-700">✈️</span>
                                <div>
                                    <p class="font-bold text-[11px]">Kabar Baik CoE & Visa Terbit</p>
                                    <p class="text-[10px] text-slate-500 group-hover:text-purple-100 truncate">Pemberitahuan kelulusan izin tinggal Jepang</p>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Email:</span>
                        <p id="detailEmail" class="font-bold text-slate-800">-</p>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Alamat Domisili:</span>
                        <p id="detailAddress" class="font-medium text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Kontak Darurat (Wali):</span>
                        <p id="detailEmergency" class="font-bold text-slate-800">-</p>
                    </div>
                </div>
            </div>

            <!-- Grid 2: Penempatan Kerja & Pelatihan -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i data-lucide="briefcase" class="w-4 h-4 text-japan-600"></i>
                    <span>Pelatihan & Penempatan Kerja di Jepang</span>
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Angkatan (Batch):</span>
                        <p id="detailBatch" class="font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Sektor / Bidang:</span>
                        <p id="detailSector" class="font-bold text-japan-700">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Level Bahasa Jepang:</span>
                        <p id="detailJapaneseLevel" class="font-bold text-emerald-700">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Perusahaan Kaisha:</span>
                        <p id="detailCompany" class="font-black text-slate-900">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Prefektur Penempatan:</span>
                        <p id="detailPrefecture" class="font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Nomor Paspor:</span>
                        <p id="detailPassport" class="font-mono font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Tgl Masuk Belajar:</span>
                        <p id="detailEntryDate" class="font-bold text-slate-800">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Tgl / Target Terbang:</span>
                        <p id="detailDepartureDate" class="font-bold text-japan-600">-</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Sertifikat SSW Skill:</span>
                        <p id="detailSsw" class="font-bold text-slate-800">-</p>
                    </div>
                </div>
            </div>

            <!-- Grid 3: Medikal (MCU) & Legalitas CoE/Visa & Akademik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <!-- Medikal & Visa -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                        <i data-lucide="stethoscope" class="w-4 h-4 text-blue-600"></i>
                        <span>Medikal (MCU) & Dokumen Visa</span>
                    </h3>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Status Kelayakan MCU:</span>
                            <span id="detailMcuResult" class="font-black text-slate-900">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Klinik MCU:</span>
                            <span id="detailMcuClinic" class="font-bold text-slate-800">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Tanggal MCU:</span>
                            <span id="detailMcuDate" class="text-slate-800">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nomor CoE:</span>
                            <span id="detailCoeNumber" class="font-mono font-bold text-slate-800">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nomor Visa:</span>
                            <span id="detailVisaNumber" class="font-mono font-bold text-slate-800">-</span>
                        </div>
                    </div>
                </div>

                <!-- Akademik & Disiplin -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                        <i data-lucide="award" class="w-4 h-4 text-amber-600"></i>
                        <span>Evaluasi Akademik & Kehadiran</span>
                    </h3>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Rata-rata Nilai Ujian:</span>
                            <span id="detailExamScore" class="font-black text-slate-900">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Tingkat Kehadiran:</span>
                            <span id="detailAttendance" class="font-black text-emerald-600">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Grade Kedisiplinan:</span>
                            <span id="detailDiscipline" class="font-black text-japan-600">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Kelengkapan Berkas:</span>
                            <span id="detailDocsCount" class="font-bold text-slate-800">-</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Grid 4: Berkas & Dokumen Digital Siswa (8 Dokumen) -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="folder-check" class="w-4 h-4 text-japan-600"></i>
                        <span>Berkas Dokumen Pribadi (Digital Scan)</span>
                    </h3>
                    <span id="detailUploadedCountBadge" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">0 / 8 Berkas</span>
                </div>

                <div id="detailDocsGrid" class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-1">
                    <!-- Dynamic Document Items populated by JS -->
                </div>
            </div>

            <!-- Grid 5: Keuangan & Catatan Admin -->
            <div class="p-4 rounded-2xl bg-slate-900 text-white space-y-2 text-xs">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Total Biaya:</span>
                        <p id="detailTotalCost" class="font-black text-white text-sm">Rp 0</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Terbayar:</span>
                        <p id="detailPaidAmount" class="font-black text-emerald-400 text-sm">Rp 0</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Sisa Tanggungan:</span>
                        <p id="detailRemaining" class="font-black text-rose-400 text-sm">Rp 0</p>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Status & Skema:</span>
                        <p id="detailPaymentStatus" class="font-bold text-amber-300 uppercase text-xs">-</p>
                    </div>
                </div>
                <div id="detailAdminNotesBox" class="pt-2 border-t border-slate-800 text-[11px] text-slate-300 italic hidden">
                    Catatan: <span id="detailAdminNotes">-</span>
                </div>
            </div>

        </div>

        <!-- Footer Actions -->
        <div class="p-4 px-6 bg-white border-t border-slate-200 flex-shrink-0 flex items-center justify-between">
            <button type="button" onclick="closeModal('studentDetailModal')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 transition">
                Tutup
            </button>
            <div class="flex items-center gap-2">
                <button 
                    id="detailPaymentBtn" 
                    type="button" 
                    class="px-3.5 py-2 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-bold transition flex items-center gap-1.5"
                >
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                    <span>Catat Bayar</span>
                </button>
                <a 
                    id="detailPrintBtn" 
                    href="#" 
                    target="_blank" 
                    class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                >
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    <span>Cetak Lembar Profil</span>
                </a>
                <a 
                    id="detailEditBtn" 
                    href="#" 
                    class="btn-red-primary px-4 py-2 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5"
                >
                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                    <span>Edit Lengkap</span>
                </a>
            </div>
        </div>

    </div>
</div>

<!-- Document Viewer Modal in Index -->
<div id="indexDocPreviewModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('indexDocPreviewModal')"></div>
    <div class="relative w-full max-w-3xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10 flex flex-col max-h-[90vh]">
        <div class="bg-slate-900 text-white p-4 px-6 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <i data-lucide="file-text" class="w-5 h-5 text-japan-500"></i>
                <h3 id="indexDocPreviewTitle" class="text-sm font-bold text-white">Preview Dokumen</h3>
            </div>
            <div class="flex items-center gap-2">
                <a id="indexDocDownloadBtn" href="#" download target="_blank" class="px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition flex items-center gap-1.5">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    <span>Download</span>
                </a>
                <button onclick="closeModal('indexDocPreviewModal')" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition">
                    &times;
                </button>
            </div>
        </div>
        <div id="indexDocContainer" class="p-4 overflow-y-auto flex items-center justify-center min-h-[350px] bg-slate-100 flex-1">
            <!-- Dynamic Content -->
        </div>
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

    let currentStudentObj = null;
    let currentStudentFinancialObj = null;

    // Open Student Quick Detail Modal
    function openStudentDetailModal(studentId) {
        fetch(`/admin/students/${studentId}?format=json`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const s = data.student;
            currentStudentObj = s;
            currentStudentFinancialObj = data;

            // Reset WhatsApp template accordion
            const waBox = document.getElementById('studentWaBox');
            if (waBox) waBox.classList.add('hidden');

            // Foto
            const photoImg = document.getElementById('detailPhoto');
            const noPhoto = document.getElementById('detailNoPhoto');
            if (s.photo) {
                photoImg.src = s.photo;
                photoImg.classList.remove('hidden');
                noPhoto.classList.add('hidden');
            } else {
                photoImg.classList.add('hidden');
                noPhoto.classList.remove('hidden');
            }

            // Identitas
            document.getElementById('detailName').textContent = s.name;
            document.getElementById('detailJapaneseName').textContent = s.japanese_name || '-';
            document.getElementById('detailNis').textContent = s.nis;
            document.getElementById('detailProgram').textContent = s.program;
            document.getElementById('detailStatusBadge').textContent = s.status.toUpperCase();
            document.getElementById('detailNik').textContent = s.nik || '-';
            document.getElementById('detailGender').textContent = s.gender;
            document.getElementById('detailBirth').textContent = (s.birth_place || '-') + ', ' + (s.birth_date ? s.birth_date.split('T')[0] : '-');
            document.getElementById('detailEducation').textContent = s.education || '-';
            document.getElementById('detailPhone').textContent = s.phone || '-';
            document.getElementById('detailPhoneLink').href = s.phone ? `https://wa.me/${s.phone.replace(/^0/, '62').replace(/[^0-9]/g, '')}` : '#';
            document.getElementById('detailEmail').textContent = s.email || '-';
            document.getElementById('detailAddress').textContent = (s.address || '-') + ' (' + (s.city || '-') + ')';
            document.getElementById('detailEmergency').textContent = (s.emergency_contact_name || '-') + ' (' + (s.emergency_contact_phone || '-') + ')';

            // Pelatihan
            document.getElementById('detailBatch').textContent = s.batch || '-';
            document.getElementById('detailSector').textContent = s.sector || '-';
            document.getElementById('detailJapaneseLevel').textContent = s.japanese_level || '-';
            document.getElementById('detailCompany').textContent = s.destination_company || 'Proses Penempatan';
            document.getElementById('detailPrefecture').textContent = s.destination_prefecture || '-';
            document.getElementById('detailPassport').textContent = s.passport_number || '-';
            document.getElementById('detailEntryDate').textContent = s.entry_date ? s.entry_date.split('T')[0] : '-';
            document.getElementById('detailDepartureDate').textContent = s.departure_date ? s.departure_date.split('T')[0] : '-';
            document.getElementById('detailSsw').textContent = s.ssw_certificate || '-';

            // Medikal & Visa
            document.getElementById('detailMcuResult').textContent = data.mcu_label;
            document.getElementById('detailMcuClinic').textContent = s.mcu_clinic || '-';
            document.getElementById('detailMcuDate').textContent = s.mcu_date ? s.mcu_date.split('T')[0] : '-';
            document.getElementById('detailCoeNumber').textContent = s.coe_number || '-';
            document.getElementById('detailVisaNumber').textContent = s.visa_number || '-';

            // Akademik
            document.getElementById('detailExamScore').textContent = s.exam_score ? s.exam_score + ' / 100' : '-';
            document.getElementById('detailAttendance').textContent = (s.attendance_percentage ?? 100) + '%';
            document.getElementById('detailDiscipline').textContent = 'Grade ' + (s.discipline_grade || 'A');
            document.getElementById('detailDocsCount').textContent = data.uploaded_docs_count + ' / 8 Dokumen';
            document.getElementById('detailUploadedCountBadge').textContent = data.uploaded_docs_count + ' / 8 Dokumen';

            // 8 Dokumen Digital Grid
            const docsList = [
                { key: 'document_ktp', label: 'e-KTP', val: s.document_ktp },
                { key: 'document_kk', label: 'Kartu Keluarga', val: s.document_kk },
                { key: 'document_ijazah', label: 'Ijazah Asli', val: s.document_ijazah },
                { key: 'document_passport', label: 'Paspor RI', val: s.document_passport },
                { key: 'document_certificate', label: 'JLPT / JFT', val: s.document_certificate },
                { key: 'document_ssw', label: 'Skill SSW', val: s.document_ssw },
                { key: 'document_mcu', label: 'Hasil MCU', val: s.document_mcu },
                { key: 'document_coe_visa', label: 'CoE & Visa', val: s.document_coe_visa },
            ];

            const docsGrid = document.getElementById('detailDocsGrid');
            docsGrid.innerHTML = '';
            docsList.forEach(d => {
                const hasDoc = !!d.val;
                const div = document.createElement('div');
                div.className = `p-2.5 rounded-xl border ${hasDoc ? 'border-emerald-200 bg-emerald-50/40' : 'border-slate-200 bg-slate-100/50'} text-xs space-y-1`;
                div.innerHTML = `
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-slate-800 text-[11px] truncate">${d.label}</span>
                        <span class="w-2 h-2 rounded-full ${hasDoc ? 'bg-emerald-500' : 'bg-slate-300'}"></span>
                    </div>
                    ${hasDoc ? `
                        <button type="button" onclick="viewDocFromDetailModal('${d.label}', '${d.val}')" class="w-full mt-1 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] flex items-center justify-center gap-1 transition">
                            <i data-lucide="eye" class="w-3 h-3"></i>
                            <span>Buka</span>
                        </button>
                    ` : `
                        <span class="block text-[10px] text-slate-400 italic">Belum ada</span>
                    `}
                `;
                docsGrid.appendChild(div);
            });

            // Keuangan
            document.getElementById('detailTotalCost').textContent = data.formatted_total_cost;
            document.getElementById('detailPaidAmount').textContent = data.formatted_paid_amount;
            document.getElementById('detailRemaining').textContent = data.formatted_remaining_balance;
            document.getElementById('detailPaymentStatus').textContent = `${s.payment_status} (${s.payment_scheme})`;

            // Catatan Admin
            const adminNotesBox = document.getElementById('detailAdminNotesBox');
            if (s.admin_notes) {
                document.getElementById('detailAdminNotes').textContent = s.admin_notes;
                adminNotesBox.classList.remove('hidden');
            } else {
                adminNotesBox.classList.add('hidden');
            }

            // Buttons
            document.getElementById('detailPrintBtn').href = `/admin/students/${s.id}/print`;
            document.getElementById('detailEditBtn').href = `/admin/students/${s.id}/edit`;
            
            const payBtn = document.getElementById('detailPaymentBtn');
            payBtn.onclick = function() {
                closeModal('studentDetailModal');
                document.getElementById('paymentStudentName').textContent = s.name;
                document.getElementById('paymentTotalCost').textContent = data.formatted_total_cost;
                document.getElementById('paymentRemaining').textContent = data.formatted_remaining_balance;
                document.getElementById('inputPaidAmount').value = s.paid_amount;
                document.getElementById('quickPaymentForm').action = `/admin/students/${s.id}/payment`;
                openModal('quickPaymentModal');
            };

            openModal('studentDetailModal');
            if (window.lucide) {
                lucide.createIcons();
            }
        })
        .catch(err => {
            console.error(err);
            alert('Gagal memuat detail data siswa.');
        });
    }

    // Toggle Student WhatsApp Template Accordion
    function toggleStudentWaBox() {
        const box = document.getElementById('studentWaBox');
        if (box) {
            box.classList.toggle('hidden');
        }
    }

    // Send Quick WhatsApp to Student using Pre-Formatted Templates
    function sendStudentQuickWa(type) {
        if (!currentStudentObj) return;
        const s = currentStudentObj;
        const fin = currentStudentFinancialObj;

        let cleanPhone = (s.phone || '').replace(/[^0-9]/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '62' + cleanPhone.substring(1);
        }

        if (!cleanPhone) {
            alert('Nomor WhatsApp siswa belum terdaftar.');
            return;
        }

        let msg = '';
        if (type === 'billing') {
            msg = `Halo Sdr/i *${s.name}* (NIS: ${s.nis}),\n\nSalam hangat dari Bagian Keuangan LPK Sahabat Jepang Indonesia 🌸\n\nKami menginformasikan status rincian biaya program *${s.program}* Anda saat ini:\n• Total Biaya: ${fin ? fin.formatted_total_cost : 'Rp -'}\n• Sudah Terbayar: ${fin ? fin.formatted_paid_amount : 'Rp -'}\n• Sisa Tanggungan: *${fin ? fin.formatted_remaining_balance : 'Rp -'}*\n\nMohon untuk menyelesaikan sisa pembayaran sebelum jadwal keberangkatan ke Jepang. Pembayaran dapat ditransfer ke rekening resmi LPK SJI. Terima kasih atas kerjasamanya.`;
        } else if (type === 'mcu') {
            msg = `Halo Sdr/i *${s.name}* (NIS: ${s.nis}),\n\nSalam dari Tim Keberangkatan LPK Sahabat Jepang Indonesia 🌸\n\nTahap persiapan kerja Anda ke Jepang telah memasuki jadwal *Medical Check-Up (MCU)*.\n• Klinik/RS Rekanan: *${s.mcu_clinic || 'RS / Klinik Rekanan LPK'}*\n• Tanggal Pelaksanaan: *${s.mcu_date ? s.mcu_date.split('T')[0] : 'Sesuai Jadwal'}*\n\n*Panduan Sebelum MCU:*\n1. Berpuasa 10-12 jam sebelum pemeriksaan darah (hanya boleh minum air putih).\n2. Istirahat cukup dan hindari begadang.\n3. Membawa e-KTP asli dan pasfoto 3x4.\n\nSemoga hasil MCU Fit dan lancar ya!`;
        } else if (type === 'interview') {
            msg = `Halo Sdr/i *${s.name}*,\n\nPemberitahuan dari Divisi Penempatan LPK Sahabat Jepang Indonesia 🌸\n\nJadwal wawancara kerja Anda dengan pihak user di Jepang telah ditetapkan:\n• Perusahaan (Kaisha): *${s.destination_company || 'Perusahaan Mitra Jepang'}*\n• Prefektur: *${s.destination_prefecture || 'Jepang'}*\n• Bidang Pekerjaan: *${s.sector || s.program}*\n\nHarap mempersiapkan *Jikoshoukai* (perkenalan diri dalam bahasa Jepang), mengenakan seragam kemeja putih rapi berkerah, dan hadir 30 menit sebelum sesi dimulai. Ganbatte kudasai!`;
        } else if (type === 'coe') {
            msg = `Omedetou gozaimasu Sdr/i *${s.name}*! 🎉🇯🇵\n\nKabar gembira dari LPK Sahabat Jepang Indonesia!\nDokumen *Certificate of Eligibility (CoE)* Anda dari Imigrasi Jepang telah terbit resmi${s.coe_number ? ' dengan nomor: *' + s.coe_number + '*' : ''}.\n\nTim kami saat ini sedang mempersiapkan pengajuan Visa Kerja ke Kedutaan Besar Jepang. Harap pastikan paspor asli Anda masih aktif. Selamat melangkah menuju karir di Jepang!`;
        }

        const waUrl = `https://api.whatsapp.com/send?phone=${cleanPhone}&text=${encodeURIComponent(msg)}`;
        window.open(waUrl, '_blank');
    }

    // View Doc from Detail Modal
    function viewDocFromDetailModal(title, docUrl) {
        document.getElementById('indexDocPreviewTitle').textContent = title;
        const downloadBtn = document.getElementById('indexDocDownloadBtn');
        downloadBtn.href = docUrl;
        downloadBtn.download = title.replace(/[^a-zA-Z0-9]/g, '_');

        const container = document.getElementById('indexDocContainer');
        container.innerHTML = '';

        if (!docUrl) {
            container.innerHTML = '<p class="text-slate-400 text-sm">Tidak ada berkas yang dapat ditampilkan.</p>';
        } else if (docUrl.includes('data:application/pdf') || docUrl.endsWith('.pdf')) {
            container.innerHTML = `<iframe src="${docUrl}" class="w-full h-[65vh] rounded-xl border border-slate-300 shadow-sm" frameborder="0"></iframe>`;
        } else {
            container.innerHTML = `<img src="${docUrl}" alt="${title}" class="max-w-full max-h-[70vh] rounded-xl shadow-md object-contain border border-slate-200">`;
        }

        openModal('indexDocPreviewModal');
        if (window.lucide) {
            lucide.createIcons();
        }
    }
</script>
@endsection
