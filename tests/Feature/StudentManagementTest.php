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

    public function test_admin_can_filter_students_by_government_programs_and_view_badges(): void
    {
        // 1. Create a SMILE Project student
        $smileStudent = Student::create([
            'nis' => 'SJI-SMILE-001',
            'name' => 'Nurul Hidayah Kaigo',
            'program' => 'Tokutei Ginou (SSW)',
            'gender' => 'Perempuan',
            'status' => 'active',
            'registration_category' => 'smile_project',
            'total_cost' => 0,
            'paid_amount' => 0,
            'payment_scheme' => 'dana_talangan',
            'payment_status' => 'paid',
        ]);

        // 2. Create an SMK Go Japan student
        $smkStudent = Student::create([
            'nis' => 'SJI-SMK-001',
            'name' => 'Bagus Prayoga SMK',
            'program' => 'Ginou Jisshusei (Magang)',
            'gender' => 'Laki-laki',
            'status' => 'interview',
            'registration_category' => 'smk_go_japan',
            'total_cost' => 15000000,
            'paid_amount' => 15000000,
            'payment_scheme' => 'mandiri',
            'payment_status' => 'paid',
        ]);

        // 3. Verify badge attributes
        $this->assertEquals('SMILE Project (Kemenkes)', $smileStudent->registration_category_badge['label']);
        $this->assertEquals('SMK Go Japan', $smkStudent->registration_category_badge['label']);

        // 4. Test filtering by SMILE Project
        $filterSmile = $this->actingAs($this->admin)->get('/admin/students?registration_category=smile_project');
        $filterSmile->assertStatus(200);
        $filterSmile->assertSee('Nurul Hidayah Kaigo');
        $filterSmile->assertDontSee('Bagus Prayoga SMK');

        // 5. Test filtering by SMK Go Japan
        $filterSmk = $this->actingAs($this->admin)->get('/admin/students?registration_category=smk_go_japan');
        $filterSmk->assertStatus(200);
        $filterSmk->assertSee('Bagus Prayoga SMK');
        $filterSmk->assertDontSee('Nurul Hidayah Kaigo');
    }
}
