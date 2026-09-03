<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentPortalTest extends TestCase
{
    use RefreshDatabase;

    private Student $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = Student::create([
            'nis' => 'SJI-2026-999',
            'name' => 'Ahmad Fathoni',
            'japanese_name' => 'ファトニ',
            'nik' => '3301234567890001',
            'phone' => '081299887766',
            'gender' => 'L',
            'birth_date' => '2001-05-15',
            'education' => 'SMK Teknik',
            'batch' => 'Angkatan 12',
            'program' => 'Tokutei Ginou (SSW)',
            'registration_category' => 'general',
            'sector' => 'Manufaktur & Mesin',
            'status' => 'training',
            'japanese_level' => 'N4',
            'attendance_percentage' => 98,
            'total_cost' => 15000000,
            'paid_amount' => 10000000,
            'payment_scheme' => 'cicilan_bertahap',
            'payment_status' => 'partial',
            'destination_company' => 'Toyota Boshoku Corp',
            'destination_prefecture' => 'Aichi',
        ]);
    }

    public function test_guest_can_access_student_portal_page()
    {
        $response = $this->get('/cek-status');

        $response->assertStatus(200);
        $response->assertSee('Cek Progres');
        $response->assertSee('Masukkan NIS');
    }

    public function test_guest_can_search_student_by_nis()
    {
        $response = $this->get('/cek-status?keyword=SJI-2026-999');

        $response->assertStatus(200);
        $response->assertSee('Ahmad Fathoni');
        $response->assertSee('ファトニ');
        $response->assertSee('SJI-2026-999');
        $response->assertSee('Toyota Boshoku Corp');
        $response->assertSee('Unduh Kwitansi');
        $response->assertSee('Unduh Invoice');
    }

    public function test_guest_can_search_student_by_phone()
    {
        $response = $this->get('/cek-status?keyword=081299887766');

        $response->assertStatus(200);
        $response->assertSee('Ahmad Fathoni');
    }

    public function test_guest_searching_non_existent_student_shows_not_found_message()
    {
        $response = $this->get('/cek-status?keyword=NONEXISTENT123');

        $response->assertStatus(200);
        $response->assertSee('Data Siswa Tidak Ditemukan');
    }

    public function test_guest_can_view_official_public_receipt_by_nis()
    {
        $response = $this->get('/kwitansi/SJI-2026-999');

        $response->assertStatus(200);
        $response->assertSee('Kwitansi Pembayaran Resmi');
        $response->assertSee('Ahmad Fathoni');
        $response->assertSee('SJI-2026-999');
        $response->assertSee('Rp 10.000.000');
    }

    public function test_guest_can_view_official_public_invoice_by_nis()
    {
        $response = $this->get('/invoice/SJI-2026-999');

        $response->assertStatus(200);
        $response->assertSee('INVOICE TAGIHAN');
        $response->assertSee('Ahmad Fathoni');
        $response->assertSee('Rp 5.000.000');
    }
}
