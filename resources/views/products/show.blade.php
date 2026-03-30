@extends('layouts.app', ['title' => $product->translate('name')])

@section('content')
    @php
        $productImage = $product->image_path ? asset($product->image_path) : $product->image_url;
        $tdsFile = $product->tds_path ? asset($product->tds_path) : $product->tds_url;
        $msdsFile = $product->msds_path ? asset($product->msds_path) : $product->msds_url;
    @endphp

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-6 text-sm text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-white">{{ __('ui.home') }}</a>
            <span class="mx-2">/</span>
            <a href="{{ route('products.index') }}" class="hover:text-white">{{ __('ui.products') }}</a>
            <span class="mx-2">/</span>
            <span>{{ $product->translate('name') }}</span>
        </div>

        <div class="grid gap-8 rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 lg:grid-cols-3 lg:p-8">
            <div>
                <img src="{{ $productImage }}" alt="{{ $product->translate('name') }}" class="h-full max-h-[420px] w-full rounded-[2rem] object-cover">
            </div>
            <div class="lg:col-span-2">
                <span class="rounded-full bg-amber-400/10 px-4 py-1 text-sm font-bold text-amber-300">{{ $product->translate('category') }}</span>
                <h1 class="mt-5 text-4xl font-black text-white">{{ $product->translate('name') }}</h1>
                <p class="mt-3 text-xl font-semibold text-slate-300">{{ $product->translate('tagline') }}</p>
                <p class="mt-5 max-w-3xl text-base leading-8 text-slate-400">{{ $product->translate('description') }}</p>

                <div class="mt-8 grid gap-4 md:grid-cols-2">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <p class="text-sm text-slate-400">{{ __('ui.standard') }}</p>
                        <p class="mt-2 text-lg font-bold text-white">{{ $product->translate('standard') ?: __('ui.not_specified') }}</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <p class="text-sm text-slate-400">{{ __('ui.viscosity') }}</p>
                        <p class="mt-2 text-lg font-bold text-white">{{ $product->translate('viscosity') ?: __('ui.not_specified') }}</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <p class="text-sm text-slate-400">{{ __('ui.max_diameter') }}</p>
                        <p class="mt-2 text-lg font-bold text-white">{{ $product->translate('max_diameter') ?: __('ui.not_specified') }}</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <p class="text-sm text-slate-400">{{ __('ui.operating_temperature') }}</p>
                        <p class="mt-2 text-lg font-bold text-white">{{ $product->translate('operating_temperature') ?: __('ui.not_specified') }}</p>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('quotes.create', ['product' => $product->id]) }}" class="rounded-2xl bg-amber-400 px-6 py-3 font-bold text-slate-950">{{ __('ui.request_product_quote') }}</a>
                    @if ($tdsFile)
                        <a href="{{ $tdsFile }}" target="_blank" class="rounded-2xl border border-white/10 px-6 py-3 font-bold text-white">TDS</a>
                    @endif
                    @if ($msdsFile)
                        <a href="{{ $msdsFile }}" target="_blank" class="rounded-2xl border border-white/10 px-6 py-3 font-bold text-white">MSDS</a>
                    @endif
                </div>
            </div>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-3xl font-black text-white">{{ __('ui.related_products') }}</h2>
                <div class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($relatedProducts as $relatedProduct)
                        <article class="rounded-3xl border border-white/10 bg-slate-900/70 p-5">
                            <h3 class="text-2xl font-black text-white">{{ $relatedProduct->translate('name') }}</h3>
                            <p class="mt-2 text-sm text-slate-400">{{ $relatedProduct->translate('short_description') }}</p>
                            <a href="{{ route('products.show', $relatedProduct) }}" class="mt-4 inline-flex text-sm font-bold text-amber-300">{{ __('ui.view_details') }}</a>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
