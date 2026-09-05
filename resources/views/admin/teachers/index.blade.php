@extends('admin.layouts.admin')

@section('title', 'Karyawan, Direksi & Sensei')
@section('page_title', 'Manajemen SDM: Direksi, Karyawan & Sensei')

@section('content')
<div class="space-y-6">

    <!-- 1. Top KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Karyawan & SDM</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ number_format($stats['total_teachers']) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <i data-lucide="crown" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Dewan Direksi & CEO</p>
                <h3 class="text-2xl font-black text-amber-600 mt-0.5">{{ number_format($stats['executives_count']) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Status Aktif</p>
                <h3 class="text-2xl font-black text-emerald-600 mt-0.5">{{ number_format($stats['active_teachers']) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">JLPT N1 / Native Sensei</p>
                <h3 class="text-2xl font-black text-japan-600 mt-0.5">{{ number_format($stats['n1_teachers']) }}</h3>
            </div>
        </div>

    </div>

    <!-- 2. Action & Filter Bar -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        
        <form action="{{ route('admin.teachers.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 flex-1">
            <div class="relative min-w-[200px] flex-1">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}" 
                    placeholder="Cari NIP, Nama, Jabatan, Departemen..." 
                    class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"
                >
            </div>

            <select name="role" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                <option value="all">Semua Jabatan</option>
                <option value="ceo_owner" {{ request('role') === 'ceo_owner' ? 'selected' : '' }}>👑 Owner / CEO</option>
                <option value="director" {{ request('role') === 'director' ? 'selected' : '' }}>🏛️ Direktur</option>
                <option value="finance" {{ request('role') === 'finance' ? 'selected' : '' }}>💰 Bendahara & Keuangan</option>
                <option value="sensei" {{ request('role') === 'sensei' ? 'selected' : '' }}>🎓 Sensei / Pengajar</option>
                <option value="operations" {{ request('role') === 'operations' ? 'selected' : '' }}>⚙️ Operasional</option>
                <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>📋 Staff Kantor</option>
            </select>

            <select name="status" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                <option value="all">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="leave" {{ request('status') === 'leave' ? 'selected' : '' }}>Cuti</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                Filter
            </button>

            @if(request()->anyFilled(['q', 'role', 'status']))
                <a href="{{ route('admin.teachers.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold" title="Reset Filter">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                </a>
            @endif
        </form>

        <div class="flex items-center gap-2 flex-shrink-0">
            <a 
                href="{{ route('admin.teachers.export.pdf', request()->all()) }}" 
                target="_blank"
                class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition shadow-xs flex items-center gap-1.5"
                title="Cetak Rekapitulasi Data ke PDF Resmi"
            >
                <i data-lucide="printer" class="w-4 h-4 text-red-400"></i>
                <span>Export PDF SDM</span>
            </a>

            <a 
                href="{{ route('admin.teachers.create') }}" 
                class="btn-red-primary px-4 py-2 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5"
            >
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Tambah Karyawan / Sensei</span>
            </a>
        </div>

    </div>

    <!-- 3. Teachers & Employees Grid List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($teachers as $tc)
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between group relative overflow-hidden">
                
                @if($tc->is_executive)
                    <div class="absolute top-0 right-0 px-3 py-0.5 bg-gradient-to-l from-amber-500 to-amber-600 text-white text-[9px] font-black uppercase tracking-wider rounded-bl-xl shadow-xs flex items-center gap-1">
                        <i data-lucide="star" class="w-3 h-3 fill-amber-200 text-amber-200"></i>
                        <span>Eksekutif / Pimpinan Guest</span>
                    </div>
                @endif

                <div class="space-y-4">
                    <div class="flex items-start gap-3.5">
                        <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0 relative">
                            @if($tc->photo)
                                <img src="{{ $tc->photo }}" alt="{{ $tc->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 font-bold font-mono text-sm bg-slate-100">
                                    {{ substr($tc->name, 0, 2) }}
                                </div>
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold border {{ $tc->role_badge['bg'] }}">
                                    {{ $tc->role_badge['label'] }}
                                </span>
                                @if($tc->role === 'sensei' && $tc->jlpt_level && $tc->jlpt_level !== '-')
                                    <span class="px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-red-50 text-japan-600 border border-red-100">
                                        {{ $tc->jlpt_level }}
                                    </span>
                                @endif
                            </div>

                            <h4 class="font-extrabold text-slate-900 text-sm mt-1 truncate group-hover:text-japan-600 transition" title="{{ $tc->name }}">
                                {{ $tc->name }}
                            </h4>

                            <p class="text-xs text-slate-500 font-medium truncate">
                                {{ $tc->position_title ?: ($tc->romaji_name ?: 'Sensei LPK SJI') }}
                            </p>
                        </div>
                    </div>

                    <!-- Details Box -->
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[10px] font-bold uppercase">NIP / ID:</span>
                            <span class="font-mono font-bold text-slate-800">{{ $tc->nip }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[10px] font-bold uppercase">Departemen:</span>
                            <span class="font-bold text-slate-700">{{ $tc->department ?: ($tc->role === 'sensei' ? 'Divisi Akademik' : 'Operasional') }}</span>
                        </div>
                        @if($tc->phone)
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 text-[10px] font-bold uppercase">No. WhatsApp:</span>
                                <span class="text-slate-600">{{ $tc->phone }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="inline-flex items-center gap-1.5 font-bold text-[11px] {{ $tc->status === 'active' ? 'text-emerald-600' : 'text-slate-400' }}">
                        <span class="w-2 h-2 rounded-full {{ $tc->status === 'active' ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                        <span>{{ ucfirst($tc->status) }}</span>
                    </span>

                    <div class="flex items-center gap-1.5">
                        <button 
                            type="button" 
                            data-teacher='@json($tc)'
                            onclick="openSalaryModal(JSON.parse(this.getAttribute('data-teacher')))" 
                            class="p-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold transition cursor-pointer"
                            title="Bayar Gaji / Honorarium (Kas Keluar)"
                        >
                            <i data-lucide="wallet" class="w-3.5 h-3.5"></i>
                        </button>

                        <a 
                            href="{{ route('admin.teachers.edit', $tc->id) }}" 
                            class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition cursor-pointer"
                            title="Edit Data"
                        >
                            <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                        </a>

                        <form action="{{ route('admin.teachers.destroy', $tc->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data karyawan {{ $tc->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold transition cursor-pointer" title="Hapus Data">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200 p-8">
                <div class="w-16 h-16 rounded-2xl bg-red-50 text-japan-600 mx-auto flex items-center justify-center mb-3">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
                <h3 class="font-extrabold text-slate-900 text-base">Belum Ada Data Karyawan / Sensei</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Tambahkan data dewan direksi, bendahara, staf operasional, atau sensei pengajar.</p>
                <div class="mt-4">
                    <a href="{{ route('admin.teachers.create') }}" class="btn-red-primary px-5 py-2.5 rounded-xl text-xs font-bold inline-flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Tambah Karyawan Baru</span>
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if($teachers->hasPages())
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
            {{ $teachers->links() }}
        </div>
    @endif

</div>

<!-- Modal Pembayaran Gaji / Honorarium Sensei -->
<div id="salaryModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs" onclick="closeSalaryModal()"></div>
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden z-10 animate-in fade-in zoom-in-95 duration-200">
        <div class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white p-5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center font-bold">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-white">Pembayaran Gaji / Honorarium Sensei</h3>
                    <p class="text-[10px] text-emerald-200 font-semibold">Tercatat Otomatis di Buku Kas Umum (BKK/Kredit)</p>
                </div>
            </div>
            <button onclick="closeSalaryModal()" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm cursor-pointer">
                &times;
            </button>
        </div>

        <form id="salaryModalForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-xs">
            @csrf
            
            <div class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-100 space-y-1">
                <div class="flex justify-between items-center">
                    <span class="text-slate-500 font-medium">Penerima Honorarium:</span>
                    <span id="salaryModalTeacherName" class="font-extrabold text-slate-900">-</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500 font-medium">Identitas / NIP:</span>
                    <span id="salaryModalNip" class="font-mono font-bold text-slate-800">-</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase">Nominal Bersih (IDR) *</label>
                    <input 
                        type="number" 
                        name="amount" 
                        required 
                        min="10000" 
                        step="10000"
                        placeholder="Contoh: 3500000"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 font-mono font-bold text-sm text-emerald-800"
                    >
                </div>

                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase">Periode Pembayaran *</label>
                    <input 
                        type="text" 
                        name="salary_period" 
                        value="{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}"
                        required 
                        placeholder="Contoh: September 2026"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 font-bold text-slate-800"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase">Akun Kas / Bank Pembayar *</label>
                    <select name="payment_method" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 font-bold">
                        @foreach($paymentMethods as $pmKey => $pmLabel)
                            <option value="{{ $pmKey }}">{{ $pmLabel }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase">Tanggal Pembayaran *</label>
                    <input 
                        type="date" 
                        name="payment_date" 
                        value="{{ date('Y-m-d') }}" 
                        required 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 font-bold"
                    >
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase">Upload Bukti Transfer / Slip (Opsional)</label>
                <input 
                    type="file" 
                    name="proof_file" 
                    accept="image/*,.pdf"
                    class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"
                >
            </div>

            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase">Catatan / Rincian Jam Mengajar</label>
                <input 
                    type="text" 
                    name="notes" 
                    placeholder="Contoh: Honor mengajar 60 jam + tunjangan modul" 
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600"
                >
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeSalaryModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black shadow-md flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                    <span>Bayar Gaji (Kas Keluar)</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openSalaryModal(t) {
        const form = document.getElementById('salaryModalForm');
        form.action = `/admin/teachers/${t.id}/pay-salary`;

        document.getElementById('salaryModalTeacherName').textContent = t.name + ' (' + (t.position_title || t.role) + ')';
        document.getElementById('salaryModalNip').textContent = 'NIP: ' + t.nip;

        document.getElementById('salaryModal').classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }

    function closeSalaryModal() {
        document.getElementById('salaryModal').classList.add('hidden');
    }
</script>
@endsection

