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
}
