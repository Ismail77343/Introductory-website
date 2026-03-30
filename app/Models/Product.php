<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'name',
        'name_translations',
        'slug',
        'sku',
        'category',
        'category_translations',
        'tagline',
        'tagline_translations',
        'short_description',
        'short_description_translations',
        'description',
        'description_translations',
        'viscosity',
        'viscosity_translations',
        'standard',
        'standard_translations',
        'max_diameter',
        'max_diameter_translations',
        'operating_temperature',
        'operating_temperature_translations',
        'color',
        'color_translations',
        'badge',
        'badge_translations',
        'accent_color',
        'image_url',
        'image_path',
        'tds_url',
        'tds_path',
        'msds_url',
        'msds_path',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'name_translations' => 'array',
            'category_translations' => 'array',
            'tagline_translations' => 'array',
            'short_description_translations' => 'array',
            'description_translations' => 'array',
            'viscosity_translations' => 'array',
            'standard_translations' => 'array',
            'max_diameter_translations' => 'array',
            'operating_temperature_translations' => 'array',
            'color_translations' => 'array',
            'badge_translations' => 'array',
        ];
    }

    public function quoteItems(): HasMany
    {
        return $this->hasMany(QuoteRequestItem::class);
    }
}
