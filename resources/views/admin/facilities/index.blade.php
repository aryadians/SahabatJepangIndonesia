@extends('admin.layouts.admin')

@section('title', 'Kelola Fasilitas & Galeri')
@section('page_title', 'Kelola Foto Fasilitas & Asrama')

@section('content')
<div class="space-y-8">
    
    <!-- Add Facility Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 max-w-4xl">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="plus" class="w-4 h-4"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Tambah Fasilitas / Foto Baru</h3>
                <p class="text-xs text-slate-400">Foto sarana prasarana pelatihan dan asrama LPK</p>
            </div>
        </div>

        <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @csrf
            
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Fasilitas / Ruangan *</label>
                <input type="text" name="title" required placeholder="Contoh: Asrama Putra Kamar 4 Orang" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kategori *</label>
                <input type="text" name="category" required placeholder="Akomodasi / Pembelajaran / Olahraga" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Upload File Foto (Base64 Otomatis)</label>
                <input type="file" name="image_file" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:outline-none focus:border-japan-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-japan-600 file:text-white hover:file:bg-japan-700 cursor-pointer">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Atau URL Gambar</label>
                <input type="text" name="image" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Deskripsi Fasilitas</label>
                <textarea name="description" rows="2" placeholder="Fasilitas dilengkapi AC, kasur bertingkat, loker pribadi..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600"></textarea>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Urutan Tampil (Order)</label>
                <input type="number" name="order" value="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="flex items-end justify-end">
                <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Tambah Fasilitas</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Facility Items List with Edit and Delete -->
    <div class="space-y-4">
        <h3 class="font-extrabold text-slate-900 text-base">Daftar Galeri Fasilitas ({{ $facilities->count() }})</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($facilities as $fac)
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between group">
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img src="{{ $fac->image }}" alt="{{ $fac->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-white font-bold text-[11px]">
                            {{ $fac->category }}
                        </span>
                    </div>

                    <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">{{ $fac->title }}</h4>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $fac->description }}</p>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-400">Urutan: #{{ $fac->order }}</span>
                            
                            <div class="flex items-center gap-1.5">
                                <button 
                                    type="button" 
                                    data-facility='@json($fac)'
                                    onclick="openEditFacility(JSON.parse(this.getAttribute('data-facility')))" 
                                    class="px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs flex items-center gap-1 transition"
                                >
                                    <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                    <span>Edit</span>
                                </button>

                                <form action="{{ route('admin.facilities.destroy', $fac->id) }}" method="POST" onsubmit="return confirm('Hapus fasilitas {{ $fac->title }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 rounded-lg text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 transition" title="Hapus">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs">Belum ada foto fasilitas.</div>
            @endforelse
        </div>
    </div>

</div>

<!-- Modal Edit Fasilitas -->
<div id="editFacilityModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('editFacilityModal')"></div>
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10">
        
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold">
                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-black text-white">Edit Data Fasilitas</h3>
            </div>
            <button onclick="closeModal('editFacilityModal')" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm">
                &times;
            </button>
        </div>

        <form id="editFacilityForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Fasilitas *</label>
                <input type="text" name="title" id="editFacTitle" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold focus:outline-none focus:border-japan-600">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Kategori *</label>
                    <input type="text" name="category" id="editFacCategory" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Urutan</label>
                    <input type="number" name="order" id="editFacOrder" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Ganti File Foto (Base64)</label>
                <input type="file" name="image_file" accept="image/*" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:outline-none file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-japan-600 file:text-white cursor-pointer">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Atau URL Gambar</label>
                <input type="text" name="image" id="editFacImage" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Deskripsi Fasilitas</label>
                <textarea name="description" id="editFacDescription" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('editFacilityModal')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">
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
    function openEditFacility(fac) {
        document.getElementById('editFacTitle').value = fac.title;
        document.getElementById('editFacCategory').value = fac.category;
        document.getElementById('editFacOrder').value = fac.order || 0;
        document.getElementById('editFacImage').value = fac.image || '';
        document.getElementById('editFacDescription').value = fac.description || '';

        const form = document.getElementById('editFacilityForm');
        form.action = `/admin/facilities/${fac.id}`;

        openModal('editFacilityModal');
    }
</script>
@endsection
