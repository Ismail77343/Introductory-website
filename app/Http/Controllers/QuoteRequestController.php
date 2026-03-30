<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuoteRequestController extends Controller
{
    public function create()
    {
        $selectedProduct = Product::query()->find(request('product'));

        return view('quotes.create', [
            'products' => Product::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'selectedProduct' => $selectedProduct,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:1'],
            'items.*.unit' => ['required', 'string', 'max:50'],
        ]);

        $products = Product::query()
            ->whereIn('id', collect($validated['items'])->pluck('product_id'))
            ->get()
            ->keyBy('id');

        DB::transaction(function () use ($validated, $products) {
            $quoteRequest = QuoteRequest::query()->create([
                'company_name' => $validated['company_name'],
                'contact_person' => $validated['contact_person'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'new',
            ]);

            foreach ($validated['items'] as $item) {
                $product = $products->get($item['product_id']);

                $quoteRequest->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'],
                ]);
            }
        });

        return redirect()
            ->route('quotes.create')
            ->with('success', 'تم استلام طلب التسعيرة بنجاح، وسيتم التواصل معكم قريبًا.');
    }
}
