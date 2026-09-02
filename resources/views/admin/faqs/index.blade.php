@extends('admin.layouts.admin')

@section('title', 'Kelola FAQ')
@section('page_title', 'Kelola Pertanyaan & Jawaban (FAQ)')

@section('content')
<div class="space-y-8">
    
    <!-- Add Form -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 max-w-4xl">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="plus" class="w-4 h-4"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Tambah Pertanyaan FAQ Baru</h3>
                <p class="text-xs text-slate-400">Pertanyaan umum yang sering diajukan calon siswa</p>
            </div>
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

    <!-- FAQ Items List with Edit & Delete -->
    <div class="space-y-4">
        <h3 class="font-extrabold text-slate-900 text-base">Daftar Pertanyaan FAQ ({{ $faqs->count() }})</h3>
        
        <div class="space-y-3 max-w-4xl">
            @forelse($faqs as $faq)
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-start justify-between gap-4">
                    <div class="space-y-1.5 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-red-100 text-japan-700 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                                Q
                            </span>
                            <h4 class="font-extrabold text-slate-900 text-sm">{{ $faq->question }}</h4>
                        </div>
                        <p class="text-xs text-slate-600 pl-8 leading-relaxed">{{ $faq->answer }}</p>
                    </div>

                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        <button 
                            type="button" 
                            data-faq='@json($faq)'
                            onclick="openEditFaq(JSON.parse(this.getAttribute('data-faq')))" 
                            class="px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs flex items-center gap-1 transition"
                        >
                            <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                            <span>Edit</span>
                        </button>

                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 rounded-lg text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 transition" title="Hapus">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-slate-400 text-xs">Belum ada data FAQ.</div>
            @endforelse
        </div>
    </div>

</div>

<!-- Modal Edit FAQ -->
<div id="editFaqModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('editFaqModal')"></div>
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10">
        
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold">
                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-black text-white">Edit Tanya Jawab (FAQ)</h3>
            </div>
            <button onclick="closeModal('editFaqModal')" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm">
                &times;
            </button>
        </div>

        <form id="editFaqForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Pertanyaan *</label>
                <input type="text" name="question" id="editFaqQuestion" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Jawaban Lengkap *</label>
                <textarea name="answer" id="editFaqAnswer" rows="4" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"></textarea>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Urutan (Order)</label>
                <input type="number" name="order" id="editFaqOrder" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('editFaqModal')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">
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
    function openEditFaq(faq) {
        document.getElementById('editFaqQuestion').value = faq.question;
        document.getElementById('editFaqAnswer').value = faq.answer;
        document.getElementById('editFaqOrder').value = faq.order || 0;

        const form = document.getElementById('editFaqForm');
        form.action = `/admin/faqs/${faq.id}`;

        openModal('editFaqModal');
    }
</script>
@endsection
