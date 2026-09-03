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
        Schema::create('campus_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('institution')->nullable(); // e.g. Poltekkes Semarang, SMK 1 Surabaya
            $table->string('program_tag')->default('MoU Kampus'); // SMILE Project, SMK Go Japan, MoU Kampus, dll
            $table->string('badge_text')->nullable(); // Penandatanganan MoU, Campus Job Fair
            $table->text('description')->nullable();
            $table->string('sub_text_left')->nullable(); // e.g. Program Beasiswa Kemenkes
            $table->string('sub_text_right')->nullable(); // e.g. Resmi Terverifikasi
            $table->longText('image'); // Base64 data URI or image URL
            $table->integer('order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campus_galleries');
    }
};
