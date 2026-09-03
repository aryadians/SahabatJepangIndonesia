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
        Schema::create('job_interviews', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('japanese_company_name')->nullable();
            $table->string('prefecture', 100);
            $table->string('sector', 100);
            $table->dateTime('interview_date');
            $table->string('location_type', 30)->default('online'); // online / offline
            $table->string('meeting_link')->nullable();
            $table->string('meeting_passcode', 100)->nullable();
            $table->integer('quota_needed')->default(1);
            $table->string('salary_range', 100)->nullable();
            $table->string('status', 30)->default('scheduled'); // scheduled, ongoing, completed, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('interview_candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_interview_id')->constrained('job_interviews')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('result', 30)->default('pending'); // pending, passed, failed, rescheduled
            $table->decimal('interview_score', 4, 1)->nullable();
            $table->text('interviewer_feedback')->nullable();
            $table->timestamps();

            $table->unique(['job_interview_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_candidates');
        Schema::dropIfExists('job_interviews');
    }
};
