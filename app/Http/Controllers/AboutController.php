<?php

namespace App\Http\Controllers;

use App\Models\HomeSection;

class AboutController extends Controller
{
    public function index()
    {
        return view('about.index', [
            'sections' => HomeSection::query()
                ->where('page', 'about')
                ->where('is_active', true)
                ->with(['items' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order')])
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
