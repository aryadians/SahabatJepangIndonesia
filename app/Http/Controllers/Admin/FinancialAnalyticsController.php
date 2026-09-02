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

        // 3. Payment Status Breakdown
        $statusCounts = [
            'lunas' => Student::where('payment_status', 'lunas')->count(),
            'sebagian' => Student::where('payment_status', 'sebagian')->count(),
            'belum' => Student::where('payment_status', 'belum')->count(),
        ];

        // 4. Cashflow Forecasting (Next 30, 60, 90 Days based on Batch Departures & Student Installments)
        $activeBatches = BatchSchedule::whereIn('status', ['buka', 'terbatas'])->orderBy('start_date')->get();
        
        $forecast30Days = Student::where('status', 'pelatihan')
            ->where('payment_status', '!=', 'lunas')
            ->sum(DB::raw('(total_cost - paid_amount) * 0.40')); // Estimasi pelunasan termin 1

        $forecast60Days = Student::whereIn('status', ['pelatihan', 'matching'])
            ->where('payment_status', '!=', 'lunas')
            ->sum(DB::raw('(total_cost - paid_amount) * 0.70')); // Estimasi pelunasan termin 2

        $forecast90Days = Student::whereIn('status', ['matching', 'terbang'])
            ->where('payment_status', '!=', 'lunas')
            ->sum(DB::raw('total_cost - paid_amount')); // Estimasi pelunasan penuh sebelum terbang

        // 5. Unpaid Receivables Table (Top Outstanding Balances)
        $outstandingStudents = Student::where('payment_status', '!=', 'lunas')
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
