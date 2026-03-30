<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $currentLanguage?->direction ?? 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $pageMetaTitle = $metaTitle ?? $title ?? $siteSettings?->translate('default_meta_title') ?? $siteSettings?->translate('site_name') ?? 'Nofouth Future';
        $pageMetaDescription = $metaDescription ?? $siteSettings?->translate('default_meta_description') ?? $siteSettings?->translate('site_tagline') ?? 'Industrial CPVC and PVC adhesive solutions';
        $pageMetaKeywords = $metaKeywords ?? $siteSettings?->translate('default_meta_keywords') ?? 'CPVC, PVC, industrial adhesives';
        $publicLogo = $siteSettings?->logo_path ? asset($siteSettings->logo_path) : ($siteSettings?->logo_url ?: null);
    @endphp
    <title>{{ $pageMetaTitle }}</title>
    <meta name="description" content="{{ $pageMetaDescription }}">
    <meta name="keywords" content="{{ $pageMetaKeywords }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root { --accent: #fbbf24; --ink: #020617; --panel: rgba(15, 23, 42, .72); --line: rgba(255,255,255,.1); }
        body { font-family: 'Cairo', sans-serif; }
        .reveal { opacity: 0; transform: translateY(32px) scale(.98); transition: opacity .85s ease, transform .85s ease; }
        .reveal-visible { opacity: 1; transform: translateY(0) scale(1); }
        .float-card { transition: transform .4s ease, box-shadow .4s ease, border-color .4s ease; }
        .float-card:hover { transform: translateY(-10px); box-shadow: 0 24px 50px rgba(2, 6, 23, .34); border-color: rgba(251,191,36,.28); }
        .glass-card { border: 1px solid var(--line); background: linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.03)); backdrop-filter: blur(12px); border-radius: 2rem; }
        .section-heading { position: relative; display: inline-block; padding-bottom: .75rem; }
        .section-heading::after { content: ""; position: absolute; inset-inline-start: 0; bottom: 0; width: 6rem; height: 4px; border-radius: 999px; background: linear-gradient(90deg, rgba(251,191,36,1), rgba(251,191,36,.15)); }
        .animated-bg { position: fixed; inset: 0; z-index: -2; background: radial-gradient(circle at 15% 20%, rgba(251,191,36,.14), transparent 22%), radial-gradient(circle at 85% 10%, rgba(56,189,248,.12), transparent 22%), radial-gradient(circle at 50% 80%, rgba(251,191,36,.08), transparent 18%), linear-gradient(155deg, #020617, #0f172a 55%, #111827); }
        .animated-bg::after { content: ""; position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px); background-size: 80px 80px; mask-image: radial-gradient(circle at center, black 35%, transparent 85%); opacity: .25; }
        .hero-orb { position: absolute; border-radius: 999px; filter: blur(50px); pointer-events: none; animation: pulseOrb 8s ease-in-out infinite; }
        .hero-orb.one { width: 16rem; height: 16rem; right: 8%; top: 10%; background: rgba(251,191,36,.14); }
        .hero-orb.two { width: 18rem; height: 18rem; left: 4%; bottom: 10%; background: rgba(56,189,248,.10); animation-delay: -3s; }
        @keyframes pulseOrb { 0%,100% { transform: translate3d(0,0,0) scale(1);} 50% { transform: translate3d(0,-18px,0) scale(1.06);} }
        @keyframes navSlide { from { opacity: 0; transform: translateY(-16px);} to { opacity: 1; transform: translateY(0);} }
        .nav-enter { animation: navSlide .7s ease forwards; }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-white">
    @php
        $isAdminArea = request()->routeIs('admin.*');
        $navLinks = [
            ['label' => __('ui.home'), 'route' => 'home'],
            ['label' => __('ui.about'), 'route' => 'about.index'],
            ['label' => __('ui.products'), 'route' => 'products.index'],
            ['label' => __('ui.articles'), 'route' => 'articles.index'],
            ['label' => __('ui.quote_request'), 'route' => 'quotes.create'],
            ['label' => __('ui.contact'), 'route' => 'contact.index'],
            ['label' => auth()->check() ? __('ui.dashboard') : __('ui.admin_login'), 'route' => auth()->check() ? 'admin.dashboard' : 'admin.login'],
        ];
    @endphp

    <div class="animated-bg"></div>
    <div class="hero-orb one"></div>
    <div class="hero-orb two"></div>

    <header class="sticky top-0 z-40 border-b border-white/10 bg-slate-950/80 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="nav-enter flex items-center gap-3">
                @if ($publicLogo)
                    <img src="{{ $publicLogo }}" alt="logo" class="h-12 w-12 rounded-2xl object-cover shadow-lg shadow-amber-500/20">
                @else
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-400 text-slate-900 font-black shadow-lg shadow-amber-500/20">NF</div>
                @endif
                <div>
                    <p class="text-xl font-black text-amber-300">{{ $siteSettings?->translate('site_name') ?? 'Nofouth Future' }}</p>
                    <p class="text-xs text-slate-300">{{ $siteSettings?->translate('site_tagline') ?? 'Industrial CPVC and PVC adhesive solutions' }}</p>
                </div>
            </a>

            <nav class="hidden items-center gap-6 text-sm md:flex">
                @foreach ($navLinks as $index => $link)
                    <a href="{{ route($link['route']) }}" class="nav-enter transition {{ request()->routeIs($link['route']) ? 'text-amber-300' : 'text-slate-300 hover:text-white' }}" style="animation-delay: {{ 120 + ($index * 70) }}ms">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-3">
                @if ($activeLanguages->isNotEmpty())
                    <div class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-2 py-2">
                        @foreach ($activeLanguages as $language)
                            <a href="{{ route('locale.switch', $language) }}" class="rounded-xl px-3 py-2 text-sm font-bold transition {{ app()->getLocale() === $language->code ? 'bg-amber-400 text-slate-950' : 'text-slate-300 hover:text-white' }}">
                                {{ strtoupper($language->code) }}
                            </a>
                        @endforeach
                    </div>
                @endif

                @if ($isAdminArea && auth()->check())
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="rounded-xl border border-white/10 px-4 py-2 text-sm text-slate-300 transition hover:text-white">تسجيل الخروج</button>
                    </form>
                @endif
            </div>
        </div>
    </header>

    @if (session('success'))
        <div class="mx-auto mt-6 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-emerald-100">{{ session('success') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mx-auto mt-6 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 px-5 py-4 text-rose-100">
                <p class="mb-2 font-bold">يرجى مراجعة الحقول التالية:</p>
                <ul class="space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <main>@yield('content')</main>

    <footer class="mt-20 border-t border-white/10 bg-slate-950/70">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 text-sm text-slate-300 sm:px-6 lg:grid-cols-3 lg:px-8">
            <div>
                <h3 class="mb-3 text-lg font-bold text-amber-300">{{ __('ui.about_company') }}</h3>
                <p>{{ $siteSettings?->translate('about_text') ?? 'Dynamic Laravel platform for products, articles, and quote requests.' }}</p>
            </div>
            <div>
                <h3 class="mb-3 text-lg font-bold text-amber-300">{{ __('ui.quick_links') }}</h3>
                <div class="space-y-2">
                    <a class="block hover:text-white" href="{{ route('about.index') }}">{{ __('ui.about') }}</a>
                    <a class="block hover:text-white" href="{{ route('products.index') }}">{{ __('ui.products') }}</a>
                    <a class="block hover:text-white" href="{{ route('articles.index') }}">{{ __('ui.articles') }}</a>
                    <a class="block hover:text-white" href="{{ route('quotes.create') }}">{{ __('ui.quote_request') }}</a>
                </div>
            </div>
            <div>
                <h3 class="mb-3 text-lg font-bold text-amber-300">{{ __('ui.contact_info') }}</h3>
                <p>{{ $siteSettings?->translate('contact_address') ?? 'Riyadh - Saudi Arabia' }}</p>
                <p>{{ $siteSettings->contact_email ?? 'info@araib.com' }}</p>
                <p>{{ $siteSettings->contact_phone ?? '+966 577252986' }}</p>
            </div>
        </div>
        @if ($siteSettings?->translate('footer_text'))
            <div class="mx-auto max-w-7xl px-4 pb-8 text-center text-sm text-slate-400 sm:px-6 lg:px-8">{{ $siteSettings->translate('footer_text') }}</div>
        @endif
    </footer>

    <script>
        const revealElements = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('reveal-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        revealElements.forEach((element) => revealObserver.observe(element));

        const counterElements = document.querySelectorAll('[data-counter]');
        const numberPattern = /[\d.,]+/;
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                const element = entry.target;
                const originalValue = element.dataset.counter;
                const match = originalValue.match(numberPattern);
                if (!match) {
                    counterObserver.unobserve(element);
                    return;
                }
                const numericString = match[0].replace(/,/g, '');
                const target = parseFloat(numericString);
                const prefix = originalValue.slice(0, match.index);
                const suffix = originalValue.slice((match.index ?? 0) + match[0].length);
                const isDecimal = numericString.includes('.');
                const startTime = performance.now();
                const duration = 1800;
                const step = (now) => {
                    const progress = Math.min((now - startTime) / duration, 1);
                    const current = target * progress;
                    const value = isDecimal ? current.toFixed(1) : Math.floor(current).toLocaleString('en-US');
                    element.textContent = `${prefix}${value}${suffix}`;
                    if (progress < 1) requestAnimationFrame(step);
                    else element.textContent = originalValue;
                };
                requestAnimationFrame(step);
                counterObserver.unobserve(element);
            });
        }, { threshold: 0.4 });
        counterElements.forEach((element) => counterObserver.observe(element));
    </script>
</body>
</html>
