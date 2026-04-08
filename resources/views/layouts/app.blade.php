<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $currentLanguage?->direction ?? 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $pageMetaTitle = $metaTitle ?? $title ?? $siteSettings?->translate('default_meta_title') ?? $siteSettings?->translate('site_name') ?? 'Nofouth Future Company';
        $pageMetaDescription = $metaDescription ?? $siteSettings?->translate('default_meta_description') ?? $siteSettings?->translate('site_tagline') ?? 'Professional plumbing, electrical, and maintenance services';
        $pageMetaKeywords = $metaKeywords ?? $siteSettings?->translate('default_meta_keywords') ?? 'plumbing, electrical services, maintenance, technical services';
        $publicLogo = $siteSettings?->logo_path ? asset($siteSettings->logo_path) : ($siteSettings?->logo_url ?: null);
    @endphp
    <title>{{ $pageMetaTitle }}</title>
    <meta name="description" content="{{ $pageMetaDescription }}">
    <meta name="keywords" content="{{ $pageMetaKeywords }}">
    @if ($publicLogo)
        <link rel="icon" type="image/png" href="{{ $publicLogo }}">
        <link rel="shortcut icon" href="{{ $publicLogo }}">
        <link rel="apple-touch-icon" href="{{ $publicLogo }}">
    @endif
    <script>
        (() => {
            const storageKey = 'theme';
            const savedTheme = localStorage.getItem(storageKey);
            const preferredTheme = savedTheme === 'light' || savedTheme === 'dark' ? savedTheme : 'dark';
            document.documentElement.dataset.theme = preferredTheme;
            document.documentElement.style.colorScheme = preferredTheme;
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-light: #81b9dd;
            --brand-deep: #2756a3;
            --accent: var(--brand-deep);
            --ink: #071426;
            --panel: rgba(11, 28, 56, .74);
            --line: rgba(129, 185, 221, .18);
            --surface-dark: rgba(12, 24, 46, .82);
            --surface-soft-dark: rgba(20, 43, 82, .62);
            --text-strong-dark: #f4f8fc;
            --text-muted-dark: #b4cce1;
            --brand-shadow: rgba(39, 86, 163, .28);
            --brand-shadow-soft: rgba(129, 185, 221, .2);
        }
        body { font-family: 'Cairo', sans-serif; }
        .reveal { opacity: 0; transform: translateY(32px) scale(.98); transition: opacity .85s ease, transform .85s ease; }
        .reveal-visible { opacity: 1; transform: translateY(0) scale(1); }
        .float-card { transition: transform .4s ease, box-shadow .4s ease, border-color .4s ease; }
        .float-card:hover { transform: translateY(-10px); box-shadow: 0 24px 50px rgba(3, 12, 28, .32); border-color: rgba(129,185,221,.34); }
        .glass-card { border: 1px solid var(--line); background: linear-gradient(180deg, rgba(129,185,221,.14), rgba(255,255,255,.04)); backdrop-filter: blur(12px); border-radius: 2rem; box-shadow: 0 18px 44px rgba(4, 14, 30, .18); }
        .section-heading { position: relative; display: inline-block; padding-bottom: .75rem; }
        .section-heading::after { content: ""; position: absolute; inset-inline-start: 0; bottom: 0; width: 6rem; height: 4px; border-radius: 999px; background: linear-gradient(90deg, var(--brand-deep), rgba(129,185,221,.16)); }
        .animated-bg { position: fixed; inset: 0; z-index: -2; background: radial-gradient(circle at 15% 20%, rgba(129,185,221,.14), transparent 22%), radial-gradient(circle at 85% 12%, rgba(39,86,163,.22), transparent 24%), radial-gradient(circle at 50% 80%, rgba(129,185,221,.09), transparent 18%), linear-gradient(155deg, #071426, #0f2650 58%, #122d5c); }
        .animated-bg::after { content: ""; position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px); background-size: 80px 80px; mask-image: radial-gradient(circle at center, black 35%, transparent 85%); opacity: .25; }
        .hero-orb { position: absolute; border-radius: 999px; filter: blur(50px); pointer-events: none; animation: pulseOrb 8s ease-in-out infinite; }
        .hero-orb.one { width: 16rem; height: 16rem; right: 8%; top: 10%; background: rgba(39,86,163,.2); }
        .hero-orb.two { width: 18rem; height: 18rem; left: 4%; bottom: 10%; background: rgba(129,185,221,.14); animation-delay: -3s; }
        @keyframes pulseOrb { 0%,100% { transform: translate3d(0,0,0) scale(1);} 50% { transform: translate3d(0,-18px,0) scale(1.06);} }
        @keyframes navSlide { from { opacity: 0; transform: translateY(-16px);} to { opacity: 1; transform: translateY(0);} }
        .nav-enter { animation: navSlide .7s ease forwards; }
        .theme-toggle-icon-light, .theme-toggle[data-theme='light'] .theme-toggle-icon-dark { display: none; }
        .theme-toggle[data-theme='light'] .theme-toggle-icon-light { display: inline-flex; }
        body, header, footer, main, section, article, aside, nav, a, button, input, textarea, select, div, span { transition: background-color .25s ease, color .25s ease, border-color .25s ease, box-shadow .25s ease; }
        [class*="shadow-amber-"] { --tw-shadow-color: var(--brand-shadow) !important; }
        [class~="text-amber-300"] { color: #a9d3ea !important; }
        [class~="bg-amber-400"] { background-color: var(--brand-deep) !important; color: #f8fbff !important; }
        [class~="bg-amber-400"]:hover { background-color: #1f4686 !important; }
        [class~="text-slate-950"] { color: #f8fbff !important; }
        [class~="border-white/10"] { border-color: var(--line) !important; }
        [class~="bg-white/5"] { background-color: rgba(129, 185, 221, .08) !important; }
        [class~="bg-white/10"] { background-color: rgba(129, 185, 221, .12) !important; }
        [class~="bg-slate-950"] { background-color: rgba(7, 20, 38, .9) !important; }
        [class~="bg-slate-950/80"] { background-color: rgba(7, 20, 38, .78) !important; }
        [class~="bg-slate-950/70"] { background-color: rgba(7, 20, 38, .72) !important; }
        [class~="bg-slate-950/60"] { background-color: rgba(7, 20, 38, .64) !important; }
        [class~="bg-slate-950/40"] { background-color: rgba(7, 20, 38, .46) !important; }
        [class~="bg-slate-900"] { background-color: var(--surface-dark) !important; }
        [class~="bg-slate-900/70"] { background-color: var(--surface-soft-dark) !important; }
        [class~="text-white"] { color: var(--text-strong-dark) !important; }
        [class~="text-slate-200"] { color: #e4eff7 !important; }
        [class~="text-slate-300"] { color: var(--text-muted-dark) !important; }
        [class~="text-slate-400"] { color: #8fb0cb !important; }
        [class~="hover:text-white"]:hover { color: #f8fbff !important; }
        [class~="hover:bg-white/5"]:hover { background-color: rgba(129, 185, 221, .14) !important; }
        [class~="shadow-black/10"], [class~="shadow-black/20"] { --tw-shadow-color: rgba(3, 12, 28, .24) !important; }
        html[data-theme='light'] { color-scheme: light; }
        html[data-theme='light'] body { background: #f7fbff; color: #17345f; }
        html[data-theme='light'] .animated-bg { background: radial-gradient(circle at 15% 20%, rgba(129,185,221,.22), transparent 22%), radial-gradient(circle at 85% 10%, rgba(39,86,163,.14), transparent 24%), radial-gradient(circle at 50% 80%, rgba(129,185,221,.12), transparent 20%), linear-gradient(155deg, #f8fcff, #e9f3fb 55%, #f4f9fe); }
        html[data-theme='light'] .animated-bg::after { background-image: linear-gradient(rgba(15,23,42,.05) 1px, transparent 1px), linear-gradient(90deg, rgba(15,23,42,.05) 1px, transparent 1px); opacity: .4; }
        html[data-theme='light'] .hero-orb.one { background: rgba(39,86,163,.14); }
        html[data-theme='light'] .hero-orb.two { background: rgba(129,185,221,.22); }
        html[data-theme='light'] .glass-card { border-color: rgba(129,185,221,.22); background: linear-gradient(180deg, rgba(255,255,255,.99), rgba(248,252,255,.95)); box-shadow: 0 16px 34px rgba(39, 86, 163, .08); }
        html[data-theme='light'] .float-card:hover { box-shadow: 0 24px 48px rgba(39, 86, 163, .14); border-color: rgba(129,185,221,.32); }
        html[data-theme='light'] [class*="shadow-amber-"] { --tw-shadow-color: rgba(39, 86, 163, .18) !important; }
        html[data-theme='light'] [class~="text-amber-300"] { color: var(--brand-deep) !important; }
        html[data-theme='light'] [class~="bg-amber-400"] { background-color: var(--brand-deep) !important; color: #f8fbff !important; }
        html[data-theme='light'] [class~="bg-slate-950"],
        html[data-theme='light'] [class~="bg-slate-950/80"],
        html[data-theme='light'] [class~="bg-slate-950/70"],
        html[data-theme='light'] [class~="bg-slate-950/60"] { background-color: rgba(240, 247, 253, .80) !important; }
        html[data-theme='light'] [class~="bg-slate-950/40"] { background-color: rgba(235, 244, 252, .92) !important; }
        html[data-theme='light'] [class~="bg-slate-900"],
        html[data-theme='light'] [class~="bg-slate-900/70"] { background: linear-gradient(180deg, rgba(255,255,255,1), rgba(248,252,255,.96)) !important; box-shadow: 0 16px 32px rgba(39, 86, 163, .09); }
        html[data-theme='light'] [class~="bg-white/5"],
        html[data-theme='light'] [class~="bg-white/10"] { background-color: rgba(129, 185, 221, .08) !important; }
        html[data-theme='light'] [class~="border-white/10"] { border-color: rgba(129, 185, 221, .18) !important; }
        html[data-theme='light'] [class~="text-white"] { color: #163860 !important; }
        html[data-theme='light'] [class~="text-slate-200"] { color: #1a3d69 !important; }
        html[data-theme='light'] [class~="text-slate-300"] { color: #2f557f !important; }
        html[data-theme='light'] [class~="text-slate-400"] { color: #4f7399 !important; }
        html[data-theme='light'] [class~="hover:text-white"]:hover { color: var(--brand-deep) !important; }
        html[data-theme='light'] [class~="hover:bg-white/5"]:hover { background-color: rgba(129, 185, 221, .12) !important; }
        html[data-theme='light'] [class~="shadow-black/10"],
        html[data-theme='light'] [class~="shadow-black/20"] { --tw-shadow-color: rgba(39, 86, 163, .08) !important; }
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
                    <p class="text-xl font-black text-amber-300">{{ $siteSettings?->translate('site_name') ?? 'Nofouth Future Company' }}</p>
                    <p class="text-xs text-slate-300">{{ $siteSettings?->translate('site_tagline') ?? 'Professional plumbing, electrical, and maintenance services' }}</p>
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
                <button
                    type="button"
                    data-theme-toggle
                    class="theme-toggle flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-300 transition hover:text-white"
                    aria-label="Toggle theme"
                    title="Toggle theme"
                >
                    <span class="theme-toggle-icon-dark" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21.752 15.002A9.718 9.718 0 0 1 18 15.75C12.615 15.75 8.25 11.385 8.25 6c0-1.33.266-2.599.748-3.752A9.75 9.75 0 1 0 21.752 15.002Z" />
                        </svg>
                    </span>
                    <span class="theme-toggle-icon-light" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.25a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM12 18.75a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-1.5a.75.75 0 0 1 .75-.75ZM21 11.25a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1 0-1.5H21ZM4.5 11.25a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1 0-1.5h1.5ZM18.364 4.636a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 1 1-1.06 1.061l-1.06-1.06a.75.75 0 0 1 0-1.06ZM5.576 17.303a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 0 1-1.06 1.061l-1.06-1.06a.75.75 0 0 1 0-1.06ZM19.424 17.303a.75.75 0 0 1 0 1.06l-1.06 1.06a.75.75 0 1 1-1.06-1.06l1.06-1.06a.75.75 0 0 1 1.06 0ZM6.636 4.636a.75.75 0 0 1 0 1.06l-1.06 1.06a.75.75 0 1 1-1.06-1.06l1.06-1.06a.75.75 0 0 1 1.06 0ZM12 6.75A5.25 5.25 0 1 1 6.75 12 5.256 5.256 0 0 1 12 6.75Z" />
                        </svg>
                    </span>
                </button>

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
                <p>{{ $siteSettings?->translate('about_text') ?? 'Professional platform for plumbing, electrical, and maintenance services, technical articles, and service requests.' }}</p>
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
                <p>{{ $siteSettings->contact_email ?? 'info@nofouthfuture.com' }}</p>
                <p>{{ $siteSettings->contact_phone ?? '+966 577252986' }}</p>
            </div>
        </div>
        @if ($siteSettings?->translate('footer_text'))
            <div class="mx-auto max-w-7xl px-4 pb-8 text-center text-sm text-slate-400 sm:px-6 lg:px-8">{{ $siteSettings->translate('footer_text') }}</div>
        @endif
    </footer>

    <script>
        const themeStorageKey = 'theme';
        const themeToggleButton = document.querySelector('[data-theme-toggle]');
        const applyTheme = (theme) => {
            document.documentElement.dataset.theme = theme;
            document.documentElement.style.colorScheme = theme;
            themeToggleButton?.setAttribute('data-theme', theme);
            themeToggleButton?.setAttribute('aria-label', theme === 'dark' ? 'Activate light mode' : 'Activate dark mode');
            themeToggleButton?.setAttribute('title', theme === 'dark' ? 'Activate light mode' : 'Activate dark mode');
        };

        applyTheme(document.documentElement.dataset.theme || 'dark');

        themeToggleButton?.addEventListener('click', () => {
            const nextTheme = document.documentElement.dataset.theme === 'light' ? 'dark' : 'light';
            applyTheme(nextTheme);
            localStorage.setItem(themeStorageKey, nextTheme);
        });

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
