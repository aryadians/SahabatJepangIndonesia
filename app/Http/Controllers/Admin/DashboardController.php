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
        $totalCost = \App\Models\Student::sum('total_cost') ?? 0;
        $paidAmount = \App\Models\Student::sum('paid_amount') ?? 0;
        $receivables = max(0, $totalCost - $paidAmount);
        $recoveryRate = $totalCost > 0 ? round(($paidAmount / $totalCost) * 100, 1) : 100;

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
            'receivables' => $receivables,
            'total_cost' => $totalCost,
            'paid_amount' => $paidAmount,
            'recovery_rate' => $recoveryRate,
            // Pipeline breakdown
            'pipe_active' => \App\Models\Student::where('status', 'active')->count(),
            'pipe_interview' => \App\Models\Student::where('status', 'interview')->count(),
            'pipe_passed' => \App\Models\Student::where('status', 'passed_interview')->count(),
            'pipe_departed' => \App\Models\Student::where('status', 'departed')->count(),
            'pipe_graduated' => \App\Models\Student::where('status', 'graduated')->count(),
            // Keuangan Reimburse & Arsip Digital
            'reimbursements_pending' => \App\Models\Reimbursement::where('status', 'submitted')->count(),
            'reimbursements_paid' => \App\Models\Reimbursement::where('type', 'reimbursement')->whereIn('status', ['paid', 'settled'])->sum('amount_approved'),
            'advances_active' => \App\Models\Reimbursement::where('type', 'cash_advance')->whereIn('status', ['approved', 'paid'])->sum('amount_approved'),
            'unsettled_advances' => \App\Models\Reimbursement::where('type', 'cash_advance')->whereIn('status', ['approved', 'paid'])->count(),
            'archives_total' => \App\Models\DigitalArchive::count(),
            'folders_total' => \App\Models\ArchiveFolder::count(),
            // Buku Kas Umum Real-time
            'cash_balance' => ((float) \App\Models\CashTransaction::where('type', 'income')->sum('amount')) - ((float) \App\Models\CashTransaction::where('type', 'expense')->sum('amount')),
            'cash_income_month' => (float) \App\Models\CashTransaction::where('type', 'income')->whereBetween('transaction_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount'),
            'cash_expense_month' => (float) \App\Models\CashTransaction::where('type', 'expense')->whereBetween('transaction_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount'),
            'is_financial_locked' => !empty(\App\Models\SiteSetting::get('financial_lock_until')),
        ];

        // 6-Month Intake Trend (DB agnostic using Carbon)
        $monthlyIntake = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = now()->subMonths($i);
            $start = $monthDate->copy()->startOfMonth();
            $end = $monthDate->copy()->endOfMonth();
            $label = $monthDate->translatedFormat('M Y');
            $studentCount = \App\Models\Student::whereBetween('created_at', [$start, $end])->count();
            $leadCount = Consultation::whereBetween('created_at', [$start, $end])->count();

            $monthlyIntake[] = [
                'label' => $label,
                'short' => $monthDate->translatedFormat('M'),
                'students' => $studentCount,
                'leads' => $leadCount,
            ];
        }

        $latestLeads = Consultation::latest()->take(5)->get();
        $latestStudents = \App\Models\Student::latest()->take(5)->get();
        $latestCashTransactions = \App\Models\CashTransaction::latest('transaction_date')->latest('id')->take(5)->get();
        $programs = Program::orderBy('order')->get();

        return view('admin.dashboard', compact('counts', 'monthlyIntake', 'latestLeads', 'latestStudents', 'latestCashTransactions', 'programs'));
    }
}
