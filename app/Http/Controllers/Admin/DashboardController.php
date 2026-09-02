<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Facility;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\Program;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    /**
     * Dashboard Utama CMS & Leads
     */
    public function index()
    {
        $counts = [
            'leads_total' => Consultation::count(),
            'leads_pending' => Consultation::where('status', 'pending')->count(),
            'leads_contacted' => Consultation::where('status', 'contacted')->count(),
            'leads_registered' => Consultation::where('status', 'registered')->count(),
            'programs' => Program::count(),
            'facilities' => Facility::count(),
            'testimonials' => Testimonial::count(),
            'faqs' => Faq::count(),
            'partners' => Partner::count(),
        ];

        $latestLeads = Consultation::latest()->take(5)->get();
        $programs = Program::orderBy('order')->get();

        return view('admin.dashboard', compact('counts', 'latestLeads', 'programs'));
    }
}
