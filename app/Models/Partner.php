<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'prefecture',
        'category',
        'logo',
        'order',
    ];

    /**
     * Auto clear synced stats cache on partner change
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
}
