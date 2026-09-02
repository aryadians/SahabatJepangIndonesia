@extends('admin.layouts.admin')

@section('title', 'Manajemen Pengguna & RBAC')
@section('page_title', 'Manajemen Pengguna & Hak Akses (RBAC)')

@section('content')
<div class="space-y-8">
    
    <!-- KPI Summary Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Akun Terdaftar</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ $rolesCount['total'] }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="shield" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Administrator (Full Access)</p>
                <h3 class="text-2xl font-black text-japan-600 mt-0.5">{{ $rolesCount['admin'] }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <i data-lucide="user-check" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Pengajar / Sensei</p>
                <h3 class="text-2xl font-black text-blue-600 mt-0.5">{{ $rolesCount['teacher'] }}</h3>
            </div>
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
                <p class="text-xs text-slate-400">Buat akun untuk Administrator atau Tenaga Pengajar / Sensei</p>
            </div>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @csrf
            
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Lengkap *</label>
                <input type="text" name="name" required placeholder="Contoh: Budi Santoso, S.Pd" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Email Login *</label>
                <input type="email" name="email" required placeholder="budi@sahabatjepangindonesia.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Peran / Role Hak Akses *</label>
                <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold text-slate-800">
                    <option value="admin">Administrator (Akses Penuh Seluruh Sistem & Keuangan)</option>
                    <option value="teacher" selected>Pengajar / Sensei (Akses Akademik, Siswa & Jadwal)</option>
                    <option value="staff">Staf LPK (Akses Operasional)</option>
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
                <label class="flex items-center gap-2 cursor-pointer">
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

    <!-- Users Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Daftar Pengguna Sistem ({{ $users->total() }})</h3>
                <p class="text-xs text-slate-400">Pengaturan hak akses role administrator dan tenaga pengajar</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3.5 px-4">Nama & Email</th>
                        <th class="py-3.5 px-4">Hak Akses (Role)</th>
                        <th class="py-3.5 px-4">Kontak</th>
                        <th class="py-3.5 px-4">Status</th>
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
                                        <h4 class="font-extrabold text-slate-900">{{ $u->name }}</h4>
                                        <p class="text-[11px] text-slate-400">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($u->role === 'admin')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-black bg-red-100 text-japan-800 border border-red-200">
                                        Administrator
                                    </span>
                                @elseif($u->role === 'teacher')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-black bg-blue-100 text-blue-800 border border-blue-200">
                                        Pengajar / Sensei
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Staf LPK
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 font-medium">
                                {{ $u->phone ?: '-' }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if($u->is_active)
                                    <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-xs">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-bold text-xs">Non-aktif</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-500">
                                {{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <button 
                                        type="button" 
                                        data-user='@json($u)'
                                        onclick="openEditUser(JSON.parse(this.getAttribute('data-user')))" 
                                        class="px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs flex items-center gap-1 transition"
                                    >
                                        <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                        <span>Edit</span>
                                    </button>

                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengguna {{ $u->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 rounded-lg text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 transition" title="Hapus">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">Belum ada data pengguna.</td>
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
<div id="editUserModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
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
                        <option value="admin">Administrator</option>
                        <option value="teacher">Pengajar / Sensei</option>
                        <option value="staff">Staf LPK</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">No WhatsApp / HP</label>
                    <input type="text" name="phone" id="editUserPhone" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kata Sandi Baru (Kosongkan jika tidak diganti)</label>
                <input type="password" name="password" minlength="6" placeholder="Biarkan kosong jika tidak diubah" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
            </div>

            <div class="flex items-center gap-2 pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
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
        document.getElementById('editUserRole').value = u.role;
        document.getElementById('editUserPhone').value = u.phone || '';
        document.getElementById('editUserActive').checked = !!u.is_active;

        const form = document.getElementById('editUserForm');
        form.action = `/admin/users/${u.id}`;

        openModal('editUserModal');
    }
</script>
@endsection
