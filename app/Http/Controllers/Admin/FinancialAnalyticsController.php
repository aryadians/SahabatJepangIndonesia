<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BatchSchedule;
use App\Models\Reimbursement;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialAnalyticsController extends Controller
{
    public function index()
    {
        // 1. Core Financial Metrics (Pendapatan Siswa)
        $totalPotentialRevenue = (float) Student::sum('total_cost');
        $totalRealizedRevenue = (float) Student::sum('paid_amount');
        $totalReceivables = $totalPotentialRevenue - $totalRealizedRevenue;
        $collectionRate = $totalPotentialRevenue > 0 ? round(($totalRealizedRevenue / $totalPotentialRevenue) * 100, 1) : 0;

        // 1b. Arus Kas Keluar (Pengeluaran Reimburse & Kasbon Dinas)
        $totalReimbursements = (float) Reimbursement::where('type', 'reimbursement')
            ->whereIn('status', ['paid', 'settled'])
            ->sum('amount_approved');

        $totalCashAdvances = (float) Reimbursement::where('type', 'cash_advance')
            ->whereIn('status', ['paid', 'settled'])
            ->sum('amount_approved');

        $totalOutflow = $totalReimbursements + $totalCashAdvances;
        $netCashflow = $totalRealizedRevenue - $totalOutflow;
        $expenseRatio = $totalRealizedRevenue > 0 ? round(($totalOutflow / $totalRealizedRevenue) * 100, 1) : 0;

        // 1c. Grafik Komparatif 12 Bulan (Arus Kas Masuk vs Kas Keluar)
        $currentYear = now()->year;
        $monthlyComparison = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthStart = Carbon::create($currentYear, $m, 1)->startOfMonth();
            $monthEnd = Carbon::create($currentYear, $m, 1)->endOfMonth();

            $mInflow = (float) Student::whereBetween('created_at', [$monthStart, $monthEnd])->sum('paid_amount');

            $mReimb = (float) Reimbursement::where('type', 'reimbursement')
                ->whereIn('status', ['paid', 'settled'])
                ->where(function ($q) use ($monthStart, $monthEnd) {
                    $q->whereBetween('paid_at', [$monthStart, $monthEnd])
                      ->orWhere(function ($sub) use ($monthStart, $monthEnd) {
                          $sub->whereNull('paid_at')->whereBetween('created_at', [$monthStart, $monthEnd]);
                      });
                })
                ->sum('amount_approved');

            $mAdv = (float) Reimbursement::where('type', 'cash_advance')
                ->whereIn('status', ['paid', 'settled'])
                ->where(function ($q) use ($monthStart, $monthEnd) {
                    $q->whereBetween('paid_at', [$monthStart, $monthEnd])
                      ->orWhere(function ($sub) use ($monthStart, $monthEnd) {
                          $sub->whereNull('paid_at')->whereBetween('created_at', [$monthStart, $monthEnd]);
                      });
                })
                ->sum('amount_approved');

            $mOutflow = $mReimb + $mAdv;
            $monthlyComparison[] = [
                'month' => $m,
                'month_name' => $monthStart->translatedFormat('M'),
                'inflow' => $mInflow,
                'outflow_reimburse' => $mReimb,
                'outflow_advance' => $mAdv,
                'outflow' => $mOutflow,
                'net' => $mInflow - $mOutflow,
            ];
        }

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
            'totalReimbursements',
            'totalCashAdvances',
            'totalOutflow',
            'netCashflow',
            'expenseRatio',
            'monthlyComparison',
            'programRevenue',
            'statusCounts',
            'activeBatches',
            'forecast30Days',
            'forecast60Days',
            'forecast90Days',
            'outstandingStudents'
        ));
    }

    /**
     * Export / Cetak Laporan Eksekutif Keuangan & Arus Kas ke PDF Resmi
     */
    public function exportPdf()
    {
        $totalPotentialRevenue = Student::sum('total_cost');
        $totalRealizedRevenue = Student::sum('paid_amount');
        $totalReceivables = $totalPotentialRevenue - $totalRealizedRevenue;
        $collectionRate = $totalPotentialRevenue > 0 ? round(($totalRealizedRevenue / $totalPotentialRevenue) * 100, 1) : 0;

        $programRevenue = Student::select('program', 
            DB::raw('COUNT(*) as student_count'),
            DB::raw('SUM(total_cost) as total_potential'),
            DB::raw('SUM(paid_amount) as total_collected'),
            DB::raw('SUM(total_cost - paid_amount) as total_outstanding')
        )
        ->groupBy('program')
        ->get();

        $statusCounts = [
            'lunas' => Student::whereIn('payment_status', ['paid', 'lunas'])->count(),
            'sebagian' => Student::whereIn('payment_status', ['partial', 'sebagian'])->count(),
            'belum' => Student::whereIn('payment_status', ['unpaid', 'belum', 'talangan'])->count(),
        ];

        $forecast30Days = Student::whereIn('status', ['active', 'pelatihan'])
            ->whereNotIn('payment_status', ['paid', 'lunas'])
            ->sum(DB::raw('(total_cost - paid_amount) * 0.40'));

        $forecast60Days = Student::whereIn('status', ['active', 'interview', 'matching'])
            ->whereNotIn('payment_status', ['paid', 'lunas'])
            ->sum(DB::raw('(total_cost - paid_amount) * 0.70'));

        $forecast90Days = Student::whereIn('status', ['passed_interview', 'departed', 'terbang'])
            ->whereNotIn('payment_status', ['paid', 'lunas'])
            ->sum(DB::raw('total_cost - paid_amount'));

        $outstandingStudents = Student::whereNotIn('payment_status', ['paid', 'lunas'])
            ->whereRaw('total_cost > paid_amount')
            ->orderByRaw('(total_cost - paid_amount) DESC')
            ->get();

        return view('admin.finance.export_pdf', compact(
            'totalPotentialRevenue',
            'totalRealizedRevenue',
            'totalReceivables',
            'collectionRate',
            'programRevenue',
            'statusCounts',
            'forecast30Days',
            'forecast60Days',
            'forecast90Days',
            'outstandingStudents'
        ));
    }
}
