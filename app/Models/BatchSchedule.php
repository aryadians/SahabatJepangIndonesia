<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_name',
        'program_type',
        'start_date',
        'registration_deadline',
        'target_departure',
        'quota',
        'remaining_seats',
        'status',
        'order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'registration_deadline' => 'date',
        'quota' => 'integer',
        'remaining_seats' => 'integer',
    ];
}
