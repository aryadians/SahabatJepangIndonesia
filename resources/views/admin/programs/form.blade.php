@extends('admin.layouts.admin')

@section('title', $program->exists ? 'Edit Program' : 'Tambah Program')
@section('page_title', $program->exists ? 'Edit Program Karir' : 'Tambah Program Karir Baru')

@section('content')
<div class="max-w-4xl bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
    
    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
        <div>
            <h3 class="font-extrabold text-slate-900 text-lg">{{ $program->exists ? 'Edit Data Program: ' . $program->title : 'Formulir Program Karir Baru' }}</h3>
            <p class="text-xs text-slate-500">Lengkapi informasi gaji, kualifikasi, sektor, dan fasilitas program</p>
        </div>
        <a href="{{ route('admin.programs.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">
            &larr; Kembali
        </a>
    </div>

    <form action="{{ $program->exists ? route('admin.programs.update', $program->id) : route('admin.programs.store') }}" method="POST" class="space-y-5">
        @csrf
        @if($program->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Program <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $program->title) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Tulisan Kanji / Jepang</label>
                <input type="text" name="japanese_title" value="{{ old('japanese_title', $program->japanese_title) }}" placeholder="Contoh: 特定技能" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-japanese">
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Subtitle / Penjelasan Singkat</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $program->subtitle) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Teks Badge (Contoh: Paling Populer)</label>
                <input type="text" name="badge" value="{{ old('badge', $program->badge) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Warna Badge (Class Tailwind)</label>
                <input type="text" name="badge_color" value="{{ old('badge_color', $program->badge_color ?? 'bg-red-600 text-white') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Estimasi Gaji (Yen)</label>
                <input type="text" name="salary_yen" value="{{ old('salary_yen', $program->salary_yen) }}" placeholder="¥ 180.000 - ¥ 260.000" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold text-japan-700">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Estimasi Gaji (Rupiah)</label>
                <input type="text" name="salary_idr" value="{{ old('salary_idr', $program->salary_idr) }}" placeholder="Rp 19.000.000 - Rp 27.500.000 / bln" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Masa Kontrak & Durasi</label>
                <input type="text" name="duration" value="{{ old('duration', $program->duration) }}" placeholder="Kontrak hingga 5 Tahun (Bisa Diperpanjang)" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Deskripsi Lengkap Program</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">{{ old('description', $program->description) }}</textarea>
            </div>

            <!-- Multi-lines fields -->
            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Pilihan Bidang Sektor (1 Baris = 1 Sektor)</label>
                @php
                    $sectorsStr = is_array($program->sectors) ? implode("\n", $program->sectors) : '';
                @endphp
                <textarea name="sectors_raw" rows="4" placeholder="Kaigo (Caregiver / Perawat Lansia)&#10;Pengolahan Makanan & Minuman&#10;Pertanian & Peternakan Modern" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-mono">{{ old('sectors_raw', $sectorsStr) }}</textarea>
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Persyaratan & Kualifikasi (1 Baris = 1 Syarat)</label>
                @php
                    $reqsStr = is_array($program->requirements) ? implode("\n", $program->requirements) : '';
                @endphp
                <textarea name="requirements_raw" rows="4" placeholder="Usia 18 - 35 Tahun&#10;Minimal Lulusan SMA/SMK Sederajat&#10;Sertifikat JLPT N4 / JFT A2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-mono">{{ old('requirements_raw', $reqsStr) }}</textarea>
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Fasilitas & Keuntungan (1 Baris = 1 Keuntungan)</label>
                @php
                    $benefitsStr = is_array($program->benefits) ? implode("\n", $program->benefits) : '';
                @endphp
                <textarea name="benefits_raw" rows="4" placeholder="Gaji Pokok Standar Jepang + Lembur&#10;Asuransi Kesehatan & Hari Tua Penuh&#10;Fasilitas Tempat Tinggal Bersubsidi" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-mono">{{ old('benefits_raw', $benefitsStr) }}</textarea>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Urutan Tampil (Order)</label>
                <input type="number" name="order" value="{{ old('order', $program->order ?? 1) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="flex items-center gap-3 pt-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $program->is_active ?? true) ? 'checked' : '' }} class="rounded text-japan-600 focus:ring-red-500">
                    <span class="text-sm font-bold text-slate-700">Aktifkan Program Ini di Website</span>
                </label>
            </div>

        </div>

        <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.programs.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="btn-red-primary px-7 py-2.5 rounded-xl text-xs font-bold shadow-md">
                Simpan Program
            </button>
        </div>

    </form>

</div>
@endsection
