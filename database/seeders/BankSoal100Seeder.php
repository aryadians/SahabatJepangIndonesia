<?php

namespace Database\Seeders;

use App\Models\ExamQuestion;
use Illuminate\Database\Seeder;

class BankSoal100Seeder extends Seeder
{
    public function run(): void
    {
        ExamQuestion::truncate();

        $allQuestions = [];
        $order = 1;

        // =========================================================
        // 1. JLPT N5 BANK SOAL (25 SOAL)
        // =========================================================
        $n5Data = [
            // Kotoba & Kanji
            ['Kotoba', 'Pilihlah cara baca kanji berikut: 「毎朝７時に【起きます】。」', 'まいあさ ７じに 【おきます】。', 'おきます (Okimasu)', 'ねます (Nemasu)', 'いきます (Ikimasu)', 'きます (Kimasu)', 'A', '起きます dibaca "okimasu" yang berarti bangun tidur.'],
            ['Kanji', 'Pilihlah kanji untuk kata yang bergaris bawah: 「あした ともだちと 【やま】へ いきます。」', 'あした ともだちと 【やま】へ いきます。', '川', '木', '山', '水', 'C', 'Kata "yama" (gunung) ditulis dengan kanji 山.'],
            ['Kotoba', 'Pilihlah kanji untuk kata: 「【ほん】を よみます。」', '【ほん】を よみます。', '本', '休', '体', '木', 'A', 'Kata "hon" (buku) ditulis dengan kanji 本.'],
            ['Kanji', 'Pilihlah cara baca kanji: 「【先生】の へやは あちらです。」', '【せんせい】の へやは あちらです。', 'せんせい (Sensei)', 'がくせい (Gakusei)', 'いしゃ (Isha)', 'かいしゃいん', 'A', 'Kanji 先生 dibaca "sensei" (guru/instruktur).'],
            ['Kotoba', 'Lawan kata dari 【あつい】 (panas cuaca) adalah:', '「あつい (Atsui)」の はんたいの ことばは どれですか。', 'さむい (Samui)', 'つめたい (Tsumetai)', 'すずしい (Suzushii)', 'ぬるい (Nurui)', 'A', 'Lawan kata panas cuaca (Atsui) adalah dingin cuaca (Samui/寒い).'],
            ['Kotoba', 'Pilihlah kata yang tepat: 「きょうは てんきが いいですから、【　】が あおいです。」', 'きょうは てんきが いいですから、【　】が あおいです。', 'そら (Sora - Langit)', 'うみ (Umi - Laut)', 'やま (Yama)', 'かわ (Kawa)', 'A', 'Langit (Sora) berwarna biru (Aoi) saat cuaca cerah.'],
            ['Kanji', 'Cara baca kanji: 「【水】を のみます。」', '【みず】を のみます。', 'みず (Mizu)', 'おちゃ (Ocha)', 'ジュース', 'ぎゅうにゅう', 'A', 'Kanji 水 dibaca "mizu" (air).'],
            ['Kotoba', 'Lengkapilah kalimat sapaan: Bertemu seseorang di siang hari mengucapkan:', 'ひるの あいさつは どれですか。', 'おはようございます', 'こんにちは (Konnichiwa)', 'こんばんは', 'さようなら', 'B', 'Sapaan siang hari dalam bahasa Jepang adalah こんにちは (Konnichiwa).'],
            // Bunpou
            ['Bunpou', 'Partikel yang tepat: 「わたしは にほんご（　）べんきょうします。」', 'わたしは にほんご（　）べんきょうします。', 'に', 'を (o / wo)', 'で', 'へ', 'B', 'Partikel を menandai objek kata kerja transitif (belajar bahasa Jepang).'],
            ['Bunpou', 'Partikel keterangan tempat: 「ぎんこう（　）おかねを おろします。」', 'ぎんこう（　）おかねを おろします。', 'で', 'に', 'へ', 'から', 'A', 'Partikel で menunjukkan tempat terjadinya kegiatan aktif.'],
            ['Bunpou', 'Partikel arah tujuan: 「らいしゅう とうきょう（　）いきます。」', 'らいしゅう とうきょう（　）いきます。', 'へ (e / he)', 'で', 'を', 'が', 'A', 'Partikel へ (dibaca e) menunjukkan arah tujuan perpindahan.'],
            ['Bunpou', 'Partikel waktu: 「まいあさ ６じ（　）おきます。」', 'まいあさ ６じ（　）おきます。', 'に', 'で', 'を', 'へ', 'A', 'Partikel に digunakan setelah keterangan waktu yang berangka pasti.'],
            ['Bunpou', 'Bentuk ajakan sopan: 「いっしょに ひるごはんを（　）か。」', 'いっしょに ひるごはんを（　）か。', 'たべませんか (Tabemasen ka)', 'たべますか', 'たべましたか', 'たべないですか', 'A', 'Pola [Masu-stem + ませんか] digunakan untuk mengajak secara sopan.'],
            ['Bunpou', 'Bentuk keinginan: 「わたしは あたらしい スマホが（　）です。」', 'わたしは あたらしい スマホが（　）です。', 'ほしい (Hoshii)', 'すき', 'じょうず', 'たい', 'A', 'Pola [Kata Benda + が + ほしい] menyatakan keinginan terhadap suatu benda.'],
            ['Bunpou', 'Bentuk sedang melakukan: 「いま、レポートを（　）います。」', 'いま、レポートを（　）います。', 'かいて (Kaite)', 'かき', 'かく', 'かいた', 'A', 'Pola [Kata Kerja Bentuk Te + います] menyatakan kegiatan yang sedang berlangsung.'],
            ['Bunpou', 'Larangan sopan: 「ここで しゃしんを とっては（　）。」', 'ここで しゃしんを とっては（　）。', 'いけません (Ikemasen)', 'いいです', 'ください', 'あります', 'A', 'Pola [Bentuk Te + は いけません] menyatakan larangan (tidak boleh).'],
            ['Bunpou', 'Izin sopan: 「この パソコンを つかっても（　）ですか。」', 'この パソコンを つかっても（　）ですか。', 'いい (Ii)', 'だめ', 'いけない', 'ほしい', 'A', 'Pola [Bentuk Te + も いいですか] digunakan untuk meminta izin.'],
            ['Bunpou', 'Kata tanya jumlah: 「きょうしつに がくせいが（　）いますか。」', 'きょうしつに がくせいが（　）いますか。', 'なんにん (Nannin)', 'なんじ', 'いくら', 'どこ', 'A', 'Kata tanya untuk menghitung jumlah orang adalah 何人 (なんにん/nannin).'],
            ['Bunpou', 'Perbandingan: 「くるまと でんしゃと（　）が はやいですか。」', 'くるまと でんしゃと（　）が はやいですか。', 'どちら (Dochira)', 'どれ', 'どこ', 'だれ', 'A', 'Untuk membandingkan 2 benda pilihan gunakan どちら (dochira).'],
            ['Bunpou', 'Menyambung kata sifat-i: 「この へやは ひろくて、（　）です。」', 'この へやは ひろくて、（　）です。', 'あかるい (Akarui)', 'あかるくて', 'あかるいな', 'あかるく', 'A', 'Pola penggabungan sifat-i [~くて + Sifat kedua bentuk desu].'],
            // Dokkai & Situasi
            ['Dokkai', 'Bacalah teks: 「山田さんは毎朝コーヒーを飲みます。パンは食べません。」 Pertanyaan: 山田さんは朝、何を食べますか。', '山田さんは毎朝コーヒーを飲みます。パンは食べません。', 'パンを食べます', 'コーヒーを食べます', '何も食べません', 'ごはんを食べます', 'C', 'Teks menyebutkan "pan wa tabemasen", artinya tidak makan apapun (何も食べません).'],
            ['Dokkai', 'Bacalah jadwal: 「日曜日：休み、月曜〜金曜：9:00〜17:00、土曜：9:00〜12:00。」 Kapan kantor tutup?', 'にちようび：やすみ。げつよう〜きんよう：９じ〜１７じ。', '日曜日 (Minggu)', '土曜日の午前', '月曜日の午後', '金曜日の朝', 'A', '日曜日 (Minggu) berstatus やすみ (tutup/libur).'],
            ['Dokkai', 'Pemberitahuan: 「図書館の中では静かにしてください。飲食はできません。」 Apa yang dilarang di perpustakaan?', 'としょかんの なかでは しずかにしてください。いんしょくは できません。', 'Makan dan minum', 'Membaca buku', 'Duduk', 'Belajar', 'A', '飲食 (inshoku) berarti makan dan minum.'],
            ['Dokkai', 'Pesan singkat: 「田中さん、風邪をひいたので今日の授業を休みます。スミス」 Siapa yang sakit?', 'かぜを ひいたので きょうの じゅぎょうを やすみます。スミス', 'Smith (スミス)', 'Tanaka (田中)', 'Sensei', 'Dokter', 'A', 'Pengirim pesan adalah Smith yang menyatakan sedang terkena flu.'],
            ['Dokkai', 'Nota belanja: 「リンゴ 3個 300円、バナナ 1房 200円、合計 500円。」 Berapa harga 1 buah apel?', 'リンゴ ３こ ３００えん。', '100円 (100 Yen)', '200円', '300円', '500円', 'A', '3 buah apel 300 yen, maka 1 buah apel berharga 100 yen.']
        ];

        foreach ($n5Data as $d) {
            $allQuestions[] = [
                'level' => 'N5',
                'section' => $d[0],
                'question' => $d[1],
                'question_japanese' => $d[2],
                'option_a' => $d[3],
                'option_b' => $d[4],
                'option_c' => $d[5],
                'option_d' => $d[6],
                'correct_answer' => $d[7],
                'explanation' => $d[8],
                'points' => 10,
                'order' => $order++,
            ];
        }

        // =========================================================
        // 2. JLPT N4 BANK SOAL (25 SOAL)
        // =========================================================
        $n4Data = [
            ['Kotoba', 'Pilihlah kata yang tepat: 「時間がありませんから、【　】歩きましょう。」', 'じかんが ありませんから、【　】あるきましょう。', '急いで (Isoide)', 'ゆっくり', 'だんだん', 'ぜんぜん', 'A', '急いで (isoide) berarti bergegas / cepat.'],
            ['Kanji', 'Cara baca kanji: 「工場の機械が【故障】しました。」', 'こうじょうの きかいが 【こしょう】しました。', 'こしょう (Koshou)', 'こじょう', 'こしょうじ', 'こしょ', 'A', '故障 dibaca koshou (kerusakan mekanis).'],
            ['Kotoba', 'Lengkapilah kata kerja: 「安全靴を【　】作業に入ります。」', 'あんぜんぐつを 【　】さぎょうに はいります。', 'はいて (Haite)', 'きて (Kite)', 'かぶって', 'はめて', 'A', 'Alas kaki/sepatu keselamatan menggunakan kata kerja はきます (haite).'],
            ['Kanji', 'Pilihlah kanji yang tepat: 「明日の会議の【よてい】を確認する。」', 'あしたの かいぎの 【よてい】を かくにんする。', '予定', '予言', '定食', '天気', 'A', 'Yotei (jadwal/rencana) ditulis dengan kanji 予定.'],
            ['Kotoba', 'Lawan kata dari 【ふくざつ】 (rumit) adalah:', '「ふくざつ (Fukuzatsu)」の はんたいは どれですか。', 'かんたん (Kantan - Mudah/Sederhana)', 'べんり', 'たいへん', 'しんせつ', 'A', 'Lawan kata dari Fukuzatsu (rumit) adalah Kantan (sederhana/mudah).'],
            ['Kotoba', 'Arti ungkapan: 「ごちそうさまでした」 diucapkan saat:', '「ごちそうさまでした」は いつ いいますか。', 'Setelah selesai makan', 'Sebelum mulai makan', 'Saat berangkat kerja', 'Saat pulang ke rumah', 'A', 'Gochisousama deshita diucapkan setelah selesai menikmati makanan.'],
            ['Kanji', 'Cara baca kanji: 「【注意】してください。」', '【ちゅうい】してください。', 'ちゅうい (Chuui)', 'しゅうい', 'ちゅい', 'ちょうい', 'A', '注意 dibaca chuui yang berarti perhatian / berhati-hati.'],
            // Bunpou N4
            ['Bunpou', 'Pola tata bahasa: 「日本へ 行く（　）、パスポートを つくります。」', 'にほんへ いく（　）、パスポートを つくります。', 'まえに (Mae ni)', 'あとで', 'ながら', 'とき', 'A', 'Pola [K. Kerja Kamus + まえに] bermakna "sebelum".'],
            ['Bunpou', 'Bentuk pasif (Ukemi): 「わたしは いぬに てを（　）。」', 'わたしは いぬに てを（　）。', 'かまれました (Kamaremashita)', 'かみました', 'かませました', 'かまれます', 'A', 'Bentuk pasif lampau dari かみます (menggigit) adalah かまれました.'],
            ['Bunpou', 'Bentuk kausatif (Shieki): 「部長は 社員を 出張に（　）。」', 'ぶちょうは しゃいんを しゅっちょうに（　）。', '行かせました (Ikasemashita)', '行かれました', '行きました', '行きます', 'A', 'Bentuk menyuruh/mengizinkan (kausatif) dari 行く adalah 行かせる (Ikasemashita).'],
            ['Bunpou', 'Bentuk keharusan: 「明日までに レポートを 出さ（　）。」', 'あしたまでに レポートを ださ（　）。', 'なければなりません (Nakereba narimasen)', 'なくてもいいです', 'てはいけません', 'たほうがいいです', 'A', 'Pola [Bentuk Nai + ければなりません] menyatakan keharusan mutlak.'],
            ['Bunpou', 'Bentuk saran: 「風邪ですから、早く 寝た（　）いいですよ。」', 'かぜですから、はやく ねた（　）いいですよ。', 'ほうが (Hou ga)', 'まえに', 'ように', 'ために', 'A', 'Pola [Bentuk Ta + ほうがいい] digunakan untuk memberi saran yang baik.'],
            ['Bunpou', 'Bentuk tujuan: 「日本語が 上手に なる（　）、毎日 練習しています。」', 'にほんごが じょうずに なる（　）、まいにち れんしゅうしています。', 'ように (You ni)', 'ために', 'まえに', 'あとで', 'A', 'Pola [K. Kerja Potensial/Non-volisional + ように] menyatakan tujuan agar tercapai.'],
            ['Bunpou', 'Bentuk simultan: 「音楽を（　）勉強します。」', 'おんがくを（　）べんきょうします。', '聞きながら (Kikinagara)', '聞いて', '聞くまえに', '聞いたあとで', 'A', 'Pola [Masu-stem + ながら] menyatakan melakukan dua pekerjaan bersamaan.'],
            ['Bunpou', 'Bentuk dugaan: 「空が 暗いですから、雨が（　）そうです。」', 'そらが くらいですから、あめが（　）そうです。', '降り (Furi)', '降る', '降った', '降らない', 'A', 'Pola [Masu-stem + そうです] menyatakan kelihatannya akan terjadi.'],
            ['Bunpou', 'Pola Tara: 「薬を（　）、熱が 下がりました。」', 'くすりを（　）、ねつが さがりました。', '飲んだら (Nondara)', '飲むなら', '飲めば', '飲むと', 'A', 'Pola ~たら menyatakan kejadian yang terjadi setelah aksi selesai.'],
            ['Bunpou', 'Bentuk usaha: 「忘れ物を しない（　）してください。」', 'わすれものを しない（　）してください。', 'ように (You ni)', 'ために', 'ことに', 'はず', 'A', 'Pola [K. Kerja Nai + ようにしてください] berarti berusahalah untuk tidak...'],
            ['Bunpou', 'Pola Te-shimau: 「パスポートを（　）しまいました。」', 'パスポートを（　）しまいました。', 'なくして (Nakushite)', 'なくす', 'なくした', 'なくさない', 'A', 'Pola [Bentuk Te + しまいました] menyatakan penyesalan atas ketidaksengajaan.'],
            // Dokkai & Situasi N4
            ['Dokkai', 'Memo Kantor: 「明日の会議は10時から第2会議室で行われます。各自資料を印刷して持参してください。」 Apa yang harus dibawa?', '明日の会議は10時から第2会議室で行われます。各自資料を持参してください。', 'Dokumen cetak (資料)', 'Laptop baru', 'Makanan', 'Kamera', 'A', 'Memo menyatakan "資料を持参してください" (bawa dokumen masing-masing).'],
            ['Dokkai', 'Instruksi Mesin: 「使用後は電源を切り、プラグをコンセントから抜いてください。」 Apa langkah setelah memakai mesin?', 'しようごは でんげんを きり、プラグを ぬいてください。', 'Matikan saklar & cabut kabel', 'Biarkan menyala', 'Siram air', 'Pindahkan ruangan', 'A', '電源を切り (matikan power) dan プラグを抜く (cabut steker).'],
            ['Dokkai', 'Petunjuk Obat: 「1回2錠、毎食後30分以内に服用すること。」 Berapa butir obat sekali minum?', '1回2錠、毎食後30分以内に服用すること。', '2 Butir (2錠)', '1 Butir', '3 Butir', '30 Butir', 'A', '1回2錠 berarti 2 butir per satu kali minum.'],
            ['Dokkai', 'Email Izin Sakit: 「熱が38度あるため、本日の勤務を欠勤させていただきます。」 Apa alasan tidak masuk kerja?', 'ねつが 38ど あるため、けっきんさせていただきます。', 'Demam 38 derajat', 'Liburan', 'Ban bocor', 'Acara keluarga', 'A', 'Alasan izin kerja adalah demam tinggi 38 derajat (熱が38度).'],
            ['Dokkai', 'Aturan Asrama: 「ゴミ出しは朝8時までに指定の場所に出してください。夜間は禁止です。」 Kapan dilarang membuang sampah?', 'ゴミ出しは朝8時まで。夜間は禁止です。', 'Malam hari (夜間)', 'Pagi hari', 'Siang hari', 'Hari kerja', 'A', 'Teks menegaskan "夜間は禁止" (malam hari dilarang).'],
            ['Dokkai', 'Papan Pengumuman: 「本日は点検のため、エレベーターは終日ご利用いただけません。」 Apa yang sedang dilakukan?', 'てんけんのため、エレベーターは ごりよういただけません。', 'Inspeksi/Maintenance lift', 'Lift rusak selamanya', 'Gedung tutup', 'Pengecatan', 'A', '点検 (tenken) berarti inspeksi berkala / pemeliharaan teknis.'],
            ['Dokkai', 'Memo Lembur: 「本日17時以降残業ができる方は15時までにリーダーへ申し出てください。」 Batas waktu konfirmasi lembur?', 'ほんじつ 15じまでに リーダーへ もうしでてください。', 'Pukul 15:00', 'Pukul 17:00', 'Besok pagi', 'Tengah malam', 'A', 'Batas lapor kesediaan lembur adalah jam 15:00 (15時までに).']
        ];

        foreach ($n4Data as $d) {
            $allQuestions[] = [
                'level' => 'N4',
                'section' => $d[0],
                'question' => $d[1],
                'question_japanese' => $d[2],
                'option_a' => $d[3],
                'option_b' => $d[4],
                'option_c' => $d[5],
                'option_d' => $d[6],
                'correct_answer' => $d[7],
                'explanation' => $d[8],
                'points' => 10,
                'order' => $order++,
            ];
        }

        // =========================================================
        // 3. JLPT N3 BANK SOAL (25 SOAL)
        // =========================================================
        $n3Data = [
            ['Bunpou', 'Keigo Merendah (Kenjougo): 「部長、こちらの書類を（　）よろしいでしょうか。」', '部長、こちらの書類を（　）よろしいでしょうか。', '拝見しても (Haiken shitemo)', 'ご覧になって', 'お見せして', '見られても', 'A', '拝見する (haiken suru) adalah bentuk merendah (Kenjougo) dari kata kerja 見る (melihat).'],
            ['Bunpou', 'Keigo Menghormati (Sonkeigo): 「社長は もう（　）ました。」', '社長は もう（　）ました。', 'お帰りになり (Okaeri ni nari)', '参り', '申され', '拝見し', 'A', 'Bentuk Sonkeigo resmi [お + Masu-stem + になります] untuk menghormati atasan.'],
            ['Bunpou', 'Pola N3: 「先輩の助けが（　）、この仕事は終わらなかっただろう。」', '先輩の助けが（　）、この仕事は終わらなかっただろう。', 'なかったら (Nakattara)', 'なければ', 'なくては', 'ないなら', 'A', 'Pola pengandaian hipotesis lampau: [Aがなかったら、Bは〜なかっただろう].'],
            ['Bunpou', 'Pola N3: 「締め切りは明日なので、今日中に提出（　）。」', '締め切りは明日なので、今日中に提出（　）。', 'せざるを得ない (Sezaru o enai)', 'するわけがない', 'するはずがない', 'するべきではない', 'A', '~ざるを得ない berarti mau tidak mau terpaksa harus melakukan karena keadaan.'],
            ['Bunpou', 'Fukugoudoushi: 「最後まであきらめずに、やり（　）ことが大切だ。」', 'さいごまで あきらめずに、やり（　）ことが たいせつだ。', '抜く (Nuku - Yarinuita/Yarinuku)', '出す', 'かける', 'あわせる', 'A', '~抜く (~nuku) berarti menyelesaikan tugas berat sampai tuntas dengan tekad baja.'],
            ['Bunpou', 'Pola N3: 「この仕事は 経験の 有無に（　）、誰でも 応募できます。」', 'この仕事は 経験の 有無に（　）、誰でも 応募できます。', 'かかわらず (Kakawarazu)', 'したがって', 'たいして', 'くらべて', 'A', '~にかかわらず (~ni kakawarazu) berarti "tanpa memandang / terlepas dari...".'],
            ['Bunpou', 'Pola N3: 「雨が 降らない（　）、試合は 予定通り 行われます。」', '雨が 降らない（　）、試合は 予定通り 行われます。', 'かぎり (Kagiri)', 'ばかり', 'とおり', 'せいで', 'A', '~かぎり (~kagiri) bermakna "selama / asalkan kondisi A terpenuhi...".'],
            ['Bunpou', 'Pola N3: 「彼は 日本に 5年も 住んでいる（　）、漢字が ほとんど 読めない。」', '彼は 日本に 5年も 住んでいる（　）、漢字が ほとんど 読めない。', 'わりに (Wari ni)', 'ために', 'せいで', 'おかげで', 'A', '~わりに (~wari ni) digunakan saat kenyataan berlawanan dari standar yang diharapkan.'],
            ['Kotoba', 'Arti istilah bisnis: 「【見積書】を 取引先に 送付してください。」', '【みつもりしょ】を とりひきさきに そうふしてください。', 'Surat Penawaran Harga (Quotation)', 'Surat Perjanjian Kerja', 'Kuitansi Resmi', 'Laporan Keuangan', 'A', '見積書 (Mitsumorisho) adalah dokumen estimasi biaya / surat penawaran harga.'],
            ['Kotoba', 'Arti istilah industri: 「作業前の【朝礼】で 本日の目標を確認する。」', 'さぎょうまえの 【ちょうれい】で ほんじつの もくひょうを かくにんする。', 'Briefing Pagi (Chourei)', 'Makan Siang Bersama', 'Senam Sore', 'Evaluasi Bulanan', 'A', '朝礼 (Chourei) adalah apel briefing pagi rutin di perusahaan Jepang.'],
            ['Kotoba', 'Arti istilah 5S: 「【整理・整頓】を 徹底してください。」', '【せいり・せいとん】を てっていしてください。', 'Ringkas & Rapi (Sort & Set in Order)', 'Cepat & Tanggap', 'Hemat & Bersih', 'Disiplin & Santai', 'A', '整理 (Seiri = memilah yang perlu) dan 整頓 (Seiton = menata rapi pada tempatnya).'],
            ['Kanji', 'Cara baca kanji: 「安全第一で【作業】を進める。」', 'あんぜんだいいちで 【さぎょう】を すすめる。', 'さぎょう (Sagyou)', 'さくぎょう', 'しぎょう', 'さごう', 'A', 'Kanji 作業 dibaca sagyou (aktivitas operasional kerja).'],
            ['Kanji', 'Cara baca kanji: 「お客様への【対応】を 丁寧にする。」', 'おきゃくさまへの 【たいおう】を ていねいにする。', 'たいおう (Taiou)', 'たいとう', 'ついおう', 'たおう', 'A', 'Kanji 対応 dibaca taiou (penanganan / respon layanan).'],
            ['Bunpou', 'Pola N3: 「昨日の夜は 疲れて、服を 着た（　）寝てしまった。」', 'きのうのよるは つかれて、ふくを きた（　）ねてしまった。', 'まま (Mama)', 'きり', 'ばかり', 'とおり', 'A', 'Pola [Bentuk Ta + まま] berarti dalam kondisi tetap seperti itu tanpa berubah.'],
            ['Bunpou', 'Pola N3: 「子供の（　）素直な 意見を 言ってください。」', 'こどもの（　）すなおな いけんを いってください。', 'ような (You na)', 'そうな', 'らしい', 'みたい', 'A', 'Pola [Kata Benda + のような] berarti perumpamaan "seperti...".'],
            ['Bunpou', 'Pola N3: 「練習すれば する（　）、日本語が 上手になります。」', 'れんしゅうすれば する（　）、にほんごが じょうずになります。', 'ほど (Hodo)', 'くらい', 'ばかり', 'だけ', 'A', 'Pola [~ば ~するほど] berarti "semakin... maka semakin...".'],
            ['Bunpou', 'Pola N3: 「この製品は デザインが 良い（　）、機能性にも 優れている。」', 'このせいひんは デザインが よい（　）、きのうせいにも すぐれている。', 'ばかりでなく (Bakari de naku)', 'にかぎらず', 'につれて', 'をはじめ', 'A', '~ばかりでなく berarti "tidak hanya... tetapi juga...".'],
            // Dokkai N3
            ['Dokkai', 'K3 Pabrik: 「作業中は必ず保護メガネと安全靴を着用すること。万が一異常音がした場合は、直ちに非常停止ボタンを押し、リーダーに報告すること。」 Tindakan pertama saat ada suara aneh?', '作業中は必ず保護具を着用。異常時は直ちに非常停止ボタンを押すこと。', 'Tekan tombol darurat (非常停止ボタン)', 'Terus bekerja', 'Bongkar sendiri', 'Pulang', 'A', 'Teks instruksi: 直ちに非常停止ボタンを押す (segera tekan tombol darurat).'],
            ['Dokkai', 'Etika Hou-Ren-So: 「問題が発生した時は、自分で勝手に判断せず、直ちに上司へ報告・連絡・相談を行うこと。」 Kapan harus melapor?', 'もんだいが はっせいした ときは、じ直ちに ほうれんそうを おこなう。', 'Segera saat masalah muncul', 'Setelah pulang', 'Minggu depan', 'Tidak perlu lapor', 'A', 'Prinsip Hou-Ren-So mengharuskan segera melapor saat kendala terjadi.'],
            ['Dokkai', 'Manual Kualitas (Hinshitsu): 「不良品を発見した場合は、赤色のコンテナに分別し、良品と混ざらないよう区別して保管すること。」 Di mana produk cacat ditaruh?', 'ふりょうひんを はっけんした ばあいは、あかいろの コンテナに ぶんべつする。', 'Wadah merah (赤色のコンテナ)', 'Kotak biru', 'Lantai pabrik', 'Tempat sampah umum', 'A', 'Produk cacat (不良品) wajib dipisahkan ke wadah khusus berwarna merah.'],
            ['Dokkai', 'Email Bisnis: 「お世話になっております。来週火曜日の訪問の件、14時にお伺いしてもよろしいでしょうか。」 Maksud email?', '来週火曜日14時にお伺いしてもよろしいでしょうか。', 'Konfirmasi jadwal kunjungan jam 14:00', 'Membatalkan pesanan', 'Meminta diskon', 'Mengajak makan malam', 'A', 'Email bertujuan mengonfirmasi jam kunjungan kerja pada Selasa jam 14:00.'],
            ['Dokkai', 'Prosedur Lembur: 「月間残業時間が40時間を超える場合は、産業医による面談が必要となります。」 Konsekuensi lembur > 40 jam?', 'げっかん ざんぎょうが 40じかんを こえる ばあい、さんぎょうい めんだんが ひつよう。', 'Konsultasi dokter perusahaan (面談)', 'Potong gaji', 'Diberi bonus instan', 'Wajib cuti selamanya', 'A', 'Aturan kesehatan kerja mewajibkan konseling dengan dokter industri (産業医面談).'],
            ['Dokkai', 'Slip Gaji (Kyuuyo Meisai): 「基本給 200,000円、残業手当 35,000円、控除合計（社会保険・税金）40,000円、差引支給額 195,000円。」 Berapa gaji bersih (Take-home pay)?', 'さしひき しきゅうがく 195,000えん。', '195,000 Yen', '200,000 Yen', '235,000 Yen', '40,000 Yen', 'A', '差引支給額 (gaji bersih setelah potongan) adalah 195,000 Yen.'],
            ['Dokkai', 'Aturan Apartemen: 「夜21時以降は洗濯機や掃除機の使用を控え、隣人に配慮してください。」 Apa yang dilarang setelah jam 21:00?', 'よる 21じ いこうは せんたくきや そうじきの しようを ひかえること。', 'Menggunakan mesin cuci / bising', 'Tidur', 'Membaca buku', 'Menyalakan lampu', 'A', 'Setelah pukul 21:00 dilarang menyalakan peralatan berisik seperti mesin cuci/vacuum.'],
            ['Dokkai', 'Pengumuman Cuaca (Taifuu): 「大型台風接近のため、明日の出勤については明朝6時に緊急連絡網にて指示します。」 Kapan kepastian masuk kerja diumumkan?', 'たいふう せっきんのため、あすの しゅっきんは あす あさ6じに れんらくする。', 'Besok pagi jam 06:00', 'Malam ini jam 24:00', 'Minggu depan', 'Tidak diumumkan', 'A', 'Keputusan operasional kerja saat badai akan dikabarkan jam 06:00 pagi besok.']
        ];

        foreach ($n3Data as $d) {
            $allQuestions[] = [
                'level' => 'N3',
                'section' => $d[0],
                'question' => $d[1],
                'question_japanese' => $d[2],
                'option_a' => $d[3],
                'option_b' => $d[4],
                'option_c' => $d[5],
                'option_d' => $d[6],
                'correct_answer' => $d[7],
                'explanation' => $d[8],
                'points' => 10,
                'order' => $order++,
            ];
        }

        // =========================================================
        // 4. JFT-BASIC A2 (TOKUTEI GINOU SSW) (25 SOAL)
        // =========================================================
        $jftData = [
            ['Kaigo / Lansia', 'Situasi Panti Lansia: 「田中さん、これからお風呂に入りましょうか。」 Tanaka-san menjawab: 「少し寒気がします。」 Respon perawat yang tepat:', '「田中さん、これからお風呂に入りましょうか。」 「少し寒気がします。」', '熱を測って、今日は清拭（体を拭く）にしましょう。', '無理して入りましょう。', '早く服を脱いでください。', '何もしなくていいです。', 'A', 'Jika pasien menggigil (寒気), ukur suhu tubuh dan ganti mandi dengan mengelap tubuh demi keselamatan.'],
            ['Kaigo / Lansia', 'Bantuan Makan: 「鈴木さん、ご飯を食べる前に、まず【　】をしましょう。」', 'ご飯を食べる前に、まず【　】をしましょう。', '手洗いとお口の体操 (Cuci tangan & senam mulut)', '激しい運動', '冷たい水を一気飲み', '就寝の準備', 'A', 'Sebelum makan, lansia diarahkan mencuci tangan dan senam rongga mulut untuk mencegah tersedak (Enge).'],
            ['Kaigo / Lansia', 'Pemindahan Pasien (Isetsu): Saat memindahkan pasien ke kursi roda, posisi rem kursi roda harus:', '車いすに移乗するとき、ブレーキは どうしますか。', '必ず両側のブレーキをしっかりかける (Kunci kedua rem)', 'ブレーキはかけない', '片方だけかける', '椅子を動かしながら乗せる', 'A', 'Rem kursi roda wajib terkunci rapat di kedua sisi untuk menghindari risiko pasien jatuh.'],
            ['Restoran', 'Pelayanan Tamu: 「いらっしゃいませ。何名様でしょうか。」 Tamu menjawab: 「２人です。」 Respon pelayan sopan:', '「いらっしゃいませ。何名様でしょうか。」 「２人です。」', '２名様ですね。こちらのお席へご案内いたします。', '２人ね、あっちへ行って。', '席はありません。', '早く座って。', 'A', 'Ungkapan standar perhotelan/restoran: 「２名様ですね。こちらのお席へご案内いたします。」'],
            ['Restoran', 'Mengantar Makanan: Saat menyajikan pesanan ke meja tamu, pelayan mengucapkan:', '料理を テーブルに 運ぶときの 挨拶は：', 'お待たせいたしました。ご注文のラーメンでございます。', '食べなさい。', '早く食べてください。', '終わりました。', 'A', 'Ungkapan sopan: 「お待たせいたしました。ご注文の〜でございます。」'],
            ['Restoran', 'Pembersihan Meja (Bakkingu): Saat tamu selesai makan dan meninggalkan meja, tindakan standar:', 'お客様が 帰られた後の テーブル清掃：', 'アルコール消毒液でテーブルと椅子を拭く', '水だけをかける', '何もしない', '新しい皿をそのまま置く', 'A', 'Meja dan kursi wajib dilap dengan cairan disinfektan alkohol berstandar sanitasi Jepang.'],
            ['Pabrik / Manufaktur', 'Laporan Kerja Selesai: 「リーダー、この部品のバリ取り作業が終わりました。次はどうしますか。」 Respon atasan:', 'バリ取り作業が終わりました。次はどうしますか。', 'お疲れ様。寸法検査をしてから箱に並べてください。', 'もう帰ってください。', '知らなくていいです。', '床に置いてください。', 'A', 'Atasan memberikan instruksi lanjutan untuk inspeksi ukuran (寸法検査) dan penataan produk.'],
            ['Pabrik / Manufaktur', 'Alat Pelindung Diri (APD): Di area pengelasan logam (Yousetsu), APD yang wajib dipakai:', '溶接作業エリアで 必要な 保護具は：', '遮光面（保護マスク）と耐熱革手袋', 'サンダル', 'Tシャツのみ', '帽子のみ', 'A', 'Pengelasan membutuhkan helm kedok pelindung mata anti-silau dan sarung tangan kulit tahan panas.'],
            ['Pabrik / Manufaktur', 'Prosedur Darurat: Jika melihat tumpahan oli di lantai pabrik, tindakan yang benar:', '工場の床に 油が こぼれているのを 見つけた時：', '直ちにウエス（布）で拭き取り、滑り止め処置をする', '見なかったことにして通り過ぎる', '水で流す', '走って逃げる', 'A', 'Tumpahan oli harus segera dibersihkan dengan kain lap agar tidak mencelakakan rekan kerja.'],
            ['Pertanian / Nougyou', 'Pemanenan Sayur: 「このキャベツは固く締まっているものを、根元から包丁で切り取ってください。」 Kriteria panen kubis?', 'かたく しまっているものを、ねもとから ほうちょうで きりとる。', 'Kubis yang padat keras, dipotong dari pangkal akar', 'Kubis yang masih lembek', 'Kubis yang ada ulatnya', 'Dipetik dengan ditarik daunnya', 'A', 'Petunjuk panen: potong kubis yang padat dari pangkal batang dengan pisau khusus.'],
            ['Pertanian / Nougyou', 'Penyiraman Tanaman: 「夏の水やりは日中の高温時を避け、早朝か夕方に行ってください。」 Waktu terbaik menyiram?', 'なつの みずやりは そうちょうか ゆうがたに おこなう。', 'Pagi-pagi sekali atau sore hari', 'Tepat tengah hari saat terik', 'Tengah malam', 'Seminggu sekali', 'A', 'Di musim panas, penyiraman dilakukan saat pagi hari (早朝) atau sore hari (夕方).'],
            ['Perhotelan', 'Housekeeping Kamar: Saat membersihkan kamar tamu, menemukan dompet tertinggal di kasur, tindakan:', '客室清掃中に 忘れ物の 財布を 見つけた時：', '触らずに位置を記録し、直ちにフロントへ届けて保管する', '自分のポケットに入れる', 'ゴミ箱に捨てる', 'そのまま置いておく', 'A', 'Barang tertinggal (忘れ物) wajib langsung diserahkan ke bagian Front Desk untuk dicatat resmi.'],
            ['Perhotelan', 'Menyapa Tamu di Koridor: Saat berpapasan dengan tamu hotel di lorong, staf mengucapkan:', '廊下で お客様と すれ違うときの 挨拶：', 'いらっしゃいませ。おはようございます／こんにちは。', '何ですか？', 'どいてください。', '見ないでください。', 'A', 'Staf wajib menyapa ramah dengan senyum dan membungkuk hormat (Eshaku).'],
            ['Konstruksi', 'Kerja Ketinggian (Kousho Sagyou): Bekerja di atas scaffolding ketinggian 2 meter ke atas wajib memakai:', '高所作業で 必ず 使用する 安全具：', 'フルハーネス型安全帯（墜落制止用器具）', '普通のベルト', 'スニーカー', '軍手のみ', 'A', 'Kerja ketinggian di Jepang mewajibkan pemakaian full harness safety belt anti-jatuh.'],
            ['Konstruksi', 'Tanda Isyarat Crane: Saat crane mengangkat beban berat (Tamagake), pejalan kaki di bawah:', 'クレーンで 荷物を 吊り上げている時、下の人は：', '吊り荷の下には絶対に入らず、安全距離を保つ', '荷物の下で作業する', 'クレーンに触る', '座って待つ', 'A', 'Dilarang keras berdiri di bawah muatan derek gantung (吊り荷の下立ち入り禁止).'],
            ['Kesehatan / Apotek', 'Minum Obat: 「この薬は毎食後30分以内に、ぬるま湯で飲んでください。」 Cara minum obat?', 'このくすりは まいしょくご 30ぷんいないに、ぬるまゆで のんでください。', 'Dalam 30 menit setelah makan dengan air hangat', 'Sebelum makan dengan air es', 'Saat lapar dengan susu', 'Sebelum tidur', 'A', '食後30分以内 = dalam 30 menit sehabis makan, ぬるま湯 = air hangat kuku.'],
            ['Kesehatan / Klinik', 'Gejala Penyakit: 「3日前から喉が痛くて、咳と微熱が続いています。」 Gejala apa yang dialami?', 'のどが いたくて、せきと びねつが つづいている。', 'Sakit tenggorokan, batuk, dan demam ringan', 'Sakit perut dan diare', 'Kaki patah', 'Mata gatal', 'A', '喉が痛い (tenggorokan sakit), 咳 (batuk), 微熱 (demam ringan).'],
            ['Kehidupan / Bank', 'Buka Rekening: 「口座開設には、在留カードと印鑑（またはサイン）が必要です。」 Dokumen wajib?', 'こうざかいせつには ざいりゅうカードと いんかんが ひつよう。', 'Kartu Izin Tinggal (Zairyu Card) & Stempel/Tanda tangan', 'Kartu Pelajar saja', 'Foto selfie', 'Tiket pesawat', 'A', 'Buka rekening tabungan bank Jepang memerlukan Zairyu Card dan stempel Hanko / tanda tangan.'],
            ['Kehidupan / Transport', 'Naik Kereta: 「ICカード（Suica/Pasmo）の残高が不足している時は、精算機でチャージしてください。」 Apa yang harus dilakukan jika saldo kurang?', 'ICカードの ざんだかが ふそくの ときは、せいさんきで チャージする。', 'Isi ulang saldo di mesin Seisanki', 'Lompat pintu keluar', 'Buang kartunya', 'Beli tiket baru', 'A', 'Bila saldo kurang saat di gate keluar stasiun, lakukan top-up di mesin 精算機 (Seisanki).'],
            ['Kehidupan / Supermarket', 'Kasir Belanja: 「レジ袋はご利用になりますか。1枚5円になります。」 Apa yang ditanyakan kasir?', 'レジぶくろは ごりようになりますか。', 'Apakah Anda membutuhkan kantong plastik belanja?', 'Mau bayar tunai atau kartu?', 'Mau beli sayur?', 'Ada kartu member?', 'A', 'レジ袋 (Rejibukuro) adalah kantong kresek belanjaan yang berbayar (5 Yen).'],
            ['Kehidupan / Sampah', 'Membuang Botol: 「ペットボトルを捨てる時、キャップとラベルをはがして分別してください。」 Syarat membuang botol plastik?', 'キャップと ラベルを はがして ぶんべつする。', 'Lepas tutup botol dan plastik labelnya', 'Langsung buang utuh', 'Bakar di halaman', 'Campur dengan sisa makanan', 'A', 'Botol plastik di Jepang wajib dilepas tutup dan labelnya sebelum dibuang ke tong daur ulang.'],
            ['Kehidupan / Darurat', 'Gempa Bumi (Jishin): Saat terjadi gempa bumi kuat di dalam ruangan, tindakan keselamatan pertama:', 'じしんが おきたとき、さいしょに とるべき こうどう：', '机の下に入り、頭を守る (Masuk ke bawah meja melindungi kepala)', '窓を開けて外に飛び降りる', '大声で叫んで走り回る', 'エレベーターに乗る', 'A', 'Tindakan mitigasi gempa: lindungi kepala dan berlindung di bawah meja kokoh.'],
            ['Kehidupan / Darurat', 'Nomor Telepon Darurat: Nomor darurat kebakaran dan ambulans medis di Jepang adalah:', '日本の 火事・救急車の 緊急通報電話番号は：', '119', '110', '911', '112', 'A', 'Nomor darurat pemadam kebakaran dan ambulans di Jepang adalah 119 (Polisi = 110).'],
            ['Kehidupan / Kantor Pos', 'Kirim Surat: 「この手紙をインドネシアへエアメール（航空便）で送りたいのですが、いくらですか。」 Layanan pos apa yang diminta?', 'インドネシアへ エアメール（こうくうびん）で おくりたい。', 'Kirim surat via pos udara ke Indonesia', 'Kirim paket laut', 'Beli perangko lokal', 'Kirim uang tunai', 'A', 'エアメール (Airmail / 航空便) adalah layanan pengiriman surat via jalur penerbangan internasional.'],
            ['Kehidupan / Apartemen', 'Lapor Kerusakan: 「アパートのエアコンから水が漏れてきました。管理会社に連絡してください。」 Masalah yang terjadi?', 'アパートの エアコンから みずが もれてきた。', 'AC apartemen bocor air', 'Pintu rusak', 'Lampu mati', 'Kompor padam', 'A', 'エアコンから水が漏れる = Air bocor menetes dari unit pendingin ruangan (AC).']
        ];

        foreach ($jftData as $d) {
            $allQuestions[] = [
                'level' => 'JFT-Basic',
                'section' => $d[0],
                'question' => $d[1],
                'question_japanese' => $d[2],
                'option_a' => $d[3],
                'option_b' => $d[4],
                'option_c' => $d[5],
                'option_d' => $d[6],
                'correct_answer' => $d[7],
                'explanation' => $d[8],
                'points' => 10,
                'order' => $order++,
            ];
        }

        // Simpan seluruh 100 Soal ke Database
        foreach ($allQuestions as $q) {
            ExamQuestion::create($q);
        }
    }
}
