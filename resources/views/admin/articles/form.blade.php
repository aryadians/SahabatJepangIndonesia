@extends('admin.layouts.admin')

@section('title', $article->exists ? 'Edit Artikel' : 'Tulis Artikel Baru')
@section('page_title', $article->exists ? 'Edit Artikel Edukasi' : 'Tulis Artikel Edukasi Baru')

@section('content')
<div class="max-w-4xl bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
    
    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
        <div>
            <h3 class="font-extrabold text-slate-900 text-lg">{{ $article->exists ? 'Edit Artikel: ' . $article->title : 'Formulir Penulisan Artikel Baru' }}</h3>
            <p class="text-xs text-slate-500">Artikel edukasi akan tampil di beranda dan halaman berita</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">
            &larr; Kembali
        </a>
    </div>

    <form action="{{ $article->exists ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @if($article->exists)
            @method('PUT')
        @endif

        <div class="space-y-4">
            
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Judul Artikel *</label>
                <input type="text" name="title" value="{{ old('title', $article->title) }}" required placeholder="Contoh: Panduan Lengkap Syarat Tokutei Ginou SSW 2026" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Kategori *</label>
                    <input type="text" name="category" value="{{ old('category', $article->category ?? 'Panduan SSW') }}" required placeholder="Panduan SSW / Tips & Trik / Finansial / Budaya" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Penulis (Author)</label>
                    <input type="text" name="author" value="{{ old('author', $article->author ?? 'Tim Edukasi LPK SJI') }}" placeholder="Tim Edukasi LPK SJI" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Upload File Thumbnail (Base64)</label>
                    <input type="file" name="thumbnail_file" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:outline-none focus:border-japan-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-japan-600 file:text-white hover:file:bg-japan-700 cursor-pointer">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Atau URL Gambar Thumbnail</label>
                    <input type="text" name="thumbnail" value="{{ old('thumbnail', $article->thumbnail) }}" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Ringkasan Singkat (Excerpt)</label>
                <textarea name="excerpt" rows="2" placeholder="Ringkasan 1-2 kalimat untuk preview di kartu..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">{{ old('excerpt', $article->excerpt) }}</textarea>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Isi Lengkap Konten Artikel (Format HTML / Teks) *</label>
                <textarea name="content" rows="12" required placeholder="Tuliskan isi artikel lengkap di sini... Mendukung tag HTML seperti <h3>, <p>, <ul>, <li>, <strong>" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-mono">{{ old('content', $article->content) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $article->is_published ?? true) ? 'checked' : '' }} class="rounded text-japan-600 focus:ring-red-500">
                    <span class="text-sm font-bold text-slate-700">Publikasikan Sekarang (Status: Tayang)</span>
                </label>
            </div>

        </div>

        <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.articles.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="btn-red-primary px-7 py-2.5 rounded-xl text-xs font-bold shadow-md">
                Simpan Artikel
            </button>
        </div>

    </form>

</div>
@endsection
