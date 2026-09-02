@extends('admin.layouts.admin')

@section('title', $teacher->exists ? 'Edit Pengajar - ' . $teacher->name : 'Tambah Pengajar Baru')
@section('page_title', $teacher->exists ? 'Edit Data Pengajar' : 'Tambah Tenaga Pengajar / Sensei Baru')

@section('content')
<div class="max-w-4xl space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.teachers.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            &larr; Kembali ke Data Pengajar
        </a>
    </div>

    <form action="{{ $teacher->exists ? route('admin.teachers.update', $teacher->id) : route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if($teacher->exists)
            @method('PUT')
        @endif

        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
                <i data-lucide="user-check" class="w-5 h-5 text-japan-600"></i>
                <h3 class="font-extrabold text-slate-900 text-base">Profil Instruktur / Sensei</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nomor Induk Pengajar (NIP) *</label>
                    <input type="text" name="nip" value="{{ old('nip', $teacher->nip ?? 'SNS-' . rand(100, 999)) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-mono font-bold focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nama Lengkap & Gelar *</label>
                    <input type="text" name="name" value="{{ old('name', $teacher->name) }}" required placeholder="Contoh: Budi Santoso, S.Pd., M.Hum." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-bold focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nama Panggilan / Kanji (Sensei)</label>
                    <input type="text" name="romaji_name" value="{{ old('romaji_name', $teacher->romaji_name) }}" placeholder="Contoh: Budi Sensei (ブディ先生)" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-japanese focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Level Sertifikasi JLPT *</label>
                    <input type="text" name="jlpt_level" value="{{ old('jlpt_level', $teacher->jlpt_level ?? 'JLPT N2') }}" required placeholder="JLPT N1 / JLPT N2 / Native Speaker" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nomor WhatsApp / HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}" placeholder="081234567890" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Email</label>
                    <input type="email" name="email" value="{{ old('email', $teacher->email) }}" placeholder="sensei@sahabatjepangindonesia.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Jenis Kelamin *</label>
                    <select name="gender" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
                        <option value="Laki-laki" {{ old('gender', $teacher->gender) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $teacher->gender) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Status Keaktifan *</label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
                        <option value="active" {{ old('status', $teacher->status) === 'active' ? 'selected' : '' }}>Aktif Mengajar</option>
                        <option value="leave" {{ old('status', $teacher->status) === 'leave' ? 'selected' : '' }}>Cuti</option>
                        <option value="inactive" {{ old('status', $teacher->status) === 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Tipe Kepegawaian *</label>
                    <select name="employment_type" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
                        <option value="full_time" {{ old('employment_type', $teacher->employment_type) === 'full_time' ? 'selected' : '' }}>Instruktur Tetap (Full Time)</option>
                        <option value="part_time" {{ old('employment_type', $teacher->employment_type) === 'part_time' ? 'selected' : '' }}>Instruktur Tamu / Part Time</option>
                        <option value="native" {{ old('employment_type', $teacher->employment_type) === 'native' ? 'selected' : '' }}>Native Speaker Jepang</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Tanggal Bergabung</label>
                    <input type="date" name="join_date" value="{{ old('join_date', $teacher->join_date ? $teacher->join_date->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5 sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Bidang Spesialisasi Pengajaran *</label>
                    <input type="text" name="specialization" value="{{ old('specialization', $teacher->specialization ?? 'Tata Bahasa (Bunpou) & Percakapan (Kaiwa)') }}" required placeholder="Tata Bahasa (Bunpou), Kaiwa, Istilah Kaigo, Budaya Kerja Horenso" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5 sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Pengalaman Kerja / Studi di Jepang</label>
                    <input type="text" name="japan_experience" value="{{ old('japan_experience', $teacher->japan_experience) }}" placeholder="Contoh: Ex-Ginou Jisshusei Toyota Aichi (3 Tahun)" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5 sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Upload Foto Profil Sensei (Base64)</label>
                    <input type="file" name="photo_file" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:outline-none focus:border-japan-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-japan-600 file:text-white hover:file:bg-japan-700 cursor-pointer">
                </div>

                <div class="space-y-1.5 sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Atau URL Foto Sensei</label>
                    <input type="text" name="photo" value="{{ old('photo', $teacher->photo) }}" placeholder="https://..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5 sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Catatan Tambahan</label>
                    <textarea name="notes" rows="2" placeholder="Catatan internal profil sensei..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">{{ old('notes', $teacher->notes) }}</textarea>
                </div>

            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('admin.teachers.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Simpan Data Sensei</span>
                </button>
            </div>
        </div>

    </form>

</div>
@endsection
