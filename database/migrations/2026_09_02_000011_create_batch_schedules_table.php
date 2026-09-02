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
        Schema::create('batch_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('batch_name'); // e.g. "Batch 38 - Tokutei Ginou Fast Track"
            $table->string('program_type'); // Tokutei Ginou / Magang / Kelas Bahasa
            $table->date('start_date');
            $table->date('registration_deadline');
            $table->string('target_departure')->nullable(); // e.g. "Maret - April 2027"
            $table->integer('quota')->default(20);
            $table->integer('remaining_seats')->default(5);
            $table->string('status')->default('open'); // open, limited, closed
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_schedules');
    }
};
