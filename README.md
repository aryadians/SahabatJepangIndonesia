<p align="center">
  <img src="https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/torii-gate.svg" width="64" height="64" alt="Torii Gate">
</p>

<h1 align="center">
  ⛩️ LPK SAHABAT JEPANG INDONESIA (友好日本)
</h1>

<p align="center">
  <strong>Sistem ERP Manajemen Terpadu, Web Portal Resmi, & Ekosistem RBAC Lembaga Pelatihan Kerja (LPK) serta Sending Organization (SO) Penyalur Resmi RI - Jepang</strong>
</p>

<p align="center">
  <em>Izin Resmi Kementerian Ketenagakerjaan RI: <strong>KEP.224/LATTAS/XII/2023</strong> • Akreditasi Lembaga: <strong>LA-LPK A</strong></em>
</p>

<p align="center">
  <!-- Badges -->
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-%5E8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.4+-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Database-MySQL%20%2F%20SQLite-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL / SQLite">
  <img src="https://img.shields.io/badge/RBAC-Multi--Role%20Segregation-8B5CF6?style=for-the-badge&logo=auth0&logoColor=white" alt="RBAC Multi-Role">
  <img src="https://img.shields.io/badge/Tests-105%20Passed%20%7C%20668%20Assertions-success?style=for-the-badge&logo=checkmarx&logoColor=white" alt="Tests 100% Passing">
  <img src="https://img.shields.io/badge/Design-Japanese_Zen_Luxury-DC2626?style=for-the-badge&logo=affinitydesigner&logoColor=white" alt="Japanese Zen Luxury">
  <img src="https://img.shields.io/badge/PWA-Ready%20%7C%20Offline%20Cache-8A2BE2?style=for-the-badge&logo=pwa&logoColor=white" alt="PWA Ready">
  <img src="https://img.shields.io/badge/License-MIT-F59E0B?style=for-the-badge" alt="License MIT">
</p>

---

## 📖 Daftar Isi

