<?php

namespace Tests\Feature;

use App\Models\Affiliate;
use App\Models\DigitalArchive;
use App\Models\JobInterview;
use App\Models\Reimbursement;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ReimbursementAndEmployeeTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_manage_employees_with_ceo_and_director_roles(): void
    {
        $this->actingAs($this->admin);

        // 1. Create CEO / Owner
        $response = $this->post('/admin/teachers', [
            'nip' => 'CEO-001',
            'role' => 'ceo_owner',
            'name' => 'Dr. H. Hendra Kusuma, M.M.',
            'position_title' => 'Founder & Chief Executive Officer',
            'department' => 'Dewan Direksi',
            'gender' => 'Laki-laki',
            'status' => 'active',
            'is_executive' => '1',
            'order' => 1,
        ]);

        $response->assertRedirect('/admin/teachers');
        $this->assertDatabaseHas('teachers', [
            'nip' => 'CEO-001',
            'role' => 'ceo_owner',
            'is_executive' => true,
        ]);

        // 2. View teachers index and filter by role
        $indexRes = $this->get('/admin/teachers?role=ceo_owner');
        $indexRes->assertOk();
        $indexRes->assertSee('Dr. H. Hendra Kusuma, M.M.');
        $indexRes->assertSee('Founder & Chief Executive Officer');
    }

    public function test_admin_can_submit_regular_reimbursement_with_base64_receipt(): void
    {
        $this->actingAs($this->admin);

        $employee = Teacher::create([
            'nip' => 'STAFF-001',
            'role' => 'staff',
            'name' => 'Faisal Rahman, S.T.',
            'gender' => 'Laki-laki',
            'status' => 'active',
        ]);

        $dummyReceipt = UploadedFile::fake()->image('tiket_kereta.jpg', 600, 400);

        $response = $this->post('/admin/reimbursements', [
            'teacher_id' => $employee->id,
            'type' => 'reimbursement',
            'category' => 'transportasi',
            'title' => 'Klaim Tiket Kereta Dinas MoU Cirebon',
            'destination' => 'Cirebon',
            'start_date' => now()->toDateString(),
            'amount_requested' => 450000,
            'receipt_files' => [$dummyReceipt],
            'receipt_titles' => ['Tiket Kereta Argo Cheribon'],
            'receipt_amounts' => [450000],
        ]);

        $response->assertRedirect('/admin/reimbursements');

        $this->assertDatabaseHas('reimbursements', [
            'teacher_id' => $employee->id,
            'type' => 'reimbursement',
            'amount_requested' => 450000,
            'status' => 'submitted',
        ]);

        // Assert that Base64 digital archive was also automatically created
        $this->assertDatabaseHas('digital_archives', [
            'category' => 'nota_reimburse',
            'uploader_name' => 'Faisal Rahman, S.T.',
        ]);
    }

    public function test_cash_advance_full_lifecycle_and_spj_settlement(): void
    {
        $this->actingAs($this->admin);

        $employee = Teacher::create([
            'nip' => 'DIR-002',
            'role' => 'director',
            'name' => 'Dewi Sartika, M.Ed.',
            'gender' => 'Perempuan',
            'status' => 'active',
        ]);

        // 1. Karyawan meminta uang muka dinas Rp 3.000.000
        $this->post('/admin/reimbursements', [
            'teacher_id' => $employee->id,
            'type' => 'cash_advance',
            'category' => 'mou_perjalanan_dinas',
            'title' => 'Uang Muka Dinas Penandatanganan MoU Poltekkes Semarang',
            'destination' => 'Semarang',
            'start_date' => now()->toDateString(),
            'amount_requested' => 3000000,
        ]);

        $reimbursement = Reimbursement::where('teacher_id', $employee->id)->first();
        $this->assertNotNull($reimbursement);
        $this->assertEquals('submitted', $reimbursement->status);

        // 2. Bendahara menyetujui Rp 3.000.000
        $this->post("/admin/reimbursements/{$reimbursement->id}/status", [
            'action' => 'approve',
            'amount_approved' => 3000000,
        ]);
        $reimbursement->refresh();
        $this->assertEquals('approved', $reimbursement->status);
        $this->assertEquals(3000000, $reimbursement->amount_approved);

        // 3. Bendahara mencairkan uang muka
        $this->post("/admin/reimbursements/{$reimbursement->id}/status", [
            'action' => 'pay',
        ]);
        $reimbursement->refresh();
        $this->assertEquals('paid', $reimbursement->status);
        $this->assertNotNull($reimbursement->paid_at);

        // 4. Setelah dinas, karyawan mengisi realisasi SPJ Rp 3.250.000 (Kurang bayar Rp 250.000)
        $dummyReceipt = UploadedFile::fake()->image('nota_hotel.jpg', 600, 400);

        $this->post("/admin/reimbursements/{$reimbursement->id}/status", [
            'action' => 'settle',
            'amount_spent' => 3250000,
            'settlement_notes' => 'Terdapat kelebihan biaya hotel Rp 250.000',
            'settlement_receipts' => [$dummyReceipt],
        ]);

        $reimbursement->refresh();
        $this->assertEquals('settled', $reimbursement->status);
        $this->assertEquals(3250000, $reimbursement->amount_spent);
        $this->assertEquals(250000, $reimbursement->amount_diff); // Kurang bayar positif
        $this->assertNotNull($reimbursement->settled_at);

        // 5. Cetak Lembar SPJ Resmi (A4)
        $printRes = $this->get("/admin/reimbursements/{$reimbursement->id}/print");
        $printRes->assertOk();
        $printRes->assertSee('SURAT PERTANGGUNGJAWABAN (SPJ) BIAYA PERJALANAN DINAS');
        $printRes->assertSee('Semarang');
        $printRes->assertSee('3.250.000');
    }

    public function test_export_and_import_reimbursements_csv_and_template(): void
    {
        $this->actingAs($this->admin);

        // 1. Download template CSV
        $templateRes = $this->get('/admin/reimbursements/template');
        $templateRes->assertOk();
        $templateRes->assertHeader('Content-Disposition', 'attachment; filename="template_reimburse_sji.csv"');

        // 2. Export CSV
        $exportRes = $this->get('/admin/reimbursements/export');
        $exportRes->assertOk();

        // 3. Export PDF
        $pdfRes = $this->get('/admin/reimbursements/export-pdf');
        $pdfRes->assertOk();
        $pdfRes->assertSee('LAPORAN REKAPITULASI KLAIM REIMBURSEMENT');

        // 4. Import CSV
        $csvContent = "\xEF\xBB\xBF" . "tipe,kategori,nama_karyawan,keperluan_dinas,kota_tujuan,tanggal_mulai,tanggal_selesai,nominal_diajukan,catatan\n" .
            "reimbursement,transportasi,Ahmad Fauzi,Dinas MoU Bandung,Bandung,2026-09-01,2026-09-02,750000,Tiket travel\n";
        
        $csvFile = UploadedFile::fake()->createWithContent('import_test.csv', $csvContent);

        $importRes = $this->post('/admin/reimbursements/import', [
            'csv_file' => $csvFile,
        ]);

        $importRes->assertRedirect('/admin/reimbursements');
        $this->assertDatabaseHas('reimbursements', [
            'employee_name' => 'Ahmad Fauzi',
            'title' => 'Dinas MoU Bandung',
            'amount_requested' => 750000,
        ]);
    }

    public function test_digital_archive_upload_and_gallery(): void
    {
        $this->actingAs($this->admin);

        $fakeDoc = UploadedFile::fake()->image('mou_stikes.jpg', 800, 600);

        $response = $this->post('/admin/digital-archives', [
            'title' => 'Scan MoU Resmi Poltekkes Kemenkes',
            'category' => 'dokumen_mou',
            'document_date' => now()->toDateString(),
            'document_file' => $fakeDoc,
            'notes' => 'Ditandatangani oleh Direktur',
        ]);

        $response->assertRedirect('/admin/digital-archives');

        $this->assertDatabaseHas('digital_archives', [
            'title' => 'Scan MoU Resmi Poltekkes Kemenkes',
            'category' => 'dokumen_mou',
        ]);

        $indexRes = $this->get('/admin/digital-archives');
        $indexRes->assertOk();
        $indexRes->assertSee('Scan MoU Resmi Poltekkes Kemenkes');
    }

    public function test_executives_and_interviews_appear_on_guest_homepage(): void
    {
        // 1. Create Executive
        Teacher::create([
            'nip' => 'EXEC-001',
            'role' => 'ceo_owner',
            'name' => 'Prof. Dr. Ir. Kenji Sastro, Ph.D.',
            'position_title' => 'Founder & Presiden Direktur',
            'gender' => 'Laki-laki',
            'status' => 'active',
            'is_executive' => true,
            'order' => 1,
            'notes' => 'Membangun jembatan karir legal Indonesia ke Jepang.',
        ]);

        // 2. Create Scheduled Kaisha Interview
        JobInterview::create([
            'company_name' => 'Osaka Precision Machinery Co.',
            'prefecture' => 'Osaka',
            'sector' => 'Manufaktur & Pengelasan Mesin',
            'interview_date' => now()->addDays(5),
            'quota_needed' => 6,
            'status' => 'scheduled',
        ]);

        // 3. Guest visits homepage
        $guestRes = $this->get('/');
        $guestRes->assertOk();

        // Should see Executive Leadership Board
        $guestRes->assertSee('Prof. Dr. Ir. Kenji Sastro, Ph.D.');
        $guestRes->assertSee('Founder &amp; Presiden Direktur', false);

        // Should see Scheduled Kaisha Interview
        $guestRes->assertSee('Osaka Precision Machinery Co.');
        $guestRes->assertSee('6 Kuota');
    }

    public function test_windows_file_explorer_ajax_endpoints(): void
    {
        $this->actingAs($this->admin);

        // 1. Create Folder
        $folderRes = $this->postJson('/admin/digital-archives/folders', [
            'name' => 'MoU Jawa Tengah 2026',
            'parent_id' => null,
            'color' => 'blue',
        ]);
        $folderRes->assertOk()->assertJson(['success' => true]);
        $folderId = $folderRes->json('folder.id');
        $this->assertDatabaseHas('archive_folders', ['name' => 'MoU Jawa Tengah 2026']);

        // 2. Rename Folder
        $renameFolderRes = $this->putJson("/admin/digital-archives/folders/{$folderId}/rename", [
            'name' => 'MoU Jawa Tengah & DIY 2026',
        ]);
        $renameFolderRes->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseHas('archive_folders', ['name' => 'MoU Jawa Tengah & DIY 2026']);

        // 3. Upload File via AJAX into Folder
        $dummyFile = UploadedFile::fake()->image('mou_smk1.jpg', 640, 480);
        $uploadRes = $this->postJson('/admin/digital-archives/upload-ajax', [
            'folder_id' => $folderId,
            'category' => 'dokumen_mou',
            'file' => $dummyFile,
        ]);
        $uploadRes->assertOk()->assertJson(['success' => true]);
        $fileId = $uploadRes->json('archive.id');
        $this->assertDatabaseHas('digital_archives', [
            'id' => $fileId,
            'folder_id' => $folderId,
            'file_name' => 'mou_smk1.jpg',
        ]);

        // 4. Explorer Data API
        $dataRes = $this->getJson("/admin/digital-archives/explorer-data?folder_id={$folderId}");
        $dataRes->assertOk()->assertJson(['success' => true]);
        $this->assertCount(1, $dataRes->json('files'));

        // 5. Rename File
        $renameFileRes = $this->putJson("/admin/digital-archives/{$fileId}/rename", [
            'title' => 'MoU Resmi SMK 1 Semarang Final',
        ]);
        $renameFileRes->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseHas('digital_archives', [
            'id' => $fileId,
            'title' => 'MoU Resmi SMK 1 Semarang Final',
        ]);

        // 6. Delete File
        $deleteFileRes = $this->deleteJson("/admin/digital-archives/{$fileId}/ajax");
        $deleteFileRes->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseMissing('digital_archives', ['id' => $fileId]);

        // 7. Delete Folder
        $delFolderRes = $this->deleteJson("/admin/digital-archives/folders/{$folderId}");
        $delFolderRes->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseMissing('archive_folders', ['id' => $folderId]);
    }

    public function test_reimbursement_and_archive_stats_endpoints(): void
    {
        $this->actingAs($this->admin);

        // Test Reimbursements Stats API
        $rmbStatsRes = $this->getJson('/admin/reimbursements/stats');
        $rmbStatsRes->assertOk()->assertJson(['success' => true]);
        $rmbStatsRes->assertJsonStructure([
            'success',
            'stats' => [
                'total_reimbursed',
                'total_reimbursed_formatted',
                'active_advances',
                'active_advances_formatted',
                'pending_count',
                'unsettled_advances_count',
                'total_transactions',
            ]
        ]);

        // Test Digital Archives Stats API
        $arcStatsRes = $this->getJson('/admin/digital-archives/stats');
        $arcStatsRes->assertOk()->assertJson(['success' => true]);
        $arcStatsRes->assertJsonStructure([
            'success',
            'stats' => [
                'total_files',
                'total_folders',
                'total_receipts',
                'total_mou',
                'total_base64_chars',
                'total_size_mb',
                'storage' => [
                    'driver',
                    'driver_label',
                    'driver_icon',
                    'used_bytes',
                    'used_formatted',
                    'free_bytes',
                    'free_formatted',
                    'total_quota_bytes',
                    'total_quota_formatted',
                    'used_percentage',
                    'free_percentage',
                ],
            ]
        ]);
    }

    public function test_reimbursement_period_filtering_and_export(): void
    {
        $this->actingAs($this->admin);

        $teacher = Teacher::create([
            'nip' => 'TCH-999',
            'role' => 'sensei',
            'name' => 'Yamada Sensei',
            'gender' => 'Laki-laki',
            'status' => 'active',
        ]);

        // Today reimbursement
        Reimbursement::create([
            'reimbursement_no' => 'RMB-TODAY-001',
            'teacher_id' => $teacher->id,
            'employee_name' => $teacher->name,
            'type' => 'reimbursement',
            'category' => 'operasional_kantor',
            'title' => 'Pengeluaran ATK Hari Ini',
            'start_date' => now()->toDateString(),
            'amount_requested' => 150000,
            'status' => 'approved',
        ]);

        // Past reimbursement (3 weeks ago)
        Reimbursement::create([
            'reimbursement_no' => 'RMB-PAST-002',
            'teacher_id' => $teacher->id,
            'employee_name' => $teacher->name,
            'type' => 'reimbursement',
            'category' => 'operasional_kantor',
            'title' => 'Pengeluaran Konsumsi 3 Minggu Lalu',
            'start_date' => now()->subWeeks(3)->toDateString(),
            'amount_requested' => 250000,
            'status' => 'approved',
        ]);

        // 1. Filter Today
        $todayRes = $this->get('/admin/reimbursements?period=today');
        $todayRes->assertOk();
        $todayRes->assertSee('RMB-TODAY-001');
        $todayRes->assertDontSee('RMB-PAST-002');

        // 2. Filter Weekly
        $weeklyRes = $this->get('/admin/reimbursements?period=weekly');
        $weeklyRes->assertOk();
        $weeklyRes->assertSee('RMB-TODAY-001');
        $weeklyRes->assertDontSee('RMB-PAST-002');

        // 3. Filter Custom Date Range
        $rangeRes = $this->get('/admin/reimbursements?date_from=' . now()->subMonth()->toDateString() . '&date_to=' . now()->toDateString());
        $rangeRes->assertOk();
        $rangeRes->assertSee('RMB-TODAY-001');
        $rangeRes->assertSee('RMB-PAST-002');

        // 4. Test Export PDF and CSV with Period Filter
        $pdfRes = $this->get(route('admin.reimbursements.export.pdf', ['period' => 'today']));
        $pdfRes->assertOk();
        $pdfRes->assertSee('RMB-TODAY-001');
        $pdfRes->assertDontSee('RMB-PAST-002');

        $csvRes = $this->get(route('admin.reimbursements.export', ['period' => 'today']));
        $csvRes->assertOk();
        $this->assertEquals('text/csv; charset=UTF-8', $csvRes->headers->get('Content-Type'));
    }

    public function test_digital_archive_storage_config_and_drivers(): void
    {
        $this->actingAs($this->admin);

        // 1. Switch to Cloud Driver with 10 GB quota (10240 MB)
        $cloudRes = $this->postJson('/admin/digital-archives/storage-config', [
            'driver' => 'cloud',
            'quota_mb' => 10240,
        ]);
        $cloudRes->assertOk()->assertJson([
            'success' => true,
            'stats' => [
                'storage' => [
                    'driver' => 'cloud',
                    'driver_icon' => 'cloud',
                ]
            ]
        ]);

        // 2. Switch to Local Server Disk Driver
        $localRes = $this->postJson('/admin/digital-archives/storage-config', [
            'driver' => 'local',
            'quota_mb' => 20480,
        ]);
        $localRes->assertOk()->assertJson([
            'success' => true,
            'stats' => [
                'storage' => [
                    'driver' => 'local',
                    'driver_icon' => 'hard-drive',
                ]
            ]
        ]);

        // 3. Switch back to Hosting Web cPanel Driver
        $hostingRes = $this->postJson('/admin/digital-archives/storage-config', [
            'driver' => 'hosting',
            'quota_mb' => 5120,
        ]);
        $hostingRes->assertOk()->assertJson([
            'success' => true,
            'stats' => [
                'storage' => [
                    'driver' => 'hosting',
                    'driver_icon' => 'server',
                ]
            ]
        ]);
    }

    public function test_admin_can_send_whatsapp_notification_for_reimbursement(): void
    {
        $this->actingAs($this->admin);

        $employee = Teacher::create([
            'nip' => 'STAFF-WA-01',
            'role' => 'staff',
            'name' => 'Budi Santoso, S.Kom.',
            'phone' => '081234567890',
            'gender' => 'Laki-laki',
            'status' => 'active',
        ]);

        $reimbursement = Reimbursement::create([
            'teacher_id' => $employee->id,
            'employee_name' => $employee->name,
            'reimbursement_no' => 'RMB-WA-2026-001',
            'type' => 'reimbursement',
            'category' => 'transportasi',
            'title' => 'Penggantian Transport Monev',
            'amount_requested' => 350000,
            'status' => 'approved',
        ]);

        $response = $this->postJson("/admin/reimbursements/{$reimbursement->id}/send-wa", [
            'notes' => 'Telah disetujui bagian keuangan, menunggu pencairan.',
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'message',
            'manual_url',
        ]);
    }

    public function test_admin_can_view_centralized_financial_analytics_with_cashflow_comparison(): void
    {
        $this->actingAs($this->admin);

        $employee = Teacher::create([
            'nip' => 'STAFF-FIN-01',
            'role' => 'staff',
            'name' => 'Finance Staff',
            'gender' => 'Laki-laki',
            'status' => 'active',
        ]);

        Reimbursement::create([
            'teacher_id' => $employee->id,
            'employee_name' => $employee->name,
            'reimbursement_no' => 'RMB-FIN-001',
            'type' => 'reimbursement',
            'category' => 'operasional',
            'title' => 'Pembelian ATK Kantor',
            'amount_requested' => 150000,
            'amount_approved' => 150000,
            'status' => 'paid',
            'disbursed_at' => now(),
        ]);

        $response = $this->get('/admin/finance');
        $response->assertOk();
        $response->assertSee('Pusat Rekapitulasi');
        $response->assertSee('Grafik Komparasi Bulanan');
        $response->assertSee('Total Kas Masuk (Inflow)');
        $response->assertSee('Total Pengeluaran (Outflow)');
        $response->assertSee('Arus Kas Bersih (Net)');
        $response->assertSee('Beban Pengeluaran');
    }

    public function test_admin_can_manage_smk_bkk_affiliates_and_view_student_progress(): void
    {
        $this->actingAs($this->admin);

        // 1. Create SMK / BKK Affiliate
        $partner = Affiliate::create([
            'code' => 'BKK-SMK-2026',
            'name' => 'Drs. Supardi (Koordinator BKK)',
            'type' => 'smk_bkk',
            'institution_name' => 'SMK Negeri 2 Indramayu',
            'phone' => '087712345678',
            'email' => 'bkk.smkn2@example.com',
            'reward_per_lead' => 500000,
            'is_active' => true,
        ]);

        $this->assertEquals('SMK & Bursa Kerja Khusus (BKK)', $partner->type_label);

        // 2. Add referred student
        $student = Student::create([
            'nis' => '2026-NIS-001',
            'name' => 'Ahmad Rizki',
            'gender' => 'Laki-laki',
            'birth_place' => 'Indramayu',
            'birth_date' => '2005-08-17',
            'phone' => '081299887766',
            'status' => 'active',
            'affiliate_code' => $partner->code,
        ]);

        // 3. Query affiliate students breakdown JSON
        $studentsRes = $this->getJson("/admin/affiliates/{$partner->id}/students");
        $studentsRes->assertOk();
        $studentsRes->assertJsonFragment([
            'name' => 'Ahmad Rizki',
        ]);

        // 4. Send WhatsApp Greeting / Progress Recap
        $waRes = $this->postJson("/admin/affiliates/{$partner->id}/send-wa", [
            'message' => 'Laporan perkembangan siswa bimbingan dari SMKN 2 Indramayu.',
        ]);
        $waRes->assertOk();
        $waRes->assertJsonStructure([
            'success',
            'message',
            'manual_url',
        ]);
    }

    public function test_admin_can_export_affiliates_to_csv_and_pdf(): void
    {
        $this->actingAs($this->admin);

        Affiliate::create([
            'code' => 'EXP-SMK-01',
            'name' => 'BKK SMK Karya Mandiri',
            'type' => 'smk_bkk',
            'institution_name' => 'SMK Karya Mandiri',
            'phone' => '089988776655',
            'reward_per_lead' => 450000,
            'is_active' => true,
        ]);

        // 1. Export CSV
        $csvRes = $this->get('/admin/affiliates/export-csv');
        $csvRes->assertOk();
        $this->assertTrue(str_contains($csvRes->headers->get('Content-Disposition') ?? '', 'rekap_kemitraan_smk_bkk_'));

        // 2. Export PDF
        $pdfRes = $this->get('/admin/affiliates/export-pdf');
        $pdfRes->assertOk();
        $pdfRes->assertSee('Rekapitulasi Kemitraan SMK & BKK', false);
        $pdfRes->assertSee('SMK Karya Mandiri');
    }
}
