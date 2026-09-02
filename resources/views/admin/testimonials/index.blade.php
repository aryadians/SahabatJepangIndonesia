@extends('admin.layouts.admin')

@section('title', 'Kelola Testimoni Alumni')
@section('page_title', 'Kelola Testimoni & Kisah Sukses Alumni')

@section('content')
<div class="space-y-8">
    
    <!-- Add Form -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 max-w-4xl">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-5 h-5 text-japan-600"></i>
            <h3 class="font-extrabold text-slate-900 text-base">Tambah Testimoni Alumni Baru</h3>
        </div>

        <form action="{{ route('admin.testimonials.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @csrf
            
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Alumni *</label>
                <input type="text" name="name" required placeholder="Ahmad Rizky Pratama" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kota Asal</label>
                <input type="text" name="origin" placeholder="Surabaya, Jawa Timur" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Prefektur / Kota di Jepang *</label>
                <input type="text" name="prefecture" required placeholder="Tokyo / 東京都" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Program *</label>
                <input type="text" name="program" required placeholder="Tokutei Ginou - Food Industry" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Perusahaan Penerima (Kaisha) *</label>
                <input type="text" name="company" required placeholder="Tokyo Foods Co., Ltd." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Penghasilan / Gaji *</label>
                <input type="text" name="salary" required placeholder="¥ 220.000 / bln (± Rp 23,5 Juta)" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold text-japan-700">
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">URL Foto Avatar / Profil</label>
                <input type="text" name="avatar" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kutipan / Cerita Pengalaman (Quote) *</label>
                <textarea name="quote" rows="3" required placeholder="Ceritakan bagaimana pengalaman belajar di LPK SJI dan kerja di Jepang..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600"></textarea>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Tag / Angkatan</label>
                <input type="text" name="tag" value="Alumni 2026" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="flex items-end justify-end">
                <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Tambah Testimoni</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Testimonials List -->
    <div class="space-y-4">
        <h3 class="font-extrabold text-slate-900 text-base">Daftar Testimoni ({{ $testimonials->count() }})</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @forelse($testimonials as $testi)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ $testi->avatar }}" alt="{{ $testi->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-red-200">
                                <div>
                                    <h4 class="font-extrabold text-slate-900 text-sm">{{ $testi->name }}</h4>
                                    <p class="text-[11px] text-slate-400">{{ $testi->origin }} • {{ $testi->tag }}</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-red-50 text-japan-700 font-bold text-xs">
                                {{ $testi->prefecture }}
                            </span>
                        </div>

                        <p class="text-xs text-slate-600 italic bg-slate-50 p-3 rounded-2xl border border-slate-100">
                            "{{ $testi->quote }}"
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-800">{{ $testi->company }}</span>
                            <span class="text-[11px] text-japan-600 font-semibold block">{{ $testi->salary }}</span>
                        </div>

                        <form action="{{ route('admin.testimonials.destroy', $testi->id) }}" method="POST" onsubmit="return confirm('Hapus testimoni ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs">Belum ada testimoni.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
