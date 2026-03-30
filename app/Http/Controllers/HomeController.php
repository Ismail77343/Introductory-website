<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\HomeSection;
use App\Models\Product;
use App\Models\QuoteRequest;
use App\Models\SiteSetting;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $sections = HomeSection::query()
            ->where('page', 'home')
            ->where('is_active', true)
            ->with(['items' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return view('home', [
            'heroSection' => $sections->firstWhere('key', 'hero'),
            'dynamicSections' => $sections->reject(fn ($section) => $section->key === 'hero'),
            'featuredProducts' => Product::query()
                ->where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('sort_order')
                ->take(4)
                ->get(),
            'articles' => Article::query()
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderByDesc('published_at')
                ->take(3)
                ->get(),
            'testimonials' => Testimonial::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
            'siteInfo' => SiteSetting::query()->first(),
            'stats' => [
                'products' => Product::query()->where('is_active', true)->count(),
                'quotes' => QuoteRequest::query()->count(),
                'messages' => ContactMessage::query()->count(),
            ],
        ]);
    }
}
