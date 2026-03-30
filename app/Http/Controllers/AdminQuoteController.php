<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;

class AdminQuoteController extends Controller
{
    public function index()
    {
        return view('admin.quotes.index', [
            'quotes' => QuoteRequest::query()->with('items')->latest()->get(),
        ]);
    }
}
