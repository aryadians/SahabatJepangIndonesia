<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;

class ExamQuestionController extends Controller
{
    /**
     * Tampilkan daftar butir soal ujian CBT
     */
    public function index(Request $request)
    {
        $level = $request->query('level', 'all');
        $section = $request->query('section', 'all');
        $status = $request->query('status', 'all');
        $search = $request->query('search');

        $query = ExamQuestion::query();

        if ($level !== 'all' && !empty($level)) {
            $query->where('level', $level);
        }

        if ($section !== 'all' && !empty($section)) {
            $query->where('section', $section);
        }

        if ($status !== 'all' && !empty($status)) {
            $query->where('is_active', $status === 'active');
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('question_japanese', 'like', "%{$search}%")
                  ->orWhere('option_a', 'like', "%{$search}%")
                  ->orWhere('option_b', 'like', "%{$search}%")
                  ->orWhere('option_c', 'like', "%{$search}%")
                  ->orWhere('option_d', 'like', "%{$search}%")
                  ->orWhere('explanation', 'like', "%{$search}%");
            });
        }

        $questions = $query->orderBy('level')
            ->orderBy('section')
            ->orderBy('order')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Metrics Summary
        $stats = [
            'total' => ExamQuestion::count(),
            'active' => ExamQuestion::where('is_active', true)->count(),
            'inactive' => ExamQuestion::where('is_active', false)->count(),
            'n5' => ExamQuestion::where('level', 'N5')->count(),
            'n4' => ExamQuestion::where('level', 'N4')->count(),
            'n3' => ExamQuestion::where('level', 'N3')->count(),
            'jft' => ExamQuestion::where('level', 'JFT-Basic')->count(),
        ];

        return view('admin.exam_questions.index', compact(
            'questions',
            'level',
            'section',
            'status',
            'search',
            'stats'
        ));
    }

    /**
     * Tampilkan form pembuatan butir soal baru
     */
    public function create()
    {
        $question = new ExamQuestion([
            'level' => 'N5',
            'section' => 'Kotoba',
            'points' => 10,
            'order' => 0,
            'is_active' => true,
            'correct_answer' => 'A',
        ]);

        return view('admin.exam_questions.form', [
            'question' => $question,
            'isEdit' => false,
        ]);
    }

    /**
     * Simpan butir soal baru
     */
    public function store(Request $request)
    {
        $validated = $this->validateQuestion($request);

        $question = ExamQuestion::create($validated);

        AuditLog::record(
            'exam_question_create',
            "Menambahkan butir soal CBT ({$question->level} - {$question->section}): " . mb_substr($question->question, 0, 50) . "...",
            ['question_id' => $question->id, 'level' => $question->level, 'section' => $question->section]
        );

        return redirect()->route('admin.exam-questions.index')
            ->with('success', "Soal {$question->level} ({$question->section}) berhasil ditambahkan ke Bank Soal CBT.");
    }

    /**
     * Tampilkan form edit butir soal
     */
    public function edit($id)
    {
        $question = ExamQuestion::findOrFail($id);

        return view('admin.exam_questions.form', [
            'question' => $question,
            'isEdit' => true,
        ]);
    }

    /**
     * Perbarui butir soal yang ada
     */
    public function update(Request $request, $id)
    {
        $question = ExamQuestion::findOrFail($id);
        $validated = $this->validateQuestion($request);

        $question->update($validated);

        AuditLog::record(
            'exam_question_update',
            "Memperbarui butir soal CBT ID #{$question->id} ({$question->level})",
            ['question_id' => $question->id, 'level' => $question->level, 'section' => $question->section]
        );

        return redirect()->route('admin.exam-questions.index')
            ->with('success', "Soal ID #{$question->id} ({$question->level} - {$question->section}) berhasil diperbarui.");
    }

    /**
     * Hapus butir soal
     */
    public function destroy($id)
    {
        $question = ExamQuestion::findOrFail($id);
        $details = ['id' => $question->id, 'level' => $question->level, 'question' => mb_substr($question->question, 0, 50)];
        $question->delete();

        AuditLog::record(
            'exam_question_delete',
            "Menghapus butir soal CBT ID #{$id}",
            $details
        );

        return redirect()->route('admin.exam-questions.index')
            ->with('success', 'Butir soal berhasil dihapus dari Bank Soal CBT.');
    }

    /**
     * Toggle status aktif butir soal (AJAX/POST)
     */
    public function toggleStatus(Request $request, $id)
    {
        $question = ExamQuestion::findOrFail($id);
        $question->is_active = !$question->is_active;
        $question->save();

        AuditLog::record(
            'exam_question_toggle',
            "Mengubah status soal ID #{$question->id} menjadi " . ($question->is_active ? 'Aktif' : 'Nonaktif'),
            ['question_id' => $question->id, 'is_active' => $question->is_active]
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $question->is_active,
                'message' => 'Status soal berhasil diubah.',
            ]);
        }

        return redirect()->back()
            ->with('success', "Status soal ID #{$question->id} berhasil diubah menjadi " . ($question->is_active ? 'Aktif' : 'Nonaktif') . ".");
    }

    /**
     * Validasi input butir soal
     */
    protected function validateQuestion(Request $request): array
    {
        $data = $request->validate([
            'level' => 'required|in:N5,N4,N3,JFT-Basic',
            'section' => 'required|in:Kotoba,Bunpou,Dokkai,Kanji,Choukai',
            'question' => 'required|string',
            'question_japanese' => 'nullable|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:A,B,C,D',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1|max:100',
            'order' => 'nullable|integer|min:0',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['order'] = $data['order'] ?? 0;

        return $data;
    }
}
