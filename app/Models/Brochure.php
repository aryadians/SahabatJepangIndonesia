<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brochure extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'program',
        'badge_text',
        'description',
        'file_path',
        'file_name',
        'file_size',
        'download_count',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'download_count' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Scope brosur yang aktif tampil
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order')->orderBy('id', 'desc');
    }

    /**
     * Ikon & Warna sesuai Program/Kelas
     */
    public function getThemeAttribute(): array
    {
        return match($this->program) {
            'Tokutei Ginou (SSW)' => [
                'icon' => 'award',
                'bg' => 'from-red-600 to-japan-700',
                'badge_bg' => 'bg-red-100 text-japan-700',
                'border' => 'border-red-200 hover:border-red-500',
            ],
            'Ginou Jisshusei (Magang)' => [
                'icon' => 'briefcase',
                'bg' => 'from-blue-600 to-indigo-700',
                'badge_bg' => 'bg-blue-100 text-blue-800',
                'border' => 'border-blue-200 hover:border-blue-500',
            ],
            'Engineer & Profesional' => [
                'icon' => 'cpu',
                'bg' => 'from-emerald-600 to-teal-700',
                'badge_bg' => 'bg-emerald-100 text-emerald-800',
                'border' => 'border-emerald-200 hover:border-emerald-500',
            ],
            'Kursus Bahasa Jepang' => [
                'icon' => 'book-open',
                'bg' => 'from-purple-600 to-indigo-800',
                'badge_bg' => 'bg-purple-100 text-purple-800',
                'border' => 'border-purple-200 hover:border-purple-500',
            ],
            default => [
                'icon' => 'file-text',
                'bg' => 'from-slate-700 to-slate-900',
                'badge_bg' => 'bg-slate-100 text-slate-800',
                'border' => 'border-slate-200 hover:border-slate-400',
            ],
        };
    }
}
