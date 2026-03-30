<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithTranslatedFields;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminArticleController extends Controller
{
    use InteractsWithTranslatedFields;

    public function index()
    {
        return view('admin.articles.index', [
            'articles' => Article::query()->orderBy('sort_order')->orderByDesc('published_at')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.articles.form', [
            'article' => new Article(['is_published' => true]),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request)
    {
        Article::query()->create($this->validatedData($request));

        return redirect()->route('admin.articles.index')->with('success', 'تمت إضافة المقال بنجاح.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.form', [
            'article' => $article,
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $article->update($this->validatedData($request, $article));

        return redirect()->route('admin.articles.index')->with('success', 'تم تحديث المقال بنجاح.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'تم حذف المقال بنجاح.');
    }

    protected function validatedData(Request $request, ?Article $article = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('articles', 'slug')->ignore($article?->id)],
            'excerpt' => ['required', 'string'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'url', 'max:2048'],
            'cover_image_file' => ['nullable', 'image', 'max:4096'],
            'download_url' => ['nullable', 'url', 'max:2048'],
            'download_file' => ['nullable', 'file', 'max:10240'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
            'translations' => ['nullable', 'array'],
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_published'] = (bool) ($validated['is_published'] ?? false);

        if ($request->hasFile('cover_image_file')) {
            $validated['cover_image_path'] = $this->storeUploadedFile($request->file('cover_image_file'), 'articles');
        }

        if ($request->hasFile('download_file')) {
            $validated['download_path'] = $this->storeUploadedFile($request->file('download_file'), 'articles');
        }

        $validated = array_merge($validated, $this->extractTranslationFields($request, [
            'title',
            'excerpt',
            'body',
            'meta_title',
            'meta_description',
            'meta_keywords',
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
