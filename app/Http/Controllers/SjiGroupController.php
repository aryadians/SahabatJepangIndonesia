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

        $indonesiaBranches = GroupBranch::active()->ordered()->indonesia()->get();
        $japanBranches = GroupBranch::active()->ordered()->japan()->get();
        $allBranches = GroupBranch::active()->ordered()->get();

        // Corporate Leadership & Identity
        $corporate = [
            'name' => $settings['site_name'] ?? 'PT SAHABAT JEPANG INDONESIA GROUP',
            'tagline' => $settings['site_tagline'] ?? '友好日本インドネシア • SJI Group Sending Organization & Nihongo Gakkou',
            'leader_name' => $settings['corporate_leader_name'] ?? 'YOYOK WIDODO',
            'leader_title' => $settings['corporate_leader_title'] ?? 'Representative Director and Chairman',
            'leader_message' => $settings['corporate_leader_message'] ?? 'Our mission is to maximize the potential of individuals and organizations, and we continue to create value from a global perspective. Based on trust and a commitment to innovation, we will work together to achieve sustainable growth.',
            'vision' => $settings['corporate_vision'] ?? 'Become a leading partner in sending Indonesian talent that is honest, trustworthy, and possesses high levels of expertise. We aim to cultivate individuals who will act as "national ambassadors," promoting Indonesia\'s outstanding values in Japan and around the world.',
            'mission' => $settings['corporate_mission'] ?? "1. Promoting continuous human resource development\n2. Protection and improvement of workers' welfare\n3. Building a robust international cooperation system\n4. A firm commitment to social responsibility",
            'alumni_sent' => $settings['corporate_alumni_sent'] ?? '850+',
            'social_facebook' => $settings['social_facebook'] ?? 'https://www.facebook.com/groups/1402737939919037/',
            'social_instagram' => $settings['social_instagram'] ?? 'https://www.instagram.com/pt.sjigroup/',
            'social_youtube' => $settings['social_youtube'] ?? 'https://www.youtube.com/@SJIGroup?si=R7p2Z5VY_2RdXzhU',
            'social_tiktok' => $settings['social_tiktok'] ?? 'https://www.tiktok.com/@sji.group',
            'contact_whatsapp' => $settings['contact_whatsapp'] ?? '6281333270022',
            'whatsapp_link' => $settings['contact_whatsapp_link'] ?? 'https://api.whatsapp.com/send?phone=6281333270022&text=Hallo%20Admin.Saya%20mau%20tanya%20tentang%20magang%20ke%20jepang.',
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
                ['time' => '09:00 AM', 'title' => 'Kelas Percakapan & Kelas Praktik Keperawatan', 'title_jp' => '会話授業・介護特別クラス', 'desc' => 'Sesi kaiwa interaktif dengan penutur asli Jepang dan simulasi praktikum ranjang pasien (Kaigo).'],
                ['time' => '01:00 PM', 'title' => 'Waktu Luang / Mandiri', 'title_jp' => '自由時間', 'desc' => 'Waktu santai siswa, komunikasi dengan keluarga di kampung halaman.'],
                ['time' => '05:00 PM', 'title' => 'Persiapan Makan Malam & Santap Malam', 'title_jp' => '夕食準備・夕食', 'desc' => 'Makan malam akhir pekan bersama seluruh rekan asrama.'],
                ['time' => '07:00 PM', 'title' => 'Waktu Luang / Review Santai', 'title_jp' => '自由時間・読書', 'desc' => 'Aktivitas santai, membaca buku kebudayaan Jepang atau menonton video bahasa.'],
                ['time' => '10:00 PM', 'title' => 'Lampu Dipadamkan (Lights Off)', 'title_jp' => '消灯・就寝', 'desc' => 'Waktu istirahat total untuk memulihkan energi menghadapi pekan baru.'],
            ]
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
            'schedules',
            'countryGuide'
        ));
    }
}
