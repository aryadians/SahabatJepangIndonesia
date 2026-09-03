<?php

namespace Tests\Feature;

use App\Models\Consultation;
use App\Models\InterviewCandidate;
use App\Models\JobInterview;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin.newfeatures@example.com',
        ]);
    }

    public function test_guest_can_access_brochure_page(): void
    {
        $response = $this->get('/brosur');
        $response->assertStatus(200);
        $response->assertSee('Brosur Resmi');
    }

    public function test_guest_submitting_brochure_creates_lead_and_unlocks_brochure(): void
    {
        $payload = [
            'name' => 'Aditya Pratama',
            'phone' => '081234567890',
            'program' => 'Tokutei Ginou (SSW)',
            'city' => 'Semarang',
        ];

        $response = $this->post('/brosur/download', $payload);
        $response->assertRedirect('/brosur?unlocked=true');

        $this->assertDatabaseHas('consultations', [
            'name' => 'Aditya Pratama',
            'phone' => '081234567890',
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_view_student_receipt_and_invoice(): void
    {
        $student = Student::create([
            'nis' => 'SJI-2026-991',
            'name' => 'Bambang Pamungkas',
            'gender' => 'Laki-laki',
            'program' => 'Tokutei Ginou (SSW)',
            'status' => 'active',
            'total_cost' => 25000000,
            'paid_amount' => 10000000,
            'payment_status' => 'partial',
        ]);

        // 1. Receipt
        $receiptResponse = $this->actingAs($this->admin)->get("/admin/students/{$student->id}/receipt");
        $receiptResponse->assertStatus(200);
        $receiptResponse->assertSee('Kwitansi Pembayaran Resmi');
        $receiptResponse->assertSee('Bambang Pamungkas');
        $receiptResponse->assertSee('10.000.000');

        // 2. Invoice
        $invoiceResponse = $this->actingAs($this->admin)->get("/admin/students/{$student->id}/invoice");
        $invoiceResponse->assertStatus(200);
        $invoiceResponse->assertSee('INVOICE TAGIHAN');
        $invoiceResponse->assertSee('15.000.000'); // Sisa tagihan
    }

    public function test_admin_can_manage_job_interviews_and_assign_candidates(): void
    {
        $student = Student::create([
            'nis' => 'SJI-2026-992',
            'name' => 'Siti Nurhaliza',
            'gender' => 'Perempuan',
            'program' => 'Tokutei Ginou (SSW)',
            'status' => 'active',
        ]);

        // 1. Create Job Interview
        $interviewData = [
            'company_name' => 'Tokyo Caregiver Corp',
            'prefecture' => 'Tokyo',
            'sector' => 'Kaigo / Caregiver',
            'interview_date' => now()->addDays(5)->format('Y-m-d H:i'),
            'location_type' => 'online',
            'meeting_link' => 'https://zoom.us/j/123456789',
            'quota_needed' => 3,
            'status' => 'scheduled',
            'student_ids' => [$student->id],
        ];

        $response = $this->actingAs($this->admin)->post('/admin/interviews', $interviewData);
        $response->assertRedirect('/admin/interviews');

        $interview = JobInterview::where('company_name', 'Tokyo Caregiver Corp')->first();
        $this->assertNotNull($interview);

        // Candidate attached and student status updated to 'interview'
        $this->assertDatabaseHas('interview_candidates', [
            'job_interview_id' => $interview->id,
            'student_id' => $student->id,
            'result' => 'pending',
        ]);
        $this->assertEquals('interview', $student->fresh()->status);

        // 2. Update Candidate Result to Passed
        $resultResponse = $this->actingAs($this->admin)->post("/admin/interviews/{$interview->id}/candidates/{$student->id}", [
            'result' => 'passed',
            'interview_score' => 92.5,
            'interviewer_feedback' => 'Sangat sopan dan kaiwa lancar.',
        ]);
        $resultResponse->assertRedirect('/admin/interviews');

        // Student automatically promoted to 'passed_interview' with destination company
        $freshStudent = $student->fresh();
        $this->assertEquals('passed_interview', $freshStudent->status);
        $this->assertEquals('Tokyo Caregiver Corp', $freshStudent->destination_company);
        $this->assertEquals('Tokyo', $freshStudent->destination_prefecture);
    }
}
