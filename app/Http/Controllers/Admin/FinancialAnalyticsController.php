<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BatchSchedule;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialAnalyticsController extends Controller
{
    public function index()
    {
        // 1. Core Financial Metrics
        $totalPotentialRevenue = Student::sum('total_cost');
        $totalRealizedRevenue = Student::sum('paid_amount');
        $totalReceivables = $totalPotentialRevenue - $totalRealizedRevenue;
        $collectionRate = $totalPotentialRevenue > 0 ? round(($totalRealizedRevenue / $totalPotentialRevenue) * 100, 1) : 0;

        // 2. Program Breakdown
        $programRevenue = Student::select('program', 
            DB::raw('COUNT(*) as student_count'),
            DB::raw('SUM(total_cost) as total_potential'),
            DB::raw('SUM(paid_amount) as total_collected'),
            DB::raw('SUM(total_cost - paid_amount) as total_outstanding')
        )
        ->groupBy('program')
        ->get();

        // 3. Payment Status Breakdown (Supports English & Indonesian schema values)
        $statusCounts = [
            'lunas' => Student::whereIn('payment_status', ['paid', 'lunas'])->count(),
            'sebagian' => Student::whereIn('payment_status', ['partial', 'sebagian'])->count(),
            'belum' => Student::whereIn('payment_status', ['unpaid', 'belum', 'talangan'])->count(),
        ];

        // 4. Cashflow Forecasting (Next 30, 60, 90 Days based on Batch Departures & Student Installments)
        $activeBatches = BatchSchedule::whereIn('status', ['open', 'limited', 'buka', 'terbatas'])->orderBy('start_date')->get();
        
        $forecast30Days = Student::whereIn('status', ['active', 'pelatihan'])
            ->whereNotIn('payment_status', ['paid', 'lunas'])
            ->sum(DB::raw('(total_cost - paid_amount) * 0.40')); // Estimasi pelunasan termin 1

        $forecast60Days = Student::whereIn('status', ['active', 'interview', 'matching'])
            ->whereNotIn('payment_status', ['paid', 'lunas'])
            ->sum(DB::raw('(total_cost - paid_amount) * 0.70')); // Estimasi pelunasan termin 2

        $forecast90Days = Student::whereIn('status', ['passed_interview', 'departed', 'terbang'])
            ->whereNotIn('payment_status', ['paid', 'lunas'])
            ->sum(DB::raw('total_cost - paid_amount')); // Estimasi pelunasan penuh sebelum terbang

        // 5. Unpaid Receivables Table (Top Outstanding Balances)
        $outstandingStudents = Student::whereNotIn('payment_status', ['paid', 'lunas'])
            ->whereRaw('total_cost > paid_amount')
            ->orderByRaw('(total_cost - paid_amount) DESC')
            ->paginate(15);

        return view('admin.finance.index', compact(
            'totalPotentialRevenue',
            'totalRealizedRevenue',
            'totalReceivables',
            'collectionRate',
            'programRevenue',
            'statusCounts',
            'activeBatches',
            'forecast30Days',
            'forecast60Days',
            'forecast90Days',
            'outstandingStudents'
        ));
    }
}
