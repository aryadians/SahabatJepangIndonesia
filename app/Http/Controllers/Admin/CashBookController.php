<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashTransaction;
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

        // Ambil Transaksi Terurut Tanggal & ID
        $transactions = $query->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(25)
            ->withQueryString();

        $incomeCategories = CashTransaction::INCOME_CATEGORIES;
        $expenseCategories = CashTransaction::EXPENSE_CATEGORIES;
        $paymentMethods = CashTransaction::PAYMENT_METHODS;

        return view('admin.cash_book.index', compact(
            'transactions',
            'periodIncome',
            'periodExpense',
            'periodNet',
            'overallCashBalance',
            'incomeCategories',
            'expenseCategories',
            'paymentMethods',
            'period',
            'startDate',
            'endDate'
        ));
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
        $query = CashTransaction::query();

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
}
