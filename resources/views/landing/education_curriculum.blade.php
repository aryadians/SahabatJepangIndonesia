@extends('layouts.app')

@section('title', 'Kurikulum & Edukasi Terpadu • PT SAHABAT JEPANG INDONESIA GROUP (SJI Group)')
@section('meta_description', 'Kurikulum komprehensif bahasa Jepang, alur 4 tingkatan pelatihan, tenaga pengajar native sensei, lab praktik kerja autentik, dan jadwal kedisiplinan asrama PT Sahabat Jepang Indonesia Group.')

@section('content')
<!-- Header Hero Banner (Japanese Zen Luxury) -->
<section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white overflow-hidden pt-24 pb-20 border-b border-slate-800">
    <div class="absolute inset-0 bg-seigaiha opacity-10 pointer-events-none"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-10">
            <div class="max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-japan-600/20 border border-japan-500/40 text-red-400 text-xs font-black tracking-wider uppercase">
                    <span class="font-japanese text-sm text-red-500">教育システム</span>
                    <span>•</span>
                    <span>SJI GROUP CURRICULUM & ACADEMY</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                    Kurikulum Terpadu & Standar Pendidikan
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-red-400 via-rose-300 to-amber-300 text-2xl sm:text-3xl lg:text-4xl mt-1 font-extrabold">
                        PT SAHABAT JEPANG INDONESIA GROUP
                    </span>
                </h1>

                <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl">
                    Sistem edukasi berbasis kompetensi nyata standar industri Jepang. Mengintegrasikan kemahiran bahasa (Kotoba & Kaiwa), etos kerja profesional (Hou-Ren-Sou & 5S), penguasaan kejuruan (Tokutei Ginou & Magang), serta ketangguhan mental dan fisik (Shin-Gi-Tai).
                </p>

                <!-- Fast Credentials Badges -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3">
                    <div class="p-3 rounded-2xl bg-white/5 border border-white/10 text-center">
                        <p class="text-2xl font-black text-amber-400">{{ $facultyStats['course_levels_count'] ?? ($sjiStats['course_levels_count'] ?? 4) }}</p>
                        <p class="text-[11px] text-slate-300 font-medium">Jenjang Tingkat Kelas</p>
                    </div>
                    <div class="p-3 rounded-2xl bg-white/5 border border-white/10 text-center">
                        <p class="text-2xl font-black text-rose-400">{{ $facultyStats['staff_count'] ?? ($sjiStats['staff_count'] ?? '20+') }}</p>
                        <p class="text-[11px] text-slate-300 font-medium">Instruktur Berpengalaman</p>
                    </div>
                    <div class="p-3 rounded-2xl bg-white/5 border border-white/10 text-center">
                        <p class="text-2xl font-black text-emerald-400">{{ $facultyStats['native_count'] ?? ($sjiStats['native_count'] ?? 3) }}</p>
                        <p class="text-[11px] text-slate-300 font-medium">Native Sensei Jepang</p>
                    </div>
                    <div class="p-3 rounded-2xl bg-white/5 border border-white/10 text-center">
                        <p class="text-2xl font-black text-blue-400">{{ $facultyStats['urawa_count'] ?? ($sjiStats['urawa_count'] ?? 3) }}</p>
                        <p class="text-[11px] text-slate-300 font-medium">Alumni Urawa Sensei</p>
                    </div>
                </div>
            </div>

            <!-- Quick Action Card -->
            <div class="w-full lg:w-auto flex-shrink-0 bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-6 space-y-4 max-w-sm">
                <div class="flex items-center gap-3 pb-3 border-b border-white/10">
                    <div class="w-12 h-12 rounded-2xl bg-japan-600 flex items-center justify-center font-bold text-white text-xl shadow-lg shadow-red-600/30">
                        学
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium uppercase">Sistem Akademi Vokasi</p>
                        <p class="text-sm font-extrabold text-white">SJI Nihongo Academy</p>
                    </div>
                </div>

                <div class="space-y-2.5 text-xs text-slate-300">
                    <div class="flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                        <span>Pelatihan terpusat seragam di {{ $branchStats['indonesia_count'] ?? ($sjiStats['indonesia_branches_count'] ?? 7) }} cabang SJI</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                        <span>Simulasi wawancara user oleh native sensei</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                        <span>Lab praktik autentik mesin & ranjang Kaigo</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                        <span>Asrama disiplin penuh jadwal 04.00 - 22.00</span>
                    </div>
                </div>

                <a href="{{ $corporate['whatsapp_link'] }}" target="_blank" class="w-full py-3 px-4 rounded-xl bg-japan-600 hover:bg-japan-700 text-white font-bold text-xs flex items-center justify-center gap-2 transition shadow-md shadow-red-600/20">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Konsultasi Belajar & Biaya</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Sticky Subnav Bar -->
