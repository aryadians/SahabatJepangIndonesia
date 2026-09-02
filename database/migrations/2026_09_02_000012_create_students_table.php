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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            
            // 1. Identitas Siswa (Indexed for fast lookup)
            $table->string('nis', 50)->unique(); // e.g. SJI-2026-001
            $table->string('name');
            $table->string('japanese_name')->nullable(); // Katakana / Romaji
            $table->string('nik', 30)->nullable()->index();
            $table->string('phone', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('gender', 20)->default('Laki-laki'); // Laki-laki / Perempuan
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('education', 50)->nullable(); // SMA/SMK, D3, S1
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable()->index();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 30)->nullable();

            // 2. Data Pelatihan & Penempatan Jepang
            $table->string('batch', 100)->nullable()->index(); // e.g. Angkatan 42
            $table->string('program', 100)->default('Tokutei Ginou (SSW)')->index(); // SSW / Magang / Bahasa
            $table->string('sector', 100)->nullable(); // Kaigo, Food Processing, Pertanian, dll
            $table->date('entry_date')->nullable()->index(); // Tanggal Masuk Pelatihan
            $table->date('departure_date')->nullable()->index(); // Tanggal Terbang ke Jepang
            $table->string('destination_company')->nullable(); // Nama Kaisha di Jepang
            $table->string('destination_prefecture')->nullable(); // Tokyo, Osaka, Aichi, dll
            $table->string('status', 50)->default('active')->index(); 
            // active (Aktif Belajar), interview (Proses Wawancara), passed_interview (Lolos Wawancara), departed (Terbang di Jepang), graduated (Alumni), dropout (Keluar)

            // 3. Sertifikasi & Nilai Bahasa
            $table->string('japanese_level', 50)->nullable(); // N5, N4, N3, JFT A2
            $table->string('ssw_certificate', 150)->nullable(); // Nama Sertifikat Skill SSW
            $table->string('passport_number', 50)->nullable();
            $table->date('passport_expiry')->nullable();

            // 4. Keuangan, Biaya & Tanggungan Siswa (High Performance Finance)
            $table->decimal('total_cost', 15, 2)->default(0); // Total Biaya Pelatihan
            $table->decimal('paid_amount', 15, 2)->default(0); // Jumlah Terbayar
            $table->string('payment_scheme', 50)->default('mandiri'); // mandiri, talangan, beasiswa
            $table->string('payment_status', 50)->default('unpaid')->index(); // paid (Lunas), partial (Cicilan), unpaid (Belum Bayar), talangan (Dana Talangan)
            $table->text('payment_notes')->nullable();

            // 5. Foto & Dokumen Pribadi (Base64 LONGTEXT)
            $table->longText('photo')->nullable(); // Pasfoto 3x4
            $table->longText('document_ktp')->nullable(); // Scan KTP
            $table->longText('document_certificate')->nullable(); // Scan Sertifikat
            $table->longText('document_passport')->nullable(); // Scan Paspor

            // 6. Catatan Khusus Sensei / Admin
            $table->text('admin_notes')->nullable();

            $table->timestamps();

            // Composite indexes for fast multi-filter searching
            $table->index(['status', 'program']);
            $table->index(['payment_status', 'batch']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
