<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeSectionItem extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'home_section_id',
        'title',
        'title_translations',
        'subtitle',
        'subtitle_translations',
        'description',
        'description_translations',
        'icon',
        'image_url',
        'image_path',
        'button_text',
        'button_text_translations',
        'button_url',
        'attachment_url',
        'attachment_path',
        'metric',
        'metric_label',
        'metric_label_translations',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'title_translations' => 'array',
            'subtitle_translations' => 'array',
            'description_translations' => 'array',
            'button_text_translations' => 'array',
            'metric_label_translations' => 'array',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(HomeSection::class, 'home_section_id');
    }
}
