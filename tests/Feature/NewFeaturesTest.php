<?php

namespace Tests\Feature;

use App\Models\Brochure;
use App\Models\Consultation;
use App\Models\InterviewCandidate;
use App\Models\JobInterview;
use App\Models\SiteSetting;
use App\Models\Student;
use App\Models\User;
use App\Services\FonnteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
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

    public function test_guest_can_access_faq_page_and_filter_by_category(): void
    {
        \App\Models\Faq::create([
            'question' => 'Bagaimana jika memiliki tato di punggung?',
            'answer' => 'Tato yang tertutup diperbolehkan selama mematuhi kaisha.',
            'category' => 'syarat_fisik',
            'order' => 1,
        ]);

        \App\Models\Faq::create([
            'question' => 'Apakah ada dana talangan biaya tanpa jaminan?',
            'answer' => 'Ya, tersedia fasilitas dana talangan dengan sistem potong gaji legal di Jepang.',
            'category' => 'biaya',
            'order' => 2,
        ]);

        // 1. Akses halaman FAQ utama
        $response = $this->get('/faq');
        $response->assertStatus(200);
        $response->assertSee('Pertanyaan yang Sering Diajukan');
        $response->assertSee('Bagaimana jika memiliki tato di punggung?');
        $response->assertSee('Apakah ada dana talangan biaya tanpa jaminan?');
        $response->assertSee('Schema.org FAQPage Structured Data', false);
        $response->assertSee('"@type": "FAQPage"', false);

        // 2. Filter kategori syarat_fisik
        $resFilter = $this->get('/faq?category=syarat_fisik');
        $resFilter->assertStatus(200);
        $resFilter->assertSee('Bagaimana jika memiliki tato di punggung?');
    }

    public function test_brochure_and_consultation_trigger_whatsapp_log_and_flow(): void
    {
        \App\Models\WhatsAppTemplate::create([
            'trigger_key' => 'brochure_download',
            'title' => 'Konfirmasi Unduh Brosur',
            'message' => 'Konnichiwa Kak {nama}! Terima kasih telah mengunduh {brosur} ({program}). Link: {link}',
            'is_active' => true,
        ]);

        \App\Models\WhatsAppTemplate::create([
            'trigger_key' => 'new_lead',
            'title' => 'Salam Sambutan Leads Baru',
            'message' => 'Konnichiwa Kak {nama}! Terima kasih telah mendaftar program {program}.',
            'is_active' => true,
        ]);

        $brochure = Brochure::create([
            'title' => 'Brosur Pelatihan Kerja SSW 2026',
            'program' => 'Tokutei Ginou (SSW)',
            'badge_text' => 'Edisi 2026',
            'description' => 'Panduan lengkap silabus',
        ]);

        // 1. Submit download brosur
        $resBrochure = $this->post('/brosur/download', [
            'name' => 'Budi Santoso',
            'phone' => '081298765432',
            'brochure_id' => $brochure->id,
            'city' => 'Semarang',
        ]);

        $resBrochure->assertRedirect();
        $resBrochure->assertSessionHas('wa_sent', true);
        $resBrochure->assertSessionHas('wa_phone', '6281298765432');

        // Pastikan WhatsAppLog tercatat
        $this->assertDatabaseHas('whatsapp_logs', [
            'recipient_phone' => '6281298765432',
            'recipient_name' => 'Budi Santoso',
            'template_key' => 'brochure_download',
            'status' => 'sent',
        ]);

        // 2. Submit konsultasi lead
        $resConsult = $this->post('/konsultasi', [
            'name' => 'Dewi Lestari',
            'phone' => '085712345678',
            'age' => 22,
            'education' => 'SMA Sederajat',
            'program' => 'Tokutei Ginou (SSW)',
            'city' => 'Yogyakarta',
        ]);

        $resConsult->assertRedirect();
        $this->assertDatabaseHas('whatsapp_logs', [
            'recipient_phone' => '6285712345678',
            'recipient_name' => 'Dewi Lestari',
            'template_key' => 'new_lead',
            'status' => 'sent',
        ]);
    }

    public function test_seo_rich_snippets_and_sitemap(): void
    {
        // 1. Periksa Sitemap XML
        $resSitemap = $this->get('/sitemap.xml');
        $resSitemap->assertStatus(200);
        $resSitemap->assertSee('/brosur');
        $resSitemap->assertSee('/faq');

        // 2. Periksa Home Schema.org Course & EducationalOrganization
        $resHome = $this->get('/');
        $resHome->assertStatus(200);
        $resHome->assertSee('"@type": "EducationalOrganization"', false);
        $resHome->assertSee('"@type": "Course"', false);
        $resHome->assertSee('Pelatihan Intensif Bahasa & Budaya Jepang', false);
    }

    public function test_admin_can_update_fonnte_settings(): void
    {
        $response = $this->actingAs($this->admin)->from('/admin/settings')->post('/admin/settings', [
            'fonnte_enabled' => '1',
            'fonnte_api_token' => 'fonnte_token_sample_12345',
            'fonnte_country_code' => '62',
        ]);

        $response->assertRedirect('/admin/settings');
        $this->assertEquals('1', SiteSetting::get('fonnte_enabled'));
        $this->assertEquals('fonnte_token_sample_12345', SiteSetting::get('fonnte_api_token'));
        $this->assertEquals('62', SiteSetting::get('fonnte_country_code'));
        $this->assertTrue(FonnteService::isConfigured());
    }

    public function test_admin_can_send_test_fonnte_message_using_fake_api(): void
    {
        Http::fake([
            'https://api.fonnte.com/send' => Http::response([
                'status' => true,
                'detail' => 'Pesan uji coba berhasil terkirim',
            ], 200),
        ]);

        SiteSetting::set('fonnte_api_token', 'test_dummy_token_999');

        $response = $this->actingAs($this->admin)->postJson('/admin/settings/test-fonnte', [
            'target_phone' => '08123456789',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Pesan uji coba berhasil terkirim',
        ]);

        $this->assertDatabaseHas('whatsapp_logs', [
            'recipient_phone' => '628123456789',
            'status' => 'sent',
            'template_key' => 'fonnte_test',
        ]);
    }

    public function test_fonnte_device_status_endpoint(): void
    {
        Http::fake([
            'https://api.fonnte.com/device' => Http::response([
                'status' => true,
                'device' => '628123456789',
                'quota' => 450,
            ], 200),
        ]);

        SiteSetting::set('fonnte_api_token', 'test_dummy_token_999');

        $response = $this->actingAs($this->admin)->getJson('/admin/settings/device-fonnte');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertEquals('628123456789', $response->json('device.device'));
    }

    public function test_brochure_and_lead_dispatch_with_fonnte_when_enabled(): void
    {
        SiteSetting::set('fonnte_enabled', '1');
        SiteSetting::set('fonnte_api_token', 'valid_token_xyz');

        Http::fake([
            'https://api.fonnte.com/send' => Http::response([
                'status' => true,
                'detail' => 'Success dispatched',
            ], 200),
        ]);

        $brochure = Brochure::create([
            'title' => 'Brosur Program Magang Manufaktur',
            'program' => 'Ginou Jisshusei (Magang)',
            'is_active' => true,
        ]);

        $resBrochure = $this->post('/brosur/download', [
            'name' => 'Faisal Rahman',
            'phone' => '081299887766',
            'brochure_id' => $brochure->id,
            'city' => 'Surabaya',
        ]);

        $resBrochure->assertRedirect();
        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.fonnte.com/send'
                && $request['target'] === '6281299887766'
                && $request->hasHeader('Authorization', 'valid_token_xyz');
        });
    }

    public function test_admin_can_update_hero_settings_and_guest_immediately_reflects_changes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // 1. Update settings with new hero headline and image via post
        $response = $this->post('/admin/settings', [
            'hero_title_1' => 'Gerbang Emas Menuju Prestasi',
            'hero_title_highlight' => 'Masa Depan Cerah di Tokyo',
            'hero_image' => 'https://images.unsplash.com/photo-1542051841857-5f90071e7989?w=900',
            'hero_motto' => 'Pusat Pelatihan Kerja Resmi Kemenaker',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // 2. Immediately access guest homepage
        $guestHome = $this->get('/');
        $guestHome->assertOk();
        $guestHome->assertSee('Gerbang Emas Menuju Prestasi');
        $guestHome->assertSee('Masa Depan Cerah di Tokyo');
        $guestHome->assertSee('https://images.unsplash.com/photo-1542051841857-5f90071e7989?w=900');
    }

    public function test_admin_can_send_student_payment_receipt_via_whatsapp(): void
    {
        SiteSetting::set('fonnte_enabled', '1', 'whatsapp');
        SiteSetting::set('fonnte_api_token', 'mock_token_sji', 'whatsapp');

        Http::fake([
            'https://api.fonnte.com/send' => Http::response(['status' => true, 'detail' => 'Pesan terkirim'], 200),
        ]);

        $student = Student::create([
            'name' => 'Kenji Pratama',
            'nis' => 'SJI-2026-9901',
            'phone' => '081299988877',
            'paid_amount' => 5000000,
            'total_cost' => 10000000,
            'program' => 'Tokutei Ginou',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/students/{$student->id}/send-receipt-wa", [
            'phone' => '081299988877',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Http::assertSent(function ($request) use ($student) {
            return $request->url() === 'https://api.fonnte.com/send'
                && $request['target'] === '6281299988877'
                && str_contains($request['message'], 'Kenji Pratama')
                && str_contains($request['message'], url('/kwitansi/' . $student->nis));
        });
    }

    public function test_admin_can_export_income_statement_pdf(): void
    {
        // Create sample income & expense transactions
        \App\Models\CashTransaction::create([
            'transaction_number' => 'BKM-202609-0001',
            'transaction_date' => now()->toDateString(),
            'type' => 'income',
            'category' => 'tuition_student',
            'title' => 'Cicilan SPP Siswa Angkatan 2026',
            'amount' => 7500000,
            'payment_method' => 'bank_mandiri',
        ]);

        \App\Models\CashTransaction::create([
            'transaction_number' => 'BKK-202609-0001',
            'transaction_date' => now()->toDateString(),
            'type' => 'expense',
            'category' => 'teacher_salary',
            'title' => 'Gaji Sensei Bahasa Jepang',
            'amount' => 4500000,
            'payment_method' => 'bank_mandiri',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/cash-book/income-statement/pdf?period=this_month');
        $response->assertStatus(200);
        $response->assertSee('LAPORAN LABA RUGI OPERASIONAL');
        $response->assertSee('Biaya Pelatihan / Cicilan Siswa');
        $response->assertSee('7.500.000');
        $response->assertSee('4.500.000');
        $response->assertSee('Laba Bersih Operasional');
    }

    public function test_admin_can_export_balance_sheet_pdf(): void
    {
        \App\Models\CashTransaction::create([
            'transaction_number' => 'BKM-202609-0002',
            'transaction_date' => now()->toDateString(),
            'type' => 'income',
            'category' => 'tuition_student',
            'title' => 'Pembayaran Tunai Kasir Siswa',
            'amount' => 2000000,
            'payment_method' => 'cash_kasir',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/cash-book/balance-sheet/pdf');
        $response->assertStatus(200);
        $response->assertSee('LAPORAN POSISI KEUANGAN / NERACA');
        $response->assertSee('Kas Tunai (Kasir Lembaga)');
        $response->assertSee('ASET LANCAR');
        $response->assertSee('SEIMBANG (BALANCED)');
    }

    public function test_admin_can_send_reimbursement_status_wa(): void
    {
        SiteSetting::set('fonnte_enabled', '1', 'whatsapp');
        SiteSetting::set('fonnte_api_token', 'mock_token_sji', 'whatsapp');

        Http::fake([
            'https://api.fonnte.com/send' => Http::response(['status' => true, 'detail' => 'Pesan terkirim'], 200),
        ]);

        $reimburse = \App\Models\Reimbursement::create([
            'reimbursement_no' => 'RMB-202609-0099',
            'employee_name' => 'Budi Santoso',
            'title' => 'Perjalanan Dinas Kunjungan Siswa',
            'type' => 'reimbursement',
            'category' => 'transport',
            'amount_requested' => 350000,
            'amount_approved' => 350000,
            'status' => 'approved',
            'date_submitted' => now()->toDateString(),
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/reimbursements/{$reimburse->id}/send-wa", [
            'phone' => '085711223344',
            'custom_notes' => 'Dana siap diambil di kasir.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.fonnte.com/send'
                && $request['target'] === '6285711223344'
                && str_contains($request['message'], 'RMB-202609-0099')
                && str_contains($request['message'], 'Telah Disetujui');
        });
    }

    public function test_admin_can_access_flight_readiness_tracker(): void
    {
        $student = Student::create([
            'name' => 'Kenjiro Sato',
            'nis' => 'SJI-2026-999',
            'program' => 'Tokutei Ginou (SSW)',
            'status' => 'ready_to_depart',
            'destination_company' => 'Yamato Logistics KK',
            'destination_prefecture' => 'Aichi',
            'total_cost' => 15000000,
            'paid_amount' => 15000000,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/flight-readiness');
        $response->assertStatus(200);
        $response->assertSee('Flight Readiness Tracker');
        $response->assertSee('Kenjiro Sato');
        $response->assertSee('Yamato Logistics KK');
        $response->assertSee('Aichi');
    }

    public function test_admin_can_update_flight_readiness_status(): void
    {
        $student = Student::create([
            'name' => 'Ahmad Fauzi',
            'nis' => 'SJI-2026-998',
            'program' => 'Ginou Jisshusei (Magang)',
            'status' => 'passed_interview',
            'total_cost' => 20000000,
            'paid_amount' => 10000000,
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/flight-readiness/{$student->id}/status", [
            'status' => 'visa_processing',
            'destination_company' => 'Honda Auto Parts Co.',
            'destination_prefecture' => 'Gunma',
            'departure_date' => '2026-11-20',
            'passport_number' => 'X9988776',
            'passport_expiry' => '2031-11-20',
            'mcu_result' => 'fit',
            'coe_number' => 'COE-JPN-88990',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'status' => 'visa_processing',
            'destination_company' => 'Honda Auto Parts Co.',
            'destination_prefecture' => 'Gunma',
            'passport_number' => 'X9988776',
            'mcu_result' => 'fit',
            'coe_number' => 'COE-JPN-88990',
        ]);
    }

    public function test_admin_can_quick_upload_flight_document(): void
    {
        $student = Student::create([
            'name' => 'Dewi Lestari',
            'nis' => 'SJI-2026-997',
            'program' => 'Tokutei Ginou (SSW)',
            'status' => 'interview',
            'total_cost' => 18000000,
            'paid_amount' => 5000000,
        ]);

        $fakeFile = \Illuminate\Http\UploadedFile::fake()->image('passport_scan.jpg', 600, 400);

        $response = $this->actingAs($this->admin)->post("/admin/flight-readiness/{$student->id}/upload-doc", [
            'doc_type' => 'passport',
            'file' => $fakeFile,
        ]);

        $response->assertRedirect();
        $student->refresh();
        $this->assertNotNull($student->document_passport);
        $this->assertStringStartsWith('data:image', $student->document_passport);

        // Digital Archive created
        $this->assertDatabaseHas('digital_archives', [
            'category' => 'dokumen_siswa',
            'file_name' => "{$student->nis}_passport.jpg",
        ]);
    }

    public function test_admin_can_export_flight_readiness_pdf(): void
    {
        Student::create([
            'name' => 'Rina Nose',
            'nis' => 'SJI-2026-996',
            'program' => 'Tokutei Ginou (SSW)',
            'status' => 'ready_to_depart',
            'destination_company' => 'Toyota Boshoku',
            'destination_prefecture' => 'Aichi',
            'total_cost' => 15000000,
            'paid_amount' => 15000000,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/flight-readiness/export-pdf');
        $response->assertStatus(200);
        $response->assertSee('DAFTAR VERIFIKASI KESIAPAN KEBERANGKATAN SISWA');
        $response->assertSee('FLIGHT READINESS DOSSIER');
        $response->assertSee('Rina Nose');
        $response->assertSee('Toyota Boshoku');
    }

    public function test_guest_can_view_public_student_receipt(): void
    {
        $student = Student::create([
            'name' => 'Bambang Sudirman',
            'nis' => 'SJI-2026-777',
            'program' => 'Tokutei Ginou (SSW)',
            'status' => 'active',
            'total_cost' => 25000000,
            'paid_amount' => 15000000,
        ]);

        \App\Models\CashTransaction::create([
            'transaction_number' => 'BKM-202609-0001',
            'transaction_date' => now()->toDateString(),
            'type' => 'income',
            'category' => 'tuition_student',
            'title' => "Pembayaran Biaya: {$student->name} ({$student->nis})",
            'amount' => 15000000,
            'reference_type' => 'student',
            'reference_id' => $student->id,
        ]);

        $response = $this->get("/kwitansi/{$student->nis}");
        $response->assertStatus(200);
        $response->assertSee('Bambang Sudirman');
        $response->assertSee('SJI-2026-777');
        $response->assertSee('BUKTI PENERIMAAN PEMBAYARAN BIAYA PENDIDIKAN');
        $response->assertSee('Terverifikasi Digital');
        $response->assertSee('15.000.000');
    }

    public function test_guest_can_track_flight_readiness_by_nis(): void
    {
        $student = Student::create([
            'name' => 'Mega Utami',
            'nis' => 'SJI-2026-778',
            'program' => 'Ginou Jisshusei (Magang)',
            'status' => 'visa_processing',
            'destination_company' => 'Hitachi Construction Machinery',
            'destination_prefecture' => 'Ibaraki',
            'coe_number' => 'COE-IBK-99001',
            'total_cost' => 20000000,
            'paid_amount' => 20000000,
        ]);

        $response = $this->get("/cek-kesiapan/{$student->nis}");
        $response->assertStatus(200);
        $response->assertSee('Mega Utami');
        $response->assertSee('Hitachi Construction Machinery');
        $response->assertSee('Ibaraki');
        $response->assertSee('Kelengkapan 8 Dokumen Keberangkatan');
        $response->assertSee('WAITING VISA');
    }

    public function test_admin_can_send_flight_readiness_document_reminder_wa(): void
    {
        SiteSetting::set('fonnte_enabled', '1', 'whatsapp');
        SiteSetting::set('fonnte_api_token', 'mock_token_sji', 'whatsapp');

        \Illuminate\Support\Facades\Http::fake([
            'https://api.fonnte.com/send' => \Illuminate\Support\Facades\Http::response(['status' => true, 'detail' => 'Pesan terkirim'], 200),
        ]);

        $student = Student::create([
            'name' => 'Fajar Pratama',
            'nis' => 'SJI-2026-779',
            'phone' => '081299887766',
            'program' => 'Tokutei Ginou (SSW)',
            'status' => 'interview',
            'total_cost' => 18000000,
            'paid_amount' => 5000000,
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/flight-readiness/{$student->id}/send-wa", [
            'phone' => '081299887766',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        \Illuminate\Support\Facades\Http::assertSent(function ($request) {
            return $request->url() === 'https://api.fonnte.com/send'
                && $request['target'] === '6281299887766'
                && str_contains($request['message'], 'Fajar Pratama')
                && str_contains($request['message'], 'SJI-2026-779')
                && str_contains($request['message'], 'LPK Sahabat Jepang Indonesia');
        });
    }

    public function test_flight_readiness_tracker_displays_expiry_alerts(): void
    {
        // Siswa dengan paspor mendekati kadaluarsa (< 6 bulan)
        Student::create([
            'name' => 'Yudi Kritis',
            'nis' => 'SJI-2026-780',
            'status' => 'ready_to_depart',
            'passport_number' => 'B1234567',
            'passport_expiry' => now()->addMonths(2)->toDateString(),
            'total_cost' => 15000000,
            'paid_amount' => 15000000,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/flight-readiness');
        $response->assertStatus(200);
        $response->assertSee('Deteksi Dini Dokumen Kritis');
        $response->assertSee('Expiry Alert Engine');
        $response->assertSee('Paspor Kritis');
        $response->assertSee('Yudi Kritis');
    }

    public function test_guest_can_access_student_status_portal_with_keyword(): void
    {
        $student = Student::create([
            'name' => 'Budi Setiawan',
            'nis' => 'SJI-2026-002',
            'program' => 'Tokutei Ginou (SSW)',
            'status' => 'active',
            'total_cost' => 20000000,
            'paid_amount' => 10000000,
        ]);

        $response = $this->get('/cek-status?keyword=SJI-2026-002');
        $response->assertStatus(200);
        $response->assertSee('Budi Setiawan');
        $response->assertSee('SJI-2026-002');
        $response->assertSee('Unduh Kwitansi');
    }

    public function test_guest_can_access_interactive_alumni_map_page(): void
    {
        $response = $this->get('/sebaran-alumni');
        $response->assertStatus(200);
        $response->assertSee('Peta Sebaran Alumni di Seluruh Jepang');
        $response->assertSee('japanSvgMap');
        $response->assertSee('日本全国就職マップ');
        $response->assertSee('Kantō');
        $response->assertSee('Chūbu');
        $response->assertSee('Kansai');
    }

    public function test_alumni_map_filters_by_sector_and_calculates_real_students(): void
    {
        $student = Student::create([
            'name' => 'Mega Puspita',
            'nis' => 'SJI-2026-999',
            'program' => 'Tokutei Ginou (SSW)',
            'sector' => 'Kaigo',
            'destination_company' => 'Tokyo Care Home Co., Ltd.',
            'destination_prefecture' => 'Tokyo',
            'status' => 'departed',
            'total_cost' => 15000000,
            'paid_amount' => 15000000,
        ]);

        $response = $this->get('/sebaran-alumni?sector=Kaigo');
        $response->assertStatus(200);
        $response->assertSee('Mega Puspita');
        $response->assertSee('Tokyo Care Home Co., Ltd.');
        $response->assertSee('Tokyo');
    }
}



