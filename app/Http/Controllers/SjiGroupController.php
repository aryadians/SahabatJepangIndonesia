<?php

namespace App\Http\Controllers;

use App\Models\GroupBranch;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SjiGroupController extends Controller
{
    /**
     * Display the official SJI Group company profile, network of branches, and educational ecosystem.
     */
    public function index()
    {
        $settings = SiteSetting::allCached();
        $sjiStats = SiteSetting::getCorporateStats();

        $indonesiaBranches = GroupBranch::active()->ordered()->indonesia()->get();
        $japanBranches = GroupBranch::active()->ordered()->japan()->get();
        $allBranches = GroupBranch::active()->ordered()->get();

        // Corporate Leadership & Identity
        $corporate = [
            'name' => $settings['site_name'] ?? 'PT SAHABAT JEPANG INDONESIA GROUP',
            'tagline' => $settings['site_tagline'] ?? '友好日本インドネシア • SJI Group Sending Organization & Nihongo Gakkou',
            'leader_name' => $settings['corporate_leader_name'] ?? 'YOYOK WIDODO',
            'leader_title' => $settings['corporate_leader_title'] ?? 'Representative Director and Chairman',
            'leader_photo' => $settings['corporate_leader_photo'] ?? '',
            'leader_message' => $settings['corporate_leader_message'] ?? 'Our mission is to maximize the potential of individuals and organizations, and we continue to create value from a global perspective. Based on trust and a commitment to innovation, we will work together to achieve sustainable growth.',
            'vision' => $settings['corporate_vision'] ?? 'Become a leading partner in sending Indonesian talent that is honest, trustworthy, and possesses high levels of expertise. We aim to cultivate individuals who will act as "national ambassadors," promoting Indonesia\'s outstanding values in Japan and around the world.',
            'mission' => $settings['corporate_mission'] ?? "1. Promoting continuous human resource development\n2. Protection and improvement of workers' welfare\n3. Building a robust international cooperation system\n4. A firm commitment to social responsibility",
            'alumni_sent' => $sjiStats['alumni_sent'],
            'japan_offices' => 'Tokyo & Chiba',
            'mou_label' => $sjiStats['mou_label'],
            'indonesia_branches_count' => $sjiStats['indonesia_branches_count'],
            'japan_branches_count' => $sjiStats['japan_branches_count'],
            'total_branches_count' => $sjiStats['total_branches_count'],
            'social_facebook' => $settings['social_facebook'] ?? 'https://www.facebook.com/groups/1402737939919037/',
            'social_instagram' => $settings['social_instagram'] ?? 'https://www.instagram.com/pt.sjigroup/',
            'social_youtube' => $settings['social_youtube'] ?? 'https://www.youtube.com/@SJIGroup?si=R7p2Z5VY_2RdXzhU',
            'social_tiktok' => $settings['social_tiktok'] ?? 'https://www.tiktok.com/@sji.group',
            'contact_whatsapp' => $settings['contact_whatsapp'] ?? '6281333270022',
            'whatsapp_link' => $settings['contact_whatsapp_link'] ?? 'https://api.whatsapp.com/send?phone=6281333270022&text=Hallo%20Admin.Saya%20mau%20tanya%20tentang%20magang%20ke%20jepang.',
        ];

        // Indonesia Country Facts for Kaisha / Japanese Enterprises
        $countryGuide = [
            'country_name' => 'Republik Indonesia (インドネシア共和国)',
            'capital' => 'Jakarta (Populasi: ~11,01 Juta pada 2026)',
            'population' => 'Sekitar 286 Juta Jiwa (Statistik Resmi Pemerintah RI 2026)',
            'ethnicity' => 'Sekitar 300+ Suku Bangsa (Jawa, Sunda, Batak, Madura, dll.)',
            'language' => 'Bahasa Indonesia (Resmi) & Bahasa Daerah',
            'religion' => 'Islam, Kristen Protestan, Katolik, Hindu, Buddha, Khonghucu (Diakui Konstitusi)',
            'area' => 'Sekitar 1,92 Juta km² (Kurang lebih 5 kali luas daratan Jepang)',
            'gdp' => 'US$ 1,44 Triliun (Diproyeksikan US$ 1,47T pada 2026, Melampaui US$ 2T pada 2029)',
            'growth_rate' => '4.9% - 5.1% per tahun',
            'exchange_rate' => '1 USD ≈ Rp 16.808 (Bank Indonesia 2026)',
            'climate' => 'Iklim Tropis: Musim Kemarau (April - Oktober) & Musim Hujan (November - Maret)',
            'time_diff' => '-2 Jam dari Waktu Jepang (JST) di WIB (Jakarta/Jawa/Sumatera), -1 Jam di Bali (WITA)',
            'flight_time' => 'Penerbangan langsung Jakarta/Bali - Tokyo (Narita/Haneda) sekitar 7 - 8 jam',
            'flag' => 'Merah Putih (Merah: Keberanian & Semangat membara / Putih: Kebenaran & Ketulusan Hati)',
        ];

        return view('landing.company_profile', compact(
            'settings',
            'indonesiaBranches',
            'japanBranches',
            'allBranches',
            'corporate',
            'countryGuide'
        ));
    }

    /**
     * Display the dedicated Curriculum & Education page.
     */
    public function curriculum()
    {
        $settings = SiteSetting::allCached();

        $corporate = [
            'name' => $settings['site_name'] ?? 'PT SAHABAT JEPANG INDONESIA GROUP',
            'tagline' => $settings['site_tagline'] ?? '友好日本インドネシア • SJI Group Sending Organization & Nihongo Gakkou',
            'contact_whatsapp' => $settings['contact_whatsapp'] ?? '6281333270022',
            'whatsapp_link' => $settings['contact_whatsapp_link'] ?? 'https://api.whatsapp.com/send?phone=6281333270022&text=Hallo%20Admin.Saya%20mau%20tanya%20tentang%20magang%20ke%20jepang.',
        ];

        // 4-Tier Language & Skills Roadmap
        $levels = [
            [
                'code' => 'SCREENING CLASS',
                'name' => 'Seleksi Awal, Fisik & Karakter',
                'period' => '1 - 2 Minggu',
                'badge' => 'Tahap Seleksi',
                'focus' => 'Tes fisik & ketahanan, orientasi disiplin asrama, pengenalan huruf Hiragana & Katakana dasar, serta pembentukan mental pantang menyerah.',
                'icon' => 'user-check',
                'color' => 'blue'
            ],
            [
                'code' => 'N5 / JFT-BASIC A2',
                'name' => 'Dasar Bahasa Jepang (Shokyuu 1)',
                'period' => '2 - 3 Bulan',
                'badge' => 'Pemula Terpadu',
                'focus' => 'Penguasaan 100+ Kanji, 800+ Kosakata esensial, tata bahasa Minna no Nihongo I Bab 1-25, salam harian (aisatsu), dan pembiasaan budaya 5S.',
                'icon' => 'book-open',
                'color' => 'emerald'
            ],
            [
                'code' => 'N4 / KAIWA KERJA',
                'name' => 'Bahasa Lanjutan & Percakapan Kerja (Shokyuu 2)',
                'period' => '2 - 3 Bulan',
                'badge' => 'Standar Kerja Jepang',
                'focus' => 'Pola kalimat Minna no Nihongo II Bab 26-50, pendengaran cepat (choukai), tata krama bisnis Hou-Ren-Sou, dan simulasi wawancara Kaisha.',
                'icon' => 'languages',
                'color' => 'rose'
            ],
            [
                'code' => 'N3 / SPESIFIK BIDANG',
                'name' => 'Pemantapan Teknis & Ujian Keahlian Khusus',
                'period' => '1 - 2 Bulan',
                'badge' => 'Siap Terbang & Kerja',
                'focus' => 'Kosakata spesifik Kaigo (perawat lansia), pengolahan makanan, manufaktur, konstruksi, sertifikasi Prometric, dan pembekalan CoE / Visa.',
                'icon' => 'award',
                'color' => 'amber'
            ],
        ];

        $sjiStats = SiteSetting::getCorporateStats();

        // Faculty & Management Credentials (Dynamically Synced with Database & Settings)
        $facultyStats = [
            'course_levels_count' => count($levels),
            'staff_count' => $sjiStats['staff_count'],
            'staff_label' => 'Staf Manajemen & Instruktur Pengajar Berpengalaman',
            'native_count' => $sjiStats['native_count'],
            'native_label' => 'Sensei Asli dari Jepang (Native Speakers)',
            'urawa_count' => $sjiStats['urawa_count'],
            'urawa_label' => 'Sensei Alumni Urawa Japanese-Language Center',
            'mou_label' => $sjiStats['mou_label']
        ];

        // Branches statistics for dynamic counts
        $branchStats = [
            'indonesia_count' => $sjiStats['indonesia_branches_count'],
            'japan_count' => $sjiStats['japan_branches_count'],
            'total_count' => $sjiStats['total_branches_count'],
            'japan_cities' => $sjiStats['japan_cities'],
        ];

        // Workshop Labs & Facilities
        $facilities = [
            [
                'title' => 'Ruang Kelas Multimedia Interaktif',
                'desc' => 'Ruang belajar ber-AC, proyektor digital resolusi tinggi, audio lab untuk simulasi ujian Choukai (mendengar), serta meja belajar ergonomis standar Jepang.',
                'icon' => 'monitor',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'Laboratorium Praktik Kerja Standar Jepang',
                'desc' => 'Simulasi ranjang keperawatan lansia (Kaigo Bed), perkakas mesin & perakitan industri, serta alat pelindung diri (K3) standar keselamatan kerja Jepang.',
                'icon' => 'wrench',
                'image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'Asrama Kedisiplinan Terpadu (Dormitory)',
                'desc' => 'Asrama mandiri dengan jadwal kebersihan ketat, kamar tidur nyaman, sanitasi higienis, fasilitas ibadah, dan pengawasan 24 jam oleh sensei pembina.',
                'icon' => 'home',
                'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80'
            ]
        ];

        // Daily Schedule Data
        $schedules = [
            'weekday' => [
                ['time' => '04:00 AM', 'title' => 'Bangun Tidur (Wake Up)', 'title_jp' => '起床', 'desc' => 'Memulai aktivitas harian tepat waktu dengan kedisiplinan tinggi.'],
                ['time' => '04:15 AM', 'title' => 'Pembersihan Asrama, Ibadah/Doa, Persiapan Sarapan', 'title_jp' => '寮清掃・お祈り・朝食準備', 'desc' => 'Kerja bakti kebersihan kamar & koridor asrama, salat subuh bagi muslim, dan tim piket sarapan.'],
                ['time' => '06:00 AM', 'title' => 'Sarapan Pagi & Senam Pagi', 'title_jp' => '朝食・ラジオ体操', 'desc' => 'Sarapan gizi seimbang bersama dan senam peregangan fisik ala Jepang (Rajio Taisou).'],
                ['time' => '08:30 AM', 'title' => 'Kegiatan Belajar Mengajar (Kelas Bahasa)', 'title_jp' => '日本語授業・実習', 'desc' => 'Pelajaran intensif tata bahasa, kosakata, kanji, kaiwa, dan budaya kerja 5S.'],
                ['time' => '04:00 PM', 'title' => 'Latihan Fisik & Kebugaran (Running)', 'title_jp' => '体力錬成（ランニング等）', 'desc' => 'Latihan stamina, lari sore, push-up/sit-up untuk memastikan fisik tangguh di iklim Jepang.'],
                ['time' => '05:00 PM', 'title' => 'Persiapan Makan Malam & Santap Malam', 'title_jp' => '夕食準備・夕食', 'desc' => 'Makan malam bergizi dan evaluasi harian bersama pengurus asrama.'],
                ['time' => '05:30 PM', 'title' => 'Waktu Luang & Istirahat', 'title_jp' => '自由時間・休憩', 'desc' => 'Waktu istirahat pribadi, ibadah, dan mencuci pakaian.'],
                ['time' => '07:00 PM', 'title' => 'Belajar Mandiri Malam (Night Study)', 'title_jp' => '夜間自習', 'desc' => 'Review materi harian, hafalan kanji harian, dan persiapan tes evaluasi esok hari.'],
                ['time' => '10:00 PM', 'title' => 'Lampu Dipadamkan (Lights Off)', 'title_jp' => '消灯・就寝', 'desc' => 'Istirahat tidur malam wajib demi menjaga kebugaran tubuh optimal.'],
            ],
            'weekend' => [
                ['time' => '04:00 AM', 'title' => 'Bangun Tidur (Wake Up)', 'title_jp' => '起床', 'desc' => 'Tetap mempertahankan ritme bangun pagi yang konsisten.'],
                ['time' => '04:15 AM', 'title' => 'Pembersihan Asrama, Ibadah/Doa, Persiapan Sarapan', 'title_jp' => '寮清掃・お祈り・朝食準備', 'desc' => 'General cleaning area asrama dan persiapan makan pagi.'],
                ['time' => '06:00 AM', 'title' => 'Sarapan Pagi, Olahraga & Mandi', 'title_jp' => '朝食・運動・シャワー', 'desc' => 'Sarapan bersama, olahraga santai di lingkungan kampus, dan mandi pagi.'],
                ['time' => '09:00 AM', 'title' => 'Kelas Percakapan & Praktik Keperawatan', 'title_jp' => '会話授業・介護特別クラス', 'desc' => 'Sesi kaiwa interaktif dengan penutur asli Jepang dan simulasi praktikum ranjang pasien (Kaigo).'],
                ['time' => '01:00 PM', 'title' => 'Waktu Luang / Mandiri', 'title_jp' => '自由時間', 'desc' => 'Waktu santai siswa, komunikasi dengan keluarga di kampung halaman.'],
                ['time' => '05:00 PM', 'title' => 'Persiapan Makan Malam & Santap Malam', 'title_jp' => '夕食準備・夕食', 'desc' => 'Makan malam akhir pekan bersama seluruh rekan asrama.'],
                ['time' => '07:00 PM', 'title' => 'Waktu Luang / Review Santai', 'title_jp' => '自由時間・読書', 'desc' => 'Aktivitas santai, membaca buku kebudayaan Jepang atau menonton video bahasa.'],
                ['time' => '10:00 PM', 'title' => 'Lampu Dipadamkan (Lights Off)', 'title_jp' => '消灯・就寝', 'desc' => 'Waktu istirahat total untuk memulihkan energi menghadapi pekan baru.'],
            ]
        ];

        return view('landing.education_curriculum', compact(
            'settings',
            'corporate',
            'levels',
            'facultyStats',
            'branchStats',
            'facilities',
            'schedules'
        ));
    }
}
