<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('theme_primary_color', 16)->nullable()->after('footer_text');
            $table->string('theme_secondary_color', 16)->nullable()->after('theme_primary_color');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['theme_primary_color', 'theme_secondary_color']);
        });
    }
};

