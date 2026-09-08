<?php

namespace Tests\Feature;

use App\Models\ExamQuestion;
use Database\Seeders\BankSoal200Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExamSimulatorRandomizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(BankSoal200Seeder::class);
    }

    public function test_guest_can_access_simulator_and_get_randomized_questions(): void
    {
        // 1. Check default N5 returns 25 questions from the 50 bank
        $response = $this->get('/simulasi-ujian?level=N5');
        $response->assertStatus(200);
        $response->assertSee('Simulasi Tryout JLPT');
        $response->assertSee('Paket Soal Diacak Otomatis');

        $questionsN5 = $response->viewData('questions');
        $this->assertCount(25, $questionsN5);
        foreach ($questionsN5 as $q) {
            $this->assertEquals('N5', $q->level);
        }

        // 2. Check full count option (50 questions)
        $responseFull = $this->get('/simulasi-ujian?level=N5&count=50');
        $responseFull->assertStatus(200);
        $questionsN5Full = $responseFull->viewData('questions');
        $this->assertCount(50, $questionsN5Full);

        // 3. Check Grand Tryout default returns 50 questions from the 200 bank
        $responseAll = $this->get('/simulasi-ujian?level=all');
        $responseAll->assertStatus(200);
        $questionsAll = $responseAll->viewData('questions');
        $this->assertCount(50, $questionsAll);
    }

    public function test_two_students_receive_different_random_question_sequences(): void
    {
        $response1 = $this->get('/simulasi-ujian?level=N5');
        $ids1 = $response1->viewData('questions')->pluck('id')->toArray();

        $response2 = $this->get('/simulasi-ujian?level=N5');
        $ids2 = $response2->viewData('questions')->pluck('id')->toArray();

        $this->assertCount(25, $ids1);
        $this->assertCount(25, $ids2);
        // The probability of identical 25 items in identical order out of 50 is infinitesimal
        $this->assertNotEquals($ids1, $ids2);
    }

    public function test_evaluation_scores_accurately_with_specific_question_ids(): void
    {
        // Pick 5 specific questions
        $questions = ExamQuestion::where('level', 'N5')->limit(5)->get();
        $questionIds = $questions->pluck('id')->toArray();

        // Prepare 3 correct answers and 2 wrong answers
        $answers = [];
        foreach ($questions as $idx => $q) {
            if ($idx < 3) {
                $answers[$q->id] = $q->correct_answer; // Correct
            } else {
                // Wrong answer
                $wrongOptions = array_diff(['A', 'B', 'C', 'D'], [$q->correct_answer]);
                $answers[$q->id] = reset($wrongOptions);
            }
        }

        $payload = [
            'level' => 'N5',
            'question_ids' => $questionIds,
            'answers' => $answers,
        ];

        $response = $this->postJson('/simulasi-ujian/evaluate', $payload);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'level' => 'N5',
            'earned_points' => 30,
            'total_points' => 50,
            'percentage' => 60,
            'is_passed' => true,
            'correct_count' => 3,
            'wrong_count' => 2,
        ]);

        $details = $response->json('details');
        $this->assertCount(5, $details);
        $this->assertEquals($questionIds, array_column($details, 'id'));
    }
}
