<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithTranslatedFields;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminAboutSectionController extends Controller
{
    use InteractsWithTranslatedFields;

    public function index()
    {
        return view('admin.about-sections.index', [
            'sections' => HomeSection::query()->where('page', 'about')->withCount('items')->orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.about-sections.form', [
            'section' => new HomeSection(['variant' => 'cards', 'is_active' => true, 'page' => 'about']),
            'items' => [],
            'isEditing' => false,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        DB::transaction(function () use ($data) {
            $section = HomeSection::query()->create($data['section']);
            $section->items()->createMany($data['items']);
        });

        return redirect()->route('admin.about-sections.index')->with('success', 'تمت إضافة قسم صفحة من نحن بنجاح.');
    }

    public function edit(HomeSection $aboutSection)
    {
        abort_unless($aboutSection->page === 'about', 404);

        return view('admin.about-sections.form', [
            'section' => $aboutSection,
            'items' => $aboutSection->items()->orderBy('sort_order')->get()->toArray(),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, HomeSection $aboutSection)
    {
        abort_unless($aboutSection->page === 'about', 404);

        $data = $this->validatedData($request, $aboutSection);

        DB::transaction(function () use ($aboutSection, $data) {
            $aboutSection->update($data['section']);
            $aboutSection->items()->delete();
            $aboutSection->items()->createMany($data['items']);
        });

        return redirect()->route('admin.about-sections.index')->with('success', 'تم تحديث قسم صفحة من نحن بنجاح.');
    }

    public function destroy(HomeSection $aboutSection)
    {
        abort_unless($aboutSection->page === 'about', 404);
        $aboutSection->delete();

        return redirect()->route('admin.about-sections.index')->with('success', 'تم حذف القسم بنجاح.');
    }

    protected function validatedData(Request $request, ?HomeSection $section = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'key' => ['nullable', 'string', 'max:100', Rule::unique('home_sections', 'key')->ignore($section?->id)],
            'variant' => ['required', 'string', 'max:50'],
            'anchor' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'translations' => ['nullable', 'array'],
            'items' => ['nullable', 'array'],
            'items.*.title' => ['nullable', 'string', 'max:255'],
            'items.*.title_translations' => ['nullable', 'array'],
            'items.*.subtitle' => ['nullable', 'string', 'max:255'],
            'items.*.subtitle_translations' => ['nullable', 'array'],
            'items.*.description' => ['nullable', 'string'],
            'items.*.description_translations' => ['nullable', 'array'],
            'items.*.icon' => ['nullable', 'string', 'max:50'],
            'items.*.image_url' => ['nullable', 'url', 'max:2048'],
            'items.*.image_path' => ['nullable', 'string', 'max:2048'],
            'items.*.image_file' => ['nullable', 'image', 'max:4096'],
            'items.*.button_text' => ['nullable', 'string', 'max:255'],
            'items.*.button_text_translations' => ['nullable', 'array'],
            'items.*.button_url' => ['nullable', 'string', 'max:2048'],
            'items.*.attachment_url' => ['nullable', 'string', 'max:2048'],
            'items.*.attachment_path' => ['nullable', 'string', 'max:2048'],
            'items.*.attachment_file' => ['nullable', 'file', 'max:10240'],
            'items.*.metric' => ['nullable', 'string', 'max:255'],
            'items.*.metric_label' => ['nullable', 'string', 'max:255'],
            'items.*.metric_label_translations' => ['nullable', 'array'],
            'items.*.sort_order' => ['nullable', 'integer', 'min:0'],
            'items.*.is_active' => ['nullable', 'boolean'],
        ]);

        $items = collect($validated['items'] ?? [])
            ->filter(fn ($item) => ! empty($item['title']))
            ->values()
            ->map(function ($item, $index) use ($request) {
                $data = [
                    'title' => $item['title'],
                    'title_translations' => $item['title_translations'] ?? null,
                    'subtitle' => $item['subtitle'] ?? null,
                    'subtitle_translations' => $item['subtitle_translations'] ?? null,
                    'description' => $item['description'] ?? null,
                    'description_translations' => $item['description_translations'] ?? null,
                    'icon' => $item['icon'] ?? null,
                    'image_url' => $item['image_url'] ?? null,
                    'image_path' => $item['image_path'] ?? null,
                    'button_text' => $item['button_text'] ?? null,
                    'button_text_translations' => $item['button_text_translations'] ?? null,
                    'button_url' => $item['button_url'] ?? null,
                    'attachment_url' => $item['attachment_url'] ?? null,
                    'attachment_path' => $item['attachment_path'] ?? null,
                    'metric' => $item['metric'] ?? null,
                    'metric_label' => $item['metric_label'] ?? null,
                    'metric_label_translations' => $item['metric_label_translations'] ?? null,
                    'sort_order' => $item['sort_order'] ?? 0,
                    'is_active' => (bool) ($item['is_active'] ?? false),
                ];

                if ($request->file("items.$index.image_file")) {
                    $data['image_path'] = $this->storeUploadedFile($request->file("items.$index.image_file"), 'sections');
                }

                if ($request->file("items.$index.attachment_file")) {
                    $data['attachment_path'] = $this->storeUploadedFile($request->file("items.$index.attachment_file"), 'sections');
                }

                return $data;
            })
            ->all();

        return [
            'section' => [
                'title' => $validated['title'],
                'title_translations' => $this->extractTranslationFields($request, ['title'], app()->getFallbackLocale())['title_translations'] ?? null,
                'subtitle' => $validated['subtitle'] ?? null,
                'subtitle_translations' => $this->extractTranslationFields($request, ['subtitle'], app()->getFallbackLocale())['subtitle_translations'] ?? null,
                'key' => $validated['key'] ?? null,
                'page' => 'about',
                'variant' => $validated['variant'],
                'anchor' => $validated['anchor'] ?? null,
                'sort_order' => $validated['sort_order'] ?? 0,
                'is_active' => (bool) ($validated['is_active'] ?? false),
            ],
            'items' => $items,
        ];
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
