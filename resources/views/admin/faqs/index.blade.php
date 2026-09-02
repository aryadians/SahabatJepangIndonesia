@extends('admin.layouts.admin')

@section('title', 'Kelola FAQ')
@section('page_title', 'Kelola Pertanyaan & Jawaban (FAQ)')

@section('content')
<div class="space-y-8">
    
    <!-- Add Form -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 max-w-4xl">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-5 h-5 text-japan-600"></i>
            <h3 class="font-extrabold text-slate-900 text-base">Tambah Pertanyaan FAQ Baru</h3>
        </div>

        <form action="{{ route('admin.faqs.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Pertanyaan *</label>
                <input type="text" name="question" required placeholder="Contoh: Apakah ada jaminan penempatan kerja?" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Jawaban Lengkap *</label>
                <textarea name="answer" rows="3" required placeholder="Tuliskan jawaban yang jelas dan meyakinkan calon siswa..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600"></textarea>
            </div>

            <div class="flex items-center justify-between pt-2">
                <div class="space-y-1 w-36">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Urutan (Order)</label>
                    <input type="number" name="order" value="1" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>

                <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Tambah FAQ</span>
                </button>
            </div>
        </form>
    </div>

    <!-- FAQ Items List -->
    <div class="space-y-4">
        <h3 class="font-extrabold text-slate-900 text-base">Daftar Pertanyaan FAQ ({{ $faqs->count() }})</h3>
        
        <div class="space-y-3 max-w-4xl">
            @forelse($faqs as $faq)
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-start justify-between gap-4">
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-red-100 text-japan-700 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                                Q
                            </span>
                            <h4 class="font-extrabold text-slate-900 text-sm">{{ $faq->question }}</h4>
                        </div>
                        <p class="text-xs text-slate-600 pl-8 leading-relaxed">{{ $faq->answer }}</p>
                    </div>

                    <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')" class="flex-shrink-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            @empty
                <div class="py-12 text-center text-slate-400 text-xs">Belum ada data FAQ.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
