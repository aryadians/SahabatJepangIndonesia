<?php

namespace Database\Seeders;

use App\Models\Affiliate;
use App\Models\ExamQuestion;
use App\Models\WhatsAppTemplate;
use Illuminate\Database\Seeder;

class GrowthFeaturesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Bank Soal JLPT & JFT-Basic
        ExamQuestion::truncate();

        $questions = [
            // === JLPT N5 Questions ===
            [
                'level' => 'N5',
                'section' => 'Kotoba',
                'question' => 'Pilihlah cara baca kanji yang tepat untuk kalimat berikut: 「毎朝７時に【起きます】。」',
                'question_japanese' => 'まいあさ ７じに 【おきます】。',
                'option_a' => 'おきます (Okimasu)',
                'option_b' => 'ねます (Nemasu)',
                'option_c' => 'いきます (Ikimasu)',
                'option_d' => 'きます (Kimasu)',
                'correct_answer' => 'A',
                'explanation' => 'Kanji 起きます dibaca "okimasu" yang berarti bangun tidur.',
                'points' => 10,
                'order' => 1,
            ],
            [
                'level' => 'N5',
                'section' => 'Bunpou',
                'question' => 'Lengkapilah partikel yang tepat: 「わたしは にほんご（　）べんきょうします。」',
                'question_japanese' => 'わたしは にほんご（　）べんきょうします。',
                'option_a' => 'に (ni)',
                'option_b' => 'を (o / wo)',
                'option_c' => 'で (de)',
                'option_d' => 'へ (e)',
                'correct_answer' => 'B',
                'explanation' => 'Partikel を (wo/o) digunakan untuk menandai objek penderita dari kata kerja transitif (belajar bahasa Jepang = にほんごをべんきょうします).',
                'points' => 10,
                'order' => 2,
            ],
            [
                'level' => 'N5',
                'section' => 'Kanji',
                'question' => 'Pilihlah kanji yang tepat untuk kata yang bergaris bawah: 「あした ともだちと 【やま】へ いきます。」',
                'question_japanese' => 'あした ともだちと 【やま】へ いきます。',
                'option_a' => '川',
                'option_b' => '木',
                'option_c' => '山',
                'option_d' => '水',
                'correct_answer' => 'C',
                'explanation' => 'Kata "yama" (gunung) ditulis dengan kanji 山. Pilihan A (kawa=sungai), B (ki=pohon), D (mizu=air).',
                'points' => 10,
                'order' => 3,
            ],
            [
                'level' => 'N5',
                'section' => 'Dokkai',
                'question' => 'Bacalah teks singkat berikut: 「山田さんは毎朝コーヒーを飲みます。パンは食べません。昼ごはんは会社の食堂でラーメンを食べます。」 Pertanyaan: 山田さんは朝、何を食べますか。',
                'question_japanese' => '山田さんは毎朝コーヒーを飲みます。パンは食べません。昼ごはんは会社の食堂でラーメンを食べます。',
                'option_a' => 'パンを食べます',
                'option_b' => 'ラーメンを食べます',
                'option_c' => '何も食べません',
                'option_d' => 'ごはんを食べます',
                'correct_answer' => 'C',
                'explanation' => 'Pada teks disebutkan "パンは食べません" (tidak makan roti) dan hanya minum kopi di pagi hari, jadi山田さん tidak makan apa-apa di pagi hari (何も食べません).',
                'points' => 10,
                'order' => 4,
            ],

            // === JLPT N4 Questions ===
            [
                'level' => 'N4',
                'section' => 'Kotoba',
                'question' => 'Pilihlah padanan kata yang sesuai untuk melengkapi kalimat: 「時間がありませんから、【　】歩きましょう。」',
                'question_japanese' => 'じかんが ありませんから、【　】あるきましょう。',
                'option_a' => 'いそいで (Isoide)',
                'option_b' => 'ゆっくり (Yukkuri)',
                'option_c' => 'だんだん (Dandan)',
                'option_d' => 'ぜんぜん (Zenzen)',
                'correct_answer' => 'A',
                'explanation' => 'Isoide (急いで) berarti terburu-buru/cepat. Karena tidak ada waktu, maka mari berjalan dengan cepat.',
                'points' => 10,
                'order' => 5,
            ],
            [
                'level' => 'N4',
                'section' => 'Bunpou',
                'question' => 'Lengkapilah pola tata bahasa berikut: 「日本へ 行く（　）、パスポートを つくらなければなりません。」',
                'question_japanese' => 'にほんへ いく（　）、パスポートを つくらなければなりません。',
                'option_a' => 'まえに (mae ni)',
                'option_b' => 'あとで (ato de)',
                'option_c' => 'ながら (nagara)',
                'option_d' => 'とき (toki)',
                'correct_answer' => 'A',
                'explanation' => 'Pola Kamus-kei + まえに (mae ni) berarti "sebelum". Sebelum pergi ke Jepang, harus membuat paspor.',
                'points' => 10,
                'order' => 6,
            ],
            [
                'level' => 'N4',
                'section' => 'Dokkai',
                'question' => 'Pilihlah bentuk sopan keigo / sonkeigo yang tepat: 「社長は もう お宅へ 【　】。」',
                'question_japanese' => 'しゃちょうは もう おたくへ 【　】。',
                'option_a' => '帰られました (Kaeraremashita)',
                'option_b' => '申しました (Moushimashita)',
                'option_c' => '参りました (Mairimashita)',
                'option_d' => '拝見しました (Haikenshimashita)',
                'correct_answer' => 'A',
                'explanation' => 'Untuk menghormati Direktur (社長), digunakan bentuk pasif hormat (sonkeigo) 帰られました.',
                'points' => 10,
                'order' => 7,
            ],

            // === JFT-Basic A2 Questions ===
            [
                'level' => 'JFT-Basic',
                'section' => 'Kotoba',
                'question' => 'Situasi Kerja Kaigo / Pabrik: 「作業が終わったら、道具を元の場所に【　】ください。」',
                'question_japanese' => 'さぎょうがおわったら、どうぐをもとのばしょに【　】ください。',
                'option_a' => 'もどして (Modoshite)',
                'option_b' => 'すてて (Sutete)',
                'option_c' => 'こわして (Kowashite)',
                'option_d' => 'わすれて (Wasurete)',
                'correct_answer' => 'A',
                'explanation' => 'Modoshite (戻して) berarti mengembalikan ke tempat semula. Ini kosakata standar 5S di tempat kerja Jepang.',
                'points' => 10,
                'order' => 8,
            ],
            [
                'level' => 'JFT-Basic',
                'section' => 'Bunpou',
                'question' => 'Instruksi Keselamatan Kerja: 「機械が動いているときは、絶対に触ら【　】でください。」',
                'question_japanese' => 'きかいが うごいているときは、ぜったいに さわら【　】でください。',
                'option_a' => 'ない (nai)',
                'option_b' => 'なく (naku)',
                'option_c' => 'なかっ (nakat)',
                'option_d' => 'ぬ (nu)',
                'correct_answer' => 'A',
                'explanation' => 'Pola larangan halus: Kata Kerja bentuk Nai + でください (触らないでください = tolong jangan sentuh sama sekali).',
                'points' => 10,
                'order' => 9,
            ],
            [
                'level' => 'JFT-Basic',
                'section' => 'Dokkai',
                'question' => 'Pemberitahuan Asrama: 「ゴミ出しのルール：燃えるゴミは火曜日と金曜日の朝8時までに出してください。段ボールは木曜日です。」 Pertanyaan: 火曜日に出せるゴミは何ですか。',
                'question_japanese' => 'ゴミ出しのルール：燃えるゴミは火曜日と金曜日の朝8時までに出してください。段ボールは木曜日です。',
                'option_a' => '燃えるゴミ (Sampah mudah terbakar / organik)',
                'option_b' => '段ボール (Kardus)',
                'option_c' => '粗大ゴミ (Sampah besar)',
                'option_d' => 'ビン・缶 (Botol & Kaleng)',
                'correct_answer' => 'A',
                'explanation' => 'Berdasarkan teks pengumuman, sampah yang dikeluarkan pada hari Selasa (火曜日) adalah 燃えるゴミ (sampah mudah terbakar).',
                'points' => 10,
                'order' => 10,
            ],
        ];

        foreach ($questions as $q) {
            ExamQuestion::create($q);
        }

        // 2. Seed WhatsApp CRM Templates
        $templates = [
            [
                'trigger_key' => 'new_lead',
                'title' => 'Sapaan & Brosur Pendaftar Baru (Leads)',
                'message' => "Halo Kak {nama}! 👋🎌\n\nTerima kasih telah mendaftar dan berkonsultasi di *LPK Sahabat Jepang Indonesia (友好日本インドネシア)*.\n\nKami telah mencatat minat Kakak untuk program *{program}*.\n\n📚 *Download Brosur & Rincian Biaya:* {link_brosur}\n\nKonselor kami akan segera memandu jadwal seleksi dan tes wawancara. Ada yang ingin ditanyakan terlebih dahulu seputar asrama atau alur seleksi?",
            ],
            [
                'trigger_key' => 'payment_receipt',
                'title' => 'Konfirmasi Pembayaran Angsuran Lunas / Masuk',
                'message' => "Kpd Yth. Siswa/Wali: *{nama}* (NIS: {nis})\n\nTerima kasih, pembayaran sebesar *Rp {nominal}* untuk program *{program}* telah kami terima dan tercatat di sistem keuangan LPK SJI pada tanggal {tanggal}.\n\n📊 *Sisa Tanggungan Biaya:* Rp {sisa_tanggungan}\n\nSemangat terus dalam pelatihan bahasa Jepang! Ganbatte kudasai! 🌸",
            ],
            [
                'trigger_key' => 'due_reminder',
                'title' => 'Pengingat Jatuh Tempo Biaya Pelatihan',
                'message' => "Halo Kak {nama} (NIS: {nis}),\n\nKami informasikan pengingat ramah bahwa angsuran biaya program *{program}* dengan sisa tanggungan sebesar *Rp {sisa_tanggungan}* akan jatuh tempo pada *{jatuh_tempo}*.\n\nPembayaran dapat ditransfer melalui Rekening Resmi LPK Sahabat Jepang Indonesia:\n🏦 *BCA:* 123-456-7890 (a.n LPK Sahabat Jepang Indonesia)\n\nKonfirmasi bukti transfer ke nomor WhatsApp ini ya Kak. Terima kasih! 🙏",
            ],
            [
                'trigger_key' => 'interview_invite',
                'title' => 'Undangan Wawancara (Mensetsu) Perusahaan Jepang',
                'message' => "KABAR GEMBIRA! 🎉🇯🇵\n\nHalo Kak {nama},\nSelamat! Berkas Anda telah lolos kurasi awal untuk wawancara langsung (*Mensetsu*) dengan Kaisha: *{perusahaan}* (Prefektur {prefektur}).\n\n📅 *Hari/Tanggal:* {jadwal}\n⏰ *Waktu:* {waktu} WIB\n📍 *Lokasi:* Ruang Wawancara Online LPK SJI / Zoom Meeting\n\nHarap hadir tepat waktu dengan seragam kemeja putih dan persiapan perkenalan diri (*Jikoshoukai*).",
            ],
        ];

        foreach ($templates as $t) {
            WhatsAppTemplate::updateOrCreate(
                ['trigger_key' => $t['trigger_key']],
                $t
            );
        }

        // 3. Seed Demo Affiliates / Mitra Sekolah
        $affiliates = [
            [
                'code' => 'SMKN1JKT',
                'name' => 'Drs. Bambang Hariyanto (Koordinator BKK)',
                'type' => 'guru_bk',
                'institution_name' => 'SMK Negeri 1 Jakarta',
                'phone' => '081298761234',
                'email' => 'bkk.smkn1jkt@gmail.com',
                'bank_name' => 'Bank Mandiri',
                'bank_account_number' => '123-00-998877-1',
                'bank_account_holder' => 'Bambang Hariyanto',
                'reward_per_lead' => 500000,
                'is_active' => true,
            ],
            [
                'code' => 'ALUMNI-RIZKY',
                'name' => 'Rizky Pratama (Alumni Tokutei Ginou SSW)',
                'type' => 'alumni',
                'institution_name' => 'Komunitas Alumni SJI Nagoya',
                'phone' => '081388776655',
                'email' => 'rizky.nagoya@gmail.com',
                'bank_name' => 'BCA',
                'bank_account_number' => '8820-112233',
                'bank_account_holder' => 'Rizky Pratama',
                'reward_per_lead' => 750000,
                'is_active' => true,
            ],
            [
                'code' => 'SMK-TARUNA',
                'name' => 'SMK Taruna Karya Bandung',
                'type' => 'sekolah',
                'institution_name' => 'Yayasan Pendidikan Taruna Karya',
                'phone' => '082155443322',
                'email' => 'kerjasama@smktarunabandung.sch.id',
                'bank_name' => 'BNI',
                'bank_account_number' => '0987-654-321',
                'bank_account_holder' => 'SMK Taruna Karya',
                'reward_per_lead' => 500000,
                'is_active' => true,
            ],
        ];

        foreach ($affiliates as $a) {
            Affiliate::updateOrCreate(
                ['code' => $a['code']],
                $a
            );
        }
    }
}
