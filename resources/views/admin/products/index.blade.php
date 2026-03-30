@extends('layouts.admin', ['title' => 'إدارة المنتجات'])

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-black text-white">إدارة المنتجات</h1>
                <p class="mt-2 text-slate-300">إضافة وتعديل وحذف المنتجات من قاعدة البيانات.</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="rounded-2xl bg-amber-400 px-6 py-3 font-bold text-slate-950">إضافة منتج</a>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-white/5">
            <table class="min-w-full text-right">
                <thead class="bg-white/5 text-sm text-slate-300">
                    <tr>
                        <th class="px-5 py-4">الاسم</th>
                        <th class="px-5 py-4">الفئة</th>
                        <th class="px-5 py-4">SKU</th>
                        <th class="px-5 py-4">الحالة</th>
                        <th class="px-5 py-4">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-t border-white/10 text-sm text-slate-200">
                            <td class="px-5 py-4 font-bold">{{ $product->name }}</td>
                            <td class="px-5 py-4">{{ $product->category }}</td>
                            <td class="px-5 py-4">{{ $product->sku }}</td>
                            <td class="px-5 py-4">{{ $product->is_active ? 'نشط' : 'مخفي' }}</td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="rounded-xl bg-white/10 px-3 py-2">تعديل</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('هل تريد حذف هذا المنتج؟')">
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
