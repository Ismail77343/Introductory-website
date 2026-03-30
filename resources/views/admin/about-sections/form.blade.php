@extends('layouts.admin', ['title' => $isEditing ? 'تعديل قسم من نحن' : 'إضافة قسم من نحن'])

@section('content')
    @php
        $sectionItems = old('items', $items ?: [
            ['title' => '', 'description' => '', 'icon' => '', 'sort_order' => 1],
            ['title' => '', 'description' => '', 'icon' => '', 'sort_order' => 2],
            ['title' => '', 'description' => '', 'icon' => '', 'sort_order' => 3],
        ]);

        $itemTranslationFields = [
            'title' => 'عنوان العنصر',
            'subtitle' => 'عنوان فرعي',
            'description' => 'الوصف',
            'button_text' => 'نص الزر',
            'metric_label' => 'وصف الإحصائية',
        ];
    @endphp

    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 lg:p-8">
            <h1 class="text-4xl font-black text-white">{{ $isEditing ? 'تعديل قسم صفحة من نحن' : 'إضافة قسم لصفحة من نحن' }}</h1>
            <p class="mt-3 text-slate-300">يمكنك بناء صفحة About Us بأقسام متعددة اللغات: تعريف، شهادات، فريق، مميزات أو إحصائيات.</p>

            <form method="POST" action="{{ $isEditing ? route('admin.about-sections.update', $section) : route('admin.about-sections.store') }}" enctype="multipart/form-data" class="mt-8 space-y-8">
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif

                <div class="grid gap-5 md:grid-cols-2">
                    <div><label class="mb-2 block text-sm text-slate-300">عنوان القسم الأساسي</label><input type="text" name="title" value="{{ old('title', $section->title) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                    <div><label class="mb-2 block text-sm text-slate-300">المفتاح</label><input type="text" name="key" value="{{ old('key', $section->key) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                    <div>
                        <label class="mb-2 block text-sm text-slate-300">نوع القسم</label>
                        <select name="variant" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">
                            <option value="hero" @selected(old('variant', $section->variant) === 'hero')>Hero</option>
                            <option value="cards" @selected(old('variant', $section->variant) === 'cards')>Cards</option>
                            <option value="stats" @selected(old('variant', $section->variant) === 'stats')>Stats</option>
                        </select>
                    </div>
                    <div><label class="mb-2 block text-sm text-slate-300">Anchor</label><input type="text" name="anchor" value="{{ old('anchor', $section->anchor) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                    <div><label class="mb-2 block text-sm text-slate-300">الترتيب</label><input type="number" name="sort_order" value="{{ old('sort_order', $section->sort_order) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                    <label class="flex items-center gap-3 text-slate-300">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $section->is_active))>
                        قسم نشط
                    </label>
                    <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">الوصف الفرعي الأساسي</label><textarea name="subtitle" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old('subtitle', $section->subtitle) }}</textarea></div>
                </div>

                <div class="space-y-6 rounded-[1.75rem] border border-white/10 bg-slate-950/40 p-5">
                    <div>
                        <h2 class="text-2xl font-black text-amber-300">ترجمات القسم</h2>
                        <p class="mt-1 text-sm text-slate-400">عند تعبئة هذه الحقول ستتغير النصوص في صفحة من نحن فور تبديل اللغة.</p>
                    </div>
                    @foreach ($activeLanguages as $language)
                        <div class="rounded-[1.5rem] border border-white/10 bg-slate-950/70 p-5">
                            <h3 class="text-xl font-black text-white">{{ $language->native_name }} ({{ strtoupper($language->code) }})</h3>
                            <div class="mt-4 grid gap-5 md:grid-cols-2">
                                <div><label class="mb-2 block text-sm text-slate-300">عنوان القسم</label><input type="text" name="translations[{{ $language->code }}][title]" value="{{ old("translations.{$language->code}.title", $section->translationInput('title', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">الوصف الفرعي</label><textarea name="translations[{{ $language->code }}][subtitle]" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.subtitle", $section->translationInput('subtitle', $language->code)) }}</textarea></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-black text-amber-300">عناصر القسم</h2>
                            <p class="mt-1 text-sm text-slate-400">هذا الجزء يدعم أيضًا ترجمة نصوص الفريق أو الشهادات أو الإحصائيات لكل لغة مضافة.</p>
                        </div>
                        <button type="button" id="add-item-button" class="rounded-2xl bg-white/10 px-6 py-3 font-bold text-white">إضافة عنصر جديد</button>
                    </div>

                    <div id="section-items-container" class="space-y-5">
                        @foreach ($sectionItems as $index => $item)
                            @php
                                $existingImage = $item['image_path'] ?? null;
                                $existingAttachment = $item['attachment_path'] ?? null;
                            @endphp
                            <div class="rounded-[1.75rem] border border-white/10 bg-slate-900/70 p-5 section-item-card">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div><label class="mb-2 block text-sm text-slate-300">عنوان العنصر الأساسي</label><input type="text" name="items[{{ $index }}][title]" value="{{ $item['title'] ?? '' }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                    <div><label class="mb-2 block text-sm text-slate-300">عنوان فرعي أساسي</label><input type="text" name="items[{{ $index }}][subtitle]" value="{{ $item['subtitle'] ?? '' }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                    <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">الوصف الأساسي</label><textarea name="items[{{ $index }}][description]" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white">{{ $item['description'] ?? '' }}</textarea></div>
                                    <div><label class="mb-2 block text-sm text-slate-300">أيقونة أو Emoji</label><input type="text" name="items[{{ $index }}][icon]" value="{{ $item['icon'] ?? '' }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                    <div><label class="mb-2 block text-sm text-slate-300">رابط صورة</label><input type="url" name="items[{{ $index }}][image_url]" value="{{ $item['image_url'] ?? '' }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                    <div><label class="mb-2 block text-sm text-slate-300">رفع صورة</label><input type="file" name="items[{{ $index }}][image_file]" accept="image/*" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                    <div><label class="mb-2 block text-sm text-slate-300">نص الزر الأساسي</label><input type="text" name="items[{{ $index }}][button_text]" value="{{ $item['button_text'] ?? '' }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                    <div><label class="mb-2 block text-sm text-slate-300">رابط الزر</label><input type="text" name="items[{{ $index }}][button_url]" value="{{ $item['button_url'] ?? '' }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                    <div><label class="mb-2 block text-sm text-slate-300">رابط مرفق</label><input type="text" name="items[{{ $index }}][attachment_url]" value="{{ $item['attachment_url'] ?? '' }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                    <div><label class="mb-2 block text-sm text-slate-300">رفع مرفق</label><input type="file" name="items[{{ $index }}][attachment_file]" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                    <div><label class="mb-2 block text-sm text-slate-300">القيمة الإحصائية</label><input type="text" name="items[{{ $index }}][metric]" value="{{ $item['metric'] ?? '' }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                    <div><label class="mb-2 block text-sm text-slate-300">وصف الإحصائية الأساسي</label><input type="text" name="items[{{ $index }}][metric_label]" value="{{ $item['metric_label'] ?? '' }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                    <div><label class="mb-2 block text-sm text-slate-300">الترتيب</label><input type="number" name="items[{{ $index }}][sort_order]" value="{{ $item['sort_order'] ?? $index + 1 }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                    <label class="flex items-center gap-3 text-slate-300">
                                        <input type="checkbox" name="items[{{ $index }}][is_active]" value="1" @checked(($item['is_active'] ?? true))>
                                        عنصر نشط
                                    </label>
                                </div>

                                <div class="mt-5 space-y-4 rounded-[1.5rem] border border-white/10 bg-slate-950/60 p-4">
                                    <h3 class="text-lg font-black text-amber-300">ترجمات هذا العنصر</h3>
                                    @foreach ($activeLanguages as $language)
                                        <div class="rounded-[1.25rem] border border-white/10 bg-slate-900/70 p-4">
                                            <p class="mb-4 text-sm font-bold text-white">{{ $language->native_name }} ({{ strtoupper($language->code) }})</p>
                                            <div class="grid gap-4 md:grid-cols-2">
                                                @foreach ($itemTranslationFields as $field => $label)
                                                    @php
                                                        $translationValue = old("items.{$index}.{$field}_translations.{$language->code}", data_get($item, "{$field}_translations.{$language->code}"));
                                                    @endphp
                                                    @if ($field === 'description')
                                                        <div class="md:col-span-2">
                                                            <label class="mb-2 block text-sm text-slate-300">{{ $label }}</label>
                                                            <textarea name="items[{{ $index }}][{{ $field }}_translations][{{ $language->code }}]" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white">{{ $translationValue }}</textarea>
                                                        </div>
                                                    @else
                                                        <div>
                                                            <label class="mb-2 block text-sm text-slate-300">{{ $label }}</label>
                                                            <input type="text" name="items[{{ $index }}][{{ $field }}_translations][{{ $language->code }}]" value="{{ $translationValue }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <input type="hidden" name="items[{{ $index }}][image_path]" value="{{ $existingImage }}">
                                <input type="hidden" name="items[{{ $index }}][attachment_path]" value="{{ $existingAttachment }}">

                                @if ($existingImage || $existingAttachment)
                                    <div class="mt-5 grid gap-4 lg:grid-cols-2">
                                        @if ($existingImage)
                                            <div class="rounded-2xl border border-white/10 bg-slate-950/70 p-4">
                                                <p class="mb-3 text-sm text-slate-400">الصورة الحالية</p>
                                                <img src="{{ asset($existingImage) }}" alt="preview" class="h-40 w-full rounded-2xl object-cover">
                                            </div>
                                        @endif
                                        @if ($existingAttachment)
                                            <div class="rounded-2xl border border-white/10 bg-slate-950/70 p-4">
                                                <p class="mb-3 text-sm text-slate-400">المرفق الحالي</p>
                                                <a href="{{ asset($existingAttachment) }}" target="_blank" class="inline-flex rounded-2xl bg-white/10 px-4 py-2 font-bold text-white">فتح المرفق</a>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <button type="button" class="mt-5 rounded-2xl bg-rose-500/20 px-4 py-3 text-rose-200 remove-item-button">حذف هذا العنصر</button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-3">
                    <button class="rounded-2xl bg-amber-400 px-8 py-4 font-bold text-slate-950">{{ $isEditing ? 'حفظ التعديلات' : 'إضافة القسم' }}</button>
                    <a href="{{ route('admin.about-sections.index') }}" class="rounded-2xl border border-white/10 px-8 py-4 font-bold text-white">إلغاء</a>
                </div>
            </form>
        </div>
    </section>

    <template id="section-item-template">
        <div class="rounded-[1.75rem] border border-white/10 bg-slate-900/70 p-5 section-item-card">
            <div class="grid gap-4 md:grid-cols-2">
                <div><label class="mb-2 block text-sm text-slate-300">عنوان العنصر الأساسي</label><input type="text" data-name="title" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">عنوان فرعي أساسي</label><input type="text" data-name="subtitle" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">الوصف الأساسي</label><textarea rows="3" data-name="description" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></textarea></div>
                <div><label class="mb-2 block text-sm text-slate-300">أيقونة أو Emoji</label><input type="text" data-name="icon" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">رابط صورة</label><input type="url" data-name="image_url" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">رفع صورة</label><input type="file" data-name="image_file" accept="image/*" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">نص الزر الأساسي</label><input type="text" data-name="button_text" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">رابط الزر</label><input type="text" data-name="button_url" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">رابط مرفق</label><input type="text" data-name="attachment_url" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">رفع مرفق</label><input type="file" data-name="attachment_file" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">القيمة الإحصائية</label><input type="text" data-name="metric" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">وصف الإحصائية الأساسي</label><input type="text" data-name="metric_label" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">الترتيب</label><input type="number" data-name="sort_order" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                <label class="flex items-center gap-3 text-slate-300">
                    <input type="checkbox" data-name="is_active" value="1" checked>
                    عنصر نشط
                </label>
            </div>

            <div class="mt-5 space-y-4 rounded-[1.5rem] border border-white/10 bg-slate-950/60 p-4">
                <h3 class="text-lg font-black text-amber-300">ترجمات هذا العنصر</h3>
                @foreach ($activeLanguages as $language)
                    <div class="rounded-[1.25rem] border border-white/10 bg-slate-900/70 p-4">
                        <p class="mb-4 text-sm font-bold text-white">{{ $language->native_name }} ({{ strtoupper($language->code) }})</p>
                        <div class="grid gap-4 md:grid-cols-2">
                            @foreach ($itemTranslationFields as $field => $label)
                                @if ($field === 'description')
                                    <div class="md:col-span-2">
                                        <label class="mb-2 block text-sm text-slate-300">{{ $label }}</label>
                                        <textarea rows="3" data-translation-name="{{ $field }}_translations" data-translation-locale="{{ $language->code }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></textarea>
                                    </div>
                                @else
                                    <div>
                                        <label class="mb-2 block text-sm text-slate-300">{{ $label }}</label>
                                        <input type="text" data-translation-name="{{ $field }}_translations" data-translation-locale="{{ $language->code }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <input type="hidden" data-name="image_path">
            <input type="hidden" data-name="attachment_path">
            <button type="button" class="mt-5 rounded-2xl bg-rose-500/20 px-4 py-3 text-rose-200 remove-item-button">حذف هذا العنصر</button>
        </div>
    </template>

    <script>
        const itemsContainer = document.getElementById('section-items-container');
        const addItemButton = document.getElementById('add-item-button');
        const itemTemplate = document.getElementById('section-item-template');

        const reindexItems = () => {
            itemsContainer.querySelectorAll('.section-item-card').forEach((card, index) => {
                card.querySelectorAll('[data-name]').forEach((field) => {
                    field.name = `items[${index}][${field.dataset.name}]`;
                });

                card.querySelectorAll('[data-translation-name]').forEach((field) => {
                    field.name = `items[${index}][${field.dataset.translationName}][${field.dataset.translationLocale}]`;
                });
            });
        };

        addItemButton.addEventListener('click', () => {
            itemsContainer.appendChild(itemTemplate.content.cloneNode(true));
            reindexItems();
        });

        itemsContainer.addEventListener('click', (event) => {
            if (!event.target.classList.contains('remove-item-button')) {
                return;
            }

            event.target.closest('.section-item-card')?.remove();
            reindexItems();
        });

        reindexItems();
    </script>
@endsection
