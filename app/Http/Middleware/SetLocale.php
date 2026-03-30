<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $defaultLocale = 'ar';
        $activeCodes = ['ar', 'en'];

        if (class_exists(Language::class) && \Illuminate\Support\Facades\Schema::hasTable('languages')) {
            $languages = Language::query()->where('is_active', true)->orderBy('sort_order')->get();
            $activeCodes = $languages->pluck('code')->all();
            $defaultLocale = $languages->firstWhere('is_default', true)?->code
                ?? $languages->first()?->code
                ?? $defaultLocale;
        }

        $locale = $request->session()->get('locale', $defaultLocale);

        if (! in_array($locale, $activeCodes, true)) {
            $locale = $defaultLocale;
        }

        App::setLocale($locale);
        App::setFallbackLocale($defaultLocale);

        return $next($request);
    }
}
