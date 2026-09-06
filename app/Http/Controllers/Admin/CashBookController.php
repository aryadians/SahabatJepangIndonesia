<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashTransaction;
use App\Models\SiteSetting;
use App\Traits\UploadsImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashBookController extends Controller
{
    use UploadsImage;

    /**
     * Tampilkan Buku Kas Umum & Jurnal Keuangan LPK
     */
    public function index(Request $request)
    {
        $query = $this->buildFilteredQuery($request);

        // Status Tutup Buku / Periode Terkunci
        $lockDate = SiteSetting::get('financial_lock_until');

        // Filter parameters for view
        $period = $request->input('period', 'this_month');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Hitung Metrik Akumulatif Periode Ini
        $periodIncome = (float) (clone $query)->where('type', 'income')->sum('amount');
        $periodExpense = (float) (clone $query)->where('type', 'expense')->sum('amount');
        $periodNet = $periodIncome - $periodExpense;

        // Total Kas Lembaga Keseluruhan (All-time Current Balance)
        $totalAllIncome = (float) CashTransaction::where('type', 'income')->sum('amount');
        $totalAllExpense = (float) CashTransaction::where('type', 'expense')->sum('amount');
        $overallCashBalance = $totalAllIncome - $totalAllExpense;

        // Saldo Per Akun / Metode Pembayaran (Kas Tunai & Rekening Bank Aktif)
        $balancePerMethod = [];
        foreach (CashTransaction::PAYMENT_METHODS as $methodKey => $methodLabel) {
            $in = (float) CashTransaction::where('payment_method', $methodKey)->where('type', 'income')->sum('amount');
            $out = (float) CashTransaction::where('payment_method', $methodKey)->where('type', 'expense')->sum('amount');
            $balancePerMethod[$methodKey] = [
                'label' => $methodLabel,
                'income' => $in,
                'expense' => $out,
                'balance' => $in - $out,
            ];
        }

        $incomeCategories = CashTransaction::INCOME_CATEGORIES;
        $expenseCategories = CashTransaction::EXPENSE_CATEGORIES;
        $paymentMethods = CashTransaction::PAYMENT_METHODS;

        // Breakdown Kategori untuk Rekap Laba Rugi Periode Terpilih
        $incomeBreakdown = [];
        foreach ($incomeCategories as $catKey => $catLabel) {
            $sum = (float) (clone $query)->where('type', 'income')->where('category', $catKey)->sum('amount');
            if ($sum > 0) {
                $incomeBreakdown[] = [
                    'key' => $catKey,
                    'label' => $catLabel,
                    'amount' => $sum,
                    'percentage' => $periodIncome > 0 ? round(($sum / $periodIncome) * 100, 1) : 0,
                ];
            }
        }

        $expenseBreakdown = [];
        foreach ($expenseCategories as $catKey => $catLabel) {
            $sum = (float) (clone $query)->where('type', 'expense')->where('category', $catKey)->sum('amount');
            if ($sum > 0) {
                $expenseBreakdown[] = [
                    'key' => $catKey,
                    'label' => $catLabel,
                    'amount' => $sum,
                    'percentage' => $periodExpense > 0 ? round(($sum / $periodExpense) * 100, 1) : 0,
                ];
            }
        }

        // Ambil Transaksi Terurut Tanggal & ID
        $transactions = $query->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(25)
            ->withQueryString();

        return view('admin.cash_book.index', compact(
            'transactions',
            'periodIncome',
            'periodExpense',
            'periodNet',
            'overallCashBalance',
            'balancePerMethod',
            'incomeBreakdown',
            'expenseBreakdown',
            'incomeCategories',
            'expenseCategories',
            'paymentMethods',
            'lockDate',
            'period',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Kunci / Buka Tutup Buku Periode Keuangan
     */
    public function togglePeriodLock(Request $request)
    {
        $action = $request->input('action', 'lock');

        if ($action === 'unlock') {
            SiteSetting::set('financial_lock_until', null, 'financial');
            return back()->with('success', 'Kunci periode tutup buku berhasil dibuka. Semua periode kas dapat diedit kembali.');
        }

        $request->validate([
            'lock_date' => 'required|date',
        ]);

        $lockDate = $request->input('lock_date');
        SiteSetting::set('financial_lock_until', $lockDate, 'financial');

        $formattedDate = Carbon::parse($lockDate)->format('d/m/Y');
        return back()->with('success', "Tutup buku berhasil diaktifkan! Transaksi kas sampai dengan {$formattedDate} sekarang terkunci dan terlindungi.");
    }

    /**
     * Simpan Transaksi Kas Masuk / Keluar Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:60',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:100',
            'transaction_date' => 'required|date',
            'payment_method' => 'required|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'proof_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Cek apakah tanggal transaksi berada dalam periode tutup buku
        $lockDate = SiteSetting::get('financial_lock_until');
        if ($lockDate && $validated['transaction_date'] <= $lockDate) {
            $formattedLock = Carbon::parse($lockDate)->format('d/m/Y');
            return back()->with('error', "Gagal! Tanggal transaksi berada dalam periode yang telah Ditutup Buku (Lock Period s/d {$formattedLock}). Buka kunci periode terlebih dahulu jika perlu input susulan.");
        }

        $proofBase64 = null;
        if ($request->hasFile('proof_file')) {
            $file = $request->file('proof_file');
            $mime = $file->getMimeType();
            $data = base64_encode(file_get_contents($file->getRealPath()));
            $proofBase64 = 'data:' . $mime . ';base64,' . $data;
        }

        $trxNumber = CashTransaction::generateNumber($validated['type']);

        CashTransaction::create([
            'transaction_number' => $trxNumber,
            'transaction_date' => $validated['transaction_date'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'reference_type' => 'manual',
            'proof_file' => $proofBase64,
            'notes' => $validated['notes'] ?? null,
            'recorded_by' => auth()->user()->name ?? 'Admin Keuangan',
        ]);

        $typeText = $validated['type'] === 'income' ? 'Kas Masuk' : 'Kas Keluar';
        return redirect()->route('admin.cash-book.index')
            ->with('success', "Transaksi {$typeText} berhasil dicatat dengan No. Bukti {$trxNumber}.");
    }

    /**
     * Perbarui Catatan / Keterangan Transaksi Kas
     */
    public function update(Request $request, $id)
    {
        $transaction = CashTransaction::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:60',
            'payment_method' => 'required|string|max:50',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
            'proof_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Cek proteksi periode tutup buku
        $lockDate = SiteSetting::get('financial_lock_until');
        $existingDate = $transaction->transaction_date ? Carbon::parse($transaction->transaction_date)->format('Y-m-d') : null;
        if ($lockDate && ($existingDate <= $lockDate || $validated['transaction_date'] <= $lockDate)) {
            $formattedLock = Carbon::parse($lockDate)->format('d/m/Y');
            return back()->with('error', "Gagal! Transaksi kas ini berada dalam periode yang telah Ditutup Buku (Lock Period s/d {$formattedLock}). Buka kunci periode terlebih dahulu jika memerlukan koreksi.");
        }

        if ($request->hasFile('proof_file')) {
            $file = $request->file('proof_file');
            $mime = $file->getMimeType();
            $data = base64_encode(file_get_contents($file->getRealPath()));
            $transaction->proof_file = 'data:' . $mime . ';base64,' . $data;
        }

        $transaction->title = $validated['title'];
        $transaction->category = $validated['category'];
        $transaction->payment_method = $validated['payment_method'];
        $transaction->transaction_date = $validated['transaction_date'];
        $transaction->notes = $validated['notes'] ?? null;
        $transaction->save();

        return redirect()->route('admin.cash-book.index')
            ->with('success', "Transaksi {$transaction->transaction_number} berhasil diperbarui.");
    }

    /**
     * Hapus Transaksi Kas
     */
    public function destroy($id)
    {
        $transaction = CashTransaction::findOrFail($id);

        // Cek proteksi periode tutup buku
        $lockDate = SiteSetting::get('financial_lock_until');
        $existingDate = $transaction->transaction_date ? Carbon::parse($transaction->transaction_date)->format('Y-m-d') : null;
        if ($lockDate && $existingDate <= $lockDate) {
            $formattedLock = Carbon::parse($lockDate)->format('d/m/Y');
            return back()->with('error', "Gagal! Transaksi {$transaction->transaction_number} berada dalam periode yang telah Ditutup Buku (s/d {$formattedLock}). Transaksi terkunci dari penghapusan.");
        }

        $no = $transaction->transaction_number;
        $transaction->delete();

        return redirect()->route('admin.cash-book.index')
            ->with('success', "Transaksi {$no} berhasil dihapus dari Buku Kas Umum.");
    }

    /**
     * Ekspor Laporan Buku Kas Umum ke CSV (Format Excel dengan UTF-8 BOM)
     */
    public function exportCsv(Request $request)
    {
        $query = $this->buildFilteredQuery($request);
        $transactions = $query->orderBy('transaction_date', 'asc')->orderBy('id', 'asc')->get();

        $fileName = 'buku_kas_umum_lpk_sji_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        return response()->streamDownload(function () use ($transactions) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

            fputcsv($file, [
                'No',
                'No. Bukti Kas',
                'Tanggal Transaksi',
                'Tipe Mutasi',
                'Kategori Akun',
                'Uraian / Judul Transaksi',
                'Metode Pembayaran',
                'Pemasukan / Debet (Rp)',
                'Pengeluaran / Kredit (Rp)',
                'Saldo Berjalan (Rp)',
                'Keterangan / Memo',
                'Dicatat Oleh',
                'Waktu Input Sistem'
            ]);

            $runningBalance = 0;
            $no = 1;
            foreach ($transactions as $t) {
                $debet = $t->type === 'income' ? (float) $t->amount : 0;
                $kredit = $t->type === 'expense' ? (float) $t->amount : 0;
                $runningBalance += ($debet - $kredit);

                $formattedDate = $t->transaction_date ? Carbon::parse($t->transaction_date)->format('d/m/Y') : '-';
                $createdAt = $t->created_at ? Carbon::parse($t->created_at)->format('d/m/Y H:i') : '-';

                fputcsv($file, [
                    $no++,
                    $t->transaction_number,
                    $formattedDate,
                    $t->type === 'income' ? 'Kas Masuk' : 'Kas Keluar',
                    $t->category_label,
                    $t->title,
                    $t->payment_method_label,
                    $debet,
                    $kredit,
                    $runningBalance,
                    $t->notes ?: '-',
                    $t->recorded_by ?: 'System',
                    $createdAt
                ]);
            }

            fclose($file);
        }, $fileName, $headers);
    }

    /**
     * Cetak Lembar Buku Kas Umum ke Dokumen Resmi A4 Landscape PDF
     */
    public function exportPdf(Request $request)
    {
        $query = $this->buildFilteredQuery($request);
        $transactions = $query->orderBy('transaction_date', 'asc')->orderBy('id', 'asc')->get();

        $totalIncome = (float) $transactions->where('type', 'income')->sum('amount');
        $totalExpense = (float) $transactions->where('type', 'expense')->sum('amount');
        $netCashflow = $totalIncome - $totalExpense;

        return view('admin.cash_book.export_pdf', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'netCashflow'
        ));
    }

    /**
     * Helper Reusable Filter Query Buku Kas
     */
    private function buildFilteredQuery(Request $request)
    {
        $query = CashTransaction::with(['reimbursement', 'student', 'teacher', 'affiliate']);

        // 1. Filter Rentang Waktu (Periode)
        $period = $request->input('period', 'this_month');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        switch ($period) {
            case 'today':
                $query->whereDate('transaction_date', Carbon::today());
                break;
            case 'this_week':
                $query->whereBetween('transaction_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereBetween('transaction_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
            case 'this_year':
                $query->whereYear('transaction_date', Carbon::now()->year);
                break;
            case 'custom':
                if ($startDate && $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate]);
                } elseif ($startDate) {
                    $query->whereDate('transaction_date', '>=', $startDate);
                } elseif ($endDate) {
                    $query->whereDate('transaction_date', '<=', $endDate);
                }
                break;
        }

        // 2. Filter Tipe Transaksi (Income / Expense)
        if ($request->filled('type') && in_array($request->type, ['income', 'expense'])) {
            $query->where('type', $request->type);
        }

        // 3. Filter Kategori Akun
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // 4. Filter Metode Pembayaran
        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }

        // 5. Pencarian Teks (No Bukti, Judul, Keterangan)
        if ($request->filled('q')) {
            $search = trim($request->q);
            $query->where(function ($q) use ($search) {
                $q->where('transaction_number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhere('recorded_by', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    /**
     * Cetak Lembar Bukti Kas Masuk (BKM) atau Bukti Kas Keluar (BKK) Resmi
     */
    public function printVoucher($id)
    {
        $transaction = CashTransaction::with(['student', 'teacher', 'affiliate', 'reimbursement'])->findOrFail($id);
        $settings = SiteSetting::allCached();
        $terbilang = trim($this->terbilang((int)$transaction->amount)) . ' Rupiah';

        return view('admin.cash_book.print_voucher', compact('transaction', 'settings', 'terbilang'));
    }

    /**
     * Konversi Angka ke Kata Terbilang Rupiah
     */
    private function terbilang($number)
    {
        $result = $this->rawTerbilang($number);
        return preg_replace('/\s+/', ' ', trim($result));
    }

    private function rawTerbilang($number)
    {
        $number = abs((int)$number);
        $bilang = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        
        if ($number < 12) {
            return $bilang[$number];
        } elseif ($number < 20) {
            return $this->rawTerbilang($number - 10) . ' Belas';
        } elseif ($number < 100) {
            return $this->rawTerbilang((int)($number / 10)) . ' Puluh ' . $this->rawTerbilang($number % 10);
        } elseif ($number < 200) {
            return 'Seratus ' . $this->rawTerbilang($number - 100);
        } elseif ($number < 1000) {
            return $this->rawTerbilang((int)($number / 100)) . ' Ratus ' . $this->rawTerbilang($number % 100);
        } elseif ($number < 2000) {
            return 'Seribu ' . $this->rawTerbilang($number - 1000);
        } elseif ($number < 1000000) {
            return $this->rawTerbilang((int)($number / 1000)) . ' Ribu ' . $this->rawTerbilang($number % 1000);
        } elseif ($number < 1000000000) {
            return $this->rawTerbilang((int)($number / 1000000)) . ' Juta ' . $this->rawTerbilang($number % 1000000);
        } elseif ($number < 1000000000000) {
            return $this->rawTerbilang((int)($number / 1000000000)) . ' Miliar ' . $this->rawTerbilang($number % 1000000000);
        }
        return (string)$number;
    }
}
