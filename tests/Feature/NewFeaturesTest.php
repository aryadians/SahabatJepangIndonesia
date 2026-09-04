<?php

namespace Tests\Feature;

use App\Models\Brochure;
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
        Brochure::create([
            'title' => 'Brosur Tokutei Ginou Kaigo 2026',
            'program' => 'Tokutei Ginou (SSW)',
            'badge_text' => 'Populer',
            'description' => 'Panduan lengkap visa SSW Kaigo',
        ]);

        $response = $this->get('/brosur');
        $response->assertStatus(200);
        $response->assertSee('Brosur Tokutei Ginou Kaigo 2026');
    }

    public function test_admin_can_manage_brochures_and_guest_downloads_selected(): void
    {
        // 1. Admin creates a new brochure
        $adminPost = $this->actingAs($this->admin)->post('/admin/brochures', [
            'title' => 'Silabus Magang Manufaktur 3 Tahun',
            'program' => 'Ginou Jisshusei (Magang)',
            'badge_text' => 'Kelas Baru',
            'description' => 'Silabus lengkap magang industri',
            'is_active' => 1,
        ]);
        $adminPost->assertRedirect('/admin/brochures');

        $brochure = Brochure::where('title', 'Silabus Magang Manufaktur 3 Tahun')->first();
        $this->assertNotNull($brochure);
        $this->assertEquals(0, $brochure->download_count);

        // 2. Guest submits lead to download this specific brochure
        $payload = [
            'name' => 'Aditya Pratama',
            'phone' => '081234567890',
            'brochure_id' => $brochure->id,
            'city' => 'Semarang',
        ];

        $response = $this->post('/brosur/download', $payload);
        $response->assertRedirect('/brosur?unlocked=true&brochure_id=' . $brochure->id);

        // Verify consultation lead recorded with brochure title
        $this->assertDatabaseHas('consultations', [
            'name' => 'Aditya Pratama',
            'phone' => '081234567890',
            'program' => 'Ginou Jisshusei (Magang)',
            'status' => 'pending',
        ]);

        // Verify brochure download count incremented
        $this->assertEquals(1, $brochure->fresh()->download_count);

        // 3. Guest can also hit the download file endpoint
        $fileResponse = $this->get('/brosur/file/' . $brochure->id);
        $fileResponse->assertStatus(302); // Redirects to preview because no physical binary was attached
        $this->assertEquals(2, $brochure->fresh()->download_count);
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

    public function test_admin_can_manage_campus_galleries(): void
    {
        // 1. Admin views index
        $indexResponse = $this->actingAs($this->admin)->get('/admin/campus-galleries');
        $indexResponse->assertStatus(200);

        // 2. Admin creates a photo slide
        $postResponse = $this->actingAs($this->admin)->post('/admin/campus-galleries', [
            'title' => 'MoU Poltekkes Kemenkes Surabaya 2026',
            'institution' => 'Poltekkes Surabaya',
            'program_tag' => 'SMILE Project',
            'badge_text' => 'MoU Resmi',
            'description' => 'Penandatanganan kerjasama penyaluran perawat Kaigo',
            'sub_text_left' => 'Poltekkes Surabaya',
            'sub_text_right' => '100% Gratis',
            'image_url' => 'https://example.com/photo.jpg',
            'order' => 1,
            'is_active' => 1,
        ]);
        $postResponse->assertRedirect('/admin/campus-galleries');

        $gallery = \App\Models\CampusGallery::where('title', 'MoU Poltekkes Kemenkes Surabaya 2026')->first();
        $this->assertNotNull($gallery);
        $this->assertTrue($gallery->is_active);

        // 3. Admin toggles active
        $toggleResponse = $this->actingAs($this->admin)->post("/admin/campus-galleries/{$gallery->id}/toggle-active");
        $this->assertFalse($gallery->fresh()->is_active);

        // 4. Admin updates
        $updateResponse = $this->actingAs($this->admin)->put("/admin/campus-galleries/{$gallery->id}", [
            'title' => 'MoU Poltekkes Kemenkes Surabaya Updated',
            'institution' => 'Poltekkes Surabaya Kampus Utama',
            'program_tag' => 'SMILE Project',
            'order' => 2,
            'is_active' => 1,
        ]);
        $updateResponse->assertRedirect('/admin/campus-galleries');
        $this->assertEquals('MoU Poltekkes Kemenkes Surabaya Updated', $gallery->fresh()->title);

        // 5. Admin creates with uploaded file
        $file = \Illuminate\Http\UploadedFile::fake()->image('mou_campus.jpg', 600, 400);
        $filePostResponse = $this->actingAs($this->admin)->post('/admin/campus-galleries', [
            'title' => 'MoU Poltekkes Semarang Gelombang 5',
            'institution' => 'Poltekkes Semarang',
            'program_tag' => 'SMILE Project',
            'badge_text' => 'MoU Baru',
            'image_file' => $file,
            'is_active' => 1,
        ]);
        $filePostResponse->assertRedirect('/admin/campus-galleries');

        $uploadedGallery = \App\Models\CampusGallery::where('title', 'MoU Poltekkes Semarang Gelombang 5')->first();
        $this->assertNotNull($uploadedGallery);
        $this->assertStringStartsWith('data:image/', $uploadedGallery->image);

        // 6. Verify it appears on homepage carousel
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('MoU Poltekkes Semarang Gelombang 5');

        // 7. Admin deletes
        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/campus-galleries/{$uploadedGallery->id}");
        $deleteResponse->assertRedirect('/admin/campus-galleries');
        $this->assertNull(\App\Models\CampusGallery::find($uploadedGallery->id));
    }

    /**
     * Test Admin can configure Social Proof Ticker and SMILE Project Poltekkes MoU Notice is Rendered
     */
    public function test_admin_can_configure_social_proof_popup_and_poltekkes_mou_notice_is_rendered(): void
    {
        // 1. Admin accesses settings page
        $settingsPage = $this->actingAs($this->admin)->get('/admin/settings');
        $settingsPage->assertStatus(200);
        $settingsPage->assertSee('Notifikasi Pop-up Aktivitas (Pojok Kiri Bawah)');

        // 2. Admin saves custom social proof ticker configuration
        $customItems = [
            [
                'icon' => '🌸',
                'title' => 'Visa Kaigo Terbit',
                'desc' => 'Alumni Poltekkes Kemenkes lolos seleksi rumah sakit Tokyo.',
                'time' => '1m lalu'
            ]
        ];

        $updateResponse = $this->actingAs($this->admin)->post('/admin/settings', [
            'popup_ticker_enabled' => '1',
            'popup_ticker_interval' => '18',
            'popup_ticker_items' => json_encode($customItems),
        ]);

        $updateResponse->assertSessionHas('success');

        // 3. Guest visits homepage and verifies config is injected
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('window.__SOCIAL_PROOF_CONFIG__', false);
        $homeResponse->assertSee('Visa Kaigo Terbit', false);
        $homeResponse->assertSee('18000', false);

        // 4. Verify Poltekkes MoU notice is present in consultation modal
        $homeResponse->assertSee('Khusus Mahasiswa & Alumni Poltekkes yang Sudah MoU', false);
        $homeResponse->assertSee('smileMouNotice', false);

        // 5. Admin disables popup ticker
        $disableResponse = $this->actingAs($this->admin)->post('/admin/settings', [
            'popup_ticker_interval' => '25',
        ]);
        $disableResponse->assertSessionHas('success');

        $homeDisabled = $this->get('/');
        $homeDisabled->assertSee('enabled: false', false);
    }

    public function test_admin_can_export_pdf_for_leads_finance_students_teachers_and_interviews_with_dynamic_logo(): void
    {
        // 1. Set dynamic custom logo in settings
        \App\Models\SiteSetting::set('site_name', 'LPK NIPPON INDONESIA JAYA');
        \App\Models\SiteSetting::set('site_logo', 'https://example.com/logo-lpk.png');

        // Create sample records
        \App\Models\Consultation::create([
            'name' => 'Kandidat Lead PDF',
            'phone' => '081299998888',
            'program' => 'Tokutei Ginou',
            'city' => 'Bandung',
            'status' => 'pending',
        ]);

        $st = Student::create([
            'nis' => 'SJI-2026-PDF01',
            'name' => 'Siswa Roster PDF',
            'gender' => 'Laki-laki',
            'program' => 'Magang Jepang',
            'status' => 'active',
            'total_cost' => 20000000,
            'paid_amount' => 5000000,
            'payment_status' => 'partial',
        ]);

        \App\Models\Teacher::create([
            'nip' => 'SENSEI-PDF-01',
            'name' => 'Yamamoto Kenji Sensei',
            'gender' => 'Laki-laki',
            'jlpt_level' => 'JLPT N1 / Native',
            'specialization' => 'Bunpou & Choukai',
            'employment_type' => 'Tetap',
            'status' => 'active',
        ]);

        $interview = JobInterview::create([
            'company_name' => 'Kanto Care Home Kaisha',
            'prefecture' => 'Kanagawa',
            'sector' => 'Kaigo / Caregiver',
            'interview_date' => now()->addDays(2),
            'location_type' => 'online',
            'quota_needed' => 2,
            'status' => 'scheduled',
        ]);

        \App\Models\InterviewCandidate::create([
            'job_interview_id' => $interview->id,
            'student_id' => $st->id,
            'result' => 'passed',
            'interview_score' => 92.5,
            'interviewer_feedback' => 'Bahasa sangat lancar dan etos kerja tinggi',
        ]);

        // 1. Test Leads Export PDF
        $resLeads = $this->actingAs($this->admin)->get('/admin/leads/export-pdf');
        $resLeads->assertStatus(200);
        $resLeads->assertSee('LAPORAN DATA KONSULTASI');
        $resLeads->assertSee('Kandidat Lead PDF');
        $resLeads->assertSee('https://example.com/logo-lpk.png');
        $resLeads->assertSee('LPK NIPPON INDONESIA JAYA');

        // 2. Test Finance Analytics Export PDF
        $resFinance = $this->actingAs($this->admin)->get('/admin/finance/export-pdf');
        $resFinance->assertStatus(200);
        $resFinance->assertSee('LAPORAN EKSEKUTIF KEUANGAN');
        $resFinance->assertSee('Proyeksi 30 Hari');
        $resFinance->assertSee('https://example.com/logo-lpk.png');

        // 3. Test Student Database Export PDF
        $resStudent = $this->actingAs($this->admin)->get('/admin/students/export-pdf');
        $resStudent->assertStatus(200);
        $resStudent->assertSee('REKAPITULASI BUKU INDUK SISWA');
        $resStudent->assertSee('Siswa Roster PDF');
        $resStudent->assertSee('SJI-2026-PDF01');
        $resStudent->assertSee('https://example.com/logo-lpk.png');

        // 4. Test Teachers Export PDF
        $resTeachers = $this->actingAs($this->admin)->get('/admin/teachers/export-pdf');
        $resTeachers->assertStatus(200);
        $resTeachers->assertSee('DAFTAR RESMI DEWAN PENGAJAR');
        $resTeachers->assertSee('Yamamoto Kenji Sensei');
        $resTeachers->assertSee('JLPT N1 / Native');
        $resTeachers->assertSee('https://example.com/logo-lpk.png');

        // 5. Test Interview History Export PDF
        $resInterviews = $this->actingAs($this->admin)->get('/admin/interviews/export-pdf');
        $resInterviews->assertStatus(200);
        $resInterviews->assertSee('LAPORAN RIWAYAT WAWANCARA KERJA');
        $resInterviews->assertSee('Kanto Care Home Kaisha');
        $resInterviews->assertSee('Siswa Roster PDF');
        $resInterviews->assertSee('92.5/100');
        $resInterviews->assertSee('https://example.com/logo-lpk.png');
    }
}
