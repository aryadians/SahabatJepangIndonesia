<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'age',
        'education',
        'program',
        'city',
        'message',
        'status',
        'admin_notes',
    ];
}
