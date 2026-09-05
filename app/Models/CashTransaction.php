<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'transaction_date',
        'type',
        'category',
        'title',
        'amount',
        'payment_method',
        'reference_type',
        'reference_id',
        'proof_file',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public const INCOME_CATEGORIES = [
        'tuition_student' => 'Biaya Pelatihan / Cicilan Siswa',
        'registration_fee' => 'Uang Pendaftaran & Formulir',
        'talangan_in' => 'Penerimaan Dana Talangan / Bank',
        'subsidy_government' => 'Subsidi Beasiswa Kemenaker/Kemenkes',
        'affiliate_fee_in' => 'Fee Kemitraan Industri / Kaisha',
        'cash_advance_return' => 'Pengembalian Sisa Kasbon Dinas',
        'other_income' => 'Pemasukan Lain-lain',
    ];

    public const EXPENSE_CATEGORIES = [
        'teacher_salary' => 'Gaji / Honorarium Sensei & Karyawan',
        'building_rent' => 'Sewa Gedung Kampus & Asrama',
        'utilities' => 'Utilitas (Listrik, Air PDAM, Wi-Fi)',
        'marketing_ads' => 'Iklan Meta/Google & Brosur Promosi',
        'student_equipment' => 'Buku Modul, Seragam & ATK Kelas',
        'reimbursement' => 'Klaim Reimbursement Operasional',
        'cash_advance' => 'Uang Muka Perjalanan Dinas',
        'affiliate_commission' => 'Komisi Kemitraan SMK & BKK',
        'tax_legal' => 'Pajak, Perizinan SO & Akreditasi',
        'other_expense' => 'Beban Operasional Lainnya',
    ];

    public const PAYMENT_METHODS = [
        'cash_kasir' => 'Kas Tunai (Kasir LPK)',
        'bank_mandiri' => 'Transfer Bank Mandiri',
        'bank_bca' => 'Transfer Bank BCA',
        'bank_bni' => 'Transfer Bank BNI',
        'qris_transfer' => 'QRIS / Digital Transfer',
    ];

    /**
     * Generate Nomor Bukti Kas Otomatis (BKM untuk Masuk, BKK untuk Keluar)
     */
    public static function generateNumber(string $type): string
    {
        $prefix = ($type === 'income') ? 'BKM' : 'BKK';
        $period = date('Ym');
        $lastTrx = self::where('transaction_number', 'like', "{$prefix}-{$period}-%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastTrx && preg_match('/-(\d+)$/', $lastTrx->transaction_number, $matches)) {
            $seq = (int) $matches[1] + 1;
        } else {
            $seq = 1;
        }

        return sprintf("%s-%s-%04d", $prefix, $period, $seq);
    }

    /**
     * Label Kategori Transaksi
     */
    public function getCategoryLabelAttribute(): string
    {
        if ($this->type === 'income') {
            return self::INCOME_CATEGORIES[$this->category] ?? ucfirst(str_replace('_', ' ', $this->category));
        }
        return self::EXPENSE_CATEGORIES[$this->category] ?? ucfirst(str_replace('_', ' ', $this->category));
    }

    /**
     * Badge Kategori Transaksi
     */
    public function getCategoryBadgeAttribute(): array
    {
        return match($this->category) {
            'tuition_student' => ['bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'icon' => 'graduation-cap'],
            'registration_fee' => ['bg' => 'bg-blue-100 text-blue-800 border-blue-200', 'icon' => 'user-plus'],
            'talangan_in' => ['bg' => 'bg-cyan-100 text-cyan-800 border-cyan-200', 'icon' => 'landmark'],
            'subsidy_government' => ['bg' => 'bg-indigo-100 text-indigo-800 border-indigo-200', 'icon' => 'award'],
            'teacher_salary' => ['bg' => 'bg-amber-100 text-amber-800 border-amber-200', 'icon' => 'user-check'],
            'building_rent' => ['bg' => 'bg-orange-100 text-orange-800 border-orange-200', 'icon' => 'home'],
            'utilities' => ['bg' => 'bg-yellow-100 text-yellow-800 border-yellow-200', 'icon' => 'zap'],
            'marketing_ads' => ['bg' => 'bg-pink-100 text-pink-800 border-pink-200', 'icon' => 'megaphone'],
            'student_equipment' => ['bg' => 'bg-teal-100 text-teal-800 border-teal-200', 'icon' => 'book-open'],
            'reimbursement', 'cash_advance' => ['bg' => 'bg-rose-100 text-rose-800 border-rose-200', 'icon' => 'receipt'],
            'affiliate_commission' => ['bg' => 'bg-purple-100 text-purple-800 border-purple-200', 'icon' => 'gift'],
            default => ['bg' => 'bg-slate-100 text-slate-800 border-slate-200', 'icon' => 'file-text'],
        };
    }

    /**
     * Label Metode Pembayaran
     */
    public function getPaymentMethodLabelAttribute(): string
    {
        return self::PAYMENT_METHODS[$this->payment_method] ?? ucfirst(str_replace('_', ' ', $this->payment_method));
    }

    /**
     * Format Rupiah Nominal
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->amount, 0, ',', '.');
    }

    /**
     * Relasi ke Siswa jika transaksi terkait siswa
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'reference_id');
    }

    /**
     * Relasi ke Reimbursement jika transaksi terkait klaim dinas
     */
    public function reimbursement(): BelongsTo
    {
        return $this->belongsTo(Reimbursement::class, 'reference_id');
    }

    /**
     * Relasi ke Mitra Afiliasi jika transaksi terkait pencairan komisi BKK/SMK
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class, 'reference_id');
    }

    /**
     * Relasi ke Guru / Sensei / Karyawan jika transaksi terkait penggajian
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'reference_id');
    }
}

