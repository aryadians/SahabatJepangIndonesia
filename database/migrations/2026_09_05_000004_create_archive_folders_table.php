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
        Schema::create('archive_folders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->foreignId('parent_id')->nullable()->constrained('archive_folders')->cascadeOnDelete();
            $table->string('color', 50)->default('amber');
            $table->string('created_by', 100)->nullable();
            $table->timestamps();
        });

        Schema::table('digital_archives', function (Blueprint $table) {
            $table->foreignId('folder_id')->nullable()->after('reimbursement_id')->constrained('archive_folders')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('digital_archives', function (Blueprint $table) {
            $table->dropForeign(['folder_id']);
            $table->dropColumn('folder_id');
        });

        Schema::dropIfExists('archive_folders');
    }
};
