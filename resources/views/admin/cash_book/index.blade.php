@extends('admin.layouts.admin')

@section('title', 'Buku Kas Umum & Jurnal Keuangan LPK')
@section('page_title', 'Buku Kas Umum & Jurnal Keuangan LPK')

@section('content')
<div class="space-y-6">

    <!-- Top Action Header & Quick Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-3xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-japan-50 text-japan-600 flex items-center justify-center font-black text-xl shadow-xs">
                <i data-lucide="book-open" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-lg font-black text-slate-900 tracking-tight">Buku Kas Umum & Jurnal Keuangan Terpusat</h2>
                <p class="text-xs text-slate-500 font-medium">Rekapitulasi mutasi kas masuk, pengeluaran operasional, dan saldo berjalan lembaga</p>
            </div>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <button 
                type="button" 
                id="btnTopKasMasuk"
                onclick="openCreateModal('income')" 
                class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm flex items-center gap-2 transition transform active:scale-95 cursor-pointer"
            >
                <i data-lucide="arrow-down-left" class="w-4 h-4"></i>
                <span>+ Kas Masuk (Debit)</span>
            </button>

            <button 
                type="button" 
                id="btnTopKasKeluar"
                onclick="openCreateModal('expense')" 
                class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-sm flex items-center gap-2 transition transform active:scale-95 cursor-pointer"
            >
                <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                <span>+ Kas Keluar (Kredit)</span>
            </button>

            <a 
                href="{{ route('admin.cash-book.export.csv', request()->query()) }}" 
                download="buku_kas_umum_lpk_sji.csv"
                class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-200 shadow-xs flex items-center gap-1.5 transition cursor-pointer"
                title="Ekspor Seluruh Mutasi ke Format CSV Excel"
            >
                <i data-lucide="download" class="w-4 h-4 text-slate-600"></i>
                <span class="hidden sm:inline">Export CSV</span>
            </a>

            <a 
                href="{{ route('admin.cash-book.export.pdf', request()->query()) }}" 
                target="_blank" 
                class="px-3.5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-xs flex items-center gap-1.5 transition cursor-pointer"
                title="Cetak Laporan Buku Kas Resmi ke PDF A4 Landscape"
            >
                <i data-lucide="printer" class="w-4 h-4 text-japan-400"></i>
                <span class="hidden sm:inline">Cetak PDF</span>
            </a>
        </div>
    </div>

    <!-- 4 Metrik Kas & Neraca Saldo -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Pemasukan Periode Ini -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Pemasukan (Debit)</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="text-2xl font-black text-emerald-700">Rp {{ number_format($periodIncome, 0, ',', '.') }}</h3>
            <p class="text-[11px] text-slate-400">Total penerimaan kas pada periode ini</p>
        </div>

        <!-- 2. Total Pengeluaran Periode Ini -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-bold uppercase tracking-wider text-rose-800">Pengeluaran (Kredit)</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                    <i data-lucide="receipt" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="text-2xl font-black text-rose-700">Rp {{ number_format($periodExpense, 0, ',', '.') }}</h3>
            <p class="text-[11px] text-slate-400">Total beban & belanja dinas periode ini</p>
        </div>

        <!-- 3. Arus Kas Bersih (Netto Periode Ini) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Surplus / Defisit Periode</span>
                <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase {{ $periodNet >= 0 ? 'bg-blue-100 text-blue-800' : 'bg-rose-100 text-rose-800' }}">
                    {{ $periodNet >= 0 ? 'Surplus' : 'Defisit' }}
                </span>
            </div>
            <h3 class="text-2xl font-black {{ $periodNet >= 0 ? 'text-blue-700' : 'text-rose-700' }}">
                {{ $periodNet >= 0 ? '+' : '' }}Rp {{ number_format($periodNet, 0, ',', '.') }}
            </h3>
            <p class="text-[11px] text-slate-400">Selisih mutasi masuk dikurangi keluar</p>
        </div>

        <!-- 4. Saldo Kas Berjalan Keseluruhan -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-2 bg-gradient-to-br from-slate-900 to-slate-950 text-white">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-300">Saldo Kas Riil Lembaga</span>
                <div class="w-8 h-8 rounded-lg bg-slate-800 text-japan-400 flex items-center justify-center font-bold">
                    <i data-lucide="landmark" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="text-2xl font-black text-white">Rp {{ number_format($overallCashBalance, 0, ',', '.') }}</h3>
            <p class="text-[11px] text-slate-400 font-medium">Akumulasi saldo kas & rekening aktif LPK</p>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.cash-book.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3 text-xs">
            <!-- 1. Periode Waktu -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">Periode</label>
                <select name="period" id="filterPeriod" onchange="toggleCustomDates(this.value)" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-semibold focus:ring-2 focus:ring-japan-500">
                    <option value="this_month" {{ request('period', 'this_month') === 'this_month' ? 'selected' : '' }}>Bulan Ini ({{ now()->translatedFormat('F Y') }})</option>
                    <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="this_week" {{ request('period') === 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="this_year" {{ request('period') === 'this_year' ? 'selected' : '' }}>Tahun Ini ({{ now()->year }})</option>
                    <option value="custom" {{ request('period') === 'custom' ? 'selected' : '' }}>Rentang Kustom...</option>
                </select>
            </div>

            <!-- 2. Tipe Transaksi -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">Tipe Mutasi</label>
                <select name="type" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-semibold focus:ring-2 focus:ring-japan-500">
                    <option value="">Semua Tipe</option>
                    <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Pemasukan (Debit)</option>
                    <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Pengeluaran (Kredit)</option>
                </select>
            </div>

            <!-- 3. Kategori Akun -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">Kategori Akun</label>
                <select name="category" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-semibold focus:ring-2 focus:ring-japan-500">
                    <option value="all">Semua Kategori</option>
                    <optgroup label="-- Pemasukan --">
                        @foreach($incomeCategories as $key => $val)
                            <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="-- Pengeluaran --">
                        @foreach($expenseCategories as $key => $val)
                            <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>

            <!-- 4. Metode Bayar -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">Rekening / Kas</label>
                <select name="payment_method" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-semibold focus:ring-2 focus:ring-japan-500">
                    <option value="all">Semua Akun</option>
                    @foreach($paymentMethods as $key => $val)
                        <option value="{{ $key }}" {{ request('payment_method') === $key ? 'selected' : '' }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 5. Search Text -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">Pencarian</label>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}" 
                    placeholder="No bukti / judul / catatan..." 
                    class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-semibold focus:ring-2 focus:ring-japan-500"
                >
            </div>

            <!-- 6. Submit Button -->
            <div class="flex items-end gap-2">
                <button type="submit" class="w-full py-2 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>Terapkan</span>
                </button>
                @if(request()->anyFilled(['period', 'type', 'category', 'payment_method', 'q', 'start_date', 'end_date']))
                    <a href="{{ route('admin.cash-book.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition" title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>

            <!-- Custom Date Inputs (Conditionally Displayed) -->
            <div id="customDateRange" class="col-span-full grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-slate-100 {{ request('period') === 'custom' ? '' : 'hidden' }}">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Sampai</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Jurnal Buku Kas Umum -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Jurnal Mutasi Kas Umum</h3>
                <p class="text-xs text-slate-400">Daftar transaksi debit dan kredit tersusun kronologis</p>
            </div>
            <span class="text-xs font-mono font-bold px-3 py-1 bg-slate-100 text-slate-700 rounded-full">
                {{ $transactions->total() }} Transaksi
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-[10px] font-black tracking-wider">
                    <tr>
                        <th class="py-3 px-4">No. Bukti & Tanggal</th>
                        <th class="py-3 px-4">Uraian / Kategori Akun</th>
                        <th class="py-3 px-4">Rekening / Kas</th>
                        <th class="py-3 px-4 text-right">Pemasukan (Debit)</th>
                        <th class="py-3 px-4 text-right">Pengeluaran (Kredit)</th>
                        <th class="py-3 px-4 text-center">Bukti Nota</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $trx)
                        @php
                            $badge = $trx->category_badge;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- No Bukti & Tanggal -->
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $trx->type === 'income' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                    <span class="font-mono font-black {{ $trx->type === 'income' ? 'text-emerald-700' : 'text-rose-700' }}">
                                        {{ $trx->transaction_number }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 mt-0.5 font-medium">
                                    {{ $trx->transaction_date->format('d/m/Y') }}
                                </p>
                            </td>

                            <!-- Uraian & Kategori -->
                            <td class="py-3 px-4 max-w-xs sm:max-w-md">
                                <h5 class="font-bold text-slate-900 leading-snug">{{ $trx->title }}</h5>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold border {{ $badge['bg'] }}">
                                        <i data-lucide="{{ $badge['icon'] }}" class="w-3 h-3"></i>
                                        <span>{{ $trx->category_label }}</span>
                                    </span>
                                    @if($trx->notes)
                                        <span class="text-[10px] text-slate-400 italic truncate max-w-[200px]" title="{{ $trx->notes }}">
                                            "{{ $trx->notes }}"
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Rekening / Kas -->
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-semibold text-[11px] inline-block">
                                    {{ $trx->payment_method_label }}
                                </span>
                                <p class="text-[10px] text-slate-400 mt-0.5 font-mono">Oleh: {{ $trx->recorded_by ?: 'System' }}</p>
                            </td>

                            <!-- Penerimaan (Debit) -->
                            <td class="py-3 px-4 text-right font-mono font-bold text-emerald-700 text-sm">
                                @if($trx->type === 'income')
                                    +Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>

                            <!-- Pengeluaran (Kredit) -->
                            <td class="py-3 px-4 text-right font-mono font-bold text-rose-700 text-sm">
                                @if($trx->type === 'expense')
                                    -Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>

                            <!-- Bukti Nota -->
                            <td class="py-3 px-4 text-center">
                                @if($trx->proof_file)
                                    <button 
                                        type="button" 
                                        onclick="showProofModal('{{ $trx->transaction_number }}', '{{ $trx->title }}', '{{ $trx->proof_file }}')" 
                                        class="p-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold transition inline-flex items-center gap-1 text-[11px]"
                                        title="Lihat Bukti Transaksi"
                                    >
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        <span>Bukti</span>
                                    </button>
                                @else
                                    <span class="text-[10px] text-slate-400 italic">Tanpa Nota</span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <button 
                                        type="button" 
                                        onclick="openEditModal({{ json_encode($trx) }})" 
                                        class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition" 
                                        title="Edit Transaksi"
                                    >
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    </button>

                                    <form action="{{ route('admin.cash-book.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi kas {{ $trx->transaction_number }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 transition" title="Hapus Transaksi">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-2 opacity-40"></i>
                                <p class="text-sm font-bold text-slate-700">Belum ada transaksi kas pada periode ini.</p>
                                <p class="text-xs text-slate-400 mt-1">Gunakan tombol cepat di bawah untuk mencatat kas masuk atau pengeluaran operasional.</p>
                                <div class="mt-4 flex items-center justify-center gap-2">
                                    <button type="button" onclick="openCreateModal('income')" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition">
                                        + Kas Masuk (Debit)
                                    </button>
                                    <button type="button" onclick="openCreateModal('expense')" class="px-3.5 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-xs transition">
                                        + Kas Keluar (Kredit)
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Tambah Transaksi Kas -->
<div id="createTransactionModal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-5 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2.5">
                <div id="modalIconContainer" class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    <i data-lucide="arrow-down-left" id="modalIcon" class="w-5 h-5"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-slate-900 text-base" id="modalTitle">Catat Kas Masuk (Debit)</h4>
                    <p class="text-xs text-slate-400">Input transaksi finansial langsung ke buku kas umum</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('createTransactionModal')" class="text-slate-400 hover:text-slate-700 text-xl font-bold p-1">&times;</button>
        </div>

        <form action="{{ route('admin.cash-book.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf
            <input type="hidden" name="type" id="formType" value="income">

            <!-- Tipe Switch Buttons -->
            <div class="grid grid-cols-2 gap-2 p-1 bg-slate-100 rounded-xl">
                <button type="button" onclick="switchModalType('income')" id="btnSwitchIncome" class="py-2 font-bold rounded-lg transition bg-white text-emerald-700 shadow-xs">
                    Kas Masuk (Debit)
                </button>
                <button type="button" onclick="switchModalType('expense')" id="btnSwitchExpense" class="py-2 font-bold rounded-lg transition text-slate-600 hover:text-slate-900">
                    Kas Keluar (Kredit)
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- Kategori Akun -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kategori Akun <span class="text-red-500">*</span></label>
                    <select name="category" id="formCategory" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-semibold focus:ring-2 focus:ring-japan-500">
                        <!-- Populated by JS -->
                    </select>
                </div>

                <!-- Tanggal Transaksi -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Transaksi <span class="text-red-500">*</span></label>
                    <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-semibold">
                </div>
            </div>

            <!-- Uraian / Judul Transaksi -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">Uraian / Judul Transaksi <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="Contoh: Pembayaran Gaji Sensei September 2026" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-semibold">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- Nominal (IDR) -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nominal Transaksi (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="amount" min="100" step="100" required placeholder="500000" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-mono font-bold text-slate-900">
                </div>

                <!-- Metode Pembayaran -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Metode / Akun Bank <span class="text-red-500">*</span></label>
                    <select name="payment_method" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-semibold">
                        @foreach($paymentMethods as $key => $val)
                            <option value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Upload Bukti Transaksi -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">Upload Bukti Transfer / Kwitansi / Nota Fisik (Opsional)</label>
                <input type="file" name="proof_file" accept="image/*,application/pdf" class="w-full text-[11px] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 border border-slate-200 rounded-xl p-1 bg-slate-50">
            </div>

            <!-- Catatan / Memo -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">Catatan / Memo Tambahan</label>
                <textarea name="notes" rows="2" placeholder="Keterangan tambahan untuk pelaporan..." class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200"></textarea>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeModal('createTransactionModal')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition">
                    Batal
                </button>
                <button type="submit" id="modalSubmitBtn" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-sm transition">
                    Simpan Kas Masuk
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Transaksi Kas -->
<div id="editTransactionModal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-5 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <h4 class="font-extrabold text-slate-900 text-base" id="editModalTitle">Edit Transaksi Kas</h4>
                <p class="text-xs text-slate-400 font-mono" id="editTrxNumber">-</p>
            </div>
            <button type="button" onclick="closeModal('editTransactionModal')" class="text-slate-400 hover:text-slate-700 text-xl font-bold p-1">&times;</button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold text-slate-700 mb-1">Uraian / Judul Transaksi <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="editTitle" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-semibold">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kategori Akun <span class="text-red-500">*</span></label>
                    <select name="category" id="editCategory" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-semibold">
                        <optgroup label="-- Pemasukan --">
                            @foreach($incomeCategories as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="-- Pengeluaran --">
                            @foreach($expenseCategories as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Transaksi <span class="text-red-500">*</span></label>
                    <input type="date" name="transaction_date" id="editDate" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-semibold">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Metode / Akun Bank <span class="text-red-500">*</span></label>
                <select name="payment_method" id="editMethod" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-semibold">
                    @foreach($paymentMethods as $key => $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Ganti Bukti Transfer / Nota (Opsional)</label>
                <input type="file" name="proof_file" accept="image/*,application/pdf" class="w-full text-[11px] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 border border-slate-200 rounded-xl p-1 bg-slate-50">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Catatan / Memo Tambahan</label>
                <textarea name="notes" id="editNotes" rows="2" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200"></textarea>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeModal('editTransactionModal')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Pratinjau Bukti Transaksi -->
<div id="proofModal" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <h4 class="font-extrabold text-slate-900 text-sm" id="proofModalTitle">Bukti Transaksi</h4>
                <p class="text-xs text-slate-400 font-mono" id="proofModalSubtitle">-</p>
            </div>
            <button type="button" onclick="closeModal('proofModal')" class="text-slate-400 hover:text-slate-700 text-xl font-bold p-1">&times;</button>
        </div>

        <div id="proofContainer" class="max-h-[60vh] overflow-auto flex items-center justify-center bg-slate-100 rounded-2xl p-2 border border-slate-200">
            <!-- Rendered by JS -->
        </div>

        <div class="flex items-center justify-between pt-2">
            <a id="proofDownloadBtn" href="#" download="bukti_transaksi" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition flex items-center gap-1.5">
                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                <span>Unduh Bukti</span>
            </a>
            <button type="button" onclick="closeModal('proofModal')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    const incomeCategoriesMap = @json($incomeCategories);
    const expenseCategoriesMap = @json($expenseCategories);

    // Fallback modal open/close helpers
    window.openModal = window.openModal || function(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.classList.add('active');
        }
    };

    window.closeModal = window.closeModal || function(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modal.classList.remove('active');
        }
    };

    function toggleCustomDates(val) {
        const range = document.getElementById('customDateRange');
        if (range) {
            if (val === 'custom') {
                range.classList.remove('hidden');
            } else {
                range.classList.add('hidden');
            }
        }
    }

    // Direct Instant Zero-Lag Modal Trigger
    window.openCreateModal = function(type) {
        switchModalType(type);
        const modal = document.getElementById('createTransactionModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.classList.add('active');
        }
    };

    window.switchModalType = function(type) {
        const formType = document.getElementById('formType');
        const modalTitle = document.getElementById('modalTitle');
        const modalIconContainer = document.getElementById('modalIconContainer');
        const modalSubmitBtn = document.getElementById('modalSubmitBtn');
        const btnSwitchIncome = document.getElementById('btnSwitchIncome');
        const btnSwitchExpense = document.getElementById('btnSwitchExpense');
        const formCategory = document.getElementById('formCategory');

        if (formType) formType.value = type;

        if (type === 'income') {
            if (modalTitle) modalTitle.textContent = 'Catat Kas Masuk (Debit)';
            if (modalIconContainer) modalIconContainer.className = 'w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold';
            if (modalSubmitBtn) {
                modalSubmitBtn.className = 'px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-sm transition';
                modalSubmitBtn.textContent = 'Simpan Kas Masuk';
            }
            if (btnSwitchIncome) btnSwitchIncome.className = 'py-2 font-bold rounded-lg transition bg-white text-emerald-700 shadow-xs';
            if (btnSwitchExpense) btnSwitchExpense.className = 'py-2 font-bold rounded-lg transition text-slate-600 hover:text-slate-900';

            // Populate income categories
            if (formCategory) {
                formCategory.innerHTML = '';
                Object.keys(incomeCategoriesMap).forEach(key => {
                    const opt = document.createElement('option');
                    opt.value = key;
                    opt.textContent = incomeCategoriesMap[key];
                    formCategory.appendChild(opt);
                });
            }
        } else {
            if (modalTitle) modalTitle.textContent = 'Catat Kas Keluar (Kredit)';
            if (modalIconContainer) modalIconContainer.className = 'w-9 h-9 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold';
            if (modalSubmitBtn) {
                modalSubmitBtn.className = 'px-5 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold shadow-sm transition';
                modalSubmitBtn.textContent = 'Simpan Kas Keluar';
            }
            if (btnSwitchIncome) btnSwitchIncome.className = 'py-2 font-bold rounded-lg transition text-slate-600 hover:text-slate-900';
            if (btnSwitchExpense) btnSwitchExpense.className = 'py-2 font-bold rounded-lg transition bg-white text-rose-700 shadow-xs';

            // Populate expense categories
            if (formCategory) {
                formCategory.innerHTML = '';
                Object.keys(expenseCategoriesMap).forEach(key => {
                    const opt = document.createElement('option');
                    opt.value = key;
                    opt.textContent = expenseCategoriesMap[key];
                    formCategory.appendChild(opt);
                });
            }
        }

        if (window.lucide) {
            lucide.createIcons();
        }
    };

    window.openEditModal = function(trx) {
        const editForm = document.getElementById('editForm');
        if (editForm) editForm.action = `/admin/cash-book/${trx.id}`;
        
        const titleEl = document.getElementById('editModalTitle');
        if (titleEl) titleEl.textContent = `Edit ${trx.type === 'income' ? 'Kas Masuk' : 'Kas Keluar'}`;
        
        const numEl = document.getElementById('editTrxNumber');
        if (numEl) numEl.textContent = trx.transaction_number;
        
        const editTitle = document.getElementById('editTitle');
        if (editTitle) editTitle.value = trx.title;
        
        const editCat = document.getElementById('editCategory');
        if (editCat) editCat.value = trx.category;
        
        const editDate = document.getElementById('editDate');
        if (editDate) editDate.value = trx.transaction_date ? trx.transaction_date.substring(0, 10) : '';
        
        const editMethod = document.getElementById('editMethod');
        if (editMethod) editMethod.value = trx.payment_method;
        
        const editNotes = document.getElementById('editNotes');
        if (editNotes) editNotes.value = trx.notes || '';

        const modal = document.getElementById('editTransactionModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.classList.add('active');
        }
    };

    window.showProofModal = function(trxNo, title, proofUrl) {
        const modalTitle = document.getElementById('proofModalTitle');
        if (modalTitle) modalTitle.textContent = title;
        
        const modalSub = document.getElementById('proofModalSubtitle');
        if (modalSub) modalSub.textContent = trxNo;
        
        const container = document.getElementById('proofContainer');
        const dlBtn = document.getElementById('proofDownloadBtn');

        if (dlBtn) {
            dlBtn.href = proofUrl;
            dlBtn.download = `${trxNo}_bukti`;
        }

        if (container) {
            if (proofUrl.startsWith('data:application/pdf')) {
                container.innerHTML = `<iframe src="${proofUrl}" class="w-full h-80 rounded-xl border-0"></iframe>`;
            } else {
                container.innerHTML = `<img src="${proofUrl}" alt="Bukti Transaksi" class="max-h-80 max-w-full rounded-xl object-contain shadow-md">`;
            }
        }

        const modal = document.getElementById('proofModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.classList.add('active');
        }
    };

    // Auto bind clicks on DOM ready
    document.addEventListener('DOMContentLoaded', () => {
        const btnIn = document.getElementById('btnTopKasMasuk');
        if (btnIn) {
            btnIn.addEventListener('click', (e) => {
                e.preventDefault();
                openCreateModal('income');
            });
        }
        const btnOut = document.getElementById('btnTopKasKeluar');
        if (btnOut) {
            btnOut.addEventListener('click', (e) => {
                e.preventDefault();
                openCreateModal('expense');
            });
        }

        // Initialize categories in form
        switchModalType('income');
    });
</script>
@endsection
