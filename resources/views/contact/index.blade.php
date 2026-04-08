@extends('layouts.app', ['title' => __('ui.contact')])

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-3">
            @php
                $mapEmbedUrl = $siteSettings?->map_embed_url;
            @endphp
            <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6">
                <h1 class="text-3xl font-black text-white">{{ __('ui.contact') }}</h1>
                <p class="mt-4 leading-8 text-slate-300">{{ __('ui.contact_intro') }}</p>
                <div class="mt-6 space-y-3 text-slate-300">
                    <p>{{ $siteSettings?->translate('contact_address') ?? 'Riyadh - Saudi Arabia' }}</p>
                    <p>{{ $siteSettings->contact_phone ?? '+966 577252986' }}</p>
                    <p>{{ $siteSettings->contact_email ?? 'info@nofouthfuture.com' }}</p>
                    @if ($siteSettings?->whatsapp_number)
                        <p>WhatsApp: {{ $siteSettings->whatsapp_number }}</p>
                    @endif
                </div>
            </div>

            <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 lg:col-span-2">
                @if ($mapEmbedUrl)
                    <div class="mb-6 overflow-hidden rounded-[1.5rem] border border-white/10">
                        <iframe src="{{ $mapEmbedUrl }}" class="h-[340px] w-full" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                @endif
                <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                    @csrf
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm text-slate-300">{{ __('ui.name_or_company') }}</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm text-slate-300">{{ __('ui.email') }}</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">
                        </div>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-slate-300">{{ __('ui.inquiry_type') }}</label>
                        <select name="subject" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">
                            <option value="{{ __('ui.quote_request') }}" @selected(old('subject') === __('ui.quote_request'))>{{ __('ui.quote_request') }}</option>
                            <option value="{{ __('ui.technical_inquiry') }}" @selected(old('subject') === __('ui.technical_inquiry'))>{{ __('ui.technical_inquiry') }}</option>
                            <option value="{{ __('ui.general_inquiry') }}" @selected(old('subject') === __('ui.general_inquiry'))>{{ __('ui.general_inquiry') }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-slate-300">{{ __('ui.message') }}</label>
                        <textarea name="message" rows="6" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old('message') }}</textarea>
                    </div>
                    <button class="rounded-2xl bg-amber-400 px-8 py-4 font-bold text-slate-950">{{ __('ui.send_message') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
