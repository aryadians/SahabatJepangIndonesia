<?php

namespace Tests\Feature;

use App\Models\DigitalArchive;
use App\Models\JobInterview;
use App\Models\Reimbursement;
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
            ]
        ]);
    }
}
