<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithTranslatedFields;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    use InteractsWithTranslatedFields;

    public function index()
    {
        return view('admin.testimonials.index', [
            'testimonials' => Testimonial::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.testimonials.form', [
            'testimonial' => new Testimonial(['rating' => 5, 'is_active' => true]),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request)
    {
        Testimonial::query()->create($this->validatedData($request));

        return redirect()->route('admin.testimonials.index')->with('success', 'تمت إضافة الرأي بنجاح.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', [
            'testimonial' => $testimonial,
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $testimonial->update($this->validatedData($request));

        return redirect()->route('admin.testimonials.index')->with('success', 'تم تحديث الرأي بنجاح.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'تم حذف الرأي بنجاح.');
    }

    protected function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_title' => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'translations' => ['nullable', 'array'],
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        $validated = array_merge($validated, $this->extractTranslationFields($request, [
            'client_name',
            'client_title',
            'company_name',
            'quote',
        ], app()->getFallbackLocale()));

        return $validated;
    }
}
