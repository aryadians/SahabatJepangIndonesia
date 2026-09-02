@extends('admin.layouts.admin')

@section('title', 'Kelola Fasilitas & Galeri')
@section('page_title', 'Kelola Foto Fasilitas & Asrama')

@section('content')
<div class="space-y-8">
    
    <!-- Add Facility Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 max-w-4xl">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-5 h-5 text-japan-600"></i>
            <h3 class="font-extrabold text-slate-900 text-base">Tambah Fasilitas / Foto Baru</h3>
        </div>

        <form action="{{ route('admin.facilities.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @csrf
            
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Fasilitas / Ruangan *</label>
                <input type="text" name="title" required placeholder="Contoh: Asrama Putra Kamar 4 Orang" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kategori *</label>
                <input type="text" name="category" required placeholder="Akomodasi / Pembelajaran / Olahraga" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">URL Gambar / Foto *</label>
                <input type="text" name="image" required placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
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

    <!-- Facility Items List -->
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
                            <form action="{{ route('admin.facilities.destroy', $fac->id) }}" method="POST" onsubmit="return confirm('Hapus fasilitas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs">Belum ada foto fasilitas.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
