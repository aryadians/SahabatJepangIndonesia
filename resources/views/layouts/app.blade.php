<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Primary Meta Tags -->
    <title>@yield('title', ($settings['site_name'] ?? 'LPK Sahabat Jepang Indonesia') . ' - Penyalur Resmi & Pelatihan Kerja ke Jepang')</title>
    <meta name="title" content="@yield('title', ($settings['site_name'] ?? 'LPK Sahabat Jepang Indonesia') . ' - Penyalur Resmi & Pelatihan Kerja ke Jepang')">
    <meta name="description" content="@yield('meta_description', ($settings['site_tagline'] ?? 'Sending Organization Resmi Kemnaker RI Izin KEP.224/LATTAS/XII/2023') . '. Program Tokutei Ginou (SSW), Magang Kerja (Ginou Jisshusei), Beasiswa Kemenkes SMILE Project 100% Gratis, dan SMK Go Japan.')">
    <meta name="keywords" content="@yield('meta_keywords', 'LPK Jepang resmi, magang jepang kemenaker, tokutei ginou ssw, beasiswa kemenkes kaigo smile project, smk go japan vokasi, kursus bahasa jepang n4 n3, sending organization jepang, gaji kerja di jepang, sahabat jepang indonesia')">
    <meta name="author" content="{{ $settings['site_name'] ?? 'LPK Sahabat Jepang Indonesia' }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="theme-color" content="#DC2626">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook / WhatsApp Rich Share Card -->
    <meta property="og:site_name" content="{{ $settings['site_name'] ?? 'LPK Sahabat Jepang Indonesia' }}">
    <meta property="og:type" content="@yield('meta_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', ($settings['site_name'] ?? 'LPK Sahabat Jepang Indonesia') . ' - Karir Gemilang di Negeri Sakura')">
    <meta property="og:description" content="@yield('meta_description', 'Lembaga Pelatihan Kerja & Sending Organization (SO) Resmi Kemnaker RI. Penyaluran resmi Tokutei Ginou (SSW), Magang Kaigo, SMILE Project 100% Gratis, & SMK Go Japan.')">
    <meta property="og:image" content="@yield('meta_image', asset('images/og-share-banner.jpg'))">
    <meta property="og:image:secure_url" content="@yield('meta_image', asset('images/og-share-banner.jpg'))">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $settings['site_name'] ?? 'LPK Sahabat Jepang Indonesia' }} - Official Banner">
    <meta property="og:locale" content="id_ID">
    <meta property="og:locale:alternate" content="ja_JP">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'LPK Sahabat Jepang Indonesia')">
    <meta name="twitter:description" content="@yield('meta_description', 'Lembaga Pelatihan Kerja & Penyaluran Resmi ke Jepang berizin SO Kemenaker RI.')">
    <meta name="twitter:image" content="@yield('meta_image', asset('images/og-share-banner.jpg'))">

    <!-- Favicon (SVG Torii / Kanji Japanese Emblem) & Mobile Touch Icon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='48' fill='%23DC2626'/><circle cx='50' cy='50' r='38' fill='white'/><text x='50' y='66' font-size='46' font-weight='900' font-family='sans-serif' text-anchor='middle' fill='%23DC2626'>友</text></svg>">
    <link rel="apple-touch-icon" href="{{ asset('images/og-share-banner.jpg') }}">


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
      "name": "{{ $settings['site_name'] ?? 'LPK Sahabat Jepang Indonesia' }}",
      "alternateName": "友好日本インドネシア",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('images/og-share-banner.jpg') }}",
      "image": "{{ asset('images/og-share-banner.jpg') }}",
      "description": "Lembaga Pelatihan Kerja (LPK) & Sending Organization (SO) resmi Kemenaker RI Izin No: KEP.224/LATTAS/XII/2023. Program Tokutei Ginou SSW, Magang Kaigo, SMILE Project Kemenkes 100% Gratis, dan SMK Go Japan.",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "Jl. Sakura Raya No. 88, Pusat Karir Jepang",
        "addressLocality": "Jakarta Selatan",
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

        // Guest Live Real-Time Synchronization
        (function initGuestRealTimeSync() {
            function syncGuestData() {
                fetch('{{ route("realtime.guest") }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status !== 'success') return;

                    // Update live statistics counters
                    document.querySelectorAll('[data-live-stat="total_alumni"]').forEach(el => {
                        el.textContent = data.stats.total_alumni + '+';
                    });
                    document.querySelectorAll('[data-live-stat="active_students"]').forEach(el => {
                        el.textContent = data.stats.active_students;
                    });
                    document.querySelectorAll('[data-live-stat="departed_students"]').forEach(el => {
                        el.textContent = data.stats.departed_students;
                    });

                    // Update live batch seats
                    if (data.batches) {
                        data.batches.forEach(b => {
                            document.querySelectorAll(`[data-live-batch-seats="${b.id}"]`).forEach(el => {
                                el.textContent = b.remaining_seats;
                            });
                        });
                    }

                    // Update live brochure download counters
                    if (data.brochures) {
                        data.brochures.forEach(br => {
                            document.querySelectorAll(`[data-live-brochure-downloads="${br.id}"]`).forEach(el => {
                                el.textContent = Number(br.download_count).toLocaleString('id-ID') + ' diunduh';
                            });
                        });
                    }
                })
                .catch(() => {});
            }

            // Initial sync & recurring interval
            syncGuestData();
            setInterval(syncGuestData, 25000);

            // Re-sync when user returns to tab
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    syncGuestData();
                }
            });
        })();

        // Japanese Aesthetic Universal Toast Alert for Public Guests
        window.showJapaneseAlert = function(type, title, message) {
            let container = document.getElementById('guestAlertContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'guestAlertContainer';
                container.className = 'fixed top-5 right-5 z-[9999] flex flex-col gap-2.5 max-w-sm pointer-events-none';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            const typeConfig = {
                success: {
                    border: 'border-emerald-200 bg-white/95 shadow-emerald-500/15',
                    iconBg: 'bg-emerald-50 text-emerald-600',
                    icon: 'check-circle-2',
                    badge: 'bg-emerald-100 text-emerald-800',
                    bar: 'bg-emerald-500',
                    tag: 'Berhasil'
                },
                error: {
                    border: 'border-rose-200 bg-white/95 shadow-rose-500/15',
                    iconBg: 'bg-rose-50 text-japan-600',
                    icon: 'alert-circle',
                    badge: 'bg-rose-100 text-japan-700',
                    bar: 'bg-japan-600',
                    tag: 'Perhatian'
                },
                info: {
                    border: 'border-red-200 bg-white/95 shadow-red-500/15',
                    iconBg: 'bg-red-50 text-japan-600',
                    icon: 'sparkles',
                    badge: 'bg-red-100 text-japan-700',
                    bar: 'bg-japan-600',
                    tag: 'Info LPK'
                }
            }[type || 'info'];

            toast.className = `pointer-events-auto ${typeConfig.border} text-slate-900 p-4 rounded-2xl shadow-2xl border flex items-start gap-3 backdrop-blur-md transform transition-all duration-300 -translate-y-3 opacity-0 max-w-sm relative overflow-hidden`;
            toast.innerHTML = `
                <div class="w-9 h-9 rounded-xl ${typeConfig.iconBg} flex items-center justify-center flex-shrink-0 mt-0.5 shadow-2xs font-bold">
                    <i data-lucide="${typeConfig.icon}" class="w-5 h-5"></i>
                </div>
                <div class="flex-1 min-w-0 pr-2">
                    <div class="flex items-center gap-1.5 mb-0.5">
                        <span class="px-1.5 py-0.2 rounded text-[9px] font-black uppercase tracking-wider ${typeConfig.badge}">
                            ${typeConfig.tag}
                        </span>
                        <h5 class="text-xs font-black text-slate-900 truncate">${title}</h5>
                    </div>
                    <p class="text-[11px] text-slate-600 leading-relaxed font-medium">${message}</p>
                </div>
                <button onclick="this.closest('.pointer-events-auto').remove()" class="text-slate-400 hover:text-slate-700 text-base leading-none p-1">
                    &times;
                </button>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-slate-100">
                    <div class="h-full ${typeConfig.bar} transition-all duration-[4500ms] ease-linear w-full guest-progress-bar"></div>
                </div>
            `;

            container.appendChild(toast);
            if (window.lucide) {
                lucide.createIcons();
            }

            setTimeout(() => {
                toast.classList.remove('-translate-y-3', 'opacity-0');
                const pBar = toast.querySelector('.guest-progress-bar');
                if (pBar) pBar.style.width = '0%';
            }, 50);

            setTimeout(() => {
                toast.classList.add('-translate-y-3', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        };
    </script>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showJapaneseAlert('success', 'Berhasil', '{{ addslashes(session('success')) }}');
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showJapaneseAlert('error', 'Pemberitahuan', '{{ addslashes(session('error')) }}');
            });
        </script>
    @endif
</body>
</html>
