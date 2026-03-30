<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

trait InteractsWithTranslatedFields
{
    protected function extractTranslationFields(Request $request, array $fields, string $defaultLocale = 'ar'): array
    {
        $translations = $request->input('translations', []);
        $payload = [];

        foreach ($fields as $field) {
            $fieldTranslations = [];

            foreach ($translations as $locale => $values) {
                $value = $values[$field] ?? null;

                if (is_string($value)) {
                    $value = trim($value);
                }

                if ($value !== null && $value !== '') {
                    $fieldTranslations[$locale] = $value;
                }
            }

            if ($fieldTranslations !== []) {
                $payload[$field.'_translations'] = $fieldTranslations;
                $payload[$field] = $fieldTranslations[$defaultLocale] ?? reset($fieldTranslations);
            }
        }

        return $payload;
    }
}
