<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'site_name',
        'site_name_translations',
        'site_tagline',
        'site_tagline_translations',
        'logo_url',
        'logo_path',
        'contact_email',
        'contact_phone',
        'contact_address',
        'contact_address_translations',
        'map_embed_url',
        'whatsapp_number',
        'vision',
        'vision_translations',
        'mission',
        'mission_translations',
        'about_text',
        'about_text_translations',
        'footer_text',
        'footer_text_translations',
        'default_article_image_url',
        'default_article_image_path',
        'default_meta_title',
        'default_meta_title_translations',
        'default_meta_description',
        'default_meta_description_translations',
        'default_meta_keywords',
        'default_meta_keywords_translations',
        'theme_primary_color',
        'theme_secondary_color',
    ];

    protected function casts(): array
    {
        return [
            'site_name_translations' => 'array',
            'site_tagline_translations' => 'array',
            'contact_address_translations' => 'array',
            'vision_translations' => 'array',
            'mission_translations' => 'array',
            'about_text_translations' => 'array',
            'footer_text_translations' => 'array',
            'default_meta_title_translations' => 'array',
            'default_meta_description_translations' => 'array',
            'default_meta_keywords_translations' => 'array',
        ];
    }
}
