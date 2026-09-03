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
        Schema::table('students', function (Blueprint $table) {
            // 1. Data Medical Check-Up (MCU)
            $table->date('mcu_date')->nullable()->after('status');
            $table->string('mcu_clinic', 150)->nullable()->after('mcu_date');
            $table->string('mcu_result', 50)->nullable()->after('mcu_clinic'); // fit, unfit, pending, follow_up

            // 2. Data Dokumen COE & Visa Kerja Jepang
            $table->string('coe_number', 100)->nullable()->after('mcu_result');
            $table->date('coe_date')->nullable()->after('coe_number');
            $table->string('visa_number', 100)->nullable()->after('coe_date');
            $table->date('visa_expiry')->nullable()->after('visa_number');

            // 3. Evaluasi Akademik & Nilai Siswa
            $table->decimal('exam_score', 5, 2)->nullable()->after('japanese_level'); // Rata-rata nilai ujian 0-100
            $table->unsignedTinyInteger('attendance_percentage')->nullable()->after('exam_score'); // 0-100%
            $table->string('discipline_grade', 10)->nullable()->after('attendance_percentage'); // A, B, C, D

            // 4. Berkas Dokumen Pribadi Digital (Base64 LONGTEXT)
            $table->longText('document_kk')->nullable()->after('document_ktp');
            $table->longText('document_ijazah')->nullable()->after('document_kk');
            $table->longText('document_ssw')->nullable()->after('document_certificate');
            $table->longText('document_mcu')->nullable()->after('document_ssw');
            $table->longText('document_coe_visa')->nullable()->after('document_mcu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'mcu_date',
                'mcu_clinic',
                'mcu_result',
                'coe_number',
                'coe_date',
                'visa_number',
                'visa_expiry',
                'exam_score',
                'attendance_percentage',
                'discipline_grade',
                'document_kk',
                'document_ijazah',
                'document_ssw',
                'document_mcu',
                'document_coe_visa',
            ]);
        });
    }
};
