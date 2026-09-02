@extends('admin.layouts.admin')

@section('title', 'Kelola Artikel Edukasi')
@section('page_title', 'Kelola Berita & Artikel Edukasi Karir')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h3 class="font-extrabold text-slate-900 text-lg">Daftar Artikel & Berita</h3>
            <p class="text-xs text-slate-500">Artikel edukasi seputar karir Jepang yang dipublikasikan di website</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="btn-red-primary px-5 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tulis Artikel Baru</span>
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3.5 px-4">Artikel</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Penulis</th>
                        <th class="py-3.5 px-4">Dibaca</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($articles as $art)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100 border border-slate-200">
                                        <img src="{{ $art->thumbnail }}" alt="{{ $art->title }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h4 class="font-extrabold text-slate-900 line-clamp-1 max-w-sm">{{ $art->title }}</h4>
                                        <span class="text-[11px] text-slate-400">{{ $art->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                    {{ $art->category }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 font-medium">
                                {{ $art->author }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 font-semibold">
                                {{ number_format($art->views) }} views
                            </td>
                            <td class="py-3.5 px-4">
                                @if($art->is_published)
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs">Tayang</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 font-bold text-xs">Draft</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-center">
                                    
                                    <!-- Lihat Artikel -->
                                    <a 
                                        href="{{ route('articles.show', $art->slug) }}" 
                                        target="_blank" 
                                        class="p-1.5 rounded-lg text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition" 
                                        title="Buka Halaman Artikel"
                                    >
                                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <!-- Edit Artikel -->
                                    <a 
                                        href="{{ route('admin.articles.edit', $art->id) }}" 
                                        class="px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold transition flex items-center gap-1"
                                        title="Edit Lengkap Artikel"
                                    >
                                        <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                        <span>Edit</span>
                                    </a>

                                    <!-- Delete Artikel -->
                                    <form action="{{ route('admin.articles.destroy', $art->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus artikel {{ $art->title }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 transition" title="Hapus">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">Belum ada artikel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
