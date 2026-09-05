<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'institution_name',
        'phone',
        'email',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
        'reward_per_lead',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'reward_per_lead' => 'decimal:2',
    ];

    /**
     * Leads yang mendaftar melalui kode referral mitra ini
     */
    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class, 'affiliate_code', 'code');
    }

    /**
     * Siswa yang terdaftar melalui kode referral mitra ini
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'affiliate_code', 'code');
    }

    /**
     * Total estimasi komisi yang diperoleh
     */
    public function getTotalRewardEarnedAttribute(): float
    {
        $enrolledCount = $this->students()->count();
        return (float) ($enrolledCount * $this->reward_per_lead);
    }

    /**
     * Riwayat Transaksi Pengeluaran Kas untuk Pencairan Komisi Mitra
     */
    public function cashTransactions(): HasMany
    {
        return $this->hasMany(CashTransaction::class, 'reference_id')
            ->where('reference_type', 'affiliate');
    }

    /**
     * Total Komisi yang Telah Dicairkan / Dibayarkan ke Mitra
     */
    public function getTotalPaidCommissionAttribute(): float
    {
        return (float) CashTransaction::where('reference_type', 'affiliate')
            ->where('reference_id', $this->id)
            ->where('type', 'expense')
            ->sum('amount');
    }

    /**
     * Sisa Komisi yang Belum Dicairkan (Pending)
     */
    public function getPendingCommissionAttribute(): float
    {
        return max(0, $this->total_reward_earned - $this->total_paid_commission);
    }

    /**
     * Label Kategori Kemitraan SMK / BKK
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'smk_bkk' => 'SMK & Bursa Kerja Khusus (BKK)',
            'sekolah' => 'SMK / Sekolah Menengah',
            'kampus_poltekkes' => 'Perguruan Tinggi / Poltekkes',
            'guru_bk' => 'Guru BK (Bimbingan Konseling)',
            'alumni' => 'Ikatan Alumni Jepang',
            default => 'Komunitas & Umum',
        };
    }

    /**
     * Badge visual warna kategori
     */
    public function getTypeBadgeAttribute(): array
    {
        return match($this->type) {
            'smk_bkk' => ['bg' => 'bg-indigo-100 text-indigo-800 border-indigo-200', 'icon' => 'school'],
            'sekolah' => ['bg' => 'bg-blue-100 text-blue-800 border-blue-200', 'icon' => 'building-2'],
            'kampus_poltekkes' => ['bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'icon' => 'graduation-cap'],
            'guru_bk' => ['bg' => 'bg-purple-100 text-purple-800 border-purple-200', 'icon' => 'user-check'],
            'alumni' => ['bg' => 'bg-amber-100 text-amber-800 border-amber-200', 'icon' => 'award'],
            default => ['bg' => 'bg-slate-100 text-slate-800 border-slate-200', 'icon' => 'users'],
        };
    }
}
