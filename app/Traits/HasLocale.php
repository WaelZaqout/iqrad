<?php

namespace App\Traits;

trait HasLocale
{
    protected function translate(string $field): ?string
    {
        $locale = app()->getLocale();
        $value = "{$field}_{$locale}";
        $fallback = "{$field}_" . ($locale === 'ar' ? 'en' : 'ar');

        return $this->$value ?? $this->$fallback ?? null;
    }
}


