<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $currentLanguage?->direction ?? 'rtl' }}" data-theme="dark">
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
            --brand-a: {{ $siteSettings?->theme_primary_color ?: '#fbbf24' }};
            --brand-b: {{ $siteSettings?->theme_secondary_color ?: '#38bdf8' }};
        }
        body { font-family: 'Cairo', sans-serif; }
        .required-mark { margin-inline-start: .35rem; color: #f87171; font-weight: 900; }
        a, button, input, select, textarea { transition: background-color .22s ease, color .22s ease, border-color .22s ease, box-shadow .22s ease, transform .22s ease; }
        :where(a,button,input,select,textarea):focus-visible { outline: none; box-shadow: 0 0 0 4px color-mix(in oklab, var(--brand-a) 28%, transparent); }
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

        /* Light theme (Dark stays as-is). */
        html[data-theme="light"] body { background-color: #f8fafc !important; color: #0f172a !important; }
        html[data-theme="light"] .bg-slate-950 { background-color: #f8fafc !important; }
        html[data-theme="light"] .bg-slate-900 { background-color: #ffffff !important; }
        html[data-theme="light"] .bg-slate-900\/70 { background-color: rgba(255,255,255,.86) !important; }
        html[data-theme="light"] .bg-slate-900\/95 { background-color: rgba(255,255,255,.92) !important; }
        html[data-theme="light"] .bg-slate-950\/80 { background-color: rgba(248,250,252,.86) !important; }
        html[data-theme="light"] .bg-slate-950\/75 { background-color: rgba(248,250,252,.84) !important; }
        html[data-theme="light"] .bg-slate-950\/70 { background-color: rgba(248,250,252,.80) !important; }
        html[data-theme="light"] .bg-slate-950\/60 { background-color: rgba(248,250,252,.78) !important; }
        /* Forms use bg-slate-950/50 heavily — was missing, so cards stayed dark grey in Light. */
        html[data-theme="light"] .bg-slate-950\/50 {
            background: linear-gradient(
                135deg,
                rgba(255,255,255,.94),
                color-mix(in oklab, var(--brand-b) 6%, white),
                rgba(248,250,252,.88)
            ) !important;
            backdrop-filter: blur(12px);
            box-shadow: 0 16px 42px rgba(2, 6, 23, .09);
            border-color: rgba(15,23,42,.08) !important;
        }
        html[data-theme="light"] .text-white { color: #0f172a !important; }
        html[data-theme="light"] .text-slate-100 { color: rgba(15,23,42,.88) !important; }
        html[data-theme="light"] .text-slate-200 { color: rgba(15,23,42,.80) !important; }
        html[data-theme="light"] .text-slate-300 { color: rgba(15,23,42,.72) !important; }
        html[data-theme="light"] .text-slate-400 { color: rgba(15,23,42,.62) !important; }
        html[data-theme="light"] .text-slate-500 { color: rgba(15,23,42,.52) !important; }
        html[data-theme="light"] .border-white\/10 { border-color: rgba(15,23,42,.10) !important; }
        html[data-theme="light"] .bg-white\/5 {
            background: linear-gradient(
                135deg,
                rgba(255,255,255,.86),
                rgba(255,255,255,.70)
            ) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 16px 44px rgba(2, 6, 23, .10);
        }
        html[data-theme="light"] .bg-white\/10 {
            background: linear-gradient(
                135deg,
                rgba(255,255,255,.92),
                rgba(255,255,255,.76)
            ) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 16px 44px rgba(2, 6, 23, .10);
        }
        html[data-theme="light"] .hover\:bg-white\/5:hover { background-color: rgba(15,23,42,.05) !important; }
        html[data-theme="light"] .hover\:text-white:hover { color: #0b1220 !important; }

        html[data-theme="light"] .text-amber-300 { color: rgba(146,64,14,.92) !important; }
        html[data-theme="light"] .bg-amber-400\/20 { background-color: color-mix(in oklab, var(--brand-a) 22%, transparent) !important; }

        /* Make admin sidebar + shell feel native Light. */
        html[data-theme="light"] aside {
            background: linear-gradient(180deg, #ffffff, #f8fafc 55%, #f1f5f9) !important;
            border-color: rgba(15,23,42,.10) !important;
        }
        html[data-theme="light"] aside .text-slate-300 { color: rgba(15,23,42,.70) !important; }
        html[data-theme="light"] aside .text-slate-400 { color: rgba(15,23,42,.58) !important; }
        html[data-theme="light"] aside .text-slate-500 { color: rgba(15,23,42,.48) !important; }
        html[data-theme="light"] aside a:hover { background-color: rgba(15,23,42,.05) !important; }
        html[data-theme="light"] aside a.bg-amber-400 { box-shadow: 0 18px 40px color-mix(in oklab, var(--brand-a) 28%, transparent) !important; }

        html[data-theme="light"] header.bg-slate-900\/70 { background-color: rgba(255,255,255,.82) !important; }
        html[data-theme="light"] .admin-hero {
            background: radial-gradient(circle at 10% 20%, color-mix(in oklab, var(--brand-a) 32%, transparent), transparent 40%),
                        radial-gradient(circle at 90% 10%, color-mix(in oklab, var(--brand-b) 18%, transparent), transparent 38%),
                        linear-gradient(135deg, rgba(255,255,255,.92), rgba(248,250,252,.74)) !important;
            border-color: rgba(15,23,42,.10) !important;
            box-shadow: 0 20px 55px rgba(2, 6, 23, .12);
            backdrop-filter: blur(10px);
        }

        html[data-theme="light"] .bg-rose-500\/20 { background-color: rgba(244,63,94,.12) !important; }
        html[data-theme="light"] .text-rose-200 { color: rgb(190,18,60) !important; }
        html[data-theme="light"] .border-rose-500\/30 { border-color: rgba(244,63,94,.26) !important; }
        html[data-theme="light"] .bg-rose-500\/10 { background-color: rgba(244,63,94,.08) !important; }

        /* Admin forms in Light. */
        html[data-theme="light"] input,
        html[data-theme="light"] select,
        html[data-theme="light"] textarea {
            background-color: rgba(255,255,255,.92) !important;
            border-color: rgba(15,23,42,.12) !important;
            color: #0f172a !important;
            box-shadow: 0 10px 26px rgba(2, 6, 23, .06);
        }
        html[data-theme="light"] select { color-scheme: light; }
        html[data-theme="light"] input:focus,
        html[data-theme="light"] select:focus,
        html[data-theme="light"] textarea:focus {
            outline: none;
            border-color: color-mix(in oklab, var(--brand-a) 70%, white) !important;
            box-shadow: 0 0 0 4px color-mix(in oklab, var(--brand-a) 22%, transparent), 0 14px 28px rgba(2, 6, 23, .08);
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
                        <button type="button" class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-bold text-slate-300 transition hover:text-white" data-theme-toggle aria-label="Toggle theme">
                            <span data-theme-label>Dark</span>
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-white/10 bg-slate-950/60" aria-hidden="true">
                                <svg data-theme-icon-moon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-amber-200">
                                    <path d="M21.752 15.002A9.718 9.718 0 0 1 12.01 22C6.486 22 2 17.514 2 11.99A9.718 9.718 0 0 1 8.998 2.248a.75.75 0 0 1 .87.87A8.218 8.218 0 0 0 19.88 14.132a.75.75 0 0 1 .872.87Z"/>
                                </svg>
                                <svg data-theme-icon-sun xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-5 w-5 text-amber-500">
                                    <path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 12 2.25Zm0 16.5a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-1.5a.75.75 0 0 1 .75-.75ZM4.72 4.72a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 1 1-1.06 1.06L4.72 5.78a.75.75 0 0 1 0-1.06Zm12.44 12.44a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 1 1-1.06 1.06l-1.06-1.06a.75.75 0 0 1 0-1.06ZM2.25 12a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1-.75-.75Zm16.5 0a.75.75 0 0 1 .75-.75H21a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM4.72 19.28a.75.75 0 0 1 0-1.06l1.06-1.06a.75.75 0 1 1 1.06 1.06l-1.06 1.06a.75.75 0 0 1-1.06 0Zm12.44-12.44a.75.75 0 0 1 0-1.06l1.06-1.06a.75.75 0 1 1 1.06 1.06l-1.06 1.06a.75.75 0 0 1-1.06 0ZM12 6.75a5.25 5.25 0 1 0 0 10.5 5.25 5.25 0 0 0 0-10.5Z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </button>
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
        const themeStorageKey = 'nofouth_theme';
        const root = document.documentElement;
        const applyTheme = (theme) => {
            const value = theme === 'light' ? 'light' : 'dark';
            root.setAttribute('data-theme', value);
            document.querySelectorAll('[data-theme-label]').forEach((el) => {
                el.textContent = value === 'light' ? 'Light' : 'Dark';
            });
            document.querySelectorAll('[data-theme-icon-moon]').forEach((el) => {
                el.classList.toggle('hidden', value === 'light');
            });
            document.querySelectorAll('[data-theme-icon-sun]').forEach((el) => {
                el.classList.toggle('hidden', value !== 'light');
            });
        };
        applyTheme(localStorage.getItem(themeStorageKey) || 'dark');
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

        let pendingDeleteForm = null;
        const deleteModal = document.createElement('div');
        deleteModal.className = 'fixed inset-0 z-[90] hidden items-center justify-center bg-slate-950/80 p-4';
        deleteModal.innerHTML = `
            <div class="w-full max-w-md rounded-[2rem] border border-white/10 bg-slate-900 p-6">
                <h3 class="text-2xl font-black text-white">{{ __('admin.delete') }}</h3>
                <p class="mt-3 text-slate-300" data-delete-message>{{ __('admin.review_fields') }}</p>
                <div class="mt-6 flex gap-3">
                    <button type="button" class="flex-1 rounded-2xl border border-white/10 px-5 py-3 font-bold text-white" data-delete-cancel>{{ __('admin.cancel') }}</button>
                    <button type="button" class="flex-1 rounded-2xl bg-rose-500/20 px-5 py-3 font-bold text-rose-200" data-delete-confirm>{{ __('admin.delete') }}</button>
                </div>
            </div>
        `;
        document.body.appendChild(deleteModal);

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

        document.querySelectorAll('form[data-delete-confirm]').forEach((form) => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                pendingDeleteForm = form;
                deleteModal.querySelector('[data-delete-message]').textContent = form.dataset.deleteConfirm;
                deleteModal.classList.remove('hidden');
                deleteModal.classList.add('flex');
            });
        });

        deleteModal.querySelector('[data-delete-cancel]').addEventListener('click', () => {
            pendingDeleteForm = null;
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
        });

        deleteModal.querySelector('[data-delete-confirm]').addEventListener('click', () => {
            pendingDeleteForm?.submit();
        });

        deleteModal.addEventListener('click', (event) => {
            if (event.target === deleteModal) {
                pendingDeleteForm = null;
                deleteModal.classList.add('hidden');
                deleteModal.classList.remove('flex');
            }
        });
    </script>
</body>
</html>
