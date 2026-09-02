<?php

namespace App\Http\Controllers;

use App\Models\ExamQuestion;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ExamSimulatorController extends Controller
{
    /**
     * Tampilkan Halaman Simulasi Ujian JLPT & JFT-Basic CBT Online
     */
    public function index(Request $request)
    {
        $settings = SiteSetting::allCached();
        $selectedLevel = $request->query('level', 'N5');

        if (!in_array($selectedLevel, ['N5', 'N4', 'N3', 'JFT-Basic', 'all'])) {
            $selectedLevel = 'N5';
        }

        $query = ExamQuestion::where('is_active', true);
        if ($selectedLevel !== 'all') {
            $query->where('level', $selectedLevel);
        }
        $questions = $query->orderBy('order')->get();

        $levelsCount = [
            'N5' => ExamQuestion::where('level', 'N5')->where('is_active', true)->count(),
            'N4' => ExamQuestion::where('level', 'N4')->where('is_active', true)->count(),
            'N3' => ExamQuestion::where('level', 'N3')->where('is_active', true)->count(),
            'JFT-Basic' => ExamQuestion::where('level', 'JFT-Basic')->where('is_active', true)->count(),
            'all' => ExamQuestion::where('is_active', true)->count(),
        ];

        return view('landing.exam-simulator', compact('settings', 'questions', 'selectedLevel', 'levelsCount'));
    }

    /**
     * Evaluasi Hasil Simulasi Ujian & Pembahasan
     */
    public function evaluate(Request $request)
    {
        $level = $request->input('level', 'N5');
        $userAnswers = $request->input('answers', []); // [question_id => selected_option]

        $query = ExamQuestion::where('is_active', true);
        if ($level !== 'all') {
            $query->where('level', $level);
        }
        $questions = $query->orderBy('order')->get();

        $totalPoints = 0;
        $earnedPoints = 0;
        $correctCount = 0;
        $wrongCount = 0;
        $results = [];
        $sectionBreakdown = [];

        foreach ($questions as $q) {
            $userAns = $userAnswers[$q->id] ?? null;
            $isCorrect = ($userAns === $q->correct_answer);

            $totalPoints += $q->points;
            if ($isCorrect) {
                $earnedPoints += $q->points;
                $correctCount++;
            } else {
                $wrongCount++;
            }

            if (!isset($sectionBreakdown[$q->section])) {
                $sectionBreakdown[$q->section] = ['total' => 0, 'correct' => 0];
            }
            $sectionBreakdown[$q->section]['total']++;
            if ($isCorrect) {
                $sectionBreakdown[$q->section]['correct']++;
            }

            $results[] = [
                'id' => $q->id,
                'section' => $q->section,
                'question' => $q->question,
                'question_japanese' => $q->question_japanese,
                'option_a' => $q->option_a,
                'option_b' => $q->option_b,
                'option_c' => $q->option_c,
                'option_d' => $q->option_d,
                'user_answer' => $userAns,
                'correct_answer' => $q->correct_answer,
                'is_correct' => $isCorrect,
                'explanation' => $q->explanation,
                'points' => $q->points,
            ];
        }

        $percentage = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100) : 0;
        $isPassed = $percentage >= 60; // Standar kelulusan JLPT 60%

        return response()->json([
            'status' => 'success',
            'level' => $level,
            'earned_points' => $earnedPoints,
            'total_points' => $totalPoints,
            'percentage' => $percentage,
            'is_passed' => $isPassed,
            'correct_count' => $correctCount,
            'wrong_count' => $wrongCount,
            'section_breakdown' => $sectionBreakdown,
            'details' => $results,
        ]);
    }
}
