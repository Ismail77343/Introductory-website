@extends('layouts.admin', ['title' => __('admin.products_title')])

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-black text-white">{{ __('admin.products_title') }}</h1>
                <p class="mt-2 text-slate-300">{{ __('admin.products_intro') }}</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="rounded-2xl bg-amber-400 px-6 py-3 font-bold text-slate-950">{{ __('admin.add_product') }}</a>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-white/5">
            <table class="min-w-full text-right">
                <thead class="bg-white/5 text-sm text-slate-300">
                    <tr>
                        <th class="px-5 py-4">{{ __('admin.product_name') }}</th>
                        <th class="px-5 py-4">{{ __('admin.category') }}</th>
                        <th class="px-5 py-4">{{ __('admin.sku') }}</th>
                        <th class="px-5 py-4">{{ __('admin.status') }}</th>
                        <th class="px-5 py-4">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-t border-white/10 text-sm text-slate-200">
                            <td class="px-5 py-4 font-bold">{{ $product->name }}</td>
                            <td class="px-5 py-4">{{ $product->category }}</td>
                            <td class="px-5 py-4">{{ $product->sku }}</td>
                            <td class="px-5 py-4">{{ $product->is_active ? __('admin.active') : __('admin.hidden') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="rounded-xl bg-white/10 px-3 py-2">{{ __('admin.edit') }}</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" data-delete-confirm="{{ __('admin.confirm_delete_product') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-xl bg-rose-500/20 px-3 py-2 text-rose-200">{{ __('admin.delete') }}</button>
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
