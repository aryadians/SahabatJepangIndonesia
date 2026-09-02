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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            // 1. Identitas Sensei / Pengajar
            $table->string('nip', 50)->unique(); // Kode Sensei, e.g. SNS-001
            $table->string('name');
            $table->string('romaji_name')->nullable(); // e.g. "Budi Sensei"
            $table->string('phone', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('gender', 20)->default('Laki-laki');
            $table->date('join_date')->nullable()->index();

            // 2. Kualifikasi & Sertifikasi Bahasa Jepang
            $table->string('jlpt_level', 20)->default('N2')->index(); // N1, N2, N3
            $table->string('japan_experience', 255)->nullable(); // e.g. "Ex-Ginou Jisshusei Toyota Aichi (3 Tahun)"
            $table->string('specialization', 255)->default('Bunpou & Kaiwa'); // Tata Bahasa, Percakapan, Kaigo, Horenso
            $table->string('employment_type', 50)->default('full_time'); // full_time, part_time, native

            // 3. Status Keaktifan
            $table->string('status', 30)->default('active')->index(); // active, leave, inactive

            // 4. Media & Foto Profil (Base64 LONGTEXT)
            $table->longText('photo')->nullable();
            $table->longText('document_certificate')->nullable(); // Scan Sertifikat JLPT/Ijazah

            // 5. Catatan
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
