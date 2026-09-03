@extends('admin.layouts.admin')

@section('title', 'Kalender Wawancara Kaisha & Job Matching')
@section('page_title', 'Jadwal Seleksi Wawancara Kaisha & Job Matching')

@section('content')
<div class="space-y-6">

    <!-- 1. Top KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Agenda Wawancara -->
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Agenda Wawancara</p>
                <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">{{ number_format($stats['total_interviews']) }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Seluruh sesi wawancara user</p>
        </div>

        <!-- Terjadwal Mendatang -->
        <div class="p-5 rounded-2xl bg-white border border-blue-200 shadow-xs hover:border-blue-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">Terjadwal Mendatang</p>
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-blue-600 mt-2">{{ number_format($stats['scheduled']) }}</p>
            <p class="text-[11px] text-blue-700/80 mt-0.5 font-medium">Sesi siap dilaksanakan</p>
        </div>

        <!-- Kandidat Ditugaskan -->
        <div class="p-5 rounded-2xl bg-white border border-purple-200 shadow-xs hover:border-purple-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-purple-600 uppercase tracking-wider">Kandidat Dimatching</p>
                <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                    <i data-lucide="users" class="w-4 h-4"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-purple-600 mt-2">{{ number_format($stats['total_candidates']) }}</p>
            <p class="text-[11px] text-purple-700/80 mt-0.5 font-medium">Siswa terdaftar wawancara</p>
        </div>

        <!-- Siswa Lolos Seleksi -->
        <div class="p-5 rounded-2xl bg-white border border-emerald-200 shadow-xs hover:border-emerald-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Siswa Lolos Seleksi</p>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-emerald-600 mt-2">{{ number_format($stats['passed_candidates']) }}</p>
            <p class="text-[11px] text-emerald-700/80 mt-0.5 font-medium">Siap proses CoE & Visa</p>
        </div>

    </div>

    <!-- 2. Action & Filter Bar -->
    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex flex-wrap items-center justify-between gap-4">
        
        <!-- Filter Form -->
        <form action="{{ route('admin.interviews.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
            <select name="status" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-slate-50 focus:bg-white focus:outline-none focus:border-japan-600">
                <option value="all">Semua Status</option>
                <option value="scheduled" {{ $status === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                <option value="ongoing" {{ $status === 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            <select name="sector" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-slate-50 focus:bg-white focus:outline-none focus:border-japan-600">
                <option value="all">Semua Bidang Karir</option>
                <option value="Kaigo / Caregiver" {{ $sector === 'Kaigo / Caregiver' ? 'selected' : '' }}>Kaigo / Caregiver</option>
                <option value="Pengolahan Makanan" {{ $sector === 'Pengolahan Makanan' ? 'selected' : '' }}>Pengolahan Makanan</option>
                <option value="Manufaktur Mesin" {{ $sector === 'Manufaktur Mesin' ? 'selected' : '' }}>Manufaktur Mesin</option>
                <option value="Pertanian (Nougyou)" {{ $sector === 'Pertanian (Nougyou)' ? 'selected' : '' }}>Pertanian (Nougyou)</option>
                <option value="Konstruksi" {{ $sector === 'Konstruksi' ? 'selected' : '' }}>Konstruksi</option>
                <option value="Perhotelan" {{ $sector === 'Perhotelan' ? 'selected' : '' }}>Perhotelan</option>
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                Filter
            </button>

            @if($status !== 'all' || $sector !== 'all')
                <a href="{{ route('admin.interviews.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold" title="Reset Filter">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                </a>
            @endif
        </form>

        <!-- Tambah Jadwal Wawancara Button -->
        <button 
            type="button" 
            onclick="openModal('addInterviewModal')" 
            class="btn-red-primary px-4 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5"
        >
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Jadwalkan Wawancara Kaisha</span>
        </button>

    </div>

    <!-- 3. List of Interviews Cards & Candidates -->
    <div class="space-y-4">
        @forelse($interviews as $interview)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden hover:border-slate-300 transition">
                
                <!-- Card Header -->
                <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-japan-50 text-japan-600 flex items-center justify-center font-japanese font-black text-xl flex-shrink-0 border border-red-100">
                            会
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="text-base font-black text-slate-900 leading-tight">
                                    {{ $interview->company_name }}
                                </h3>
                                @if($interview->japanese_company_name)
                                    <span class="text-xs text-japan-600 font-japanese font-bold">
                                        ({{ $interview->japanese_company_name }})
                                    </span>
                                @endif
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $interview->status_badge['bg'] }}">
                                    {{ $interview->status_badge['label'] }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1 flex items-center gap-3 flex-wrap">
                                <span class="inline-flex items-center gap-1 font-semibold text-slate-700">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-japan-600"></i>
                                    {{ $interview->prefecture }}
                                </span>
                                <span>•</span>
                                <span class="inline-flex items-center gap-1 font-semibold text-slate-700">
                                    <i data-lucide="briefcase" class="w-3.5 h-3.5 text-slate-400"></i>
                                    {{ $interview->sector }}
                                </span>
                                <span>•</span>
                                <span class="inline-flex items-center gap-1 font-semibold text-emerald-600">
                                    <i data-lucide="banknote" class="w-3.5 h-3.5"></i>
                                    {{ $interview->salary_range ?: 'Standar UMR Prefektur' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Interview Date & Actions -->
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <div class="text-right">
                            <p class="text-xs font-black text-slate-900">
                                {{ $interview->interview_date->format('d M Y, H:i') }} WIB
                            </p>
                            <p class="text-[11px] text-japan-600 font-bold">
                                {{ $interview->interview_date->addHours(2)->format('H:i') }} Waktu Jepang (JST)
                            </p>
                        </div>

                        <!-- Add Candidate Button -->
                        <button 
                            type="button" 
                            onclick="openAssignCandidatesModal({{ $interview->id }}, '{{ addslashes($interview->company_name) }}')"
                            class="px-3 py-1.5 rounded-xl border border-blue-200 bg-blue-50 text-blue-800 text-xs font-bold hover:bg-blue-100 transition flex items-center gap-1"
                            title="Tugaskan Siswa ke Wawancara ini"
                        >
                            <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                            <span>Matching Siswa</span>
                        </button>

                        <!-- Delete button -->
                        <form action="{{ route('admin.interviews.destroy', $interview->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus agenda wawancara ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus Agenda">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Online Link / Location details -->
                @if($interview->meeting_link)
                    <div class="px-6 py-2.5 bg-blue-50/50 border-b border-blue-100/60 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2 text-blue-900">
                            <i data-lucide="video" class="w-4 h-4 text-blue-600"></i>
                            <span class="font-bold">Link Zoom / Google Meet:</span>
                            <a href="{{ $interview->meeting_link }}" target="_blank" class="text-blue-600 underline font-mono truncate max-w-md">{{ $interview->meeting_link }}</a>
                            @if($interview->meeting_passcode)
                                <span class="bg-blue-100 px-2 py-0.5 rounded text-[11px] font-mono font-bold">Passcode: {{ $interview->meeting_passcode }}</span>
                            @endif
                        </div>
                        <span class="text-slate-500 text-[11px]">Kuota Dibutuhkan: <b class="text-slate-900">{{ $interview->quota_needed }} Siswa</b></span>
                    </div>
                @endif

                <!-- Candidates Table Inside Card -->
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Kandidat Siswa Peserta Wawancara ({{ $interview->candidates->count() }} Terdaftar)
                        </h4>
                    </div>

                    @if($interview->candidates->count() > 0)
                        <div class="overflow-x-auto rounded-2xl border border-slate-100">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] uppercase font-bold">
                                        <th class="py-2.5 px-4">Nama Siswa</th>
                                        <th class="py-2.5 px-4">Level Bahasa</th>
                                        <th class="py-2.5 px-4">Hasil Seleksi</th>
                                        <th class="py-2.5 px-4">Nilai / Skor</th>
                                        <th class="py-2.5 px-4">Catatan Pewawancara</th>
                                        <th class="py-2.5 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($interview->candidates as $cand)
                                        <tr class="hover:bg-slate-50/80 transition">
                                            <td class="py-3 px-4">
                                                <div class="font-bold text-slate-900">{{ $cand->student->name ?? 'Siswa Terhapus' }}</div>
                                                <div class="text-[10px] text-slate-400 font-mono">NIS: {{ $cand->student->nis ?? '-' }} • {{ $cand->student->phone ?? '-' }}</div>
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="px-2 py-0.5 rounded bg-slate-100 font-bold text-slate-700 text-[11px]">
                                                    {{ $cand->student->japanese_level ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $cand->result_badge['bg'] }}">
                                                    {{ $cand->result_badge['label'] }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 font-bold text-slate-700 font-mono">
                                                {{ $cand->interview_score ? $cand->interview_score . ' / 100' : '-' }}
                                            </td>
                                            <td class="py-3 px-4 text-slate-500 text-[11px] max-w-xs truncate">
                                                {{ $cand->interviewer_feedback ?: '-' }}
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <button 
                                                    type="button" 
                                                    onclick="openResultModal({{ $interview->id }}, {{ $cand->student_id }}, '{{ addslashes($cand->student->name ?? '') }}', '{{ $cand->result }}', '{{ $cand->interview_score }}', '{{ addslashes($cand->interviewer_feedback ?? '') }}')"
                                                    class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] transition"
                                                >
                                                    Update Hasil
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-6 text-center rounded-2xl bg-slate-50 border border-dashed border-slate-200">
                            <p class="text-xs text-slate-400">Belum ada kandidat siswa yang ditugaskan ke wawancara ini.</p>
                            <button 
                                type="button" 
                                onclick="openAssignCandidatesModal({{ $interview->id }}, '{{ addslashes($interview->company_name) }}')"
                                class="mt-2 text-xs font-bold text-japan-600 hover:underline"
                            >
                                + Pilih dan Matching Siswa Sekarang
                            </button>
                        </div>
                    @endif
                </div>

            </div>
        @empty
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-xs space-y-3">
                <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                    <i data-lucide="calendar-x" class="w-8 h-8"></i>
                </div>
                <h4 class="text-base font-bold text-slate-900">Belum Ada Agenda Wawancara</h4>
                <p class="text-xs text-slate-400 max-w-md mx-auto">
                    Buat jadwal wawancara kerja baru bersama User Perusahaan Jepang (Kaisha) untuk siswa yang siap seleksi.
                </p>
                <button 
                    type="button" 
                    onclick="openModal('addInterviewModal')" 
                    class="btn-red-primary px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center gap-1.5 mt-2"
                >
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Buat Jadwal Baru</span>
                </button>
            </div>
        @endforelse

        @if($interviews->hasPages())
            <div class="pt-4">
                {{ $interviews->links() }}
            </div>
        @endif
    </div>

</div>

<!-- ==============================================================
     MODAL 1: TAMBAH JADWAL WAWANCARA BARU
     ============================================================== -->
<div id="addInterviewModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-6 max-h-[90vh] overflow-y-auto">
        
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="calendar-plus" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900">Buat Jadwal Wawancara Kaisha</h3>
                    <p class="text-xs text-slate-400">Jadwal seleksi user perusahaan Jepang</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('addInterviewModal')" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('admin.interviews.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <!-- Nama Perusahaan -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Nama Perusahaan (Kaisha) <span class="text-rose-500">*</span></label>
                    <input type="text" name="company_name" required placeholder="Contoh: Yamato Care Service Co., Ltd." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-semibold text-slate-900">
                </div>

                <!-- Nama Katakana -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Nama Kanji / Katakana</label>
                    <input type="text" name="japanese_company_name" placeholder="Contoh: ヤマトケアサービス株式会社" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-japanese focus:outline-none focus:border-japan-600">
                </div>

                <!-- Prefektur -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Prefektur Penempatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="prefecture" required placeholder="Contoh: Tokyo, Aichi, Osaka" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-semibold">
                </div>

                <!-- Bidang / Sektor -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Bidang Karir <span class="text-rose-500">*</span></label>
                    <select name="sector" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                        <option value="Kaigo / Caregiver">Kaigo / Caregiver (Perawat Lansia)</option>
                        <option value="Pengolahan Makanan">Pengolahan Makanan (Food Processing)</option>
                        <option value="Manufaktur Mesin">Manufaktur Mesin & Logam</option>
                        <option value="Pertanian (Nougyou)">Pertanian (Nougyou)</option>
                        <option value="Konstruksi">Konstruksi</option>
                        <option value="Perhotelan">Perhotelan (Hospitality)</option>
                        <option value="Restoran & F&B">Restoran & Pelayanan Makanan</option>
                    </select>
                </div>

                <!-- Tanggal & Jam Wawancara -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Waktu Wawancara (WIB) <span class="text-rose-500">*</span></label>
                    <input type="datetime-local" name="interview_date" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-semibold">
                </div>

                <!-- Tipe Lokasi -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Tipe Pelaksanaan <span class="text-rose-500">*</span></label>
                    <select name="location_type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                        <option value="online">Online (Zoom / Google Meet)</option>
                        <option value="offline">Offline (Tatap Muka di Kampus SJI)</option>
                    </select>
                </div>

                <!-- Link Meeting -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Tautan Zoom / Meeting</label>
                    <input type="url" name="meeting_link" placeholder="https://zoom.us/j/..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>

                <!-- Passcode -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Passcode Meeting</label>
                    <input type="text" name="meeting_passcode" placeholder="Passcode (Opsional)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-mono">
                </div>

                <!-- Kuota Dibutuhkan -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Kuota Siswa Diterima <span class="text-rose-500">*</span></label>
                    <input type="number" name="quota_needed" value="2" min="1" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-bold">
                </div>

                <!-- Estimasi Gaji -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Estimasi Gaji Bulanan</label>
                    <input type="text" name="salary_range" placeholder="Contoh: ¥190,000 - ¥220,000" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 font-semibold text-emerald-600">
                </div>

                <input type="hidden" name="status" value="scheduled">
            </div>

            <!-- Pilih Kandidat Siswa Awal -->
            <div class="space-y-1 pt-2 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-700">Tugaskan Siswa Awal (Matching)</label>
                <div class="max-h-36 overflow-y-auto rounded-xl border border-slate-200 p-2 space-y-1.5 bg-slate-50">
                    @forelse($availableStudents as $stu)
                        <label class="flex items-center gap-2 text-xs p-1.5 rounded-lg hover:bg-white transition cursor-pointer">
                            <input type="checkbox" name="student_ids[]" value="{{ $stu->id }}" class="rounded text-japan-600 focus:ring-0">
                            <span class="font-bold text-slate-900">{{ $stu->name }}</span>
                            <span class="text-[10px] text-slate-400">({{ $stu->japanese_level ?: 'Dasar' }} • {{ $stu->program }})</span>
                        </label>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-2">Belum ada siswa berstatus aktif.</p>
                    @endforelse
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('addInterviewModal')" class="px-4 py-2 rounded-xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="btn-red-primary px-5 py-2 rounded-xl text-xs font-bold shadow-md">
                    Simpan Jadwal Wawancara
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ==============================================================
     MODAL 2: TUGASKAN / MATCHING KANDIDAT SISWA
     ============================================================== -->
<div id="assignCandidatesModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-5">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <h3 class="text-base font-black text-slate-900">Matching Kandidat Siswa</h3>
                <p class="text-xs text-slate-400" id="assignInterviewTitle">Pilih siswa aktif untuk sesi wawancara</p>
            </div>
            <button type="button" onclick="closeModal('assignCandidatesModal')" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="assignCandidatesForm" action="" method="POST" class="space-y-4">
            @csrf

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Daftar Siswa Aktif Siap Seleksi:</label>
                <div class="max-h-60 overflow-y-auto rounded-xl border border-slate-200 p-2 space-y-1.5 bg-slate-50">
                    @forelse($availableStudents as $stu)
                        <label class="flex items-center gap-2.5 text-xs p-2 rounded-lg hover:bg-white transition cursor-pointer border border-transparent hover:border-slate-200">
                            <input type="checkbox" name="student_ids[]" value="{{ $stu->id }}" class="rounded text-japan-600 focus:ring-0">
                            <div>
                                <span class="font-bold text-slate-900 block">{{ $stu->name }}</span>
                                <span class="text-[10px] text-slate-400">NIS: {{ $stu->nis }} • {{ $stu->japanese_level ?: '-' }} • {{ $stu->program }}</span>
                            </div>
                        </label>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Tidak ada data siswa aktif.</p>
                    @endforelse
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('assignCandidatesModal')" class="px-4 py-2 rounded-xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="btn-red-primary px-5 py-2 rounded-xl text-xs font-bold shadow-md">
                    Tugaskan Siswa Terpilih
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==============================================================
     MODAL 3: UPDATE HASIL KELULUSAN SELEKSI SISWA
     ============================================================== -->
<div id="resultModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 space-y-5">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <h3 class="text-base font-black text-slate-900">Update Hasil Seleksi Siswa</h3>
                <p class="text-xs text-slate-400" id="resultStudentName">Nama Siswa</p>
            </div>
            <button type="button" onclick="closeModal('resultModal')" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="resultForm" action="" method="POST" class="space-y-4">
            @csrf

            <!-- Status Kelulusan -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Keputusan Hasil Wawancara <span class="text-rose-500">*</span></label>
                <select id="resultSelect" name="result" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-japan-600">
                    <option value="pending">🟡 Menunggu Hasil Pewawancara</option>
                    <option value="passed">🟢 Lolos Seleksi (Passed) ➔ Otomatis Update Status Siswa</option>
                    <option value="failed">🔴 Belum Lolos (Failed)</option>
                    <option value="rescheduled">🟣 Jadwal Ulang (Rescheduled)</option>
                </select>
            </div>

            <!-- Skor Nilai Wawancara -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Nilai Skor Pewawancara (0 - 100)</label>
                <input type="number" step="0.1" min="0" max="100" id="scoreInput" name="interview_score" placeholder="Contoh: 85.5" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 font-mono focus:outline-none focus:border-japan-600">
            </div>

            <!-- Feedback / Catatan -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Catatan & Masukan User Kaisha</label>
                <textarea id="feedbackText" name="interviewer_feedback" rows="3" placeholder="Catatan kaiwa, sikap sopan santun (aisatsu), ketrampilan..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('resultModal')" class="px-4 py-2 rounded-xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="btn-red-primary px-5 py-2 rounded-xl text-xs font-bold shadow-md">
                    Simpan Hasil Seleksi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAssignCandidatesModal(interviewId, companyName) {
        document.getElementById('assignInterviewTitle').textContent = 'Wawancara dengan ' + companyName;
        document.getElementById('assignCandidatesForm').action = '/admin/interviews/' + interviewId + '/candidates';
        openModal('assignCandidatesModal');
    }

    function openResultModal(interviewId, studentId, studentName, currentResult, currentScore, currentFeedback) {
        document.getElementById('resultStudentName').textContent = studentName;
        document.getElementById('resultSelect').value = currentResult || 'pending';
        document.getElementById('scoreInput').value = currentScore || '';
        document.getElementById('feedbackText').value = currentFeedback || '';
        document.getElementById('resultForm').action = '/admin/interviews/' + interviewId + '/candidates/' + studentId;
        openModal('resultModal');
    }
</script>
@endsection
