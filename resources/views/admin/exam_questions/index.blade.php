@extends('admin.layouts.admin')

@section('title', 'Bank Soal Ujian CBT')
@section('page_title', 'Manajemen Bank Soal & Tryout CBT JLPT/JFT')

@section('content')
<div class="space-y-6">

    <!-- Top Stats Cards Row -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
        <div class="bg-white rounded-3xl p-4 border border-slate-200/90 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                <i data-lucide="book-marked" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Soal</p>
                <p class="text-xl font-black text-slate-900">{{ $stats['total'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-4 border border-slate-200/90 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Soal Aktif</p>
                <p class="text-xl font-black text-emerald-600">{{ $stats['active'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-4 border border-slate-200/90 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <span class="text-xs font-black">N5</span>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">JLPT N5</p>
                <p class="text-xl font-black text-blue-600">{{ $stats['n5'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-4 border border-slate-200/90 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold">
                <span class="text-xs font-black">N4</span>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">JLPT N4</p>
                <p class="text-xl font-black text-teal-600">{{ $stats['n4'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-4 border border-slate-200/90 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                <span class="text-xs font-black">N3</span>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">JLPT N3</p>
                <p class="text-xl font-black text-purple-600">{{ $stats['n3'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-4 border border-slate-200/90 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <span class="text-xs font-black">JFT</span>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">JFT-Basic</p>
                <p class="text-xl font-black text-amber-600">{{ $stats['jft'] }}</p>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        
        <!-- Header Actions & Navigation -->
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-black text-slate-900 text-lg flex items-center gap-2">
                    <span class="font-japanese text-japan-600 text-base">日本語試験</span>
                    <span>Bank Soal Latihan & Tryout CBT</span>
                </h3>
                <p class="text-xs text-slate-500">
                    Kelola materi latihan ujian bahasa Jepang untuk siswa LPK SJI Group dan simulasi tryout publik
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <a 
                    href="{{ route('exam.simulator') }}" 
                    target="_blank" 
                    class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                >
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    <span>Coba CBT Publik</span>
                </a>

                <a 
                    href="{{ route('admin.exam-questions.create') }}" 
                    class="px-4 py-2 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm shadow-red-600/20"
                >
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Tambah Butir Soal</span>
                </a>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="p-4 bg-slate-50 border-b border-slate-100">
            <form action="{{ route('admin.exam-questions.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
                <!-- Search Box -->
                <div class="relative flex-1 min-w-[200px] sm:min-w-[260px]">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search }}" 
                        placeholder="Cari soal, kanji, opsi, atau pembahasan..."
                        class="w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                    >
                </div>

                <!-- Level Filter -->
                <select 
                    name="level" 
                    class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 font-semibold focus:outline-none focus:border-japan-600"
                >
                    <option value="all" {{ $level === 'all' ? 'selected' : '' }}>Semua Level</option>
                    <option value="N5" {{ $level === 'N5' ? 'selected' : '' }}>JLPT N5</option>
                    <option value="N4" {{ $level === 'N4' ? 'selected' : '' }}>JLPT N4</option>
                    <option value="N3" {{ $level === 'N3' ? 'selected' : '' }}>JLPT N3</option>
                    <option value="JFT-Basic" {{ $level === 'JFT-Basic' ? 'selected' : '' }}>JFT-Basic A2</option>
                </select>

                <!-- Section Filter -->
                <select 
                    name="section" 
                    class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 font-semibold focus:outline-none focus:border-japan-600"
                >
                    <option value="all" {{ $section === 'all' ? 'selected' : '' }}>Semua Bagian</option>
                    <option value="Kotoba" {{ $section === 'Kotoba' ? 'selected' : '' }}>Kotoba (Kosakata)</option>
                    <option value="Bunpou" {{ $section === 'Bunpou' ? 'selected' : '' }}>Bunpou (Tata Bahasa)</option>
                    <option value="Dokkai" {{ $section === 'Dokkai' ? 'selected' : '' }}>Dokkai (Membaca)</option>
                    <option value="Kanji" {{ $section === 'Kanji' ? 'selected' : '' }}>Kanji</option>
                    <option value="Choukai" {{ $section === 'Choukai' ? 'selected' : '' }}>Choukai (Mendengarkan)</option>
                </select>

                <!-- Status Filter -->
                <select 
                    name="status" 
                    class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 font-semibold focus:outline-none focus:border-japan-600"
                >
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Hanya Aktif</option>
                    <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <button 
                    type="submit" 
                    class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5"
                >
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>Terapkan</span>
                </button>

                @if($search || $level !== 'all' || $section !== 'all' || $status !== 'all')
                    <a 
                        href="{{ route('admin.exam-questions.index') }}" 
                        class="px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold transition"
                    >
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Table Listing -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                        <th class="py-3.5 px-4 w-12 text-center">#</th>
                        <th class="py-3.5 px-4 w-36">Level & Bagian</th>
                        <th class="py-3.5 px-4 min-w-[280px]">Butir Pertanyaan</th>
                        <th class="py-3.5 px-4 w-60">Pilihan Jawaban (Opsi)</th>
                        <th class="py-3.5 px-4 w-28 text-center">Kunci & Poin</th>
                        <th class="py-3.5 px-4 w-24 text-center">Status</th>
                        <th class="py-3.5 px-4 w-28 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($questions as $index => $q)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 text-center text-slate-400 font-mono">
                                {{ $questions->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4 space-y-1">
                                <div>
                                    @if($q->level === 'N5')
                                        <span class="px-2 py-0.5 rounded-md font-black text-[10px] bg-blue-100 text-blue-700 border border-blue-200">
                                            JLPT N5
                                        </span>
                                    @elseif($q->level === 'N4')
                                        <span class="px-2 py-0.5 rounded-md font-black text-[10px] bg-teal-100 text-teal-700 border border-teal-200">
                                            JLPT N4
                                        </span>
                                    @elseif($q->level === 'N3')
                                        <span class="px-2 py-0.5 rounded-md font-black text-[10px] bg-purple-100 text-purple-700 border border-purple-200">
                                            JLPT N3
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-md font-black text-[10px] bg-amber-100 text-amber-700 border border-amber-200">
                                            JFT-Basic
                                        </span>
                                    @endif
                                </div>
                                <div class="text-[11px] font-semibold text-slate-500">
                                    {{ $q->section }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if(!empty($q->question_japanese))
                                    <div class="font-japanese font-bold text-slate-900 text-sm mb-1 leading-snug">
                                        {{ $q->question_japanese }}
                                    </div>
                                @endif
                                <p class="text-slate-800 font-medium line-clamp-2">
                                    {{ $q->question }}
                                </p>
                                @if(!empty($q->explanation))
                                    <div class="mt-1 text-[11px] text-slate-500 line-clamp-1 italic bg-slate-50 px-2 py-0.5 rounded border border-slate-100">
                                        💡 Pembahasan: {{ $q->explanation }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-[11px] space-y-0.5 font-mono">
                                <div class="{{ $q->correct_answer === 'A' ? 'text-emerald-700 font-black bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200' : 'text-slate-600' }}">
                                    A: {{ Str::limit($q->option_a, 25) }}
                                </div>
                                <div class="{{ $q->correct_answer === 'B' ? 'text-emerald-700 font-black bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200' : 'text-slate-600' }}">
                                    B: {{ Str::limit($q->option_b, 25) }}
                                </div>
                                <div class="{{ $q->correct_answer === 'C' ? 'text-emerald-700 font-black bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200' : 'text-slate-600' }}">
                                    C: {{ Str::limit($q->option_c, 25) }}
                                </div>
                                <div class="{{ $q->correct_answer === 'D' ? 'text-emerald-700 font-black bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200' : 'text-slate-600' }}">
                                    D: {{ Str::limit($q->option_d, 25) }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-block w-7 h-7 rounded-full bg-emerald-600 text-white font-black text-xs leading-7 shadow-sm">
                                    {{ $q->correct_answer }}
                                </span>
                                <div class="text-[10px] text-slate-400 font-bold mt-1">
                                    {{ $q->points }} Poin
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('admin.exam-questions.toggle', $q->id) }}" method="POST">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="px-2.5 py-1 rounded-full text-[10px] font-extrabold transition {{ $q->is_active ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}"
                                        title="Klik untuk mengubah status aktif"
                                    >
                                        {{ $q->is_active ? '● Aktif' : '○ Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a 
                                        href="{{ route('admin.exam-questions.edit', $q->id) }}" 
                                        class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition" 
                                        title="Edit Soal"
                                    >
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <form 
                                        action="{{ route('admin.exam-questions.destroy', $q->id) }}" 
                                        method="POST" 
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini dari Bank Soal?');"
                                        class="inline-block"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition" 
                                            title="Hapus Soal"
                                        >
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i data-lucide="file-question" class="w-10 h-10 text-slate-300"></i>
                                    <p class="font-bold text-slate-700">Tidak ada butir soal yang ditemukan</p>
                                    <p class="text-xs text-slate-400">Silakan ubah filter pencarian atau tambahkan soal baru.</p>
                                    <a 
                                        href="{{ route('admin.exam-questions.create') }}" 
                                        class="mt-2 px-4 py-2 rounded-xl bg-japan-600 hover:bg-japan-700 text-white text-xs font-bold transition shadow-sm"
                                    >
                                        Tambah Soal Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($questions->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $questions->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
