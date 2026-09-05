<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobInterview extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'japanese_company_name',
        'prefecture',
        'sector',
        'interview_date',
        'location_type',
        'meeting_link',
        'meeting_passcode',
        'quota_needed',
        'salary_range',
        'status',
        'notes',
    ];

    protected $casts = [
        'interview_date' => 'datetime',
        'quota_needed' => 'integer',
    ];

    /**
     * Relasi ke kandidat siswa
     */
    public function candidates()
    {
        return $this->hasMany(InterviewCandidate::class, 'job_interview_id');
    }

    /**
     * Relasi many-to-many ke Siswa
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'interview_candidates')
                    ->withPivot(['id', 'result', 'interview_score', 'interviewer_feedback'])
                    ->withTimestamps();
    }

    /**
     * Badge Status Wawancara
     */
    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'scheduled' => ['label' => 'Terjadwal', 'bg' => 'bg-blue-100 text-blue-800 border-blue-200'],
            'ongoing' => ['label' => 'Berlangsung', 'bg' => 'bg-amber-100 text-amber-800 border-amber-200 animate-pulse'],
            'completed' => ['label' => 'Selesai', 'bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200'],
            'cancelled' => ['label' => 'Dibatalkan', 'bg' => 'bg-rose-100 text-rose-800 border-rose-200'],
            default => ['label' => ucfirst($this->status), 'bg' => 'bg-slate-100 text-slate-800 border-slate-200'],
        };
    }

    public function getQuotaAttribute(): int
    {
        return (int) ($this->quota_needed ?? 1);
    }

    public function getProgramTypeAttribute(): string
    {
        return $this->sector ?? 'Tokutei Ginou';
    }
}
