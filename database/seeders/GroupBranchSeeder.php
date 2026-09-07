<?php

namespace Database\Seeders;

use App\Models\GroupBranch;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class GroupBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'PT SJI GROUP',
                'japanese_name' => 'PT SJI GROUP',
                'category_jp' => '特定技能送り出し機関',
                'category_id' => 'Lembaga Pengirim Pekerja Berketerampilan Khusus (Tokutei Ginou / SSW)',
                'phone' => '+62 889-9425-1009',
                'secondary_phone' => null,
                'address' => 'Jl. Gracia Land Ruko A-01, Pepe, Kec. Sedati, Kab. Sidoarjo, Jawa Timur 61253',
                'postal_code' => '61253',
                'city' => 'Sidoarjo',
                'province' => 'Jawa Timur',
                'country' => 'ID',
                'sort_order' => 1,
                'is_active' => true,
                'description' => 'Induk holding dan sending organization resmi program Tokutei Ginou (SSW) untuk penempatan tenaga kerja profesional di berbagai sektor industri Jepang.',
            ],
            [
                'name' => 'LPK SAHABAT JEPANG INDONESIA',
                'japanese_name' => 'LPK サハバット・ジャパン・インドネシア 本校',
                'category_jp' => '技能実習送り出し機関+日本語学校',
                'category_id' => 'Lembaga Pengirim Pemagang Teknis (SO) & Sekolah Bahasa Jepang Pusat',
                'phone' => '+62 813-3327-0022',
                'secondary_phone' => null,
                'address' => 'Perum Putri Juanda Blok C3, No.5 RT/RW. 006/018, Ds. Pepe Kec. Sedati Kab. Sidoarjo, Jawa Timur 61253',
                'postal_code' => '61253',
                'city' => 'Sidoarjo',
                'province' => 'Jawa Timur',
                'country' => 'ID',
                'sort_order' => 2,
                'is_active' => true,
                'description' => 'Kampus pusat pelatihan intensif bahasa & budaya Jepang serta sending organization pemagangan teknis (Ginou Jisshusei) resmi Kemnaker RI.',
            ],
            [
                'name' => 'LPK SAHABAT JEPANG INDONESIA CAB. CIKARANG',
                'japanese_name' => 'LPK サハバット・ジャパン・インドネシア チカラン校',
                'category_jp' => '日本語学校',
                'category_id' => 'Sekolah Bahasa Jepang Cabang Cikarang',
                'phone' => '+62 822-3112-2205',
                'secondary_phone' => null,
                'address' => 'Jl. Raya Cikarang – Cibarusah No.18, Pasirsari, Cikarang Selatan, Bekasi - Jawa Barat 17550',
                'postal_code' => '17550',
                'city' => 'Bekasi',
                'province' => 'Jawa Barat',
                'country' => 'ID',
                'sort_order' => 3,
                'is_active' => true,
                'description' => 'Pusat pelatihan bahasa Jepang berstandar industri berlokasi strategis di kawasan industri Cikarang Bekasi.',
            ],
            [
                'name' => 'LPK HIKARI PELANGI INTERNASIONAL',
                'japanese_name' => 'LPK ヒカリ・ペランギ・インターナショナル',
                'category_jp' => '日本語学校',
                'category_id' => 'Sekolah Bahasa Jepang & Pengembangan Karir Internasional',
                'phone' => '+62 858-7262-3670',
                'secondary_phone' => null,
                'address' => 'Jl. Kavling Bumi Sedati Blok C2, No.16 Ds. Pepe Kec. Sedati Kab. Sidoarjo, Jawa Timur 61253',
                'postal_code' => '61253',
                'city' => 'Sidoarjo',
                'province' => 'Jawa Timur',
                'country' => 'ID',
                'sort_order' => 4,
                'is_active' => true,
                'description' => 'Lembaga pendidikan bahasa Jepang dengan pendekatan kurikulum terpadu dan pembinaan kedisiplinan pra-seleksi.',
            ],
            [
                'name' => 'LPK BINTANG HIGASHI JAVA',
                'japanese_name' => 'LPK ビンタン・ヒガシ・ジャワ',
                'category_jp' => '技能実習送り出し機関+日本語学校',
                'category_id' => 'Lembaga Pengirim Pemagang Teknis & Sekolah Bahasa Jepang',
                'phone' => '+62 851-7984-0847',
                'secondary_phone' => null,
                'address' => 'Perum Putri Juanda Blok C3, No.5 (Lt 2) RT/RW. 006/018, Ds. Pepe Kec. Sedati Kab. Sidoarjo, Jawa Timur 61253',
                'postal_code' => '61253',
                'city' => 'Sidoarjo',
                'province' => 'Jawa Timur',
                'country' => 'ID',
                'sort_order' => 5,
                'is_active' => true,
                'description' => 'Unit pelatihan khusus bidang manufaktur dan pengolahan makanan serta sending organization binaan SJI Group.',
            ],
            [
                'name' => 'LPK SAHABAT JEPANG INDONESIA CAB. KARAWANG',
                'japanese_name' => 'LPK サハバット・ジャパン・インドネシア カラワン校',
                'category_jp' => '日本語学校',
                'category_id' => 'Sekolah Bahasa Jepang Cabang Karawang',
                'phone' => '+62 812-9896-2765',
                'secondary_phone' => null,
                'address' => 'Jl. Siliwangi No.2 RT/RW. 004/013 Kel. Karawang Wetan, Kec. Karawang Timur, Kab. Karawang, Jawa Barat 41314',
                'postal_code' => '41314',
                'city' => 'Karawang',
                'province' => 'Jawa Barat',
                'country' => 'ID',
                'sort_order' => 6,
                'is_active' => true,
                'description' => 'Sentra bimbingan intensif persiapan wawancara dan bahasa Jepang untuk pemuda di wilayah Karawang dan sekitarnya.',
            ],
            [
                'name' => 'LPK HIKARI SEIKO BERSAMA',
                'japanese_name' => 'LPK ヒカリ・セイコー・ベルサマ',
                'category_jp' => '日本語学校',
                'category_id' => 'Sekolah Bahasa Jepang Terpadu',
                'phone' => '+62 878-7143-0363',
                'secondary_phone' => null,
                'address' => 'Perum. Taman Sentosa Blok B1/93, Jalan Taman Sentosa, Pasir Sari, Cikarang Selatan, Kab. Bekasi, Jawa Barat 17532',
                'postal_code' => '17532',
                'city' => 'Bekasi',
                'province' => 'Jawa Barat',
                'country' => 'ID',
                'sort_order' => 7,
                'is_active' => true,
                'description' => 'Lembaga pelatihan vokasi teknik dan bahasa Jepang dengan sarana ruang kelas multimedia terintegrasi.',
            ],
            [
                'name' => '株式会社 SAHABAT JAPAN AGENCY 駐在員事務所',
                'japanese_name' => '株式会社 SAHABAT JAPAN AGENCY 駐在員事務所',
                'category_jp' => '駐在員事務所',
                'category_id' => 'Kantor Perwakilan Resmi Tokyo (Tokyo Representative Office)',
                'phone' => '+81 70-3268-9213',
                'secondary_phone' => null,
                'address' => '〒130-0022, ドルミ錦糸町大興ビル 東京都墨田区江東橋3−2−2',
                'postal_code' => '130-0022',
                'city' => 'Tokyo',
                'province' => 'Tokyo',
                'country' => 'JP',
                'sort_order' => 8,
                'is_active' => true,
                'description' => 'Kantor perwakilan SJI Group di Tokyo untuk menjembatani koordinasi langsung dengan asosiasi penerima (Kumiai), perusahaan Jepang (Kaisha), dan pendampingan kesejahteraan pekerja.',
            ],
            [
                'name' => '大心の船橋入国後研修センター',
                'japanese_name' => '大心の船橋入国後研修センター',
                'category_jp' => '入国後研修センター',
                'category_id' => 'Pusat Pelatihan & Karantina Pasca-Kedatangan Jepang (Chiba Training Center)',
                'phone' => '090-3266-0444',
                'secondary_phone' => '047-401-0710',
                'address' => '〒273-0046, 千葉県船橋市上山町 2-490-1',
                'postal_code' => '273-0046',
                'city' => 'Funabashi',
                'province' => 'Chiba',
                'country' => 'JP',
                'sort_order' => 9,
                'is_active' => true,
                'description' => 'Fasilitas karantina dan pembekalan hukum, tata tertib, serta adaptasi kehidupan sehari-hari selama 1 bulan pertama setelah peserta mendarat di Jepang.',
            ],
        ];

        foreach ($branches as $branch) {
            GroupBranch::updateOrCreate(
                ['name' => $branch['name']],
                $branch
            );
        }

        // Initialize SJI Group Corporate Identity in SiteSetting
        $groupSettings = [
            'site_name' => 'PT SAHABAT JEPANG INDONESIA GROUP',
            'site_tagline' => '友好日本インドネシア • SJI Group Sending Organization & Japanese Academy',
            'site_logo' => '/images/logo.png',
            'corporate_leader_title' => 'Representative Director and Chairman',
            'corporate_leader_name' => 'YOYOK WIDODO',
            'corporate_leader_message' => 'Our mission is to maximize the potential of individuals and organizations, and we continue to create value from a global perspective. Based on trust and a commitment to innovation, we will work together to achieve sustainable growth.',
            'corporate_vision' => 'Become a leading partner in sending Indonesian talent that is honest, trustworthy, and possesses high levels of expertise. We aim to cultivate individuals who will act as "national ambassadors," promoting Indonesia\'s outstanding values in Japan and around the world.',
            'corporate_mission' => "1. Promoting continuous human resource development\n2. Protection and improvement of workers' welfare\n3. Building a robust international cooperation system\n4. A firm commitment to social responsibility",
            'corporate_alumni_sent' => '850+',
            'social_facebook' => 'https://www.facebook.com/groups/1402737939919037/',
            'social_instagram' => 'https://www.instagram.com/pt.sjigroup/',
            'social_youtube' => 'https://www.youtube.com/@SJIGroup?si=R7p2Z5VY_2RdXzhU',
            'social_tiktok' => 'https://www.tiktok.com/@sji.group',
            'contact_whatsapp' => '6281333270022',
            'contact_whatsapp_link' => 'https://api.whatsapp.com/send?phone=6281333270022&text=Hallo%20Admin.Saya%20mau%20tanya%20tentang%20magang%20ke%20jepang.',
        ];

        foreach ($groupSettings as $key => $val) {
            SiteSetting::set($key, $val, 'corporate');
        }
    }
}
