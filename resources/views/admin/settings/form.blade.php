@extends('layouts.admin', ['title' => __('admin.settings_title')])

@section('content')
    @php
        $logoPath = old('logo_path', $settings->logo_path);
        $logoUrl = old('logo_url', $settings->logo_url);
        $defaultArticleImagePath = old('default_article_image_path', $settings->default_article_image_path);
        $defaultArticleImageUrl = old('default_article_image_url', $settings->default_article_image_url);
        $logoPreview = $logoPath ? asset($logoPath) : ($logoUrl ?: null);
        $defaultArticlePreview = $defaultArticleImagePath ? asset($defaultArticleImagePath) : ($defaultArticleImageUrl ?: null);
        $themePrimaryColor = old('theme_primary_color', $settings->theme_primary_color ?: '#fbbf24');
        $themeSecondaryColor = old('theme_secondary_color', $settings->theme_secondary_color ?: '#38bdf8');
    @endphp

    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 lg:p-8">
            <h1 class="text-4xl font-black text-white">{{ __('admin.settings_title') }}</h1>
            <p class="mt-3 text-slate-300">{{ __('admin.settings_intro') }}</p>

            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="mt-8 grid gap-5 md:grid-cols-2">
                @csrf
                @method('PUT')

                <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.email') }}</label><input type="email" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.phone') }}</label><input type="text" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.whatsapp') }}</label><input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings->whatsapp_number) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">{{ __('admin.map_embed_url') }}</label><input type="url" name="map_embed_url" value="{{ old('map_embed_url', $settings->map_embed_url) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>

                <div class="md:col-span-2 grid gap-4 lg:grid-cols-2">
                    <article class="rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-5">
                        <p class="text-sm text-slate-400">{{ __('admin.logo') }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ __('admin.logo_card_help') }}</p>
                        <div class="mt-4">
                            @if ($logoPreview)
                                <img src="{{ $logoPreview }}" alt="{{ __('admin.logo') }}" class="h-40 w-full rounded-2xl object-cover">
                            @else
                                <div class="flex h-40 items-center justify-center rounded-2xl border border-dashed border-white/10 text-slate-500">{{ __('admin.no_media') }}</div>
                            @endif
                        </div>
                        <button type="button" data-modal-target="logo-modal" class="mt-4 w-full rounded-2xl bg-white/10 px-4 py-3 font-bold text-white">{{ __('admin.manage_logo') }}</button>
                    </article>

                    <article class="rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-5">
                        <p class="text-sm text-slate-400">{{ __('admin.default_article_image') }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ __('admin.default_article_image_help') }}</p>
                        <div class="mt-4">
                            @if ($defaultArticlePreview)
                                <img src="{{ $defaultArticlePreview }}" alt="{{ __('admin.default_article_image') }}" class="h-40 w-full rounded-2xl object-cover">
                            @else
                                <div class="flex h-40 items-center justify-center rounded-2xl border border-dashed border-white/10 text-slate-500">{{ __('admin.no_media') }}</div>
                            @endif
                        </div>
                        <button type="button" data-modal-target="default-article-image-modal" class="mt-4 w-full rounded-2xl bg-white/10 px-4 py-3 font-bold text-white">{{ __('admin.manage_default_article_image') }}</button>
                    </article>
                </div>

                <div class="md:col-span-2 rounded-[1.75rem] border border-white/10 bg-slate-950/60 p-5">
                    <h2 class="text-2xl font-black text-amber-300">{{ __('admin.theme_colors_title') }}</h2>
                    <p class="mt-2 text-sm text-slate-300">{{ __('admin.theme_colors_help') }}</p>
                    <div class="mt-5 grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm text-slate-300">{{ __('admin.theme_primary_color') }}</label>
                            <div class="flex gap-3">
                                <input type="color" value="{{ $themePrimaryColor }}" class="h-12 w-16 cursor-pointer rounded-2xl border border-white/10 bg-slate-900 p-2" data-color-sync="theme_primary_color_picker">
                                <input type="text" name="theme_primary_color" value="{{ $themePrimaryColor }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white" placeholder="#fbbf24" data-color-target="theme_primary_color_picker">
                            </div>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm text-slate-300">{{ __('admin.theme_secondary_color') }}</label>
                            <div class="flex gap-3">
                                <input type="color" value="{{ $themeSecondaryColor }}" class="h-12 w-16 cursor-pointer rounded-2xl border border-white/10 bg-slate-900 p-2" data-color-sync="theme_secondary_color_picker">
                                <input type="text" name="theme_secondary_color" value="{{ $themeSecondaryColor }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white" placeholder="#38bdf8" data-color-target="theme_secondary_color_picker">
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="logo_path" value="{{ $logoPath }}">
                <input type="hidden" name="default_article_image_path" value="{{ $defaultArticleImagePath }}">

                <div class="md:col-span-2 space-y-8">
                    @foreach ($activeLanguages as $language)
                        <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/60 p-5">
                            <h2 class="text-2xl font-black text-amber-300">{{ $language->native_name }} ({{ strtoupper($language->code) }})</h2>
                            <div class="mt-5 grid gap-5 md:grid-cols-2">
                                <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.site_name') }}</label><input type="text" name="translations[{{ $language->code }}][site_name]" value="{{ old("translations.{$language->code}.site_name", $settings->translationInput('site_name', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.site_tagline') }}</label><input type="text" name="translations[{{ $language->code }}][site_tagline]" value="{{ old("translations.{$language->code}.site_tagline", $settings->translationInput('site_tagline', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">{{ __('admin.address') }}</label><textarea name="translations[{{ $language->code }}][contact_address]" rows="2" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.contact_address", $settings->translationInput('contact_address', $language->code)) }}</textarea></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">{{ __('admin.vision') }}</label><textarea name="translations[{{ $language->code }}][vision]" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.vision", $settings->translationInput('vision', $language->code)) }}</textarea></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">{{ __('admin.mission') }}</label><textarea name="translations[{{ $language->code }}][mission]" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.mission", $settings->translationInput('mission', $language->code)) }}</textarea></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">{{ __('admin.about_us') }}</label><textarea name="translations[{{ $language->code }}][about_text]" rows="4" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.about_text", $settings->translationInput('about_text', $language->code)) }}</textarea></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">{{ __('admin.footer_text') }}</label><textarea name="translations[{{ $language->code }}][footer_text]" rows="2" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.footer_text", $settings->translationInput('footer_text', $language->code)) }}</textarea></div>
                                <div><label class="mb-2 block text-sm text-slate-300">Meta Title</label><input type="text" name="translations[{{ $language->code }}][default_meta_title]" value="{{ old("translations.{$language->code}.default_meta_title", $settings->translationInput('default_meta_title', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div><label class="mb-2 block text-sm text-slate-300">Meta Keywords</label><input type="text" name="translations[{{ $language->code }}][default_meta_keywords]" value="{{ old("translations.{$language->code}.default_meta_keywords", $settings->translationInput('default_meta_keywords', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">Meta Description</label><textarea name="translations[{{ $language->code }}][default_meta_description]" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.default_meta_description", $settings->translationInput('default_meta_description', $language->code)) }}</textarea></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="md:col-span-2 flex gap-3">
                    <button class="rounded-2xl bg-amber-400 px-8 py-4 font-bold text-slate-950">{{ __('admin.save_settings') }}</button>
                    <a href="{{ route('admin.dashboard') }}" class="rounded-2xl border border-white/10 px-8 py-4 font-bold text-white">{{ __('admin.back_to_dashboard') }}</a>
                </div>

                <div id="logo-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/75 p-4">
                    <div class="w-full max-w-xl rounded-[2rem] border border-white/10 bg-slate-900 p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-black text-white">{{ __('admin.manage_logo') }}</h2>
                            <button type="button" data-close-modal class="text-slate-400">{{ __('admin.close') }}</button>
                        </div>
                        <div class="mt-6 space-y-5">
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.image_url') }}</label><input type="url" name="logo_url" value="{{ $logoUrl }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.upload_logo') }}</label><input type="file" name="logo_file" accept="image/*" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                        </div>
                    </div>
                </div>

                <div id="default-article-image-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/75 p-4">
                    <div class="w-full max-w-xl rounded-[2rem] border border-white/10 bg-slate-900 p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-black text-white">{{ __('admin.manage_default_article_image') }}</h2>
                            <button type="button" data-close-modal class="text-slate-400">{{ __('admin.close') }}</button>
                        </div>
                        <div class="mt-6 space-y-5">
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.image_url') }}</label><input type="url" name="default_article_image_url" value="{{ $defaultArticleImageUrl }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.upload_default_article_image') }}</label><input type="file" name="default_article_image_file" accept="image/*" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.querySelectorAll('[data-color-sync]').forEach((picker) => {
            picker.addEventListener('input', () => {
                const key = picker.dataset.colorSync;
                document.querySelectorAll(`[data-color-target="${key}"]`).forEach((input) => {
                    input.value = picker.value;
                });
            });
        });
        document.querySelectorAll('[data-color-target]').forEach((input) => {
            input.addEventListener('input', () => {
                const key = input.dataset.colorTarget;
                document.querySelectorAll(`[data-color-sync="${key}"]`).forEach((picker) => {
                    if (/^#([0-9a-fA-F]{6})$/.test(input.value)) picker.value = input.value;
                });
            });
        });

        document.querySelectorAll('[data-modal-target]').forEach((button) => {
            button.addEventListener('click', () => {
                document.getElementById(button.dataset.modalTarget)?.classList.remove('hidden');
                document.getElementById(button.dataset.modalTarget)?.classList.add('flex');
            });
        });

        document.querySelectorAll('[data-close-modal]').forEach((button) => {
            button.addEventListener('click', () => {
                button.closest('.fixed')?.classList.add('hidden');
                button.closest('.fixed')?.classList.remove('flex');
            });
        });

        document.querySelectorAll('.fixed[id$="-modal"]').forEach((modal) => {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        });
    </script>
@endsection
