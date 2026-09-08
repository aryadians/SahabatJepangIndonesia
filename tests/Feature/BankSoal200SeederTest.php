<?php

namespace Tests\Feature;

use App\Models\ExamQuestion;
use Database\Seeders\BankSoal200Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BankSoal200SeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_bank_soal_200_seeder_populates_exactly_200_valid_questions(): void
    {
        $this->seed(BankSoal200Seeder::class);

        $this->assertEquals(200, ExamQuestion::count());

        // Level distribution check
        $this->assertEquals(50, ExamQuestion::where('level', 'N5')->count());
        $this->assertEquals(50, ExamQuestion::where('level', 'N4')->count());
        $this->assertEquals(50, ExamQuestion::where('level', 'N3')->count());
        $this->assertEquals(50, ExamQuestion::where('level', 'JFT-Basic')->count());

        // Answer key balance check (50 for each option A, B, C, D)
        $this->assertEquals(50, ExamQuestion::where('correct_answer', 'A')->count());
        $this->assertEquals(50, ExamQuestion::where('correct_answer', 'B')->count());
        $this->assertEquals(50, ExamQuestion::where('correct_answer', 'C')->count());
        $this->assertEquals(50, ExamQuestion::where('correct_answer', 'D')->count());

        // Points check
        $this->assertEquals(200, ExamQuestion::where('points', 10)->count());

        // Active status check
        $this->assertEquals(200, ExamQuestion::where('is_active', true)->count());

        // Valid section check
        $allowedSections = ['Kotoba', 'Bunpou', 'Dokkai', 'Kanji', 'Choukai'];
        $this->assertEquals(0, ExamQuestion::whereNotIn('section', $allowedSections)->count());
    }
}
