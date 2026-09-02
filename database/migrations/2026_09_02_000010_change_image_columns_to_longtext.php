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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->longText('value')->nullable()->change();
        });

        Schema::table('facilities', function (Blueprint $table) {
            $table->longText('image')->nullable()->change();
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->longText('thumbnail')->nullable()->change();
        });

        Schema::table('partners', function (Blueprint $table) {
            if (!Schema::hasColumn('partners', 'logo')) {
                $table->longText('logo')->nullable()->after('name');
            } else {
                $table->longText('logo')->nullable()->change();
            }
        });

        Schema::table('programs', function (Blueprint $table) {
            if (!Schema::hasColumn('programs', 'image')) {
                $table->longText('image')->nullable()->after('description');
            } else {
                $table->longText('image')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Keep as longtext
    }
};
