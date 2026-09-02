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
        'photo',
        'document_ktp',
        'document_certificate',
        'document_passport',
        'admin_notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'entry_date' => 'date',
        'departure_date' => 'date',
        'passport_expiry' => 'date',
        'total_cost' => 'decimal:2',
        'paid_amount' => 'decimal:2',
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
}
