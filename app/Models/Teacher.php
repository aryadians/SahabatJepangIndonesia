<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'name',
        'romaji_name',
        'phone',
        'email',
        'gender',
        'join_date',
        'jlpt_level',
        'japan_experience',
        'specialization',
        'employment_type',
        'status',
        'photo',
        'document_certificate',
        'notes',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];
}
