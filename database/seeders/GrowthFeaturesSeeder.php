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
        // 1. Seed Bank Soal JLPT & JFT-Basic Lengkap (N5, N4, N3, JFT A2)
        ExamQuestion::truncate();

        $questions = [
            // ==========================================
            // === JLPT N5 Questions (Dasar Pemula) ===
            // ==========================================
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
                'explanation' => 'Kanji 起きます dibaca "okimasu" yang berarti bangun tidur. Sedangkan ねます = tidur, いきます = pergi, きます = datang.',
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
                'explanation' => 'Kata "yama" (gunung) ditulis dengan kanji 山. Pilihan A (川 = kawa/sungai), B (木 = ki/pohon), D (水 = mizu/air).',
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
                'explanation' => 'Pada teks disebutkan "パンは食べません" (tidak makan roti) dan hanya minum kopi di pagi hari, jadi Yamada-san tidak makan apapun di pagi hari (何も食べません).',
                'points' => 10,
                'order' => 4,
            ],
            [
                'level' => 'N5',
                'section' => 'Bunpou',
                'question' => 'Lengkapilah partikel keterangan tempat aktivitas: 「きょう ぎんこう（　）おかねを おろします。」',
                'question_japanese' => 'きょう ぎんこう（　）おかねを おろします。',
                'option_a' => 'で (de)',
                'option_b' => 'に (ni)',
                'option_c' => 'へ (e)',
                'option_d' => 'から (kara)',
                'correct_answer' => 'A',
                'explanation' => 'Partikel で digunakan untuk menunjukkan tempat berlangsungnya suatu kegiatan aktif (menarik uang di bank = ぎんこうでおかねをおろす).',
                'points' => 10,
                'order' => 5,
            ],
            [
                'level' => 'N5',
                'section' => 'Kotoba',
                'question' => 'Pilihlah antonim (lawan kata) yang tepat untuk kata 【たかい】:',
                'question_japanese' => '「たかい (Takai)」の はんたいの ことばは どれですか。',
                'option_a' => 'やすい (Yasui)',
                'option_b' => 'ひくい (Hikui)',
                'option_c' => 'おもい (Omoi)',
                'option_d' => 'やすい / ひくい (Bisa keduanya)',
                'correct_answer' => 'D',
                'explanation' => 'Takai (高い) memiliki 2 arti: mahal (lawannya Yasui/安い) dan tinggi (lawannya Hikui/低い). Maka jawaban paling tepat mencakup keduanya.',
                'points' => 10,
                'order' => 6,
            ],

            // ==========================================
            // === JLPT N4 Questions (Dasar Pra-Kerja) ===
            // ==========================================
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
                'order' => 7,
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
                'explanation' => 'Pola [Kata Kerja Bentuk Kamus + まえに] berarti "sebelum...". Sebelum pergi ke Jepang harus membuat paspor.',
                'points' => 10,
                'order' => 8,
            ],
            [
                'level' => 'N4',
                'section' => 'Bunpou',
                'question' => 'Bentuk kalimat pasif (Ukemi) yang tepat: 「わたしは いぬに てを（　）。」 (Saya digigit anjing pada bagian tangan)',
                'question_japanese' => 'わたしは いぬに てを（　）。',
                'option_a' => 'かまれました (Kamaremashita)',
                'option_b' => 'かみました (Kamimashita)',
                'option_c' => 'かませました (Kamasemashita)',
                'option_d' => 'かまれません (Kamaremasen)',
                'correct_answer' => 'A',
                'explanation' => 'Kata kerja かみます (menggigit) bentuk pasifnya adalah かまれます. Bentuk lampau positifnya: かまれました.',
                'points' => 10,
                'order' => 9,
            ],
            [
                'level' => 'N4',
                'section' => 'Dokkai',
                'question' => 'Bacalah memo kantor: 「明日の会議は10時から第2会議室で行われます。各自、先週の資料を印刷して持参してください。」 Pertanyaan: 会議の前に何をしなければなりませんか。',
                'question_japanese' => '明日の会議は10時から第2会議室で行われます。各自、先週の資料を印刷して持参してください。',
                'option_a' => '第1会議室を予約する',
                'option_b' => '先週の資料をプリントアウトして持っていく',
                'option_c' => '10時半に会議室に行く',
                'option_d' => '新しい資料を作成する',
                'correct_answer' => 'B',
                'explanation' => 'Instruksi pada memo: "先週の資料を印刷して持参してください" = Harap mencetak dokumen minggu lalu dan membawanya masing-masing.',
                'points' => 10,
                'order' => 10,
            ],
            [
                'level' => 'N4',
                'section' => 'Bunpou',
                'question' => 'Pilihlah bentuk kondisional yang tepat: 「薬を（　）、熱が下がりました。」 (Setelah minum obat, demam saya turun)',
                'question_japanese' => 'くすりを（　）、ねつが さがりました。',
                'option_a' => '飲んだら (Nondara)',
                'option_b' => '飲むなら (Nomu nara)',
                'option_c' => '飲めば (Nomeba)',
                'option_d' => '飲むと (Nomu to)',
                'correct_answer' => 'A',
                'explanation' => 'Bentuk ~たら (~tara) digunakan saat kejadian B terjadi sebagai hasil / penemuan setelah tindakan A dilakukan di masa lampau.',
                'points' => 10,
                'order' => 11,
            ],
            [
                'level' => 'N4',
                'section' => 'Kotoba',
                'question' => 'Pilihlah arti kata yang paling tepat: 「工場で【故障】した機械を修理しました。」',
                'question_japanese' => 'こうじょうで 【こしょう】した きかいを しゅうりしました。',
                'option_a' => 'Kerusakan / Macet (Koshou)',
                'option_b' => 'Kecelakaan (Jiko)',
                'option_c' => 'Kebakaran (Kaji)',
                'option_d' => 'Kehilangan (Funsitsu)',
                'correct_answer' => 'A',
                'explanation' => '故障 (Koshou) berarti kerusakan atau mogok mekanis pada mesin / peralatan kerja.',
                'points' => 10,
                'order' => 12,
            ],

            // ==========================================
            // === JLPT N3 Questions (Menengah / Kerja) ===
            // ==========================================
            [
                'level' => 'N3',
                'section' => 'Bunpou',
                'question' => 'Pilihlah ungkapan tata bahasa bisnis yang tepat: 「部長、こちらの書類を（　）よろしいでしょうか。」',
                'question_japanese' => '部長、こちらの書類を（　）よろしいでしょうか。',
                'option_a' => 'ご覧になって (Goran ni natte)',
                'option_b' => '拝見しても (Haiken shitemo)',
                'option_c' => 'お見せして (Omise shite)',
                'option_d' => '見られても (Miraretemo)',
                'correct_answer' => 'B',
                'explanation' => '拝見する (haiken suru) adalah bentuk Kenjougo (merendah) dari 見る (melihat). Ketika meminta izin untuk melihat berkas dari atasan, gunakan 拝見してもよろしいでしょうか。',
                'points' => 10,
                'order' => 13,
            ],
            [
                'level' => 'N3',
                'section' => 'Dokkai',
                'question' => 'Bacalah aturan keselamatan kerja (Koujou Anzen): 「作業中は必ず保護メガネと安全靴を着用すること。万が一異常音がした場合は、直ちに非常停止ボタンを押し、リーダーに報告すること。」 Pertanyaan: 異常が発生した時、作業員が最初に行うべきことは何ですか。',
                'question_japanese' => '作業中は必ず保護メガネと安全靴を着用すること。万が一異常音がした場合は、直ちに非常停止ボタンを押し、リーダーに報告すること。',
                'option_a' => '機械をそのまま動かし続ける',
                'option_b' => 'すぐに非常停止ボタンを押す',
                'option_c' => '一人で機械を分解して修理する',
                'option_d' => '家に帰る',
                'correct_answer' => 'B',
                'explanation' => 'Teks menyatakan "直ちに非常停止ボタンを押し" (segera tekan tombol darurat) sebagai tindakan pertama saat terjadi suara aneh / abnormal.',
                'points' => 10,
                'order' => 14,
            ],
            [
                'level' => 'N3',
                'section' => 'Bunpou',
                'question' => 'Lengkapilah pola tata bahasa: 「先輩の助けが（　）、このプロジェクトは成功しなかっただろう。」',
                'question_japanese' => '先輩の助けが（　）、このプロジェクトは成功しなかっただろう。',
                'option_a' => 'なければ (Nakereba)',
                'option_b' => 'なかったら (Nakattara)',
                'option_c' => 'なかったなら (Nakatta nara)',
                'option_d' => 'なくては (Nakute wa)',
                'correct_answer' => 'B',
                'explanation' => 'Pola [Aがなかったら、Bは成功しなかっただろう] adalah bentuk pengandaian kontra-faktual (Seandainya tidak ada bantuan senior, proyek ini pasti tidak berhasil).',
                'points' => 10,
                'order' => 15,
            ],
            [
                'level' => 'N3',
                'section' => 'Kotoba',
                'question' => 'Pilihlah padanan kata kerja majemuk (Fukugoudoushi): 「最後まであきらめずに、やり【　】ことが大切だ。」',
                'question_japanese' => 'さいごまで あきらめずに、やり【　】ことが たいせつだ。',
                'option_a' => 'ぬく (Nuku - Yarinuita/Yarinuku)',
                'option_b' => 'だす (Dasu)',
                'option_c' => 'かける (Kakeru)',
                'option_d' => 'あわせる (Awaseru)',
                'correct_answer' => 'A',
                'explanation' => '~抜く (~nuku) menempel pada kata kerja masu-stem bermakna menyelesaikan sesuatu sampai tuntas dengan usaha keras pantang menyerah (やり抜く = menuntaskan sampai akhir).',
                'points' => 10,
                'order' => 16,
            ],
            [
                'level' => 'N3',
                'section' => 'Bunpou',
                'question' => 'Pilihlah ungkapan keharusan: 「締め切りは明日ですので、今日中に提出（　）。」',
                'question_japanese' => '締め切りは明日ですので、今日中に提出（　）。',
                'option_a' => 'せざるを得ない (Sezaru o enai)',
                'option_b' => 'するわけにはいかない (Suru wake ni wa ikanai)',
                'option_c' => 'するに違いない (Suru ni chigainai)',
                'option_d' => 'するべきではない (Suru beki dewanai)',
                'correct_answer' => 'A',
                'explanation' => '~ざるを得ない (~zaru o enai) berarti terpaksa / mau tidak mau harus melakukan karena situasi yang mendesak.',
                'points' => 10,
                'order' => 17,
            ],

            // ==========================================
            // === JFT-Basic A2 (Tokutei Ginou SSW) ===
            // ==========================================
            [
                'level' => 'JFT-Basic',
                'section' => 'Kaigo / Caregiver',
                'question' => 'Situasi Panti Lansia (Kaigo Shisetsu): 「田中さん、これからお風呂に入りましょうか。体調はいかがですか。」 Tanaka-san menjawab: 「少し寒気がします。」 Apa respon perawat (Kaigoshi) yang paling tepat?',
                'question_japanese' => '「田中さん、これからお風呂に入りましょうか。体調はいかがですか。」 「少し寒気がします。」',
                'option_a' => '無理して入りましょう。',
                'option_b' => 'そうですか。では、熱を測って今日は体を拭くだけにしましょう。',
                'option_c' => '大丈夫ですから、早く服を脱いでください。',
                'option_d' => '何も心配いりません。',
                'correct_answer' => 'B',
                'explanation' => 'Jika lansia merasa menggigil (寒気がする), perawat harus mengukur suhu tubuh dan mengganti mandi dengan mengelap tubuh (清拭/Seishiki) demi keselamatan pasien.',
                'points' => 10,
                'order' => 18,
            ],
            [
                'level' => 'JFT-Basic',
                'section' => 'Restoran / Food Service',
                'question' => 'Situasi Restoran Pelayanan Tamu: 「いらっしゃいませ。何名様でしょうか。」 Tamu menjawab: 「３人です。」 Respon pelayan yang sopan adalah:',
                'question_japanese' => '「いらっしゃいませ。何名様でしょうか。」 「３人です。」',
                'option_a' => '３名様ですね。こちらのお席へどうぞ。',
                'option_b' => '３人ね、あっちへ行って。',
                'option_c' => '座ってください。',
                'option_d' => '席はありません。',
                'correct_answer' => 'A',
                'explanation' => 'Standar pelayanan restoran Jepang menggunakan bentuk sopan: 「３名様ですね。こちらのお席へどうぞ。」 (Baik, untuk 3 orang, silakan ke meja sebelah sini).',
                'points' => 10,
                'order' => 19,
            ],
            [
                'level' => 'JFT-Basic',
                'section' => 'Seikatsu / Pemilahan Sampah',
                'question' => 'Peraturan Tempat Tinggal di Jepang: 「ペットボトルを捨てるとき、最初に何をしなければなりませんか。」',
                'question_japanese' => 'ペットボトルをすてるとき、さいしょに なにを しなければなりませんか。',
                'option_a' => 'キャップとラベルをはがして、中を水で洗う。',
                'option_b' => 'そのまま燃えるゴミの袋に入れる。',
                'option_c' => '夜中に外に置いておく。',
                'option_d' => '燃えないゴミと一緒に捨てる。',
                'correct_answer' => 'A',
                'explanation' => 'Di Jepang, botol plastik (PET) wajib dilepas tutup (cap) dan label plastiknya, lalu dibilas air sebelum dimasukkan ke kantong daur ulang khusus.',
                'points' => 10,
                'order' => 20,
            ],
            [
                'level' => 'JFT-Basic',
                'section' => 'Pabrik / Manufaktur',
                'question' => 'Komunikasi 5S di Tempat Kerja: 「リーダー、この部品のバリ取り作業が終わりました。次はどうすればいいですか。」 Respon atasan yang tepat:',
                'question_japanese' => '「リーダー、この部品のバリ取り作業が終わりました。次はどうすればいいですか。」',
                'option_a' => 'お疲れ様。寸法検査をしてから箱に並べてください。',
                'option_b' => 'もう帰ってください。',
                'option_c' => '知らなくていいです。',
                'option_d' => 'そのまま床に置いてください。',
                'correct_answer' => 'A',
                'explanation' => 'Komunikasi kerja standar (Hou-Ren-So): melapor tugas selesai, lalu menerima instruksi lanjutan untuk inspeksi ukuran (寸法検査) dan penataan produk.',
                'points' => 10,
                'order' => 21,
            ],
            [
                'level' => 'JFT-Basic',
                'section' => 'Kesehatan / Rumah Sakit',
                'question' => 'Situasi di Apotek: 「この薬は食後30分以内に、ぬるま湯で飲んでください。」 Kapan obat tersebut harus diminum?',
                'question_japanese' => '「この薬は食後30分以内に、ぬるま湯で飲んでください。」',
                'option_a' => 'Makan sebelum minum obat',
                'option_b' => 'Setelah selesai makan dalam waktu 30 menit dengan air hangat',
                'option_c' => 'Sebelum tidur dengan susu',
                'option_d' => 'Saat perut kosong di pagi hari',
                'correct_answer' => 'B',
                'explanation' => '食後 (Shokugo) = setelah makan, 30分以内 (sanjuppun inai) = dalam 30 menit, ぬるま湯 (nurumayu) = air hangat kuku.',
                'points' => 10,
                'order' => 22,
            ],
        ];

        foreach ($questions as $q) {
            ExamQuestion::create($q);
        }

        // 2. Seed WhatsApp Gateway Templates
        WhatsAppTemplate::truncate();

        $templates = [
            [
                'trigger_key' => 'new_lead',
                'title' => 'Salam Sambutan Pendaftaran Baru (Leads)',
                'message' => "Konnichiwa Kak {nama}! 🌸\n\nTerima kasih telah mendaftar formulir konsultasi program {program} di LPK Sahabat Jepang Indonesia.\n\nTim konselor kami siap membantu persiapan wawancara, pelatihan bahasa, dan pengurusan dokumen resmi ke Jepang. Apakah saat ini Kak {nama} bersedia untuk konsultasi online singkat via WhatsApp?\n\nSalam hangat,\nTim Konselor LPK Sahabat Jepang Indonesia 🇯🇵",
                'is_active' => true,
            ],
            [
                'trigger_key' => 'payment_receipt',
                'title' => 'Kuitansi Pembayaran Siswa',
                'message' => "Halo Kak {nama} (NIS: {nis})!\n\nPembayaran biaya program {program} telah kami terima dan tercatat di sistem akademik LPK Sahabat Jepang Indonesia.\n\nSisa tagihan berjalan: Rp {sisa_tanggungan}.\n\nTerima kasih atas kedisiplinan Anda. Semangat terus belajarnya! Gambatte kudasai! 💪",
                'is_active' => true,
            ],
            [
                'trigger_key' => 'due_reminder',
                'title' => 'Pengingat Jatuh Tempo Cicilan Biaya',
                'message' => "Pemberitahuan Akademik LPK Sahabat Jepang Indonesia 🌸\n\nYth. Kak {nama} (NIS: {nis}), kami menginformasikan sisa tanggungan cicilan pelatihan Anda sebesar Rp {sisa_tanggungan}.\n\nMohon melakukan konfirmasi pembayaran sebelum tanggal jatuh tempo angkatan agar proses matching Kaisha berjalan lancar.\n\nInfo rekening: BCA 123-456-7890 a.n LPK Sahabat Jepang Indonesia.",
                'is_active' => true,
            ],
            [
                'trigger_key' => 'interview_invite',
                'title' => 'Undangan Wawancara User Jepang (Mensetsu)',
                'message' => "Kabar Gembira untuk Kak {nama}! 🇯🇵🎉\n\nProfil Anda terpilih untuk mengikuti sesi wawancara langsung (Mensetsu) bersama Perusahaan Mitra Jepang untuk sektor {program}.\n\nJadwal Simulasi Wawancara:\n🗓️ Hari/Tgl: Menyesuaikan Jadwal Angkatan\n📍 Tempat: Ruang Zoom / Kampus LPK SJI\n\nHarap konfirmasi kesiapan dan kenakan pakaian formal (Kemeja Putih & Dasi). Ganbarimashou!",
                'is_active' => true,
            ],
            [
                'trigger_key' => 'brochure_download',
                'title' => 'Konfirmasi Unduh Brosur & Silabus Resmi',
                'message' => "Konnichiwa Kak {nama}! 🌸\n\nTerima kasih telah mengunduh {brosur} ({program}) dari LPK Sahabat Jepang Indonesia.\n\nDokumen resmi kurikulum, rincian biaya transparan, dan proyeksi gaji di Jepang dapat Anda akses kembali melalui tautan: {link}.\n\nApakah Kak {nama} memiliki pertanyaan seputar pendaftaran kelas atau beasiswa SMILE Project Kemenkes? Tim konselor kami siap membantu konsultasi gratis via WhatsApp.\n\nSalam hangat,\nLPK Sahabat Jepang Indonesia 🇯🇵",
                'is_active' => true,
            ],
        ];

        foreach ($templates as $t) {
            WhatsAppTemplate::create($t);
        }

        // 3. Seed Mitra Kemitraan SMK / BKK
        Affiliate::truncate();

        $affiliates = [
            [
                'code' => 'SMKN1JKT',
                'name' => 'Drs. Bambang Hariyanto (Koordinator BKK)',
                'type' => 'guru_bk',
                'institution_name' => 'SMK Negeri 1 Jakarta',
                'phone' => '081298765432',
                'email' => 'bkk@smkn1jakarta.sch.id',
                'reward_per_lead' => 500000,
                'bank_name' => 'Bank Mandiri',
                'bank_account_number' => '1230009876543',
                'bank_account_holder' => 'Bambang Hariyanto',
                'is_active' => true,
            ],
            [
                'code' => 'SMKN2BDG',
                'name' => 'Ibu Siti Nurhaliza, S.Pd',
                'type' => 'guru_bk',
                'institution_name' => 'SMK Negeri 2 Bandung',
                'phone' => '081387654321',
                'email' => 'siti.bk@smkn2bdg.sch.id',
                'reward_per_lead' => 500000,
                'bank_name' => 'BCA',
                'bank_account_number' => '8720192831',
                'bank_account_holder' => 'Siti Nurhaliza',
                'is_active' => true,
            ],
            [
                'code' => 'ALUMNI-RIZKY',
                'name' => 'Rizky Pratama (Alumni Tokutei Ginou Aichi)',
                'type' => 'alumni',
                'institution_name' => 'Alumni Angkatan 14 SJI (Toyota Kaisha)',
                'phone' => '081543219876',
                'email' => 'rizky.aichi@gmail.com',
                'reward_per_lead' => 600000,
                'bank_name' => 'BNI',
                'bank_account_number' => '0459182341',
                'bank_account_holder' => 'Rizky Pratama',
                'is_active' => true,
            ],
        ];

        foreach ($affiliates as $a) {
            Affiliate::create($a);
        }
    }
}
