<p align="center">
  <img src="https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/torii-gate.svg" width="64" height="64" alt="Torii Gate">
</p>

<h1 align="center">
  ⛩️ LPK SAHABAT JEPANG INDONESIA (友好日本)
</h1>

<p align="center">
  <strong>Sistem ERP Manajemen Terpadu & Web Portal Resmi Lembaga Pelatihan Kerja (LPK) serta Sending Organization (SO) Penyalur Resmi RI - Jepang</strong>
</p>

<p align="center">
  <em>Izin Resmi Kementerian Ketenagakerjaan RI: <strong>KEP.224/LATTAS/XII/2023</strong></em>
</p>

<p align="center">
  <!-- Badges -->
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-%5E8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.4+-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Database-MySQL%20%2F%20SQLite-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL / SQLite">
  <img src="https://img.shields.io/badge/Tests-19%20Passed%20%7C%20118%20Assertions-success?style=for-the-badge&logo=checkmarx&logoColor=white" alt="Tests 100% Passing">
  <img src="https://img.shields.io/badge/Design-Japanese_Zen_Luxury-DC2626?style=for-the-badge&logo=affinitydesigner&logoColor=white" alt="Japanese Zen Luxury">
  <img src="https://img.shields.io/badge/License-MIT-F59E0B?style=for-the-badge" alt="License MIT">
</p>

---

## 📖 Daftar Isi

