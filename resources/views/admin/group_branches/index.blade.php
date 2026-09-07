@extends('admin.layouts.admin')

@section('title', 'Jaringan Cabang SJI Group')
@section('page_title', 'Manajemen Jaringan Cabang & Entitas SJI Group')

@section('content')
<div class="space-y-6">

    <!-- Top Stats Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="building-2" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kampus Indonesia</p>
                <p class="text-2xl font-black text-slate-900">{{ $totalId }} <span class="text-xs font-normal text-slate-500">Cabang</span></p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <i data-lucide="globe-2" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kantor di Jepang</p>
                <p class="text-2xl font-black text-slate-900">{{ $totalJp }} <span class="text-xs font-normal text-slate-500">Kantor/Balai</span></p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Aktif</p>
                <p class="text-2xl font-black text-emerald-600">{{ $totalActive }} <span class="text-xs font-normal text-slate-500">Entitas</span></p>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        
        <!-- Header Actions & Filters -->
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-black text-slate-900 text-lg">Direktori Lembaga di Bawah SJI Group</h3>
                <p class="text-xs text-slate-500">Kelola entitas PT SJI Group, LPK cabang, kantor perwakilan Tokyo, dan balai karantina Chiba</p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('company.profile') }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5">
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    <span>Lihat Halaman Publik</span>
                </a>

                <button 
                    type="button" 
                    onclick="openAddBranchModal()" 
                    class="px-4 py-2 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm shadow-red-600/20"
                >
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Tambah Cabang Baru</span>
                </button>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="p-4 bg-slate-50 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <form action="{{ route('admin.group-branches.index') }}" method="GET" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                <input type="hidden" name="country" value="{{ $country }}">
                
                <div class="relative flex-1 sm:w-72">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search }}" 
                        placeholder="Cari nama, kategori, kota..." 
                        class="w-full pl-9 pr-4 py-1.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 bg-white"
                    >
                </div>

                <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('admin.group-branches.index', ['country' => $country]) }}" class="px-2.5 py-1.5 rounded-xl bg-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-300 transition">
                        Reset
                    </a>
                @endif
            </form>

            <div class="flex items-center gap-1.5 self-start sm:self-center">
                <a 
                    href="{{ route('admin.group-branches.index', ['country' => 'all', 'search' => $search]) }}" 
                    class="px-3 py-1 rounded-xl text-xs font-bold {{ $country === 'all' ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}"
                >
                    Semua
                </a>
                <a 
                    href="{{ route('admin.group-branches.index', ['country' => 'ID', 'search' => $search]) }}" 
                    class="px-3 py-1 rounded-xl text-xs font-bold {{ $country === 'ID' ? 'bg-japan-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}"
                >
                    🇮🇩 Indonesia ({{ $totalId }})
                </a>
                <a 
                    href="{{ route('admin.group-branches.index', ['country' => 'JP', 'search' => $search]) }}" 
                    class="px-3 py-1 rounded-xl text-xs font-bold {{ $country === 'JP' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}"
                >
                    🇯🇵 Jepang ({{ $totalJp }})
                </a>
            </div>
        </div>

        <!-- Table Listing -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-100/70 text-slate-700 font-extrabold uppercase tracking-wider text-[11px] border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 w-12 text-center">Urutan</th>
                        <th class="py-3 px-4">Nama Entitas & Kategori</th>
                        <th class="py-3 px-4">Lokasi / Alamat</th>
                        <th class="py-3 px-4">Kontak Telepon</th>
                        <th class="py-3 px-4 text-center w-24">Negara</th>
                        <th class="py-3 px-4 text-center w-24">Status</th>
                        <th class="py-3 px-4 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($branches as $branch)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-4 text-center font-mono font-bold text-slate-400">
                                {{ $branch->sort_order }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="space-y-0.5">
                                    <p class="font-extrabold text-slate-900 text-sm flex items-center gap-1.5">
                                        <span>{{ $branch->name }}</span>
                                    </p>
                                    @if($branch->category_jp)
                                        <p class="text-[11px] font-bold text-japan-600 font-japanese">
                                            {{ $branch->category_jp }}
                                        </p>
                                    @endif
                                    @if($branch->category_id)
                                        <p class="text-[11px] text-slate-400">
                                            {{ $branch->category_id }}
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 max-w-xs">
                                <p class="text-xs text-slate-700 font-medium line-clamp-2 leading-relaxed">
                                    {{ $branch->address }}
                                </p>
                                <p class="text-[10px] text-slate-400 mt-0.5">
                                    {{ $branch->city ? $branch->city . ', ' : '' }}{{ $branch->province }} {{ $branch->postal_code }}
                                </p>
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-800">
                                <p class="text-xs flex items-center gap-1.5 text-emerald-700">
                                    <i data-lucide="phone" class="w-3.5 h-3.5 text-emerald-600"></i>
                                    <span>{{ $branch->phone ?? '-' }}</span>
                                </p>
                                @if($branch->secondary_phone)
                                    <p class="text-[11px] text-slate-400 mt-0.5">
                                        Alt: {{ $branch->secondary_phone }}
                                    </p>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ $branch->country === 'JP' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-japan-800' }}">
                                    {{ $branch->country === 'JP' ? '🇯🇵 JP' : '🇮🇩 ID' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <form action="{{ route('admin.group-branches.toggle', $branch->id) }}" method="POST">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="px-2.5 py-0.5 rounded-full text-[10px] font-bold transition {{ $branch->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-200 text-slate-600 hover:bg-slate-300' }}"
                                        title="Klik untuk mengubah status aktif"
                                    >
                                        {{ $branch->is_active ? 'Aktif' : 'Non-Aktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button 
                                        type="button" 
                                        onclick="openEditBranchModal({{ json_encode($branch) }})"
                                        class="p-1.5 rounded-lg bg-slate-100 hover:bg-japan-50 hover:text-japan-600 text-slate-600 transition"
                                        title="Edit Cabang"
                                    >
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>

                                    <form action="{{ route('admin.group-branches.destroy', $branch->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus cabang {{ $branch->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="p-1.5 rounded-lg bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-600 transition"
                                            title="Hapus Cabang"
                                        >
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                Belum ada data cabang atau hasil pencarian tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($branches->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $branches->links() }}
            </div>
        @endif

    </div>

</div>

<!-- Modal Form Tambah / Edit Cabang -->
<div id="branchModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 my-8 space-y-6">
        
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <h3 id="modalTitle" class="font-black text-slate-900 text-lg">Tambah Cabang Baru SJI Group</h3>
                <p class="text-xs text-slate-500">Lengkapi data profil lembaga, alamat, dan nomor kontak resmi</p>
            </div>
            <button type="button" onclick="closeBranchModal()" class="p-2 rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="branchForm" action="{{ route('admin.group-branches.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div id="methodField"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1 sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nama Entitas / Lembaga <span class="text-red-500">*</span></label>
                    <input type="text" id="branchName" name="name" required placeholder="Contoh: LPK SAHABAT JEPANG INDONESIA CAB. CIKARANG" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600 font-bold">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nama Jepang (Optional)</label>
                    <input type="text" id="branchJapaneseName" name="japanese_name" placeholder="Contoh: LPK サハバット・ジャパン・インドネシア" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600 font-japanese">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Negara Operasional <span class="text-red-500">*</span></label>
                    <select id="branchCountry" name="country" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600 font-bold bg-white">
                        <option value="ID">🇮🇩 Indonesia (LPK / Sending Org)</option>
                        <option value="JP">🇯🇵 Jepang (Kantor Perwakilan / Balai Pelatihan)</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Kategori Jepang</label>
                    <input type="text" id="branchCategoryJp" name="category_jp" placeholder="Contoh: 技能実習送り出し機関+日本語学校" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600 font-japanese">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Kategori Indonesia</label>
                    <input type="text" id="branchCategoryId" name="category_id" placeholder="Contoh: Sekolah Bahasa Jepang Cabang Cikarang" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nomor Telepon / WhatsApp</label>
                    <input type="text" id="branchPhone" name="phone" placeholder="Contoh: +62 813-3327-0022" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600 font-semibold text-emerald-700">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Telepon Alternatif (Optional)</label>
                    <input type="text" id="branchSecondaryPhone" name="secondary_phone" placeholder="Contoh: 047-401-0710" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Alamat Lengkap</label>
                    <textarea id="branchAddress" name="address" rows="2" placeholder="Jl. Gracia Land Ruko A-01, Pepe, Kec. Sedati, Kab. Sidoarjo, Jawa Timur 61253" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600"></textarea>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Kota</label>
                    <input type="text" id="branchCity" name="city" placeholder="Contoh: Sidoarjo" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Provinsi / Prefektur</label>
                    <input type="text" id="branchProvince" name="province" placeholder="Contoh: Jawa Timur atau Tokyo" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Kode Pos</label>
                    <input type="text" id="branchPostalCode" name="postal_code" placeholder="Contoh: 61253 atau 130-0022" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Urutan Tampil (Sort Order)</label>
                    <input type="number" id="branchSortOrder" name="sort_order" placeholder="1, 2, 3..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Keterangan / Profil Singkat</label>
                    <textarea id="branchDescription" name="description" rows="2" placeholder="Deskripsi ringkas program atau fasilitas khusus cabang ini..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600"></textarea>
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer pt-2">
                        <input type="checkbox" id="branchIsActive" name="is_active" value="1" checked class="w-4 h-4 rounded text-japan-600 focus:ring-japan-500 border-slate-300">
                        <span class="text-xs font-bold text-slate-700">Tampilkan Cabang ini di Halaman Publik (Aktif)</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" onclick="closeBranchModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-bold transition shadow-sm">
                    Simpan Cabang
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    function openAddBranchModal() {
        document.getElementById('modalTitle').textContent = 'Tambah Cabang Baru SJI Group';
        document.getElementById('branchForm').action = "{{ route('admin.group-branches.store') }}";
        document.getElementById('methodField').innerHTML = '';
        
        document.getElementById('branchName').value = '';
        document.getElementById('branchJapaneseName').value = '';
        document.getElementById('branchCategoryJp').value = '';
        document.getElementById('branchCategoryId').value = '';
        document.getElementById('branchCountry').value = 'ID';
        document.getElementById('branchPhone').value = '';
        document.getElementById('branchSecondaryPhone').value = '';
        document.getElementById('branchAddress').value = '';
        document.getElementById('branchCity').value = '';
        document.getElementById('branchProvince').value = '';
        document.getElementById('branchPostalCode').value = '';
        document.getElementById('branchSortOrder').value = '';
        document.getElementById('branchDescription').value = '';
        document.getElementById('branchIsActive').checked = true;

        const modal = document.getElementById('branchModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function openEditBranchModal(branch) {
        document.getElementById('modalTitle').textContent = 'Edit Data Cabang: ' + branch.name;
        document.getElementById('branchForm').action = "/admin/group-branches/" + branch.id;
        document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('branchName').value = branch.name || '';
        document.getElementById('branchJapaneseName').value = branch.japanese_name || '';
        document.getElementById('branchCategoryJp').value = branch.category_jp || '';
        document.getElementById('branchCategoryId').value = branch.category_id || '';
        document.getElementById('branchCountry').value = branch.country || 'ID';
        document.getElementById('branchPhone').value = branch.phone || '';
        document.getElementById('branchSecondaryPhone').value = branch.secondary_phone || '';
        document.getElementById('branchAddress').value = branch.address || '';
        document.getElementById('branchCity').value = branch.city || '';
        document.getElementById('branchProvince').value = branch.province || '';
        document.getElementById('branchPostalCode').value = branch.postal_code || '';
        document.getElementById('branchSortOrder').value = branch.sort_order || '';
        document.getElementById('branchDescription').value = branch.description || '';
        document.getElementById('branchIsActive').checked = !!branch.is_active;

        const modal = document.getElementById('branchModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeBranchModal() {
        const modal = document.getElementById('branchModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection
