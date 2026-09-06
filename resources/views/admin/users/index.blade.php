@extends('admin.layouts.admin')

@section('title', 'Manajemen Pengguna & Hak Akses (RBAC)')
@section('page_title', 'Manajemen Pengguna & Hak Akses (RBAC)')

@section('content')
<div class="space-y-8">
    
    <!-- 4 KPI Summary Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Akun</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ $rolesCount['total'] }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="shield" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Administrator</p>
                <h3 class="text-2xl font-black text-japan-600 mt-0.5">{{ $rolesCount['admin'] }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <i data-lucide="graduation-cap" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Pengajar / Sensei</p>
                <h3 class="text-2xl font-black text-blue-600 mt-0.5">{{ $rolesCount['teacher'] }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="briefcase" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Karyawan / Staf</p>
                <h3 class="text-2xl font-black text-emerald-600 mt-0.5">{{ $rolesCount['staff'] }}</h3>
            </div>
        </div>

    </div>

    <!-- Matriks Hak Akses Peran (RBAC Matrix Reference Card) -->
    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold text-xs">
                    <i data-lucide="key" class="w-4 h-4 text-red-400"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-900 text-sm">Matriks Hak Akses Resmi (RBAC Matrix Policy)</h3>
                    <p class="text-xs text-slate-500">Batasan otorisasi sistem berdasarkan fungsi jabatan kerja di LPK Sahabat Jepang Indonesia</p>
                </div>
            </div>
            <span class="text-[11px] font-mono font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                Level Keamanan: Strict
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-extrabold text-[11px]">
                        <th class="py-3 px-4">Nama Peran / Role</th>
                        <th class="py-3 px-3 text-center">Dashboard & Siswa</th>
                        <th class="py-3 px-3 text-center">Wawancara Kaisha</th>
                        <th class="py-3 px-3 text-center">Keuangan, Kas & P&L</th>
                        <th class="py-3 px-3 text-center">Reimburse / Kasbon</th>
                        <th class="py-3 px-3 text-center">CMS Web & Hero</th>
                        <th class="py-3 px-3 text-center">Kelola RBAC User</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    <tr class="hover:bg-slate-50/80">
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 text-japan-700 font-bold border border-red-200">
                                <i data-lucide="shield" class="w-3 h-3 text-japan-600"></i>
                                <span>Administrator</span>
                            </span>
                            <span class="block text-[10px] text-slate-400 mt-0.5">Pimpinan & IT LPK SJI</span>
                        </td>
                        <td class="py-3 px-3 text-center text-emerald-600 font-bold"><i data-lucide="check-circle" class="w-4 h-4 mx-auto"></i> Penuh</td>
                        <td class="py-3 px-3 text-center text-emerald-600 font-bold"><i data-lucide="check-circle" class="w-4 h-4 mx-auto"></i> Penuh</td>
                        <td class="py-3 px-3 text-center text-emerald-600 font-bold"><i data-lucide="check-circle" class="w-4 h-4 mx-auto"></i> Penuh</td>
                        <td class="py-3 px-3 text-center text-emerald-600 font-bold"><i data-lucide="check-circle" class="w-4 h-4 mx-auto"></i> Approval</td>
                        <td class="py-3 px-3 text-center text-emerald-600 font-bold"><i data-lucide="check-circle" class="w-4 h-4 mx-auto"></i> Penuh</td>
                        <td class="py-3 px-3 text-center text-emerald-600 font-bold"><i data-lucide="check-circle" class="w-4 h-4 mx-auto"></i> Penuh</td>
                    </tr>
                    <tr class="hover:bg-slate-50/80">
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 font-bold border border-blue-200">
                                <i data-lucide="graduation-cap" class="w-3 h-3 text-blue-600"></i>
                                <span>Sensei / Pengajar</span>
                            </span>
                            <span class="block text-[10px] text-slate-400 mt-0.5">Guru Bahasa & Budaya Jepang</span>
                        </td>
                        <td class="py-3 px-3 text-center text-blue-600 font-bold"><i data-lucide="check-circle" class="w-4 h-4 mx-auto"></i> Nilai & Siswa</td>
                        <td class="py-3 px-3 text-center text-blue-600 font-bold"><i data-lucide="check-circle" class="w-4 h-4 mx-auto"></i> Jadwal</td>
                        <td class="py-3 px-3 text-center text-slate-300"><i data-lucide="x-circle" class="w-4 h-4 mx-auto text-slate-300"></i> Dibatasi</td>
                        <td class="py-3 px-3 text-center text-blue-600 font-bold"><i data-lucide="check-circle" class="w-4 h-4 mx-auto"></i> Klaim Pribadi</td>
                        <td class="py-3 px-3 text-center text-slate-300"><i data-lucide="x-circle" class="w-4 h-4 mx-auto text-slate-300"></i> Dibatasi</td>
                        <td class="py-3 px-3 text-center text-slate-300"><i data-lucide="x-circle" class="w-4 h-4 mx-auto text-slate-300"></i> Dibatasi</td>
                    </tr>
                    <tr class="hover:bg-slate-50/80">
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold border border-emerald-200">
                                <i data-lucide="briefcase" class="w-3 h-3 text-emerald-600"></i>
                                <span>Karyawan / Staf LPK</span>
                            </span>
                            <span class="block text-[10px] text-slate-400 mt-0.5">Operasional, Keuangan & Administrasi</span>
                        </td>
                        <td class="py-3 px-3 text-center text-emerald-600 font-bold"><i data-lucide="check-circle" class="w-4 h-4 mx-auto"></i> Penuh</td>
                        <td class="py-3 px-3 text-center text-emerald-600 font-bold"><i data-lucide="check-circle" class="w-4 h-4 mx-auto"></i> Penuh</td>
                        <td class="py-3 px-3 text-center text-emerald-600 font-bold"><i data-lucide="check-circle" class="w-4 h-4 mx-auto"></i> Catat & Jurnal</td>
                        <td class="py-3 px-3 text-center text-emerald-600 font-bold"><i data-lucide="check-circle" class="w-4 h-4 mx-auto"></i> Verifikasi</td>
                        <td class="py-3 px-3 text-center text-slate-300"><i data-lucide="x-circle" class="w-4 h-4 mx-auto text-slate-300"></i> Dibatasi</td>
                        <td class="py-3 px-3 text-center text-slate-300"><i data-lucide="x-circle" class="w-4 h-4 mx-auto text-slate-300"></i> Dibatasi</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add New User Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 max-w-4xl">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Tambah Akun Pengguna Baru</h3>
                <p class="text-xs text-slate-400">Buat akun resmi untuk Administrator, Sensei / Instruktur, atau Karyawan / Staf</p>
            </div>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @csrf
            
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Lengkap *</label>
                <input type="text" name="name" required placeholder="Contoh: Budi Santoso, S.Pd" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Email Login Resmi *</label>
                <input type="email" name="email" required placeholder="nama@sahabatjepangindonesia.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Peran / Role Hak Akses *</label>
                <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold text-slate-800">
                    <option value="admin">Administrator (Akses Penuh Seluruh Sistem, CMS & Pengguna)</option>
                    <option value="teacher" selected>Pengajar / Sensei (Akses Akademik, Evaluasi Siswa & Jadwal)</option>
                    <option value="staff">Karyawan / Staf LPK (Akses Operasional, Kas & Arsip)</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nomor WhatsApp / HP</label>
                <input type="text" name="phone" placeholder="081234567890" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kata Sandi (Password) *</label>
                <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="flex items-center gap-3 pt-6">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded text-japan-600 focus:ring-red-500">
                    <span class="text-xs font-bold text-slate-700">Akun Aktif (Dapat Login)</span>
                </label>
            </div>

            <div class="sm:col-span-2 flex items-center justify-end pt-2">
                <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span>Buat Akun Pengguna</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Users Table Card with Filter & Search -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Table Header & Filter Bar -->
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Daftar Pengguna Sistem ({{ $users->total() }})</h3>
                <p class="text-xs text-slate-400">Pengaturan akun terdaftar dan hak akses operasional</p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Role Filter Tabs -->
                <div class="flex items-center p-1 rounded-xl bg-slate-100 border border-slate-200 text-xs font-bold">
                    <a href="{{ route('admin.users.index') }}" class="px-2.5 py-1 rounded-lg transition {{ !request('role') ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                        Semua
                    </a>
                    <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="px-2.5 py-1 rounded-lg transition {{ request('role') === 'admin' ? 'bg-white text-japan-700 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                        Admin
                    </a>
                    <a href="{{ route('admin.users.index', ['role' => 'teacher']) }}" class="px-2.5 py-1 rounded-lg transition {{ request('role') === 'teacher' ? 'bg-white text-blue-700 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                        Sensei
                    </a>
                    <a href="{{ route('admin.users.index', ['role' => 'staff']) }}" class="px-2.5 py-1 rounded-lg transition {{ request('role') === 'staff' ? 'bg-white text-emerald-700 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                        Karyawan
                    </a>
                </div>

                <!-- Search Input Form -->
                <form action="{{ route('admin.users.index') }}" method="GET" class="relative">
                    @if(request('role'))
                        <input type="hidden" name="role" value="{{ request('role') }}">
                    @endif
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="Cari nama / email..." 
                        class="w-48 sm:w-56 pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 bg-slate-50 focus:bg-white"
                    >
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-1/2 -translate-y-1/2"></i>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3.5 px-4">Nama & Email</th>
                        <th class="py-3.5 px-4">Hak Akses (Role)</th>
                        <th class="py-3.5 px-4">Kontak</th>
                        <th class="py-3.5 px-4">Status Akun</th>
                        <th class="py-3.5 px-4">Terdaftar</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs flex-shrink-0">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-extrabold text-slate-900 flex items-center gap-1.5">
                                            <span>{{ $u->name }}</span>
                                            @if($u->id === auth()->id())
                                                <span class="px-1.5 py-0.2 rounded bg-japan-50 text-japan-600 text-[9px] font-black">Anda</span>
                                            @endif
                                        </h4>
                                        <p class="text-[11px] text-slate-400 font-mono">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($u->role === 'admin')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-black bg-red-100 text-japan-800 border border-red-200 inline-flex items-center gap-1">
                                        <i data-lucide="shield" class="w-3 h-3 text-japan-600"></i>
                                        <span>Administrator</span>
                                    </span>
                                @elseif($u->role === 'teacher')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-black bg-blue-100 text-blue-800 border border-blue-200 inline-flex items-center gap-1">
                                        <i data-lucide="graduation-cap" class="w-3 h-3 text-blue-600"></i>
                                        <span>Pengajar / Sensei</span>
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1">
                                        <i data-lucide="briefcase" class="w-3 h-3 text-emerald-600"></i>
                                        <span>Karyawan / Staf</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 font-medium">
                                {{ $u->phone ?: '-' }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if($u->is_active)
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800 font-bold text-xs inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span>Non-aktif</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-500">
                                {{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    
                                    <!-- Toggle Status Button -->
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.toggle', $u->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button 
                                                type="submit" 
                                                class="px-2 py-1 rounded-lg text-xs font-bold transition {{ $u->is_active ? 'text-amber-700 bg-amber-50 hover:bg-amber-100' : 'text-emerald-700 bg-emerald-50 hover:bg-emerald-100' }}"
                                                title="{{ $u->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}"
                                            >
                                                {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Edit Button -->
                                    <button 
                                        type="button" 
                                        data-user='@json($u)'
                                        onclick="openEditUser(JSON.parse(this.getAttribute('data-user')))" 
                                        class="px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs flex items-center gap-1 transition"
                                    >
                                        <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                        <span>Edit</span>
                                    </button>

                                    <!-- Delete Button -->
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun {{ $u->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 rounded-lg text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 transition" title="Hapus Akun">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">Belum ada data pengguna yang sesuai filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Edit User -->
<div id="editUserModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal hidden">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('editUserModal')"></div>
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10">
        
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold">
                    <i data-lucide="user-cog" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-black text-white">Edit Data Pengguna & Hak Akses</h3>
            </div>
            <button onclick="closeModal('editUserModal')" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm">
                &times;
            </button>
        </div>

        <form id="editUserForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Lengkap *</label>
                <input type="text" name="name" id="editUserName" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Email Login *</label>
                <input type="email" name="email" id="editUserEmail" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Peran / Role *</label>
                    <select name="role" id="editUserRole" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold focus:outline-none focus:border-japan-600">
                        <option value="admin">Administrator (Full Access)</option>
                        <option value="teacher">Pengajar / Sensei (Akademik & Siswa)</option>
                        <option value="staff">Karyawan / Staf LPK (Operasional & Kas)</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">No WhatsApp / HP</label>
                    <input type="text" name="phone" id="editUserPhone" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kata Sandi Baru (Kosongkan jika tidak diganti)</label>
                <input type="password" name="password" minlength="6" placeholder="Biarkan kosong jika tidak ingin mengganti" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
            </div>

            <div class="flex items-center gap-2 pt-2">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="is_active" id="editUserActive" value="1" class="rounded text-japan-600 focus:ring-red-500">
                    <span class="text-xs font-bold text-slate-700">Akun Aktif (Dapat Login)</span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('editUserModal')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md flex items-center gap-1.5">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    function openEditUser(u) {
        document.getElementById('editUserName').value = u.name;
        document.getElementById('editUserEmail').value = u.email;
        document.getElementById('editUserRole').value = u.role === 'karyawan' ? 'staff' : u.role;
        document.getElementById('editUserPhone').value = u.phone || '';
        document.getElementById('editUserActive').checked = !!u.is_active;

        const form = document.getElementById('editUserForm');
        form.action = `/admin/users/${u.id}`;

        openModal('editUserModal');
    }
</script>
@endsection
