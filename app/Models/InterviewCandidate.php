<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewCandidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_interview_id',
        'student_id',
        'result',
        'interview_score',
        'interviewer_feedback',
    ];

    protected $casts = [
        'interview_score' => 'decimal:1',
    ];

    public function jobInterview()
    {
        return $this->belongsTo(JobInterview::class, 'job_interview_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function getResultBadgeAttribute(): array
    {
        return match($this->result) {
            'passed' => ['label' => 'Lolos Seleksi', 'bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200'],
            'failed' => ['label' => 'Belum Lolos', 'bg' => 'bg-rose-100 text-rose-800 border-rose-200'],
            'rescheduled' => ['label' => 'Jadwal Ulang', 'bg' => 'bg-purple-100 text-purple-800 border-purple-200'],
            default => ['label' => 'Menunggu Hasil', 'bg' => 'bg-amber-100 text-amber-800 border-amber-200'],
        };
    }
}
