@extends('admin.layouts.admin')

@section('title', $isEdit ? 'Edit Butir Soal CBT' : 'Tambah Soal CBT Baru')
@section('page_title', $isEdit ? 'Edit Butir Soal CBT #' . $question->id : 'Tambah Butir Soal Bank CBT')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Navigation Back -->
    <div class="flex items-center justify-between">
        <a 
            href="{{ route('admin.exam-questions.index') }}" 
            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition shadow-sm"
        >
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Bank Soal</span>
        </a>

        @if($isEdit)
            <div class="text-xs text-slate-500">
                ID Soal: <span class="font-mono font-bold text-slate-800">#{{ $question->id }}</span>
            </div>
        @endif
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-red-100 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="{{ $isEdit ? 'edit-3' : 'plus-circle' }}" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-black text-slate-900 text-base">
                    {{ $isEdit ? 'Formulir Pembaruan Butir Soal' : 'Formulir Pembuatan Soal CBT Baru' }}
                </h3>
                <p class="text-xs text-slate-500">
                    Lengkapi parameter ujian, teks soal, opsi pilihan ganda, dan pembahasan
                </p>
            </div>
        </div>

        <form 
            action="{{ $isEdit ? route('admin.exam-questions.update', $question->id) : route('admin.exam-questions.store') }}" 
            method="POST" 
            class="p-6 sm:p-8 space-y-6 text-xs"
        >
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- 1. Metadata Level & Bagian -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5 text-[11px]">
                        Level Ujian <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="level" 
                        required 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:border-japan-600 focus:outline-none"
                    >
                        <option value="N5" {{ old('level', $question->level) === 'N5' ? 'selected' : '' }}>JLPT N5 (Pemula)</option>
                        <option value="N4" {{ old('level', $question->level) === 'N4' ? 'selected' : '' }}>JLPT N4 (Menengah Bawah)</option>
                        <option value="N3" {{ old('level', $question->level) === 'N3' ? 'selected' : '' }}>JLPT N3 (Menengah Mandiri)</option>
                        <option value="JFT-Basic" {{ old('level', $question->level) === 'JFT-Basic' ? 'selected' : '' }}>JFT-Basic A2 (Kerja Tokutei)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5 text-[11px]">
                        Bagian / Kategori Soal <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="section" 
                        required 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:border-japan-600 focus:outline-none"
                    >
                        <option value="Kotoba" {{ old('section', $question->section) === 'Kotoba' ? 'selected' : '' }}>Kotoba (Kosakata & Moji)</option>
                        <option value="Bunpou" {{ old('section', $question->section) === 'Bunpou' ? 'selected' : '' }}>Bunpou (Tata Bahasa / Pola Kalimat)</option>
                        <option value="Dokkai" {{ old('section', $question->section) === 'Dokkai' ? 'selected' : '' }}>Dokkai (Pemahaman Bacaan)</option>
                        <option value="Kanji" {{ old('section', $question->section) === 'Kanji' ? 'selected' : '' }}>Kanji (Cara Baca & Arti)</option>
                        <option value="Choukai" {{ old('section', $question->section) === 'Choukai' ? 'selected' : '' }}>Choukai (Mendengarkan / Audio)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5 text-[11px]">
                        Bobot Poin Nilai <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="points" 
                        required 
                        min="1" 
                        max="100" 
                        value="{{ old('points', $question->points ?? 10) }}" 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:border-japan-600 focus:outline-none"
                    >
                </div>
            </div>

            <!-- 2. Soal Aksara Jepang & Pertanyaan Utama -->
            <div class="space-y-4 pt-2 border-t border-slate-100">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5 text-[11px] flex items-center justify-between">
                        <span>Teks Kalimat Jepang (Kanji / Kana)</span>
                        <span class="text-slate-400 font-normal lowercase text-[10px]">Opsional / Sangat dianjurkan</span>
                    </label>
                    <input 
                        type="text" 
                        name="question_japanese" 
                        value="{{ old('question_japanese', $question->question_japanese) }}" 
                        placeholder="Contoh: 毎朝、パンを（　　）食べます。"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-japanese font-bold text-slate-900 focus:bg-white focus:border-japan-600 focus:outline-none"
                    >
                    <p class="text-[10px] text-slate-400 mt-1">
                        Gunakan aksara Hiragana, Katakana, dan Kanji asli agar peserta terbiasa dengan format ujian JLPT resmi.
                    </p>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5 text-[11px]">
                        Instruksi / Pertanyaan Bahasa Indonesia <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="question" 
                        required 
                        rows="3" 
                        placeholder="Contoh: Pilihlah partikel atau kata yang tepat untuk melengkapi kalimat rumpang di atas."
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:bg-white focus:border-japan-600 focus:outline-none"
                    >{{ old('question', $question->question) }}</textarea>
                </div>
            </div>

            <!-- 3. Pilihan Jawaban (Opsi A, B, C, D) & Kunci Jawaban -->
            <div class="space-y-3 pt-2 border-t border-slate-100">
                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] flex items-center justify-between">
                    <span>Opsi Pilihan Ganda & Kunci Jawaban Benar</span>
                    <span class="text-emerald-600 font-black">Pilih radio button lingkaran untuk kunci jawaban</span>
                </label>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <!-- Opsi A -->
                    <div class="p-3.5 rounded-2xl border transition {{ old('correct_answer', $question->correct_answer) === 'A' ? 'border-emerald-500 bg-emerald-50/40 shadow-sm' : 'border-slate-200 bg-slate-50/50' }}">
                        <div class="flex items-center gap-2 mb-1.5">
                            <input 
                                type="radio" 
                                id="correct_a" 
                                name="correct_answer" 
                                value="A" 
                                {{ old('correct_answer', $question->correct_answer) === 'A' ? 'checked' : '' }}
                                class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                            >
                            <label for="correct_a" class="font-black text-slate-800 cursor-pointer text-xs">
                                Opsi A (Kunci Benar)
                            </label>
                        </div>
                        <input 
                            type="text" 
                            name="option_a" 
                            required 
                            value="{{ old('option_a', $question->option_a) }}" 
                            placeholder="Jawaban opsi A..."
                            class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:border-japan-600 focus:outline-none"
                        >
                    </div>

                    <!-- Opsi B -->
                    <div class="p-3.5 rounded-2xl border transition {{ old('correct_answer', $question->correct_answer) === 'B' ? 'border-emerald-500 bg-emerald-50/40 shadow-sm' : 'border-slate-200 bg-slate-50/50' }}">
                        <div class="flex items-center gap-2 mb-1.5">
                            <input 
                                type="radio" 
                                id="correct_b" 
                                name="correct_answer" 
                                value="B" 
                                {{ old('correct_answer', $question->correct_answer) === 'B' ? 'checked' : '' }}
                                class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                            >
                            <label for="correct_b" class="font-black text-slate-800 cursor-pointer text-xs">
                                Opsi B (Kunci Benar)
                            </label>
                        </div>
                        <input 
                            type="text" 
                            name="option_b" 
                            required 
                            value="{{ old('option_b', $question->option_b) }}" 
                            placeholder="Jawaban opsi B..."
                            class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:border-japan-600 focus:outline-none"
                        >
                    </div>

                    <!-- Opsi C -->
                    <div class="p-3.5 rounded-2xl border transition {{ old('correct_answer', $question->correct_answer) === 'C' ? 'border-emerald-500 bg-emerald-50/40 shadow-sm' : 'border-slate-200 bg-slate-50/50' }}">
                        <div class="flex items-center gap-2 mb-1.5">
                            <input 
                                type="radio" 
                                id="correct_c" 
                                name="correct_answer" 
                                value="C" 
                                {{ old('correct_answer', $question->correct_answer) === 'C' ? 'checked' : '' }}
                                class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                            >
                            <label for="correct_c" class="font-black text-slate-800 cursor-pointer text-xs">
                                Opsi C (Kunci Benar)
                            </label>
                        </div>
                        <input 
                            type="text" 
                            name="option_c" 
                            required 
                            value="{{ old('option_c', $question->option_c) }}" 
                            placeholder="Jawaban opsi C..."
                            class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:border-japan-600 focus:outline-none"
                        >
                    </div>

                    <!-- Opsi D -->
                    <div class="p-3.5 rounded-2xl border transition {{ old('correct_answer', $question->correct_answer) === 'D' ? 'border-emerald-500 bg-emerald-50/40 shadow-sm' : 'border-slate-200 bg-slate-50/50' }}">
                        <div class="flex items-center gap-2 mb-1.5">
                            <input 
                                type="radio" 
                                id="correct_d" 
                                name="correct_answer" 
                                value="D" 
                                {{ old('correct_answer', $question->correct_answer) === 'D' ? 'checked' : '' }}
                                class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                            >
                            <label for="correct_d" class="font-black text-slate-800 cursor-pointer text-xs">
                                Opsi D (Kunci Benar)
                            </label>
                        </div>
                        <input 
                            type="text" 
                            name="option_d" 
                            required 
                            value="{{ old('option_d', $question->option_d) }}" 
                            placeholder="Jawaban opsi D..."
                            class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:border-japan-600 focus:outline-none"
                        >
                    </div>
                </div>
            </div>

            <!-- 4. Penjelasan & Pembahasan Jawaban -->
            <div class="space-y-2 pt-2 border-t border-slate-100">
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5 text-[11px] flex items-center justify-between">
                    <span>Penjelasan & Pembahasan Detail</span>
                    <span class="text-slate-400 font-normal lowercase text-[10px]">Tampil saat siswa menyelesaikan tryout CBT</span>
                </label>
                <textarea 
                    name="explanation" 
                    rows="3" 
                    placeholder="Contoh: Partikel 'o' (を) digunakan untuk menandai objek langsung dari kata kerja transitif 'tabemasu' (makan)."
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:bg-white focus:border-japan-600 focus:outline-none"
                >{{ old('explanation', $question->explanation) }}</textarea>
            </div>

            <!-- 5. Urutan & Status Aktif -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100 items-center">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1 text-[11px]">
                        Nomor Urutan Soal
                    </label>
                    <input 
                        type="number" 
                        name="order" 
                        min="0" 
                        value="{{ old('order', $question->order ?? 0) }}" 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:border-japan-600 focus:outline-none"
                    >
                    <span class="text-[10px] text-slate-400">Angka lebih kecil tampil lebih awal (0 = urutan default).</span>
                </div>

                <div class="pt-2 sm:pt-4">
                    <label class="flex items-center gap-2.5 cursor-pointer select-none">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1" 
                            {{ old('is_active', $question->is_active ?? true) ? 'checked' : '' }}
                            class="w-4 h-4 text-japan-600 rounded focus:ring-red-500 cursor-pointer"
                        >
                        <span class="font-bold text-slate-800 text-xs">
                            Aktifkan Butir Soal Ini dalam Ujian CBT
                        </span>
                    </label>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a 
                    href="{{ route('admin.exam-questions.index') }}" 
                    class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition"
                >
                    Batal
                </a>

                <button 
                    type="submit" 
                    class="px-6 py-2.5 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-bold transition flex items-center gap-2 shadow-sm shadow-red-600/20"
                >
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>{{ $isEdit ? 'Simpan Perubahan Soal' : 'Tambahkan ke Bank Soal' }}</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
