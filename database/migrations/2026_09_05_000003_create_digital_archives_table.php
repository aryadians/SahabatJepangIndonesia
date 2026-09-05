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
        Schema::create('digital_archives', function (Blueprint $table) {
            $table->id();

            // 1. Identifikasi Dokumen
            $table->string('archive_no', 60)->unique()->index();
            $table->string('title', 255);
            $table->string('category', 60)->default('nota_reimburse')->index(); 
            // nota_reimburse, kuitansi_hotel_tiket, dokumen_mou, surat_tugas, legalitas_izin, perjanjian_kaisha, lainnya

            // 2. Relasi Opsional ke Transaksi Reimburse
            $table->foreignId('reimbursement_id')->nullable()->constrained('reimbursements')->nullOnDelete();

            // 3. Metadata Berkas
            $table->string('uploader_name', 150)->nullable();
            $table->date('document_date')->nullable()->index();
            $table->string('file_name', 255)->nullable();
            $table->string('file_type', 100)->nullable(); // image/jpeg, image/png, application/pdf
            $table->string('file_size', 50)->nullable(); // e.g. "1.2 MB"

            // 4. Berkas Utama Berbasis Base64 (LONGTEXT)
            $table->longText('file_base64');

            // 5. Catatan Tambahan
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_archives');
    }
};
