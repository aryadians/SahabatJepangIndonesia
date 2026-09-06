<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reimbursement extends Model
{
    use HasFactory;

    protected $fillable = [
        'reimbursement_no',
        'teacher_id',
        'employee_name',
        'type',
        'category',
        'title',
        'destination',
        'start_date',
        'end_date',
        'amount_requested',
        'amount_approved',
        'amount_spent',
        'amount_diff',
        'status',
        'notes',
        'receipts_data',
        'paid_at',
        'settled_at',
        'created_by',
        'approved_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'paid_at' => 'datetime',
        'settled_at' => 'datetime',
        'amount_requested' => 'float',
        'amount_approved' => 'float',
        'amount_spent' => 'float',
        'amount_diff' => 'float',
        'receipts_data' => 'array',
    ];

    /**
     * Karyawan / Pemohon
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    /**
     * Relasi ke Arsip Digital
     */
    public function digitalArchives(): HasMany
    {
        return $this->hasMany(DigitalArchive::class, 'reimbursement_id');
    }

    /**
     * Transaksi Terkait di Buku Kas Umum (BKM / BKK) & Jurnal Keuangan
     */
    public function cashTransactions(): HasMany
    {
        return $this->hasMany(CashTransaction::class, 'reference_id')->where('reference_type', 'reimbursement');
    }

    /**
     * Transaksi Kas Keluar Terakhir (Pencairan Dana)
     */
    public function latestCashTransaction()
    {
        return $this->cashTransactions()->latest('id')->first();
    }

    /**
     * Hitung selisih Uang Muka vs Realisasi
     * Positif (> 0) = Lembaga Kurang Bayar (Bendahara harus mengganti ke karyawan)
     * Negatif (< 0) = Karyawan Lebih Bayar (Karyawan harus mengembalikan sisa ke kasir)
     * Nol (= 0) = Pas / Sesuai
     */
    public function calculateDifference(): float
    {
        if ($this->type === 'cash_advance') {
            return (float) ($this->amount_spent - $this->amount_approved);
        }
        return 0;
    }

    /**
     * Helper Badge Status Dokumen
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'approved' => [
                'label' => 'Disetujui',
                'bg' => 'bg-blue-50 text-blue-700 border-blue-200',
                'icon' => 'check-circle-2',
            ],
            'paid' => [
                'label' => $this->type === 'cash_advance' ? 'Dana Dicairkan' : 'Telah Diganti',
                'bg' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'icon' => 'banknote',
            ],
            'settled' => [
                'label' => 'Selesai (SPJ Valid)',
                'bg' => 'bg-teal-50 text-teal-800 border-teal-300 font-black',
                'icon' => 'award',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'bg' => 'bg-rose-50 text-rose-700 border-rose-200',
                'icon' => 'x-circle',
            ],
            default => [
                'label' => 'Menunggu Verifikasi',
                'bg' => 'bg-amber-50 text-amber-700 border-amber-200',
                'icon' => 'clock',
            ],
        };
    }

    /**
     * Helper Badge Tipe Transaksi
     */
    public function getTypeBadgeAttribute(): array
    {
        return match ($this->type) {
            'cash_advance' => [
                'label' => 'Uang Muka Dinas (Kasbon)',
                'short_label' => 'Kasbon Dinas',
                'bg' => 'bg-purple-100 text-purple-800 border-purple-200',
                'color' => 'text-purple-600',
            ],
            default => [
                'label' => 'Reimburse (Klaim Nota)',
                'short_label' => 'Reimburse',
                'bg' => 'bg-sky-100 text-sky-800 border-sky-200',
                'color' => 'text-sky-600',
            ],
        };
    }

    /**
     * Helper Label Kategori
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'mou_perjalanan_dinas' => 'Perjalanan Dinas MoU & Kemitraan',
            'transportasi' => 'Transportasi (Tiket / Bensin / Tol)',
            'akomodasi_hotel' => 'Akomodasi / Penginapan Hotel',
            'konsumsi_meeting' => 'Konsumsi & Jamuan Meeting',
            'operasional_kantor' => 'Operasional Kantor & Pelatihan',
            default => 'Keperluan Dinas Lainnya',
        };
    }

    /**
     * Generate Nomor Dokumen Otomatis
     */
    public static function generateNumber(string $type = 'reimbursement'): string
    {
        $prefix = $type === 'cash_advance' ? 'ADV-SJI' : 'RMB-SJI';
        $period = now()->format('Ym');
        $count = static::where('reimbursement_no', 'like', "{$prefix}/{$period}/%")->count() + 1;
        $serial = str_pad($count, 4, '0', STR_PAD_LEFT);
        return "{$prefix}/{$period}/{$serial}";
    }
}
