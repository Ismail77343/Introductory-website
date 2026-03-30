@extends('layouts.admin', ['title' => $isEditing ? 'تعديل منتج' : 'إضافة منتج'])

@section('content')
    @php
        $productImage = old('image_path', $product->image_path);
        $productImageUrl = old('image_url', $product->image_url);
        $productTds = old('tds_path', $product->tds_path);
        $productTdsUrl = old('tds_url', $product->tds_url);
        $productMsds = old('msds_path', $product->msds_path);
        $productMsdsUrl = old('msds_url', $product->msds_url);
    @endphp

    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 lg:p-8">
            <h1 class="text-4xl font-black text-white">{{ $isEditing ? 'تعديل منتج' : 'إضافة منتج جديد' }}</h1>

            <form method="POST" action="{{ $isEditing ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data" class="mt-8 grid gap-5 md:grid-cols-2">
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif

                <div><label class="mb-2 block text-sm text-slate-300">اسم المنتج الأساسي</label><input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">SKU</label><input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">Slug</label><input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">الفئة الأساسية</label><input type="text" name="category" value="{{ old('category', $product->category) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">الشعار النصي الأساسي</label><input type="text" name="tagline" value="{{ old('tagline', $product->tagline) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">وصف مختصر أساسي</label><textarea name="short_description" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old('short_description', $product->short_description) }}</textarea></div>
                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">الوصف التفصيلي الأساسي</label><textarea name="description" rows="5" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old('description', $product->description) }}</textarea></div>
                <div><label class="mb-2 block text-sm text-slate-300">اللزوجة الأساسية</label><input type="text" name="viscosity" value="{{ old('viscosity', $product->viscosity) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">المعيار الأساسي</label><input type="text" name="standard" value="{{ old('standard', $product->standard) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">أقصى قطر</label><input type="text" name="max_diameter" value="{{ old('max_diameter', $product->max_diameter) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">درجة التشغيل</label><input type="text" name="operating_temperature" value="{{ old('operating_temperature', $product->operating_temperature) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">اللون</label><input type="text" name="color" value="{{ old('color', $product->color) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">شارة المنتج</label><input type="text" name="badge" value="{{ old('badge', $product->badge) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">لون التمييز</label><input type="text" name="accent_color" value="{{ old('accent_color', $product->accent_color) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">الترتيب</label><input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>

                <div class="md:col-span-2 grid gap-4 lg:grid-cols-3">
                    <article class="rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-5">
                        <p class="text-sm text-slate-400">صورة المنتج</p>
                        <div class="mt-4">
                            @if ($productImage)
                                <img src="{{ asset($productImage) }}" alt="صورة المنتج" class="h-40 w-full rounded-2xl object-cover">
                            @elseif ($productImageUrl)
                                <img src="{{ $productImageUrl }}" alt="صورة المنتج" class="h-40 w-full rounded-2xl object-cover">
                            @else
                                <div class="flex h-40 items-center justify-center rounded-2xl border border-dashed border-white/10 text-slate-500">لا توجد صورة</div>
                            @endif
                        </div>
                        <button type="button" data-modal-target="image-modal" class="mt-4 w-full rounded-2xl bg-white/10 px-4 py-3 font-bold text-white">إدارة الصورة</button>
                    </article>
                    <article class="rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-5">
                        <p class="text-sm text-slate-400">ملف TDS</p>
                        <div class="mt-4 min-h-[10rem] rounded-2xl border border-dashed border-white/10 p-4 text-sm text-slate-300">
                            @if ($productTds)
                                <a href="{{ asset($productTds) }}" target="_blank" class="font-bold text-amber-300">فتح الملف الحالي</a>
                            @elseif ($productTdsUrl)
                                <a href="{{ $productTdsUrl }}" target="_blank" class="font-bold text-amber-300">فتح الرابط الحالي</a>
                            @else
                                لا يوجد ملف مضاف
                            @endif
                        </div>
                        <button type="button" data-modal-target="tds-modal" class="mt-4 w-full rounded-2xl bg-white/10 px-4 py-3 font-bold text-white">إدارة ملف TDS</button>
                    </article>
                    <article class="rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-5">
                        <p class="text-sm text-slate-400">ملف MSDS</p>
                        <div class="mt-4 min-h-[10rem] rounded-2xl border border-dashed border-white/10 p-4 text-sm text-slate-300">
                            @if ($productMsds)
                                <a href="{{ asset($productMsds) }}" target="_blank" class="font-bold text-amber-300">فتح الملف الحالي</a>
                            @elseif ($productMsdsUrl)
                                <a href="{{ $productMsdsUrl }}" target="_blank" class="font-bold text-amber-300">فتح الرابط الحالي</a>
                            @else
                                لا يوجد ملف مضاف
                            @endif
                        </div>
                        <button type="button" data-modal-target="msds-modal" class="mt-4 w-full rounded-2xl bg-white/10 px-4 py-3 font-bold text-white">إدارة ملف MSDS</button>
                    </article>
                </div>

                <input type="hidden" name="image_path" value="{{ $productImage }}">
                <input type="hidden" name="tds_path" value="{{ $productTds }}">
                <input type="hidden" name="msds_path" value="{{ $productMsds }}">

                <div class="md:col-span-2 space-y-6">
                    @foreach ($activeLanguages as $language)
                        <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/60 p-5">
                            <h2 class="text-2xl font-black text-amber-300">{{ $language->native_name }} ({{ strtoupper($language->code) }})</h2>
                            <div class="mt-5 grid gap-5 md:grid-cols-2">
                                <div><label class="mb-2 block text-sm text-slate-300">اسم المنتج</label><input type="text" name="translations[{{ $language->code }}][name]" value="{{ old("translations.{$language->code}.name", $product->translationInput('name', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div><label class="mb-2 block text-sm text-slate-300">الفئة</label><input type="text" name="translations[{{ $language->code }}][category]" value="{{ old("translations.{$language->code}.category", $product->translationInput('category', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">الشعار النصي</label><input type="text" name="translations[{{ $language->code }}][tagline]" value="{{ old("translations.{$language->code}.tagline", $product->translationInput('tagline', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">وصف مختصر</label><textarea name="translations[{{ $language->code }}][short_description]" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.short_description", $product->translationInput('short_description', $language->code)) }}</textarea></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">الوصف التفصيلي</label><textarea name="translations[{{ $language->code }}][description]" rows="5" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.description", $product->translationInput('description', $language->code)) }}</textarea></div>
                                <div><label class="mb-2 block text-sm text-slate-300">اللزوجة</label><input type="text" name="translations[{{ $language->code }}][viscosity]" value="{{ old("translations.{$language->code}.viscosity", $product->translationInput('viscosity', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div><label class="mb-2 block text-sm text-slate-300">المعيار</label><input type="text" name="translations[{{ $language->code }}][standard]" value="{{ old("translations.{$language->code}.standard", $product->translationInput('standard', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div><label class="mb-2 block text-sm text-slate-300">أقصى قطر</label><input type="text" name="translations[{{ $language->code }}][max_diameter]" value="{{ old("translations.{$language->code}.max_diameter", $product->translationInput('max_diameter', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div><label class="mb-2 block text-sm text-slate-300">درجة التشغيل</label><input type="text" name="translations[{{ $language->code }}][operating_temperature]" value="{{ old("translations.{$language->code}.operating_temperature", $product->translationInput('operating_temperature', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div><label class="mb-2 block text-sm text-slate-300">اللون</label><input type="text" name="translations[{{ $language->code }}][color]" value="{{ old("translations.{$language->code}.color", $product->translationInput('color', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div><label class="mb-2 block text-sm text-slate-300">شارة المنتج</label><input type="text" name="translations[{{ $language->code }}][badge]" value="{{ old("translations.{$language->code}.badge", $product->translationInput('badge', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <label class="flex items-center gap-3 text-slate-300">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))>
                    منتج مميز
                </label>
                <label class="flex items-center gap-3 text-slate-300">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))>
                    منتج نشط
                </label>

                <div class="md:col-span-2 flex gap-3">
                    <button class="rounded-2xl bg-amber-400 px-8 py-4 font-bold text-slate-950">{{ $isEditing ? 'حفظ التعديلات' : 'إضافة المنتج' }}</button>
                    <a href="{{ route('admin.products.index') }}" class="rounded-2xl border border-white/10 px-8 py-4 font-bold text-white">إلغاء</a>
                </div>

                <div id="image-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/75 p-4">
                    <div class="w-full max-w-xl rounded-[2rem] border border-white/10 bg-slate-900 p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-black text-white">إدارة صورة المنتج</h2>
                            <button type="button" data-close-modal class="text-slate-400">إغلاق</button>
                        </div>
                        <div class="mt-6 space-y-5">
                            <div><label class="mb-2 block text-sm text-slate-300">رابط الصورة</label><input type="url" name="image_url" value="{{ $productImageUrl }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">رفع صورة من الجهاز</label><input type="file" name="image_file" accept="image/*" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                        </div>
                    </div>
                </div>

                <div id="tds-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/75 p-4">
                    <div class="w-full max-w-xl rounded-[2rem] border border-white/10 bg-slate-900 p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-black text-white">إدارة ملف TDS</h2>
                            <button type="button" data-close-modal class="text-slate-400">إغلاق</button>
                        </div>
                        <div class="mt-6 space-y-5">
                            <div><label class="mb-2 block text-sm text-slate-300">رابط الملف</label><input type="url" name="tds_url" value="{{ $productTdsUrl }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">رفع ملف من الجهاز</label><input type="file" name="tds_file" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                        </div>
                    </div>
                </div>

                <div id="msds-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/75 p-4">
                    <div class="w-full max-w-xl rounded-[2rem] border border-white/10 bg-slate-900 p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-black text-white">إدارة ملف MSDS</h2>
                            <button type="button" data-close-modal class="text-slate-400">إغلاق</button>
                        </div>
                        <div class="mt-6 space-y-5">
                            <div><label class="mb-2 block text-sm text-slate-300">رابط الملف</label><input type="url" name="msds_url" value="{{ $productMsdsUrl }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">رفع ملف من الجهاز</label><input type="file" name="msds_file" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.querySelectorAll('[data-modal-target]').forEach((button) => {
            button.addEventListener('click', () => {
                document.getElementById(button.dataset.modalTarget)?.classList.remove('hidden');
                document.getElementById(button.dataset.modalTarget)?.classList.add('flex');
            });
        });

        document.querySelectorAll('[data-close-modal]').forEach((button) => {
            button.addEventListener('click', () => {
                button.closest('.fixed')?.classList.add('hidden');
                button.closest('.fixed')?.classList.remove('flex');
            });
        });

        document.querySelectorAll('.fixed[id$="-modal"]').forEach((modal) => {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        });
    </script>
@endsection
