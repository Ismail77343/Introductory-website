<?php

namespace App\Models\Concerns;

trait HasTranslations
{
    public function translate(string $field, ?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        $translationsField = $field.'_translations';
        $fallbackLocale = app()->getFallbackLocale();
        $translations = $this->{$translationsField} ?? [];

        if (is_string($translations)) {
            $decoded = json_decode($translations, true);
            $translations = is_array($decoded) ? $decoded : [];
        }

        if (is_array($translations)) {
            $value = $translations[$locale]
                ?? $translations[$fallbackLocale]
                ?? collect($translations)->filter(fn ($item) => filled($item))->first();

            if (filled($value)) {
                return (string) $value;
            }
        }

        return (string) ($this->{$field} ?? '');
    }

    public function translationInput(string $field, string $locale): string
    {
        $translationsField = $field.'_translations';
        $translations = $this->{$translationsField} ?? [];

        if (is_string($translations)) {
            $decoded = json_decode($translations, true);
            $translations = is_array($decoded) ? $decoded : [];
        }

        return (string) ($translations[$locale] ?? ($locale === app()->getFallbackLocale() ? ($this->{$field} ?? '') : ''));
    }
}
