@extends('layouts.app', ['title' => $article->translate('title'), 'metaTitle' => $article->translate('meta_title') ?: $article->translate('title'), 'metaDescription' => $article->translate('meta_description') ?: $article->translate('excerpt'), 'metaKeywords' => $article->translate('meta_keywords') ?: ($siteSettings?->translate('default_meta_keywords') ?? __('ui.articles'))])

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        @php
            $articleImage = $article->cover_image_path ? asset($article->cover_image_path) : ($article->cover_image ?: ($siteSettings?->default_article_image_path ? asset($siteSettings->default_article_image_path) : ($siteSettings?->default_article_image_url ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80')));
        @endphp
        <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-slate-900/70">
            <img src="{{ $articleImage }}" alt="{{ $article->translate('title') }}" class="h-72 w-full object-cover">
            <div class="p-8">
                <p class="text-sm text-slate-400">{{ optional($article->published_at)->format('Y-m-d') }}</p>
                <h1 class="mt-3 text-4xl font-black text-amber-300">{{ $article->translate('title') }}</h1>
                <p class="mt-4 text-lg leading-8 text-slate-300">{{ $article->translate('excerpt') }}</p>
                <div class="mt-8 leading-9 text-slate-200">{{ $article->translate('body') }}</div>
                @if ($article->download_path || $article->download_url)
                    <a href="{{ $article->download_path ? asset($article->download_path) : $article->download_url }}" target="_blank" class="mt-8 inline-flex rounded-2xl bg-amber-400 px-6 py-3 font-bold text-slate-950">{{ __('ui.download_related') }}</a>
                @endif
            </div>
        </div>

        @if ($relatedArticles->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-3xl font-black text-white">{{ __('ui.related_articles') }}</h2>
                <div class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($relatedArticles as $relatedArticle)
                        <article class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6">
                            <h3 class="text-2xl font-black text-white">{{ $relatedArticle->translate('title') }}</h3>
                            <p class="mt-3 leading-8 text-slate-300">{{ $relatedArticle->translate('excerpt') }}</p>
                            <a href="{{ route('articles.show', $relatedArticle) }}" class="mt-4 inline-flex text-sm font-bold text-amber-300">{{ __('ui.read_article') }}</a>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
