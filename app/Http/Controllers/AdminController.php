<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\HomeSection;
use App\Models\Product;
use App\Models\QuoteRequest;
use App\Models\Testimonial;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'stats' => [
                'products' => Product::query()->count(),
                'quotes' => QuoteRequest::query()->count(),
                'messages' => ContactMessage::query()->count(),
                'featured' => Product::query()->where('is_featured', true)->count(),
                'sections' => HomeSection::query()->where('page', 'home')->count(),
                'about_sections' => HomeSection::query()->where('page', 'about')->count(),
                'articles' => Article::query()->count(),
                'testimonials' => Testimonial::query()->count(),
            ],
            'recentQuotes' => QuoteRequest::query()->latest()->with('items')->take(5)->get(),
            'recentMessages' => ContactMessage::query()->latest()->take(5)->get(),
        ]);
    }
}
