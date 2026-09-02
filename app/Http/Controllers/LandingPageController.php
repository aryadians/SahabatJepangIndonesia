<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LandingPageController extends Controller
{
    /**
     * Tampilkan Halaman Utama Landing Page
     */
    public function index()
    {
        $programs = [
            [
                'id' => 'ssw',
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
                ]
            ],
            [
                'id' => 'magang',
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
                ]
            ],
            [
                'id' => 'kursus',
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
                ]
            ],
            [
                'id' => 'engineer',
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
                ]
            ]
        ];

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
                'tag' => 'Alumni 2024'
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
                'tag' => 'Alumni 2024'
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
                'tag' => 'Alumni 2025'
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
                'tag' => 'Alumni 2025'
            ]
        ];

        $faqs = [
            [
                'q' => 'Apakah LPK Sahabat Jepang Indonesia memiliki izin resmi Sending Organization (SO)?',
                'a' => 'Ya, 100% resmi dan terverifikasi. LPK Sahabat Jepang Indonesia telah terdaftar resmi di Kementerian Ketenagakerjaan Republik Indonesia (Kemenaker RI) dengan izin Sending Organization (SO) dan Akreditasi LPK, sehingga seluruh proses penempatan kerja di Jepang dijamin aman, legal, dan terlindungi undang-undang.'
            ],
            [
                'q' => 'Berapa batas usia dan syarat pendidikan minimal untuk mendaftar?',
                'a' => 'Untuk program Tokutei Ginou (SSW) dan Magang (Ginou Jisshusei), usia minimal 18 tahun dan maksimal 35 tahun dengan pendidikan minimal lulusan SMA/SMK sederajat semua jurusan. Untuk program Engineer, minimal lulusan D3/S1 jurusan Teknik atau IT.'
            ],
            [
                'q' => 'Apakah yang belum bisa Bahasa Jepang sama sekali bisa mendaftar?',
                'a' => 'Sangat bisa! 90% calon peserta kami memulai dari tingkat nol (belum tahu huruf Hiragana/Katakana). Kami menyediakan program pelatihan intensif bahasa dan budaya Jepang dari dasar dengan metode cepat dan interaktif hingga siap ujian kelulusan JLPT/JFT.'
            ],
            [
                'q' => 'Apakah ada sistem dana talangan atau kemudahan pembiayaan pelatihan?',
                'a' => 'Ya, kami bekerja sama dengan lembaga keuangan mitra terpercaya untuk menyediakan opsi skema pembiayaan bertahap dan program dana talangan proses keberangkatan sehingga tidak memberatkan calon peserta dan keluarga.'
            ],
            [
                'q' => 'Bagaimana jika memiliki mata minus atau bekas luka/tato?',
                'a' => 'Mata minus umumnya diperbolehkan dengan bantuan kacamata/softlens (kecuali bidang tertentu yang melarang buta warna total). Untuk tato, selama berada di area tertutup dan bersedia mematuhi aturan standar kaisha/pemberi kerja Jepang, silakan konsultasikan terlebih dahulu dengan tim konselor kami.'
            ],
            [
                'q' => 'Berapa lama waktu yang dibutuhkan dari daftar sampai terbang ke Jepang?',
                'a' => 'Rata-rata waktu proses adalah 4 hingga 7 bulan, meliputi: Pelatihan Bahasa (2-3 bulan), Wawancara Perusahaan (Mensetsu), Pengurusan Dokumen Eligibility (COE) dari Imigrasi Jepang (2-3 bulan), Pembuatan Visa Kerja, dan Keberangkatan.'
            ]
        ];

        $facilities = [
            [
                'title' => 'Ruang Kelas Multimedia Ber-AC',
                'category' => 'Pembelajaran',
                'description' => 'Ruang belajar modern dengan proyektor interaktif, audio sound system untuk latihan listening Choukai, dan meja ergonomis.',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'Asrama Calon Siswa (Dormitory)',
                'category' => 'Akomodasi',
                'description' => 'Fasilitas asrama bersih, nyaman, aman 24 jam dengan loker pribadi, area ibadah, wifi cepat, dan dapur bersama.',
                'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'Ruang Simulasi Wawancara Jepang (Mensetsu Room)',
                'category' => 'Simulasi Kerja',
                'description' => 'Ruangan khusus berstandar etika bisnis Jepang (Ojigi, Aisatsu, Hou-Ren-So) untuk latihan wawancara user via video conference.',
                'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'Laboratorium Komputer & JFT/SSW CBT Center',
                'category' => 'Ujian & Sertifikasi',
                'description' => 'Fasilitas komputer modern dengan simulasi ujian CBT (Computer Based Test) resmi JFT-Basic dan Skill Test.',
                'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'Area Latihan Fisik & Kedisiplinan (Taishou)',
                'category' => 'Kebugaran',
                'description' => 'Lapangan olahraga terbuka untuk senam pagi Radio Taiso, pembinaan ketahanan fisik (Tairyoku), dan pembentukan karakter.',
                'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'Kantin Bersih & Ruang Santai Budaya Jepang',
                'category' => 'Sosialisasi',
                'description' => 'Area santai dengan ornamen khas Jepang, buku komik/manga kanji, dan fasilitas makan sehat bergizi.',
                'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=800&q=80'
            ]
        ];

        return view('landing.index', compact('programs', 'testimonials', 'faqs', 'facilities'));
    }

    /**
     * Simpan Formulir Konsultasi & Pendaftaran Calon Siswa
     */
    public function storeConsultation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'age' => 'nullable|integer|min:16|max:50',
            'education' => 'nullable|string|max:100',
            'program' => 'required|string|max:150',
            'city' => 'nullable|string|max:150',
            'message' => 'nullable|string|max:1000',
        ]);

        try {
            $consultation = Consultation::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'age' => $validated['age'] ?? null,
                'education' => $validated['education'] ?? null,
                'program' => $validated['program'],
                'city' => $validated['city'] ?? null,
                'message' => $validated['message'] ?? null,
                'status' => 'pending'
            ]);

            // Format WhatsApp URL untuk direct follow up
            $cleanPhone = preg_replace('/[^0-9]/', '', $validated['phone']);
            $waMessage = urlencode("Halo Admin LPK Sahabat Jepang Indonesia, saya sudah mengisi form konsultasi di website.\n\nNama: {$validated['name']}\nUmur: " . ($validated['age'] ?? '-') . " Tahun\nPendidikan: " . ($validated['education'] ?? '-') . "\nProgram Minat: {$validated['program']}\nKota Asal: " . ($validated['city'] ?? '-') . "\n\nSaya ingin berkonsultasi mengenai proses keberangkatan ke Jepang. Terima kasih!");
            $waUrl = "https://api.whatsapp.com/send?phone=6281234567890&text={$waMessage}";

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Terima kasih! Data pendaftaran dan konsultasi Anda berhasil dikirim. Tim konselor kami akan segera menghubungi Anda melalui WhatsApp.',
                    'wa_url' => $waUrl,
                    'data' => $consultation
                ]);
            }

            return redirect()->route('home')->with('success', 'Pendaftaran Anda berhasil dikirim! Tim konselor kami akan segera menghubungi Anda.');
        } catch (\Exception $e) {
            Log::error('Error saving consultation: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan sistem saat menyimpan data. Silakan coba lagi atau hubungi via WhatsApp langsung.'
                ], 500);
            }

            return back()->withInput()->with('error', 'Terjadi kesalahan saat memproses data. Silakan coba lagi.');
        }
    }
}
