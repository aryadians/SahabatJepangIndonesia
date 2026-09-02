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
            'students' => \App\Models\Student::count(),
            'students_active' => \App\Models\Student::whereIn('status', ['active', 'interview', 'passed_interview'])->count(),
            'students_departed' => \App\Models\Student::where('status', 'departed')->count(),
            'teachers' => \App\Models\Teacher::count(),
            'schedules' => \App\Models\BatchSchedule::count(),
            'articles' => \App\Models\Article::count(),
            'receivables' => \App\Models\Student::selectRaw('SUM(total_cost - paid_amount) as total_unpaid')->value('total_unpaid') ?? 0,
        ];

        $latestLeads = Consultation::latest()->take(5)->get();
        $latestStudents = \App\Models\Student::latest()->take(5)->get();
        $programs = Program::orderBy('order')->get();

        return view('admin.dashboard', compact('counts', 'latestLeads', 'latestStudents', 'programs'));
    }
}
