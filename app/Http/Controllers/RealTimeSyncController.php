<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\BatchSchedule;
use App\Models\Consultation;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RealTimeSyncController extends Controller
{
    /**
     * Endpoint Real-Time Sync untuk Sisi Guest / Publik
     * Menyediakan data kuota angkatan, statistik alumni terkini, dan feed siswa live
     */
    public function guestSync(Request $request): JsonResponse
    {
        $departedCount = Student::where('status', 'departed')->count();
        $activeCount = Student::whereIn('status', ['active', 'interview', 'passed_interview'])->count();

        // 4 Siswa terkini yang terbang / lolos user
        $latestDeparted = Student::whereIn('status', ['departed', 'passed_interview'])
            ->latest('updated_at')
            ->take(4)
            ->get(['id', 'name', 'japanese_name', 'destination_company', 'destination_prefecture', 'program', 'sector', 'status', 'photo']);

        // Jadwal & kuota angkatan terkini
        $batches = BatchSchedule::where('status', 'open')
            ->orderBy('order')
            ->take(5)
            ->get(['id', 'batch_name', 'program_type', 'quota', 'remaining_seats', 'registration_deadline']);

        return response()->json([
            'status' => 'success',
            'timestamp' => now()->toIso8601String(),
            'epoch' => now()->timestamp,
            'stats' => [
                'total_alumni' => 586 + $departedCount,
                'active_students' => $activeCount,
                'departed_students' => $departedCount,
            ],
            'latest_departed' => $latestDeparted,
            'batches' => $batches,
        ]);
    }

    /**
     * Endpoint Real-Time Sync untuk Sisi Admin & Sensei
     * Menyediakan notifikasi leads baru, counter pending, dan metrik sistem secara real-time
     */
    public function adminSync(Request $request): JsonResponse
    {
        $pendingLeadsQuery = Consultation::where('status', 'pending');
        $pendingLeadsCount = $pendingLeadsQuery->count();

        $latestLeads = Consultation::where('status', 'pending')
            ->latest('id')
            ->take(5)
            ->get(['id', 'name', 'phone', 'city', 'program', 'created_at'])
            ->map(function ($item) {
                $cleanPhone = preg_replace('/[^0-9]/', '', $item->phone);
                if (str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = '62' . substr($cleanPhone, 1);
                }
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'phone' => $item->phone,
                    'city' => $item->city,
                    'program' => $item->program,
                    'created_at_human' => Carbon::parse($item->created_at)->diffForHumans(),
                    'wa_link' => "https://wa.me/{$cleanPhone}?text=" . urlencode("Halo {$item->name}, terima kasih telah berkonsultasi di LPK Sahabat Jepang Indonesia. Ada yang bisa kami bantu mengenai program {$item->program}?"),
                ];
            });

        $pendingAffiliatesCount = Affiliate::where('is_active', false)->count();
        $totalStudents = Student::count();
        $activeStudents = Student::whereIn('status', ['active', 'interview', 'passed_interview'])->count();
        $departedStudents = Student::where('status', 'departed')->count();

        $leadsKpi = [
            'total' => Consultation::count(),
            'pending' => $pendingLeadsCount,
            'contacted' => Consultation::where('status', 'contacted')->count(),
            'registered' => Consultation::where('status', 'registered')->count(),
            'cancelled' => Consultation::where('status', 'cancelled')->count(),
        ];

        $totalReceivables = Student::where('status', '!=', 'cancelled')
            ->selectRaw('SUM(CASE WHEN total_cost > paid_amount THEN total_cost - paid_amount ELSE 0 END) as total_receivable')
            ->value('total_receivable') ?? 0;

        $maxConsultationId = Consultation::max('id') ?? 0;
        $maxStudentId = Student::max('id') ?? 0;

        $interviewsKpi = [
            'total' => \App\Models\JobInterview::count(),
            'scheduled' => \App\Models\JobInterview::where('status', 'scheduled')->count(),
            'candidates' => \App\Models\InterviewCandidate::count(),
            'passed' => \App\Models\InterviewCandidate::where('result', 'passed')->count(),
        ];

        $brochuresKpi = [
            'total' => \App\Models\Brochure::count(),
            'downloads' => (int) \App\Models\Brochure::sum('download_count'),
            'active' => \App\Models\Brochure::where('is_active', true)->count(),
        ];

        return response()->json([
            'status' => 'success',
            'server_time' => now()->format('H:i:s'),
            'epoch' => now()->timestamp,
            'max_consultation_id' => $maxConsultationId,
            'max_student_id' => $maxStudentId,
            'notifications' => [
                'pending_leads_count' => $pendingLeadsCount,
                'latest_leads' => $latestLeads,
                'pending_affiliates_count' => $pendingAffiliatesCount,
            ],
            'leads_kpi' => $leadsKpi,
            'students_kpi' => [
                'total' => $totalStudents,
                'active' => $activeStudents,
                'departed' => $departedStudents,
            ],
            'financial_kpi' => [
                'receivables' => (float) $totalReceivables,
                'formatted_receivables' => 'Rp ' . number_format($totalReceivables, 0, ',', '.'),
            ],
            'interviews_kpi' => $interviewsKpi,
            'brochures_kpi' => $brochuresKpi,
        ]);
    }
}