1. [Tentang Platform](#-tentang-platform)
2. [Fitur Unggulan Guest (Portal Publik)](#-fitur-unggulan-guest-portal-publik)
3. [Fitur Lengkap Panel Admin (ERP Backoffice)](#-fitur-lengkap-panel-admin-erp-backoffice)
4. [Integrasi Program Unggulan Pemerintah RI](#-integrasi-program-unggulan-pemerintah-ri)
5. [Generator Kwitansi & Invoice Resmi (Hanko 判子)](#-generator-kwitansi--invoice-resmi-hanko-)
6. [Arsitektur Real-Time Polling & Sinkronisasi Data](#-arsitektur-real-time-polling--sinkronisasi-data)
7. [Teknologi & Dependensi (Tech Stack)](#-teknologi--dependensi-tech-stack)
8. [Panduan Instalasi & Menjalankan Lokal](#-panduan-instalasi--menjalankan-lokal)
9. [Uji Otomatis (Automated Testing)](#-uji-otomatis-automated-testing)
10. [Struktur Direktori Proyek](#-struktur-direktori-proyek)
11. [Kepatuhan Hukum & Regulasi RI - Jepang](#-kepatuhan-hukum--regulasi-ri---jepang)

---

## 🌸 Tentang Platform

**LPK Sahabat Jepang Indonesia (SJI)** adalah aplikasi web *enterprise-grade* yang dirancang khusus untuk memfasilitasi seluruh rantai operasional Lembaga Pelatihan Kerja dan *Sending Organization* (SO) resmi penempatan tenaga kerja terampil ke Jepang. 

Website ini menggabungkan:
1. **Front-Facing Web Portal berestetika *Japanese Zen Luxury***: Tampilan mewah, bersih, responsif, dan kaya interaksi (animasi modern, tipografi seimbang, skema warna *Japan Red `#DC2626`*, *Sakura `#FFF1F2`*, dan *Slate `#0B0F19`*).
2. **Backoffice ERP Admin yang Komprehensif**: Mengatur manajemen siswa, kurikulum 6 bulan, penagihan & pembayaran transparan, pencocokan wawancara kerja (*Job Matching Kaisha*), galeri MoU kampus kesehatan se-Indonesia, hingga unduhan brosur terverifikasi.

---

## ✨ Fitur Unggulan Guest (Portal Publik)

| Fitur | Deskripsi | Halaman / Rute |
| :--- | :--- | :--- |
| **⛩️ Navbar Zen Minimalis** | Navigasi simetris, dropdown terstruktur rapi (Program Karir, Program Pemerintah, Biaya, Brosur, CBT), dengan CTA utama *✨ Konsultasi Gratis*. | `components/navbar.blade.php` |
| **💼 Program Karir Jepang** | Informasi silabus lengkap untuk jalur **Tokutei Ginou (SSW)**, **Ginou Jisshusei (Magang 3 Tahun)**, **Engineer & IT Pro**, serta **Kursus Intensif N5–N3**. | `/#program` |
| **🏛️ Program Pemerintah MoU** | Showcase kerja sama resmi dengan Kemenkes RI (**SMILE Project**) dan Kemendikbudristek (**SMK Go Japan**) lengkap dengan rekam jejak **4 Gelombang Keberangkatan**. | `/#kemitraan` |
| **🎠 Carousel Kunjungan Kampus** | Galeri foto dinamis dokumentasi MoU, seminar, dan bursa kerja (*Campus Hiring*) di Poltekkes & STIKes seluruh Indonesia dengan fitur *infinite loop* dan *smart autoplay pause-on-hover*. | `/#kemitraan` |
| **💰 Kalkulator & Simulasi Gaji** | Simulasi transparansi biaya, penghitungan estimasi gaji bersih di Jepang dalam Yen (¥) dan Rupiah (Rp), simulasi biaya hidup, serta proyeksi tabungan bulanan. | `/#kalkulator` |
| **📝 Simulasi Ujian JLPT CBT** | Aplikasi simulator Computer-Based Test (CBT) interaktif dengan bank 100 soal bahasa Jepang (Moji, Goi, Bunpou, Dokkai) lengkap dengan skoring otomatis tanpa perlu registrasi. | `/tryout-cbt` |
| **🗺️ Peta Alumni di 47 Prefektur** | Peta interaktif sebaran alumni LPK SJI yang telah aktif bekerja di prefektur Tokyo, Osaka, Aichi, Kanagawa, Fukuoka, Hokkaido, dll. | `/peta-alumni` |
| **📥 Katalog Brosur Resmi** | Unduhan brosur kurikulum & biaya resmi 2026. Calon siswa dapat mengisi kontak singkat untuk membuka kunci file asli (PDF) dengan penghitung unduhan *real-time*. | `/brosur` |
| **🤝 Kemitraan SMK & Guru BK** | Portal pendaftaran afiliasi khusus guru BKK SMK dengan perhitungan komisi referral transparan. | `/afiliasi/daftar` |
| **💬 Modal Konsultasi Cepat** | Formulir pendaftaran calon siswa dengan integrasi pemilihan program reguler maupun beasiswa pemerintah, auto-redirect ke WhatsApp Konsultan. | Global Pop-up Modal |

---

## 🏢 Fitur Lengkap Panel Admin (ERP Backoffice)

Panel Admin aman dan dilindungi autentikasi session multi-role:

1. **Dashboard & Mini Dashboard**:
   - Metrik KPI live: Total Siswa Aktif, Calon Siswa (Leads), Siswa Lolos Wawancara, Total Pemasukan Kursus, dan Tagihan Tertunda (*Outstanding Balance*).
   - Audio notifikasi instan & *toast alert* saat ada calon siswa baru yang mendaftar dari portal publik.
2. **Database Siswa & Master Data (`/admin/students`)**:
   - Manajemen siklus hidup siswa (*Pendaftaran -> Pelatihan -> Medical -> Matching User -> Paspor/CoE -> Terbang ke Jepang*).
   - **Filter 2-Tier Cepat**: Filter berdasarkan Program, Angkatan (*Batch*), Status Medikal (*Fit / Unfit*), Status Biaya (*Lunas / Talangan / Cicilan*), serta **Kategori Pendaftaran Khusus (SMILE Project Kemenkes / SMK Go Japan / Reguler)**.
   - **Dossier Digital Siswa (Rirekisho 履歴書)**: Cetak profil biodata lengkap siswa format Jepang siap serah ke perusahaan penerima (*Kaisha*).
   - **Export & Import CSV Massal**: Template CSV standar untuk import ratusan siswa dalam sekali klik.
3. **Manajemen Jadwal Wawancara Kaisha (`/admin/interviews`)**:
   - Jadwal temu wawancara kerja daring/luring dengan perwakilan perusahaan Jepang.
   - Penugasan kandidat siswa, pencatatan nilai wawancara, dan otomatisasi update status siswa menjadi *Lolos User*.
4. **Manajemen Brosur Resmi (`/admin/brochures`)**:
   - Unggah berkas brosur PDF resmi atau tautan unduhan eksternal.
   - Tentukan badge edisi (*Edisi 2026 / Gratis / Beasiswa*), program studi target, dan lacak statistik jumlah unduhan.
5. **Manajemen Galeri Kampus & MoU (`/admin/campus-galleries`)**:
   - CRUD dokumentasi kunjungan kampus kesehatan dan bursa kerja.
   - Fitur upload file gambar atau URL eksternal dengan *live image preview* instan.
   - Switch tombol aktivasi instan yang langsung tersinkron ke Carousel Beranda.
6. **Integrasi WhatsApp Blast Template (`/admin/whatsapp`)**:
   - Template pesan dinamis dengan tag otomatis `{nama}`, `{nis}`, `{program}`, `{sisa_biaya}` untuk follow-up cepat via WhatsApp Web / API.

---

## 🤝 Integrasi Program Unggulan Pemerintah RI

Sistem ini mendukung secara penuh dan membedakan skema penanganan dua program kerja sama strategis pemerintah:

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                           PROGRAM STRATEGIS PEMERINTAH                          │
├────────────────────────────────────────┬────────────────────────────────────────┤
│ 1. SMILE PROJECT (KEMENKES RI)         │ 2. SMK GO JAPAN (VOKASI)               │
├────────────────────────────────────────┼────────────────────────────────────────┤
│ • Khusus alumni Poltekkes & STIKes     │ • Khusus siswa tingkat akhir & alumni  │
│   jurusan Keperawatan / Kebidanan.     │   SMK jurusan Teknik, Mesin & Otomotif.│
│ • Rekam Jejak: Sukses 4 Gelombang.     │ • Bekerja sama dengan 45+ jejaring BKK │
│ • Biaya Pelatihan: 100% GRATIS         │   sekolah vokasi di Indonesia.         │
│   (Dibiayai negara via Kemenkes).      │ • Fasilitas dana talangan 0% DP kerja  │
│ • Bidang Kerja: Kaigo (Caregiver).     │   sama perbankan (BNI, Mandiri, BCA).  │
└────────────────────────────────────────┴────────────────────────────────────────┘
```

Kedua program ini tersinkronisasi di:
- **Formulir Konsultasi**: Calon siswa dapat memilih peminatan program beasiswa ini.
- **Database Siswa Admin**: Ditandai badge khusus warna *emerald* dan *blue*.
- **Filter Pencarian**: Admin dapat memilah laporan siswa berdasarkan program pemerintah dalam 1 klik.
- **Kalkulator Biaya**: Menampilkan info bebas biaya pendaftaran dan beasiswa penuh.

---

## 📑 Generator Kwitansi & Invoice Resmi (Hanko 判子)

Setiap data siswa yang tersimpan di sistem dapat langsung dicetak bukti tagihan atau bukti pembayarannya dengan standar dokumen administrasi Jepang:

- **Kwitansi Pembayaran Resmi (`/admin/students/{id}/receipt`)**:
  - Nomor seri kwitansi otomatis (format: `KW-SJI-YYYYMMDD-XXXX`).
  - Cap stempel merah resmi Jepang (*Hanko / Inkan 判子*) bertuliskan kanji resmi `友好日本`.
  - Terbilang nominal otomatis dalam Rupiah.
  - Barcode verifikasi keabsahan dokumen.
- **Faktur Tagihan / Invoice Resmi (`/admin/students/{id}/invoice`)**:
  - Rincian item biaya kursus, modul buku, asrama, asuransi, dan visa.
  - Rekapitulasi pembayaran: Total Biaya, Jumlah Telah Dibayar, dan Sisa Saldo (*Remaining Balance*).
  - Instruksi rekening transfer bank resmi atas nama yayasan LPK.

---

## ⚡ Arsitektur Real-Time Polling & Sinkronisasi Data

Untuk menjamin kenyamanan pengguna tanpa konfigurasi WebSocket server yang rumit, aplikasi menggunakan **Adaptive Polling Engine**:

```
[ Portal Tamu (Guest) ] ──────────────► GET /api/sync/guest (Interval 15s)
                                             │
                                             ├─► Update counter unduh brosur
                                             └─► Update kuota kelas tersedia

[ Panel Admin ] ──────────────────────► GET /api/sync/admin (Interval 10s)
                                             │
                                             ├─► Deteksi lead/konsultasi baru
                                             ├─► Bunyikan audio notifikasi bel
                                             ├─► Update Live KPI dashboard
                                             └─► Perbarui metrik tanpa reload
```

---

## 🛠️ Teknologi & Dependensi (Tech Stack)

### Core Backend & Framework
- **[PHP 8.2+](https://php.net)**: Bahasa pemrograman backend utama dengan *typed properties* dan *strict types*.
- **[Laravel 11.x](https://laravel.com)**: Framework MVC modern dengan Eloquent ORM, Blade templating, dan Form Request Validation.
- **[MySQL](https://www.mysql.com/) / [SQLite](https://www.sqlite.org/)**: Database relasional dengan skema migrasi dan relasi data terindeks.

### Frontend & Desain
- **[Tailwind CSS](https://tailwindcss.com)**: Framework utility-first CSS dengan custom palet warna bertema Jepang (*japan-50 s/d japan-900*).
- **[Vanilla JavaScript (ES6+)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)**: Logika modal pop-up, carousel dinamis, kalkulator biaya, dan polling AJAX tanpa dependensi library eksternal yang berat.
- **[Lucide Icons](https://lucide.dev/)**: Ikon SVG modern, bersih, dan tajam di layar Retina.
- **[Google Fonts](https://fonts.google.com/)**: Tipografi elegan menggunakan kombinasi *Plus Jakarta Sans*, *Outfit*, dan font kanji Jepang *Noto Sans JP*.

---

## 🚀 Panduan Instalasi & Menjalankan Lokal

Pastikan komputer Anda telah terinstal:
- **PHP >= 8.2** (ekstensi: `pdo_mysql`, `pdo_sqlite`, `mbstring`, `openssl`, `curl`, `gd`)
- **Composer** (versi 2.x)
- **Node.js & NPM** (opsional untuk *asset bundling*)

### Langkah-langkah:

```bash
# 1. Clone repository
git clone https://github.com/aryadians/SahabatJepangIndonesia.git
cd SahabatJepangIndonesia

# 2. Install dependensi Composer
composer install

# 3. Buat file konfigurasi Environment
cp .env.example .env

# 4. Generate Application Encryption Key
php artisan key:generate

# 5. Konfigurasi Database pada file .env
# (Default menggunakan SQLite atau MySQL sesuai preferensi Anda)
# Untuk SQLite:
touch database/database.sqlite
# Pastikan DB_CONNECTION=sqlite pada file .env

# 6. Jalankan Migrasi Database & Seeder Data Awal
php artisan migrate:fresh --seed

# 7. Hubungkan Storage Link (untuk upload foto & dokumen)
php artisan storage:link

# 8. Bersihkan & Optimalkan Cache View
php artisan optimize:clear

# 9. Jalankan Server Pengembangan Lokal
php artisan serve
```

Aplikasi siap diakses melalui browser:
- **Portal Tamu / Landing Page**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Katalog Unduh Brosur**: [http://127.0.0.1:8000/brosur](http://127.0.0.1:8000/brosur)
- **Panel Admin / ERP**: [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)

### Kredensial Akun Administrator Default:
- **Email**: `admin@sahabatjepangindonesia.com` *(atau sesuai database seeder)*
- **Password**: `password` *(atau `admin123`)*

---

## 🧪 Uji Otomatis (Automated Testing)

Platform ini memiliki cakupan pengujian otomatis (*Feature & Unit Testing*) yang komprehensif untuk memastikan seluruh alur bisnis berjalan 100% bebas dari bug:

```bash
# Menjalankan seluruh test suite
php artisan test
```

### Hasil Test Suite Terverifikasi:
```text
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response

   PASS  Tests\Feature\NewFeaturesTest
  ✓ guest can access brochure page
  ✓ admin can manage brochures and guest downloads selected
  ✓ admin can view student receipt and invoice
  ✓ admin can manage job interviews and assign candidates
  ✓ admin can manage campus galleries

   PASS  Tests\Feature\RealTimeSyncTest
  ✓ guest can access guest sync endpoint
  ✓ guest cannot access admin sync endpoint
  ✓ admin can access admin sync endpoint
  ✓ new lead is reflected in admin sync
  ✓ updating lead status via ajax returns live kpi stats

   PASS  Tests\Feature\StudentManagementTest
  ✓ guest cannot access students database
  ✓ admin can view students index
  ✓ admin can fetch student quick detail json
  ✓ admin can download csv template
  ✓ admin can export students database csv
  ✓ admin can import students csv
  ✓ admin can filter students by government programs and view badges

  Tests:    19 passed (118 assertions)
  Duration: ~3.0s (100% Green)
```

---

## 📁 Struktur Direktori Proyek

```text
SahabatJepangIndonesia/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── CampusGalleryController.php  # CRUD Galeri Kunjungan Kampus
│   │   │   │   ├── BrochureManagerController.php # Kelola Brosur Resmi Admin
│   │   │   │   ├── StudentController.php        # Database Siswa, Kwitansi & Invoice
│   │   │   │   ├── InterviewController.php      # Jadwal Wawancara Kaisha
│   │   │   │   └── SyncController.php           # Endpoint Polling Real-time Admin
│   │   │   ├── BrochureController.php           # Portal Unduh Brosur Guest
│   │   │   ├── ExamSimulatorController.php      # CBT Tryout JLPT Simulator
│   │   │   └── HomeController.php               # Landing Page & Lead Capture
│   │   └── Requests/                            # Validasi Form Request
│   └── Models/                                  # Eloquent Models (Student, Brochure, dll)
├── database/
│   ├── migrations/                              # Skema Tabel Database
│   └── seeders/                                 # Data Awal Dummy & Pengaturan Default
├── public/
│   ├── css/style.css                            # Styling Khusus & Animasi Zen
│   └── js/app.js                                # Script Global Modal & Polling
├── resources/
│   └── views/
│       ├── admin/                               # Blade Views Panel ERP Admin
│       ├── components/                          # Reusable Blade Components (Navbar, Carousel)
│       └── landing/                             # Blade Views Halaman Publik Tamu
├── routes/
│   ├── web.php                                  # Rute Web Tamu & Panel Admin
│   └── api.php                                  # Rute Endpoint API Sync
└── tests/
    └── Feature/                                 # 19 Automated Feature Tests
```

---

## 🔒 Kepatuhan Hukum & Regulasi RI - Jepang

Platform **LPK Sahabat Jepang Indonesia** dirancang dengan standar kepatuhan hukum ketat:
1. **Penyalur Resmi Kemenaker RI**: Seluruh alur pendaftaran siswa mematuhi peraturan pengiriman tenaga kerja ke luar negeri skema TITP (*Technical Intern Training Program*) dan SSW (*Specified Skilled Worker*).
2. **Zero Hidden Fees (Anti-Pungli)**: Menampilkan rincian biaya pelatihan, asrama, dan ujian sertifikasi secara transparan kepada calon siswa dan orang tua.
3. **Privasi & Keamanan Data**: Data calon siswa dan pelamar dilindungi dan tidak disebarluaskan kepada pihak ketiga yang tidak terafiliasi.

---

<p align="center">
  Dibuat dengan ❤️ dan dedikasi untuk kemajuan generasi muda Indonesia meraih karir impian di Negeri Sakura.<br>
  <strong>LPK Sahabat Jepang Indonesia (友好日本インドネシア)</strong>
</p>
