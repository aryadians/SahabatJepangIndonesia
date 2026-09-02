@extends('admin.layouts.admin')

@section('title', 'Kelola Mitra Kaisha')
@section('page_title', 'Kelola Mitra Perusahaan Jepang (Kaisha & Kumiai)')

@section('content')
<div class="space-y-8">
    
    <!-- Add Form -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 max-w-4xl">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="plus" class="w-4 h-4"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Tambah Mitra Kaisha Baru</h3>
                <p class="text-xs text-slate-400">Perusahaan Jepang penerima dan organisasi pengawas (Kumiai)</p>
            </div>
        </div>

        <form action="{{ route('admin.partners.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
            @csrf
            
            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Perusahaan / Organisasi *</label>
                <input type="text" name="name" required placeholder="Tokyo Foods Industry Co., Ltd." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Prefektur / Wilayah</label>
                <input type="text" name="prefecture" placeholder="東京都 (Tokyo)" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-japanese">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kategori</label>
                <select name="category" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                    <option value="Kaisha">Kaisha (Perusahaan)</option>
                    <option value="Kumiai">Kumiai (Organisasi Pengawas)</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Urutan (Order)</label>
                <input type="number" name="order" value="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div>
                <button type="submit" class="w-full btn-red-primary py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center justify-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Tambah Mitra</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Partners List with Edit & Delete -->
    <div class="space-y-4">
        <h3 class="font-extrabold text-slate-900 text-base">Daftar Mitra yang Ditampilkan di Banner Marquee ({{ $partners->count() }})</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($partners as $partner)
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-japan-600 flex-shrink-0"></div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm">{{ $partner->name }}</h4>
                            <p class="text-[11px] text-slate-400 font-japanese">{{ $partner->prefecture ?? 'Jepang' }} • {{ $partner->category }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-1 flex-shrink-0">
                        <button 
                            type="button" 
                            data-partner='@json($partner)'
                            onclick="openEditPartner(JSON.parse(this.getAttribute('data-partner')))" 
                            class="px-2 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs flex items-center gap-1 transition"
                        >
                            <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                            <span>Edit</span>
                        </button>

                        <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Hapus mitra {{ $partner->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 rounded-lg text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 transition" title="Hapus">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs">Belum ada data mitra.</div>
            @endforelse
        </div>
    </div>

</div>

<!-- Modal Edit Mitra -->
<div id="editPartnerModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('editPartnerModal')"></div>
    <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10">
        
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold">
                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-black text-white">Edit Data Mitra Kaisha</h3>
            </div>
            <button onclick="closeModal('editPartnerModal')" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm">
                &times;
            </button>
        </div>

        <form id="editPartnerForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Perusahaan / Organisasi *</label>
                <input type="text" name="name" id="editPartnerName" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Prefektur / Wilayah</label>
                <input type="text" name="prefecture" id="editPartnerPrefecture" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-japanese focus:outline-none focus:border-japan-600">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Kategori</label>
                    <select name="category" id="editPartnerCategory" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                        <option value="Kaisha">Kaisha (Perusahaan)</option>
                        <option value="Kumiai">Kumiai (Pengawas)</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Urutan (Order)</label>
                    <input type="number" name="order" id="editPartnerOrder" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('editPartnerModal')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">
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
    function openEditPartner(partner) {
        document.getElementById('editPartnerName').value = partner.name;
        document.getElementById('editPartnerPrefecture').value = partner.prefecture || '';
        document.getElementById('editPartnerCategory').value = partner.category || 'Kaisha';
        document.getElementById('editPartnerOrder').value = partner.order || 0;

        const form = document.getElementById('editPartnerForm');
        form.action = `/admin/partners/${partner.id}`;

        openModal('editPartnerModal');
    }
</script>
@endsection
