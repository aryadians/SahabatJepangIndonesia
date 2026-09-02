<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'section',
        'question',
        'question_japanese',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
        'points',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'points' => 'integer',
        'order' => 'integer',
    ];
}
