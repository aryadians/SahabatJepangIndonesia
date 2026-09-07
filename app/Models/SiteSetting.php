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
            Cache::forget('sji_corporate_synced_stats');
        });

        static::deleted(function () {
            Cache::forget('site_settings_all');
            Cache::forget('sji_corporate_synced_stats');
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
     * Get real-time synchronized corporate statistics across entire web portal
     */
    public static function getCorporateStats(): array
    {
        return Cache::remember('sji_corporate_synced_stats', 600, function () {
            $settings = static::allCached();

            // 1. Branches Count & Cities from GroupBranch
            $indonesiaBranchesCount = GroupBranch::where('is_active', true)->where('country', 'ID')->count();
            $japanBranches = GroupBranch::where('is_active', true)->where('country', 'JP')->get();
            $japanBranchesCount = $japanBranches->count();
            $totalBranchesCount = $indonesiaBranchesCount + $japanBranchesCount;

            $japanCities = $japanBranches->pluck('city')->unique()->filter()->values();
            $japanCitiesFormatted = $japanCities->isNotEmpty() ? $japanCities->join(' & ') : 'Tokyo & Chiba';
            $japanCitiesSlash = $japanCities->isNotEmpty() ? $japanCities->join('/') : 'Tokyo/Chiba';

            // 2. Teachers / Faculty from Teacher model
            $activeTeachers = Teacher::where('status', 'active')->get();
            $activeStaffCount = $activeTeachers->count();

            // Count Native sensei
            $dbNativeCount = $activeTeachers->filter(function ($t) {
                $text = strtolower(($t->jlpt_level ?? '') . ' ' . ($t->specialization ?? '') . ' ' . ($t->romaji_name ?? '') . ' ' . ($t->notes ?? ''));
                return str_contains($text, 'native');
            })->count();

            // Count Urawa Alumni sensei
            $dbUrawaCount = $activeTeachers->filter(function ($t) {
                $text = strtolower(($t->japan_experience ?? '') . ' ' . ($t->specialization ?? '') . ' ' . ($t->notes ?? ''));
                return str_contains($text, 'urawa');
            })->count();

            // SJI default baselines with auto-increment if DB count grows or admin overrides
            $staffCountSetting = $settings['stat_instructors_count'] ?? null;
            $staffCount = !empty($staffCountSetting) ? (int)$staffCountSetting : max(20, $activeStaffCount);
            $staffDisplay = $staffCount . ($settings['stat_instructors_suffix'] ?? '+');

            $nativeSetting = $settings['stat_native_teachers'] ?? null;
            $nativeCount = !empty($nativeSetting) ? (int)$nativeSetting : max(3, $dbNativeCount);

            $urawaSetting = $settings['stat_urawa_teachers'] ?? null;
            $urawaCount = !empty($urawaSetting) ? (int)$urawaSetting : max(3, $dbUrawaCount);

            // 3. Alumni Sent
            $alumniSent = $settings['corporate_alumni_sent'] ?? '850+';

            // 4. Partner MoU
            $partnerCount = Partner::count();
            $mouLabel = $settings['corporate_mou_label'] ?? 'MoU Poltekkes & SMK Nasional';

            // 5. Course Levels
            $courseLevelsCount = 4; // 4 Jenjang (Screening, N5, N4, N3/Kaigo)

            return [
                'course_levels_count' => $courseLevelsCount,
                'staff_count' => $staffDisplay,
                'staff_raw' => $staffCount,
                'native_count' => $nativeCount,
                'urawa_count' => $urawaCount,
                'alumni_sent' => $alumniSent,
                'indonesia_branches_count' => $indonesiaBranchesCount,
                'japan_branches_count' => $japanBranchesCount,
                'total_branches_count' => $totalBranchesCount,
                'japan_cities' => $japanCitiesFormatted,
                'japan_cities_slash' => $japanCitiesSlash,
                'partner_count' => $partnerCount,
                'mou_label' => $mouLabel,
            ];
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
        Cache::forget('sji_corporate_synced_stats');
        return $setting;
    }
}
