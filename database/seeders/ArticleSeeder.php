<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Panduan Lengkap Syarat & Alur Program Tokutei Ginou (SSW) Jepang 2026',
                'category' => 'Panduan SSW',
                'thumbnail' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?auto=format&fit=crop&w=800&q=80',
                'excerpt' => 'Ketahui syarat lengkap, dokumen yang dibutuhkan, serta estimasi biaya dan gaji terbaru program visa kerja Tokutei Ginou (Specified Skilled Worker) di Jepang.',
                'content' => '<p class="lead">Program <strong>Tokutei Ginou (特定技能)</strong> atau <em>Specified Skilled Worker (SSW)</em> adalah salah satu jalur paling diminati oleh generasi muda Indonesia yang ingin meniti karir profesional di Jepang dengan standar gaji setara pekerja lokal.</p>
                
                <h3>Apa itu Tokutei Ginou (SSW)?</h3>
                <p>Tokutei Ginou diluncurkan secara resmi oleh pemerintah Jepang untuk mengatasi kekurangan tenaga kerja di sektor-sektor industri produktif. Berbeda dengan program magang, pemegang visa SSW memiliki status sebagai pekerja resmi penuh dengan hak gaji, asuransi, dan perlindungan ketenagakerjaan standar Jepang.</p>
                
                <h3>Persyaratan Utama Mengikuti SSW:</h3>
                <ul>
                    <li><strong>Usia Minimal:</strong> 18 tahun (maksimal umumnya 35 tahun tergantung sektor).</li>
                    <li><strong>Pendidikan:</strong> Minimal SMA/SMK sederajat semua jurusan.</li>
                    <li><strong>Kemampuan Bahasa:</strong> Sertifikat JLPT level N4 atau JFT-Basic level A2.</li>
                    <li><strong>Sertifikat Keahlian:</strong> Lulus ujian Skill Test (Senmonkyu / SSW Test) pada bidang yang dipilih (seperti Pengolahan Makanan, Kaigo, Pertanian, atau Manufaktur).</li>
                    <li><strong>Kesehatan:</strong> Lolos tes MCU (Medical Check-up) standar imigrasi Jepang.</li>
                </ul>

                <h3>Tahapan Proses di LPK Sahabat Jepang Indonesia:</h3>
                <ol>
                    <li>Pendaftaran & konsultasi penjurusan karir.</li>
                    <li>Pelatihan intensif Bahasa Jepang dan etika kerja (2-3 bulan).</li>
                    <li>Ujian resmi JFT-Basic & Skill Test.</li>
                    <li>Wawancara dengan perusahaan penerima di Jepang (Mensetsu).</li>
                    <li>Pengurusan Certificate of Eligibility (COE) dan Visa Kerja.</li>
                    <li>Pemberangkatan dan pendampingan di Jepang.</li>
                </ol>
                
                <p>Mulailah langkah awal Anda sekarang bersama tim konselor profesional LPK Sahabat Jepang Indonesia!</p>',
                'author' => 'Tim Konselor LPK SJI',
                'is_published' => true,
                'views' => 420,
            ],
            [
                'title' => 'Tips Ampuh Lolos Wawancara (Mensetsu) dengan Perusahaan Jepang',
                'category' => 'Tips & Trik',
                'thumbnail' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=800&q=80',
                'excerpt' => 'Pelajari tata krama etika bisnis Jepang (Ojigi, Aisatsu, Hou-Ren-So) serta pertanyaan yang paling sering diajukan saat wawancara kerja.',
                'content' => '<p class="lead">Tahap wawancara (<em>Mensetsu</em>) adalah momen penentu kelulusan Anda diterima bekerja di perusahaan Jepang (*Kaisha*). Di Jepang, kepribadian, kesopanan, dan semangat kerja dinilai sama pentingnya dengan kemampuan teknis.</p>

                <h3>1. Etika Dasar Masuk Ruangan (Ojigi & Aisatsu)</h3>
                <p>Ketuk pintu 3 kali dengan tegas. Ucapkan <em>"Shitsurei shimasu"</em> dengan suara lantang dan jelas sebelum masuk. Berikan bungkukan badan (<em>Ojigi</em>) sekitar 30-45 derajat dengan sopan.</p>

                <h3>2. Kontak Mata dan Bahasa Tubuh yang Tegap</h3>
                <p>Duduklah dengan posisi tegak, tangan berada di atas paha (posisi <em>Seiza</em> atau duduk tegap), dan pertahankan kontak mata hangat dengan para interviewer. Jangan melipat tangan atau bersandar di kursi.</p>

                <h3>3. Jawab Pertanyaan dengan Jujur dan Antusias</h3>
                <p>Pewawancara Jepang sangat menghargai kejujuran dan motivasi belajar yang tinggi (<em>Yaruki</em>). Jika ada pertanyaan yang kurang jelas, jangan ragu untuk meminta maaf dan meminta pengulangan dengan sopan menggunakan kalimat <em>"Mou ichido onegaishimasu"</em>.</p>',
                'author' => 'Sensei Hiroshi & Tim Pengajar',
                'is_published' => true,
                'views' => 315,
            ],
            [
                'title' => 'Simulasi Rincian Biaya Hidup & Tips Menabung Rp 15 Juta/Bulan di Jepang',
                'category' => 'Finansial & Gaji',
                'thumbnail' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80',
                'excerpt' => 'Bedah tuntas rincian sewa kamar apartemen, makan harian, belanja bahan pokok di supermarket lokal, hingga strategi mengirim uang ke Indonesia.',
                'content' => '<p class="lead">Banyak calon pekerja penasaran: <em>"Dari gaji ¥200.000 (± Rp 21 Juta), berapa sih sisa uang bersih yang bisa ditabung dan dikirim ke keluarga di Indonesia?"</em> Mari kita bedah rinciannya secara transparan.</p>

                <h3>Simulasi Pengeluaran Rata-rata per Bulan:</h3>
                <ul>
                    <li><strong>Sewa Tempat Tinggal / Asrama Bersubsidi:</strong> ¥25.000 - ¥35.000</li>
                    <li><strong>Listrik, Air & Gas (Utilitas):</strong> ¥8.000 - ¥12.000</li>
                    <li><strong>Makan & Belanja Supermarket (Masak Sendiri):</strong> ¥20.000 - ¥28.000</li>
                    <li><strong>Paket Data Internet & Pulsa:</strong> ¥3.000 - ¥5.000</li>
                </ul>

                <h3>Tips Menabung Efektif:</h3>
                <p>Memasak sendiri di asrama bersama rekan kerja dari Indonesia dapat memangkas anggaran konsumsi hingga 50%. Ditambah dengan jam kerja lembur (*Zangyou*) yang dibayar 1.25x lipat, potensi tabungan bersih Anda bisa mencapai <strong>Rp 12 - 18 Juta per bulan</strong>.</p>',
                'author' => 'Divisi Keuangan & Alumni SJI',
                'is_published' => true,
                'views' => 580,
            ],
            [
                'title' => 'Mengenal Budaya Kerja Jepang: Makna Penting Hou-Ren-So dan 5S',
                'category' => 'Budaya Kerja',
                'thumbnail' => 'https://images.unsplash.com/photo-1542051841857-5f90071e7989?auto=format&fit=crop&w=800&q=80',
                'excerpt' => 'Kunci sukses beradaptasi dan disayangi atasan di tempat kerja Jepang adalah memahami prinsip komunikasi Houkoku, Renraku, Soudan.',
                'content' => '<p class="lead">Di dunia industri Jepang, disiplin komunikasi adalah pondasi utama kerja sama tim yang solid. Filosofi ini dirangkum dalam konsep <strong>Hou-Ren-So (報・連・相)</strong>.</p>

                <h3>1. Houkoku (Lapor / 報告)</h3>
                <p>Selalu laporkan progres pekerjaan dan hasil tugas kepada atasan secara berkala, terutama jika terjadi kendala atau perubahan situasi kerja.</p>

                <h3>2. Renraku (Komunikasi / 連絡)</h3>
                <p>Menyampaikan informasi penting secara cepat dan tepat kepada seluruh anggota tim yang berkaitan tanpa menunda.</p>

                <h3>3. Soudan (Konsultasi / 相談)</h3>
                <p>Jangan mengambil keputusan sepihak jika Anda merasa ragu. Selalu konsultasikan dengan senior atau atasan untuk menemukan solusi terbaik.</p>',
                'author' => 'Tim Pengajar Kebudayaan',
                'is_published' => true,
                'views' => 240,
            ]
        ];

        foreach ($articles as $art) {
            Article::updateOrCreate(
                ['slug' => Str::slug($art['title'])],
                array_merge($art, ['slug' => Str::slug($art['title'])])
            );
        }
    }
}
