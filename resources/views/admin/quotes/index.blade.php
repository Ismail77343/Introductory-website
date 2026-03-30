@extends('layouts.admin', ['title' => 'طلبات التسعير'])

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-black text-white">طلبات التسعير</h1>
            <p class="mt-2 text-slate-300">هذه الطلبات محفوظة في قاعدة البيانات ولا تظهر إلا بعد تسجيل الدخول.</p>
        </div>

        <div class="space-y-5">
            @foreach ($quotes as $quote)
                <article class="rounded-[2rem] border border-white/10 bg-white/5 p-6">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-black text-white">{{ $quote->company_name }}</h2>
                            <p class="mt-2 text-slate-300">{{ $quote->contact_person }} - {{ $quote->email }} - {{ $quote->phone }}</p>
                        </div>
                        <span class="rounded-full bg-amber-400/10 px-4 py-2 text-sm font-bold text-amber-300">{{ $quote->status }}</span>
                    </div>
                    <div class="mt-5 overflow-hidden rounded-[1.5rem] border border-white/10">
                        <table class="min-w-full text-right text-sm">
                            <thead class="bg-white/5 text-slate-300">
                                <tr>
                                    <th class="px-4 py-3">المنتج</th>
                                    <th class="px-4 py-3">الكمية</th>
                                    <th class="px-4 py-3">الوحدة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quote->items as $item)
                                    <tr class="border-t border-white/10 text-slate-200">
                                        <td class="px-4 py-3">{{ $item->product_name }}</td>
                                        <td class="px-4 py-3">{{ rtrim(rtrim(number_format($item->quantity, 2), '0'), '.') }}</td>
                                        <td class="px-4 py-3">{{ $item->unit }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($quote->notes)
                        <p class="mt-4 text-slate-300">{{ $quote->notes }}</p>
                    @endif
                </article>
            @endforeach
        </div>
    </section>
@endsection
