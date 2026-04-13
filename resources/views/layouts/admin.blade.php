<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $currentLanguage?->direction ?? 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $adminFavicon = $siteSettings?->logo_path ? asset($siteSettings->logo_path) : ($siteSettings?->logo_url ?: null);
    @endphp
    <title>{{ $title ?? __('admin.dashboard') }}</title>
    @if ($adminFavicon)
        <link rel="icon" type="image/png" href="{{ $adminFavicon }}">
        <link rel="shortcut icon" href="{{ $adminFavicon }}">
        <link rel="apple-touch-icon" href="{{ $adminFavicon }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-light: #81b9dd;
            --brand-deep: #2756a3;
            --admin-bg: #071426;
            --admin-surface: rgba(11, 28, 56, .84);
            --admin-surface-soft: rgba(19, 42, 79, .72);
            --admin-line: rgba(129, 185, 221, .18);
            --admin-text: #eef5fb;
            --admin-muted: #aac5dc;
            --admin-shadow: rgba(39, 86, 163, .22);
        }
        body { font-family: 'Cairo', sans-serif; background: linear-gradient(180deg, #071426, #0e2344 55%, #122d5c); color: var(--admin-text); }
        body, aside, header, main, a, button, input, textarea, select, div, span { transition: background-color .25s ease, color .25s ease, border-color .25s ease, box-shadow .25s ease; }
        [class*="shadow-amber-"] { --tw-shadow-color: var(--admin-shadow) !important; }
        [class~="text-amber-300"] { color: #aed5ea !important; }
        [class~="bg-amber-400"] { background-color: var(--brand-deep) !important; color: #f8fbff !important; }
        [class~="bg-amber-400"]:hover { background-color: #1f4686 !important; }
        [class~="text-slate-950"] { color: #f8fbff !important; }
        [class~="border-white/10"] { border-color: var(--admin-line) !important; }
        [class~="bg-white/5"] { background-color: rgba(129, 185, 221, .08) !important; }
        [class~="bg-slate-950"] { background-color: rgba(7, 20, 38, .92) !important; }
        [class~="bg-slate-950/40"] { background-color: rgba(7, 20, 38, .44) !important; }
        [class~="bg-slate-950/60"] { background-color: rgba(7, 20, 38, .64) !important; }
        [class~="bg-slate-950/70"] { background-color: rgba(7, 20, 38, .76) !important; }
        [class~="bg-slate-900"] { background-color: var(--admin-surface) !important; }
        [class~="bg-slate-900/70"] { background-color: var(--admin-surface-soft) !important; }
        [class~="text-white"] { color: var(--admin-text) !important; }
        [class~="text-slate-300"] { color: var(--admin-muted) !important; }
        [class~="text-slate-400"] { color: #81aac9 !important; }
        [class~="text-slate-500"] { color: #6f95b5 !important; }
        [class~="hover:text-white"]:hover { color: #f8fbff !important; }
        [class~="hover:bg-white/5"]:hover { background-color: rgba(129, 185, 221, .14) !important; }
        [class~="shadow-black/10"], [class~="shadow-black/20"] { --tw-shadow-color: rgba(4, 14, 30, .24) !important; }
    </style>
</head>
<body class="bg-slate-950 text-white">
    @php
        $adminLogo = $siteSettings?->logo_path ? asset($siteSettings->logo_path) : ($siteSettings?->logo_url ?: null);
        $adminLinks = [
            ['label' => __('admin.nav_home'), 'route' => 'admin.dashboard'],
            ['label' => __('admin.nav_settings'), 'route' => 'admin.settings.edit'],
            ['label' => __('admin.nav_products'), 'route' => 'admin.products.index'],
            ['label' => __('admin.nav_home_sections'), 'route' => 'admin.home-sections.index'],
            ['label' => __('admin.nav_about_sections'), 'route' => 'admin.about-sections.index'],
            ['label' => __('admin.nav_articles'), 'route' => 'admin.articles.index'],
            ['label' => __('admin.nav_testimonials'), 'route' => 'admin.testimonials.index'],
            ['label' => __('admin.nav_languages'), 'route' => 'admin.languages.index'],
            ['label' => __('admin.nav_quotes'), 'route' => 'admin.quotes.index'],
            ['label' => __('admin.nav_messages'), 'route' => 'admin.messages.index'],
        ];
    @endphp

    <div class="flex min-h-screen">
        <aside class="hidden w-80 shrink-0 border-l border-white/10 bg-[linear-gradient(180deg,#020617,#0f172a)] lg:flex lg:flex-col">
            <div class="border-b border-white/10 p-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4">
                    @if ($adminLogo)
                        <img src="{{ $adminLogo }}" alt="logo" class="h-14 w-14 rounded-2xl object-cover shadow-lg shadow-amber-400/20">
                    @else
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-400 text-slate-950 font-black">NF</div>
                    @endif
                    <div>
                        <p class="text-xl font-black text-amber-300">{{ $siteSettings?->translate('site_name') ?? 'Nofouth Future Company' }}</p>
                        <p class="text-sm text-slate-400">{{ __('admin.site_control_panel') }}</p>
                    </div>
                </a>
            </div>

            <div class="px-4 py-5">
                <p class="mb-3 px-4 text-xs font-bold tracking-[0.3em] text-slate-500">{{ __('admin.admin_section') }}</p>
                <nav class="space-y-2">
                    @foreach ($adminLinks as $link)
                        <a href="{{ route($link['route']) }}" class="flex items-center justify-between rounded-2xl px-4 py-3 font-bold transition {{ request()->routeIs($link['route']) ? 'bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                            <span>{{ $link['label'] }}</span>
                            <span class="text-xs opacity-70">›</span>
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="mt-auto border-t border-white/10 p-4">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="w-full rounded-2xl border border-white/10 px-4 py-3 text-slate-300 transition hover:bg-white/5 hover:text-white">{{ __('admin.logout') }}</button>
                </form>
            </div>
        </aside>

        <div class="flex min-h-screen flex-1 flex-col">
            <header class="border-b border-white/10 bg-slate-900/70 px-4 py-4 backdrop-blur sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate-400">{{ __('admin.dashboard_intro') }}</p>
                        <h1 class="text-2xl font-black text-white">{{ $title ?? __('admin.dashboard') }}</h1>
                    </div>
                    <a href="{{ route('home') }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm font-bold text-slate-300 transition hover:text-white">{{ __('admin.view_site') }}</a>
                </div>
            </header>

            @if (session('success'))
                <div class="px-4 pt-6 sm:px-6 lg:px-8">
                    <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-emerald-100">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="px-4 pt-6 sm:px-6 lg:px-8">
                    <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 px-5 py-4 text-rose-100">
                        <p class="mb-2 font-bold">{{ __('admin.review_fields') }}</p>
                        <ul class="space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <main class="flex-1">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
