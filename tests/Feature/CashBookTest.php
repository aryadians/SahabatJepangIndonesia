<?php

namespace Tests\Feature;

use App\Models\CashTransaction;
use App\Models\Reimbursement;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CashBookTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_access_cash_book_index_and_view_metrics(): void
    {
        $this->actingAs($this->admin);

        // Create sample transactions
        CashTransaction::create([
            'transaction_number' => 'BKM-202609-0001',
            'transaction_date' => now()->toDateString(),
            'type' => 'income',
            'category' => 'tuition_student',
            'title' => 'Pembayaran Siswa Gelombang 1',
            'amount' => 5000000,
            'payment_method' => 'bank_mandiri',
        ]);

        CashTransaction::create([
            'transaction_number' => 'BKK-202609-0001',
            'transaction_date' => now()->toDateString(),
            'type' => 'expense',
            'category' => 'utilities',
            'title' => 'Tagihan Listrik & WiFi Asrama',
            'amount' => 750000,
            'payment_method' => 'cash_kasir',
        ]);

        $response = $this->get('/admin/cash-book');
        $response->assertOk();
        $response->assertSee('Buku Kas Umum', false);
        $response->assertSee('Jurnal Keuangan Terpusat', false);
        $response->assertSee('BKM-202609-0001');
        $response->assertSee('BKK-202609-0001');
        $response->assertSee('5.000.000');
        $response->assertSee('750.000');
        $response->assertSee('btnTopKasMasuk');
        $response->assertSee('btnTopKasKeluar');
        $response->assertSee('createTransactionModal');
        $response->assertSee('download="buku_kas_umum_lpk_sji.csv"', false);
    }

    public function test_admin_can_create_manual_income_and_expense_transactions(): void
    {
        $this->actingAs($this->admin);

        // 1. Create Income
        $dummyProof = UploadedFile::fake()->image('bukti_transfer.jpg', 600, 400);

        $incomeRes = $this->post('/admin/cash-book', [
            'type' => 'income',
            'category' => 'registration_fee',
            'title' => 'Pendaftaran 5 Calon Siswa Baru',
            'amount' => 1250000,
            'transaction_date' => now()->toDateString(),
            'payment_method' => 'bank_bca',
            'notes' => 'Pendaftaran via transfer BCA',
            'proof_file' => $dummyProof,
        ]);

        $incomeRes->assertRedirect('/admin/cash-book');
        $this->assertDatabaseHas('cash_transactions', [
            'type' => 'income',
            'category' => 'registration_fee',
            'amount' => 1250000,
        ]);

        // 2. Create Expense
        $expenseRes = $this->post('/admin/cash-book', [
            'type' => 'expense',
            'category' => 'teacher_salary',
            'title' => 'Honorarium Sensei Bahasa Jepang',
            'amount' => 3500000,
            'transaction_date' => now()->toDateString(),
            'payment_method' => 'bank_mandiri',
            'notes' => 'Gaji 2 Sensei batch 14',
        ]);

        $expenseRes->assertRedirect('/admin/cash-book');
        $this->assertDatabaseHas('cash_transactions', [
            'type' => 'expense',
            'category' => 'teacher_salary',
            'amount' => 3500000,
        ]);
    }

    public function test_admin_can_update_and_delete_cash_transaction(): void
    {
        $this->actingAs($this->admin);

        $trx = CashTransaction::create([
            'transaction_number' => 'BKM-202609-9999',
            'transaction_date' => now()->toDateString(),
            'type' => 'income',
            'category' => 'other_income',
            'title' => 'Penjualan Buku Kamus Kanji',
            'amount' => 150000,
            'payment_method' => 'cash_kasir',
        ]);

        // Update
        $updateRes = $this->put("/admin/cash-book/{$trx->id}", [
            'title' => 'Penjualan Buku Kamus Kanji & Tata Bahasa N4',
            'category' => 'other_income',
            'payment_method' => 'cash_kasir',
            'transaction_date' => now()->toDateString(),
            'notes' => 'Terjual 3 paket buku',
        ]);

        $updateRes->assertRedirect('/admin/cash-book');
        $this->assertDatabaseHas('cash_transactions', [
            'id' => $trx->id,
            'title' => 'Penjualan Buku Kamus Kanji & Tata Bahasa N4',
            'notes' => 'Terjual 3 paket buku',
        ]);

        // Delete
        $deleteRes = $this->delete("/admin/cash-book/{$trx->id}");
        $deleteRes->assertRedirect('/admin/cash-book');
        $this->assertDatabaseMissing('cash_transactions', [
            'id' => $trx->id,
        ]);
    }

    public function test_student_payment_automatically_creates_cash_book_income(): void
    {
        $this->actingAs($this->admin);

        $student = Student::create([
            'nis' => 'SJI-2026-901',
            'name' => 'Fajar Pratama',
            'gender' => 'Laki-laki',
            'total_cost' => 20000000,
            'paid_amount' => 0,
            'status' => 'active',
            'program' => 'Tokutei Ginou (SSW)',
        ]);

        // Student makes payment update
        $response = $this->post("/admin/students/{$student->id}/payment", [
            'paid_amount' => 5000000,
            'payment_notes' => 'Pembayaran termin 1 via transfer Mandiri',
        ]);

        $response->assertSessionHas('success');

        // Verify CashTransaction was automatically created
        $this->assertDatabaseHas('cash_transactions', [
            'type' => 'income',
            'category' => 'tuition_student',
            'reference_type' => 'student',
            'reference_id' => $student->id,
            'amount' => 5000000,
        ]);
    }

    public function test_disbursed_reimbursement_automatically_creates_cash_book_expense(): void
    {
        $this->actingAs($this->admin);

        $employee = Teacher::create([
            'nip' => 'STAFF-GL-01',
            'role' => 'staff',
            'name' => 'Rina Marlina',
            'gender' => 'Perempuan',
            'status' => 'active',
        ]);

        $reimbursement = Reimbursement::create([
            'teacher_id' => $employee->id,
            'employee_name' => $employee->name,
            'reimbursement_no' => 'RMB-GL-2026-001',
            'type' => 'cash_advance',
            'category' => 'transportasi',
            'title' => 'Uang Muka Perjalanan Dinas Sosialisasi BKK',
            'amount_requested' => 1200000,
            'status' => 'approved',
        ]);

        // Admin marks as paid
        $response = $this->post("/admin/reimbursements/{$reimbursement->id}/status", [
            'action' => 'pay',
        ]);

        $response->assertSessionHas('success');

        // Verify CashTransaction was automatically created
        $this->assertDatabaseHas('cash_transactions', [
            'type' => 'expense',
            'category' => 'cash_advance',
            'reference_type' => 'reimbursement',
            'reference_id' => $reimbursement->id,
            'amount' => 1200000,
        ]);

        // Employee settles with remaining money (amount spent 1.000.000, excess returned 200.000)
        $settleRes = $this->post("/admin/reimbursements/{$reimbursement->id}/status", [
            'action' => 'settle',
            'amount_spent' => 1000000,
            'settlement_notes' => 'Sisa uang 200.000 dikembalikan ke kasir',
        ]);
        $settleRes->assertSessionHas('success');

        // Verify CashTransaction for return was created
        $this->assertDatabaseHas('cash_transactions', [
            'type' => 'income',
            'category' => 'cash_advance_return',
            'reference_type' => 'reimbursement',
            'reference_id' => $reimbursement->id,
            'amount' => 200000,
        ]);
    }

    public function test_admin_can_export_cash_book_to_csv_and_pdf(): void
    {
        $this->actingAs($this->admin);

        CashTransaction::create([
            'transaction_number' => 'BKM-EXP-001',
            'transaction_date' => now()->toDateString(),
            'type' => 'income',
            'category' => 'tuition_student',
            'title' => 'Pelunasan Biaya Pelatihan Siswa',
            'amount' => 15000000,
            'payment_method' => 'bank_mandiri',
        ]);

        // 1. Export CSV
        $csvRes = $this->get('/admin/cash-book/export-csv');
        $csvRes->assertOk();
        $this->assertTrue(str_contains($csvRes->headers->get('Content-Disposition') ?? '', 'buku_kas_umum_lpk_sji_'));

        // 2. Export PDF
        $pdfRes = $this->get('/admin/cash-book/export-pdf');
        $pdfRes->assertOk();
        $pdfRes->assertSee('Buku Kas Umum', false);
        $pdfRes->assertSee('Jurnal Keuangan', false);
        $pdfRes->assertSee('BKM-EXP-001');
        $pdfRes->assertSee('15.000.000');
    }

    public function test_affiliate_commission_payout_creates_cash_book_expense(): void
    {
        $this->actingAs($this->admin);

        $affiliate = \App\Models\Affiliate::create([
            'code' => 'SMK-TEST-01',
            'name' => 'Bambang Subagio',
            'type' => 'smk_bkk',
            'institution_name' => 'SMKN 1 Majalengka',
            'phone' => '08123456789',
            'reward_per_lead' => 500000,
            'bank_name' => 'BCA',
            'bank_account_number' => '1234567890',
            'bank_account_holder' => 'Bambang Subagio',
        ]);

        // Create 2 students with this affiliate code
        Student::create([
            'nis' => 'SJI-AFF-01',
            'name' => 'Siswa Rujukan 1',
            'gender' => 'Laki-laki',
            'total_cost' => 20000000,
            'paid_amount' => 5000000,
            'status' => 'active',
            'affiliate_code' => $affiliate->code,
        ]);

        Student::create([
            'nis' => 'SJI-AFF-02',
            'name' => 'Siswa Rujukan 2',
            'gender' => 'Perempuan',
            'total_cost' => 20000000,
            'paid_amount' => 5000000,
            'status' => 'active',
            'affiliate_code' => $affiliate->code,
        ]);

        $this->assertEquals(1000000, $affiliate->total_reward_earned);
        $this->assertEquals(1000000, $affiliate->pending_commission);
        $this->assertEquals(0, $affiliate->total_paid_commission);

        // Admin dispatches commission payout
        $response = $this->post("/admin/affiliates/{$affiliate->id}/payout", [
            'amount' => 500000,
            'payment_method' => 'bank_bca',
            'payout_date' => now()->toDateString(),
            'notes' => 'Pencairan komisi 1 siswa pertama via transfer BCA',
        ]);

        $response->assertSessionHas('success');

        // Verify CashTransaction was created
        $this->assertDatabaseHas('cash_transactions', [
            'type' => 'expense',
            'category' => 'affiliate_commission',
            'reference_type' => 'affiliate',
            'reference_id' => $affiliate->id,
            'amount' => 500000,
        ]);

        // Refresh affiliate and verify updated balances
        $affiliate->refresh();
        $this->assertEquals(500000, $affiliate->total_paid_commission);
        $this->assertEquals(500000, $affiliate->pending_commission);
    }

    public function test_period_lock_prevents_updates_and_deletions_of_closed_transactions(): void
    {
        $this->actingAs($this->admin);

        $closedDate = now()->subDays(5)->toDateString();

        $trx = CashTransaction::create([
            'transaction_number' => 'BKM-LOCK-001',
            'transaction_date' => $closedDate,
            'type' => 'income',
            'category' => 'tuition_student',
            'title' => 'Pembayaran Siswa Lama',
            'amount' => 2000000,
            'payment_method' => 'bank_mandiri',
        ]);

        // Lock period up to 2 days ago
        $lockDate = now()->subDays(2)->toDateString();
        $lockRes = $this->post('/admin/cash-book/period-lock', [
            'action' => 'lock',
            'lock_date' => $lockDate,
        ]);
        $lockRes->assertSessionHas('success');

        // 1. Attempt to update locked transaction -> Should fail
        $updateRes = $this->put("/admin/cash-book/{$trx->id}", [
            'title' => 'Ganti Judul Transaksi Terkunci',
            'category' => 'tuition_student',
            'payment_method' => 'bank_mandiri',
            'transaction_date' => $closedDate,
        ]);
        $updateRes->assertSessionHas('error');
        $this->assertDatabaseMissing('cash_transactions', [
            'id' => $trx->id,
            'title' => 'Ganti Judul Transaksi Terkunci',
        ]);

        // 2. Attempt to delete locked transaction -> Should fail
        $deleteRes = $this->delete("/admin/cash-book/{$trx->id}");
        $deleteRes->assertSessionHas('error');
        $this->assertDatabaseHas('cash_transactions', [
            'id' => $trx->id,
        ]);

        // 3. Attempt to create new transaction in closed period -> Should fail
        $createRes = $this->post('/admin/cash-book', [
            'type' => 'expense',
            'category' => 'utilities',
            'title' => 'Beban Listrik Susulan',
            'amount' => 500000,
            'transaction_date' => $closedDate,
            'payment_method' => 'cash_kasir',
        ]);
        $createRes->assertSessionHas('error');

        // 4. Unlock period
        $unlockRes = $this->post('/admin/cash-book/period-lock', [
            'action' => 'unlock',
        ]);
        $unlockRes->assertSessionHas('success');

        // 5. Now delete should succeed
        $deleteSuccessRes = $this->delete("/admin/cash-book/{$trx->id}");
        $deleteSuccessRes->assertRedirect('/admin/cash-book');
        $this->assertDatabaseMissing('cash_transactions', [
            'id' => $trx->id,
        ]);
    }
}

