<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->json('site_name_translations')->nullable()->after('site_name');
            $table->json('site_tagline_translations')->nullable()->after('site_tagline');
            $table->json('contact_address_translations')->nullable()->after('contact_address');
            $table->json('vision_translations')->nullable()->after('vision');
            $table->json('mission_translations')->nullable()->after('mission');
            $table->json('about_text_translations')->nullable()->after('about_text');
            $table->json('footer_text_translations')->nullable()->after('footer_text');
            $table->json('default_meta_title_translations')->nullable()->after('default_meta_title');
            $table->json('default_meta_description_translations')->nullable()->after('default_meta_description');
            $table->json('default_meta_keywords_translations')->nullable()->after('default_meta_keywords');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->json('name_translations')->nullable()->after('name');
            $table->json('category_translations')->nullable()->after('category');
            $table->json('tagline_translations')->nullable()->after('tagline');
            $table->json('short_description_translations')->nullable()->after('short_description');
            $table->json('description_translations')->nullable()->after('description');
            $table->json('viscosity_translations')->nullable()->after('viscosity');
            $table->json('standard_translations')->nullable()->after('standard');
            $table->json('max_diameter_translations')->nullable()->after('max_diameter');
            $table->json('operating_temperature_translations')->nullable()->after('operating_temperature');
            $table->json('color_translations')->nullable()->after('color');
            $table->json('badge_translations')->nullable()->after('badge');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->json('title_translations')->nullable()->after('title');
            $table->json('excerpt_translations')->nullable()->after('excerpt');
            $table->json('body_translations')->nullable()->after('body');
            $table->json('meta_title_translations')->nullable()->after('meta_title');
            $table->json('meta_description_translations')->nullable()->after('meta_description');
            $table->json('meta_keywords_translations')->nullable()->after('meta_keywords');
        });

        Schema::table('home_sections', function (Blueprint $table) {
            $table->json('title_translations')->nullable()->after('title');
            $table->json('subtitle_translations')->nullable()->after('subtitle');
        });

        Schema::table('home_section_items', function (Blueprint $table) {
            $table->json('title_translations')->nullable()->after('title');
            $table->json('subtitle_translations')->nullable()->after('subtitle');
            $table->json('description_translations')->nullable()->after('description');
            $table->json('button_text_translations')->nullable()->after('button_text');
            $table->json('metric_label_translations')->nullable()->after('metric_label');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->json('client_name_translations')->nullable()->after('client_name');
            $table->json('client_title_translations')->nullable()->after('client_title');
            $table->json('company_name_translations')->nullable()->after('company_name');
            $table->json('quote_translations')->nullable()->after('quote');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'site_name_translations',
                'site_tagline_translations',
                'contact_address_translations',
                'vision_translations',
                'mission_translations',
                'about_text_translations',
                'footer_text_translations',
                'default_meta_title_translations',
                'default_meta_description_translations',
                'default_meta_keywords_translations',
            ]);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'name_translations',
                'category_translations',
                'tagline_translations',
                'short_description_translations',
                'description_translations',
                'viscosity_translations',
                'standard_translations',
                'max_diameter_translations',
                'operating_temperature_translations',
                'color_translations',
                'badge_translations',
            ]);
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'title_translations',
                'excerpt_translations',
                'body_translations',
                'meta_title_translations',
                'meta_description_translations',
                'meta_keywords_translations',
            ]);
        });

        Schema::table('home_sections', function (Blueprint $table) {
            $table->dropColumn(['title_translations', 'subtitle_translations']);
        });

        Schema::table('home_section_items', function (Blueprint $table) {
            $table->dropColumn([
                'title_translations',
                'subtitle_translations',
                'description_translations',
                'button_text_translations',
                'metric_label_translations',
            ]);
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn([
                'client_name_translations',
                'client_title_translations',
                'company_name_translations',
                'quote_translations',
            ]);
        });
    }
};
