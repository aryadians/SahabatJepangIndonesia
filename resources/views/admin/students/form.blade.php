@extends('admin.layouts.admin')

@section('title', $student->exists ? 'Edit Data Siswa - ' . $student->name : 'Tambah Siswa Baru')
@section('page_title', $student->exists ? 'Edit Data Siswa' : 'Pendaftaran Data Siswa Baru')

@section('content')
<div class="max-w-5xl space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.students.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            &larr; Kembali ke Data Siswa
        </a>
    </div>

    <form action="{{ $student->exists ? route('admin.students.update', $student->id) : route('admin.students.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if($student->exists)
            @method('PUT')
        @endif

        <!-- Card 1: Identitas Pribadi Siswa -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">1. Identitas & Biodata Pribadi</h3>
                    <p class="text-xs text-slate-500">Informasi identitas resmi sesuai KTP / Paspor</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nomor Induk Siswa (NIS) *</label>
                    <input type="text" name="nis" value="{{ old('nis', $student->nis ?? 'SJI-' . date('Y') . '-' . rand(100, 999)) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-mono font-bold focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5 sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nama Lengkap (Sesuai KTP) *</label>
                    <input type="text" name="name" value="{{ old('name', $student->name) }}" required placeholder="Contoh: Rian Hidayat" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-bold focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nama Katakana / Romaji</label>
                    <input type="text" name="japanese_name" value="{{ old('japanese_name', $student->japanese_name) }}" placeholder="Contoh: リアン・ヒダヤット" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-japanese focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nomor NIK (KTP)</label>
                    <input type="text" name="nik" value="{{ old('nik', $student->nik) }}" placeholder="16 digit NIK" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-mono">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Jenis Kelamin *</label>
                    <select name="gender" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
                        <option value="Laki-laki" {{ old('gender', $student->gender) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $student->gender) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nomor WhatsApp / HP *</label>
                    <input type="text" name="phone" value="{{ old('phone', $student->phone) }}" placeholder="081234567890" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Email</label>
                    <input type="email" name="email" value="{{ old('email', $student->email) }}" placeholder="email@gmail.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Pendidikan Terakhir</label>
                    <input type="text" name="education" value="{{ old('education', $student->education) }}" placeholder="SMK / SMA / D3 / S1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Tempat Lahir</label>
                    <input type="text" name="birth_place" value="{{ old('birth_place', $student->birth_place) }}" placeholder="Kota Kelahiran" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $student->birth_date ? $student->birth_date->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Kota Domisili</label>
                    <input type="text" name="city" value="{{ old('city', $student->city) }}" placeholder="Bandung, Cilacap, dll" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5 sm:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Alamat Lengkap KTP</label>
                    <textarea name="address" rows="2" placeholder="Nama jalan, RT/RW, Kelurahan, Kecamatan, Kabupaten/Kota" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">{{ old('address', $student->address) }}</textarea>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nama Kontak Darurat / Ortu</label>
                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $student->emergency_contact_name) }}" placeholder="Nama Ayah / Ibu / Wali" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">No. HP Kontak Darurat</label>
                    <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $student->emergency_contact_phone) }}" placeholder="081299998888" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>
            </div>
        </div>

        <!-- Card 2: Pelatihan, Penempatan Jepang & Sertifikasi -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="plane" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">2. Pelatihan, Penempatan & Sertifikasi Jepang</h3>
                    <p class="text-xs text-slate-500">Program karir, data perusahaan penempatan (Kaisha), sertifikat, dan paspor</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Program Karir *</label>
                    <select name="program" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
                        <option value="Tokutei Ginou (SSW)" {{ old('program', $student->program) === 'Tokutei Ginou (SSW)' ? 'selected' : '' }}>Tokutei Ginou (SSW)</option>
                        <option value="Ginou Jisshusei (Magang)" {{ old('program', $student->program) === 'Ginou Jisshusei (Magang)' ? 'selected' : '' }}>Ginou Jisshusei (Magang)</option>
                        <option value="Engineer & Profesional" {{ old('program', $student->program) === 'Engineer & Profesional' ? 'selected' : '' }}>Engineer & Profesional</option>
                        <option value="Kursus Bahasa Jepang" {{ old('program', $student->program) === 'Kursus Bahasa Jepang' ? 'selected' : '' }}>Kursus Bahasa Jepang</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Sektor / Bidang Kerja</label>
                    <input type="text" name="sector" value="{{ old('sector', $student->sector) }}" placeholder="Kaigo, Food Processing, Manufaktur, dll" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Angkatan / Gelombang</label>
                    <input type="text" name="batch" value="{{ old('batch', $student->batch) }}" placeholder="Contoh: Angkatan 42" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Tanggal Masuk Belajar</label>
                    <input type="date" name="entry_date" value="{{ old('entry_date', $student->entry_date ? $student->entry_date->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Tanggal / Target Terbang</label>
                    <input type="date" name="departure_date" value="{{ old('departure_date', $student->departure_date ? $student->departure_date->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Status Siswa *</label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
                        <option value="active" {{ old('status', $student->status) === 'active' ? 'selected' : '' }}>Aktif Belajar di LPK</option>
                        <option value="interview" {{ old('status', $student->status) === 'interview' ? 'selected' : '' }}>Tahap Interview User Kaisha</option>
                        <option value="passed_interview" {{ old('status', $student->status) === 'passed_interview' ? 'selected' : '' }}>Lolos Wawancara (Proses CoE/Visa)</option>
                        <option value="departed" {{ old('status', $student->status) === 'departed' ? 'selected' : '' }}>Sudah Berada di Jepang</option>
                        <option value="graduated" {{ old('status', $student->status) === 'graduated' ? 'selected' : '' }}>Alumni / Selesai Kontrak</option>
                        <option value="dropout" {{ old('status', $student->status) === 'dropout' ? 'selected' : '' }}>Keluar / Mengundurkan Diri</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Perusahaan Penempatan (Kaisha)</label>
                    <input type="text" name="destination_company" value="{{ old('destination_company', $student->destination_company) }}" placeholder="Contoh: Nichirei Foods Inc." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Prefektur / Kota di Jepang</label>
                    <input type="text" name="destination_prefecture" value="{{ old('destination_prefecture', $student->destination_prefecture) }}" placeholder="Tokyo, Osaka, Chiba, Aichi, dll" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Level Bahasa Jepang</label>
                    <input type="text" name="japanese_level" value="{{ old('japanese_level', $student->japanese_level) }}" placeholder="JLPT N4 / JFT-Basic A2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Sertifikat Keterampilan SSW</label>
                    <input type="text" name="ssw_certificate" value="{{ old('ssw_certificate', $student->ssw_certificate) }}" placeholder="Contoh: SSW Pengolahan Makanan (Lulus)" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nomor Paspor</label>
                    <input type="text" name="passport_number" value="{{ old('passport_number', $student->passport_number) }}" placeholder="Contoh: C1234567" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-mono">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Masa Berlaku Paspor</label>
                    <input type="date" name="passport_expiry" value="{{ old('passport_expiry', $student->passport_expiry ? $student->passport_expiry->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>
            </div>
        </div>

        <!-- Card 3: Keuangan & Skema Pembayaran -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">3. Keuangan, Biaya & Tanggungan Siswa</h3>
                    <p class="text-xs text-slate-500">Pencatatan total biaya, jumlah terbayar, dan sisa tanggungan</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Total Biaya Program (IDR) *</label>
                    <input type="number" name="total_cost" value="{{ old('total_cost', $student->total_cost ?? 25000000) }}" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-black focus:outline-none focus:border-emerald-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Jumlah Terbayar (IDR) *</label>
                    <input type="number" name="paid_amount" value="{{ old('paid_amount', $student->paid_amount ?? 0) }}" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-black text-emerald-600 focus:outline-none focus:border-emerald-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Skema Pembiayaan *</label>
                    <select name="payment_scheme" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
                        <option value="mandiri" {{ old('payment_scheme', $student->payment_scheme) === 'mandiri' ? 'selected' : '' }}>Mandiri (Tunai / Transfer)</option>
                        <option value="talangan" {{ old('payment_scheme', $student->payment_scheme) === 'talangan' ? 'selected' : '' }}>Skema Dana Talangan LPK</option>
                        <option value="beasiswa" {{ old('payment_scheme', $student->payment_scheme) === 'beasiswa' ? 'selected' : '' }}>Beasiswa Penuh / Subsidi</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Status Pelunasan</label>
                    <select name="payment_status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
                        <option value="unpaid" {{ old('payment_status', $student->payment_status) === 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="partial" {{ old('payment_status', $student->payment_status) === 'partial' ? 'selected' : '' }}>Cicilan / Belum Lunas</option>
                        <option value="paid" {{ old('payment_status', $student->payment_status) === 'paid' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>

                <div class="space-y-1.5 sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Catatan Pembayaran & Termin</label>
                    <input type="text" name="payment_notes" value="{{ old('payment_notes', $student->payment_notes) }}" placeholder="Contoh: DP 10 Juta terbayar, sisa 15 Juta jatuh tempo sebelum terbang..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>
            </div>
        </div>

        <!-- Card 4: Pasfoto Siswa (Base64 LONGTEXT) & Catatan Sensei -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="image" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">4. Pasfoto & Catatan Khusus Sensei / Admin</h3>
                    <p class="text-xs text-slate-500">Pasfoto 3x4 latar merah (tersimpan Base64 di database)</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-start">
                
                <!-- Photo Preview -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col items-center justify-center text-center space-y-2">
                    <div class="w-24 h-32 rounded-xl bg-slate-200 border border-slate-300 overflow-hidden flex items-center justify-center">
                        @if($student->photo)
                            <img id="studentPhotoPreview" src="{{ $student->photo }}" alt="{{ $student->name }}" class="w-full h-full object-cover">
                        @else
                            <img id="studentPhotoPreview" src="" alt="Preview Foto" class="w-full h-full object-cover hidden">
                            <span id="noPhotoText" class="text-[11px] text-slate-400 font-bold">Pasfoto 3x4</span>
                        @endif
                    </div>
                    <span class="text-[10px] text-slate-400">Latar Merah Formal</span>
                </div>

                <div class="space-y-4 sm:col-span-2">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase">Upload Pasfoto Siswa (Base64)</label>
                        <input 
                            type="file" 
                            name="photo_file" 
                            accept="image/*" 
                            onchange="previewStudentPhoto(this)"
                            class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:outline-none focus:border-japan-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-japan-600 file:text-white hover:file:bg-japan-700 cursor-pointer"
                        >
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase">Atau URL Foto Siswa</label>
                        <input type="text" name="photo" value="{{ old('photo', $student->photo) }}" placeholder="https://..." class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase">Catatan Evaluasi Sensei / Konselor</label>
                        <textarea name="admin_notes" rows="3" placeholder="Tuliskan catatan perkembangan belajar, kedisiplinan, atau catatan wawancara..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">{{ old('admin_notes', $student->admin_notes) }}</textarea>
                    </div>
                </div>

            </div>
        </div>

        <!-- Sticky Save Button -->
        <div class="sticky bottom-6 z-20 flex justify-end gap-3">
            <a href="{{ route('admin.students.index') }}" class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-50 shadow-sm flex items-center gap-1.5">
                Batal
            </a>
            <button type="submit" class="btn-red-primary px-8 py-3 rounded-2xl font-bold text-xs shadow-xl flex items-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>{{ $student->exists ? 'Simpan Pembaruan Siswa' : 'Daftarkan Siswa Baru' }}</span>
            </button>
        </div>

    </form>

</div>

<script>
    function previewStudentPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('studentPhotoPreview');
                const noText = document.getElementById('noPhotoText');
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
