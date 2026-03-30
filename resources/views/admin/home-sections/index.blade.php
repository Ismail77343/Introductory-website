@extends('layouts.admin', ['title' => 'أقسام الرئيسية'])

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-black text-white">أقسام الصفحة الرئيسية</h1>
                <p class="mt-2 text-slate-300">يمكنك إضافة أقسام جديدة وزيادة عدد الكروت داخل كل قسم.</p>
            </div>
            <a href="{{ route('admin.home-sections.create') }}" class="rounded-2xl bg-amber-400 px-6 py-3 font-bold text-slate-950">إضافة قسم</a>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-white/5">
            <table class="min-w-full text-right">
                <thead class="bg-white/5 text-sm text-slate-300">
                    <tr>
                        <th class="px-5 py-4">العنوان</th>
                        <th class="px-5 py-4">النوع</th>
                        <th class="px-5 py-4">العناصر</th>
                        <th class="px-5 py-4">الحالة</th>
                        <th class="px-5 py-4">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sections as $section)
                        <tr class="border-t border-white/10 text-sm text-slate-200">
                            <td class="px-5 py-4 font-bold">{{ $section->title }}</td>
                            <td class="px-5 py-4">{{ $section->variant }}</td>
                            <td class="px-5 py-4">{{ $section->items_count }}</td>
                            <td class="px-5 py-4">{{ $section->is_active ? 'نشط' : 'مخفي' }}</td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.home-sections.edit', $section) }}" class="rounded-xl bg-white/10 px-3 py-2">تعديل</a>
                                    <form method="POST" action="{{ route('admin.home-sections.destroy', $section) }}" onsubmit="return confirm('هل تريد حذف القسم؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-xl bg-rose-500/20 px-3 py-2 text-rose-200">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
