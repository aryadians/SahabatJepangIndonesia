<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'role',
        'name',
        'romaji_name',
        'position_title',
        'department',
        'phone',
        'email',
        'gender',
        'join_date',
        'jlpt_level',
        'japan_experience',
        'specialization',
        'employment_type',
        'status',
        'is_executive',
        'order',
        'photo',
        'document_certificate',
        'notes',
    ];

    protected $casts = [
        'join_date' => 'date',
        'is_executive' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope untuk jajaran eksekutif (CEO, Owner, Direktur)
     */
    public function scopeExecutives($query)
    {
        return $query->where('is_executive', true)
                     ->orWhereIn('role', ['ceo_owner', 'director'])
                     ->orderBy('order', 'asc')
                     ->orderBy('id', 'asc');
    }

    /**
     * Scope untuk pengajar / sensei
     */
    public function scopeSensei($query)
    {
        return $query->where('role', 'sensei');
    }

    /**
     * Relasi ke pengajuan Reimbursement / Kasbon
     */
    public function reimbursements(): HasMany
    {
        return $this->hasMany(Reimbursement::class, 'teacher_id');
    }

    /**
     * Riwayat Pembayaran Gaji / Honorarium dari Buku Kas Umum
     */
    public function salaries(): HasMany
    {
        return $this->hasMany(CashTransaction::class, 'reference_id')
            ->where('reference_type', 'teacher');
    }

    /**
     * Helper Badge Peran / Role
     */
    public function getRoleBadgeAttribute(): array
    {
        return match ($this->role) {
            'ceo_owner' => ['label' => 'Owner / CEO', 'bg' => 'bg-amber-100 text-amber-800 border-amber-300'],
            'director' => ['label' => 'Direktur', 'bg' => 'bg-purple-100 text-purple-800 border-purple-300'],
            'finance' => ['label' => 'Bendahara & Keuangan', 'bg' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
            'operations' => ['label' => 'Operasional', 'bg' => 'bg-blue-100 text-blue-800 border-blue-300'],
            'staff' => ['label' => 'Staff Kantor', 'bg' => 'bg-slate-100 text-slate-800 border-slate-300'],
            default => ['label' => 'Sensei / Pengajar', 'bg' => 'bg-red-100 text-japan-700 border-red-200'],
        };
    }
}
