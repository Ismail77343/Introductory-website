<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_sections', function (Blueprint $table) {
            $table->string('page')->default('home')->after('key');
        });

        Schema::table('home_section_items', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('image_url');
            $table->string('attachment_url')->nullable()->after('button_url');
            $table->string('attachment_path')->nullable()->after('attachment_url');
        });
    }

    public function down(): void
    {
        Schema::table('home_sections', function (Blueprint $table) {
            $table->dropColumn('page');
        });

        Schema::table('home_section_items', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'attachment_url', 'attachment_path']);
        });
    }
};
