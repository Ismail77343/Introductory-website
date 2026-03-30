<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('logo_url');
            $table->string('map_embed_url')->nullable()->after('contact_address');
            $table->string('default_article_image_url')->nullable()->after('footer_text');
            $table->string('default_article_image_path')->nullable()->after('default_article_image_url');
            $table->string('default_meta_title')->nullable()->after('default_article_image_path');
            $table->text('default_meta_description')->nullable()->after('default_meta_title');
            $table->text('default_meta_keywords')->nullable()->after('default_meta_description');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->string('cover_image_path')->nullable()->after('cover_image');
            $table->string('download_path')->nullable()->after('download_url');
            $table->string('meta_title')->nullable()->after('download_path');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->text('meta_keywords')->nullable()->after('meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'logo_path',
                'map_embed_url',
                'default_article_image_url',
                'default_article_image_path',
                'default_meta_title',
                'default_meta_description',
                'default_meta_keywords',
            ]);
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'cover_image_path',
                'download_path',
                'meta_title',
                'meta_description',
                'meta_keywords',
            ]);
        });
    }
};
