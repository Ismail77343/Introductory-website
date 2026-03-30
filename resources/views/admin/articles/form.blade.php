@extends('layouts.admin', ['title' => $isEditing ? 'تعديل مقال' : 'إضافة مقال'])

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 lg:p-8">
            <h1 class="text-4xl font-black text-white">{{ $isEditing ? 'تعديل مقال' : 'إضافة مقال جديد' }}</h1>

            <form method="POST" action="{{ $isEditing ? route('admin.articles.update', $article) : route('admin.articles.store') }}" enctype="multipart/form-data" class="mt-8 grid gap-5 md:grid-cols-2">
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif

                <div><label class="mb-2 block text-sm text-slate-300">العنوان الأساسي</label><input type="text" name="title" value="{{ old('title', $article->title) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">Slug</label><input type="text" name="slug" value="{{ old('slug', $article->slug) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">ملخص أساسي</label><textarea name="excerpt" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old('excerpt', $article->excerpt) }}</textarea></div>
                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">المحتوى الأساسي</label><textarea name="body" rows="8" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old('body', $article->body) }}</textarea></div>
                <div><label class="mb-2 block text-sm text-slate-300">رابط صورة الغلاف</label><input type="url" name="cover_image" value="{{ old('cover_image', $article->cover_image) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">رفع صورة الغلاف</label><input type="file" name="cover_image_file" accept="image/*" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">رابط ملف التنزيل</label><input type="url" name="download_url" value="{{ old('download_url', $article->download_url) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">رفع ملف مرفق</label><input type="file" name="download_file" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">تاريخ النشر</label><input type="datetime-local" name="published_at" value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">الترتيب</label><input type="number" name="sort_order" value="{{ old('sort_order', $article->sort_order) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">Meta Title الأساسي</label><input type="text" name="meta_title" value="{{ old('meta_title', $article->meta_title) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">Meta Keywords الأساسية</label><input type="text" name="meta_keywords" value="{{ old('meta_keywords', $article->meta_keywords) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">Meta Description الأساسية</label><textarea name="meta_description" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old('meta_description', $article->meta_description) }}</textarea></div>

                <div class="md:col-span-2 space-y-6">
                    @foreach ($activeLanguages as $language)
                        <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/60 p-5">
                            <h2 class="text-2xl font-black text-amber-300">{{ $language->native_name }} ({{ strtoupper($language->code) }})</h2>
                            <div class="mt-5 grid gap-5 md:grid-cols-2">
                                <div><label class="mb-2 block text-sm text-slate-300">العنوان</label><input type="text" name="translations[{{ $language->code }}][title]" value="{{ old("translations.{$language->code}.title", $article->translationInput('title', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div><label class="mb-2 block text-sm text-slate-300">Meta Title</label><input type="text" name="translations[{{ $language->code }}][meta_title]" value="{{ old("translations.{$language->code}.meta_title", $article->translationInput('meta_title', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">ملخص</label><textarea name="translations[{{ $language->code }}][excerpt]" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.excerpt", $article->translationInput('excerpt', $language->code)) }}</textarea></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">المحتوى</label><textarea name="translations[{{ $language->code }}][body]" rows="6" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.body", $article->translationInput('body', $language->code)) }}</textarea></div>
                                <div><label class="mb-2 block text-sm text-slate-300">Meta Keywords</label><input type="text" name="translations[{{ $language->code }}][meta_keywords]" value="{{ old("translations.{$language->code}.meta_keywords", $article->translationInput('meta_keywords', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">Meta Description</label><textarea name="translations[{{ $language->code }}][meta_description]" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.meta_description", $article->translationInput('meta_description', $language->code)) }}</textarea></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <label class="flex items-center gap-3 text-slate-300">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $article->is_published))>
                    منشور
                </label>

                <div class="md:col-span-2 flex gap-3">
                    <button class="rounded-2xl bg-amber-400 px-8 py-4 font-bold text-slate-950">{{ $isEditing ? 'حفظ التعديلات' : 'إضافة المقال' }}</button>
                    <a href="{{ route('admin.articles.index') }}" class="rounded-2xl border border-white/10 px-8 py-4 font-bold text-white">إلغاء</a>
                </div>
            </form>
        </div>
    </section>
@endsection
