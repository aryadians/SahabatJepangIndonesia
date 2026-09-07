<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Consultation;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadConversionTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'leadadmin@sji-group.com',
        ]);
    }

    public function test_guest_cannot_convert_lead(): void
    {
        $consultation = Consultation::create([
            'name' => 'Budi Santoso',
            'phone' => '08123456789',
            'program' => 'Tokutei Ginou (SSW)',
            'status' => 'pending',
        ]);

        $response = $this->post("/admin/leads/{$consultation->id}/convert-to-student", [
            'program' => 'Tokutei Ginou (SSW)',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_admin_can_convert_lead_to_official_student(): void
    {
        $consultation = Consultation::create([
            'name' => 'Ahmad Fauzi',
            'phone' => '085712345678',
            'city' => 'Yogyakarta',
            'education' => 'SMK Teknik',
            'program' => 'Tokutei Ginou (SSW)',
            'status' => 'contacted',
        ]);

        $payload = [
            'program' => 'Tokutei Ginou (SSW)',
            'batch' => 'Angkatan 45 - 2026',
            'city' => 'Yogyakarta',
            'gender' => 'Laki-laki',
            'entry_date' => '2026-09-10',
            'total_cost' => 15000000,
            'payment_scheme' => 'mandiri',
            'registration_category' => 'reguler',
        ];

        $response = $this->actingAs($this->admin)->post("/admin/leads/{$consultation->id}/convert-to-student", $payload);

        // Assert Student was created
        $student = Student::where('name', 'Ahmad Fauzi')->first();
        $this->assertNotNull($student);
        $this->assertStringStartsWith('SJI-' . date('Y') . '-', $student->nis);
        $this->assertEquals('085712345678', $student->phone);
        $this->assertEquals('Yogyakarta', $student->city);
        $this->assertEquals('Angkatan 45 - 2026', $student->batch);
        $this->assertEquals('active', $student->status);
        $this->assertEquals(15000000, $student->total_cost);

        // Assert consultation status updated to registered
        $consultation->refresh();
        $this->assertEquals('registered', $consultation->status);
        $this->assertStringContainsString($student->nis, $consultation->admin_notes);

        // Assert redirect to student edit page
        $response->assertRedirect(route('admin.students.edit', $student->id));
        $response->assertSessionHas('success');

        // Assert audit log was recorded
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'lead_convert_to_student',
        ]);
    }

    public function test_ajax_lead_conversion_returns_json(): void
    {
        $consultation = Consultation::create([
            'name' => 'Siti Rahma',
            'phone' => '087812345678',
            'city' => 'Semarang',
            'education' => 'D3 Keperawatan',
            'program' => 'Tokutei Ginou (SSW)',
            'status' => 'pending',
        ]);

        $payload = [
            'program' => 'Tokutei Ginou (SSW)',
            'batch' => 'Angkatan 46',
            'gender' => 'Perempuan',
            'city' => 'Semarang',
            'total_cost' => 18000000,
            'payment_scheme' => 'talangan',
        ];

        $response = $this->actingAs($this->admin)->postJson("/admin/leads/{$consultation->id}/convert-to-student", $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'success',
            'message',
            'student_id',
            'nis',
            'redirect_url',
        ]);

        $this->assertDatabaseHas('students', [
            'name' => 'Siti Rahma',
            'gender' => 'Perempuan',
            'city' => 'Semarang',
            'payment_scheme' => 'talangan',
        ]);
    }

    public function test_nis_sequences_properly_for_consecutive_conversions(): void
    {
        $lead1 = Consultation::create([
            'name' => 'Siswa Pertama',
            'phone' => '0811111111',
            'program' => 'Magang Teknis (Kenshusei)',
        ]);

        $lead2 = Consultation::create([
            'name' => 'Siswa Kedua',
            'phone' => '0822222222',
            'program' => 'Magang Teknis (Kenshusei)',
        ]);

        $this->actingAs($this->admin)->postJson("/admin/leads/{$lead1->id}/convert-to-student", [
            'program' => 'Magang Teknis (Kenshusei)',
        ]);

        $this->actingAs($this->admin)->postJson("/admin/leads/{$lead2->id}/convert-to-student", [
            'program' => 'Magang Teknis (Kenshusei)',
        ]);

        $st1 = Student::where('name', 'Siswa Pertama')->first();
        $st2 = Student::where('name', 'Siswa Kedua')->first();

        $this->assertNotEquals($st1->nis, $st2->nis);
    }
}
