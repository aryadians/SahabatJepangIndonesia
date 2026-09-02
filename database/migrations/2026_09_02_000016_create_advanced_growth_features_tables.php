<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Bank Soal Ujian JLPT & JFT CBT Simulator
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->string('level', 20)->default('N5'); // 'N5', 'N4', 'N3', 'JFT-Basic'
            $table->string('section', 50)->default('Kotoba'); // 'Kotoba' (Kosakata), 'Bunpou' (Tata Bahasa), 'Dokkai' (Membaca), 'Kanji'
            $table->text('question');
            $table->string('question_japanese')->nullable();
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->string('correct_answer', 1); // 'A', 'B', 'C', 'D'
            $table->text('explanation')->nullable(); // Pembahasan
            $table->integer('points')->default(10);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. WhatsApp Gateway & CRM Templates
        Schema::create('whatsapp_templates', function (Blueprint $table) {
            $table->id();
            $table->string('trigger_key', 50)->unique(); // 'new_lead', 'payment_receipt', 'due_reminder', 'interview_invite', 'departure_congrats'
            $table->string('title');
            $table->text('message');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. WhatsApp Logs
        Schema::create('whatsapp_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_phone', 50);
            $table->string('recipient_name')->nullable();
            $table->string('template_key', 50)->nullable();
            $table->text('message_body');
            $table->string('status', 30)->default('sent'); // 'sent', 'delivered', 'failed'
            $table->timestamps();
        });

        // 4. Mitra Sekolah & Program Referral / Afiliasi
        Schema::create('affiliates', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique(); // e.g. 'SMK1JKT', 'ALUMNI-BUDI'
            $table->string('name');
            $table->string('type', 30)->default('sekolah'); // 'sekolah', 'guru_bk', 'alumni', 'komunitas'
            $table->string('institution_name')->nullable(); // Nama SMK / Kampus / Organisasi
            $table->string('phone', 50);
            $table->string('email')->nullable();
            $table->string('bank_name', 50)->nullable();
            $table->string('bank_account_number', 50)->nullable();
            $table->string('bank_account_holder')->nullable();
            $table->decimal('reward_per_lead', 12, 2)->default(500000); // Komisi per siswa enrolled
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Tambah kolom affiliate_code ke consultations & students
        Schema::table('consultations', function (Blueprint $table) {
            if (!Schema::hasColumn('consultations', 'affiliate_code')) {
                $table->string('affiliate_code', 50)->nullable()->after('status');
            }
        });

        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'affiliate_code')) {
                $table->string('affiliate_code', 50)->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
        Schema::dropIfExists('whatsapp_templates');
        Schema::dropIfExists('whatsapp_logs');
        Schema::dropIfExists('affiliates');
        
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn('affiliate_code');
        });
        
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('affiliate_code');
        });
    }
};
