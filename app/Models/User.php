<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'phone',
        'avatar',
        'is_active',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is Administrator (Super Admin)
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is Teacher / Sensei
     */
    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    /**
     * Check if user is Staff / Karyawan Operasional
     */
    public function isStaff(): bool
    {
        return in_array($this->role, ['staff', 'karyawan'], true);
    }

    /**
     * Check if user matches any given role(s)
     */
    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles, true);
        }
        return in_array($this->role, func_get_args(), true);
    }

    /**
     * Check if user can manage RBAC user accounts
     */
    public function canManageUsers(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Check if user can manage CMS web content & settings
     */
    public function canManageContent(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Check if user can manage Financial transactions & P&L
     */
    public function canManageFinance(): bool
    {
        return $this->isAdmin() || $this->isStaff();
    }

    /**
     * Check if user can view/manage academic student records
     */
    public function canManageAcademics(): bool
    {
        return $this->isAdmin() || $this->isTeacher() || $this->isStaff();
    }

    /**
     * Role Friendly Label
     */
    public function getRoleNameAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'teacher' => 'Pengajar / Sensei',
            'staff', 'karyawan' => 'Karyawan / Staf LPK',
            default => ucfirst($this->role ?? 'User'),
        };
    }

    /**
     * Role Badge Color & Tailwind Classes
     */
    public function getRoleBadgeClassAttribute(): string
    {
        return match($this->role) {
            'admin' => 'bg-red-50 text-japan-700 border-red-200',
            'teacher' => 'bg-blue-50 text-blue-700 border-blue-200',
            'staff', 'karyawan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
    }
}
