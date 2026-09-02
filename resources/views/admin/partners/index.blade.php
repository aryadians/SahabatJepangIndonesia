@extends('admin.layouts.admin')

@section('title', 'Kelola Mitra Kaisha')
@section('page_title', 'Kelola Mitra Perusahaan Jepang (Kaisha & Kumiai)')

@section('content')
<div class="space-y-8">
    
    <!-- Add Form -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 max-w-4xl">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-5 h-5 text-japan-600"></i>
            <h3 class="font-extrabold text-slate-900 text-base">Tambah Mitra Kaisha Baru</h3>
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

    <!-- Partners List -->
    <div class="space-y-4">
        <h3 class="font-extrabold text-slate-900 text-base">Daftar Mitra yang Ditampilkan di Banner Marquee ({{ $partners->count() }})</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($partners as $partner)
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-japan-600"></div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm">{{ $partner->name }}</h4>
                            <p class="text-[11px] text-slate-400 font-japanese">{{ $partner->prefecture ?? 'Jepang' }} • {{ $partner->category }}</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Hapus mitra ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs">Belum ada data mitra.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
