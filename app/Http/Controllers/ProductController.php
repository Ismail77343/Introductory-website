<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $products = $products
            ->when($request->string('category')->isNotEmpty(), function ($collection) use ($request) {
                $category = (string) $request->string('category');
                return $collection->filter(fn ($product) => $product->translate('category') === $category);
            })
            ->when($request->string('search')->isNotEmpty(), function ($collection) use ($request) {
                $search = mb_strtolower((string) $request->string('search'));
                return $collection->filter(function ($product) use ($search) {
                    return str_contains(mb_strtolower($product->translate('name')), $search)
                        || str_contains(mb_strtolower($product->sku), $search)
                        || str_contains(mb_strtolower($product->translate('tagline')), $search);
                });
            })
            ->values();

        return view('products.index', [
            'products' => $products,
            'categories' => Product::query()->where('is_active', true)->orderBy('sort_order')->get()->map(fn ($product) => $product->translate('category'))->filter()->unique()->values(),
            'filters' => $request->only(['category', 'search']),
        ]);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => Product::query()
                ->where('is_active', true)
                ->where('id', '!=', $product->id)
                ->where('category', $product->category)
                ->orderBy('sort_order')
                ->take(3)
                ->get(),
        ]);
    }
}
