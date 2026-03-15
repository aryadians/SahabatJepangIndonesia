# Sahabat Jepang Indonesia (SJI) - LPK Website Project

## 1. Project Overview
Project ini bertujuan membangun platform digital modern untuk **LPK Sahabat Jepang Indonesia (SJI)**. Platform ini mencakup website corporate dengan performa tinggi dan sistem manajemen internal (Admin Panel) untuk mengelola ribuan data siswa, pengajar, tagihan, dan program kerja ke Jepang (Magang & SSW).

## 2. Tech Stack (Next.js Modern Stack)
**Stack: Next.js 14+ (App Router) + TypeScript + Tailwind CSS**

### Kenapa Next.js?
1. **Performa & SEO:** Mendukung Server Side Rendering (SSR) untuk artikel berita dan program, sangat baik untuk SEO.
2. **User Experience:** Transisi antar halaman sangat cepat, mendukung Lazy Loading secara native.
3. **Modern UI:** Memudahkan implementasi animasi (Framer Motion) dan desain yang rapi (Shadcn UI).
4. **Custom Admin:** Kita akan membangun Dashboard Admin yang ringan, cepat, dan modern menggunakan Shadcn UI + TanStack Table.

---

## 3. Fitur & Spesifikasi Desain

### A. Branding & Visual
- **Warna Utama:** Merah, Putih, dan Biru (Pattern sesuai bendera Indonesia & Jepang).
- **Desain:** Modern, rapi, profesional.
- **Animasi:** Framer Motion untuk hover effects, scroll animations, dan elemen 3D.
- **Alerts:** SweetAlert2 untuk notifikasi pendaftaran dan konfirmasi.

### B. Website Corporate (Public)
- **Multi-language (i18n):** Bahasa Indonesia, Jepang, dan Inggris (`next-intl`).
- **Pages:**
  - **Homepage:** Hero Section (dengan animasi menarik), Statistik (Ribuan Alumni), Testimonial.
  - **Profil & Vision/Mission:** Sejarah dan tujuan SJI.
  - **Daftar Kelas:** List kelas, biaya transparan, dan deskripsi detail.
  - **Program Kerja:** Detail Program Magang (Ginou Jisshuusei) dan SSW (Tokutei Ginou).
  - **News/Berita & Pengumuman:** Update terbaru LPK.
  - **Mitra Resmi:** Logo-logo perusahaan partner di Jepang.
  - **Tim Pengajar:** Profil pengajar bahasa Jepang.
  - **FAQ:** Pertanyaan yang sering diajukan.

### C. Admin Panel (Internal)
- **Dashboard:** Statistik siswa aktif, tagihan tertunda, dan pendaftaran baru.
- **Data Siswa:** Manajemen ribuan data siswa, upload dokumen, status proses ke Jepang.
- **Data Pengajar:** Jadwal dan absensi (optional).
- **Billing/Tagihan:** Pencatatan biaya, status pembayaran, dan invoice.
- **Program Management:** Update daftar kelas dan biaya.

---

## 4. Struktur Database (Prisma/Drizzle ORM)
- `users`: Admin & Staff.
- `students`: Biodata, Dokumen, Status (Process, Match, Depart).
- `teachers`: Profil pengajar.
- `classes/programs`: Detail program dan biaya.
- `payments`: Histori transaksi.
- `news`: Artikel berita dan pengumuman.

---

## 5. Rencana Pengembangan (Roadmap)

### Phase 1: Setup & i18n
- Inisialisasi Next.js + Tailwind + Shadcn.
- Setup `next-intl` untuk 3 bahasa.
- Layouting Header & Footer (Red/White/Blue theme).

### Phase 2: Landing Page & Animations
- Implementasi Hero Section & 3D/Framer Motion.
- Halaman Profil, Visi Misi, dan Program.
- SweetAlert2 Integration.

### Phase 3: Admin Dashboard
- Setup Auth (NextAuth/Auth.js).
- Create Student & Billing Management (TanStack Table).
- Form pendaftaran online (Client side).

### Phase 4: Optimization & Deployment
- Image Optimization.
- Lazy Loading components.
- Deployment ke Vercel/VPS.

---

## 6. Coding Standards
- **Components:** Functional components dengan React Hooks.
- **State Management:** React Context atau Zustand (jika diperlukan).
- **Styling:** Tailwind CSS Utility-first.
- **Validation:** Zod untuk skema validasi form.

---

**Gemini CLI Note:** File ini adalah Source of Truth. Gunakan Next.js App Router dan utamakan performa serta visual yang "snappy".
