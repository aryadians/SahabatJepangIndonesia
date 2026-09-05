<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    /**
     * Otomatis invalidate cache saat ada perubahan data pengaturan
     */
    protected static function booted(): void
    {
        static::saved(function () {
            Cache::forget('site_settings_all');
        });

        static::deleted(function () {
            Cache::forget('site_settings_all');
        });
    }

    /**
     * Helper to get setting value by key with default
     */
    public static function get($key, $default = null)
    {
        $all = static::allCached();
        return $all[$key] ?? $default;
    }

    /**
     * Get all settings cached in memory
     */
    public static function allCached(): array
    {
        return Cache::remember('site_settings_all', 3600, function () {
            return static::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Helper to set setting value by key and invalidate cache
     */
    public static function set($key, $value, $group = 'general')
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
        Cache::forget('site_settings_all');
        return $setting;
    }
}
