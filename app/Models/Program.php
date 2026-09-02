<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'japanese_title',
        'badge',
        'badge_color',
        'icon',
        'salary_yen',
        'salary_idr',
        'duration',
        'description',
        'sectors',
        'requirements',
        'benefits',
        'order',
        'is_active',
    ];

    protected $casts = [
        'sectors' => 'array',
        'requirements' => 'array',
        'benefits' => 'array',
        'is_active' => 'boolean',
    ];
}
