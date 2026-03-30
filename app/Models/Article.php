<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'title',
        'title_translations',
        'slug',
        'excerpt',
        'excerpt_translations',
        'body',
        'body_translations',
        'cover_image',
        'cover_image_path',
        'download_url',
        'download_path',
        'meta_title',
        'meta_title_translations',
        'meta_description',
        'meta_description_translations',
        'meta_keywords',
        'meta_keywords_translations',
        'is_published',
        'published_at',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'title_translations' => 'array',
            'excerpt_translations' => 'array',
            'body_translations' => 'array',
            'meta_title_translations' => 'array',
            'meta_description_translations' => 'array',
            'meta_keywords_translations' => 'array',
        ];
    }
}
