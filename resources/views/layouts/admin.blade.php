<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'لوحة الإدارة' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-white">
    <div class="flex min-h-screen">
        <aside class="hidden w-80 shrink-0 border-l border-white/10 bg-[linear-gradient(180deg,#020617,#0f172a)] lg:flex lg:flex-col">
            <div class="border-b border-white/10 p-6">
                @php
                    $adminLogo = $siteSettings?->logo_path ? asset($siteSettings->logo_path) : ($siteSettings?->logo_url ?: null);
                    $adminLinks = [
                        ['label' => 'الرئيسية', 'route' => 'admin.dashboard'],
                        ['label' => 'إعدادات الموقع', 'route' => 'admin.settings.edit'],
                        ['label' => 'المنتجات', 'route' => 'admin.products.index'],
                        ['label' => 'أقسام الرئيسية', 'route' => 'admin.home-sections.index'],
                        ['label' => 'صفحة من نحن', 'route' => 'admin.about-sections.index'],
                        ['label' => 'المقالات', 'route' => 'admin.articles.index'],
                        ['label' => 'آراء العملاء', 'route' => 'admin.testimonials.index'],
                        ['label' => 'اللغات', 'route' => 'admin.languages.index'],
                        ['label' => 'طلبات التسعير', 'route' => 'admin.quotes.index'],
                        ['label' => 'رسائل التواصل', 'route' => 'admin.messages.index'],
                    ];
                @endphp

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4">
                    @if ($adminLogo)
                        <img src="{{ $adminLogo }}" alt="logo" class="h-14 w-14 rounded-2xl object-cover shadow-lg shadow-amber-400/20">
                    @else
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-400 text-slate-950 font-black">NF</div>
                    @endif
                    <div>
                        <p class="text-xl font-black text-amber-300">{{ $siteSettings->site_name ?? 'شركة نفوذ المستقبل' }}</p>
                        <p class="text-sm text-slate-400">لوحة تحكم الموقع</p>
                    </div>
                </a>
            </div>

            <div class="px-4 py-5">
                <p class="mb-3 px-4 text-xs font-bold tracking-[0.3em] text-slate-500">ADMIN</p>
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
                    <button class="w-full rounded-2xl border border-white/10 px-4 py-3 text-slate-300 transition hover:bg-white/5 hover:text-white">تسجيل الخروج</button>
                </form>
            </div>
        </aside>

        <div class="flex min-h-screen flex-1 flex-col">
            <header class="border-b border-white/10 bg-slate-900/70 px-4 py-4 backdrop-blur sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate-400">لوحة إدارة مرتبة وسهلة لتعديل الموقع بالكامل</p>
                        <h1 class="text-2xl font-black text-white">{{ $title ?? 'لوحة الإدارة' }}</h1>
                    </div>
                    <a href="{{ route('home') }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm font-bold text-slate-300 transition hover:text-white">عرض الموقع</a>
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
                        <p class="mb-2 font-bold">يرجى مراجعة الحقول التالية:</p>
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
