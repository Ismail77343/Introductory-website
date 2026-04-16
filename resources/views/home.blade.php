@extends('layouts.app')

@section('content')
    @php
        $heroItem = $heroSection?->items->first();
        $heroMedia = $heroItem?->image_path ? asset($heroItem->image_path) : $heroItem?->image_url;
    @endphp

    <section id="{{ $heroSection?->anchor ?: 'hero' }}" class="hero-banner relative overflow-hidden border-b border-white/10">
        <div class="hero-banner__overlay absolute inset-0 bg-[linear-gradient(145deg,_rgba(15,23,42,.75),_rgba(30,41,59,.9))]"></div>
        @if ($heroMedia)
            <img src="{{ $heroMedia }}" alt="{{ $heroSection->title }}" class="hero-banner__media absolute inset-0 h-full w-full object-cover opacity-25">
        @endif

        <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
            <div class="max-w-4xl reveal">
                <span class="inline-flex rounded-full border border-amber-400/25 bg-amber-400/10 px-4 py-1 text-sm text-amber-200">
                    {{ $heroSection?->translate('subtitle') }}
                </span>
                <h1 class="mt-6 text-4xl font-black leading-tight text-white sm:text-6xl">{{ $heroSection?->translate('title') }}</h1>
                <p class="mt-5 text-lg leading-8 text-slate-200">{{ $heroSection?->translate('subtitle') }}</p>

                @if ($siteInfo?->vision)
                    <div class="mt-8 glass-card p-5">
                        <h2 class="text-lg font-black text-amber-300">{{ __('ui.vision') }}</h2>
                        <p class="mt-2 leading-8 text-slate-200">{{ $siteInfo->translate('vision') }}</p>
                    </div>
                @endif

                @if ($siteInfo?->mission)
                    <div class="mt-4 glass-card p-5">
                        <h2 class="text-lg font-black text-amber-300">{{ __('ui.mission') }}</h2>
                        <p class="mt-2 leading-8 text-slate-200">{{ $siteInfo->translate('mission') }}</p>
                    </div>
                @endif

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ $heroItem?->button_url ?: route('quotes.create') }}" class="rounded-2xl bg-amber-400 px-6 py-3 font-bold text-slate-950 transition hover:bg-amber-300">
                        {{ $heroItem?->translate('button_text') ?: __('ui.request_quote_now') }}
                    </a>
                    <a href="{{ route('products.index') }}" class="rounded-2xl border border-white/15 px-6 py-3 font-bold text-white transition hover:border-amber-300 hover:text-amber-300">
                        {{ __('ui.browse_products') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    @foreach ($dynamicSections as $section)
        <section id="{{ $section->anchor ?: 'section-'.$section->id }}" class="{{ $loop->odd ? 'bg-slate-900/35' : 'bg-slate-950/10' }} border-b border-white/5">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="reveal mb-10 max-w-3xl">
                    <h2 class="section-heading text-4xl font-black text-amber-300">{{ $section->translate('title') }}</h2>
                    @if ($section->subtitle)
                        <p class="mt-4 text-lg leading-8 text-slate-300">{{ $section->translate('subtitle') }}</p>
                    @endif
                </div>

                @if ($section->variant === 'stats')
                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach ($section->items as $item)
                            <article class="float-card reveal rounded-[2rem] border border-white/10 bg-white/5 p-6 text-center">
                                <p class="counter-value text-5xl font-black text-amber-300" data-counter="{{ $item->metric ?: $item->title }}">{{ $item->metric ?: $item->title }}</p>
                                <p class="mt-3 text-slate-300">{{ $item->translate('metric_label') ?: $item->translate('description') }}</p>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($section->items as $item)
                            @php
                                $itemImage = $item->image_path ? asset($item->image_path) : $item->image_url;
                                $itemAttachment = $item->attachment_path ? asset($item->attachment_path) : $item->attachment_url;
                            @endphp
                            <article class="float-card reveal rounded-[2rem] border border-white/10 bg-slate-950/50 p-8 shadow-xl shadow-black/10">
                                @if ($itemImage)
                                    <img src="{{ $itemImage }}" alt="{{ $item->translate('title') }}" class="mb-5 h-48 w-full rounded-[1.5rem] object-cover">
                                @elseif ($item->icon)
                                    <div class="mb-5 text-center text-5xl">{{ $item->icon }}</div>
                                @endif
                                <h3 class="text-center text-2xl font-black text-white">{{ $item->translate('title') }}</h3>
                                @if ($item->subtitle)
                                    <p class="mt-3 text-center font-semibold text-amber-200">{{ $item->translate('subtitle') }}</p>
                                @endif
                                @if ($item->description)
                                    <p class="mt-4 text-center leading-8 text-slate-300">{{ $item->translate('description') }}</p>
                                @endif
                                <div class="mt-6 flex flex-wrap justify-center gap-3">
                                    @if ($item->button_text && $item->button_url)
                                        <a href="{{ $item->button_url }}" class="inline-flex rounded-2xl bg-white/10 px-4 py-2 font-bold text-white transition hover:bg-amber-400 hover:text-slate-950">
                                            {{ $item->translate('button_text') }}
                                        </a>
                                    @endif
                                    @if ($itemAttachment)
                                        <a href="{{ $itemAttachment }}" target="_blank" class="inline-flex rounded-2xl border border-white/10 px-4 py-2 font-bold text-white transition hover:border-amber-300 hover:text-amber-300">
                                            {{ __('ui.download_file') }}
                                        </a>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endforeach

    <section class="border-b border-white/5">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="reveal mb-8 flex items-end justify-between gap-4">
                <div>
                    <h2 class="section-heading text-3xl font-black text-white">{{ __('ui.featured_products') }}</h2>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm font-bold text-amber-300 hover:text-amber-200">{{ __('ui.view_all') }}</a>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($featuredProducts as $product)
                    @php
                        $productImage = $product->image_path ? asset($product->image_path) : $product->image_url;
                    @endphp
                    <article class="float-card reveal overflow-hidden rounded-3xl border border-white/10 bg-slate-900/70 shadow-xl shadow-black/10">
                        <img src="{{ $productImage }}" alt="{{ $product->name }}" class="h-56 w-full object-cover">
                        <div class="p-6">
                            <p class="text-sm font-bold uppercase tracking-wider text-amber-300">{{ $product->translate('category') }}</p>
                            <h3 class="mt-2 text-2xl font-black text-white">{{ $product->translate('name') }}</h3>
                            <p class="mt-2 text-sm text-slate-300">{{ $product->translate('tagline') }}</p>
                            <p class="mt-4 text-sm leading-7 text-slate-400">{{ $product->translate('short_description') }}</p>
                            <a href="{{ route('products.show', $product) }}" class="mt-5 inline-flex rounded-2xl bg-white/10 px-4 py-2 text-sm font-bold text-white transition hover:bg-amber-400 hover:text-slate-950">
                                {{ __('ui.view_details') }}
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="testimonials" class="border-b border-white/5 bg-slate-950/30">
        <div class="mx-auto max-w-5xl px-4 py-16 text-center sm:px-6 lg:px-8">
            <h2 class="section-heading text-4xl font-black text-amber-300">{{ __('ui.our_clients') }}</h2>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($testimonials as $testimonial)
                    <article class="float-card reveal rounded-[2rem] border border-white/10 bg-slate-900/70 p-8 text-right">
                        <div class="mb-4 text-amber-300">{{ str_repeat('★', $testimonial->rating) }}</div>
                        <p class="leading-8 text-slate-200">"{{ $testimonial->translate('quote') }}"</p>
                        <div class="mt-6">
                            <p class="font-black text-white">{{ $testimonial->translate('client_name') }}</p>
                            <p class="text-sm text-slate-400">{{ $testimonial->translate('client_title') }}{{ $testimonial->translate('company_name') ? ' - '.$testimonial->translate('company_name') : '' }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="contact-info" class="border-b border-white/5 bg-slate-900/35">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-3">
                <article class="glass-card p-6">
                    <h3 class="text-xl font-black text-amber-300">{{ __('ui.email') }}</h3>
                    <p class="mt-3 text-slate-200">{{ $siteInfo?->contact_email ?? 'info@araib.com' }}</p>
                </article>
                <article class="glass-card p-6">
                    <h3 class="text-xl font-black text-amber-300">{{ __('ui.phone') }}</h3>
                    <p class="mt-3 text-slate-200">{{ $siteInfo?->contact_phone ?? '+966 577252986' }}</p>
                </article>
                <article class="glass-card p-6">
                    <h3 class="text-xl font-black text-amber-300">{{ __('ui.contact_info') }}</h3>
                    <p class="mt-3 text-slate-200">{{ $siteInfo?->translate('contact_address') ?? 'Riyadh - Saudi Arabia' }}</p>
                </article>
            </div>
        </div>
    </section>

    <section id="articles" class="bg-slate-900/35">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mb-8 flex items-end justify-between gap-4">
                <div>
                    <h2 class="section-heading text-4xl font-black text-amber-300">{{ __('ui.technical_articles') }}</h2>
                </div>
                <a href="{{ route('articles.index') }}" class="text-sm font-bold text-amber-300 hover:text-amber-200">{{ __('ui.view_all') }}</a>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($articles as $article)
                    @php
                        $articleImage = $article->cover_image_path
                            ? asset($article->cover_image_path)
                            : ($article->cover_image
                                ?: ($siteSettings?->default_article_image_path
                                    ? asset($siteSettings->default_article_image_path)
                                    : ($siteSettings?->default_article_image_url ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80')));
                        $articleDownload = $article->download_path ? asset($article->download_path) : $article->download_url;
                    @endphp
                    <article class="float-card reveal overflow-hidden rounded-[2rem] border border-white/10 bg-slate-900/70">
                        <img src="{{ $articleImage }}" alt="{{ $article->translate('title') }}" class="h-56 w-full object-cover">
                        <div class="p-6">
                            <p class="text-sm text-slate-400">{{ optional($article->published_at)->format('Y-m-d') }}</p>
                            <h3 class="mt-3 text-2xl font-black text-white">{{ $article->translate('title') }}</h3>
                            <p class="mt-4 leading-8 text-slate-300">{{ $article->translate('excerpt') }}</p>
                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="{{ route('articles.show', $article) }}" class="rounded-2xl bg-amber-400 px-4 py-2 text-sm font-bold text-slate-950">{{ __('ui.read_article') }}</a>
                                @if ($articleDownload)
                                    <a href="{{ $articleDownload }}" target="_blank" class="rounded-2xl border border-white/10 px-4 py-2 text-sm font-bold text-white">{{ __('ui.download_file') }}</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
