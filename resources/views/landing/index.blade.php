@extends('layouts.app')

@section('title', 'LPK Sahabat Jepang Indonesia - Lembaga Penyalur & Pelatihan Kerja Resmi ke Jepang')

@section('content')
    <!-- 1. Hero Section (3D Animated Canvas & Counters) -->
    @include('components.hero')

    <!-- 1.5. Trusted Japanese Kaisha & Kumiai Partners Marquee -->
    @include('components.partners')

    <!-- 2. About & Credibility Section (SO Kemenaker RI & Akreditasi) -->
    @include('components.about')

    <!-- 3. Programs Catalog Section (SSW, Magang, Bahasa, Engineer) -->
    @include('components.programs')

    <!-- 4. Interactive Salary & Savings Simulator -->
    @include('components.calculator')

    <!-- 5. Step-by-step Road to Japan Timeline -->
    @include('components.timeline')

    <!-- 6. Facilities & Dormitory Gallery (Lazy Loaded Lightbox) -->
    @include('components.facilities')

    <!-- 7. Testimonials & Alumni Success Stories -->
    @include('components.testimonials')

    <!-- 8. Why Choose Us (6 Value Pillars) -->
    @include('components.why-us')

    <!-- 9. Interactive FAQ Accordion -->
    @include('components.faq')

    <!-- 9.5. Educational News & Articles Preview -->
    @include('components.articles')

    <!-- 10. Final Call To Action Banner -->
    @include('components.cta-banner')
@endsection
