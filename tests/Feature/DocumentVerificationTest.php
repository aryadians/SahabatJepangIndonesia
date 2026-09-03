<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentVerificationTest extends TestCase
{
    use RefreshDatabase;

    private Student $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = Student::create([
            'nis' => 'SJI-2026-888',
            'name' => 'Budi Santoso',
            'japanese_name' => 'ブディ',
            'nik' => '3301234567898888',
            'phone' => '081288776655',
            'gender' => 'L',
            'education' => 'D3 Keperawatan',
            'batch' => 'Gelombang 4 (SMILE Project)',
            'program' => 'Kaigo (Caregiver)',
            'registration_category' => 'kemenkes_kaigo',
            'sector' => 'Keperawatan Lansia',
            'status' => 'passed_user',
            'japanese_level' => 'N4',
            'total_cost' => 0,
            'paid_amount' => 0,
            'payment_scheme' => 'beasiswa_penuh',
            'payment_status' => 'paid',
            'destination_company' => 'Aoi Care Group Tokyo',
            'destination_prefecture' => 'Tokyo',
        ]);
    }

    public function test_guest_can_access_verification_page_without_code()
    {
        $response = $this->get('/verifikasi');

        $response->assertStatus(200);
        $response->assertSee('Verifikasi Keabsahan Dokumen');
        $response->assertSee('Dokumen Tidak Terverifikasi');
    }

    public function test_guest_can_verify_valid_receipt_code()
    {
        $code = 'KW-SJI-202609-' . str_pad($this->student->id, 4, '0', STR_PAD_LEFT);
        $response = $this->get("/verifikasi/{$code}");

        $response->assertStatus(200);
        $response->assertSee('DOKUMEN RESMI TERVERIFIKASI');
        $response->assertSee('Budi Santoso');
        $response->assertSee('SJI-2026-888');
        $response->assertSee('Kaigo (Caregiver)');
        $response->assertSee('Stempel Digital Resmi');
    }

    public function test_guest_can_verify_document_by_student_nis()
    {
        $response = $this->get('/verifikasi/SJI-2026-888');

        $response->assertStatus(200);
        $response->assertSee('DOKUMEN RESMI TERVERIFIKASI');
        $response->assertSee('Budi Santoso');
    }

    public function test_guest_verifying_invalid_or_fake_code_shows_unverified_alert()
    {
        $response = $this->get('/verifikasi/FAKE-CODE-UNKNOWN-999');

        $response->assertStatus(200);
        $response->assertSee('Dokumen Tidak Terverifikasi');
        $response->assertDontSee('DOKUMEN RESMI TERVERIFIKASI');
    }
}
