<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HomeSection extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'key',
        'page',
        'title',
        'title_translations',
        'subtitle',
        'subtitle_translations',
        'variant',
        'anchor',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'title_translations' => 'array',
            'subtitle_translations' => 'array',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(HomeSectionItem::class)->orderBy('sort_order');
    }
}
