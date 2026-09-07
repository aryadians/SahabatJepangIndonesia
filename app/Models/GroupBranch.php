<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupBranch extends Model
{
    use HasFactory;

    protected $table = 'group_branches';

    protected $fillable = [
        'name',
        'japanese_name',
        'category_jp',
        'category_id',
        'phone',
        'secondary_phone',
        'address',
        'postal_code',
        'city',
        'province',
        'country',
        'logo_url',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Auto clear synced stats cache on change
     */
    protected static function booted(): void
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('sji_corporate_synced_stats');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('sji_corporate_synced_stats');
        });
    }

    /**
     * Scope for active branches
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for sorting
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Scope for Indonesia branches
     */
    public function scopeIndonesia($query)
    {
        return $query->where('country', 'ID');
    }

    /**
     * Scope for Japan offices
     */
    public function scopeJapan($query)
    {
        return $query->where('country', 'JP');
    }

    /**
     * Helper to get sanitized WhatsApp phone number
     */
    public function getCleanWhatsappAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', (string) $this->phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        return $phone;
    }
}
