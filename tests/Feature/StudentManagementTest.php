<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'testadmin@example.com',
        ]);
    }

    public function test_guest_cannot_access_students_database(): void
    {
        $response = $this->get('/admin/students');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_students_index(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/students');
        $response->assertStatus(200);
        $response->assertSee('Database Siswa');
    }

    public function test_admin_can_fetch_student_quick_detail_json(): void
    {
        $student = Student::first();
        if (!$student) {
            $student = Student::create([
                'nis' => 'SJI-TEST-001',
                'name' => 'Testing Student',
                'program' => 'Tokutei Ginou (SSW)',
                'gender' => 'Laki-laki',
                'status' => 'active',
                'total_cost' => 25000000,
                'paid_amount' => 10000000,
                'payment_scheme' => 'mandiri',
                'payment_status' => 'partial',
            ]);
        }

        $response = $this->actingAs($this->admin)->getJson("/admin/students/{$student->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'student' => ['id', 'nis', 'name', 'program'],
            'remaining_balance',
            'formatted_total_cost',
            'formatted_paid_amount',
            'mcu_label',
            'uploaded_docs_count',
        ]);
    }

    public function test_admin_can_download_csv_template(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/students/template');
        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition', 'attachment; filename=Template_Import_Siswa_LPK_SJI.csv');
    }

    public function test_admin_can_export_students_database_csv(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/students/export');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    public function test_admin_can_import_students_csv(): void
    {
        $csv = "NIS,Nama Lengkap,Program,Jenis Kelamin,Total Biaya,Sudah Bayar,Skema Biaya\n";
        $csv .= "SJI-IMPORT-099,Siswa Hasil Import,Tokutei Ginou (SSW),Laki-laki,25000000,25000000,mandiri\n";

        $tempPath = tempnam(sys_get_temp_dir(), 'csv_test');
        file_put_contents($tempPath, $csv);

        $file = new UploadedFile($tempPath, 'students_test.csv', 'text/csv', null, true);

        $response = $this->actingAs($this->admin)->post('/admin/students/import', [
            'csv_file' => $file,
        ]);

        $response->assertRedirect('/admin/students');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'nis' => 'SJI-IMPORT-099',
            'name' => 'Siswa Hasil Import',
        ]);

        // Clean up
        Student::where('nis', 'SJI-IMPORT-099')->delete();
        @unlink($tempPath);
    }
}
