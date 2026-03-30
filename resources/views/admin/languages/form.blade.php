@extends('layouts.admin', ['title' => $isEditing ? 'تعديل لغة' : 'إضافة لغة'])

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 lg:p-8">
            <h1 class="text-4xl font-black text-white">{{ $isEditing ? 'تعديل لغة' : 'إضافة لغة جديدة' }}</h1>

            <form method="POST" action="{{ $isEditing ? route('admin.languages.update', $language) : route('admin.languages.store') }}" class="mt-8 grid gap-5 md:grid-cols-2">
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif

                <div><label class="mb-2 block text-sm text-slate-300">الكود</label><input type="text" name="code" value="{{ old('code', $language->code) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">الاسم</label><input type="text" name="name" value="{{ old('name', $language->name) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">الاسم الأصلي</label><input type="text" name="native_name" value="{{ old('native_name', $language->native_name) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div>
                    <label class="mb-2 block text-sm text-slate-300">الاتجاه</label>
                    <select name="direction" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">
                        <option value="rtl" @selected(old('direction', $language->direction) === 'rtl')>RTL</option>
                        <option value="ltr" @selected(old('direction', $language->direction) === 'ltr')>LTR</option>
                    </select>
                </div>
                <div><label class="mb-2 block text-sm text-slate-300">الترتيب</label><input type="number" name="sort_order" value="{{ old('sort_order', $language->sort_order) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <label class="flex items-center gap-3 text-slate-300">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $language->is_active))>
                    لغة نشطة
                </label>
                <label class="flex items-center gap-3 text-slate-300 md:col-span-2">
                    <input type="checkbox" name="is_default" value="1" @checked(old('is_default', $language->is_default))>
                    لغة افتراضية للموقع
                </label>

                <div class="md:col-span-2 flex gap-3">
                    <button class="rounded-2xl bg-amber-400 px-8 py-4 font-bold text-slate-950">{{ $isEditing ? 'حفظ التعديلات' : 'إضافة اللغة' }}</button>
                    <a href="{{ route('admin.languages.index') }}" class="rounded-2xl border border-white/10 px-8 py-4 font-bold text-white">إلغاء</a>
                </div>
            </form>
        </div>
    </section>
@endsection
