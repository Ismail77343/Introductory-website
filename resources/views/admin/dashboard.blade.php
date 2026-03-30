@extends('layouts.admin', ['title' => 'لوحة الإدارة'])

@section('content')
    <section class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8 grid gap-4 xl:grid-cols-[1.2fr_.8fr]">
            <div class="rounded-[2rem] border border-white/10 bg-[linear-gradient(135deg,rgba(251,191,36,.22),rgba(15,23,42,.4))] p-8">
                <h2 class="text-4xl font-black text-white">إدارة واضحة لكل أجزاء الموقع</h2>
                <p class="mt-3 max-w-2xl text-lg leading-8 text-slate-200">
                    من هنا تستطيع تعديل الهوية، محتوى الصفحة الرئيسية، صفحة من نحن، المقالات، آراء العملاء، الرسائل، وطلبات التسعير من مكان واحد.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('admin.settings.edit') }}" class="rounded-2xl bg-amber-400 px-5 py-3 font-bold text-slate-950">إعدادات الموقع</a>
                    <a href="{{ route('admin.about-sections.index') }}" class="rounded-2xl border border-white/10 px-5 py-3 font-bold text-white">صفحة من نحن</a>
                    <a href="{{ route('admin.articles.index') }}" class="rounded-2xl border border-white/10 px-5 py-3 font-bold text-white">إدارة المقالات</a>
                    <a href="{{ route('admin.quotes.index') }}" class="rounded-2xl border border-white/10 px-5 py-3 font-bold text-white">طلبات التسعير</a>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-1">
                <a href="{{ route('admin.messages.index') }}" class="rounded-[2rem] border border-white/10 bg-white/5 p-6">
                    <p class="text-sm text-slate-400">الرسائل</p>
                    <p class="mt-3 text-4xl font-black text-white">{{ $stats['messages'] }}</p>
                </a>
                <a href="{{ route('admin.quotes.index') }}" class="rounded-[2rem] border border-white/10 bg-white/5 p-6">
                    <p class="text-sm text-slate-400">طلبات التسعير</p>
                    <p class="mt-3 text-4xl font-black text-white">{{ $stats['quotes'] }}</p>
                </a>
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6"><p class="text-sm text-slate-400">المنتجات</p><p class="mt-2 text-4xl font-black">{{ $stats['products'] }}</p></div>
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6"><p class="text-sm text-slate-400">طلبات التسعير</p><p class="mt-2 text-4xl font-black">{{ $stats['quotes'] }}</p></div>
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6"><p class="text-sm text-slate-400">الرسائل</p><p class="mt-2 text-4xl font-black">{{ $stats['messages'] }}</p></div>
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6"><p class="text-sm text-slate-400">المنتجات المميزة</p><p class="mt-2 text-4xl font-black">{{ $stats['featured'] }}</p></div>
        </div>

        <div class="mt-5 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            <a href="{{ route('admin.home-sections.index') }}" class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-400">أقسام الرئيسية</p>
                <p class="mt-2 text-3xl font-black text-white">{{ $stats['sections'] }}</p>
            </a>
            <a href="{{ route('admin.about-sections.index') }}" class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-400">أقسام من نحن</p>
                <p class="mt-2 text-3xl font-black text-white">{{ $stats['about_sections'] }}</p>
            </a>
            <a href="{{ route('admin.articles.index') }}" class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-400">المقالات</p>
                <p class="mt-2 text-3xl font-black text-white">{{ $stats['articles'] }}</p>
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-400">آراء العملاء</p>
                <p class="mt-2 text-3xl font-black text-white">{{ $stats['testimonials'] }}</p>
            </a>
        </div>

        <div class="mt-5 grid gap-5 md:grid-cols-3">
            <a href="{{ route('admin.home-sections.index') }}" class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-400">تعديل أقسام الرئيسية</p>
                <p class="mt-2 text-xl font-black text-white">فتح القائمة</p>
            </a>
            <a href="{{ route('admin.about-sections.index') }}" class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-400">تعديل صفحة من نحن</p>
                <p class="mt-2 text-xl font-black text-white">فتح القائمة</p>
            </a>
            <a href="{{ route('admin.settings.edit') }}" class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-400">هوية الموقع والتواصل</p>
                <p class="mt-2 text-xl font-black text-white">تعديل مباشر</p>
            </a>
        </div>

        <div class="mt-10 grid gap-8 lg:grid-cols-2">
            <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6">
                <h2 class="text-2xl font-black text-white">أحدث طلبات التسعير</h2>
                <div class="mt-5 space-y-4">
                    @forelse ($recentQuotes as $quote)
                        <div class="rounded-3xl border border-white/10 bg-slate-900/70 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-bold text-white">{{ $quote->company_name }}</p>
                                <span class="text-xs text-amber-300">{{ $quote->status }}</span>
                            </div>
                            <p class="mt-2 text-sm text-slate-400">{{ $quote->contact_person }} - {{ $quote->email }}</p>
                            <p class="mt-2 text-sm text-slate-300">
                                @foreach ($quote->items as $item)
                                    {{ $item->product_name }} ({{ rtrim(rtrim(number_format($item->quantity, 2), '0'), '.') }} {{ $item->unit }}){{ !$loop->last ? '، ' : '' }}
                                @endforeach
                            </p>
                        </div>
                    @empty
                        <p class="text-slate-400">لا توجد طلبات بعد.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6">
                <h2 class="text-2xl font-black text-white">أحدث الرسائل</h2>
                <div class="mt-5 space-y-4">
                    @forelse ($recentMessages as $message)
                        <div class="rounded-3xl border border-white/10 bg-slate-900/70 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-bold text-white">{{ $message->name }}</p>
                                <span class="text-xs text-amber-300">{{ $message->subject }}</span>
                            </div>
                            <p class="mt-2 text-sm text-slate-400">{{ $message->email }}</p>
                            <p class="mt-2 text-sm leading-7 text-slate-300">{{ $message->message }}</p>
                        </div>
                    @empty
                        <p class="text-slate-400">لا توجد رسائل بعد.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
