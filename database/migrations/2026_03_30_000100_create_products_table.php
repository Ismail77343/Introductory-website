<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('category');
            $table->string('tagline');
            $table->text('short_description');
            $table->longText('description');
            $table->string('viscosity')->nullable();
            $table->string('standard')->nullable();
            $table->string('max_diameter')->nullable();
            $table->string('operating_temperature')->nullable();
            $table->string('color')->nullable();
            $table->string('badge')->nullable();
            $table->string('accent_color')->default('orange');
            $table->string('image_url')->nullable();
            $table->string('tds_url')->nullable();
            $table->string('msds_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