1. [Tentang Platform](#-tentang-platform)
2. [Kredensial Akun & Akses Login Sistem](#-kredensial-akun--akses-login-sistem)
3. [Sistem Keamanan & Role-Based Access Control (RBAC)](#-sistem-keamanan--role-based-access-control-rbac)
4. [Fitur Unggulan Guest (Portal Publik)](#-fitur-unggulan-guest-portal-publik)
5. [Fitur Lengkap Panel Admin (ERP Backoffice)](#-fitur-lengkap-panel-admin-erp-backoffice)
6. [Halaman Profil Pengguna Mandiri & Ganti Password](#-halaman-profil-pengguna-mandiri--ganti-password)
7. [Audit Trail & Rekam Jejak Aktivitas Sistem](#-audit-trail--rekam-jejak-aktivitas-sistem)
8. [Dashboard Eksekutif Cerdas Berbasis Peran](#-dashboard-eksekutif-cerdas-berbasis-peran)
9. [Buku Kas Umum, Proyeksi Keuangan & Laba Rugi (P&L)](#-buku-kas-umum-proyeksi-keuangan--laba-rugi-pl)
10. [Universal Command Palette (Ctrl + K) & Concierge Dock](#-universal-command-palette-ctrl--k--concierge-dock)
11. [Progressive Web App (PWA & Offline Mode)](#-progressive-web-app-pwa--offline-mode)
12. [Portal Cek Status Mandiri Siswa & Verifikasi Dokumen QR](#-portal-cek-status-mandiri-siswa--verifikasi-dokumen-qr)
13. [Kalkulator Remitansi & Klaim Nenkin Refund](#-kalkulator-remitansi--klaim-nenkin-refund)
14. [Simulasi Ujian JLPT CBT & Peta Sebaran Alumni](#-simulasi-ujian-jlpt-cbt--peta-sebaran-alumni)
15. [Teknologi & Dependensi (Tech Stack)](#-teknologi--dependensi-tech-stack)
16. [Panduan Instalasi & Menjalankan Lokal](#-panduan-instalasi--menjalankan-lokal)
17. [Pengujian Otomatis (Automated Testing Suite)](#-pengujian-otomatis-automated-testing-suite)
18. [Struktur Direktori Proyek](#-struktur-direktori-proyek)
19. [Kepatuhan Hukum & Regulasi RI - Jepang](#-kepatuhan-hukum--regulasi-ri---jepang)

---

## 🌸 Tentang Platform

**LPK Sahabat Jepang Indonesia (友好日本インドネシア - SJI)** adalah aplikasi web *enterprise-grade* yang dirancang khusus untuk memfasilitasi seluruh rantai operasional Lembaga Pelatihan Kerja dan *Sending Organization* (SO) resmi penempatan tenaga kerja terampil ke Jepang (jalur *Specified Skilled Worker / Tokutei Ginou* dan *Ginou Jisshusei / Magang Kerja*).

Platform ini mengintegrasikan:
1. **Front-Facing Web Portal Berestetika *Japanese Zen Luxury***: Tampilan modern, bersih, responsif, dan kaya interaksi dengan skema warna *Japan Red `#DC2626`*, *Sakura `#FFF1F2`*, dan *Slate `#0B0F19`*.
2. **Backoffice ERP Admin dengan Multi-Role RBAC**: Manajemen hak akses ketat antara **Administrator**, **Pengajar / Sensei**, dan **Karyawan / Staf LPK**.
3. **Pusat Keuangan & Akuntabilitas**: Buku Kas Umum real-time, periode kunci pembukuan (*Lock Period*), laporan laba rugi (*P&L Statement*), proyeksi kas, serta reimbursement dinas.
4. **Audit Trail & Keamanan Sistem**: Pencatatan otomatis setiap aktivitas login, perubahan data pengguna, dan transaksi finansial.
5. **Ekosistem Verifikasi & Dokumen Digital**: Kwitansi dan invoice resmi berstempel digital (*Hanko 判子*) serta QR Code anti-pemalsuan.

---

## 🔑 Kredensial Akun & Akses Login Sistem

Portal login khusus pengurus, pengajar, dan staf dapat diakses melalui:
👉 **URL Login**: `http://127.0.0.1:8000/admin/login`

Seluruh akun default menggunakan kata sandi standar pengujian: `admin123`

| Peran (Role) | Nama Pengguna | Alamat Email Login | Hak Akses Utama |
| :--- | :--- | :--- | :--- |
| **🛡️ Administrator** | Super Admin | `admin@sahabatjepangindonesia.com` | Kontrol penuh sistem, CMS situs, konfigurasi web, manajemen RBAC, keuangan & kesiswaan |
| **👨‍🏫 Pengajar / Sensei** | Yamada Sensei | `sensei@sahabatjepangindonesia.com` | Kesiswaan, jadwal kelas, wawancara kerja Kaisha, kesiapan terbang & reimbursement pribadi |
| **👩‍🏫 Pengajar / Sensei** | Dewi Sartika (N2) | `sensei2@sahabatjepangindonesia.com` | Kesiswaan, jadwal kelas, wawancara kerja Kaisha, kesiapan terbang & reimbursement pribadi |
| **💼 Karyawan / Staf** | Siti Rahmawati | `karyawan@sahabatjepangindonesia.com` | Operasional, leads CRM pendaftar, buku kas umum, arsip dokumen digital, WhatsApp gateway |

---

## 🛡️ Sistem Keamanan & Role-Based Access Control (RBAC)

Sistem mengimplementasikan pemisahan tugas (*Segregation of Duties*) yang kokoh untuk mencegah kebocoran informasi dan akses tidak sah:

### 1. Middleware Proteksi Ketat (`CheckRole`)
- Didaftarkan sebagai alias `'role'` di `bootstrap/app.php` dan diimplementasikan pada `app/Http/Middleware/CheckRole.php`.
- **Verifikasi Status Akun**: Menolak secara otomatis akun yang dinonaktifkan (`is_active = false`) dan menutup sesi seketika.
- **Otorisasi Multi-Peran**: Mendukung deklarasi peran fleksibel seperti `role:admin` atau `role:admin,staff`. Upaya akses ilegal menghasilkan HTTP 403 Forbidden.

### 2. Matriks Kebijakan Otorisasi (RBAC Route Policy)

```
[Pengguna] ──▶ [Middleware: auth] ──▶ [Middleware: role:admin / role:admin,staff]
                                              │
                      ┌───────────────────────┴───────────────────────┐
                      ▼                                               ▼
          [Administrator] (Lolos)                         [Sensei / Karyawan]
                 │                                                    │
                 ▼                                                    ▼
   Kelola User, CMS, Pengaturan                      Hanya Modul Yang Diizinkan
   Buku Kas, P&L, Audit Log                           (403 Bila Coba Akses Ilegal)
```

| Modul / Rute | Admin | Sensei | Karyawan | Keterangan Otorisasi |
| :--- | :---: | :---: | :---: | :--- |
| **Manajemen Pengguna (RBAC)** (`/admin/users/*`) | ✅ | ❌ | ❌ | Khusus Super Admin |
| **Pengaturan Web & Fonnte WA** (`/admin/settings/*`) | ✅ | ❌ | ❌ | Khusus Super Admin |
| **Audit Trail & Keamanan** (`/admin/audit-logs/*`) | ✅ | ❌ | ❌ | Khusus Super Admin |
| **Kelola Konten Web (CMS)** (`/admin/programs`, dll) | ✅ | ❌ | ❌ | Khusus Super Admin |
| **Buku Kas Umum & Jurnal** (`/admin/cash-book/*`) | ✅ | ❌ | ✅ | Admin & Karyawan Keuangan |
| **Laporan Laba Rugi & Proyeksi** (`/admin/finance/*`) | ✅ | ❌ | ✅ | Admin & Karyawan Keuangan |
| **Data Siswa & Jadwal Kelas** (`/admin/students/*`) | ✅ | ✅ | ✅ | Semua Peran Terdaftar |
| **Wawancara Kaisha & Interview** (`/admin/interviews/*`)| ✅ | ✅ | ✅ | Semua Peran Terdaftar |
| **Checklist Terbang Siswa** (`/admin/flight-readiness/*`)| ✅ | ✅ | ✅ | Semua Peran Terdaftar |
| **Profil Pribadi & Ganti Sandi** (`/admin/profile`) | ✅ | ✅ | ✅ | Semua Peran Terdaftar |
| **Pengajuan Reimburse Dinas** (`/admin/reimbursements/*`)| ✅ | ✅ | ✅ | Pengajuan Mandiri & Approval |

---

## ✨ Fitur Unggulan Guest (Portal Publik)

| Fitur | Deskripsi | Rute Akses |
| :--- | :--- | :--- |
| **⛩️ Navbar Zen Minimalis** | Navigasi mewah, menu terstruktur rapi (Program Karir, MoU Pemerintah, Biaya, Brosur, CBT, Portal Siswa), dan CTA *Konsultasi Gratis*. | Beranda |
| **📱 Progressive Web App (PWA)** | Tombol instalasi instan di layar HP Android/iOS, splash screen elegan, dan offline caching via Service Worker. | Global Layout |
| **🔍 Portal Cek Status Siswa** | Siswa & wali melacak progres berkas (6 tahapan Road to Japan), status MCU, jadwal wawancara, serta unduh kwitansi mandiri. | `/cek-status` |
| **🛡️ Verifikasi Dokumen QR** | Pindai QR code kwitansi/invoice fisik untuk menampilkan sertifikat keabsahan digital berizin SO Kemnaker RI. | `/verifikasi/{code}` |
| **💴 Kalkulator Remitansi & Nenkin** | Simulasi kurs kirim uang Yen ke Rupiah dan simulasi pencairan uang pensiun Nenkin (± Rp 45jt - Rp 95jt). | `/#kalkulator` |
| **💼 Katalog Program Karir** | Silabus kurikulum dan jalur penempatan: Tokutei Ginou (SSW), Magang 3 Tahun, Engineer/IT Pro, serta Kursus N5-N3. | `/#program` |
| **🏛️ MoU Pemerintah & Kampus** | Showcase kerja sama resmi Kemenkes RI (**SMILE Project**) dan Kemendikbudristek (**SMK Go Japan**) dengan galeri kunjungan kampus. | `/#kemitraan` |
| **📝 Simulasi Ujian JLPT CBT** | Aplikasi simulator Computer-Based Test (CBT) dengan 100 bank soal, pintasan keyboard, penanda ragu-ragu, dan sertifikat Goukaku digital. | `/simulasi-ujian` |
| **🗺️ Peta Alumni 47 Prefektur** | Peta interaktif sebaran alumni LPK SJI yang aktif bekerja di Tokyo, Osaka, Aichi, Kanagawa, Fukuoka, dll. | `/sebaran-alumni` |
| **📥 Katalog Brosur Resmi** | Unduhan brosur kurikulum & rincian biaya resmi 2026 dengan pencatat statistik unduhan real-time. | `/brosur` |
| **🤝 Kemitraan SMK & BKK** | Portal pendaftaran kerja sama BKK SMK dengan perhitungan komisi referral kemitraan transparan. | `/mitra-sekolah` |

---

## 🏢 Fitur Lengkap Panel Admin (ERP Backoffice)

Panel Admin dirancang dengan konsep *Control Room* berstandar tinggi:
1. **Universal Command Palette (`Ctrl + K`)**: Akses cepat pencarian siswa secara AJAX, navigasi ke seluruh modul, dan aksi instan hanya dengan ketukan keyboard.
2. **Dual Live Operational Clocks**: Sinkronisasi waktu langsung antara **Jakarta (WIB)** dan **Tokyo (JST, +2 jam)** untuk kelancaran koordinasi interview Kaisha.
3. **Database Siswa Terpadu (`/admin/students`)**:
   - Filter 2-Tier Cepat (Program, Batch, MCU, Status Biaya, Kategori SMILE Project / SMK Go Japan).
   - Export CSV, Cetak Dossier Pelatihan, Kwitansi Resmi, dan Invoice Tagihan.
   - Import CSV massal dengan auto-sync data keuangan dan pembuatan NIS otomatis.
4. **Wawancara Kaisha & Interview Matching (`/admin/interviews`)**:
   - Manajemen kalender seleksi user Jepang, penugasan kandidat siswa, dan otomatisasi hasil kelulusan.
5. **Kesiapan Terbang Jepang (`/admin/flight-readiness`)**:
   - Tracker kelengkapan Paspor, CoE (*Certificate of Eligibility*), Visa Kerja Kedutaan, E-KTKLN, dan Tiket Pesawat.
6. **Buku Induk Karyawan & Dewan Sensei (`/admin/teachers`)**:
   - Database instruktur JLPT N1/N2/Native, riwayat pengalaman Jepang, dan pembayaran gaji honorarium yang tercatat otomatis ke Buku Kas Umum.
7. **Arsip Digital Explorer SPA (`/admin/digital-archives`)**:
   - Pengelola berkas berkategori folder bergaya Windows Explorer untuk nota fisik, bukti transfer, dan dokumen legalitas.

---

## 👤 Halaman Profil Pengguna Mandiri & Ganti Password

Rute: **[`/admin/profile`](http://127.0.0.1:8000/admin/profile)**

Memungkinkan setiap pengguna (Administrator, Sensei, dan Karyawan) mengelola akun pribadinya:
- **Pembaruan Biodata**: Ubah Nama Lengkap dan Nomor WhatsApp.
- **Upload Avatar Terkompresi**: Mendukung unggah foto profil yang otomatis dikompresi proporsional menggunakan PHP GD (*lightweight Base64 storage*). Avatar pengguna langsung tampil di topbar panel admin.
- **Ganti Kata Sandi Mandiri**:
  - Verifikasi kata sandi saat ini (`current_password`) untuk mencegah pembajakan akun.
  - Validasi ketat kata sandi baru (minimal 6 karakter & konfirmasi ulang).
  - Tombol intip sandi (*peek visibility toggle*) interaktif.
- **Audit Logging Otomatis**: Setiap pembaruan profil atau kata sandi terekam secara aman di audit log sistem.

---

## 📜 Audit Trail & Rekam Jejak Aktivitas Sistem

Rute: **[`/admin/audit-logs`](http://127.0.0.1:8000/admin/audit-logs)** *(Khusus Administrator)*

Fitur pengawasan operasional dan akuntabilitas sistem LPK:
- **Pencatatan Otomatis (Live Event Tracking)**:
  - `auth.login`: Mencatat setiap sesi login sukses dengan data nama, peran, IP, dan User Agent browser.
  - `auth.failed`: Mencatat percobaan login gagal (kata sandi keliru atau akun yang dinonaktifkan).
  - `auth.logout`: Mencatat sesi pengguna yang keluar dari sistem.
  - `user.created`, `user.updated`, `user.toggle_status`, `user.deleted`: Mencatat setiap aksi administratif terhadap akun pengguna RBAC.
  - `profile.updated`, `profile.password_changed`: Mencatat pembaruan profil dan sandi.
  - `cash.created`: Mencatat transaksi keuangan baru.
- **4 Kartu KPI Keamanan**: Total Rekaman Log, Login Hari Ini, Percobaan Gagal / Alert, dan Total Aktivitas RBAC.
- **Filter Cerdas**: Pencarian teks deskripsi/IP, filter kategori aktivitas (`auth`, `user`, `profile`, `cash`), filter nama pengguna, dan filter rentang tanggal.
- **Metadata Inspector**: Menampilkan rincian data JSON di setiap baris log.
- **Pembersihan Log 1-Klik**: Tombol aman untuk mengarsipkan dan membersihkan log yang lebih lama dari 30 hari.

---

## 📊 Dashboard Eksekutif Cerdas Berbasis Peran

Rute: **[`/admin`](http://127.0.0.1:8000/admin)**

Dashboard menyesuaikan tampilan dan datanya secara adaptif sesuai peran yang sedang login:
- **Welcome Banner**: Sapaan personal dan identitas jabatan resmi pengguna.
- **Kartu Ringkasan KPI**:
  - **Admin & Karyawan**: Saldo Kas Riil, Piutang Pelatihan Siswa, Arus Kas Bulanan, dan Arsip Digital.
  - **Sensei / Pengajar**: Siswa Aktif di Kelas, Jadwal Wawancara Kaisha Terdekat, Siswa Lolos Seleksi Jepang, dan Klaim Reimburse Dinas Pribadi.
- **Pusat Cetak Dokumen PDF Resmi**:
  - **Admin/Staf**: 7 laporan lengkap (termasuk Buku Kas Umum & Proyeksi Keuangan).
  - **Sensei**: 4 laporan terfilter khusus akademik & interview tanpa mengekspos data kas atau laba rugi LPK.
- **Tabel Data Langsung**:
  - **Sensei**: Menampilkan tabel **Jadwal Wawancara Kaisha Mendatang** (`JobInterview`) lengkap dengan kuota siswa dan nama Kaisha, menggantikan tabel Leads CRM pendaftar.
- **Pintasan Cepat (Quick Nav Grid)**: Shortcut tombol bawah disesuaikan dengan kebutuhan harian masing-masing peran.

---

## 💰 Buku Kas Umum, Proyeksi Keuangan & Laba Rugi (P&L)

Rute: **[`/admin/cash-book`](http://127.0.0.1:8000/admin/cash-book)** & **[`/admin/finance/profit-loss`](http://127.0.0.1:8000/admin/finance/profit-loss)**

Sistem pembukuan ganda berstandar akuntansi Indonesia:
- **Jurnal Kas & Bank**: Pencatatan kas masuk (*debit*) dan kas keluar (*kredit*) lengkap dengan nomor bukti kas otomatis (`BKM-YYYYMM-XXXXX` / `BKK-YYYYMM-XXXXX`).
- **Periode Kunci Pembukuan (*Financial Lock Period*)**: Mencegah manipulasi atau penambahan transaksi pada periode yang telah diaudit / ditutup buku.
- **Laporan Laba Rugi (損益計算書 - P&L Statement)**: Menghitung pendapatan bruto, beban pokok pelatihan, beban operasional, laba usaha, dan laba bersih LPK.
- **Cetak Dokumen Resmi Format A4 Landscape**: Dilengkapi stempel dan kop surat standar Kemenaker RI.

---

## ⌨️ Universal Command Palette (Ctrl + K) & Concierge Dock

1. **Universal Admin Command Palette (`Ctrl + K` / `Cmd + K`)**:
   - Dapat dibuka dari halaman admin mana saja.
   - Pencarian siswa instan secara AJAX: ketik nama atau NIS untuk melihat profil, status Kaisha, cetak dossier, atau kwitansi.
   - Navigasi 1-klik ke semua modul sistem dan aksi cepat catat kas.
2. **Public Floating Concierge Dock**:
   - Dock melayang *frosted glass* di beranda publik untuk akses cepat ke Peta 47 Prefektur, Simulasi CBT, Cek Status Siswa, dan Unduh Brosur.
   - Garis indikator baca (*Reading Progress Bar*) warna crimson di bagian atas layar.

---

## 📱 Progressive Web App (PWA & Offline Mode)

- **`manifest.json`**: Pengaturan nama aplikasi, tema warna *Japan Red `#DC2626`*, dan 4 pintasan cepat.
- **Multi-Size App Icons**: Ikon emblem kanji `友` (*Tomo/Sahabat*) ukuran `96x96`, `192x192`, `512x512`, dan `maskable`.
- **Service Worker (`sw.js`)**: Strategi *Network-First with Cache Fallback* agar aset inti tetap dapat diakses secara offline.
- **Prompt Instalasi**: Deteksi otomatis banner instalasi pada browser Android Chrome dan petunjuk khusus iOS Safari.

---

## 🔍 Portal Cek Status Mandiri Siswa & Verifikasi Dokumen QR

1. **Portal Siswa Mandiri (`/cek-status`)**:
   - Akses tracking berkas menggunakan NIS, NIK, atau Nomor WhatsApp.
   - Visual timeline 6 tahapan Road to Japan, status MCU, rincian pembayaran, dan unduh kwitansi mandiri.
2. **Sistem Verifikasi Dokumen QR (`/verifikasi/{code}`)**:
   - Pindai QR Code kwitansi atau invoice untuk menampilkan sertifikat keabsahan digital resmi berstempel *Hanko*.

---

## 💴 Kalkulator Remitansi & Klaim Nenkin Refund

Rute: **[`/#kalkulator`](http://127.0.0.1:8000/#kalkulator)** & **[`/remitansi`](http://127.0.0.1:8000/remitansi)**

- **Kalkulator Pengiriman Devisa**: Menghitung Rupiah bersih yang diterima keluarga setelah biaya admin bank (BNI Tokyo, Mandiri, BCA, Smiles).
- **Proyeksi Akumulasi Tabungan**: Proyeksi tabungan 1 tahun, 3 tahun (± Rp 379 Juta), dan 5 tahun (± Rp 632 Juta).
- **Simulasi Nenkin Refund (脱退一時金)**: Simulasi hak klaim uang pensiun Jepang sebesar **Rp 45.000.000 - Rp 95.000.000** saat kembali ke tanah air.

---

## 🎯 Simulasi Ujian JLPT CBT & Peta Sebaran Alumni

1. **Simulasi CBT Online (`/simulasi-ujian`)**:
   - 100 bank soal interaktif berstandar JLPT & JFT-Basic (Kotoba, Bunpou, Kanji, Dokkai).
   - Pintasan keyboard (`A-D`, `1-4`, `←`, `→`, `R`), penanda ragu-ragu (*Flag for Review*), dan sertifikat kelulusan digital (*Goukaku Certificate*).
2. **Peta Sebaran Alumni 47 Prefektur (`/sebaran-alumni`)**:
   - Peta visual alumni yang bekerja di prefektur seluruh Jepang dengan filter pencarian instan nama, prefektur, dan Kaisha.

---

## 🛠️ Teknologi & Dependensi (Tech Stack)

- **Backend Framework**: [Laravel 11.x](https://laravel.com/) (PHP ^8.2)
- **Frontend & Styling**: [Tailwind CSS 3.4+](https://tailwindcss.com/) dengan kustom estetika *Zen Luxury*
- **Icons**: [Lucide Icons](https://lucide.dev/) (SVG vector)
- **Database**: MySQL / SQLite (dukungan penuh SQLite in-memory untuk testing berkecepatan tinggi)
- **PWA**: Web App Manifest & Service Worker Cache Engine
- **Font**: Plus Jakarta Sans, Inter, & Noto Sans JP (Google Fonts)
- **WhatsApp Integration**: Fonnte API Gateway terpadu

---

## 🚀 Panduan Instalasi & Menjalankan Lokal

### 1. Klon Repositori
```bash
git clone https://github.com/aryadians/SahabatJepangIndonesia.git
cd SahabatJepangIndonesia
```

### 2. Instal Dependensi Composer
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` ke `.env` dan sesuaikan konfigurasi database:
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Jalankan Migrasi & Database Seeder
```bash
php artisan migrate --seed
```

### 5. Jalankan Server Pengembangan Lokal
```bash
php artisan serve
```
Aplikasi siap diakses di: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🧪 Pengujian Otomatis (Automated Testing Suite)

Sistem dilengkapi rangkaian pengujian otomatis unit dan fitur komprehensif menggunakan PHPUnit:

```bash
php vendor/bin/phpunit
```

### Ringkasan Eksekusi Pengujian (100% Passed):
```text
PHPUnit 11.5.56 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.2.12
Configuration: C:\Tugas Kuliah\Belajar\Project\SahabatJepangIndonesia\phpunit.xml

...............................................................  63 / 105 ( 60%)
..........................................                      105 / 105 (100%)

Time: 00:35.959, Memory: 64.00 MB

OK (105 tests, 668 assertions)
```

| File Pengujian | Asersi | Cakupan Pengujian |
| :--- | :---: | :--- |
| `tests/Feature/RbacTest.php` | 31 | Middleware `CheckRole`, penolakan akses 403, toggle status user, pembuatan user RBAC |
| `tests/Feature/ProfileAndAuditLogTest.php` | 24 | Akses profil semua peran, ganti sandi mandiri, pembatasan audit log, pembersihan log |
| `tests/Feature/CashBookTest.php` | 42 | Jurnal kas, nomor bukti kas, periode kunci pembukuan, balance sheet |
| `tests/Feature/DocumentVerificationTest.php` | 28 | Verifikasi keabsahan QR code kwitansi & invoice anti-pemalsuan |
| `tests/Feature/StudentPortalTest.php` | 36 | Tracking progres 6 tahapan siswa, cetak mandiri kwitansi & invoice |
| `tests/Feature/RealTimeSyncTest.php` | 25 | Live polling sinkronisasi leads dan metrik dashboard |
| `tests/Feature/StudentManagementTest.php` | 45 | CRUD siswa, export/import CSV massal, auto-calculate saldo |
| *Modul Pengujian Lainnya* | 437 | Wawancara Kaisha, brosur, P&L, galeri kampus, reimbursement, dan CBT |

---

## 📁 Struktur Direktori Proyek

```text
SahabatJepangIndonesia/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AuditLogController.php         # Audit Trail & Rekam Jejak Sistem
│   │   │   │   ├── AuthController.php             # Login Luxury, Reset Password & Throttle
│   │   │   │   ├── CashBookController.php         # Buku Kas Umum & Jurnal Keuangan
│   │   │   │   ├── FinancialAnalyticsController.php# Analisis Keuangan & P&L Statement
│   │   │   │   ├── ProfileController.php          # Profil Mandiri & Ganti Password
│   │   │   │   ├── StudentController.php          # Database Siswa, Kwitansi & Invoice
│   │   │   │   ├── TeacherController.php          # Dewan Pengajar & Pembayaran Gaji
│   │   │   │   └── UserController.php             # Manajemen Akun & Matriks RBAC
│   │   │   ├── StudentPortalController.php        # Portal Mandiri Siswa (/cek-status)
│   │   │   ├── DocumentVerificationController.php # Verifikasi QR Code Keaslian Dokumen
│   │   │   └── ExamSimulatorController.php        # CBT Tryout JLPT 100 Soal
│   │   └── Middleware/
│   │       └── CheckRole.php                      # Enforcer Hak Akses Multi-Role RBAC
│   ├── Models/                                    # AuditLog, User, Student, Teacher, CashTransaction
│   └── Traits/
│       └── UploadsImage.php                       # Kompresi Otomatis Gambar & Avatar GD
├── database/
│   ├── migrations/                                # 31 Migrasi Skema Database
│   └── seeders/                                   # Database Seeder Pengguna & Data Awal
├── public/
│   ├── manifest.json                              # PWA Web App Manifest
│   ├── sw.js                                      # PWA Service Worker Offline Cache
│   └── images/                                    # Asset Banner, Hanko, & PWA Icons
├── resources/
│   └── views/
│       ├── admin/                                 # Views Panel ERP, RBAC, Audit Log & Dashboard
│       ├── components/                            # Reusable Blade Components (Navbar, Command Palette)
│       └── landing/                               # Halaman Tamu, Portal Siswa & Simulator CBT
├── routes/
│   └── web.php                                    # Definisi Rute Lengkap & Kebijakan Role
└── tests/
    └── Feature/                                   # 105 Automated Feature Tests
```

---

## 🔒 Kepatuhan Hukum & Regulasi RI - Jepang

Platform **LPK Sahabat Jepang Indonesia** mematuhi regulasi ketat ketenagakerjaan:
1. **Penyalur Resmi Kemenaker RI**: Izin *Sending Organization* (SO) resmi nomor `KEP.224/LATTAS/XII/2023` untuk skema TITP (*Technical Intern Training Program*) dan SSW (*Specified Skilled Worker*).
2. **Zero Hidden Fees (Anti-Pungli)**: Menampilkan rincian biaya pelatihan, asrama, dan sertifikasi secara transparan dengan kwitansi berstempel digital.
3. **Privasi & Keamanan Data (UU PDP RI)**: Seluruh data pribadi siswa, kontak darurat, serta dokumen paspor dilindungi otentikasi berlapis dan pencatatan audit log komprehensif.

---

<p align="center">
  Dibuat dengan ❤️ dan dedikasi untuk kemajuan generasi muda Indonesia meraih karir impian di Negeri Sakura.<br>
  <strong>LPK Sahabat Jepang Indonesia (友好日本インドネシア)</strong>
</p>
