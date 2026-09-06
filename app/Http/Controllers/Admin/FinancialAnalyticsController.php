<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BatchSchedule;
use App\Models\CashTransaction;
use App\Models\Reimbursement;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialAnalyticsController extends Controller
{
    public function index()
    {
        // 1. Core Financial Metrics (Pendapatan Siswa & Buku Kas)
        $totalPotentialRevenue = (float) Student::sum('total_cost');
        $totalRealizedRevenue = (float) Student::sum('paid_amount');
        $totalReceivables = $totalPotentialRevenue - $totalRealizedRevenue;
        $collectionRate = $totalPotentialRevenue > 0 ? round(($totalRealizedRevenue / $totalPotentialRevenue) * 100, 1) : 0;

        $cashBookIncome = (float) CashTransaction::where('type', 'income')->sum('amount');
        $totalInflow = $cashBookIncome > 0 ? $cashBookIncome : $totalRealizedRevenue;

        // 1b. Arus Kas Keluar (Sinkronisasi Pengeluaran Buku Kas Umum & Reimbursement Dinas)
        $totalReimbursements = (float) Reimbursement::where('type', 'reimbursement')
            ->whereIn('status', ['paid', 'settled'])
            ->sum('amount_approved');

        $totalCashAdvances = (float) Reimbursement::where('type', 'cash_advance')
            ->whereIn('status', ['paid', 'settled'])
            ->sum('amount_approved');

        $cashBookExpense = (float) CashTransaction::where('type', 'expense')->sum('amount');
        $totalOutflow = $cashBookExpense > 0 ? $cashBookExpense : ($totalReimbursements + $totalCashAdvances);
        $netCashflow = $totalInflow - $totalOutflow;
        $expenseRatio = $totalInflow > 0 ? round(($totalOutflow / $totalInflow) * 100, 1) : 0;

        // 1c. Grafik Komparatif 12 Bulan (Arus Kas Masuk vs Kas Keluar Terintegrasi)
        $currentYear = now()->year;
        $monthlyComparison = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthStart = Carbon::create($currentYear, $m, 1)->startOfMonth();
            $monthEnd = Carbon::create($currentYear, $m, 1)->endOfMonth();

            $mCashIncome = (float) CashTransaction::where('type', 'income')
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');

            $mStudentInflow = (float) Student::whereBetween('created_at', [$monthStart, $monthEnd])->sum('paid_amount');
            $mInflow = $mCashIncome > 0 ? $mCashIncome : $mStudentInflow;

            $mCashExpense = (float) CashTransaction::where('type', 'expense')
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');

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

            $mOutflow = $mCashExpense > 0 ? $mCashExpense : ($mReimb + $mAdv);
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
            'totalInflow',
            'cashBookIncome',
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

        $cashBookIncome = (float) CashTransaction::where('type', 'income')->sum('amount');
        $totalInflow = $cashBookIncome > 0 ? $cashBookIncome : (float)$totalRealizedRevenue;

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

        // 5. Cash Flow Comparison (Inflow vs Outflow)
        $totalReimbursements = (float) Reimbursement::where('type', 'reimbursement')
            ->whereIn('status', ['approved', 'paid', 'settled'])
            ->sum(DB::raw('COALESCE(amount_approved, amount_requested)'));

        $totalCashAdvances = (float) Reimbursement::where('type', 'cash_advance')
            ->whereIn('status', ['paid', 'settled'])
            ->sum(DB::raw('COALESCE(amount_approved, amount_requested)'));

        $cashBookExpense = (float) CashTransaction::where('type', 'expense')->sum('amount');
        $totalOutflow = $cashBookExpense > 0 ? $cashBookExpense : ($totalReimbursements + $totalCashAdvances);
        $netCashflow = $totalInflow - $totalOutflow;
        $expenseRatio = $totalInflow > 0 ? round(($totalOutflow / $totalInflow) * 100, 1) : 0;

        $currentYear = now()->year;
        $monthlyComparison = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthStart = Carbon::create($currentYear, $m, 1)->startOfMonth();
            $monthEnd = Carbon::create($currentYear, $m, 1)->endOfMonth();

            $mCashIncome = (float) CashTransaction::where('type', 'income')
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');

            $mStudentInflow = (float) Student::whereBetween('created_at', [$monthStart, $monthEnd])->sum('paid_amount');
            $mInflow = $mCashIncome > 0 ? $mCashIncome : $mStudentInflow;

            $mCashExpense = (float) CashTransaction::where('type', 'expense')
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');

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

            $mOutflow = $mCashExpense > 0 ? $mCashExpense : ($mReimb + $mAdv);
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
            'outstandingStudents',
            'totalReimbursements',
            'totalCashAdvances',
            'totalOutflow',
            'netCashflow',
            'expenseRatio',
            'monthlyComparison'
        ));
    }

    /**
     * Laporan Eksekutif Laba Rugi & Arus Kas LPK (Executive P&L Statement)
     */
    public function profitAndLoss(Request $request)
    {
        $data = $this->calculateProfitAndLossData($request);
        return view('admin.finance.profit_loss', $data);
    }

    /**
     * Cetak Lembar Resmi Laporan Laba Rugi A4 Portrait PDF
     */
    public function exportProfitAndLossPdf(Request $request)
    {
        $data = $this->calculateProfitAndLossData($request);
        $data['docNumber'] = 'PL-SJI/' . date('Ym') . '/' . str_pad(rand(100, 999), 4, '0', STR_PAD_LEFT);
        $data['settings'] = \App\Models\SiteSetting::allCached();
        return view('admin.finance.profit_loss_pdf', $data);
    }

    /**
     * Helper Kalkulasi Data Laba Rugi Berdasarkan Periode
     */
    protected function calculateProfitAndLossData(Request $request): array
    {
        $year = (int) $request->input('year', now()->year);
        $quarter = $request->input('quarter'); // 'Q1', 'Q2', 'Q3', 'Q4'
        $month = $request->input('month');     // 1 - 12

        // Tentukan Rentang Waktu
        if (!empty($month) && is_numeric($month) && $month >= 1 && $month <= 12) {
            $month = (int) $month;
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
            $periodType = 'month';
            $periodLabel = 'Bulan ' . $startDate->translatedFormat('F Y');
            $periodKanji = $year . '年' . $month . '月度';
        } elseif (!empty($quarter) && in_array(strtoupper($quarter), ['Q1', 'Q2', 'Q3', 'Q4'])) {
            $quarter = strtoupper($quarter);
            $periodType = 'quarter';
            match($quarter) {
                'Q1' => [
                    $startDate = Carbon::create($year, 1, 1)->startOfDay(),
                    $endDate = Carbon::create($year, 3, 31)->endOfDay(),
                    $periodLabel = "Kuartal I (Jan - Mar) {$year}",
                    $periodKanji = "{$year}年度 第1四半期",
                ],
                'Q2' => [
                    $startDate = Carbon::create($year, 4, 1)->startOfDay(),
                    $endDate = Carbon::create($year, 6, 30)->endOfDay(),
                    $periodLabel = "Kuartal II (Apr - Jun) {$year}",
                    $periodKanji = "{$year}年度 第2四半期",
                ],
                'Q3' => [
                    $startDate = Carbon::create($year, 7, 1)->startOfDay(),
                    $endDate = Carbon::create($year, 9, 30)->endOfDay(),
                    $periodLabel = "Kuartal III (Jul - Sep) {$year}",
                    $periodKanji = "{$year}年度 第3四半期",
                ],
                'Q4' => [
                    $startDate = Carbon::create($year, 10, 1)->startOfDay(),
                    $endDate = Carbon::create($year, 12, 31)->endOfDay(),
                    $periodLabel = "Kuartal IV (Okt - Des) {$year}",
                    $periodKanji = "{$year}年度 第4四半期",
                ],
            };
        } else {
            $periodType = 'year';
            $startDate = Carbon::create($year, 1, 1)->startOfDay();
            $endDate = Carbon::create($year, 12, 31)->endOfDay();
            $periodLabel = "Tahun Buku {$year}";
            $periodKanji = "{$year}年度 通期";
        }

        $incomeCategories = CashTransaction::INCOME_CATEGORIES;
        $expenseCategories = CashTransaction::EXPENSE_CATEGORIES;

        // Query transaksi pemasukan pada periode
        $incomeQuery = CashTransaction::where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate]);

        $incomeItems = [];
        $grossRevenue = 0;
        foreach ($incomeCategories as $catKey => $catLabel) {
            $amount = (float) (clone $incomeQuery)->where('category', $catKey)->sum('amount');
            if ($amount > 0) {
                $incomeItems[] = [
                    'key' => $catKey,
                    'label' => $catLabel,
                    'amount' => $amount,
                ];
                $grossRevenue += $amount;
            }
        }

        // Query transaksi pengeluaran pada periode
        $expenseQuery = CashTransaction::where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate]);

        // Klasifikasi: Beban Pokok Pendidikan / HPP (Direct Educational Cost / COGS)
        $cogsCategories = ['student_equipment'];
        $cogsItems = [];
        $totalCogs = 0;

        // Klasifikasi: Beban Usaha & Administrasi Umum (OPEX)
        $opexItems = [];
        $totalOpex = 0;

        foreach ($expenseCategories as $catKey => $catLabel) {
            $amount = (float) (clone $expenseQuery)->where('category', $catKey)->sum('amount');
            if ($amount > 0) {
                if (in_array($catKey, $cogsCategories)) {
                    $cogsItems[] = [
                        'key' => $catKey,
                        'label' => $catLabel,
                        'amount' => $amount,
                    ];
                    $totalCogs += $amount;
                } else {
                    $opexItems[] = [
                        'key' => $catKey,
                        'label' => $catLabel,
                        'amount' => $amount,
                    ];
                    $totalOpex += $amount;
                }
            }
        }

        // Laba Kotor (Gross Profit) = Gross Revenue - COGS
        $grossProfit = $grossRevenue - $totalCogs;
        $grossMargin = $grossRevenue > 0 ? round(($grossProfit / $grossRevenue) * 100, 1) : 0;

        // Laba Usaha / EBITDA (Operating Profit) = Gross Profit - OPEX
        $operatingProfit = $grossProfit - $totalOpex;
        $operatingMargin = $grossRevenue > 0 ? round(($operatingProfit / $grossRevenue) * 100, 1) : 0;

        // Laba Bersih (Net Profit / Net Income)
        $netProfit = $operatingProfit;
        $netMargin = $grossRevenue > 0 ? round(($netProfit / $grossRevenue) * 100, 1) : 0;

        // Total Beban Keseluruhan (COGS + OPEX)
        $totalExpenses = $totalCogs + $totalOpex;
        $expenseRatio = $grossRevenue > 0 ? round(($totalExpenses / $grossRevenue) * 100, 1) : 0;

        // Tren Bulanan Tahun Terpilih (12 Bulan untuk grafik dan tabel komparasi)
        $monthlyTrends = [];
        for ($m = 1; $m <= 12; $m++) {
            $mStart = Carbon::create($year, $m, 1)->startOfMonth();
            $mEnd = Carbon::create($year, $m, 1)->endOfMonth();

            $mInflow = (float) CashTransaction::where('type', 'income')
                ->whereBetween('transaction_date', [$mStart, $mEnd])
                ->sum('amount');

            $mOutflow = (float) CashTransaction::where('type', 'expense')
                ->whereBetween('transaction_date', [$mStart, $mEnd])
                ->sum('amount');

            $monthlyTrends[] = [
                'month' => $m,
                'name' => $mStart->translatedFormat('M'),
                'inflow' => $mInflow,
                'outflow' => $mOutflow,
                'net' => $mInflow - $mOutflow,
            ];
        }

        // Available years for dropdown
        $minDate = CashTransaction::min('transaction_date');
        $minYear = $minDate ? Carbon::parse($minDate)->year : (now()->year - 2);
        $maxDate = CashTransaction::max('transaction_date');
        $maxYear = max(now()->year + 1, $maxDate ? Carbon::parse($maxDate)->year : now()->year);
        $availableYears = range(max($minYear, 2023), max($maxYear, now()->year));
        rsort($availableYears);

        return compact(
            'year',
            'quarter',
            'month',
            'periodType',
            'periodLabel',
            'periodKanji',
            'startDate',
            'endDate',
            'incomeItems',
            'grossRevenue',
            'cogsItems',
            'totalCogs',
            'grossProfit',
            'grossMargin',
            'opexItems',
            'totalOpex',
            'operatingProfit',
            'operatingMargin',
            'netProfit',
            'netMargin',
            'totalExpenses',
            'expenseRatio',
            'monthlyTrends',
            'availableYears'
        );
    }
}
