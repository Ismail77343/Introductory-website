<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithTranslatedFields;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminProductController extends Controller
{
    use InteractsWithTranslatedFields;

    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product([
                'accent_color' => 'orange',
                'category' => 'Plumbing',
                'is_active' => true,
                'is_featured' => false,
            ]),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request)
    {
        Product::query()->create($this->validatedData($request));

        return redirect()->route('admin.products.index')->with('success', 'تمت إضافة الخدمة بنجاح.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product,
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validatedData($request, $product));

        return redirect()->route('admin.products.index')->with('success', 'تم تحديث الخدمة بنجاح.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'تم حذف الخدمة بنجاح.');
    }

    protected function validatedData(Request $request, ?Product $product = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product?->id)],
            'sku' => ['required', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($product?->id)],
            'category' => ['required', 'string', 'max:100'],
            'tagline' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string'],
            'description' => ['required', 'string'],
            'viscosity' => ['nullable', 'string', 'max:255'],
            'standard' => ['nullable', 'string', 'max:255'],
            'max_diameter' => ['nullable', 'string', 'max:255'],
            'operating_temperature' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:255'],
            'accent_color' => ['required', 'string', 'max:50'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'image_path' => ['nullable', 'string', 'max:2048'],
            'image_file' => ['nullable', 'image', 'max:4096'],
            'tds_url' => ['nullable', 'url', 'max:2048'],
            'tds_path' => ['nullable', 'string', 'max:2048'],
            'tds_file' => ['nullable', 'file', 'max:10240'],
            'msds_url' => ['nullable', 'url', 'max:2048'],
            'msds_path' => ['nullable', 'string', 'max:2048'],
            'msds_file' => ['nullable', 'file', 'max:10240'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'translations' => ['nullable', 'array'],
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_featured'] = (bool) ($validated['is_featured'] ?? false);
        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        if ($request->hasFile('image_file')) {
            $validated['image_path'] = $this->storeUploadedFile($request->file('image_file'), 'products');
        }

        if ($request->hasFile('tds_file')) {
            $validated['tds_path'] = $this->storeUploadedFile($request->file('tds_file'), 'products');
        }

        if ($request->hasFile('msds_file')) {
            $validated['msds_path'] = $this->storeUploadedFile($request->file('msds_file'), 'products');
        }

        $validated = array_merge($validated, $this->extractTranslationFields($request, [
            'name',
            'category',
            'tagline',
            'short_description',
            'description',
            'viscosity',
            'standard',
            'max_diameter',
            'operating_temperature',
            'color',
            'badge',
        ], app()->getFallbackLocale()));

        return $validated;
    }

    protected function storeUploadedFile($file, string $directory): string
    {
        $relativeDirectory = public_path('uploads/'.$directory);

        if (! is_dir($relativeDirectory)) {
            mkdir($relativeDirectory, 0777, true);
        }

        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($relativeDirectory, $filename);

        return 'uploads/'.$directory.'/'.$filename;
    }
}
