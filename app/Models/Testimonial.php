<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'client_name',
        'client_name_translations',
        'client_title',
        'client_title_translations',
        'company_name',
        'company_name_translations',
        'quote',
        'quote_translations',
        'rating',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'client_name_translations' => 'array',
            'client_title_translations' => 'array',
            'company_name_translations' => 'array',
            'quote_translations' => 'array',
        ];
    }
}
