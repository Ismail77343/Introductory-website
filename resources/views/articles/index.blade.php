@extends('layouts.app', ['title' => __('ui.articles'), 'metaTitle' => $siteSettings?->translate('default_meta_title') ?? __('ui.articles'), 'metaDescription' => $siteSettings?->translate('default_meta_description') ?? __('ui.technical_articles'), 'metaKeywords' => $siteSettings?->translate('default_meta_keywords') ?? __('ui.articles')])

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-10">
            <h1 class="text-4xl font-black text-amber-300">{{ __('ui.technical_articles') }}</h1>
            <p class="mt-3 text-slate-300">{{ __('ui.articles_intro') }}</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($articles as $article)
                @php
                    $articleImage = $article->cover_image_path ? asset($article->cover_image_path) : ($article->cover_image ?: ($siteSettings?->default_article_image_path ? asset($siteSettings->default_article_image_path) : ($siteSettings?->default_article_image_url ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80')));
                @endphp
                <article class="overflow-hidden rounded-[2rem] border border-white/10 bg-slate-900/70">
                    <img src="{{ $articleImage }}" alt="{{ $article->translate('title') }}" class="h-56 w-full object-cover">
                    <div class="p-6">
                        <p class="text-sm text-slate-400">{{ optional($article->published_at)->format('Y-m-d') }}</p>
                        <h2 class="mt-3 text-2xl font-black text-white">{{ $article->translate('title') }}</h2>
                        <p class="mt-4 leading-8 text-slate-300">{{ $article->translate('excerpt') }}</p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('articles.show', $article) }}" class="rounded-2xl bg-amber-400 px-4 py-2 text-sm font-bold text-slate-950">{{ __('ui.read_article') }}</a>
                            @if ($article->download_path || $article->download_url)
                                <a href="{{ $article->download_path ? asset($article->download_path) : $article->download_url }}" target="_blank" class="rounded-2xl border border-white/10 px-4 py-2 text-sm font-bold text-white">{{ __('ui.download') }}</a>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
