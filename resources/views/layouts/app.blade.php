<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Primary Meta Tags -->
    <title>@yield('title', 'LPK Sahabat Jepang Indonesia - Lembaga Penyalur & Pelatihan Kerja Resmi ke Jepang')</title>
    <meta name="title" content="LPK Sahabat Jepang Indonesia - Lembaga Penyalur & Pelatihan Kerja Resmi ke Jepang">
    <meta name="description" content="LPK Sahabat Jepang Indonesia adalah Lembaga Pelatihan Kerja dan Sending Organization (SO) resmi Kemenaker RI untuk program Tokutei Ginou (SSW), Magang Kerja (Ginou Jisshusei), dan Kursus Bahasa Jepang.">
    <meta name="keywords" content="LPK Jepang, kerja di jepang, magang jepang, tokutei ginou, ssw jepang, sending organization jepang, kursus bahasa jepang, sahabat jepang indonesia, gaji kerja di jepang">
    <meta name="author" content="LPK Sahabat Jepang Indonesia">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#DC2626">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'LPK Sahabat Jepang Indonesia - Karir Gemilang di Negeri Sakura')">
    <meta property="og:description" content="Raih impian bekerja di Jepang dengan gaji puluhan juta rupiah. Terakreditasi resmi Kemenaker RI & Izin SO Resmi.">
    <meta property="og:image" content="https://images.unsplash.com/photo-1503899036084-c55cdd92da26?auto=format&fit=crop&w=1200&q=80">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'LPK Sahabat Jepang Indonesia')">
    <meta name="twitter:description" content="Lembaga Pelatihan Kerja & Penyaluran Resmi ke Jepang berizin SO Kemenaker RI.">
    <meta name="twitter:image" content="https://images.unsplash.com/photo-1503899036084-c55cdd92da26?auto=format&fit=crop&w=1200&q=80">

    <!-- Favicon (SVG Torii / Kanji Japanese Emblem) -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='48' fill='%23DC2626'/><circle cx='50' cy='50' r='38' fill='white'/><text x='50' y='66' font-size='46' font-weight='900' font-family='sans-serif' text-anchor='middle' fill='%23DC2626'>友</text></svg>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&family=Zen+Maru+Gothic:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (via Tailwind Play CDN with Custom Colors) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        japan: {
                            50: '#FEF2F2',
                            100: '#FEE2E2',
                            200: '#FECACA',
                            300: '#FCA5A5',
                            400: '#F87171',
                            500: '#EF4444',
                            600: '#DC2626',
                            700: '#B91C1C',
                            800: '#991B1B',
                            900: '#7F1D1D',
                            dark: '#5B1111',
                        },
                        sakura: {
                            50: '#FFF1F2',
                            100: '#FFE4E6',
                            200: '#FECDD3',
                            300: '#FDA4AF',
                            400: '#FB7185',
                            500: '#F43F5E',
                        },
                        slate: {
                            850: '#151E2E',
                            950: '#0B0F19',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        japanese: ['"Zen Maru Gothic"', 'sans-serif'],
                    },
                    boxShadow: {
                        'red-glow': '0 0 25px rgba(220, 38, 38, 0.35)',
                        'card-hover': '0 20px 35px -10px rgba(220, 38, 38, 0.12), 0 1px 3px rgba(0,0,0,0.05)',
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Structured Data JSON-LD (SEO) -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "EducationalOrganization",
      "name": "LPK Sahabat Jepang Indonesia",
      "alternateName": "友好日本インドネシア",
      "url": "{{ url('/') }}",
      "logo": "https://images.unsplash.com/photo-1503899036084-c55cdd92da26?auto=format&fit=crop&w=300&q=80",
      "description": "Lembaga Pelatihan Kerja & Penyaluran Tenaga Kerja Resmi ke Jepang (Sending Organization Kemenaker RI).",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "Jl. Sakura Raya No. 88, Pusat Karir Jepang",
        "addressLocality": "Jakarta",
        "addressCountry": "ID"
      },
      "contactPoint": {
        "@@type": "ContactPoint",
        "telephone": "+62-812-3456-7890",
        "contactType": "Customer Service",
        "availableLanguage": ["Indonesian", "Japanese"]
      }
    }
    </script>
</head>
<body class="bg-[#FAFAFA] text-slate-800 antialiased selection:bg-red-500 selection:text-white relative">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-japan-900 via-japan-700 to-japan-800 text-white text-xs sm:text-sm py-2 px-4 text-center font-medium shadow-sm relative z-40">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-center gap-2 sm:gap-6">
            <span class="inline-flex items-center gap-1.5 bg-white/20 text-white px-2.5 py-0.5 rounded-full text-xs font-semibold backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                {{ $settings['announcement_badge'] ?? 'Batch Baru 2026 Dibuka' }}
            </span>
            <span>{{ $settings['announcement_text'] ?? '🌸 Pendaftaran Gelombang Khusus Tokutei Ginou & Magang Jepang Telah Dibuka! Kuota Terbatas.' }}</span>
            <button onclick="openModal('consultationModal')" class="underline underline-offset-4 hover:text-red-200 font-bold ml-1 transition">
                Daftar Sekarang &rarr;
            </button>
        </div>
    </div>

    <!-- Sticky Navigation Bar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Floating Action Widgets (WhatsApp & Scroll to top) -->
    @include('components.floating-widgets')

    <!-- Pop-up Modals -->
    @include('components.consultation-modal')
    @include('components.program-modal')
    @include('components.facility-modal')
    @include('components.quiz-modal')
    @include('components.success-modal')

    <!-- Custom App Script -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
</body>
</html>
