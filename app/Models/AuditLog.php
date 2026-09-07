<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_role',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Catat log aktivitas sistem secara otomatis
     */
    public static function record(string $action, string $description, array $properties = [], ?User $user = null): self
    {
        /** @var User|null $actor */
        $actor = $user ?? Auth::user();

        return self::create([
            'user_id' => $actor?->id,
            'user_name' => $actor?->name ?? 'Tamu / Sistem',
            'user_role' => $actor?->role ?? 'guest',
            'action' => $action,
            'description' => $description,
            'ip_address' => Request::ip() ?? '127.0.0.1',
            'user_agent' => Request::userAgent() ?? 'CLI / System',
            'properties' => $properties,
        ]);
    }

    /**
     * Mengembalikan badge class Tailwind berdasarkan kategori aksi
     */
    public function getActionBadgeClassAttribute(): string
    {
        if (str_starts_with($this->action, 'auth.failed')) {
            return 'bg-red-100 text-red-800 border-red-200';
        }
        if (str_starts_with($this->action, 'auth.')) {
            return 'bg-blue-100 text-blue-800 border-blue-200';
        }
        if (str_starts_with($this->action, 'user.')) {
            return 'bg-purple-100 text-purple-800 border-purple-200';
        }
        if (str_starts_with($this->action, 'profile.')) {
            return 'bg-indigo-100 text-indigo-800 border-indigo-200';
        }
        if (str_starts_with($this->action, 'cash.')) {
            return 'bg-emerald-100 text-emerald-800 border-emerald-200';
        }
        if (str_starts_with($this->action, 'reimbursement.')) {
            return 'bg-amber-100 text-amber-800 border-amber-200';
        }

        return 'bg-slate-100 text-slate-700 border-slate-200';
    }

    /**
     * Label aksi yang ramah pengguna
     */
    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'auth.login' => 'Login Berhasil',
            'auth.failed' => 'Login Gagal',
            'auth.logout' => 'Logout',
            'user.created' => 'Tambah Pengguna',
            'user.updated' => 'Ubah Pengguna',
            'user.toggle_status' => 'Toggle Status Akun',
            'user.deleted' => 'Hapus Pengguna',
            'profile.updated' => 'Perbarui Profil',
            'profile.password_changed' => 'Ganti Kata Sandi',
            'cash.created' => 'Transaksi Kas',
            'reimbursement.status_change' => 'Status Reimburse',
            default => str_replace(['.', '_'], ' ', ucfirst($this->action)),
        };
    }
}
