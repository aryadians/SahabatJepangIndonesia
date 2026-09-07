@extends('admin.layouts.admin')

@section('title', 'Audit Log & Rekam Jejak Aktivitas')
@section('page_title', 'Audit Trail & Rekam Jejak Sistem')

@section('content')
<div class="space-y-6">

    <!-- 1. Header Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-6 text-white shadow-md border border-slate-700/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-500/20 border border-blue-400/30 text-blue-400 flex items-center justify-center font-bold shrink-0">
                <i data-lucide="shield-alert" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-lg font-black text-white flex items-center gap-2">
                    <span>Audit Trail & Rekam Jejak Sistem LPK</span>
                    <span class="px-2 py-0.5 rounded-full bg-blue-500/20 text-blue-300 text-[10px] font-bold border border-blue-400/30">Keamanan & RBAC</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Pemantauan otomatis seluruh aktivitas login, otorisasi peran, dan perubahan data sensitif organisasi</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <form action="{{ route('admin.audit-logs.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membersihkan rekaman audit log yang lebih lama dari 30 hari?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-red-500/30 text-slate-300 hover:text-red-300 text-xs font-bold border border-white/10 transition flex items-center gap-1.5">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Bersihkan Log > 30 Hari</span>
                </button>
            </form>
        </div>
    </div>

    <!-- 2. KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Log -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Rekaman Log</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1">{{ number_format($stats['total']) }}</h3>
                <span class="text-[11px] text-slate-400 mt-0.5 inline-block">Histori aktivitas tersimpan</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                <i data-lucide="database" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Login Sukses Hari Ini -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Login Hari Ini</p>
                <h3 class="text-2xl font-black text-emerald-700 mt-1">{{ $stats['logins_today'] }} Sesi</h3>
                <span class="text-[11px] text-emerald-600 mt-0.5 inline-block">Pengguna aktif terverifikasi</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="log-in" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Percobaan Login Gagal -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-red-600 uppercase tracking-wider">Login Gagal / Alert</p>
                <h3 class="text-2xl font-black text-red-700 mt-1">{{ $stats['failed_attempts'] }} Insiden</h3>
                <span class="text-[11px] text-red-600 mt-0.5 inline-block">Kredensial salah / nonaktif</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold">
                <i data-lucide="shield-x" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Perubahan RBAC & Akun -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-purple-600 uppercase tracking-wider">Aktivitas RBAC</p>
                <h3 class="text-2xl font-black text-purple-700 mt-1">{{ $stats['rbac_events'] }} Aksi</h3>
                <span class="text-[11px] text-purple-600 mt-0.5 inline-block">Kelola user, role & toggle</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                <i data-lucide="user-cog" class="w-5 h-5"></i>
            </div>
        </div>

    </div>

    <!-- 3. Filter Controls -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
        <form action="{{ route('admin.audit-logs.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            
            <!-- Pencarian Teks -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Cari Deskripsi / IP / User</label>
                <div class="relative">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-2.5"></i>
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="Ketik kata kunci..." 
                        class="w-full pl-9 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs font-medium focus:outline-none focus:border-japan-600"
                    >
                </div>
            </div>

            <!-- Kategori Aksi -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Kategori Aktivitas</label>
                <select name="action_category" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-medium focus:outline-none focus:border-japan-600">
                    <option value="">Semua Kategori</option>
                    <option value="auth" {{ request('action_category') === 'auth' ? 'selected' : '' }}>Otentikasi & Login (auth)</option>
                    <option value="user" {{ request('action_category') === 'user' ? 'selected' : '' }}>Manajemen Pengguna (user)</option>
                    <option value="profile" {{ request('action_category') === 'profile' ? 'selected' : '' }}>Profil & Sandi (profile)</option>
                    <option value="cash" {{ request('action_category') === 'cash' ? 'selected' : '' }}>Transaksi Kas (cash)</option>
                </select>
            </div>

            <!-- Filter Pengguna -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Pengguna Terdaftar</label>
                <select name="user_id" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-medium focus:outline-none focus:border-japan-600">
                    <option value="">Semua Pengguna</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                            {{ $u->name }} ({{ ucfirst($u->role) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal Dari -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tanggal Mulai</label>
                <input 
                    type="date" 
                    name="date_from" 
                    value="{{ request('date_from') }}" 
                    class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-medium focus:outline-none focus:border-japan-600"
                >
            </div>

            <!-- Action Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-1.5 px-3 rounded-xl bg-japan-600 hover:bg-japan-700 text-white font-bold text-xs shadow-xs transition flex items-center justify-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>Terapkan</span>
                </button>
                @if(request()->anyFilled(['q', 'action_category', 'user_id', 'date_from', 'date_to']))
                    <a href="{{ route('admin.audit-logs.index') }}" class="py-1.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs transition" title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- 4. Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 text-[10px] uppercase font-bold border-b border-slate-200">
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Pengguna</th>
                        <th class="py-3 px-4">Kategori / Aksi</th>
                        <th class="py-3 px-4">Deskripsi Aktivitas</th>
                        <th class="py-3 px-4">Alamat IP & Perangkat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Waktu -->
                            <td class="py-3 px-4 whitespace-nowrap">
                                <p class="font-bold text-slate-900 leading-tight">
                                    {{ $log->created_at->format('d M Y, H:i:s') }}
                                </p>
                                <span class="text-[10px] text-slate-400">
                                    {{ $log->created_at->diffForHumans() }}
                                </span>
                            </td>

                            <!-- Pengguna -->
                            <td class="py-3 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-[10px]">
                                        {{ strtoupper(substr($log->user_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 leading-tight">{{ $log->user_name }}</p>
                                        <span class="text-[10px] font-semibold text-slate-400 capitalize">{{ $log->user_role }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $log->action_badge_class }}">
                                    {{ $log->action_label }}
                                </span>
                            </td>

                            <!-- Deskripsi -->
                            <td class="py-3 px-4 max-w-md">
                                <p class="text-slate-800 font-medium leading-relaxed">{{ $log->description }}</p>
                                @if(!empty($log->properties))
                                    <details class="mt-1">
                                        <summary class="text-[10px] font-bold text-blue-600 cursor-pointer hover:underline">Detail Metadata &rarr;</summary>
                                        <pre class="mt-1 p-2 rounded-lg bg-slate-50 border border-slate-200 text-[10px] font-mono text-slate-600 overflow-x-auto">{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                                    </details>
                                @endif
                            </td>

                            <!-- IP & Perangkat -->
                            <td class="py-3 px-4 whitespace-nowrap">
                                <div class="space-y-0.5">
                                    <span class="font-mono text-[11px] font-semibold text-slate-700 bg-slate-100 px-1.5 py-0.5 rounded">
                                        {{ $log->ip_address }}
                                    </span>
                                    <p class="text-[10px] text-slate-400 max-w-[150px] truncate" title="{{ $log->user_agent }}">
                                        {{ $log->user_agent }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 text-xs">
                                <div class="max-w-xs mx-auto space-y-2">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                        <i data-lucide="inbox" class="w-6 h-6"></i>
                                    </div>
                                    <p class="font-bold text-slate-700">Belum Ada Aktivitas</p>
                                    <p class="text-[11px]">Seluruh riwayat aktivitas sistem akan terekam secara otomatis di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
