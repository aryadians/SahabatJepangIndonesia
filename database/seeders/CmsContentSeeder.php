<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class CmsContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Site Settings (General, Hero, Contact, Stats, Footer)
        $settings = [
            // General & Brand
            ['key' => 'site_name', 'value' => 'LPK Sahabat Jepang Indonesia', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => '友好日本インドネシア • Penyalur Resmi RI', 'group' => 'general'],
            ['key' => 'announcement_badge', 'value' => 'Batch Baru 2026 Dibuka', 'group' => 'general'],
            ['key' => 'announcement_text', 'value' => '🌸 Pendaftaran Gelombang Khusus Tokutei Ginou & Magang Jepang Telah Dibuka! Kuota Terbatas.', 'group' => 'general'],
            
            // Hero Section
            ['key' => 'hero_motto', 'value' => 'LPK & SO Resmi Kemenaker RI', 'group' => 'hero'],
            ['key' => 'hero_title_1', 'value' => 'Jembatan Emas Menuju', 'group' => 'hero'],
            ['key' => 'hero_title_highlight', 'value' => 'Karir Gemilang di Jepang', 'group' => 'hero'],
            ['key' => 'hero_subtitle', 'value' => 'Wujudkan impian berpenghasilan Rp 18 - 35 Juta/bulan di Jepang. Program Tokutei Ginou (SSW) & Magang Resmi dengan bimbingan bahasa intensif dari nol, asrama representatif, hingga penempatan kerja terpercaya di seluruh prefektur Jepang.', 'group' => 'hero'],
            ['key' => 'hero_image', 'value' => 'https://images.unsplash.com/photo-1528164344705-475426879c0d?auto=format&fit=crop&w=900&q=80', 'group' => 'hero'],
            
            // Stats Counters
            ['key' => 'stat_alumni_count', 'value' => '500', 'group' => 'stats'],
            ['key' => 'stat_alumni_suffix', 'value' => '+', 'group' => 'stats'],
            ['key' => 'stat_partners_count', 'value' => '50', 'group' => 'stats'],
            ['key' => 'stat_partners_suffix', 'value' => '+', 'group' => 'stats'],
            ['key' => 'stat_pass_rate_count', 'value' => '98', 'group' => 'stats'],
            ['key' => 'stat_pass_rate_suffix', 'value' => '%', 'group' => 'stats'],
            ['key' => 'stat_legal_count', 'value' => '100', 'group' => 'stats'],
            ['key' => 'stat_legal_suffix', 'value' => '%', 'group' => 'stats'],

            // Contact & Footer
            ['key' => 'contact_phone', 'value' => '+62 812-3456-7890 / (021) 7890-1234', 'group' => 'contact'],
            ['key' => 'contact_whatsapp', 'value' => '6281234567890', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'info@sahabatjepangindonesia.com', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Jl. Sakura Raya No. 88, Kawasan Pendidikan & Pelatihan Karir Jepang, Jakarta', 'group' => 'contact'],
            ['key' => 'contact_hours', 'value' => 'Senin - Sabtu: 08.00 - 17.00 WIB', 'group' => 'contact'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // 2. Programs Catalog
        $programs = [
            [
                'slug' => 'tokutei-ginou-ssw',
                'title' => 'Tokutei Ginou (SSW)',
                'subtitle' => 'Pekerja Berketerampilan Khusus (Specified Skilled Worker)',
                'badge' => 'Paling Populer',
                'badge_color' => 'bg-red-600 text-white',
                'icon' => 'briefcase',
                'japanese_title' => '特定技能',
                'salary_yen' => '¥ 180.000 - ¥ 260.000',
                'salary_idr' => 'Rp 19.000.000 - Rp 27.500.000 / bln',
                'duration' => 'Kontrak hingga 5 Tahun (Bisa Diperpanjang/Bawa Keluarga)',
                'description' => 'Program resmi pemerintah Jepang untuk tenaga kerja terampil di berbagai sektor industri vital dengan standar gaji setara pekerja lokal Jepang.',
                'sectors' => [
                    'Kaigo (Caregiver / Perawat Lansia)',
                    'Pengolahan Makanan & Minuman',
                    'Pertanian & Peternakan Modern',
                    'Perhotelan & Restoran (Hospitality)',
                    'Manufaktur & Permesinan',
                    'Konstruksi & Infrastruktur'
                ],
                'requirements' => [
                    'Usia 18 - 35 Tahun',
                    'Minimal Lulusan SMA/SMK Sederajat (Semua Jurusan)',
                    'Sertifikat Bahasa Jepang JLPT N4 / JFT-Basic A2',
                    'Sertifikat Skill Test Bidang Terkait (Senmonkyu / SSW Test)',
                    'Sehat Jasmani & Rohani, Tidak Bertato Besar & Buta Warna Total'
                ],
                'benefits' => [
                    'Gaji Pokok Standar Jepang + Lembur (Overtime)',
                    'Asuransi Kesehatan, Hari Tua, & Ketenagakerjaan Penuh',
                    'Fasilitas Tempat Tinggal / Asrama Bersubsidi',
                    'Peluang Perubahan Status ke SSW 2 (Bisa Bawa Keluarga & Tinggal Permanen)'
                ],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'slug' => 'ginou-jisshusei-magang',
                'title' => 'Ginou Jisshusei (Magang Kerja)',
                'subtitle' => 'Program Magang Praktik Kerja Industri Resmi Jepang',
                'badge' => 'Pemula Friendly',
                'badge_color' => 'bg-emerald-600 text-white',
                'icon' => 'graduation-cap',
                'japanese_title' => '技能実習生',
                'salary_yen' => '¥ 150.000 - ¥ 200.000',
                'salary_idr' => 'Rp 15.800.000 - Rp 21.000.000 / bln',
                'duration' => 'Kontrak 3 Tahun s/d 5 Tahun',
                'description' => 'Program transfer teknologi dan peningkatan keterampilan kerja secara langsung di industri manufaktur, pertanian, dan konstruksi di Jepang.',
                'sectors' => [
                    'Pabrik & Manufaktur Otomotif',
                    'Teknik Pengelasan & Logam (Welding)',
                    'Pertanian & Perkebunan Sayur/Buah',
                    'Konstruksi Bangunan & Scaffolding',
                    'Pengepakan & Logistik Industri'
                ],
                'requirements' => [
                    'Usia 18 - 26 Tahun',
                    'Lulusan SMA/SMK/D3/S1',
                    'Pendidikan Bahasa Jepang di LPK Sahabat Jepang Indonesia (Level N5 - N4)',
                    'Lulus Tes Fisik, Mental, dan Wawancara (Mensetsu)',
                    'Tidak Bertato, Tidak Bertindik (Pria), Mata Minus Maks. Toleransi'
                ],
                'benefits' => [
                    'Uang Saku / Gaji Bulanan + Uang Lembur',
                    'Uang Nenkin (Pengembalian Dana Pensiun) setelah Selesai Kontrak (Rp 30jt - 60jt)',
                    'Sertifikat Resmi JITCO / OTIT Jepang',
                    'Jalur Emas Melanjutkan ke Program Tokutei Ginou setelah Lulus'
                ],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'slug' => 'kursus-intensif-bahasa',
                'title' => 'Kursus Intensif Bahasa & Budaya',
                'subtitle' => 'Persiapan JLPT N5, N4, N3 & JFT-Basic Bersertifikat',
                'badge' => 'Akselerasi Cepat',
                'badge_color' => 'bg-amber-600 text-white',
                'icon' => 'book-open',
                'japanese_title' => '日本語研修',
                'salary_yen' => 'Garansi Kelulusan Ujian',
                'salary_idr' => 'Persiapan Karir & Studi',
                'duration' => '3 Bulan - 6 Bulan (Kelas Tatap Muka & Online)',
                'description' => 'Kurikulum terstandar Native Speaker Jepang, berfokus pada penguasaan Kaiwa (percakapan kerja), kanji, tata bahasa, dan budaya kerja Jepang (Hou-Ren-So, 5S).',
                'sectors' => [
                    'Kelas Pemula (Dasar Huruf Hiragana, Katakana, N5)',
                    'Kelas Menengah (JLPT N4 & JFT-Basic A2)',
                    'Kelas Lanjutan (JLPT N3 & Kaiwa Bisnis)',
                    'Bimbingan Khusus Mensetsu (Simulasi Interview User Jepang)'
                ],
                'requirements' => [
                    'Terbuka untuk Umum / Pelajar / Mahasiswa / Calon Pekerja',
                    'Komitmen Mengikuti Jam Belajar Intensif',
                    'Disiplin Waktu dan Etika Belajar yang Baik'
                ],
                'benefits' => [
                    'Modul Eksklusif & Bank Soal Simulasi Ujian Komprehensif',
                    'Pengajar Berpengalaman Bersertifikat N1/N2 & Native Speaker Jepang',
                    'Gratis Konsultasi Minat Karir dan Penyaluran ke Program Kerja',
                    'Ruang Kelas Nyaman, AC, Audio Visual Multimedia'
                ],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'slug' => 'engineer-professional',
                'title' => 'Engineer & Professional Career',
                'subtitle' => 'Tenaga Ahli & Profesional Bidang IT, Mekanikal, Elektro',
                'badge' => 'High Salary',
                'badge_color' => 'bg-indigo-600 text-white',
                'icon' => 'cpu',
                'japanese_title' => '技術・人文知識',
                'salary_yen' => '¥ 220.000 - ¥ 380.000+',
                'salary_idr' => 'Rp 23.000.000 - Rp 40.000.000+ / bln',
                'duration' => 'Visa Kerja Profesional (Bisa Menetap Permanen)',
                'description' => 'Jalur karir prestisius untuk lulusan Diploma (D3) dan Sarjana (S1) bidang Teknik dan IT untuk bekerja sebagai engineer di perusahaan teknologi & manufaktur terkemuka Jepang.',
                'sectors' => [
                    'Software Engineer & IT Support',
                    'Mechanical & Electrical Engineering',
                    'CAD Drafter & Civil Construction Design',
                    'Quality Control & Factory Automation'
                ],
                'requirements' => [
                    'Lulusan D3 / S1 Jurusan Teknik (IT, Elektro, Mesin, Sipil)',
                    'Kemampuan Bahasa Jepang Minimal JLPT N3 / N2 (atau N4 dengan portofolio kuat)',
                    'Portofolio Teknis / Pengalaman Kerja Relevan'
                ],
                'benefits' => [
                    'Gaji dan Jenjang Karir Setara Karyawan Tetap (Seishain) Jepang',
                    'Fasilitas Bawa Keluarga (Spouse Visa)',
                    'Tiket Pesawat & Relokasi Ditanggung Perusahaan',
                    'Peluang Mendapatkan Hak Tinggal Permanen (Permanent Residence)'
                ],
                'order' => 4,
                'is_active' => true,
            ]
        ];

        foreach ($programs as $prog) {
            Program::updateOrCreate(['slug' => $prog['slug']], $prog);
        }

        // 3. Facilities
        $facilities = [
            [
                'title' => 'Ruang Kelas Multimedia Ber-AC',
                'category' => 'Pembelajaran',
                'description' => 'Ruang belajar modern dengan proyektor interaktif, audio sound system untuk latihan listening Choukai, dan meja ergonomis.',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=800&q=80',
                'order' => 1
            ],
            [
                'title' => 'Asrama Calon Siswa (Dormitory)',
                'category' => 'Akomodasi',
                'description' => 'Fasilitas asrama bersih, nyaman, aman 24 jam dengan loker pribadi, area ibadah, wifi cepat, dan dapur bersama.',
                'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80',
                'order' => 2
            ],
            [
                'title' => 'Ruang Simulasi Wawancara Jepang (Mensetsu Room)',
                'category' => 'Simulasi Kerja',
                'description' => 'Ruangan khusus berstandar etika bisnis Jepang (Ojigi, Aisatsu, Hou-Ren-So) untuk latihan wawancara user via video conference.',
                'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80',
                'order' => 3
            ],
            [
                'title' => 'Laboratorium Komputer & JFT/SSW CBT Center',
                'category' => 'Ujian & Sertifikasi',
                'description' => 'Fasilitas komputer modern dengan simulasi ujian CBT (Computer Based Test) resmi JFT-Basic dan Skill Test.',
                'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=800&q=80',
                'order' => 4
            ],
            [
                'title' => 'Area Latihan Fisik & Kedisiplinan (Taishou)',
                'category' => 'Kebugaran',
                'description' => 'Lapangan olahraga terbuka untuk senam pagi Radio Taiso, pembinaan ketahanan fisik (Tairyoku), dan pembentukan karakter.',
                'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800&q=80',
                'order' => 5
            ],
            [
                'title' => 'Kantin Bersih & Ruang Santai Budaya Jepang',
                'category' => 'Sosialisasi',
                'description' => 'Area santai dengan ornamen khas Jepang, buku komik/manga kanji, dan fasilitas makan sehat bergizi.',
                'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=800&q=80',
                'order' => 6
            ]
        ];

        foreach ($facilities as $fac) {
            Facility::updateOrCreate(['title' => $fac['title']], $fac);
        }

        // 4. Testimonials
        $testimonials = [
            [
                'name' => 'Ahmad Rizky Pratama',
                'origin' => 'Surabaya, Jawa Timur',
                'prefecture' => 'Tokyo / 東京都',
                'program' => 'Tokutei Ginou - Food Industry',
                'company' => 'Tokyo Foods Co., Ltd.',
                'salary' => '¥ 220.000 / bln (± Rp 23,5 Juta)',
                'quote' => 'Alhamdulillah berkat bimbingan intensif dari LPK Sahabat Jepang Indonesia, saya berhasil lolos interview sekali coba. Sekarang sudah 1,5 tahun bekerja di Tokyo. Pelatihan bahasa dan mentalnya sangat membantu adaptasi!',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80',
                'tag' => 'Alumni 2024',
                'order' => 1
            ],
            [
                'name' => 'Siti Nur Aisyah',
                'origin' => 'Bandung, Jawa Barat',
                'prefecture' => 'Osaka / 大阪府',
                'program' => 'Tokutei Ginou - Kaigo (Caregiver)',
                'company' => 'Kansai Social Welfare Foundation',
                'salary' => '¥ 240.000 / bln (± Rp 25,5 Juta)',
                'quote' => 'Dulu sempat ragu karena basic bahasa jepang nol. Di SJI sensei-nya sangat sabar mengajarkan dari hiragana sampai lulus JFT A2 dan skill test Kaigo. Pendampingan saat tiba di Kansai Airport juga luar biasa hangat.',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=80',
                'tag' => 'Alumni 2024',
                'order' => 2
            ],
            [
                'name' => 'Bagus Setiawan',
                'origin' => 'Semarang, Jawa Tengah',
                'prefecture' => 'Aichi / 愛知県',
                'program' => 'Ginou Jisshusei - Automotive Parts',
                'company' => 'Aichi Precision Auto Corp',
                'salary' => '¥ 185.000 / bln (± Rp 19,5 Juta)',
                'quote' => 'Biaya di SJI sangat transparan, tanpa pungutan liar. Fasilitas asrama selama pelatihan sangat bersih dan disiplin tinggi. Tiap bulan bisa kirim uang 12-15 juta ke orang tua di kampung.',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80',
                'tag' => 'Alumni 2025',
                'order' => 3
            ],
            [
                'name' => 'Dimas Arya Nugraha',
                'origin' => 'Yogyakarta',
                'prefecture' => 'Fukuoka / 福岡県',
                'program' => 'Engineer - Mechanical CAD',
                'company' => 'Kyushu Tech Design Co.',
                'salary' => '¥ 280.000 / bln (± Rp 29,8 Juta)',
                'quote' => 'Sebagai lulusan D3 Teknik Mesin, program Engineer di SJI membuka jalan karir internasional saya. Dibantu dari matching portofolio hingga pengurusan COE & visa kerja. Sangat profesional!',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80',
                'tag' => 'Alumni 2025',
                'order' => 4
            ]
        ];

        foreach ($testimonials as $testi) {
            Testimonial::updateOrCreate(['name' => $testi['name']], $testi);
        }

        // 5. FAQs
        $faqs = [
            [
                'question' => 'Apakah LPK Sahabat Jepang Indonesia memiliki izin resmi Sending Organization (SO)?',
                'answer' => 'Ya, 100% resmi dan terverifikasi. LPK Sahabat Jepang Indonesia telah terdaftar resmi di Kementerian Ketenagakerjaan Republik Indonesia (Kemenaker RI) dengan izin Sending Organization (SO) dan Akreditasi LPK, sehingga seluruh proses penempatan kerja di Jepang dijamin aman, legal, dan terlindungi undang-undang.',
                'order' => 1
            ],
            [
                'question' => 'Berapa batas usia dan syarat pendidikan minimal untuk mendaftar?',
                'answer' => 'Untuk program Tokutei Ginou (SSW) dan Magang (Ginou Jisshusei), usia minimal 18 tahun dan maksimal 35 tahun dengan pendidikan minimal lulusan SMA/SMK sederajat semua jurusan. Untuk program Engineer, minimal lulusan D3/S1 jurusan Teknik atau IT.',
                'order' => 2
            ],
            [
                'question' => 'Apakah yang belum bisa Bahasa Jepang sama sekali bisa mendaftar?',
                'answer' => 'Sangat bisa! 90% calon peserta kami memulai dari tingkat nol (belum tahu huruf Hiragana/Katakana). Kami menyediakan program pelatihan intensif bahasa dan budaya Jepang dari dasar dengan metode cepat dan interaktif hingga siap ujian kelulusan JLPT/JFT.',
                'order' => 3
            ],
            [
                'question' => 'Apakah ada sistem dana talangan atau kemudahan pembiayaan pelatihan?',
                'answer' => 'Ya, kami bekerja sama dengan lembaga keuangan mitra terpercaya untuk menyediakan opsi skema pembiayaan bertahap dan program dana talangan proses keberangkatan sehingga tidak memberatkan calon peserta dan keluarga.',
                'order' => 4
            ],
            [
                'question' => 'Bagaimana jika memiliki mata minus atau bekas luka/tato?',
                'answer' => 'Mata minus umumnya diperbolehkan dengan bantuan kacamata/softlens (kecuali bidang tertentu yang melarang buta warna total). Untuk tato, selama berada di area tertutup dan bersedia mematuhi aturan standar kaisha/pemberi kerja Jepang, silakan konsultasikan terlebih dahulu dengan tim konselor kami.',
                'order' => 5
            ],
            [
                'question' => 'Berapa lama waktu yang dibutuhkan dari daftar sampai terbang ke Jepang?',
                'answer' => 'Rata-rata waktu proses adalah 4 hingga 7 bulan, meliputi: Pelatihan Bahasa (2-3 bulan), Wawancara Perusahaan (Mensetsu), Pengurusan Dokumen Eligibility (COE) dari Imigrasi Jepang (2-3 bulan), Pembuatan Visa Kerja, dan Keberangkatan.',
                'order' => 6
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], $faq);
        }

        // 6. Partners
        $partners = [
            ['name' => 'Tokyo Foods Industry Co., Ltd.', 'prefecture' => '東京都', 'category' => 'Kaisha', 'order' => 1],
            ['name' => 'Kansai Social Welfare Caregiver', 'prefecture' => '大阪府', 'category' => 'Kaisha', 'order' => 2],
            ['name' => 'Aichi Precision Automotive Corp', 'prefecture' => '愛知県', 'category' => 'Kaisha', 'order' => 3],
            ['name' => 'Kyushu Tech Design & Engineering', 'prefecture' => '福岡県', 'category' => 'Kaisha', 'order' => 4],
            ['name' => 'Hokkaido Modern Agri Farm', 'prefecture' => '北海道', 'category' => 'Kaisha', 'order' => 5],
            ['name' => 'Yokohama Logistics & Packaging', 'prefecture' => '神奈川県', 'category' => 'Kaisha', 'order' => 6],
        ];

        foreach ($partners as $partner) {
            Partner::updateOrCreate(['name' => $partner['name']], $partner);
        }
    }
}
