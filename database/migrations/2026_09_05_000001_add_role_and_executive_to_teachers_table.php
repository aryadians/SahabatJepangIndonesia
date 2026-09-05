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
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('role', 50)->default('sensei')->index()->after('nip'); // ceo_owner, director, finance, operations, sensei, staff
            $table->string('position_title', 150)->nullable()->after('name'); // e.g. "Founder & Chief Executive Officer", "Direktur Operasional", "Bendahara"
            $table->string('department', 100)->nullable()->after('position_title'); // Direksi, Keuangan, Akademik, dll
            $table->boolean('is_executive')->default(false)->index()->after('status'); // true if Board of Directors / CEO / Owner
            $table->integer('order')->default(0)->index()->after('is_executive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['role', 'position_title', 'department', 'is_executive', 'order']);
        });
    }
};
