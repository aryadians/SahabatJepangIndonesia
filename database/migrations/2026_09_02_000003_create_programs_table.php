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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('japanese_title')->nullable();
            $table->string('badge')->nullable();
            $table->string('badge_color')->default('bg-red-600 text-white');
            $table->string('icon')->default('briefcase');
            $table->string('salary_yen')->nullable();
            $table->string('salary_idr')->nullable();
            $table->string('duration')->nullable();
            $table->text('description')->nullable();
            $table->json('sectors')->nullable();
            $table->json('requirements')->nullable();
            $table->json('benefits')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
