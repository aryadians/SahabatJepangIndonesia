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
        Schema::create('group_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. PT SJI GROUP, LPK SAHABAT JEPANG INDONESIA
            $table->string('japanese_name')->nullable(); // e.g. 株式会社 SAHABAT JAPAN AGENCY, 大心の船橋入国後研修センター
            $table->string('category_jp')->nullable(); // e.g. 特定技能送り出し機関, 技能実習送り出し機関+日本語学校, 日本語学校, 駐在員事務所, 入国後研修センター
            $table->string('category_id')->nullable(); // Indonesian descriptor
            $table->string('phone')->nullable(); // e.g. +62 889-9425-1009
            $table->string('secondary_phone')->nullable(); // e.g. 047-401-0710
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable(); // e.g. Sidoarjo, Bekasi, Karawang, Tokyo, Funabashi
            $table->string('province')->nullable(); // e.g. Jawa Timur, Jawa Barat, Tokyo, Chiba
            $table->string('country', 5)->default('ID'); // ID or JP
            $table->longText('logo_url')->nullable(); // Base64 or path
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_branches');
    }
};