<div class="sticky top-20 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-2xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-2 overflow-x-auto py-3 no-scrollbar select-none text-xs sm:text-sm font-bold text-slate-600">
            <div class="flex items-center gap-2">
                <a href="#roadmap" class="px-3.5 py-1.5 rounded-xl bg-red-50 text-japan-600 border border-red-200/80 hover:bg-red-100 transition flex items-center gap-1.5 whitespace-nowrap">
                    <i data-lucide="git-merge" class="w-4 h-4"></i>
                    <span>Alur 4 Jenjang</span>
                </a>
                <a href="#faculty" class="px-3.5 py-1.5 rounded-xl hover:bg-slate-100 hover:text-slate-900 transition flex items-center gap-1.5 whitespace-nowrap">
                    <i data-lucide="users" class="w-4 h-4 text-japan-600"></i>
                    <span>Sensei & Tenaga Pengajar</span>
                </a>
                <a href="#facilities" class="px-3.5 py-1.5 rounded-xl hover:bg-slate-100 hover:text-slate-900 transition flex items-center gap-1.5 whitespace-nowrap">
                    <i data-lucide="building-2" class="w-4 h-4 text-blue-600"></i>
                    <span>Lab Praktik & Asrama</span>
                </a>
                <a href="#schedule" class="px-3.5 py-1.5 rounded-xl hover:bg-slate-100 hover:text-slate-900 transition flex items-center gap-1.5 whitespace-nowrap">
                    <i data-lucide="clock" class="w-4 h-4 text-purple-600"></i>
                    <span>Jadwal Harian Siswa</span>
                </a>
                <a href="#mou" class="px-3.5 py-1.5 rounded-xl hover:bg-slate-100 hover:text-slate-900 transition flex items-center gap-1.5 whitespace-nowrap">
                    <i data-lucide="file-check-2" class="w-4 h-4 text-emerald-600"></i>
                    <span>MoU SMK & Poltekkes</span>
                </a>
            </div>
            
            <a href="{{ route('company.profile') }}" class="flex-shrink-0 inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 transition font-bold border border-slate-200 whitespace-nowrap">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Profil Korporasi SJI Group</span>
            </a>
        </div>
    </div>
</div>

