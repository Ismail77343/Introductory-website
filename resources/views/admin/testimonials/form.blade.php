@extends('layouts.admin', ['title' => $isEditing ? __('admin.edit_testimonial') : __('admin.new_testimonial')])

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 lg:p-8">
            <h1 class="text-4xl font-black text-white">{{ $isEditing ? __('admin.edit_testimonial') : __('admin.new_testimonial') }}</h1>

            <form method="POST" action="{{ $isEditing ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" class="mt-8 grid gap-5 md:grid-cols-2">
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif

                <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.base_client_name') }}</label><input type="text" name="client_name" value="{{ old('client_name', $testimonial->client_name) }}" required class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.base_client_title') }}</label><input type="text" name="client_title" value="{{ old('client_title', $testimonial->client_title) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.base_company_name') }}</label><input type="text" name="company_name" value="{{ old('company_name', $testimonial->company_name) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.rating') }}</label><input type="number" min="1" max="5" name="rating" value="{{ old('rating', $testimonial->rating) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">{{ __('admin.base_quote') }}</label><textarea name="quote" rows="5" required class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old('quote', $testimonial->quote) }}</textarea></div>
                <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.sort_order') }}</label><input type="number" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>

                <div class="md:col-span-2 space-y-6">
                    @foreach ($activeLanguages as $language)
                        <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/60 p-5">
                            <h2 class="text-2xl font-black text-amber-300">{{ $language->native_name }} ({{ strtoupper($language->code) }})</h2>
                            <div class="mt-5 grid gap-5 md:grid-cols-2">
                                <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.client') }}</label><input type="text" name="translations[{{ $language->code }}][client_name]" value="{{ old("translations.{$language->code}.client_name", $testimonial->translationInput('client_name', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.client_title') }}</label><input type="text" name="translations[{{ $language->code }}][client_title]" value="{{ old("translations.{$language->code}.client_title", $testimonial->translationInput('client_title', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.company_name') }}</label><input type="text" name="translations[{{ $language->code }}][company_name]" value="{{ old("translations.{$language->code}.company_name", $testimonial->translationInput('company_name', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">{{ __('admin.quote') }}</label><textarea name="translations[{{ $language->code }}][quote]" rows="4" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.quote", $testimonial->translationInput('quote', $language->code)) }}</textarea></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <label class="flex items-center gap-3 text-slate-300">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $testimonial->is_active))>
                    {{ __('admin.active_status') }}
                </label>

                <div class="md:col-span-2 flex gap-3">
                    <button class="rounded-2xl bg-amber-400 px-8 py-4 font-bold text-slate-950">{{ $isEditing ? __('admin.save_changes') : __('admin.add_testimonial') }}</button>
                    <a href="{{ route('admin.testimonials.index') }}" class="rounded-2xl border border-white/10 px-8 py-4 font-bold text-white">{{ __('admin.cancel') }}</a>
                </div>
            </form>
        </div>
    </section>
@endsection
