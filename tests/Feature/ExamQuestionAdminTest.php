<?php

namespace Tests\Feature;

use App\Models\ExamQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExamQuestionAdminTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $teacher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@sji-group.com',
        ]);

        $this->teacher = User::factory()->create([
            'role' => 'teacher',
            'email' => 'sensei@sji-group.com',
        ]);
    }

    public function test_guest_cannot_access_exam_questions_panel(): void
    {
        $response = $this->get('/admin/exam-questions');
        $response->assertRedirect('/login');
    }

    public function test_admin_and_teacher_can_view_exam_questions_index(): void
    {
        ExamQuestion::create([
            'level' => 'N5',
            'section' => 'Kotoba',
            'question' => 'Arti dari "Sensei" adalah...',
            'question_japanese' => '先生',
            'option_a' => 'Guru',
            'option_b' => 'Murid',
            'option_c' => 'Dokter',
            'option_d' => 'Polisi',
            'correct_answer' => 'A',
            'points' => 10,
            'is_active' => true,
        ]);

        $responseAdmin = $this->actingAs($this->admin)->get('/admin/exam-questions');
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertSee('Bank Soal');
        $responseAdmin->assertSee('Arti dari "Sensei" adalah...');

        $responseTeacher = $this->actingAs($this->teacher)->get('/admin/exam-questions');
        $responseTeacher->assertStatus(200);
        $responseTeacher->assertSee('Bank Soal');
    }

    public function test_admin_can_view_create_form(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/exam-questions/create');
        $response->assertStatus(200);
        $response->assertSee('Tambah Butir Soal');
    }

    public function test_admin_can_create_new_question(): void
    {
        $payload = [
            'level' => 'N4',
            'section' => 'Bunpou',
            'question' => 'Pilihlah partikel yang tepat untuk kalimat ini: Watashi wa gakusei ... arimasen.',
            'question_japanese' => '私は学生...ありません。',
            'option_a' => 'wa',
            'option_b' => 'de wa',
            'option_c' => 'ni',
            'option_d' => 'o',
            'correct_answer' => 'B',
            'explanation' => 'De wa arimasen adalah bentuk negatif sopan dari desu.',
            'points' => 10,
            'order' => 1,
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->admin)->post('/admin/exam-questions', $payload);
        $response->assertRedirect(route('admin.exam-questions.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('exam_questions', [
            'level' => 'N4',
            'section' => 'Bunpou',
            'correct_answer' => 'B',
        ]);
    }

    public function test_admin_can_update_question(): void
    {
        $question = ExamQuestion::create([
            'level' => 'N5',
            'section' => 'Kotoba',
            'question' => 'Pertanyaan awal',
            'option_a' => 'A',
            'option_b' => 'B',
            'option_c' => 'C',
            'option_d' => 'D',
            'correct_answer' => 'A',
            'points' => 10,
            'is_active' => true,
        ]);

        $updatePayload = [
            'level' => 'N5',
            'section' => 'Kotoba',
            'question' => 'Pertanyaan yang sudah diedit',
            'option_a' => 'Pilihan 1',
            'option_b' => 'Pilihan 2',
            'option_c' => 'Pilihan 3',
            'option_d' => 'Pilihan 4',
            'correct_answer' => 'C',
            'points' => 15,
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->admin)->put("/admin/exam-questions/{$question->id}", $updatePayload);
        $response->assertRedirect(route('admin.exam-questions.index'));

        $this->assertDatabaseHas('exam_questions', [
            'id' => $question->id,
            'question' => 'Pertanyaan yang sudah diedit',
            'correct_answer' => 'C',
            'points' => 15,
        ]);
    }

    public function test_admin_can_toggle_question_status(): void
    {
        $question = ExamQuestion::create([
            'level' => 'N3',
            'section' => 'Dokkai',
            'question' => 'Soal membaca N3',
            'option_a' => 'A',
            'option_b' => 'B',
            'option_c' => 'C',
            'option_d' => 'D',
            'correct_answer' => 'A',
            'points' => 20,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->postJson("/admin/exam-questions/{$question->id}/toggle-status");
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('exam_questions', [
            'id' => $question->id,
            'is_active' => false,
        ]);
    }

    public function test_admin_can_delete_question(): void
    {
        $question = ExamQuestion::create([
            'level' => 'JFT-Basic',
            'section' => 'Kotoba',
            'question' => 'Soal untuk dihapus',
            'option_a' => 'A',
            'option_b' => 'B',
            'option_c' => 'C',
            'option_d' => 'D',
            'correct_answer' => 'A',
            'points' => 10,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/exam-questions/{$question->id}");
        $response->assertRedirect(route('admin.exam-questions.index'));

        $this->assertDatabaseMissing('exam_questions', [
            'id' => $question->id,
        ]);
    }
}
