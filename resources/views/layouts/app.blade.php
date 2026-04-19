<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $currentLanguage?->direction ?? 'rtl' }}" data-theme="dark">
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
    @if ($publicLogo)
        <link rel="icon" type="image/png" href="{{ $publicLogo }}">
        <link rel="shortcut icon" href="{{ $publicLogo }}">
        <link rel="apple-touch-icon" href="{{ $publicLogo }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-a: {{ $siteSettings?->theme_primary_color ?: '#fbbf24' }};
            --brand-b: {{ $siteSettings?->theme_secondary_color ?: '#38bdf8' }};
            --brand-contrast: #0b1220;
            --accent: var(--brand-a);
            --ink: #020617;
            --panel: rgba(15, 23, 42, .72);
            --line: rgba(255,255,255,.1);
        }
        .bg-amber-400 { background-color: var(--brand-a) !important; color: var(--brand-contrast) !important; }
        .hover\:bg-amber-300:hover { background-color: color-mix(in oklab, var(--brand-a) 80%, white) !important; color: var(--brand-contrast) !important; }
        .text-amber-200 { color: color-mix(in oklab, var(--brand-a) 74%, white) !important; }
        .text-amber-300 { color: color-mix(in oklab, var(--brand-a) 70%, white) !important; }
        .text-amber-500 { color: color-mix(in oklab, var(--brand-a) 88%, black) !important; }
        .bg-amber-400\/10 { background-color: color-mix(in oklab, var(--brand-a) 14%, transparent) !important; }
        .bg-amber-400\/20 { background-color: color-mix(in oklab, var(--brand-a) 20%, transparent) !important; }
        .border-amber-300 { border-color: color-mix(in oklab, var(--brand-a) 64%, white) !important; }
        .border-amber-400\/25 { border-color: color-mix(in oklab, var(--brand-a) 42%, transparent) !important; }
        .border-amber-400\/30 { border-color: color-mix(in oklab, var(--brand-a) 52%, transparent) !important; }
        .hover\:border-amber-300:hover { border-color: color-mix(in oklab, var(--brand-a) 64%, white) !important; }
        .hover\:text-amber-200:hover { color: color-mix(in oklab, var(--brand-a) 78%, white) !important; }
        .hover\:text-amber-300:hover { color: color-mix(in oklab, var(--brand-a) 72%, white) !important; }
        .shadow-amber-400\/20,
        .shadow-amber-500\/20 { box-shadow: 0 18px 40px color-mix(in oklab, var(--brand-a) 24%, transparent) !important; }
        body { font-family: 'Cairo', sans-serif; }
        .required-mark { margin-inline-start: .35rem; color: #f87171; font-weight: 900; }
        .reveal { opacity: 0; transform: translateY(32px) scale(.98); transition: opacity .85s ease, transform .85s ease; }
        .reveal-visible { opacity: 1; transform: translateY(0) scale(1); }
        .float-card { transition: transform .4s ease, box-shadow .4s ease, border-color .4s ease; }
        .float-card:hover { transform: translateY(-10px); box-shadow: 0 24px 50px rgba(2, 6, 23, .34); border-color: rgba(251,191,36,.28); }
        .glass-card { border: 1px solid var(--line); background: linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.03)); backdrop-filter: blur(12px); border-radius: 2rem; }
        a, button, input, select, textarea { transition: background-color .22s ease, color .22s ease, border-color .22s ease, box-shadow .22s ease, transform .22s ease; }
        :where(a,button,input,select,textarea):focus-visible { outline: none; box-shadow: 0 0 0 4px color-mix(in oklab, var(--brand-a) 28%, transparent); }
        .section-heading { position: relative; display: inline-block; padding-bottom: .75rem; }
        .section-heading::after { content: ""; position: absolute; inset-inline-start: 0; bottom: 0; width: 6rem; height: 4px; border-radius: 999px; background: linear-gradient(90deg, var(--brand-a), color-mix(in oklab, var(--brand-a) 10%, transparent)); }
        .animated-bg { position: fixed; inset: 0; z-index: -2; background: radial-gradient(circle at 15% 20%, rgba(251,191,36,.14), transparent 22%), radial-gradient(circle at 85% 10%, rgba(56,189,248,.12), transparent 22%), radial-gradient(circle at 50% 80%, rgba(251,191,36,.08), transparent 18%), linear-gradient(155deg, #020617, #0f172a 55%, #111827); }
        .animated-bg::after { content: ""; position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px); background-size: 80px 80px; mask-image: radial-gradient(circle at center, black 35%, transparent 85%); opacity: .25; }
        .hero-orb { position: absolute; border-radius: 999px; filter: blur(50px); pointer-events: none; animation: pulseOrb 8s ease-in-out infinite; }
        .hero-orb.one { width: 16rem; height: 16rem; right: 8%; top: 10%; background: rgba(251,191,36,.14); }
        .hero-orb.two { width: 18rem; height: 18rem; left: 4%; bottom: 10%; background: rgba(56,189,248,.10); animation-delay: -3s; }
        @keyframes pulseOrb { 0%,100% { transform: translate3d(0,0,0) scale(1);} 50% { transform: translate3d(0,-18px,0) scale(1.06);} }
        @keyframes navSlide { from { opacity: 0; transform: translateY(-16px);} to { opacity: 1; transform: translateY(0);} }
        .nav-enter { animation: navSlide .7s ease forwards; }

        /* Light theme (Dark stays exactly as-is). */
        html[data-theme="light"] body { background-color: #f8fafc !important; color: #0f172a !important; }
        html[data-theme="light"] .animated-bg {
            background: radial-gradient(circle at 12% 18%, rgba(251,191,36,.16), transparent 26%),
                        radial-gradient(circle at 88% 12%, rgba(56,189,248,.12), transparent 26%),
                        radial-gradient(circle at 50% 85%, rgba(167,139,250,.10), transparent 22%),
                        linear-gradient(180deg, #ffffff, #f8fafc 55%, #f1f5f9);
        }
        html[data-theme="light"] .animated-bg::after {
            background-image: linear-gradient(rgba(15,23,42,.05) 1px, transparent 1px), linear-gradient(90deg, rgba(15,23,42,.05) 1px, transparent 1px);
            opacity: .55;
        }
        html[data-theme="light"] .hero-orb.one { background: color-mix(in oklab, var(--brand-a) 28%, transparent); filter: blur(56px); }
        html[data-theme="light"] .hero-orb.two { background: color-mix(in oklab, var(--brand-b) 20%, transparent); filter: blur(56px); }

        html[data-theme="light"] .glass-card {
            border-color: rgba(15,23,42,.10) !important;
            background: linear-gradient(180deg, rgba(255,255,255,.88), rgba(255,255,255,.58)) !important;
        }
        html[data-theme="light"] .float-card:hover { box-shadow: 0 24px 56px rgba(2, 6, 23, .14); border-color: rgba(251,191,36,.30); }

        html[data-theme="light"] .float-card {
            border-color: rgba(15,23,42,.10) !important;
            background: linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.72)) !important;
            box-shadow: 0 18px 40px rgba(2, 6, 23, .10);
        }

        /* Hero banner tuning for Light (keep Dark unchanged). */
        html[data-theme="light"] .hero-banner { border-color: rgba(15,23,42,.08) !important; }
        html[data-theme="light"] .hero-banner__overlay {
            background:
                radial-gradient(circle at 14% 18%, color-mix(in oklab, var(--brand-a) 18%, transparent), transparent 48%),
                radial-gradient(circle at 90% 12%, color-mix(in oklab, var(--brand-b) 16%, transparent), transparent 52%),
                linear-gradient(145deg, rgba(255,255,255,.92), rgba(248,250,252,.74) 55%, rgba(241,245,249,.86)) !important;
            backdrop-filter: blur(10px);
        }
        html[data-theme="light"] .hero-banner__media {
            opacity: .42 !important;
            filter: saturate(1.08) contrast(1.05);
        }

        /* Tailwind utility overrides used across public pages. */
        html[data-theme="light"] .bg-slate-950 { background-color: #f8fafc !important; }
        html[data-theme="light"] .bg-slate-950\/80 { background-color: rgba(248,250,252,.80) !important; }
        html[data-theme="light"] .bg-slate-950\/70 { background-color: rgba(248,250,252,.72) !important; }
        html[data-theme="light"] .bg-slate-950\/30 { background-color: rgba(241,245,249,.92) !important; }
        html[data-theme="light"] .bg-slate-950\/10 { background-color: rgba(241,245,249,.82) !important; }
        html[data-theme="light"] .bg-slate-900\/70 { background-color: rgba(255,255,255,.86) !important; }
        html[data-theme="light"] .bg-slate-900\/35 { background-color: rgba(255,255,255,.72) !important; }
        html[data-theme="light"] .bg-slate-900\/50 { background-color: rgba(255,255,255,.78) !important; }
        html[data-theme="light"] .bg-slate-900\/95 { background-color: rgba(255,255,255,.92) !important; }
        html[data-theme="light"] .bg-slate-900 { background-color: #ffffff !important; }

        html[data-theme="light"] .text-white { color: #0f172a !important; }
        html[data-theme="light"] .text-slate-200 { color: rgba(15,23,42,.82) !important; }
        html[data-theme="light"] .text-slate-300 { color: rgba(15,23,42,.74) !important; }
        html[data-theme="light"] .text-slate-400 { color: rgba(15,23,42,.62) !important; }
        html[data-theme="light"] .text-slate-100 { color: rgba(15,23,42,.88) !important; }

        html[data-theme="light"] .border-white\/10 { border-color: rgba(15,23,42,.10) !important; }
        html[data-theme="light"] .border-white\/15 { border-color: rgba(15,23,42,.16) !important; }
        html[data-theme="light"] .border-white\/5 { border-color: rgba(15,23,42,.06) !important; }

        html[data-theme="light"] .bg-white\/5 { background-color: rgba(255,255,255,.55) !important; }
        html[data-theme="light"] .bg-white\/10 { background-color: rgba(255,255,255,.70) !important; }
        html[data-theme="light"] .hover\:bg-white\/5:hover { background-color: rgba(15,23,42,.05) !important; }
        html[data-theme="light"] .hover\:text-white:hover { color: #0b1220 !important; }

        /* Make brand accents readable in Light. */
        html[data-theme="light"] .text-amber-200 { color: color-mix(in oklab, var(--brand-a) 82%, #111827) !important; }
        html[data-theme="light"] .text-amber-300 { color: color-mix(in oklab, var(--brand-a) 78%, #111827) !important; }
        html[data-theme="light"] .text-amber-500 { color: color-mix(in oklab, var(--brand-a) 88%, #111827) !important; }
        html[data-theme="light"] .bg-amber-400\/10 { background-color: color-mix(in oklab, var(--brand-a) 20%, transparent) !important; }
        html[data-theme="light"] .border-amber-400\/25 { border-color: color-mix(in oklab, var(--brand-a) 45%, transparent) !important; }
        html[data-theme="light"] .border-amber-400\/30 { border-color: color-mix(in oklab, var(--brand-a) 52%, transparent) !important; }

        /* Forms + destructive actions in Light. */
        html[data-theme="light"] input,
        html[data-theme="light"] select,
        html[data-theme="light"] textarea {
            background-color: rgba(255,255,255,.92) !important;
            border-color: rgba(15,23,42,.12) !important;
            color: #0f172a !important;
            box-shadow: 0 10px 26px rgba(2, 6, 23, .06);
        }
        html[data-theme="light"] select { color-scheme: light; }
        html[data-theme="light"] input::placeholder,
        html[data-theme="light"] textarea::placeholder { color: rgba(15,23,42,.45); }
        html[data-theme="light"] input:focus,
        html[data-theme="light"] select:focus,
        html[data-theme="light"] textarea:focus {
            outline: none;
            border-color: color-mix(in oklab, var(--brand-a) 70%, white) !important;
            box-shadow: 0 0 0 4px color-mix(in oklab, var(--brand-a) 22%, transparent), 0 14px 28px rgba(2, 6, 23, .08);
        }

        html[data-theme="light"] .bg-rose-500\/20 { background-color: rgba(244,63,94,.12) !important; }
        html[data-theme="light"] .text-rose-200 { color: rgb(190,18,60) !important; }
        html[data-theme="light"] .border-rose-500\/30 { border-color: rgba(244,63,94,.26) !important; }
        html[data-theme="light"] .bg-rose-500\/10 { background-color: rgba(244,63,94,.08) !important; }

        /* "Cracked glass" effect over hero overlays in Light (animated). */
        html[data-theme="light"] .hero-banner__overlay { position: absolute; }
        html[data-theme="light"] .hero-banner__overlay::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .38;
            background-image:
                repeating-linear-gradient(115deg, rgba(255,255,255,.0) 0 18px, rgba(15,23,42,.12) 18px 19px, rgba(255,255,255,0) 19px 42px),
                repeating-linear-gradient(12deg, rgba(255,255,255,.0) 0 22px, rgba(15,23,42,.10) 22px 23px, rgba(255,255,255,0) 23px 46px),
                radial-gradient(circle at 18% 22%, color-mix(in oklab, var(--brand-a) 22%, transparent), transparent 55%),
                radial-gradient(circle at 86% 18%, color-mix(in oklab, var(--brand-b) 18%, transparent), transparent 58%);
            background-size: 520px 520px, 640px 640px, auto, auto;
            background-position: 0 0, 0 0, center, center;
            mix-blend-mode: multiply;
            filter: blur(.15px);
            animation: crackDrift 12s ease-in-out infinite;
        }
        @keyframes crackDrift {
            0%, 100% { background-position: 0 0, 0 0, center, center; opacity: .32; }
            50% { background-position: 120px -80px, -90px 140px, center, center; opacity: .42; }
        }
        .mobile-nav-panel {
            transform: translateY(-12px) scale(.98);
            opacity: 0;
            pointer-events: none;
            transition: transform .24s ease, opacity .24s ease;
        }
        .mobile-nav-panel-open {
            transform: translateY(0) scale(1);
            opacity: 1;
            pointer-events: auto;
        }
        @media (max-width: 767px) {
            .hero-orb { display: none; }
            .glass-card { border-radius: 1.4rem; }
            .section-heading { padding-bottom: .45rem; }
            .section-heading::after { width: 4rem; }
            h1.text-5xl, h1.text-6xl { font-size: clamp(2rem, 8.5vw, 2.45rem) !important; line-height: 1.12 !important; }
            h2.text-4xl { font-size: clamp(1.5rem, 7vw, 2rem) !important; line-height: 1.2 !important; }
            p.text-xl { font-size: 1.02rem !important; line-height: 1.7 !important; }
        }
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

            <div class="flex items-center gap-2 sm:gap-3">
                <button type="button" class="group inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-3 py-2 text-sm font-bold text-slate-300 transition hover:text-white" data-theme-toggle aria-label="Toggle theme">
                    <span class="hidden sm:inline" data-theme-label>Dark</span>
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-white/10 bg-slate-950/60 transition group-hover:border-amber-300/40" aria-hidden="true">
                        <svg data-theme-icon-moon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-amber-200">
                            <path d="M21.752 15.002A9.718 9.718 0 0 1 12.01 22C6.486 22 2 17.514 2 11.99A9.718 9.718 0 0 1 8.998 2.248a.75.75 0 0 1 .87.87A8.218 8.218 0 0 0 19.88 14.132a.75.75 0 0 1 .872.87Z"/>
                        </svg>
                        <svg data-theme-icon-sun xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-5 w-5 text-amber-500">
                            <path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 12 2.25Zm0 16.5a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-1.5a.75.75 0 0 1 .75-.75ZM4.72 4.72a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 1 1-1.06 1.06L4.72 5.78a.75.75 0 0 1 0-1.06Zm12.44 12.44a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 1 1-1.06 1.06l-1.06-1.06a.75.75 0 0 1 0-1.06ZM2.25 12a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1-.75-.75Zm16.5 0a.75.75 0 0 1 .75-.75H21a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM4.72 19.28a.75.75 0 0 1 0-1.06l1.06-1.06a.75.75 0 1 1 1.06 1.06l-1.06 1.06a.75.75 0 0 1-1.06 0Zm12.44-12.44a.75.75 0 0 1 0-1.06l1.06-1.06a.75.75 0 1 1 1.06 1.06l-1.06 1.06a.75.75 0 0 1-1.06 0ZM12 6.75a5.25 5.25 0 1 0 0 10.5 5.25 5.25 0 0 0 0-10.5Z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                </button>
                @if ($activeLanguages->isNotEmpty())
                    <div class="hidden items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-2 py-2 sm:flex">
                        @foreach ($activeLanguages as $language)
                            <a href="{{ route('locale.switch', $language) }}" class="rounded-xl px-3 py-2 text-sm font-bold transition {{ app()->getLocale() === $language->code ? 'bg-amber-400 text-slate-950' : 'text-slate-300 hover:text-white' }}">
                                {{ strtoupper($language->code) }}
                            </a>
                        @endforeach
                    </div>
                @endif
                <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-200 transition hover:text-white md:hidden" aria-label="Open menu" data-mobile-nav-open>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                        <path fill-rule="evenodd" d="M3 5.25A.75.75 0 0 1 3.75 4.5h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 5.25Zm0 6A.75.75 0 0 1 3.75 10.5h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 11.25Zm0 6a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
                    </svg>
                </button>

                @if ($isAdminArea && auth()->check())
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="rounded-xl border border-white/10 px-4 py-2 text-sm text-slate-300 transition hover:text-white">تسجيل الخروج</button>
                    </form>
                @endif
            </div>
        </div>
    </header>
    <div class="fixed inset-0 z-40 hidden bg-slate-950/70 backdrop-blur-sm md:hidden" data-mobile-nav-backdrop></div>
    <div class="mobile-nav-panel fixed inset-x-4 top-[5.5rem] z-50 rounded-[1.75rem] border border-white/10 bg-slate-900/95 p-4 shadow-2xl shadow-black/30 md:hidden" data-mobile-nav-panel>
        <div class="mb-3 flex items-center justify-between">
            <p class="text-sm font-black text-amber-300">Navigation</p>
            <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-slate-300" aria-label="Close menu" data-mobile-nav-close>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 1 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
        <nav class="grid gap-2">
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-bold {{ request()->routeIs($link['route']) ? 'bg-amber-400 text-slate-950' : 'text-slate-200' }}" data-mobile-nav-link>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>
        @if ($activeLanguages->isNotEmpty())
            <div class="mt-4 rounded-2xl border border-white/10 bg-white/5 p-3">
                <p class="mb-2 text-xs font-bold tracking-wide text-slate-400">Language</p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($activeLanguages as $language)
                        <a href="{{ route('locale.switch', $language) }}" class="rounded-xl px-3 py-2 text-sm font-bold transition {{ app()->getLocale() === $language->code ? 'bg-amber-400 text-slate-950' : 'border border-white/10 bg-slate-900 text-slate-200' }}" data-mobile-nav-link>
                            {{ strtoupper($language->code) }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

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
        const themeStorageKey = 'nofouth_theme';
        const root = document.documentElement;
        const normalizeHex = (value) => /^#([0-9a-fA-F]{6})$/.test(value || '') ? value : '#fbbf24';
        const toRgb = (hex) => {
            const clean = normalizeHex(hex).slice(1);
            return {
                r: parseInt(clean.slice(0, 2), 16),
                g: parseInt(clean.slice(2, 4), 16),
                b: parseInt(clean.slice(4, 6), 16),
            };
        };
        const setBrandContrast = () => {
            const primary = getComputedStyle(root).getPropertyValue('--brand-a').trim() || '#fbbf24';
            const { r, g, b } = toRgb(primary);
            const luminance = ((0.299 * r) + (0.587 * g) + (0.114 * b)) / 255;
            root.style.setProperty('--brand-contrast', luminance > 0.63 ? '#0b1220' : '#f8fafc');
        };

        const applyTheme = (theme) => {
            const value = theme === 'light' ? 'light' : 'dark';
            root.setAttribute('data-theme', value);
            const label = document.querySelector('[data-theme-label]');
            const moon = document.querySelector('[data-theme-icon-moon]');
            const sun = document.querySelector('[data-theme-icon-sun]');
            if (label) label.textContent = value === 'light' ? 'Light' : 'Dark';
            if (moon) moon.classList.toggle('hidden', value === 'light');
            if (sun) sun.classList.toggle('hidden', value !== 'light');
            setBrandContrast();
        };

        const savedTheme = localStorage.getItem(themeStorageKey);
        applyTheme(savedTheme || 'dark');

        document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
            button.addEventListener('click', () => {
                const current = root.getAttribute('data-theme') || 'dark';
                const next = current === 'light' ? 'dark' : 'light';
                localStorage.setItem(themeStorageKey, next);
                applyTheme(next);
            });
        });

        document.querySelectorAll('form [required]').forEach((field) => {
            const wrapper = field.closest('div, label');
            const label = wrapper?.querySelector('label');
            if (label && !label.querySelector('.required-mark')) {
                label.insertAdjacentHTML('beforeend', '<span class="required-mark">*</span>');
            }
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

        const mobileMenuPanel = document.querySelector('[data-mobile-nav-panel]');
        const mobileMenuBackdrop = document.querySelector('[data-mobile-nav-backdrop]');
        const openMobileMenu = () => {
            if (!mobileMenuPanel || !mobileMenuBackdrop) return;
            mobileMenuBackdrop.classList.remove('hidden');
            mobileMenuPanel.classList.add('mobile-nav-panel-open');
            document.body.style.overflow = 'hidden';
        };
        const closeMobileMenu = () => {
            if (!mobileMenuPanel || !mobileMenuBackdrop) return;
            mobileMenuBackdrop.classList.add('hidden');
            mobileMenuPanel.classList.remove('mobile-nav-panel-open');
            document.body.style.overflow = '';
        };
        document.querySelectorAll('[data-mobile-nav-open]').forEach((btn) => btn.addEventListener('click', openMobileMenu));
        document.querySelectorAll('[data-mobile-nav-close], [data-mobile-nav-link], [data-mobile-nav-backdrop]').forEach((el) => el.addEventListener('click', closeMobileMenu));
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) closeMobileMenu();
        });
    </script>
</body>
</html>
