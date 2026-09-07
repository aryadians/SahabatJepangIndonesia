@extends('layouts.app')

@section('title', 'SJI Group • PT SAHABAT JEPANG INDONESIA GROUP - Penyalur Resmi & Pelatihan Kerja ke Jepang')
@section('meta_description', 'Holding Sending Organization (SO) resmi Kemenaker RI PT Sahabat Jepang Indonesia Group (SJI Group). Penyaluran kerja Tokutei Ginou (SSW), Magang Teknis, Beasiswa SMILE Project Kemenkes, dan SMK Go Japan.')
@section('meta_keywords', 'LPK Jepang resmi, magang jepang kemenaker, tokutei ginou ssw, smile project kemenkes kaigo gratis, smk go japan vokasi, kursus bahasa jepang n4 n3, sending organization jepang, sahabat jepang indonesia')

@section('content')
    <!-- 1. Hero Section (3D Animated Canvas & Counters) -->
    @include('components.hero')

    <!-- 1.5. Trusted Japanese Kaisha & Kumiai Partners Marquee -->
    @include('components.partners')

    <!-- 2. About & Credibility Section (SO Kemenaker RI & Akreditasi) -->
    @include('components.about')

    <!-- 3. Programs Catalog Section (SSW, Magang, Bahasa, Engineer) -->
    @include('components.programs')

    <!-- 3.5. Jadwal Angkatan & Kuota Penerimaan -->
    @include('components.schedule')

    <!-- 4. Interactive Salary & Savings Simulator -->
    @include('components.calculator')

    <!-- 5. Step-by-step Road to Japan Timeline -->
    @include('components.timeline')

    <!-- 6. Facilities & Dormitory Gallery (Lazy Loaded Lightbox) -->
    @include('components.facilities')

    <!-- 6.5. Professional Sensei & Instructors Showcase -->
    @include('components.teachers')

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
