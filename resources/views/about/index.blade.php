@extends('layouts.app', ['title' => __('ui.about')])

@section('content')
    @php
        $heroSection = $sections->firstWhere('variant', 'hero');
        $contentSections = $sections->reject(fn ($section) => $heroSection && $section->id === $heroSection->id)->values();
    @endphp

    <section class="relative overflow-hidden border-b border-white/10">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(251,191,36,.22),transparent_30%),linear-gradient(135deg,rgba(15,23,42,.96),rgba(30,41,59,.9))]"></div>
        @if ($heroSection?->items->first())
            @php
                $heroMedia = $heroSection->items->first()->image_path ? asset($heroSection->items->first()->image_path) : $heroSection->items->first()->image_url;
            @endphp
            @if ($heroMedia)
                <img src="{{ $heroMedia }}" alt="{{ $heroSection->translate('title') }}" class="absolute inset-0 h-full w-full object-cover opacity-15">
            @endif
        @endif

        <div class="relative mx-auto grid max-w-7xl gap-8 px-4 py-20 sm:px-6 lg:grid-cols-[1.15fr_.85fr] lg:px-8 lg:py-24">
            <div class="reveal">
                <span class="inline-flex rounded-full border border-amber-400/30 bg-amber-400/10 px-4 py-1 text-sm font-bold text-amber-200">ABOUT US</span>
                <h1 class="mt-6 text-4xl font-black leading-tight text-white sm:text-6xl">{{ $heroSection?->translate('title') ?? __('ui.about') }}</h1>
                <p class="mt-5 text-lg leading-8 text-slate-200">{{ $heroSection?->translate('subtitle') ?? ($siteSettings?->translate('about_text') ?: 'Dynamic about page content.') }}</p>

                <div class="mt-8 grid gap-4 md:grid-cols-2">
                    @if ($siteSettings?->vision)
                        <article class="glass-card p-6">
                            <p class="text-sm font-bold uppercase tracking-[0.25em] text-amber-300">{{ __('ui.vision') }}</p>
                            <p class="mt-3 leading-8 text-slate-200">{{ $siteSettings->translate('vision') }}</p>
                        </article>
                    @endif
                    @if ($siteSettings?->mission)
                        <article class="glass-card p-6">
                            <p class="text-sm font-bold uppercase tracking-[0.25em] text-amber-300">{{ __('ui.mission') }}</p>
                            <p class="mt-3 leading-8 text-slate-200">{{ $siteSettings->translate('mission') }}</p>
                        </article>
                    @endif
                </div>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('contact.index') }}" class="rounded-2xl bg-amber-400 px-6 py-3 font-bold text-slate-950">{{ __('ui.contact') }}</a>
                    <a href="{{ route('quotes.create') }}" class="rounded-2xl border border-white/15 px-6 py-3 font-bold text-white">{{ __('ui.quote_request') }}</a>
                </div>
            </div>

            <div class="reveal">
                <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-black/20">
                    <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-amber-400/20 blur-3xl"></div>
                    <h2 class="text-2xl font-black text-amber-300">{{ __('ui.about_company') }}</h2>
                    <p class="mt-4 leading-8 text-slate-300">{{ $siteSettings?->translate('about_text') }}</p>

                    <div class="mt-6 space-y-4">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-sm text-slate-400">{{ __('ui.email') }}</p>
                            <p class="mt-2 font-bold text-white">{{ $siteSettings->contact_email ?? 'info@nofouthfuture.com' }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-sm text-slate-400">{{ __('ui.phone') }}</p>
                            <p class="mt-2 font-bold text-white">{{ $siteSettings->contact_phone ?? '+966000000000' }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-sm text-slate-400">{{ __('ui.contact_info') }}</p>
                            <p class="mt-2 font-bold text-white">{{ $siteSettings?->translate('contact_address') ?? 'Riyadh - Saudi Arabia' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @foreach ($contentSections as $section)
        <section id="{{ $section->anchor ?: 'about-'.$section->id }}" class="border-b border-white/5 {{ $loop->odd ? 'bg-white/[0.03]' : '' }}">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="reveal mb-10 max-w-3xl">
                    <h2 class="section-heading text-4xl font-black text-white">{{ $section->translate('title') }}</h2>
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
                            <article class="float-card reveal overflow-hidden rounded-[2rem] border border-white/10 bg-slate-900/70 shadow-xl shadow-black/10">
                                @if ($itemImage)
                                    <img src="{{ $itemImage }}" alt="{{ $item->translate('title') }}" class="h-56 w-full object-cover">
                                @endif
                                <div class="p-6">
                                    @if (! $itemImage && $item->icon)
                                        <div class="mb-5 text-5xl">{{ $item->icon }}</div>
                                    @endif
                                    <h3 class="text-2xl font-black text-white">{{ $item->translate('title') }}</h3>
                                    @if ($item->subtitle)
                                        <p class="mt-3 font-semibold text-amber-200">{{ $item->translate('subtitle') }}</p>
                                    @endif
                                    @if ($item->description)
                                        <p class="mt-4 leading-8 text-slate-300">{{ $item->translate('description') }}</p>
                                    @endif
                                    <div class="mt-6 flex flex-wrap gap-3">
                                        @if ($item->button_text && $item->button_url)
                                            <a href="{{ $item->button_url }}" class="rounded-2xl bg-amber-400 px-4 py-2 font-bold text-slate-950">{{ $item->translate('button_text') }}</a>
                                        @endif
                                        @if ($itemAttachment)
                                            <a href="{{ $itemAttachment }}" target="_blank" class="rounded-2xl border border-white/10 px-4 py-2 font-bold text-white">{{ __('ui.download_file') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endforeach
@endsection
