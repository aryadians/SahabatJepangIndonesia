<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArchiveFolder;
use App\Models\CashTransaction;
use App\Models\DigitalArchive;
use App\Models\Reimbursement;
use App\Models\SiteSetting;
use App\Models\Teacher;
use App\Services\FonnteService;
use App\Traits\UploadsImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReimbursementController extends Controller
{
    use UploadsImage;

    /**
     * Tampilkan Dashboard & Daftar Klaim Reimburse / Kasbon Dinas
     */
    public function index(Request $request)
    {
        $reimbursements = $this->filterQuery($request)->paginate(15)->withQueryString();

        // Statistik KPI Keuangan Dinas
        $stats = [
            'total_reimbursed' => Reimbursement::where('type', 'reimbursement')
                ->whereIn('status', ['paid', 'settled'])
                ->sum('amount_approved'),
            'active_advances' => Reimbursement::where('type', 'cash_advance')
                ->whereIn('status', ['approved', 'paid'])
                ->sum('amount_approved'),
            'pending_count' => Reimbursement::where('status', 'submitted')->count(),
            'unsettled_advances_count' => Reimbursement::where('type', 'cash_advance')
                ->whereIn('status', ['approved', 'paid'])
                ->count(),
            'total_transactions' => Reimbursement::count(),
        ];

        $employees = Teacher::orderBy('name')->get();
        $paymentMethods = CashTransaction::PAYMENT_METHODS;
        $lockDate = SiteSetting::get('financial_lock_until');

        return view('admin.reimbursements.index', compact('reimbursements', 'stats', 'employees', 'paymentMethods', 'lockDate'));
    }

    /**
     * API: Ambil Data Statistik Mini Dashboard Real-time
     */
    public function stats()
    {
        $reimbursed = Reimbursement::where('type', 'reimbursement')->whereIn('status', ['paid', 'settled'])->sum('amount_approved');
        $advances = Reimbursement::where('type', 'cash_advance')->whereIn('status', ['approved', 'paid'])->sum('amount_approved');
        $pending = Reimbursement::where('status', 'submitted')->count();
        $unsettled = Reimbursement::where('type', 'cash_advance')->whereIn('status', ['approved', 'paid'])->count();
        $total = Reimbursement::count();

        return response()->json([
            'success' => true,
            'stats' => [
                'total_reimbursed' => $reimbursed,
                'total_reimbursed_formatted' => 'Rp ' . number_format($reimbursed, 0, ',', '.'),
                'active_advances' => $advances,
                'active_advances_formatted' => 'Rp ' . number_format($advances, 0, ',', '.'),
                'pending_count' => $pending,
                'unsettled_advances_count' => $unsettled,
                'total_transactions' => $total,
            ],
        ]);
    }

    /**
     * Simpan Pengajuan Reimbursement / Kasbon Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'nullable|exists:teachers,id',
            'employee_name' => 'required_without:teacher_id|nullable|string|max:150',
            'type' => 'required|in:reimbursement,cash_advance',
            'category' => 'required|string|max:60',
            'title' => 'required|string|max:255',
            'destination' => 'nullable|string|max:150',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'amount_requested' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1500',
            'receipt_files.*' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'receipt_titles.*' => 'nullable|string|max:255',
            'receipt_amounts.*' => 'nullable|numeric|min:0',
        ]);

        // Tentukan nama pegawai jika memilih dari dropdown
        $employeeName = $validated['employee_name'] ?? null;
        if (!empty($validated['teacher_id'])) {
            $employee = Teacher::find($validated['teacher_id']);
            if ($employee) {
                $employeeName = $employee->name;
            }
        }

        // Generate Nomor Seri Unik
        $reimbursementNo = Reimbursement::generateNumber($validated['type']);

        // Olah Multi-Nota Base64 (LONGTEXT)
        $receipts = [];
        if ($request->hasFile('receipt_files')) {
            $files = $request->file('receipt_files');
            $titles = $request->input('receipt_titles', []);
            $amounts = $request->input('receipt_amounts', []);

            foreach ($files as $idx => $file) {
                if ($file->isValid()) {
                    $mime = $file->getMimeType() ?: 'application/octet-stream';
                    $fileSize = round($file->getSize() / 1024, 1) . ' KB';
                    
                    if (extension_loaded('gd') && str_starts_with($mime, 'image/')) {
                        $compressed = $this->compressImageForBase64($file->getRealPath(), $mime);
                        if ($compressed !== null) {
                            $base64 = 'data:' . $compressed['mime'] . ';base64,' . base64_encode($compressed['data']);
                            $fileSize = round(strlen($compressed['data']) / 1024, 1) . ' KB';
                            $mime = $compressed['mime'];
                        } else {
                            $base64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
                        }
                    } else {
                        $base64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
                    }

                    $itemTitle = $titles[$idx] ?? 'Nota ' . ($idx + 1);
                    $itemAmount = !empty($amounts[$idx]) ? (float) $amounts[$idx] : 0;

                    $receipts[] = [
                        'id' => uniqid('rcpt_'),
                        'title' => $itemTitle,
                        'category' => $validated['category'],
                        'amount' => $itemAmount,
                        'date' => now()->toDateString(),
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $mime,
                        'file_size' => $fileSize,
                        'base64_image' => $base64,
                        'notes' => null,
                    ];
                }
            }
        }

        $reimbursement = Reimbursement::create([
            'reimbursement_no' => $reimbursementNo,
            'teacher_id' => $validated['teacher_id'] ?? null,
            'employee_name' => $employeeName ?: 'Karyawan LPK SJI',
            'type' => $validated['type'],
            'category' => $validated['category'],
            'title' => $validated['title'],
            'destination' => $validated['destination'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'amount_requested' => $validated['amount_requested'],
            'amount_approved' => 0,
            'amount_spent' => 0,
            'amount_diff' => 0,
            'status' => 'submitted',
            'notes' => $validated['notes'] ?? null,
            'receipts_data' => $receipts,
            'created_by' => auth()->user()->name ?? 'Admin',
        ]);

        // Otomatis simpan juga ke Arsip Digital Dokumen agar terintegrasi di panel arsip
        $reimburseFolder = ArchiveFolder::firstOrCreate(
            ['name' => 'Nota & Kuitansi Reimburse'],
            ['color' => 'emerald', 'created_by' => 'Sistem Keuangan']
        );

        foreach ($receipts as $rc) {
            DigitalArchive::create([
                'archive_no' => DigitalArchive::generateNumber(),
                'folder_id' => $reimburseFolder->id,
                'title' => "Bukti [{$reimbursementNo}] - " . $rc['title'],
                'category' => 'nota_reimburse',
                'reimbursement_id' => $reimbursement->id,
                'uploader_name' => $employeeName,
                'document_date' => $reimbursement->start_date ?? now()->toDateString(),
                'file_name' => $rc['file_name'] ?? 'nota.jpg',
                'file_type' => $rc['file_type'] ?? 'image/jpeg',
                'file_size' => $rc['file_size'] ?? '100 KB',
                'file_base64' => $rc['base64_image'],
                'notes' => "Lampiran pengajuan: " . $reimbursement->title,
            ]);
        }

        return redirect()->route('admin.reimbursements.index')
            ->with('success', "Pengajuan {$reimbursement->type_badge['short_label']} nomor {$reimbursementNo} berhasil dibuat.");
    }

    /**
     * Update Status & Aksi Bendahara (Approve, Cairkan/Paid, Settle Realisasi, Reject)
     */
    public function updateStatus(Request $request, $id)
    {
        $reimbursement = Reimbursement::findOrFail($id);

        $action = $request->input('action'); // approve, pay, settle, reject

        switch ($action) {
            case 'approve':
                $approvedAmount = $request->input('amount_approved', $reimbursement->amount_requested);
                $reimbursement->update([
                    'status' => 'approved',
                    'amount_approved' => (float) $approvedAmount,
                    'approved_by' => auth()->user()->name ?? 'Bendahara Keuangan',
                ]);
                $msg = "Pengajuan {$reimbursement->reimbursement_no} disetujui sebesar Rp " . number_format($approvedAmount, 0, ',', '.');
                break;

            case 'pay':
                $paymentMethod = $request->input('payment_method', 'cash_kasir');
                if (!array_key_exists($paymentMethod, CashTransaction::PAYMENT_METHODS)) {
                    $paymentMethod = 'cash_kasir';
                }

                $paymentDate = $request->input('payment_date', now()->toDateString());
                $lockDate = SiteSetting::get('financial_lock_until');
                if ($lockDate && Carbon::parse($paymentDate)->format('Y-m-d') <= $lockDate) {
                    return back()->with('error', "Gagal mencairkan: Tanggal pembayaran (" . Carbon::parse($paymentDate)->format('d/m/Y') . ") berada dalam periode yang telah Tutup Buku (s/d " . Carbon::parse($lockDate)->format('d/m/Y') . ").");
                }

                $approvedAmount = $request->filled('amount_approved') 
                    ? (float) $request->input('amount_approved') 
                    : ($reimbursement->amount_approved > 0 ? $reimbursement->amount_approved : $reimbursement->amount_requested);

                $paymentProof = null;
                if ($request->hasFile('payment_proof')) {
                    $paymentProof = $this->handleImageUpload($request, 'payment_proof', 'payment_proof_url');
                } elseif (!empty($reimbursement->receipts_data) && !empty($reimbursement->receipts_data[0]['base64_image'])) {
                    $paymentProof = $reimbursement->receipts_data[0]['base64_image'];
                }

                $paymentNotes = $request->input('payment_notes');
                $combinedNotes = "Nomor Dokumen: {$reimbursement->reimbursement_no}";
                if (!empty($paymentNotes)) {
                    $combinedNotes .= " | " . $paymentNotes;
                }

                $reimbursement->update([
                    'status' => 'paid',
                    'amount_approved' => $approvedAmount,
                    'paid_at' => Carbon::parse($paymentDate . ' ' . now()->toTimeString()),
                    'approved_by' => auth()->user()->name ?? 'Bendahara Keuangan',
                ]);

                // Auto-record to CashTransaction (General Cash Book & Jurnal Keuangan)
                $category = $reimbursement->type === 'cash_advance' ? 'cash_advance' : 'reimbursement';
                $existingTrx = CashTransaction::where('reference_type', 'reimbursement')
                    ->where('reference_id', $reimbursement->id)
                    ->where('type', 'expense')
                    ->first();

                if ($existingTrx) {
                    $existingTrx->update([
                        'transaction_date' => $paymentDate,
                        'category' => $category,
                        'title' => "Pencairan {$reimbursement->type_label}: {$reimbursement->title} ({$reimbursement->employee_name})",
                        'amount' => $approvedAmount,
                        'payment_method' => $paymentMethod,
                        'proof_file' => $paymentProof ?? $existingTrx->proof_file,
                        'notes' => $combinedNotes,
                        'recorded_by' => auth()->user()->name ?? 'Bendahara Keuangan',
                    ]);
                    $trxNumber = $existingTrx->transaction_number;
                } else {
                    $newTrx = CashTransaction::create([
                        'transaction_number' => CashTransaction::generateNumber('expense'),
                        'transaction_date' => $paymentDate,
                        'type' => 'expense',
                        'category' => $category,
                        'title' => "Pencairan {$reimbursement->type_label}: {$reimbursement->title} ({$reimbursement->employee_name})",
                        'amount' => $approvedAmount,
                        'payment_method' => $paymentMethod,
                        'reference_type' => 'reimbursement',
                        'reference_id' => $reimbursement->id,
                        'proof_file' => $paymentProof,
                        'notes' => $combinedNotes,
                        'recorded_by' => auth()->user()->name ?? 'Bendahara Keuangan',
                    ]);
                    $trxNumber = $newTrx->transaction_number;
                }

                $actionLabel = $reimbursement->type === 'cash_advance' ? 'Dana Uang Muka berhasil dicairkan' : 'Uang Reimburse berhasil dibayarkan ke karyawan';
                $methodLabel = CashTransaction::PAYMENT_METHODS[$paymentMethod] ?? $paymentMethod;
                $msg = "{$actionLabel} (Metode: {$methodLabel}) untuk dokumen {$reimbursement->reimbursement_no}. Otomatis tercatat di Buku Kas Umum & Jurnal Keuangan [{$trxNumber}].";
                break;

            case 'settle':
                // Penyelesaian Kasbon / Realisasi Pengeluaran SPJ
                $spent = (float) $request->input('amount_spent', 0);
                $diff = $spent - (float) $reimbursement->amount_approved;
                $settleNotes = $request->input('settlement_notes');
                $settleDate = $request->input('settlement_date', now()->toDateString());
                $settlePaymentMethod = $request->input('settlement_payment_method', 'cash_kasir');
                if (!array_key_exists($settlePaymentMethod, CashTransaction::PAYMENT_METHODS)) {
                    $settlePaymentMethod = 'cash_kasir';
                }

                // Cek period lock jika terdapat mutasi kas selisih
                if ($diff != 0) {
                    $lockDate = SiteSetting::get('financial_lock_until');
                    if ($lockDate && Carbon::parse($settleDate)->format('Y-m-d') <= $lockDate) {
                        return back()->with('error', "Gagal menyelesaikan SPJ: Tanggal rekonsiliasi (" . Carbon::parse($settleDate)->format('d/m/Y') . ") berada dalam periode yang telah Tutup Buku (s/d " . Carbon::parse($lockDate)->format('d/m/Y') . ").");
                    }
                }

                // Tambahkan nota baru jika ada diupload saat settlement
                $existingReceipts = $reimbursement->receipts_data ?? [];
                if ($request->hasFile('settlement_receipts')) {
                    foreach ($request->file('settlement_receipts') as $file) {
                        if ($file->isValid()) {
                            $mime = $file->getMimeType() ?: 'application/octet-stream';
                            $fileSize = round($file->getSize() / 1024, 1) . ' KB';

                            if (extension_loaded('gd') && str_starts_with($mime, 'image/')) {
                                $compressed = $this->compressImageForBase64($file->getRealPath(), $mime);
                                if ($compressed !== null) {
                                    $base64 = 'data:' . $compressed['mime'] . ';base64,' . base64_encode($compressed['data']);
                                    $fileSize = round(strlen($compressed['data']) / 1024, 1) . ' KB';
                                    $mime = $compressed['mime'];
                                } else {
                                    $base64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
                                }
                            } else {
                                $base64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
                            }

                            $newItem = [
                                'id' => uniqid('rcpt_stl_'),
                                'title' => 'Nota Realisasi SPJ - ' . $file->getClientOriginalName(),
                                'category' => $reimbursement->category,
                                'amount' => 0,
                                'date' => $settleDate,
                                'file_name' => $file->getClientOriginalName(),
                                'file_type' => $mime,
                                'file_size' => $fileSize,
                                'base64_image' => $base64,
                                'notes' => 'Diserahkan saat settlement',
                            ];
                            $existingReceipts[] = $newItem;

                            $reimburseFolder = ArchiveFolder::firstOrCreate(
                                ['name' => 'Nota & Kuitansi Reimburse'],
                                ['color' => 'emerald', 'created_by' => 'Sistem Keuangan']
                            );

                            DigitalArchive::create([
                                'archive_no' => DigitalArchive::generateNumber(),
                                'folder_id' => $reimburseFolder->id,
                                'title' => "SPJ [{$reimbursement->reimbursement_no}] - " . $file->getClientOriginalName(),
                                'category' => 'nota_reimburse',
                                'reimbursement_id' => $reimbursement->id,
                                'uploader_name' => $reimbursement->employee_name,
                                'document_date' => $settleDate,
                                'file_name' => $file->getClientOriginalName(),
                                'file_type' => $mime,
                                'file_size' => round($file->getSize() / 1024, 1) . ' KB',
                                'file_base64' => $base64,
                                'notes' => "Bukti Realisasi Kasbon: {$reimbursement->title}",
                            ]);
                        }
                    }
                }

                $combinedNotes = $reimbursement->notes;
                if (!empty($settleNotes)) {
                    $combinedNotes .= "\n[Catatan SPJ " . Carbon::parse($settleDate)->format('d/m/Y') . "]: " . $settleNotes;
                }

                $reimbursement->update([
                    'amount_spent' => $spent,
                    'amount_diff' => $diff,
                    'receipts_data' => $existingReceipts,
                    'status' => 'settled',
                    'settled_at' => Carbon::parse($settleDate . ' ' . now()->toTimeString()),
                    'notes' => $combinedNotes,
                ]);

                // Auto-sync ke Buku Kas Umum jika ada selisih uang pengembalian atau penambahan dana
                $settleProof = !empty($existingReceipts) && !empty($existingReceipts[0]['base64_image']) ? $existingReceipts[0]['base64_image'] : null;

                if ($diff < 0) {
                    $existingReturnTrx = CashTransaction::where('reference_type', 'reimbursement')
                        ->where('reference_id', $reimbursement->id)
                        ->where('type', 'income')
                        ->where('category', 'cash_advance_return')
                        ->first();

                    if ($existingReturnTrx) {
                        $existingReturnTrx->update([
                            'transaction_date' => $settleDate,
                            'amount' => abs($diff),
                            'payment_method' => $settlePaymentMethod,
                            'proof_file' => $settleProof ?? $existingReturnTrx->proof_file,
                            'notes' => "Realisasi SPJ: {$reimbursement->title}. Sisa uang muka dinas dikembalikan ke kasir.",
                        ]);
                    } else {
                        CashTransaction::create([
                            'transaction_number' => CashTransaction::generateNumber('income'),
                            'transaction_date' => $settleDate,
                            'type' => 'income',
                            'category' => 'cash_advance_return',
                            'title' => "Pengembalian Sisa Kasbon [{$reimbursement->reimbursement_no}] - {$reimbursement->employee_name}",
                            'amount' => abs($diff),
                            'payment_method' => $settlePaymentMethod,
                            'reference_type' => 'reimbursement',
                            'reference_id' => $reimbursement->id,
                            'proof_file' => $settleProof,
                            'notes' => "Realisasi SPJ: {$reimbursement->title}. Sisa uang muka dinas dikembalikan ke kasir.",
                            'recorded_by' => auth()->user()->name ?? 'Bendahara Keuangan',
                        ]);
                    }
                } elseif ($diff > 0) {
                    CashTransaction::create([
                        'transaction_number' => CashTransaction::generateNumber('expense'),
                        'transaction_date' => $settleDate,
                        'type' => 'expense',
                        'category' => 'cash_advance',
                        'title' => "Penggantian Kekurangan Kasbon [{$reimbursement->reimbursement_no}] - {$reimbursement->employee_name}",
                        'amount' => $diff,
                        'payment_method' => $settlePaymentMethod,
                        'reference_type' => 'reimbursement',
                        'reference_id' => $reimbursement->id,
                        'proof_file' => $settleProof,
                        'notes' => "Realisasi SPJ: {$reimbursement->title}. Pengeluaran aktual melebihi uang muka awal.",
                        'recorded_by' => auth()->user()->name ?? 'Bendahara Keuangan',
                    ]);
                }

                $diffLabel = '';
                if ($diff > 0) {
                    $diffLabel = " Lembaga kurang bayar Rp " . number_format($diff, 0, ',', '.') . " (telah dicatat di Buku Kas Keluar).";
                } elseif ($diff < 0) {
                    $diffLabel = " Karyawan lebih bayar Rp " . number_format(abs($diff), 0, ',', '.') . " (sisa uang telah dicatat di Buku Kas Masuk).";
                } else {
                    $diffLabel = " Realisasi pengeluaran pas sesuai uang muka.";
                }

                $msg = "Kasbon {$reimbursement->reimbursement_no} berhasil diselesaikan (Settled).{$diffLabel}";
                break;

            case 'reject':
                // Cek apakah ada transaksi kas terkait dalam periode Tutup Buku
                $lockDate = SiteSetting::get('financial_lock_until');
                $hasLockedCash = false;
                if ($lockDate) {
                    $hasLockedCash = $reimbursement->cashTransactions()
                        ->where('transaction_date', '<=', $lockDate)
                        ->exists();
                }

                if ($hasLockedCash) {
                    return back()->with('error', "Gagal menolak: Pengajuan {$reimbursement->reimbursement_no} memiliki transaksi kas dalam periode yang telah Tutup Buku.");
                }

                // Bersihkan transaksi kas yang sempat tercatat jika sebelumnya pernah di-pay
                $reimbursement->cashTransactions()->delete();

                $reimbursement->update([
                    'status' => 'rejected',
                    'notes' => $reimbursement->notes . "\n[Ditolak]: " . $request->input('reason', 'Tidak memenuhi syarat kelengkapan.'),
                ]);
                $msg = "Pengajuan {$reimbursement->reimbursement_no} ditolak.";
                break;

            default:
                return back()->with('error', 'Aksi status tidak valid.');
        }

        // Otomatis kirim notifikasi WhatsApp via Fonnte jika diaktifkan
        $waSentNote = '';
        if ($request->input('notify_wa', '1') !== '0') {
            $waRes = $this->sendStatusWhatsAppNotification($reimbursement, $action, [
                'notes' => match($action) {
                    'reject' => $request->input('reason'),
                    'settle' => $request->input('settlement_notes'),
                    default => null,
                }
            ]);
            if (!empty($waRes['success'])) {
                $waSentNote = ' • Notifikasi WhatsApp terkirim ke pemohon.';
            }
        }

        return back()->with('success', $msg . $waSentNote);
    }

    /**
     * Kirim Notifikasi Manual WhatsApp via Fonnte Gateway ke Pemohon
     */
    public function sendWaNotification(Request $request, $id)
    {
        $reimbursement = Reimbursement::findOrFail($id);
        $targetPhone = $request->input('phone');
        $customNotes = $request->input('custom_notes');

        $result = $this->sendStatusWhatsAppNotification($reimbursement, 'manual_reminder', [
            'target_phone' => $targetPhone,
            'notes' => $customNotes
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($result);
        }

        if (!empty($result['success'])) {
            return back()->with('success', "Notifikasi WhatsApp untuk {$reimbursement->reimbursement_no} berhasil dikirim.");
        } elseif (!empty($result['manual_url'])) {
            return redirect()->away($result['manual_url']);
        }

        return back()->with('error', $result['message'] ?? 'Gagal mengirim notifikasi WhatsApp.');
    }

    /**
     * Kirim Notifikasi WhatsApp via Fonnte Gateway untuk Status / Pengajuan Reimbursement
     */
    public function sendStatusWhatsAppNotification(Reimbursement $reimbursement, string $event, array $extra = []): array
    {
        $phone = null;
        $recipientName = $reimbursement->employee_name;

        if ($reimbursement->teacher_id) {
            $teacher = Teacher::find($reimbursement->teacher_id);
            if ($teacher && !empty($teacher->phone)) {
                $phone = $teacher->phone;
                $recipientName = $teacher->name;
            }
        }

        if (empty($phone) && !empty($extra['target_phone'])) {
            $phone = $extra['target_phone'];
        }

        if (empty($phone)) {
            return [
                'success' => false, 
                'message' => 'Nomor WhatsApp pemohon tidak ditemukan. Pastikan data karyawan memiliki nomor telepon.'
            ];
        }

        $typeLabel = $reimbursement->type === 'cash_advance' ? 'Kasbon Dinas (Uang Muka)' : 'Klaim Reimbursement';
        $nominal = number_format($reimbursement->amount_approved > 0 ? $reimbursement->amount_approved : $reimbursement->amount_requested, 0, ',', '.');
        $statusText = match($reimbursement->status) {
            'submitted' => 'Menunggu Verifikasi Bendahara ⏳',
            'approved' => 'Telah Disetujui (Approved) ✅',
            'paid' => 'Dana Telah Dicairkan / Dibayar 💰',
            'settled' => 'Pertanggungjawaban Selesai (Settled SPJ) 📜',
            'rejected' => 'Ditolak ❌',
            default => ucfirst($reimbursement->status),
        };

        $waMessage = "Konnichiwa, Bapak/Ibu *{$recipientName}* 🌸\n\n";
        $waMessage .= "Berikut adalah pembaruan status pengajuan dana operasional di *LPK Sahabat Jepang Indonesia*:\n\n";
        $waMessage .= "📄 *No. Dokumen*: `{$reimbursement->reimbursement_no}`\n";
        $waMessage .= "🏷️ *Tipe*: {$typeLabel}\n";
        $waMessage .= "📌 *Perihal*: {$reimbursement->title}\n";
        $waMessage .= "💵 *Nominal*: Rp {$nominal}\n";
        $waMessage .= "🔄 *Status Terkini*: *{$statusText}*\n";

        if (!empty($extra['notes'])) {
            $waMessage .= "📝 *Catatan*: {$extra['notes']}\n";
        }

        if ($reimbursement->status === 'paid' && $reimbursement->type === 'cash_advance') {
            $waMessage .= "\n⚠️ *Penting*: Harap simpan seluruh bukti/nota perjalanan dinas dan serahkan formulir SPJ paling lambat 3 hari setelah dinas selesai.\n";
        } elseif ($reimbursement->status === 'settled') {
            $diff = (float) $reimbursement->amount_diff;
            if ($diff > 0) {
                $waMessage .= "\nℹ️ Lembaga masih perlu mengganti kekurangan biaya sebesar Rp " . number_format($diff, 0, ',', '.') . ".\n";
            } elseif ($diff < 0) {
                $waMessage .= "\nℹ️ Terdapat sisa dana yang perlu dikembalikan ke kasir sebesar Rp " . number_format(abs($diff), 0, ',', '.') . ".\n";
            }
        }

        $waMessage .= "\n_Pesan otomatis dikirim oleh Sistem Keuangan LPK Sahabat Jepang Indonesia._";

        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        if (FonnteService::isConfigured()) {
            return FonnteService::send($cleanPhone, $waMessage, [
                'type' => 'reimbursement_status',
                'reimbursement_no' => $reimbursement->reimbursement_no,
                'status' => $reimbursement->status,
            ]);
        }

        return [
            'success' => false,
            'manual_url' => 'https://wa.me/' . $cleanPhone . '?text=' . urlencode($waMessage),
            'message' => 'Fonnte belum diaktifkan, gunakan tautan WhatsApp manual.'
        ];
    }

    /**
     * Hapus Dokumen Reimbursement
     */
    public function destroy($id)
    {
        $reimbursement = Reimbursement::findOrFail($id);
        $no = $reimbursement->reimbursement_no;

        // Cek apakah ada transaksi kas terkait dalam periode Tutup Buku
        $lockDate = SiteSetting::get('financial_lock_until');
        if ($lockDate) {
            $hasLockedCash = $reimbursement->cashTransactions()
                ->where('transaction_date', '<=', $lockDate)
                ->exists();

            if ($hasLockedCash) {
                return back()->with('error', "Gagal menghapus: Pengajuan {$no} memiliki transaksi di Buku Kas yang berada dalam periode Tutup Buku (s/d " . Carbon::parse($lockDate)->format('d/m/Y') . "). Buka kunci tutup buku terlebih dahulu jika ingin menghapus transaksi ini.");
            }
        }

        // Hapus transaksi kas terkait di Buku Kas Umum agar sinkron & tidak ada data hantu
        $reimbursement->cashTransactions()->delete();

        $reimbursement->delete();

        return redirect()->route('admin.reimbursements.index')
            ->with('success', "Dokumen {$no} beserta catatan pembukuannya di Buku Kas Umum & Jurnal berhasil dihapus.");
    }

    /**
     * Cetak Lembar SPJ & Rincian Nota Fisik Resmi (Printer Friendly A4)
     */
    public function print($id)
    {
        $reimbursement = Reimbursement::with(['employee', 'digitalArchives'])->findOrFail($id);
        return view('admin.reimbursements.print', compact('reimbursement'));
    }

    /**
     * Helper Query Filter Terpadu (Tipe, Status, Karyawan, Kategori, Search, Periode Cepat & Rentang Tanggal)
     */
    protected function filterQuery(Request $request)
    {
        $query = Reimbursement::with(['employee', 'cashTransactions'])->latest();

        // 1. Filter Tipe (Reimburse vs Kasbon)
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // 2. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // 3. Filter Pegawai
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->input('teacher_id'));
        }

        // 4. Filter Kategori
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // 5. Pencarian Teks
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reimbursement_no', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('employee_name', 'like', "%{$search}%")
                  ->orWhere('destination', 'like', "%{$search}%");
            });
        }

        // 6. Filter Periode Cepat (Harian, Mingguan, Bulanan)
        if ($request->filled('period')) {
            $period = $request->input('period');
            if ($period === 'today') {
                $today = now()->toDateString();
                $query->where(function ($q) use ($today) {
                    $q->whereDate('start_date', $today)
                      ->orWhere(function ($sub) use ($today) {
                          $sub->whereNull('start_date')->whereDate('created_at', $today);
                      });
                });
            } elseif ($period === 'weekly') {
                $startOfWeek = now()->startOfWeek()->startOfDay();
                $endOfWeek = now()->endOfWeek()->endOfDay();
                $query->where(function ($q) use ($startOfWeek, $endOfWeek) {
                    $q->where(function ($sq) use ($startOfWeek, $endOfWeek) {
                        $sq->whereDate('start_date', '>=', $startOfWeek->toDateString())
                           ->whereDate('start_date', '<=', $endOfWeek->toDateString());
                    })->orWhere(function ($sub) use ($startOfWeek, $endOfWeek) {
                        $sub->whereNull('start_date')
                            ->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                    });
                });
            } elseif ($period === 'monthly') {
                $month = now()->month;
                $year = now()->year;
                $query->where(function ($q) use ($month, $year) {
                    $q->where(function ($sq) use ($month, $year) {
                        $sq->whereMonth('start_date', $month)->whereYear('start_date', $year);
                    })->orWhere(function ($sq) use ($month, $year) {
                        $sq->whereNull('start_date')->whereMonth('created_at', $month)->whereYear('created_at', $year);
                    });
                });
            }
        }

        // 7. Filter Rentang Tanggal Spesifik (Custom Date Range)
        if ($request->filled('date_from')) {
            $from = $request->input('date_from');
            $query->where(function ($q) use ($from) {
                $q->whereDate('start_date', '>=', $from)
                  ->orWhere(function ($sub) use ($from) {
                      $sub->whereNull('start_date')->whereDate('created_at', '>=', $from);
                  });
            });
        }
        if ($request->filled('date_to')) {
            $to = $request->input('date_to');
            $query->where(function ($q) use ($to) {
                $q->whereDate('start_date', '<=', $to)
                  ->orWhere(function ($sub) use ($to) {
                      $sub->whereNull('start_date')->whereDate('created_at', '<=', $to);
                  });
            });
        }

        return $query;
    }

    /**
     * Export PDF Rekapitulasi Keuangan Dinas
     */
    public function exportPdf(Request $request)
    {
        $reimbursements = $this->filterQuery($request)->get();

        return view('admin.reimbursements.export_pdf', compact('reimbursements'));
    }

    /**
     * Export Seluruh Data Reimburse & Kasbon ke Format CSV/Excel
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $reimbursements = $this->filterQuery($request)->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="reimbursements_' . date('Ymd_His') . '.csv"',
        ];

        return response()->stream(function () use ($reimbursements) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM untuk Microsoft Excel

            fputcsv($out, [
                'No',
                'Nomor Dokumen',
                'Tipe Transaksi',
                'Kategori',
                'Nama Karyawan',
                'Keperluan Dinas',
                'Kota / Tujuan',
                'Tgl Mulai',
                'Tgl Selesai',
                'Nominal Diajukan (Rp)',
                'Nominal Disetujui (Rp)',
                'Realisasi SPJ (Rp)',
                'Selisih (Rp)',
                'Status',
                'Tgl Pengajuan',
                'Catatan',
            ]);

            foreach ($reimbursements as $idx => $r) {
                fputcsv($out, [
                    $idx + 1,
                    $r->reimbursement_no,
                    $r->type === 'cash_advance' ? 'Uang Muka Dinas (Kasbon)' : 'Reimburse (Klaim Nota)',
                    $r->category_label,
                    $r->employee_name,
                    $r->title,
                    $r->destination ?? '-',
                    $r->start_date ? $r->start_date->format('Y-m-d') : '-',
                    $r->end_date ? $r->end_date->format('Y-m-d') : '-',
                    $r->amount_requested,
                    $r->amount_approved,
                    $r->amount_spent,
                    $r->amount_diff,
                    $r->status_badge['label'],
                    $r->created_at->format('Y-m-d H:i'),
                    $r->notes ?? '-',
                ]);
            }

            fclose($out);
        }, 200, $headers);
    }

    /**
     * Download Template CSV Siap Isi
     */
    public function exportTemplate(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_reimburse_sji.csv"',
        ];

        return response()->stream(function () {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header kolom
            fputcsv($out, [
                'tipe',
                'kategori',
                'nama_karyawan',
                'keperluan_dinas',
                'kota_tujuan',
                'tanggal_mulai',
                'tanggal_selesai',
                'nominal_diajukan',
                'catatan',
            ]);

            // Baris contoh 1 (Reimburse)
            fputcsv($out, [
                'reimbursement',
                'transportasi',
                'Budi Santoso, S.Pd',
                'Kunjungan Koordinasi Dinas & BKK SMK',
                'Bandung & Cirebon',
                date('Y-m-d'),
                date('Y-m-d', strtotime('+2 days')),
                '1250000',
                'Tiket kereta PP dan transport lokal grab',
            ]);

            // Baris contoh 2 (Uang Muka Dinas / Kasbon MoU)
            fputcsv($out, [
                'cash_advance',
                'mou_perjalanan_dinas',
                'Dr. Ir. Hendra Kusuma',
                'Penandatanganan Naskah MoU Poltekkes Kemenkes',
                'Semarang & Solo',
                date('Y-m-d', strtotime('+3 days')),
                date('Y-m-d', strtotime('+5 days')),
                '3500000',
                'Uang saku, bensin dinas, dan penginapan hotel 2 malam',
            ]);

            fclose($out);
        }, 200, $headers);
    }

    /**
     * Import Data Reimburse / Kasbon dari File CSV/Excel
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        // Lewati UTF-8 BOM jika ada
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        // Ambil header baris pertama
        $header = fgetcsv($handle, 2000, ',');
        if (!$header || count($header) < 5) {
            fclose($handle);
            return back()->with('error', 'Format CSV tidak valid. Gunakan template yang telah disediakan.');
        }

        $imported = 0;
        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle, 2000, ',')) !== false) {
                if (empty(array_filter($row))) continue;

                $type = strtolower(trim($row[0] ?? 'reimbursement'));
                if (!in_array($type, ['reimbursement', 'cash_advance'])) {
                    $type = 'reimbursement';
                }

                $category = strtolower(trim($row[1] ?? 'mou_perjalanan_dinas'));
                $employeeName = trim($row[2] ?? 'Karyawan LPK SJI');
                $title = trim($row[3] ?? 'Perjalanan Dinas Luar Kota');
                $destination = trim($row[4] ?? null);
                $startDate = !empty($row[5]) ? date('Y-m-d', strtotime($row[5])) : now()->toDateString();
                $endDate = !empty($row[6]) ? date('Y-m-d', strtotime($row[6])) : null;
                $amount = (float) preg_replace('/[^0-9.]/', '', $row[7] ?? 0);
                $notes = trim($row[8] ?? null);

                // Cocokkan ID guru/karyawan jika ada kecocokan nama
                $teacher = Teacher::where('name', 'like', "%{$employeeName}%")->first();

                Reimbursement::create([
                    'reimbursement_no' => Reimbursement::generateNumber($type),
                    'teacher_id' => $teacher?->id,
                    'employee_name' => $employeeName,
                    'type' => $type,
                    'category' => $category,
                    'title' => $title,
                    'destination' => $destination,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'amount_requested' => $amount,
                    'amount_approved' => 0,
                    'amount_spent' => 0,
                    'amount_diff' => 0,
                    'status' => 'submitted',
                    'notes' => $notes ? $notes . ' [Import CSV]' : '[Import CSV]',
                    'receipts_data' => [],
                    'created_by' => auth()->user()->name ?? 'Admin Import',
                ]);

                $imported++;
            }

            DB::commit();
            fclose($handle);

            return redirect()->route('admin.reimbursements.index')
                ->with('success', "Berhasil mengimpor {$imported} data transaksi reimburse/kasbon.");
        } catch (\Throwable $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('error', 'Gagal memproses file CSV: ' . $e->getMessage());
        }
    }

    /**
     * Download Berkas Nota Fisik Base64 Pengajuan Reimburse / SPJ
     */
    public function downloadReceipt($id, $index)
    {
        $reimbursement = Reimbursement::findOrFail($id);
        $receipts = $reimbursement->receipts_data ?? [];
        if (!isset($receipts[$index])) {
            return back()->with('error', 'Nota fisik yang diminta tidak ditemukan.');
        }

        $rc = $receipts[$index];
        $base64 = $rc['base64_image'] ?? '';
        if (empty($base64)) {
            return back()->with('error', 'Berkas nota fisik kosong.');
        }

        if (str_contains($base64, ';base64,')) {
            [$header, $data] = explode(';base64,', $base64);
            $mime = str_replace('data:', '', $header);
        } else {
            $data = $base64;
            $mime = $rc['file_type'] ?? 'image/jpeg';
        }

        $content = base64_decode($data);
        $ext = str_contains($mime, 'pdf') ? 'pdf' : (str_contains($mime, 'png') ? 'png' : 'jpg');
        $safeTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', $rc['title'] ?? 'Nota');
        $safeDoc = str_replace('/', '-', $reimbursement->reimbursement_no);
        $filename = "{$safeDoc}_{$safeTitle}.{$ext}";

        return response($content)
            ->header('Content-Type', $mime)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
