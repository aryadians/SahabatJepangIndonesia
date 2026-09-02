@extends('admin.layouts.admin')

@section('title', $teacher->exists ? 'Edit Data Pengajar - ' . $teacher->name : 'Tambah Pengajar Baru')
@section('page_title', $teacher->exists ? 'Edit Data Pengajar' : 'Tambah Tenaga Pengajar Baru')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <!-- Top Header Bar -->
    <div class="flex items-center justify-between bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <a 
                href="{{ route('admin.teachers.index') }}" 
                class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition"
                title="Kembali ke Daftar Pengajar"
            >
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="text-base font-black text-slate-900 leading-tight">
                    {{ $teacher->exists ? 'Edit Profil Sensei: ' . $teacher->name : 'Formulir Tenaga Pengajar (Sensei)' }}
                </h2>
                <p class="text-xs text-slate-500">
                    {{ $teacher->exists ? 'NIP: ' . $teacher->nip . ' • Spesialisasi: ' . $teacher->specialization : 'Lengkapi data identitas, kualifikasi JLPT, dan spesialisasi pengajaran' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Main Form Grid (2 Columns: Left Form Fields + Right Sidebar Panel) -->
    <form action="{{ $teacher->exists ? route('admin.teachers.update', $teacher->id) : route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($teacher->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- LEFT COLUMN: CORE TEACHER DATA (8 Cols) -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- CARD 1: IDENTITAS & KONTAK SENSEI -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-5">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                            <i data-lucide="user-check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-sm">1. Identitas & Kontak Pengajar</h3>
                            <p class="text-[11px] text-slate-500">Biodata lengkap dan informasi kontak sensei</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- NIP -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nomor Induk Pengajar (NIP) <span class="text-rose-500">*</span></label>
                            <input 
                                type="text" 
                                name="nip" 
                                value="{{ old('nip', $teacher->nip ?? 'SNS-' . rand(100, 999)) }}" 
                                required 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-mono font-bold text-slate-900 bg-slate-50 focus:bg-white focus:outline-none focus:border-japan-600"
                            >
                            @error('nip') <p class="text-rose-500 text-[11px]">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nama Lengkap & Gelar -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name', $teacher->name) }}" 
                                required 
                                placeholder="Budi Santoso, S.Pd., M.Hum." 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                            @error('name') <p class="text-rose-500 text-[11px]">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nama Kanji / Romaji -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nama Kanji / Romaji Panggilan</label>
                            <input 
                                type="text" 
                                name="romaji_name" 
                                value="{{ old('romaji_name', $teacher->romaji_name) }}" 
                                placeholder="Budi Sensei (ブディ先生)" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-japanese text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Jenis Kelamin <span class="text-rose-500">*</span></label>
                            <select name="gender" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                                <option value="Laki-laki" {{ old('gender', $teacher->gender) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki (男性)</option>
                                <option value="Perempuan" {{ old('gender', $teacher->gender) === 'Perempuan' ? 'selected' : '' }}>Perempuan (女性)</option>
                            </select>
                        </div>

                        <!-- WhatsApp -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nomor WhatsApp Sensei</label>
                            <input 
                                type="text" 
                                name="phone" 
                                value="{{ old('phone', $teacher->phone) }}" 
                                placeholder="081234567890" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Email -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Alamat Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                value="{{ old('email', $teacher->email) }}" 
                                placeholder="sensei@sahabatjepangindonesia.com" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Tanggal Bergabung -->
                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Tanggal Mulai Bergabung di LPK</label>
                            <input 
                                type="date" 
                                name="join_date" 
                                value="{{ old('join_date', $teacher->join_date ? $teacher->join_date->format('Y-m-d') : '') }}" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                    </div>
                </div>

                <!-- CARD 2: KUALIFIKASI & PENGALAMAN MENGAJAR -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-5">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                            <i data-lucide="award" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-sm">2. Kualifikasi, Sertifikasi & Pengalaman</h3>
                            <p class="text-[11px] text-slate-500">Level JLPT, bidang keahlian, dan riwayat di Jepang</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Level JLPT -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Sertifikasi JLPT / Level Bahasa <span class="text-rose-500">*</span></label>
                                <input 
                                    type="text" 
                                    name="jlpt_level" 
                                    value="{{ old('jlpt_level', $teacher->jlpt_level ?? 'JLPT N2 (Certified)') }}" 
                                    required 
                                    placeholder="JLPT N1 / JLPT N2 / Native Speaker" 
                                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600"
                                >
                            </div>

                            <!-- Spesialisasi -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Bidang Pengajaran Spesialisasi <span class="text-rose-500">*</span></label>
                                <input 
                                    type="text" 
                                    name="specialization" 
                                    value="{{ old('specialization', $teacher->specialization ?? 'Tata Bahasa (Bunpou) & Percakapan (Kaiwa)') }}" 
                                    required 
                                    placeholder="Bunpou, Kaiwa, Kaigo, Mensetsu" 
                                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600"
                                >
                            </div>
                        </div>

                        <!-- Pengalaman Jepang -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Pengalaman Kerja / Studi di Jepang</label>
                            <input 
                                type="text" 
                                name="japan_experience" 
                                value="{{ old('japan_experience', $teacher->japan_experience) }}" 
                                placeholder="Contoh: Alumni Tohoku University & 5 Tahun Bekerja di Tokyo Tech" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: SIDEBAR ACTIONS & PHOTO (4 Cols) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- PHOTO FRAME CARD -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
                    <h3 class="font-black text-slate-900 text-xs uppercase tracking-wider border-b border-slate-100 pb-2">
                        Foto Profil Sensei
                    </h3>

                    <div class="flex flex-col items-center justify-center text-center space-y-3">
                        <div class="w-28 h-36 rounded-xl bg-slate-100 border-2 border-slate-300 overflow-hidden shadow-sm flex items-center justify-center relative">
                            @if($teacher->photo)
                                <img id="teacherPhotoPreview" src="{{ $teacher->photo }}" alt="{{ $teacher->name }}" class="w-full h-full object-cover">
                            @else
                                <img id="teacherPhotoPreview" src="" alt="Preview Foto" class="w-full h-full object-cover hidden">
                                <div id="noTeacherPhotoText" class="text-center p-2 text-slate-400">
                                    <i data-lucide="camera" class="w-6 h-6 mx-auto mb-1"></i>
                                    <span class="text-[10px] font-bold block">Foto Sensei</span>
                                </div>
                            @endif
                        </div>
                        <p class="text-[10px] text-slate-400">Tersimpan Base64 di Database</p>
                    </div>

                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <div class="space-y-1">
                            <label class="block text-[11px] font-bold text-slate-700">Upload File Foto</label>
                            <input 
                                type="file" 
                                name="photo_file" 
                                accept="image/*" 
                                onchange="previewTeacherPhoto(this)"
                                class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs bg-slate-50 focus:outline-none file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[11px] file:font-bold file:bg-japan-600 file:text-white hover:file:bg-japan-700 cursor-pointer"
                            >
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[11px] font-bold text-slate-700">Atau URL Foto</label>
                            <input 
                                type="text" 
                                name="photo" 
                                value="{{ old('photo', $teacher->photo) }}" 
                                placeholder="https://..." 
                                class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>
                    </div>
                </div>

                <!-- KEPEGAWAIAN & STATUS CARD -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
                    <h3 class="font-black text-slate-900 text-xs uppercase tracking-wider border-b border-slate-100 pb-2">
                        Status & Kepegawaian
                    </h3>

                    <!-- Tipe Kepegawaian -->
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-slate-700">Tipe Kepegawaian <span class="text-rose-500">*</span></label>
                        <select name="employment_type" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                            <option value="full_time" {{ old('employment_type', $teacher->employment_type) === 'full_time' ? 'selected' : '' }}>Instruktur Tetap (Full Time)</option>
                            <option value="part_time" {{ old('employment_type', $teacher->employment_type) === 'part_time' ? 'selected' : '' }}>Instruktur Tamu / Freelance</option>
                            <option value="native" {{ old('employment_type', $teacher->employment_type) === 'native' ? 'selected' : '' }}>Native Speaker Jepang</option>
                        </select>
                    </div>

                    <!-- Status Keaktifan -->
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-slate-700">Status Keaktifan <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                            <option value="active" {{ old('status', $teacher->status) === 'active' ? 'selected' : '' }}>Aktif Mengajar</option>
                            <option value="leave" {{ old('status', $teacher->status) === 'leave' ? 'selected' : '' }}>Cuti Sementara</option>
                            <option value="inactive" {{ old('status', $teacher->status) === 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>

                    <!-- Catatan Deskripsi -->
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-slate-700">Catatan Internal Sensei</label>
                        <textarea 
                            name="notes" 
                            rows="2" 
                            placeholder="Catatan keahlian, tugas kurikulum, dll..." 
                            class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                        >{{ old('notes', $teacher->notes) }}</textarea>
                    </div>
                </div>

                <!-- SUBMIT ACTIONS CARD -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-2">
                    <button 
                        type="submit" 
                        class="w-full py-3 rounded-xl bg-japan-600 hover:bg-japan-700 text-white font-black text-xs shadow-md flex items-center justify-center gap-2 transition"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $teacher->exists ? 'Simpan Pembaruan Sensei' : 'Daftarkan Sensei Baru' }}</span>
                    </button>
                    
                    <a 
                        href="{{ route('admin.teachers.index') }}" 
                        class="w-full py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold text-xs flex items-center justify-center transition"
                    >
                        Batal
                    </a>
                </div>

            </div>

        </div>
    </form>

</div>

<script>
    function previewTeacherPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('teacherPhotoPreview');
                const noText = document.getElementById('noTeacherPhotoText');
                if (img) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                }
                if (noText) {
                    noText.classList.add('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
