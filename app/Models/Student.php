<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'name',
        'japanese_name',
        'nik',
        'phone',
        'email',
        'gender',
        'birth_place',
        'birth_date',
        'education',
        'address',
        'city',
        'emergency_contact_name',
        'emergency_contact_phone',
        'batch',
        'program',
        'registration_category',
        'sector',
        'entry_date',
        'departure_date',
        'destination_company',
        'destination_prefecture',
        'status',
        'japanese_level',
        'ssw_certificate',
        'passport_number',
        'passport_expiry',
        'total_cost',
        'paid_amount',
        'payment_scheme',
        'payment_status',
        'payment_notes',
        'mcu_date',
        'mcu_clinic',
        'mcu_result',
        'coe_number',
        'coe_date',
        'visa_number',
        'visa_expiry',
        'exam_score',
        'attendance_percentage',
        'discipline_grade',
        'photo',
        'document_ktp',
        'document_kk',
        'document_ijazah',
        'document_certificate',
        'document_ssw',
        'document_passport',
        'document_mcu',
        'document_coe_visa',
        'admin_notes',
        'affiliate_code',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'entry_date' => 'date',
        'departure_date' => 'date',
        'passport_expiry' => 'date',
        'mcu_date' => 'date',
        'coe_date' => 'date',
        'visa_expiry' => 'date',
        'total_cost' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'exam_score' => 'decimal:2',
    ];

    /**
     * Hitung Sisa Tanggungan / Biaya Belum Lunas
     */
    public function getRemainingBalanceAttribute(): float
    {
        return max(0, (float)$this->total_cost - (float)$this->paid_amount);
    }

    /**
     * Format Rupiah Total Biaya
     */
    public function getFormattedTotalCostAttribute(): string
    {
        return 'Rp ' . number_format((float)$this->total_cost, 0, ',', '.');
    }

    /**
     * Format Rupiah Sudah Dibayar
     */
    public function getFormattedPaidAmountAttribute(): string
    {
        return 'Rp ' . number_format((float)$this->paid_amount, 0, ',', '.');
    }

    /**
     * Format Rupiah Sisa Tanggungan
     */
    public function getFormattedRemainingBalanceAttribute(): string
    {
        return 'Rp ' . number_format($this->remaining_balance, 0, ',', '.');
    }

    /**
     * Persentase Pelunasan Biaya
     */
    public function getPaymentPercentageAttribute(): int
    {
        if ((float)$this->total_cost <= 0) return 100;
        return min(100, (int)round(((float)$this->paid_amount / (float)$this->total_cost) * 100));
    }

    /**
     * Menghitung Jumlah Berkas Dokumen yang Sudah Diunggah
     */
    public function getUploadedDocumentsCountAttribute(): int
    {
        $docs = [
            $this->document_ktp,
            $this->document_kk,
            $this->document_ijazah,
            $this->document_passport,
            $this->document_certificate,
            $this->document_ssw,
            $this->document_mcu,
            $this->document_coe_visa,
        ];

        return count(array_filter($docs, fn($doc) => !empty($doc)));
    }

    /**
     * Label Status MCU
     */
    public function getMcuLabelAttribute(): string
    {
        return match ($this->mcu_result) {
            'fit' => 'Fit / Layak Berangkat',
            'unfit' => 'Unfit / Tidak Lolos',
            'follow_up' => 'Perlu Tindak Lanjut',
            'pending' => 'Menunggu Hasil',
            default => 'Belum MCU',
        };
    }

    public function interviews()
    {
        return $this->belongsToMany(JobInterview::class, 'interview_candidates')
                    ->withPivot(['id', 'result', 'interview_score', 'interviewer_feedback'])
                    ->withTimestamps();
    }

    /**
     * Label Kategori / Jalur Pendaftaran Siswa
     */
    public function getRegistrationCategoryLabelAttribute(): string
    {
        return match($this->registration_category) {
            'smile_project', 'kemenkes_kaigo' => 'SMILE Project (Kemenkes & Poltekkes)',
            'smk_go_japan' => 'Program Pemerintah: SMK Go Japan',
            'bkk_smk' => 'Kemitraan BKK SMK',
            'poltekkes_kampus' => 'Kemitraan Poltekkes & STIKes',
            default => 'Jalur Reguler / Umum',
        };
    }

    /**
     * Badge Style Kategori Siswa
     */
    public function getRegistrationCategoryBadgeAttribute(): array
    {
        return match($this->registration_category) {
            'smile_project', 'kemenkes_kaigo' => [
                'bg' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                'label' => 'SMILE Project (Kemenkes)',
                'icon' => 'award',
            ],
            'smk_go_japan' => [
                'bg' => 'bg-blue-100 text-blue-800 border-blue-300',
                'label' => 'SMK Go Japan',
                'icon' => 'flag',
            ],
            'bkk_smk' => [
                'bg' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                'label' => 'Mitra BKK SMK',
                'icon' => 'handshake',
            ],
            'poltekkes_kampus' => [
                'bg' => 'bg-teal-100 text-teal-800 border-teal-300',
                'label' => 'Poltekkes / STIKes',
                'icon' => 'building-2',
            ],
            default => [
                'bg' => 'bg-slate-100 text-slate-700 border-slate-200',
                'label' => 'Reguler / Umum',
                'icon' => 'user',
            ],
        };
    }
}
