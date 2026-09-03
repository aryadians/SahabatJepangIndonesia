@extends('admin.layouts.admin')

@section('title', $student->exists ? 'Edit Data Siswa - ' . $student->name : 'Pendaftaran Siswa Baru')
@section('page_title', $student->exists ? 'Edit Data Siswa' : 'Pendaftaran Siswa Baru')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Top Header Bar -->
    <div class="flex items-center justify-between bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <a 
                href="{{ route('admin.students.index') }}" 
                class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition"
                title="Kembali ke Daftar Siswa"
            >
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="text-base font-black text-slate-900 leading-tight">
                    {{ $student->exists ? 'Edit Data Siswa: ' . $student->name : 'Formulir Siswa Baru' }}
                </h2>
                <p class="text-xs text-slate-500">
                    {{ $student->exists ? 'NIS: ' . $student->nis . ' • Program: ' . $student->program : 'Silakan isi kelengkapan data pribadi, pelatihan, dan administrasi biaya' }}
                </p>
            </div>
        </div>

        @if($student->exists)
            <a 
                href="{{ route('admin.students.print', $student->id) }}" 
                target="_blank" 
                class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
            >
                <i data-lucide="printer" class="w-4 h-4 text-slate-600"></i>
                <span>Cetak Lembar Profil</span>
            </a>
        @endif
    </div>

    <!-- Main Form Grid (2 Columns: Left Form Cards + Right Sticky Sidebar Cards) -->
    <form action="{{ $student->exists ? route('admin.students.update', $student->id) : route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($student->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- ==========================================
                 LEFT COLUMN: CORE DATA FIELDS (8 Cols)
                 ========================================== -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- CARD 1: IDENTITAS & BIODATA PRIBADI -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-5">
                    
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-sm">1. Identitas & Biodata Pribadi</h3>
                            <p class="text-[11px] text-slate-500">Data resmi kependudukan siswa</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- NIS -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nomor Induk Siswa (NIS) <span class="text-rose-500">*</span></label>
                            <input 
                                type="text" 
                                name="nis" 
                                value="{{ old('nis', $student->nis ?? 'SJI-' . date('Y') . '-' . rand(100, 999)) }}" 
                                required 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-mono font-bold text-slate-900 bg-slate-50 focus:bg-white focus:outline-none focus:border-japan-600"
                            >
                            @error('nis') <p class="text-rose-500 text-[11px]">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nama Lengkap (Sesuai KTP) <span class="text-rose-500">*</span></label>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name', $student->name) }}" 
                                required 
                                placeholder="Contoh: Rian Hidayat" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                            @error('name') <p class="text-rose-500 text-[11px]">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nama Katakana -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nama Katakana / Romaji</label>
                            <input 
                                type="text" 
                                name="japanese_name" 
                                value="{{ old('japanese_name', $student->japanese_name) }}" 
                                placeholder="Contoh: リアン・ヒダヤット" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-japanese text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- NIK KTP -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nomor NIK (KTP)</label>
                            <input 
                                type="text" 
                                name="nik" 
                                value="{{ old('nik', $student->nik) }}" 
                                placeholder="16 digit NIK KTP" 
                                maxlength="20"
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-mono text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Jenis Kelamin <span class="text-rose-500">*</span></label>
                            <select name="gender" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                                <option value="Laki-laki" {{ old('gender', $student->gender) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki (男性)</option>
                                <option value="Perempuan" {{ old('gender', $student->gender) === 'Perempuan' ? 'selected' : '' }}>Perempuan (女性)</option>
                            </select>
                        </div>

                        <!-- WhatsApp -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nomor WhatsApp Siswa <span class="text-rose-500">*</span></label>
                            <input 
                                type="text" 
                                name="phone" 
                                value="{{ old('phone', $student->phone) }}" 
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
                                value="{{ old('email', $student->email) }}" 
                                placeholder="siswa@gmail.com" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Pendidikan Terakhir -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Pendidikan Terakhir</label>
                            <input 
                                type="text" 
                                name="education" 
                                value="{{ old('education', $student->education) }}" 
                                placeholder="SMK Mesin / SMA / D3 / S1" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Tempat Lahir -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Tempat Lahir</label>
                            <input 
                                type="text" 
                                name="birth_place" 
                                value="{{ old('birth_place', $student->birth_place) }}" 
                                placeholder="Bandung, Cilacap, dll" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Tanggal Lahir</label>
                            <input 
                                type="date" 
                                name="birth_date" 
                                value="{{ old('birth_date', $student->birth_date ? $student->birth_date->format('Y-m-d') : '') }}" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Kota Domisili -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Kota Domisili</label>
                            <input 
                                type="text" 
                                name="city" 
                                value="{{ old('city', $student->city) }}" 
                                placeholder="Bandung" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Kontak Darurat -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nama Kontak Darurat / Orang Tua</label>
                            <input 
                                type="text" 
                                name="emergency_contact_name" 
                                value="{{ old('emergency_contact_name', $student->emergency_contact_name) }}" 
                                placeholder="Ahmad (Ayah)" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- No HP Kontak Darurat -->
                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">No. WhatsApp Orang Tua / Kontak Darurat</label>
                            <input 
                                type="text" 
                                name="emergency_contact_phone" 
                                value="{{ old('emergency_contact_phone', $student->emergency_contact_phone) }}" 
                                placeholder="081298765432" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Alamat KTP -->
                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Alamat Lengkap KTP</label>
                            <textarea 
                                name="address" 
                                rows="2" 
                                placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan..." 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >{{ old('address', $student->address) }}</textarea>
                        </div>

                    </div>

                </div>

                <!-- CARD 2: PROGRAM & PENEMPATAN JEPANG -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-5">
                    
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                            <i data-lucide="plane-takeoff" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-sm">2. Program, Penempatan Kerja & Sertifikasi</h3>
                            <p class="text-[11px] text-slate-500">Program karir, kaisha di Jepang, sertifikat, dan paspor</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- Program Karir -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Program Karir <span class="text-rose-500">*</span></label>
                            <select name="program" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                                <option value="Tokutei Ginou (SSW)" {{ old('program', $student->program) === 'Tokutei Ginou (SSW)' ? 'selected' : '' }}>Tokutei Ginou (SSW)</option>
                                <option value="Ginou Jisshusei (Magang)" {{ old('program', $student->program) === 'Ginou Jisshusei (Magang)' ? 'selected' : '' }}>Ginou Jisshusei (Magang)</option>
                                <option value="Engineer & Profesional" {{ old('program', $student->program) === 'Engineer & Profesional' ? 'selected' : '' }}>Engineer & Profesional</option>
                                <option value="Kursus Bahasa Jepang" {{ old('program', $student->program) === 'Kursus Bahasa Jepang' ? 'selected' : '' }}>Kursus Bahasa Jepang</option>
                            </select>
                        </div>

                        <!-- Kategori / Jalur Pendaftaran Siswa -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Kategori / Jalur Pendaftaran</label>
                            <select name="registration_category" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                                <option value="umum" {{ old('registration_category', $student->registration_category) === 'umum' ? 'selected' : '' }}>Jalur Reguler / Umum</option>
                                <option value="kemenkes_kaigo" {{ old('registration_category', $student->registration_category) === 'kemenkes_kaigo' ? 'selected' : '' }}>Beasiswa Kemenkes RI (Kaigo / Caregiver)</option>
                                <option value="smk_go_japan" {{ old('registration_category', $student->registration_category) === 'smk_go_japan' ? 'selected' : '' }}>Program Pemerintah: SMK Go Japan</option>
                                <option value="bkk_smk" {{ old('registration_category', $student->registration_category) === 'bkk_smk' ? 'selected' : '' }}>Kemitraan BKK SMK</option>
                                <option value="poltekkes_kampus" {{ old('registration_category', $student->registration_category) === 'poltekkes_kampus' ? 'selected' : '' }}>Kemitraan Poltekkes / STIKes</option>
                            </select>
                        </div>

                        <!-- Sektor Kerja -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Sektor / Bidang Pekerjaan</label>
                            <input 
                                type="text" 
                                name="sector" 
                                value="{{ old('sector', $student->sector) }}" 
                                placeholder="Kaigo, Food Processing, Manufaktur..." 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Angkatan -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Angkatan / Gelombang</label>
                            <input 
                                type="text" 
                                name="batch" 
                                value="{{ old('batch', $student->batch) }}" 
                                placeholder="Contoh: Angkatan 42" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Level Bahasa -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Level Bahasa Jepang</label>
                            <input 
                                type="text" 
                                name="japanese_level" 
                                value="{{ old('japanese_level', $student->japanese_level) }}" 
                                placeholder="JLPT N4 & JFT-Basic A2" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Tgl Masuk Belajar -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Tanggal Masuk Belajar</label>
                            <input 
                                type="date" 
                                name="entry_date" 
                                value="{{ old('entry_date', $student->entry_date ? $student->entry_date->format('Y-m-d') : '') }}" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Tgl Terbang -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Tanggal / Target Terbang</label>
                            <input 
                                type="date" 
                                name="departure_date" 
                                value="{{ old('departure_date', $student->departure_date ? $student->departure_date->format('Y-m-d') : '') }}" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Perusahaan Kaisha -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Perusahaan di Jepang (Kaisha)</label>
                            <input 
                                type="text" 
                                name="destination_company" 
                                value="{{ old('destination_company', $student->destination_company) }}" 
                                placeholder="Nichirei Foods Inc." 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Prefektur -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Prefektur / Kota di Jepang</label>
                            <input 
                                type="text" 
                                name="destination_prefecture" 
                                value="{{ old('destination_prefecture', $student->destination_prefecture) }}" 
                                placeholder="Tokyo, Chiba, Aichi, dll" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Sertifikat SSW -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Sertifikasi Keterampilan SSW</label>
                            <input 
                                type="text" 
                                name="ssw_certificate" 
                                value="{{ old('ssw_certificate', $student->ssw_certificate) }}" 
                                placeholder="SSW Pengolahan Makanan (Lulus)" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- No Paspor -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nomor Paspor</label>
                            <input 
                                type="text" 
                                name="passport_number" 
                                value="{{ old('passport_number', $student->passport_number) }}" 
                                placeholder="C1234567" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-mono font-bold text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                        <!-- Masa Berlaku Paspor -->
                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Masa Berlaku Paspor</label>
                            <input 
                                type="date" 
                                name="passport_expiry" 
                                value="{{ old('passport_expiry', $student->passport_expiry ? $student->passport_expiry->format('Y-m-d') : '') }}" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                    </div>

                </div>

                <!-- CARD 3: BIAYA & SKEMA PEMBAYARAN -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-5">
                    
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                            <i data-lucide="wallet" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-sm">3. Administrasi Biaya & Keuangan</h3>
                            <p class="text-[11px] text-slate-500">Nominal biaya, pembayaran, dan skema pembiayaan</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- Total Biaya Input -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Total Biaya Program (IDR) <span class="text-rose-500">*</span></label>
                            <input 
                                type="number" 
                                name="total_cost" 
                                id="formTotalCost"
                                value="{{ old('total_cost', $student->total_cost ?? 25000000) }}" 
                                required 
                                min="0"
                                oninput="recalcFinancials()"
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-black text-slate-900 focus:outline-none focus:border-emerald-600"
                            >
                        </div>

                        <!-- Sudah Terbayar Input -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Jumlah Terbayar Saat Ini (IDR) <span class="text-rose-500">*</span></label>
                            <input 
                                type="number" 
                                name="paid_amount" 
                                id="formPaidAmount"
                                value="{{ old('paid_amount', $student->paid_amount ?? 0) }}" 
                                required 
                                min="0"
                                oninput="recalcFinancials()"
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-black text-emerald-600 focus:outline-none focus:border-emerald-600"
                            >
                        </div>

                        <!-- Skema Pembayaran -->
                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Skema Pembiayaan <span class="text-rose-500">*</span></label>
                            <select name="payment_scheme" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                                <option value="mandiri" {{ old('payment_scheme', $student->payment_scheme) === 'mandiri' ? 'selected' : '' }}>Mandiri (Tunai / Transfer)</option>
                                <option value="talangan" {{ old('payment_scheme', $student->payment_scheme) === 'talangan' ? 'selected' : '' }}>Skema Dana Talangan LPK (Potong Gaji di Jepang)</option>
                                <option value="beasiswa" {{ old('payment_scheme', $student->payment_scheme) === 'beasiswa' ? 'selected' : '' }}>Beasiswa Penuh / Subsidi LPK</option>
                            </select>
                        </div>

                        <!-- Catatan Pembayaran -->
                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Catatan Termin & Bukti Pembayaran</label>
                            <input 
                                type="text" 
                                name="payment_notes" 
                                value="{{ old('payment_notes', $student->payment_notes) }}" 
                                placeholder="Contoh: DP 10 Juta via BCA tgl 2 Sept, pelunasan sebelum terbang..." 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>

                    </div>

                </div>

                <!-- CARD 4: REKAM MEDIS (MCU) & VISA / COE JEPANG -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-5">
                    
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                            <i data-lucide="activity" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-sm">4. Rekam Medikal (MCU) & Dokumen CoE / Visa</h3>
                            <p class="text-[11px] text-slate-500">Hasil medical check-up dan legalitas keberangkatan ke Jepang</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- Tanggal MCU -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Tanggal Medical Check-Up (MCU)</label>
                            <input 
                                type="date" 
                                name="mcu_date" 
                                value="{{ old('mcu_date', $student->mcu_date ? $student->mcu_date->format('Y-m-d') : '') }}" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-blue-600"
                            >
                        </div>

                        <!-- Klinik MCU -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Klinik / Laboratorium MCU</label>
                            <input 
                                type="text" 
                                name="mcu_clinic" 
                                value="{{ old('mcu_clinic', $student->mcu_clinic) }}" 
                                placeholder="Contoh: RS Medistra / Klinik Pramita" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-blue-600"
                            >
                        </div>

                        <!-- Hasil Kelayakan MCU -->
                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Hasil Kelayakan Medikal (MCU)</label>
                            <select name="mcu_result" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-600">
                                <option value="pending" {{ old('mcu_result', $student->mcu_result) === 'pending' ? 'selected' : '' }}>Menunggu Hasil / Belum Medikal (Pending)</option>
                                <option value="fit" {{ old('mcu_result', $student->mcu_result) === 'fit' ? 'selected' : '' }}>Fit (Layak Berangkat ke Jepang)</option>
                                <option value="follow_up" {{ old('mcu_result', $student->mcu_result) === 'follow_up' ? 'selected' : '' }}>Follow-up / Butuh Pengobatan Ringan</option>
                                <option value="unfit" {{ old('mcu_result', $student->mcu_result) === 'unfit' ? 'selected' : '' }}>Unfit (Tidak Lolos Medikal)</option>
                            </select>
                        </div>

                        <!-- Nomor CoE -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nomor Certificate of Eligibility (CoE)</label>
                            <input 
                                type="text" 
                                name="coe_number" 
                                value="{{ old('coe_number', $student->coe_number) }}" 
                                placeholder="COE-2026-XXXXX" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-mono text-slate-900 focus:outline-none focus:border-blue-600"
                            >
                        </div>

                        <!-- Tanggal Terbit CoE -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Tanggal Terbit CoE</label>
                            <input 
                                type="date" 
                                name="coe_date" 
                                value="{{ old('coe_date', $student->coe_date ? $student->coe_date->format('Y-m-d') : '') }}" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-blue-600"
                            >
                        </div>

                        <!-- Nomor Visa Kerja -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nomor Visa Kerja Jepang</label>
                            <input 
                                type="text" 
                                name="visa_number" 
                                value="{{ old('visa_number', $student->visa_number) }}" 
                                placeholder="VISA-JPN-XXXXX" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-mono text-slate-900 focus:outline-none focus:border-blue-600"
                            >
                        </div>

                        <!-- Masa Berlaku Visa -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Masa Berlaku Visa</label>
                            <input 
                                type="date" 
                                name="visa_expiry" 
                                value="{{ old('visa_expiry', $student->visa_expiry ? $student->visa_expiry->format('Y-m-d') : '') }}" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-blue-600"
                            >
                        </div>

                    </div>

                </div>

                <!-- CARD 5: EVALUASI AKADEMIK & KEDISIPLINAN -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-5">
                    
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                            <i data-lucide="award" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-sm">5. Evaluasi Akademik & Karakter Siswa</h3>
                            <p class="text-[11px] text-slate-500">Hasil tes berkala dan penilaian kedisiplinan selama di LPK</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        
                        <!-- Rata-rata Ujian -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Rata-rata Nilai Ujian (0-100)</label>
                            <input 
                                type="number" 
                                step="0.1" 
                                min="0" 
                                max="100" 
                                name="exam_score" 
                                value="{{ old('exam_score', $student->exam_score) }}" 
                                placeholder="85.5" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-amber-600"
                            >
                        </div>

                        <!-- Kehadiran -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Kehadiran (%)</label>
                            <input 
                                type="number" 
                                min="0" 
                                max="100" 
                                name="attendance_percentage" 
                                value="{{ old('attendance_percentage', $student->attendance_percentage ?? 100) }}" 
                                placeholder="95" 
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-amber-600"
                            >
                        </div>

                        <!-- Grade Kedisiplinan -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Grade Kedisiplinan</label>
                            <select name="discipline_grade" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-amber-600">
                                <option value="A" {{ old('discipline_grade', $student->discipline_grade) === 'A' ? 'selected' : '' }}>A - Sangat Baik (Istiqomah)</option>
                                <option value="B" {{ old('discipline_grade', $student->discipline_grade) === 'B' ? 'selected' : '' }}>B - Baik (Standar)</option>
                                <option value="C" {{ old('discipline_grade', $student->discipline_grade) === 'C' ? 'selected' : '' }}>C - Cukup (Perlu Pembinaan)</option>
                                <option value="D" {{ old('discipline_grade', $student->discipline_grade) === 'D' ? 'selected' : '' }}>D - Kurang (Peringatan)</option>
                            </select>
                        </div>

                    </div>

                </div>

                <!-- CARD 6: ARSIP DOKUMEN PRIBADI & BERKAS DIGITAL (UPLOAD FILE / GAMBAR / PDF) -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-6">
                    
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-japan-50 text-japan-600 flex items-center justify-center font-bold">
                                <i data-lucide="folder-check" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-slate-900 text-sm">6. Berkas & Dokumen Pribadi Siswa</h3>
                                <p class="text-[11px] text-slate-500">Upload scan dokumen asli (Mendukung JPG, PNG, PDF hingga 10MB)</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold flex items-center gap-1.5">
                            <i data-lucide="file-check" class="w-3.5 h-3.5 text-japan-600"></i>
                            <span>{{ $student->uploaded_documents_count ?? 0 }} / 8 Berkas</span>
                        </span>
                    </div>

                    @php
                        $docItems = [
                            ['field' => 'document_ktp', 'label' => 'Scan KTP Asli (e-KTP)', 'icon' => 'credit-card', 'desc' => 'KTP Elektronik siswa'],
                            ['field' => 'document_kk', 'label' => 'Scan Kartu Keluarga (KK)', 'icon' => 'users', 'desc' => 'Kartu keluarga terbaru'],
                            ['field' => 'document_ijazah', 'label' => 'Scan Ijazah Terakhir', 'icon' => 'graduation-cap', 'desc' => 'Ijazah SMA/SMK/D3/S1'],
                            ['field' => 'document_passport', 'label' => 'Scan Buku Paspor', 'icon' => 'book-open', 'desc' => 'Halaman identitas paspor'],
                            ['field' => 'document_certificate', 'label' => 'Sertifikat Bahasa (JLPT / JFT)', 'icon' => 'award', 'desc' => 'Sertifikat kelulusan N5/N4/JFT'],
                            ['field' => 'document_ssw', 'label' => 'Sertifikat Keahlian SSW (Skill)', 'icon' => 'badge-check', 'desc' => 'Sertifikat kelulusan bidang Tokutei'],
                            ['field' => 'document_mcu', 'label' => 'Hasil Medical Check-Up (MCU)', 'icon' => 'stethoscope', 'desc' => 'Surat sehat laboratorium'],
                            ['field' => 'document_coe_visa', 'label' => 'Dokumen CoE & Visa Kerja', 'icon' => 'file-text', 'desc' => 'Scan CoE & Lembar Visa Jepang'],
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($docItems as $doc)
                            @php
                                $val = $student->{$doc['field']};
                                $hasDoc = !empty($val);
                                $isPdf = $hasDoc && (str_contains($val, 'data:application/pdf') || str_ends_with(strtolower($val), '.pdf'));
                            @endphp
                            <div class="p-4 rounded-2xl border {{ $hasDoc ? 'border-emerald-200 bg-emerald-50/20' : 'border-slate-200 bg-slate-50/50' }} space-y-3 transition">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg {{ $hasDoc ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }} flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="{{ $doc['icon'] }}" class="w-3.5 h-3.5"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-bold text-slate-900 leading-tight">{{ $doc['label'] }}</h4>
                                            <p class="text-[10px] text-slate-400">{{ $doc['desc'] }}</p>
                                        </div>
                                    </div>
                                    @if($hasDoc)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 flex-shrink-0">
                                            Sudah Ada
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-200 text-slate-600 flex-shrink-0">
                                            Belum Ada
                                        </span>
                                    @endif
                                </div>

                                <!-- Action if document exists: Preview button -->
                                @if($hasDoc)
                                    <div class="flex items-center justify-between p-2 rounded-xl bg-white border border-slate-200 text-xs">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                            @if($isPdf)
                                                <i data-lucide="file-text" class="w-4 h-4 text-red-500 flex-shrink-0"></i>
                                                <span class="text-[11px] font-mono font-bold text-slate-700 truncate">Dokumen PDF</span>
                                            @else
                                                <i data-lucide="image" class="w-4 h-4 text-blue-500 flex-shrink-0"></i>
                                                <span class="text-[11px] font-bold text-slate-700 truncate">File Gambar</span>
                                            @endif
                                        </div>
                                        <button 
                                            type="button" 
                                            onclick="viewDocumentModal('{{ $doc['label'] }}', '{{ $val }}')" 
                                            class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-japan-50 hover:text-japan-700 text-slate-700 text-[11px] font-bold transition flex items-center gap-1"
                                        >
                                            <i data-lucide="eye" class="w-3 h-3"></i>
                                            <span>Lihat Berkas</span>
                                        </button>
                                    </div>
                                @endif

                                <!-- File Upload Input -->
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600">{{ $hasDoc ? 'Ganti File Berkas:' : 'Upload File (JPG, PNG, PDF):' }}</label>
                                    <input 
                                        type="file" 
                                        name="{{ $doc['field'] }}_file" 
                                        accept=".jpg,.jpeg,.png,.webp,.pdf"
                                        class="w-full px-2 py-1.5 rounded-xl border border-slate-200 text-[11px] bg-white focus:outline-none file:mr-2 file:py-0.5 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-slate-800 file:text-white hover:file:bg-slate-900 cursor-pointer"
                                    >
                                </div>

                                <!-- Collapsible / URL manual -->
                                <div class="pt-1">
                                    <input 
                                        type="text" 
                                        name="{{ $doc['field'] }}" 
                                        value="{{ old($doc['field'], $val) }}" 
                                        placeholder="Atau masukkan URL / Data URI..." 
                                        class="w-full px-2.5 py-1 rounded-lg border border-slate-200 text-[10px] font-mono text-slate-600 bg-white/70 focus:bg-white focus:outline-none focus:border-japan-600"
                                    >
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

            </div>

            <!-- ==========================================
                 RIGHT COLUMN: SIDEBAR WIDGETS & ACTIONS (4 Cols)
                 ========================================== -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- CARD A: PASFOTO SISWA 3x4 (Base64) -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
                    <h3 class="font-black text-slate-900 text-xs uppercase tracking-wider border-b border-slate-100 pb-2">
                        Pasfoto Resmi Siswa (3x4)
                    </h3>

                    <div class="flex flex-col items-center justify-center text-center space-y-3">
                        <div class="w-28 h-36 rounded-xl bg-slate-100 border-2 border-slate-300 overflow-hidden shadow-sm flex items-center justify-center relative">
                            @if($student->photo)
                                <img id="studentPhotoPreview" src="{{ $student->photo }}" alt="{{ $student->name }}" class="w-full h-full object-cover">
                            @else
                                <img id="studentPhotoPreview" src="" alt="Preview Foto" class="w-full h-full object-cover hidden">
                                <div id="noPhotoText" class="text-center p-2 text-slate-400">
                                    <i data-lucide="camera" class="w-6 h-6 mx-auto mb-1"></i>
                                    <span class="text-[10px] font-bold block">Pasfoto 3x4</span>
                                </div>
                            @endif
                        </div>
                        <p class="text-[10px] text-slate-400">Latar Merah Formal (Tersimpan Base64)</p>
                    </div>

                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <div class="space-y-1">
                            <label class="block text-[11px] font-bold text-slate-700">Pilih File Foto</label>
                            <input 
                                type="file" 
                                name="photo_file" 
                                accept="image/*" 
                                onchange="previewStudentPhoto(this)"
                                class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs bg-slate-50 focus:outline-none file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[11px] file:font-bold file:bg-japan-600 file:text-white hover:file:bg-japan-700 cursor-pointer"
                            >
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[11px] font-bold text-slate-700">Atau URL Foto</label>
                            <input 
                                type="text" 
                                name="photo" 
                                value="{{ old('photo', $student->photo) }}" 
                                placeholder="https://..." 
                                class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                            >
                        </div>
                    </div>
                </div>

                <!-- CARD B: STATUS SISWA & KALKULASI KEUANGAN REAL-TIME -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
                    <h3 class="font-black text-slate-900 text-xs uppercase tracking-wider border-b border-slate-100 pb-2">
                        Status & Ringkasan Keuangan
                    </h3>

                    <!-- Status Pelatihan Dropdown -->
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-slate-700">Status Pelatihan Siswa <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                            <option value="active" {{ old('status', $student->status) === 'active' ? 'selected' : '' }}>Aktif Belajar di LPK</option>
                            <option value="interview" {{ old('status', $student->status) === 'interview' ? 'selected' : '' }}>Tahap Interview Mensetsu</option>
                            <option value="passed_interview" {{ old('status', $student->status) === 'passed_interview' ? 'selected' : '' }}>Lolos Interview (CoE/Visa)</option>
                            <option value="departed" {{ old('status', $student->status) === 'departed' ? 'selected' : '' }}>Sudah di Jepang</option>
                            <option value="graduated" {{ old('status', $student->status) === 'graduated' ? 'selected' : '' }}>Alumni / Selesai Kontrak</option>
                            <option value="dropout" {{ old('status', $student->status) === 'dropout' ? 'selected' : '' }}>Keluar / DO</option>
                        </select>
                    </div>

                    <!-- Status Pembayaran Dropdown -->
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-slate-700">Status Pelunasan</label>
                        <select name="payment_status" id="formPaymentStatus" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                            <option value="unpaid" {{ old('payment_status', $student->payment_status) === 'unpaid' ? 'selected' : '' }}>Belum Bayar (Unpaid)</option>
                            <option value="partial" {{ old('payment_status', $student->payment_status) === 'partial' ? 'selected' : '' }}>Ada Tanggungan (Partial)</option>
                            <option value="paid" {{ old('payment_status', $student->payment_status) === 'paid' ? 'selected' : '' }}>Lunas Sepenuhnya (Paid)</option>
                        </select>
                    </div>

                    <!-- Live Calculation Card -->
                    <div class="p-3.5 rounded-xl bg-slate-900 text-white space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400">Total Biaya:</span>
                            <span id="liveTotalDisplay" class="font-bold text-white">Rp 0</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400">Sudah Bayar:</span>
                            <span id="livePaidDisplay" class="font-bold text-emerald-400">Rp 0</span>
                        </div>
                        <div class="pt-2 border-t border-slate-800 flex items-center justify-between text-xs">
                            <span class="text-rose-400 font-bold">Sisa Tanggungan:</span>
                            <span id="liveRemainingDisplay" class="font-black text-rose-400 text-sm">Rp 0</span>
                        </div>
                    </div>
                </div>

                <!-- CARD C: CATATAN ADMIN & TOMBOL AKSI SIMPAN -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-slate-700">Catatan Khusus Sensei / Admin</label>
                        <textarea 
                            name="admin_notes" 
                            rows="3" 
                            placeholder="Catatan perkembangan belajar atau catatan interview..." 
                            class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-japan-600"
                        >{{ old('admin_notes', $student->admin_notes) }}</textarea>
                    </div>

                    <div class="pt-2 space-y-2">
                        <button 
                            type="submit" 
                            class="w-full py-3 rounded-xl bg-japan-600 hover:bg-japan-700 text-white font-black text-xs shadow-md flex items-center justify-center gap-2 transition"
                        >
                            <i data-lucide="check" class="w-4 h-4"></i>
                            <span>{{ $student->exists ? 'Simpan Perubahan Siswa' : 'Daftarkan Siswa Baru' }}</span>
                        </button>
                        
                        <a 
                            href="{{ route('admin.students.index') }}" 
                            class="w-full py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold text-xs flex items-center justify-center transition"
                        >
                            Batal
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </form>

</div>

<!-- Document Viewer Modal (Preview Gambar & PDF) -->
<div id="docPreviewModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('docPreviewModal')"></div>
    <div class="relative w-full max-w-3xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10 flex flex-col max-h-[90vh]">
        
        <div class="bg-slate-900 text-white p-4 px-6 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <i data-lucide="file-text" class="w-5 h-5 text-japan-500"></i>
                <h3 id="docPreviewTitle" class="text-sm font-bold text-white">Preview Berkas</h3>
            </div>
            <div class="flex items-center gap-2">
                <a id="docPreviewDownloadBtn" href="#" download="Dokumen" target="_blank" class="px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition flex items-center gap-1.5">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    <span>Download</span>
                </a>
                <button onclick="closeModal('docPreviewModal')" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition">
                    &times;
                </button>
            </div>
        </div>

        <div id="docPreviewContainer" class="p-4 overflow-y-auto flex items-center justify-center min-h-[350px] bg-slate-100 flex-1">
            <!-- Dynamic Content (Image or PDF embed) -->
        </div>

    </div>
</div>

<script>
    // Live Image Preview for Student Photo
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

    // Modal Document Preview
    function viewDocumentModal(title, docUrl) {
        document.getElementById('docPreviewTitle').textContent = title;
        const downloadBtn = document.getElementById('docPreviewDownloadBtn');
        downloadBtn.href = docUrl;
        downloadBtn.download = title.replace(/[^a-zA-Z0-9]/g, '_');

        const container = document.getElementById('docPreviewContainer');
        container.innerHTML = '';

        if (!docUrl) {
            container.innerHTML = '<p class="text-slate-400 text-sm">Tidak ada berkas yang dapat ditampilkan.</p>';
        } else if (docUrl.includes('data:application/pdf') || docUrl.endsWith('.pdf')) {
            container.innerHTML = `<iframe src="${docUrl}" class="w-full h-[65vh] rounded-xl border border-slate-300 shadow-sm" frameborder="0"></iframe>`;
        } else {
            container.innerHTML = `<img src="${docUrl}" alt="${title}" class="max-w-full max-h-[70vh] rounded-xl shadow-md object-contain border border-slate-200">`;
        }

        openModal('docPreviewModal');
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    // Live Financial Calculations
    function recalcFinancials() {
        const total = parseFloat(document.getElementById('formTotalCost').value) || 0;
        const paid = parseFloat(document.getElementById('formPaidAmount').value) || 0;
        const remaining = Math.max(0, total - paid);

        document.getElementById('liveTotalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('livePaidDisplay').textContent = 'Rp ' + paid.toLocaleString('id-ID');
        document.getElementById('liveRemainingDisplay').textContent = 'Rp ' + remaining.toLocaleString('id-ID');

        const statusSelect = document.getElementById('formPaymentStatus');
        if (paid >= total && total > 0) {
            statusSelect.value = 'paid';
        } else if (paid > 0 && paid < total) {
            statusSelect.value = 'partial';
        } else {
            statusSelect.value = 'unpaid';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        recalcFinancials();
    });
</script>
@endsection
