<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterviewCandidate;
use App\Models\JobInterview;
use App\Models\Student;
use Illuminate\Http\Request;

class JobInterviewController extends Controller
{
    /**
     * Tampilkan Agenda Kalender & Daftar Wawancara Kaisha
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $sector = $request->query('sector', 'all');

        $query = JobInterview::with(['candidates.student'])->orderBy('interview_date', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($sector !== 'all') {
            $query->where('sector', $sector);
        }

        $interviews = $query->paginate(10);

        // Siswa aktif yang siap dimatching ke wawancara
        $availableStudents = Student::whereIn('status', ['active', 'interview'])
            ->orderBy('name')
            ->get(['id', 'nis', 'name', 'program', 'sector', 'status', 'japanese_level']);

        // Statistik Cepat Agenda
        $stats = [
            'total_interviews' => JobInterview::count(),
            'scheduled' => JobInterview::where('status', 'scheduled')->count(),
            'total_candidates' => InterviewCandidate::count(),
            'passed_candidates' => InterviewCandidate::where('result', 'passed')->count(),
        ];

        return view('admin.interviews.index', compact('interviews', 'availableStudents', 'stats', 'status', 'sector'));
    }

    /**
     * Export / Cetak Riwayat & Agenda Wawancara Kaisha ke PDF Resmi
     */
    public function exportPdf(Request $request)
    {
        $status = $request->query('status', 'all');
        $sector = $request->query('sector', 'all');

        $query = JobInterview::with(['candidates.student'])->orderBy('interview_date', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($sector !== 'all') {
            $query->where('sector', $sector);
        }

        $interviews = $query->get();

        $totalCandidates = InterviewCandidate::whereIn('job_interview_id', $interviews->pluck('id'))->count();
        $passedCandidates = InterviewCandidate::whereIn('job_interview_id', $interviews->pluck('id'))->where('result', 'passed')->count();

        return view('admin.interviews.export_pdf', compact('interviews', 'totalCandidates', 'passedCandidates', 'status', 'sector'));
    }

    /**
     * Simpan Jadwal Wawancara Kaisha Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'japanese_company_name' => 'nullable|string|max:255',
            'prefecture' => 'required|string|max:100',
            'sector' => 'required|string|max:100',
            'interview_date' => 'required|date',
            'location_type' => 'required|in:online,offline',
            'meeting_link' => 'nullable|string|max:255',
            'meeting_passcode' => 'nullable|string|max:100',
            'quota_needed' => 'required|integer|min:1',
            'salary_range' => 'nullable|string|max:100',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'notes' => 'nullable|string',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $interview = JobInterview::create($validated);

        if (!empty($validated['student_ids'])) {
            foreach ($validated['student_ids'] as $stId) {
                InterviewCandidate::create([
                    'job_interview_id' => $interview->id,
                    'student_id' => $stId,
                    'result' => 'pending',
                ]);

                // Update status siswa menjadi 'interview' jika masih 'active'
                Student::where('id', $stId)->where('status', 'active')->update(['status' => 'interview']);
            }
        }

        return redirect()->route('admin.interviews.index')->with('success', 'Jadwal wawancara dengan ' . $interview->company_name . ' berhasil dibuat.');
    }

    /**
     * Perbarui Jadwal Wawancara Kaisha
     */
    public function update(Request $request, $id)
    {
        $interview = JobInterview::findOrFail($id);

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'japanese_company_name' => 'nullable|string|max:255',
            'prefecture' => 'required|string|max:100',
            'sector' => 'required|string|max:100',
            'interview_date' => 'required|date',
            'location_type' => 'required|in:online,offline',
            'meeting_link' => 'nullable|string|max:255',
            'meeting_passcode' => 'nullable|string|max:100',
            'quota_needed' => 'required|integer|min:1',
            'salary_range' => 'nullable|string|max:100',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $interview->update($validated);

        return redirect()->route('admin.interviews.index')->with('success', 'Jadwal wawancara ' . $interview->company_name . ' berhasil diperbarui.');
    }

    /**
     * Hapus Jadwal Wawancara
     */
    public function destroy($id)
    {
        $interview = JobInterview::findOrFail($id);
        $name = $interview->company_name;
        $interview->delete();

        return redirect()->route('admin.interviews.index')->with('success', 'Jadwal wawancara ' . $name . ' berhasil dihapus.');
    }

    /**
     * Tambah Kandidat Siswa ke Jadwal Wawancara
     */
    public function assignCandidates(Request $request, $id)
    {
        $interview = JobInterview::findOrFail($id);

        $validated = $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:students,id',
        ]);

        $addedCount = 0;
        foreach ($validated['student_ids'] as $stId) {
            $exists = InterviewCandidate::where('job_interview_id', $interview->id)
                ->where('student_id', $stId)
                ->exists();

            if (!$exists) {
                InterviewCandidate::create([
                    'job_interview_id' => $interview->id,
                    'student_id' => $stId,
                    'result' => 'pending',
                ]);

                Student::where('id', $stId)->where('status', 'active')->update(['status' => 'interview']);
                $addedCount++;
            }
        }

        return redirect()->route('admin.interviews.index')->with('success', $addedCount . ' kandidat siswa berhasil ditugaskan ke wawancara.');
    }

    /**
     * Perbarui Hasil Kelulusan Seleksi Siswa
     */
    public function updateCandidateResult(Request $request, $interviewId, $studentId)
    {
        $interview = JobInterview::findOrFail($interviewId);
        $candidate = InterviewCandidate::where('job_interview_id', $interviewId)
            ->where('student_id', $studentId)
            ->firstOrFail();

        $validated = $request->validate([
            'result' => 'required|in:pending,passed,failed,rescheduled',
            'interview_score' => 'nullable|numeric|min:0|max:100',
            'interviewer_feedback' => 'nullable|string',
        ]);

        $candidate->update($validated);

        // Jika siswa lolos (passed), update data siswa otomatis
        if ($validated['result'] === 'passed') {
            Student::where('id', $studentId)->update([
                'status' => 'passed_interview',
                'destination_company' => $interview->company_name,
                'destination_prefecture' => $interview->prefecture,
                'sector' => $interview->sector,
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Hasil wawancara berhasil disimpan',
                'candidate' => $candidate,
            ]);
        }

        return redirect()->route('admin.interviews.index')->with('success', 'Hasil seleksi siswa berhasil diperbarui.');
    }
}
