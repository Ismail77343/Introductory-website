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
        body { font-family: 'Cairo', sans-serif; }
        .admin-toast-enter { animation: adminToastIn .28s ease-out; }
        .admin-toast-exit { animation: adminToastOut .2s ease-in forwards; }
        @keyframes adminToastIn {
            from { opacity: 0; transform: translateY(-14px) scale(.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes adminToastOut {
            from { opacity: 1; transform: translateY(0) scale(1); }
            to { opacity: 0; transform: translateY(-12px) scale(.98); }
        }
    </style>
</head>
<body class="bg-slate-950 text-white">
    @php
        $adminLogo = $siteSettings?->logo_path ? asset($siteSettings->logo_path) : ($siteSettings?->logo_url ?: null);
        $adminUser = auth()->user();
        $adminLinks = [
            ['label' => __('admin.nav_home'), 'route' => 'admin.dashboard', 'permission' => 'dashboard.view'],
            ['label' => __('admin.nav_settings'), 'route' => 'admin.settings.edit', 'permission' => 'settings.manage'],
            ['label' => __('admin.nav_products'), 'route' => 'admin.products.index', 'permission' => 'products.manage'],
            ['label' => __('admin.nav_home_sections'), 'route' => 'admin.home-sections.index', 'permission' => 'home_sections.manage'],
            ['label' => __('admin.nav_about_sections'), 'route' => 'admin.about-sections.index', 'permission' => 'about_sections.manage'],
            ['label' => __('admin.nav_articles'), 'route' => 'admin.articles.index', 'permission' => 'articles.manage'],
            ['label' => __('admin.nav_testimonials'), 'route' => 'admin.testimonials.index', 'permission' => 'testimonials.manage'],
            ['label' => __('admin.nav_languages'), 'route' => 'admin.languages.index', 'permission' => 'languages.manage'],
            ['label' => __('admin.nav_quotes'), 'route' => 'admin.quotes.index', 'permission' => 'quotes.view'],
            ['label' => __('admin.nav_messages'), 'route' => 'admin.messages.index', 'permission' => 'messages.view'],
            ['label' => __('admin.nav_roles'), 'route' => 'admin.roles.index', 'permission' => 'roles.manage'],
            ['label' => __('admin.nav_users'), 'route' => 'admin.users.index', 'permission' => 'users.manage'],
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
                        <p class="text-xl font-black text-amber-300">{{ $siteSettings?->translate('site_name') ?? 'Nofouth Future' }}</p>
                        <p class="text-sm text-slate-400">{{ __('admin.site_control_panel') }}</p>
                    </div>
                </a>
            </div>

            <div class="px-4 py-5">
                <p class="mb-3 px-4 text-xs font-bold tracking-[0.3em] text-slate-500">{{ __('admin.admin_section') }}</p>
                <nav class="space-y-2">
                    @foreach ($adminLinks as $link)
                        @continue(! $adminUser || ! $adminUser->hasPermission($link['permission']))
                        <a href="{{ route($link['route']) }}" class="flex items-center justify-between rounded-2xl px-4 py-3 font-bold transition {{ request()->routeIs($link['route']) ? 'bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                            <span>{{ $link['label'] }}</span>
                            <span class="text-xs opacity-70">›</span>
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="mt-auto space-y-4 border-t border-white/10 p-4">
                @if ($adminUser)
                    <a href="{{ route('admin.profile.edit') }}" class="flex items-center justify-between rounded-2xl border border-white/10 px-4 py-3 text-slate-300 transition hover:bg-white/5 hover:text-white">
                        <div>
                            <p class="font-bold text-white">{{ $adminUser->name }}</p>
                            <p class="text-sm text-slate-400">{{ $adminUser->job_title ?: __('admin.nav_profile') }}</p>
                        </div>
                        <span class="text-xs opacity-70">&rsaquo;</span>
                    </a>
                @endif
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
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('admin.profile.edit') }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm font-bold text-slate-300 transition hover:text-white">{{ __('admin.nav_profile') }}</a>
                        <a href="{{ route('home') }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm font-bold text-slate-300 transition hover:text-white">{{ __('admin.view_site') }}</a>
                    </div>
                </div>
            </header>

            <main class="flex-1">
                @yield('content')
            </main>
        </div>
    </div>
    <div class="pointer-events-none fixed inset-x-4 top-4 z-[80] mx-auto flex max-w-xl flex-col gap-3 sm:right-6 sm:left-auto sm:mx-0 sm:w-full sm:max-w-md">
        @if (session('success'))
            <div class="admin-toast-enter pointer-events-auto rounded-[1.5rem] border border-emerald-500/30 bg-slate-900/95 p-4 shadow-2xl shadow-emerald-900/20 backdrop-blur" data-admin-toast>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-black text-emerald-300">{{ __('admin.toast_success_title') }}</p>
                        <p class="mt-1 text-sm text-slate-100">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="rounded-full border border-white/10 px-3 py-1 text-xs font-bold text-slate-300" data-close-toast>{{ __('admin.close') }}</button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="admin-toast-enter pointer-events-auto rounded-[1.5rem] border border-amber-500/30 bg-slate-900/95 p-4 shadow-2xl shadow-amber-900/20 backdrop-blur" data-admin-toast data-toast-persist>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-black text-amber-300">{{ __('admin.toast_error_title') }}</p>
                        <p class="mt-1 text-sm text-slate-100">{{ session('error') }}</p>
                    </div>
                    <button type="button" class="rounded-full border border-white/10 px-3 py-1 text-xs font-bold text-slate-300" data-close-toast>{{ __('admin.close') }}</button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="admin-toast-enter pointer-events-auto rounded-[1.5rem] border border-rose-500/30 bg-slate-900/95 p-4 shadow-2xl shadow-rose-900/20 backdrop-blur" data-admin-toast data-toast-persist>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-black text-rose-300">{{ __('admin.toast_error_title') }}</p>
                        <p class="mt-1 text-sm text-slate-100">{{ __('admin.review_fields') }}</p>
                        <ul class="mt-2 space-y-1 text-sm text-slate-300">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="rounded-full border border-white/10 px-3 py-1 text-xs font-bold text-slate-300" data-close-toast>{{ __('admin.close') }}</button>
                </div>
            </div>
        @endif
    </div>
    <script>
        document.querySelectorAll('[data-close-toast]').forEach((button) => {
            button.addEventListener('click', () => {
                const toast = button.closest('[data-admin-toast]');
                toast?.classList.add('admin-toast-exit');
                setTimeout(() => toast?.remove(), 180);
            });
        });

        document.querySelectorAll('[data-admin-toast]:not([data-toast-persist])').forEach((toast) => {
            setTimeout(() => {
                toast.classList.add('admin-toast-exit');
                setTimeout(() => toast.remove(), 180);
            }, 3500);
        });
    </script>
</body>
</html>
