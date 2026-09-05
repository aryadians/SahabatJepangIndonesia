<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reimbursements', function (Blueprint $table) {
            $table->id();

            // 1. Identifikasi Dokumen & Karyawan
            $table->string('reimbursement_no', 60)->unique()->index();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->string('employee_name', 150);
            $table->string('type', 30)->default('reimbursement')->index(); // 'reimbursement' (klaim nota) atau 'cash_advance' (uang muka dinas)
            $table->string('category', 60)->default('mou_perjalanan_dinas')->index(); // mou_perjalanan_dinas, transportasi, akomodasi_hotel, konsumsi, operasional, lainnya
            
            // 2. Rincian Perjalanan Dinas / Keperluan
            $table->string('title'); // e.g. "Perjalanan Dinas MoU Poltekkes Kemenkes & SMK Jawa Tengah"
            $table->string('destination', 150)->nullable(); // e.g. "Semarang & Solo"
            $table->date('start_date')->nullable()->index();
            $table->date('end_date')->nullable();

            // 3. Kalkulasi Nominal (Rupiah)
            $table->decimal('amount_requested', 15, 2)->default(0); // Nominal yang diajukan
            $table->decimal('amount_approved', 15, 2)->default(0);  // Nominal disetujui / uang muka dicairkan
            $table->decimal('amount_spent', 15, 2)->default(0);     // Realisasi pengeluaran aktual (settlement kasbon)
            $table->decimal('amount_diff', 15, 2)->default(0);      // Selisih: amount_spent - amount_approved

            // 4. Status Dokumen
            $table->string('status', 30)->default('submitted')->index(); // submitted, approved, paid, settled, rejected
            $table->text('notes')->nullable();

            // 5. Bukti Nota Fisik / Kuitansi Berbasis Base64 (LONGTEXT JSON Array)
            $table->longText('receipts_data')->nullable(); // [{id, title, category, amount, date, base64_image, notes}]

            // 6. Audit Trail & Tanggal Pencairan
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('settled_at')->nullable();
            $table->string('created_by', 100)->nullable();
            $table->string('approved_by', 100)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimbursements');
    }
};
