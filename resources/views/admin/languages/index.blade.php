@extends('layouts.admin', ['title' => 'اللغات'])

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-black text-white">إدارة اللغات</h1>
                <p class="mt-2 text-slate-300">من هنا تستطيع إضافة لغة جديدة أو تعديل الاتجاه والاسم واللغة الافتراضية.</p>
            </div>
            <a href="{{ route('admin.languages.create') }}" class="rounded-2xl bg-amber-400 px-6 py-3 font-bold text-slate-950">إضافة لغة</a>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-white/5">
            <table class="min-w-full text-right">
                <thead class="bg-white/5 text-sm text-slate-300">
                    <tr>
                        <th class="px-5 py-4">الكود</th>
                        <th class="px-5 py-4">الاسم</th>
                        <th class="px-5 py-4">الاسم الأصلي</th>
                        <th class="px-5 py-4">الاتجاه</th>
                        <th class="px-5 py-4">الحالة</th>
                        <th class="px-5 py-4">افتراضية</th>
                        <th class="px-5 py-4">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($languages as $language)
                        <tr class="border-t border-white/10 text-sm text-slate-200">
                            <td class="px-5 py-4 font-bold uppercase">{{ $language->code }}</td>
                            <td class="px-5 py-4">{{ $language->name }}</td>
                            <td class="px-5 py-4">{{ $language->native_name }}</td>
                            <td class="px-5 py-4">{{ strtoupper($language->direction) }}</td>
                            <td class="px-5 py-4">{{ $language->is_active ? 'نشطة' : 'مخفية' }}</td>
                            <td class="px-5 py-4">{{ $language->is_default ? 'نعم' : 'لا' }}</td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.languages.edit', $language) }}" class="rounded-xl bg-white/10 px-3 py-2">تعديل</a>
                                    @if (! $language->is_default)
                                        <form method="POST" action="{{ route('admin.languages.destroy', $language) }}" onsubmit="return confirm('هل تريد حذف اللغة؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded-xl bg-rose-500/20 px-3 py-2 text-rose-200">حذف</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
