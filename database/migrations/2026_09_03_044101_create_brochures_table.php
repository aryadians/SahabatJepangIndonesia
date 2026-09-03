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
        Schema::create('brochures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('program', 100)->index();
            $table->string('badge_text', 50)->nullable();
            $table->text('description')->nullable();
            $table->longText('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_size', 50)->nullable();
            $table->integer('download_count')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brochures');
    }
};
