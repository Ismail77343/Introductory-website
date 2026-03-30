<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminLanguageController extends Controller
{
    public function index()
    {
        return view('admin.languages.index', [
            'languages' => Language::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.languages.form', [
            'language' => new Language(['direction' => 'rtl', 'is_active' => true]),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $this->applyDefaultFlag($data);

        Language::query()->create($data);

        return redirect()->route('admin.languages.index')->with('success', 'تمت إضافة اللغة بنجاح.');
    }

    public function edit(Language $language)
    {
        return view('admin.languages.form', [
            'language' => $language,
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, Language $language)
    {
        $data = $this->validatedData($request, $language);
        $this->applyDefaultFlag($data, $language);

        $language->update($data);

        return redirect()->route('admin.languages.index')->with('success', 'تم تحديث اللغة بنجاح.');
    }

    public function destroy(Language $language)
    {
        if ($language->is_default) {
            return redirect()->route('admin.languages.index')->with('success', 'لا يمكن حذف اللغة الافتراضية.');
        }

        $language->delete();

        return redirect()->route('admin.languages.index')->with('success', 'تم حذف اللغة بنجاح.');
    }

    protected function validatedData(Request $request, ?Language $language = null): array
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:10', Rule::unique('languages', 'code')->ignore($language?->id)],
            'name' => ['required', 'string', 'max:255'],
            'native_name' => ['required', 'string', 'max:255'],
            'direction' => ['required', Rule::in(['rtl', 'ltr'])],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);
        $validated['is_default'] = (bool) ($validated['is_default'] ?? false);

        return $validated;
    }

    protected function applyDefaultFlag(array $data, ?Language $language = null): void
    {
        if (! $data['is_default']) {
            return;
        }

        Language::query()
            ->when($language, fn ($query) => $query->where('id', '!=', $language->id))
            ->update(['is_default' => false]);
    }
}
