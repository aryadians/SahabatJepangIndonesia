@extends('admin.layouts.admin')

@section('title', $teacher->exists ? 'Edit Data Karyawan - ' . $teacher->name : 'Tambah Karyawan / Sensei Baru')
@section('page_title', $teacher->exists ? 'Edit Profil Karyawan & SDM' : 'Tambah Karyawan / Sensei Baru')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <!-- Top Header Bar -->
    <div class="flex items-center justify-between bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <a 
                href="{{ route('admin.teachers.index') }}" 
                class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition"
                title="Kembali ke Daftar Karyawan"
            >
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="text-base font-black text-slate-900 leading-tight">
                    {{ $teacher->exists ? 'Edit Profil: ' . $teacher->name : 'Formulir Karyawan, Direksi & Sensei' }}
                </h2>
                <p class="text-xs text-slate-500">
                    {{ $teacher->exists ? 'ID/NIP: ' . $teacher->nip . ' • Jabatan: ' . ($teacher->position_title ?: $teacher->role_badge['label']) : 'Lengkapi data identitas, peran jabatan, departemen, serta status eksekutif' }}
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
            
            <!-- LEFT COLUMN: CORE TEACHER & EMPLOYEE DATA (8 Cols) -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- CARD 1: IDENTITAS & JABATAN STRUKTURAL -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-5">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                            <i data-lucide="briefcase" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-sm">1. Jabatan & Identitas Karyawan</h3>
                            <p class="text-[11px] text-slate-500">Tentukan peran, jabatan resmi institusi, dan data personal</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- Role / Kategori Jabatan -->
                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Peran / Posisi di Lembaga <span class="text-rose-500">*</span></label>
                            <select name="role" id="employeeRoleSelect" onchange="handleRoleChange(this.value)" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                                <option value="ceo_owner" {{ old('role', $teacher->role) === 'ceo_owner' ? 'selected' : '' }}>👑 Owner / Chief Executive Officer (CEO)</option>
                                <option value="director" {{ old('role', $teacher->role) === 'director' ? 'selected' : '' }}>🏛️ Direktur (Operasional / Pelatihan / Kemitraan)</option>
                                <option value="finance" {{ old('role', $teacher->role) === 'finance' ? 'selected' : '' }}>💰 Bendahara & Bagian Keuangan</option>
                                <option value="sensei" {{ old('role', $teacher->role ?? 'sensei') === 'sensei' ? 'selected' : '' }}>🎓 Sensei / Tenaga Pengajar Bahasa Jepang</option>
                                <option value="operations" {{ old('role', $teacher->role) === 'operations' ? 'selected' : '' }}>⚙️ Staf Operasional & Asrama</option>
                                <option value="staff" {{ old('role', $teacher->role) === 'staff' ? 'selected' : '' }}>📋 Staf Administrasi & Humas</option>
                            </select>
                        </div>

                        <!-- NIP / ID Pegawai -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nomor Induk / NIP Pegawai <span class="text-rose-500">*</span></label>
                            <input 
                                type="text" 
                                name="nip" 
                                value="{{ old('nip', $teacher->nip ?? 'EMP-' . rand(100, 999)) }}" 
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
                                placeholder="Dr. Ir. Budi Santoso, M.M." 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                            @error('name') <p class="text-rose-500 text-[11px]">{{ $message }}</p> @enderror
                        </div>

                        <!-- Jabatan Resmi (Title) -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nama Jabatan Resmi (Tampil di Publik)</label>
                            <input 
                                type="text" 
                                name="position_title" 
                                value="{{ old('position_title', $teacher->position_title) }}" 
                                placeholder="Founder & Chief Executive Officer" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600 font-semibold"
                            >
                        </div>

                        <!-- Departemen / Divisi -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Departemen / Divisi</label>
                            <input 
                                type="text" 
                                name="department" 
                                value="{{ old('department', $teacher->department) }}" 
                                placeholder="Direksi / Keuangan / Akademik / Humas" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Nama Kanji / Romaji / Gelar Jepang -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nama Panggilan Romaji / Gelar</label>
                            <input 
                                type="text" 
                                name="romaji_name" 
                                value="{{ old('romaji_name', $teacher->romaji_name) }}" 
                                placeholder="Budi Sensei / 代表取締役" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-japanese text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Jenis Kelamin <span class="text-rose-500">*</span></label>
                            <select name="gender" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                                <option value="Laki-laki" {{ old('gender', $teacher->gender) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender', $teacher->gender) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <!-- WhatsApp -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nomor WhatsApp</label>
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
                                placeholder="karyawan@sahabatjepangindonesia.com" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Tanggal Mulai Bergabung -->
                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Tanggal Mulai Bergabung di Lembaga</label>
                            <input 
                                type="date" 
                                name="join_date" 
                                value="{{ old('join_date', $teacher->join_date ? $teacher->join_date->format('Y-m-d') : '') }}" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                    </div>
                </div>

                <!-- CARD 2: KUALIFIKASI, JLPT & PENGALAMAN -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-5">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                            <i data-lucide="award" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-sm">2. Kualifikasi, Sertifikasi & Pengalaman</h3>
                            <p class="text-[11px] text-slate-500">Level bahasa Jepang, portofolio karir, dan riwayat di Jepang</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Level JLPT -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Level JLPT / Bahasa Jepang</label>
                                <input 
                                    type="text" 
                                    name="jlpt_level" 
                                    value="{{ old('jlpt_level', $teacher->jlpt_level ?? 'JLPT N2 (Certified)') }}" 
                                    placeholder="JLPT N1 / N2 / Native / -" 
                                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600"
                                >
                            </div>

                            <!-- Spesialisasi -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Bidang Keahlian / Spesialisasi</label>
                                <input 
                                    type="text" 
                                    name="specialization" 
                                    value="{{ old('specialization', $teacher->specialization ?? 'Tata Bahasa & Percakapan') }}" 
                                    placeholder="Bunpou, Kaiwa, Manajemen SO, Keuangan" 
                                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600"
                                >
                            </div>
                        </div>

                        <!-- Pengalaman Jepang -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Pengalaman Kerja / Studi di Jepang & Portofolio</label>
                            <input 
                                type="text" 
                                name="japan_experience" 
                                value="{{ old('japan_experience', $teacher->japan_experience) }}" 
                                placeholder="Contoh: Ex-Ginou Jisshusei Toyota Aichi (3 Tahun) / 10+ Tahun Praktisi Penempatan Kerja Jepang" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: SIDEBAR ACTIONS, VISIBILITY & PHOTO (4 Cols) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- EXECUTIVE VISIBILITY CARD -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-5 border border-amber-200 shadow-sm space-y-3">
                    <div class="flex items-center gap-2 text-amber-900 font-black text-xs uppercase tracking-wider">
                        <i data-lucide="crown" class="w-4 h-4 text-amber-600"></i>
                        <span>Profil Publik & Guest</span>
                    </div>

                    <label class="flex items-start gap-3 cursor-pointer select-none pt-1">
                        <input 
                            type="checkbox" 
                            name="is_executive" 
                            value="1" 
                            {{ old('is_executive', $teacher->is_executive || in_array($teacher->role, ['ceo_owner', 'director'])) ? 'checked' : '' }} 
                            class="w-4 h-4 mt-0.5 rounded text-amber-600 focus:ring-amber-500 border-amber-300"
                        >
                        <div class="text-xs">
                            <span class="font-extrabold text-slate-900 block">Tampilkan di Dewan Pimpinan (Guest)</span>
                            <span class="text-slate-600 text-[11px] block mt-0.5">
                                Profil, foto, dan visi beliau akan ditampilkan di section Kepemimpinan Eksekutif halaman publik untuk membangun kredibilitas calon siswa.
                            </span>
                        </div>
                    </label>

                    <div class="space-y-1 pt-2 border-t border-amber-200/60">
                        <label class="block text-[11px] font-bold text-amber-900">Urutan Tampil (Order)</label>
                        <input 
                            type="number" 
                            name="order" 
                            value="{{ old('order', $teacher->order ?? 0) }}" 
                            class="w-full px-3 py-1.5 rounded-lg border border-amber-300 text-xs bg-white focus:outline-none focus:border-amber-600 font-bold"
                            placeholder="0 (Paling Utama)"
                        >
                    </div>
                </div>

                <!-- PHOTO FRAME CARD -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
                    <h3 class="font-black text-slate-900 text-xs uppercase tracking-wider border-b border-slate-100 pb-2">
                        Foto Profil Resmi
                    </h3>

                    <div class="flex flex-col items-center justify-center text-center space-y-3">
                        <div class="w-28 h-36 rounded-xl bg-slate-100 border-2 border-slate-300 overflow-hidden shadow-sm flex items-center justify-center relative">
                            @if($teacher->photo)
                                <img id="teacherPhotoPreview" src="{{ $teacher->photo }}" alt="{{ $teacher->name }}" class="w-full h-full object-cover">
                            @else
                                <img id="teacherPhotoPreview" src="" alt="Preview Foto" class="w-full h-full object-cover hidden">
                                <div id="noTeacherPhotoText" class="text-center p-2 text-slate-400">
                                    <i data-lucide="camera" class="w-6 h-6 mx-auto mb-1"></i>
                                    <span class="text-[10px] font-bold block">Foto Profil</span>
                                </div>
                            @endif
                        </div>
                        <p class="text-[10px] text-slate-400">Format Base64 tersimpan aman di database</p>
                    </div>

                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <div class="space-y-1">
                            <label class="block text-[11px] font-bold text-slate-700">Upload File Foto Baru</label>
                            <input 
                                type="file" 
                                name="photo_file" 
                                accept="image/*" 
                                onchange="previewTeacherPhoto(this)"
                                class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs bg-slate-50 focus:outline-none file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[11px] file:font-bold file:bg-japan-600 file:text-white hover:file:bg-japan-700 cursor-pointer"
                            >
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[11px] font-bold text-slate-700">Atau URL Foto Eksternal</label>
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
                        Status & Kontrak
                    </h3>

                    <!-- Tipe Kepegawaian -->
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-slate-700">Tipe Ikatan Kerja</label>
                        <select name="employment_type" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                            <option value="full_time" {{ old('employment_type', $teacher->employment_type) === 'full_time' ? 'selected' : '' }}>Karyawan Tetap (Full Time)</option>
                            <option value="part_time" {{ old('employment_type', $teacher->employment_type) === 'part_time' ? 'selected' : '' }}>Kontrak / Freelance</option>
                            <option value="native" {{ old('employment_type', $teacher->employment_type) === 'native' ? 'selected' : '' }}>Native Speaker Jepang</option>
                        </select>
                    </div>

                    <!-- Status Keaktifan -->
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-slate-700">Status Keaktifan <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                            <option value="active" {{ old('status', $teacher->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="leave" {{ old('status', $teacher->status) === 'leave' ? 'selected' : '' }}>Cuti Sementara</option>
                            <option value="inactive" {{ old('status', $teacher->status) === 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>

                    <!-- Catatan Deskripsi -->
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-slate-700">Catatan Internal / Visi Singkat</label>
                        <textarea 
                            name="notes" 
                            rows="2" 
                            placeholder="Catatan portofolio atau kutipan visi..." 
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
                        <span>{{ $teacher->exists ? 'Simpan Pembaruan Profil' : 'Daftarkan Karyawan Baru' }}</span>
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

    function handleRoleChange(role) {
        const execCheckbox = document.querySelector('input[name="is_executive"]');
        if (execCheckbox) {
            if (role === 'ceo_owner' || role === 'director') {
                execCheckbox.checked = true;
            }
        }
    }
</script>
@endsection
