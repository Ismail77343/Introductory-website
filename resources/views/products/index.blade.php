@extends('layouts.app', ['title' => __('ui.products')])

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-black text-white">{{ __('ui.catalog') }}</h1>
            <p class="mt-3 text-slate-300">{{ __('ui.dynamic_catalog') }}</p>
        </div>

        <form method="GET" class="mb-10 grid gap-4 rounded-3xl border border-white/10 bg-white/5 p-6 lg:grid-cols-3">
            <div>
                <label class="mb-2 block text-sm text-slate-300">{{ __('ui.search') }}</label>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="{{ __('ui.search') }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none ring-0">
            </div>
            <div>
                <label class="mb-2 block text-sm text-slate-300">{{ __('ui.category') }}</label>
                <select name="category" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none">
                    <option value="">{{ __('ui.all_categories') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected(($filters['category'] ?? '') === $category)>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-3">
                <button class="rounded-2xl bg-amber-400 px-6 py-3 font-bold text-slate-950">{{ __('ui.apply') }}</button>
                <a href="{{ route('products.index') }}" class="rounded-2xl border border-white/10 px-6 py-3 font-bold text-white">{{ __('ui.reset') }}</a>
            </div>
        </form>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($products as $product)
                @php
                    $productImage = $product->image_path ? asset($product->image_path) : $product->image_url;
                @endphp
                <article class="overflow-hidden rounded-3xl border border-white/10 bg-slate-900/70">
                    <img src="{{ $productImage }}" alt="{{ $product->translate('name') }}" class="h-60 w-full object-cover">
                    <div class="p-6">
                        <div class="flex items-center justify-between gap-3">
                            <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-bold text-amber-300">{{ $product->translate('category') }}</span>
                            <span class="text-xs text-slate-400">SKU: {{ $product->sku }}</span>
                        </div>
                        <h2 class="mt-4 text-2xl font-black text-white">{{ $product->translate('name') }}</h2>
                        <p class="mt-2 text-sm font-semibold text-slate-300">{{ $product->translate('tagline') }}</p>
                        <p class="mt-4 text-sm leading-7 text-slate-400">{{ $product->translate('short_description') }}</p>
                        <div class="mt-5 flex gap-3">
                            <a href="{{ route('products.show', $product) }}" class="rounded-2xl bg-amber-400 px-4 py-2 text-sm font-bold text-slate-950">{{ __('ui.view_details') }}</a>
                            <a href="{{ route('quotes.create', ['product' => $product->id]) }}" class="rounded-2xl border border-white/10 px-4 py-2 text-sm font-bold text-white">{{ __('ui.quote_request') }}</a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-white/15 bg-white/5 p-8 text-slate-300 md:col-span-2 xl:col-span-3">
                    {{ __('ui.products') }}
                </div>
            @endforelse
        </div>
    </section>
@endsection