<main class="space-y-20 py-12 bg-slate-50">

    <!-- 1. 4-Tier Language & Skills Roadmap -->
    <section id="roadmap" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-36">
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-12">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-100 text-japan-700 text-xs font-black uppercase tracking-wider font-japanese">
                <span>段階別カリキュラム • 4-Tier Learning Roadmap</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                Alur Pendidikan Berjenjang Standar Industri Jepang
            </h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Pendidikan di SJI Group dirancang bertahap dan terukur. Siswa dibimbing dari nol hingga mampu berkomunikasi lancar dan menguasai terminologi teknis di tempat kerja Jepang.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($levels as $index => $level)
                <div class="bg-white rounded-3xl p-6 border-2 border-slate-200/90 shadow-sm hover:shadow-md hover:border-japan-400 transition flex flex-col justify-between group">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="w-9 h-9 rounded-2xl bg-japan-50 group-hover:bg-japan-600 text-japan-600 group-hover:text-white transition font-black text-sm flex items-center justify-center shadow-xs">
                                0{{ $index + 1 }}
                            </span>
                            <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 text-[10px] font-extrabold uppercase">
                                {{ $level['badge'] }}
                            </span>
                        </div>

                        <div>
                            <p class="text-xs font-mono font-black text-japan-600 uppercase tracking-wide">{{ $level['code'] }}</p>
                            <h3 class="text-base font-black text-slate-900 mt-0.5 leading-snug">{{ $level['name'] }}</h3>
                            <p class="text-xs text-slate-400 font-semibold mt-1 flex items-center gap-1.5">
                                <i data-lucide="clock-4" class="w-3.5 h-3.5 text-slate-400"></i>
                                <span>Durasi: {{ $level['period'] }}</span>
                            </p>
                        </div>

                        <p class="text-xs text-slate-600 leading-relaxed pt-2 border-t border-slate-100">
                            {{ $level['focus'] }}
                        </p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs text-japan-600 font-bold">
                        <span>Standar Kelulusan SJI</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 2. Faculty, Native Sensei & Urawa Alumni -->
    <section id="faculty" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-36">
        <div class="bg-gradient-to-br from-slate-900 via-slate-950 to-slate-900 text-white rounded-3xl p-8 sm:p-12 border border-slate-800 shadow-xl space-y-10">
            
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-600/30 border border-red-500/40 text-red-300 text-xs font-black uppercase tracking-wider font-japanese">
                    <span>指導陣・講師紹介 • Faculty & Sensei</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Tenaga Pendidik Berpengalaman & Native Speakers
                </h2>
                <p class="text-xs sm:text-sm text-slate-300">
                    Kualitas alumni SJI Group bermula dari keteladanan instruktur. Kami menghadirkan kombinasi tenaga pengajar penutur asli (native) dari Jepang dan instruktur Indonesia bersertifikasi Urawa Center.
                </p>
            </div>

            <!-- 3 Key Pillars of Faculty Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Pillar 1 -->
                <div class="bg-white/5 backdrop-blur-md rounded-3xl p-6 border border-white/10 space-y-4 hover:bg-white/10 transition">
                    <div class="w-12 h-12 rounded-2xl bg-rose-500/20 border border-rose-400/40 flex items-center justify-center text-rose-300 text-xl font-black">
                        {{ $facultyStats['native_count'] }}
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white">Native Sensei Asli Jepang</h3>
                        <p class="text-xs text-rose-300 font-japanese mt-0.5">日本人ネイティブ講師</p>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Instruktur asli Jepang mengajar secara langsung pelafalan intonasi alami, melatih mental berbicara tanpa rasa takut, dan memimpin simulasi wawancara user perusahaan penerima.
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="bg-white/5 backdrop-blur-md rounded-3xl p-6 border border-white/10 space-y-4 hover:bg-white/10 transition">
                    <div class="w-12 h-12 rounded-2xl bg-blue-500/20 border border-blue-400/40 flex items-center justify-center text-blue-300 text-xl font-black">
                        {{ $facultyStats['urawa_count'] ?? ($sjiStats['urawa_count'] ?? 3) }}
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white">Alumni Urawa Center Sensei</h3>
                        <p class="text-xs text-blue-300 font-japanese mt-0.5">浦和日本語国際センター修了</p>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Sebanyak {{ $facultyStats['urawa_count'] ?? ($sjiStats['urawa_count'] ?? 3) }} sensei kami telah menyelesaikan pelatihan metodologi pengajaran bahasa Jepang intensif di The Japan Foundation Japanese-Language Institute, Urawa, Saitama, Jepang.
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="bg-white/5 backdrop-blur-md rounded-3xl p-6 border border-white/10 space-y-4 hover:bg-white/10 transition">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 border border-emerald-400/40 flex items-center justify-center text-emerald-300 text-xl font-black">
                        {{ $facultyStats['staff_count'] ?? ($sjiStats['staff_count'] ?? '20+') }}
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white">Staf & Instruktur Bersertifikasi</h3>
                        <p class="text-xs text-emerald-300 font-japanese mt-0.5">経験豊富な専門指導陣</p>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Didukung {{ $facultyStats['staff_count'] ?? ($sjiStats['staff_count'] ?? '20+') }} instruktur berpengalaman JLPT N2/N1, alumni mantan pemagang berprestasi (ex-kenshusei), serta pembina kedisiplinan dan instruktur kejuruan praktik kerja.
                    </p>
                </div>
            </div>

            <!-- Philosophy Shin-Gi-Tai -->
            <div class="p-6 sm:p-8 rounded-2xl bg-white/5 border border-white/10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center md:text-left">
                    <span class="text-xs text-amber-400 font-bold uppercase tracking-widest font-japanese">SJI 教育理念 • Educational Philosophy</span>
                    <h4 class="text-lg font-black text-white">Konsep Pembinaan: Shin (心), Gi (技), Tai (体)</h4>
                    <p class="text-xs text-slate-300 max-w-2xl leading-relaxed">
                        Keseimbangan antara <strong>Hati & Akhlak (Shin)</strong> berupa kejujuran dan etika kerja, <strong>Keterampilan & Bahasa (Gi)</strong> yang aplikatif di lapangan, serta <strong>Kesehatan & Ketahanan Fisik (Tai)</strong> yang prima untuk menghadapi lingkungan 4 musim Jepang.
                    </p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0 text-2xl font-japanese font-black text-amber-400 bg-amber-400/10 px-5 py-3 rounded-2xl border border-amber-400/30">
                    <span>心</span>
                    <span>•</span>
                    <span>技</span>
                    <span>•</span>
                    <span>体</span>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. Workshop Labs & Facilities -->
    <section id="facilities" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-36">
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-12">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-black uppercase tracking-wider font-japanese">
                <span>実習設備・寮 • Facilities & Workshop Labs</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                Fasilitas Laboratorium & Asrama Terpadu
            </h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Pendidikan komprehensif tidak hanya berlangsung di dalam kelas. Kami menyediakan bengkel autentik dengan peralatan industri riil agar siswa tidak canggung saat menginjakkan kaki di pabrik dan panti Jepang.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($facilities as $facility)
                <div class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-lg transition flex flex-col group">
                    <div class="h-48 overflow-hidden relative bg-slate-900">
                        <img src="{{ $facility['image'] }}" alt="{{ $facility['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white">
                            <span class="px-2.5 py-1 rounded-xl bg-japan-600/90 text-[10px] font-bold uppercase backdrop-blur-md">
                                Standar Industri Jepang
                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="text-base font-black text-slate-900">{{ $facility['title'] }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                {{ $facility['desc'] }}
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-japan-600">
                            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-500"></i>
                            <span>Tersedia di Kampus Utama SJI</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 4. Daily Schedule (04:00 - 22:00) -->
    <section id="schedule" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-36">
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-10">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-purple-50 border border-purple-200 text-purple-700 text-xs font-black uppercase tracking-wider font-japanese">
                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                <span>一日のスケジュール • Daily Routine</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                Jadwal Kedisiplinan Harian Siswa (04.00 - 22.00)
            </h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Pola hidup teratur melatih kemandirian, etos kerja, dan stamina yang dibutuhkan untuk sukses bekerja di iklim empat musim Jepang.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Weekday Routine (Hari Kerja: Senin - Jumat) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-red-100 text-japan-600 flex items-center justify-center font-bold">
                            <i data-lucide="sun" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-base">Jadwal Hari Kerja (Weekday)</h3>
                            <p class="text-xs text-slate-500 font-japanese">平日スケジュール (Senin s/d Jumat)</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-red-50 text-japan-700 text-[10px] font-black uppercase">Intensif</span>
                </div>

                <div class="space-y-4">
                    @foreach($schedules['weekday'] as $item)
                        <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-slate-50 transition border border-transparent hover:border-slate-200">
                            <div class="flex-shrink-0 text-center w-20">
                                <span class="text-xs font-mono font-black text-slate-900 bg-slate-100 px-2 py-1 rounded-lg block">
                                    {{ $item['time'] }}
                                </span>
                            </div>
                            <div class="space-y-0.5 flex-1">
                                <p class="text-xs sm:text-sm font-extrabold text-slate-900 flex items-center gap-2">
                                    <span>{{ $item['title'] }}</span>
                                    <span class="text-[10px] font-japanese text-japan-600 font-bold">({{ $item['title_jp'] }})</span>
                                </p>
                                <p class="text-xs text-slate-500">{{ $item['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Weekend Routine (Akhir Pekan: Sabtu - Minggu) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                            <i data-lucide="coffee" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-base">Jadwal Akhir Pekan (Weekend)</h3>
                            <p class="text-xs text-slate-500 font-japanese">週末スケジュール (Sabtu & Minggu)</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-[10px] font-black uppercase">Kaiwa & Praktik</span>
                </div>

                <div class="space-y-4">
                    @foreach($schedules['weekend'] as $item)
                        <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-slate-50 transition border border-transparent hover:border-slate-200">
                            <div class="flex-shrink-0 text-center w-20">
                                <span class="text-xs font-mono font-black text-slate-900 bg-slate-100 px-2 py-1 rounded-lg block">
                                    {{ $item['time'] }}
                                </span>
                            </div>
                            <div class="space-y-0.5 flex-1">
                                <p class="text-xs sm:text-sm font-extrabold text-slate-900 flex items-center gap-2">
                                    <span>{{ $item['title'] }}</span>
                                    <span class="text-[10px] font-japanese text-blue-600 font-bold">({{ $item['title_jp'] }})</span>
                                </p>
                                <p class="text-xs text-slate-500">{{ $item['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- 5. MoU SMK & Poltekkes Kemenkes RI -->
    <section id="mou" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-36">
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm space-y-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-slate-100">
                <div class="space-y-2 max-w-2xl">
                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider font-japanese">
                        産学連携 • Institutional Partnerships
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Kemitraan Strategis: SMK & Poltekkes Kemenkes RI
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500">
                        SJI Group menjalin nota kesepahaman (MoU) resmi dengan berbagai Sekolah Menengah Kejuruan (SMK) dan Politeknik Kesehatan Kementerian Kesehatan RI di berbagai provinsi.
                    </p>
                </div>

                <div class="flex-shrink-0">
                    <div class="px-4 py-2.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                        <span>Program Penyaluran Kerja Legal</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Poltekkes Kaigo -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold">
                            <i data-lucide="heart-pulse" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">Poltekkes Kemenkes RI (Keperawatan Lansia)</h3>
                            <p class="text-xs text-slate-500">Program Perawat Lansia (Kaigo Tokutei Ginou)</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Lulusan keperawatan dan kebidanan dibekali bahasa Jepang medis khusus, terminologi Kaigo, serta pemahaman budaya interaksi dengan lansia Jepang. Disalurkan langsung ke rumah sakit dan panti sosial terkemuka di Jepang.
                    </p>
                </div>

                <!-- SMK Teknik & Manufaktur -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                            <i data-lucide="wrench" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">SMK Kejuruan Teknik & Otomotif</h3>
                            <p class="text-xs text-slate-500">Program Manufaktur, Konstruksi & Otomotif</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Kerjasama link-and-match kurikulum SMK dengan kebutuhan pabrik industri Jepang. Lulusan SMK langsung memasuki kelas pemantapan bahasa sebelum diterbangkan ke prefektur tujuan di Jepang.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom CTA Card -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <div class="bg-gradient-to-r from-japan-700 via-japan-600 to-rose-600 rounded-3xl p-8 sm:p-12 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-3 max-w-xl text-center md:text-left">
                <span class="px-3 py-1 rounded-full bg-white/20 text-white text-xs font-black uppercase tracking-wider font-japanese">
                    SJI GROUP • AKADEMI VOKASI JEPANG
                </span>
                <h2 class="text-2xl sm:text-3xl font-black">Tertarik Belajar & Berangkat Bersama SJI Group?</h2>
                <p class="text-xs sm:text-sm text-red-100 leading-relaxed">
                    Daftarkan dirimu sekarang di salah satu dari {{ $branchStats['indonesia_count'] ?? ($sjiStats['indonesia_branches_count'] ?? 7) }} cabang SJI Group terdekat atau konsultasikan persyaratan melalui WhatsApp resmi.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto flex-shrink-0">
                <a href="{{ $corporate['whatsapp_link'] }}" target="_blank" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-white hover:bg-slate-100 text-japan-700 font-extrabold text-xs sm:text-sm transition flex items-center justify-center gap-2 shadow-lg">
                    <i data-lucide="message-circle" class="w-4 h-4 text-emerald-600"></i>
                    <span>Konsultasi CS WhatsApp</span>
                </a>
                <a href="{{ route('company.profile') }}#network" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-japan-800/60 hover:bg-japan-900 text-white font-extrabold text-xs sm:text-sm transition flex items-center justify-center gap-2 border border-white/20">
                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                    <span>Lihat {{ $branchStats['indonesia_count'] ?? ($sjiStats['indonesia_branches_count'] ?? 7) }} Cabang Indonesia</span>
                </a>
            </div>
        </div>
    </section>

</main>
@endsection
