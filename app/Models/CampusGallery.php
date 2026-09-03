<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampusGallery extends Model
{
    use HasFactory;

    protected $table = 'campus_galleries';

    protected $fillable = [
        'title',
        'institution',
        'program_tag',
        'badge_text',
        'description',
        'sub_text_left',
        'sub_text_right',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Program Badge Styling Helper
     */
    public function getTagBadgeAttribute(): array
    {
        return match($this->program_tag) {
            'SMILE Project', 'SMILE Project (Kemenkes)' => [
                'bg' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                'badge_color' => 'bg-emerald-600',
                'label' => 'SMILE Project',
            ],
            'SMK Go Japan' => [
                'bg' => 'bg-blue-100 text-blue-800 border-blue-300',
                'badge_color' => 'bg-blue-600',
                'label' => 'SMK Go Japan',
            ],
            'Campus Job Fair', 'Bursa Kerja' => [
                'bg' => 'bg-amber-100 text-amber-800 border-amber-300',
                'badge_color' => 'bg-amber-600',
                'label' => 'Bursa Kerja',
            ],
            'Pelepasan Terbang' => [
                'bg' => 'bg-purple-100 text-purple-800 border-purple-300',
                'badge_color' => 'bg-purple-600',
                'label' => 'Pelepasan',
            ],
            default => [
                'bg' => 'bg-red-100 text-red-800 border-red-300',
                'badge_color' => 'bg-red-600',
                'label' => $this->program_tag ?: 'MoU Kampus',
            ],
        };
    }
}
