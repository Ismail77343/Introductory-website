<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view): void {
            $settings = null;
            $languages = collect();
            $currentLanguage = null;

            if (Schema::hasTable('site_settings')) {
                $settings = SiteSetting::query()->first();
            }

            if (Schema::hasTable('languages')) {
                $languages = Language::query()->where('is_active', true)->orderBy('sort_order')->get();
                $currentLanguage = $languages->firstWhere('code', app()->getLocale()) ?? $languages->firstWhere('is_default', true);
            }

            $view->with([
                'siteSettings' => $settings,
                'activeLanguages' => $languages,
                'currentLanguage' => $currentLanguage,
            ]);
        });
    }
}
