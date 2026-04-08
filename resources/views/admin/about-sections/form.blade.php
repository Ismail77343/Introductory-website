@extends('layouts.admin', ['title' => $isEditing ? __('admin.edit_about_section') : __('admin.new_about_section')])

@section('content')
    @php
        $sectionItems = old('items', $items ?: [['title' => '', 'description' => '', 'icon' => '', 'sort_order' => 1]]);
        $itemTranslationFields = ['title' => __('admin.item_title'), 'subtitle' => __('admin.item_subtitle'), 'description' => __('admin.item_description'), 'button_text' => __('admin.button_text'), 'metric_label' => __('admin.base_metric_label')];
    @endphp

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 lg:p-8">
            <div class="flex flex-col gap-4 border-b border-white/10 pb-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h1 class="text-4xl font-black text-white">{{ $isEditing ? __('admin.edit_about_section') : __('admin.new_about_section') }}</h1>
                    <p class="mt-3 max-w-3xl text-slate-300">{{ __('admin.about_section_form_intro') }}</p>
                </div>
                <div class="rounded-[1.5rem] border border-white/10 bg-slate-950/60 px-5 py-4 text-sm text-slate-300">
                    <p class="font-bold text-amber-300">{{ __('admin.section_builder_help') }}</p>
                    <p class="mt-2">{{ __('admin.section_builder_help_text') }}</p>
                </div>
            </div>

            <form method="POST" action="{{ $isEditing ? route('admin.about-sections.update', $section) : route('admin.about-sections.store') }}" enctype="multipart/form-data" class="mt-8 grid gap-8 xl:grid-cols-[minmax(0,1fr)_20rem]">
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif

                <div class="space-y-8">
                    <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/50 p-5">
                        <div class="mb-5">
                            <h2 class="text-2xl font-black text-white">{{ __('admin.section_identity') }}</h2>
                            <p class="mt-1 text-sm text-slate-400">{{ __('admin.section_identity_help') }}</p>
                        </div>
                        <div class="grid gap-5 md:grid-cols-2">
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.base_section_title') }}</label><input type="text" name="title" value="{{ old('title', $section->title) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.section_key') }}</label><input type="text" name="key" value="{{ old('key', $section->key) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.section_type') }}</label><select name="variant" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"><option value="hero" @selected(old('variant', $section->variant) === 'hero')>{{ __('admin.variant_hero') }}</option><option value="cards" @selected(old('variant', $section->variant) === 'cards')>{{ __('admin.variant_cards') }}</option><option value="stats" @selected(old('variant', $section->variant) === 'stats')>{{ __('admin.variant_stats') }}</option></select></div>
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.anchor') }}</label><input type="text" name="anchor" value="{{ old('anchor', $section->anchor) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.sort_order') }}</label><input type="number" name="sort_order" value="{{ old('sort_order', $section->sort_order) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                            <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-slate-300"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $section->is_active))>{{ __('admin.active_section') }}</label>
                            <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">{{ __('admin.base_section_subtitle') }}</label><textarea name="subtitle" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old('subtitle', $section->subtitle) }}</textarea></div>
                        </div>
                    </div>

                    <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/50 p-5" data-tabs-root>
                        <div class="mb-5">
                            <h2 class="text-2xl font-black text-white">{{ __('admin.section_translations') }}</h2>
                            <p class="mt-1 text-sm text-slate-400">{{ __('admin.about_section_translations_intro') }}</p>
                        </div>
                        <div class="mb-4 flex flex-wrap gap-3">
                            @foreach ($activeLanguages as $language)
                                <button type="button" data-tab-button="section-{{ $language->code }}" class="rounded-2xl border border-white/10 px-4 py-2 text-sm font-bold text-slate-300">{{ $language->native_name }} ({{ strtoupper($language->code) }})</button>
                            @endforeach
                        </div>
                        @foreach ($activeLanguages as $language)
                            <div data-tab-panel="section-{{ $language->code }}" class="hidden rounded-[1.5rem] border border-white/10 bg-slate-950/70 p-5">
                                <div class="grid gap-5 md:grid-cols-2">
                                    <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.section_title') }}</label><input type="text" name="translations[{{ $language->code }}][title]" value="{{ old("translations.{$language->code}.title", $section->translationInput('title', $language->code)) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                                    <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">{{ __('admin.section_subtitle') }}</label><textarea name="translations[{{ $language->code }}][subtitle]" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old("translations.{$language->code}.subtitle", $section->translationInput('subtitle', $language->code)) }}</textarea></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-5">
                        <div class="flex flex-col gap-4 rounded-[1.75rem] border border-white/10 bg-slate-950/50 p-5 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <h2 class="text-2xl font-black text-white">{{ __('admin.section_items') }}</h2>
                                <p class="mt-1 text-sm text-slate-400">{{ __('admin.about_section_items_intro') }}</p>
                            </div>
                            <button type="button" id="add-item-button" class="rounded-2xl bg-amber-400 px-6 py-3 font-bold text-slate-950">{{ __('admin.add_item') }}</button>
                        </div>

                        <div id="section-items-container" class="space-y-5">
                            @foreach ($sectionItems as $index => $item)
                                @php($existingImage = $item['image_path'] ?? null)
                                @php($existingImageUrl = $item['image_url'] ?? null)
                                @php($existingAttachment = $item['attachment_path'] ?? null)
                                @php($existingAttachmentUrl = $item['attachment_url'] ?? null)
                                <div class="section-item-card rounded-[1.75rem] border border-white/10 bg-slate-900/70 p-5" data-item-card>
                                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-white/10 pb-4">
                                        <div class="inline-flex rounded-full border border-amber-300/30 bg-amber-400/10 px-3 py-1 text-xs font-bold text-amber-300">{{ __('admin.item_card') }} <span class="mx-1" data-item-number>{{ $index + 1 }}</span></div>
                                        <div class="flex flex-wrap gap-3">
                                            <label class="flex items-center gap-2 rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-sm text-slate-300"><input type="checkbox" name="items[{{ $index }}][is_active]" value="1" @checked($item['is_active'] ?? true) data-name="is_active">{{ __('admin.active_item') }}</label>
                                            <button type="button" class="rounded-2xl border border-white/10 px-4 py-3 text-sm font-bold text-slate-300" data-toggle-item>{{ __('admin.collapse') }}</button>
                                            <button type="button" class="rounded-2xl bg-rose-500/20 px-4 py-3 text-sm font-bold text-rose-200 remove-item-button">{{ __('admin.remove_item') }}</button>
                                        </div>
                                    </div>
                                    <div class="item-body mt-5 space-y-6">
                                        <div class="grid gap-4 md:grid-cols-2">
                                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.base_item_title') }}</label><input type="text" name="items[{{ $index }}][title]" value="{{ $item['title'] ?? '' }}" data-name="title" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.base_item_subtitle') }}</label><input type="text" name="items[{{ $index }}][subtitle]" value="{{ $item['subtitle'] ?? '' }}" data-name="subtitle" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                            <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">{{ __('admin.base_item_description') }}</label><textarea name="items[{{ $index }}][description]" rows="3" data-name="description" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white">{{ $item['description'] ?? '' }}</textarea></div>
                                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.icon_or_emoji') }}</label><input type="text" name="items[{{ $index }}][icon]" value="{{ $item['icon'] ?? '' }}" data-name="icon" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.sort_order') }}</label><input type="number" name="items[{{ $index }}][sort_order]" value="{{ $item['sort_order'] ?? $index + 1 }}" data-name="sort_order" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.base_button_text') }}</label><input type="text" name="items[{{ $index }}][button_text]" value="{{ $item['button_text'] ?? '' }}" data-name="button_text" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.button_url') }}</label><input type="text" name="items[{{ $index }}][button_url]" value="{{ $item['button_url'] ?? '' }}" data-name="button_url" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.metric_value') }}</label><input type="text" name="items[{{ $index }}][metric]" value="{{ $item['metric'] ?? '' }}" data-name="metric" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.base_metric_label') }}</label><input type="text" name="items[{{ $index }}][metric_label]" value="{{ $item['metric_label'] ?? '' }}" data-name="metric_label" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                        </div>
                                        <div class="grid gap-4 lg:grid-cols-2">
                                            <article class="rounded-[1.5rem] border border-white/10 bg-slate-950/70 p-5">
                                                <p class="text-sm text-slate-400">{{ __('admin.product_image') }}</p>
                                                <div class="mt-4">@if ($existingImage)<img src="{{ asset($existingImage) }}" alt="{{ __('admin.product_image') }}" class="h-40 w-full rounded-2xl object-cover">@elseif ($existingImageUrl)<img src="{{ $existingImageUrl }}" alt="{{ __('admin.product_image') }}" class="h-40 w-full rounded-2xl object-cover">@else<div class="flex h-40 items-center justify-center rounded-2xl border border-dashed border-white/10 text-slate-500">{{ __('admin.no_image') }}</div>@endif</div>
                                                <button type="button" class="mt-4 w-full rounded-2xl bg-white/10 px-4 py-3 font-bold text-white" data-open-media-modal="image">{{ __('admin.manage_item_image') }}</button>
                                            </article>
                                            <article class="rounded-[1.5rem] border border-white/10 bg-slate-950/70 p-5">
                                                <p class="text-sm text-slate-400">{{ __('admin.base_attachment_url') }}</p>
                                                <div class="mt-4 flex min-h-[10rem] items-center rounded-2xl border border-dashed border-white/10 p-4 text-sm text-slate-300">@if ($existingAttachment)<a href="{{ asset($existingAttachment) }}" target="_blank" class="font-bold text-amber-300">{{ __('admin.current_file') }}</a>@elseif ($existingAttachmentUrl)<a href="{{ $existingAttachmentUrl }}" target="_blank" class="font-bold text-amber-300">{{ __('admin.current_link') }}</a>@else{{ __('admin.no_file_added') }}@endif</div>
                                                <button type="button" class="mt-4 w-full rounded-2xl bg-white/10 px-4 py-3 font-bold text-white" data-open-media-modal="attachment">{{ __('admin.manage_item_attachment') }}</button>
                                            </article>
                                        </div>
                                        <div class="rounded-[1.5rem] border border-white/10 bg-slate-950/60 p-4" data-tabs-root>
                                            <div class="mb-4 flex flex-wrap gap-3">@foreach ($activeLanguages as $language)<button type="button" data-tab-button="item-{{ $language->code }}-{{ $index }}" class="rounded-2xl border border-white/10 px-4 py-2 text-sm font-bold text-slate-300">{{ $language->native_name }} ({{ strtoupper($language->code) }})</button>@endforeach</div>
                                            @foreach ($activeLanguages as $language)
                                                <div data-tab-panel="item-{{ $language->code }}-{{ $index }}" class="hidden rounded-[1.25rem] border border-white/10 bg-slate-900/70 p-4">
                                                    <div class="grid gap-4 md:grid-cols-2">
                                                        @foreach ($itemTranslationFields as $field => $label)
                                                            @php($translationValue = old("items.{$index}.{$field}_translations.{$language->code}", data_get($item, "{$field}_translations.{$language->code}")))
                                                            @if ($field === 'description')
                                                                <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">{{ $label }}</label><textarea name="items[{{ $index }}][{{ $field }}_translations][{{ $language->code }}]" rows="3" data-translation-name="{{ $field }}_translations" data-translation-locale="{{ $language->code }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white">{{ $translationValue }}</textarea></div>
                                                            @else
                                                                <div><label class="mb-2 block text-sm text-slate-300">{{ $label }}</label><input type="text" name="items[{{ $index }}][{{ $field }}_translations][{{ $language->code }}]" value="{{ $translationValue }}" data-translation-name="{{ $field }}_translations" data-translation-locale="{{ $language->code }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <input type="hidden" name="items[{{ $index }}][image_path]" value="{{ $existingImage }}" data-name="image_path">
                                    <input type="hidden" name="items[{{ $index }}][attachment_path]" value="{{ $existingAttachment }}" data-name="attachment_path">
                                    <div class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/75 p-4" data-media-modal="image"><div class="w-full max-w-xl rounded-[2rem] border border-white/10 bg-slate-900 p-6"><div class="flex items-center justify-between"><h3 class="text-2xl font-black text-white">{{ __('admin.manage_item_image') }}</h3><button type="button" class="text-slate-400" data-close-media-modal>{{ __('admin.close') }}</button></div><div class="mt-6 space-y-5"><div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.image_url') }}</label><input type="url" name="items[{{ $index }}][image_url]" value="{{ $existingImageUrl }}" data-name="image_url" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div><div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.upload_image') }}</label><input type="file" name="items[{{ $index }}][image_file]" accept="image/*" data-name="image_file" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div></div></div></div>
                                    <div class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/75 p-4" data-media-modal="attachment"><div class="w-full max-w-xl rounded-[2rem] border border-white/10 bg-slate-900 p-6"><div class="flex items-center justify-between"><h3 class="text-2xl font-black text-white">{{ __('admin.manage_item_attachment') }}</h3><button type="button" class="text-slate-400" data-close-media-modal>{{ __('admin.close') }}</button></div><div class="mt-6 space-y-5"><div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.base_attachment_url') }}</label><input type="text" name="items[{{ $index }}][attachment_url]" value="{{ $existingAttachmentUrl }}" data-name="attachment_url" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div><div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.upload_attachment') }}</label><input type="file" name="items[{{ $index }}][attachment_file]" data-name="attachment_file" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white"></div></div></div></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <aside class="space-y-4 xl:sticky xl:top-6 xl:self-start">
                    <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/60 p-5"><h2 class="text-xl font-black text-white">{{ __('admin.section_status') }}</h2><div class="mt-4 space-y-3 text-sm text-slate-300"><div class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-900 px-4 py-3"><span>{{ __('admin.section_type') }}</span><span class="font-bold text-white">{{ old('variant', $section->variant ?: 'cards') }}</span></div><div class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-900 px-4 py-3"><span>{{ __('admin.items') }}</span><span class="font-bold text-white" id="items-count">{{ count($sectionItems) }}</span></div><div class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-900 px-4 py-3"><span>{{ __('admin.status') }}</span><span class="font-bold {{ old('is_active', $section->is_active) ? 'text-emerald-300' : 'text-slate-400' }}">{{ old('is_active', $section->is_active) ? __('admin.active') : __('admin.hidden') }}</span></div></div></div>
                    <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/60 p-5"><p class="text-sm text-slate-400">{{ __('admin.save_section_help') }}</p><div class="mt-5 space-y-3"><button class="w-full rounded-2xl bg-amber-400 px-8 py-4 font-bold text-slate-950">{{ $isEditing ? __('admin.save_changes') : __('admin.add_section') }}</button><a href="{{ route('admin.about-sections.index') }}" class="block w-full rounded-2xl border border-white/10 px-8 py-4 text-center font-bold text-white">{{ __('admin.cancel') }}</a></div></div>
                </aside>
            </form>
        </div>
    </section>

    <script>
        const itemsContainer = document.getElementById('section-items-container');
        const itemsCount = document.getElementById('items-count');
        const addItemButton = document.getElementById('add-item-button');
        const closeModal = (modal) => { modal?.classList.add('hidden'); modal?.classList.remove('flex'); };
        const initTabs = (root = document) => root.querySelectorAll('[data-tabs-root]').forEach((tabsRoot) => { if (tabsRoot.dataset.ready === '1') return; const buttons = tabsRoot.querySelectorAll('[data-tab-button]'); const panels = tabsRoot.querySelectorAll('[data-tab-panel]'); const activate = (name) => { buttons.forEach((button) => { const active = button.dataset.tabButton === name; button.classList.toggle('bg-amber-400', active); button.classList.toggle('text-slate-950', active); button.classList.toggle('border-amber-300', active); }); panels.forEach((panel) => panel.classList.toggle('hidden', panel.dataset.tabPanel !== name)); }; buttons.forEach((button) => button.addEventListener('click', () => activate(button.dataset.tabButton))); if (buttons[0]) activate(buttons[0].dataset.tabButton); tabsRoot.dataset.ready = '1'; });
        const reindexItems = () => { itemsCount.textContent = itemsContainer.querySelectorAll('.section-item-card').length; itemsContainer.querySelectorAll('.section-item-card').forEach((card, index) => { card.querySelectorAll('[data-name]').forEach((field) => field.name = `items[${index}][${field.dataset.name}]`); card.querySelectorAll('[data-translation-name]').forEach((field) => field.name = `items[${index}][${field.dataset.translationName}][${field.dataset.translationLocale}]`); const number = card.querySelector('[data-item-number]'); if (number) number.textContent = index + 1; card.querySelectorAll('[data-tab-button]').forEach((button) => { const locale = button.dataset.tabButton.split('-')[1]; button.dataset.tabButton = `item-${locale}-${index}`; }); card.querySelectorAll('[data-tab-panel]').forEach((panel) => { const locale = panel.dataset.tabPanel.split('-')[1]; panel.dataset.tabPanel = `item-${locale}-${index}`; }); card.querySelectorAll('[data-tabs-root]').forEach((tabs) => delete tabs.dataset.ready); }); initTabs(); };
        addItemButton.addEventListener('click', () => { const first = itemsContainer.querySelector('.section-item-card'); if (!first) return; const clone = first.cloneNode(true); clone.querySelectorAll('input[type="text"], input[type="number"], input[type="url"], textarea').forEach((field) => field.value = ''); clone.querySelectorAll('input[type="file"]').forEach((field) => field.value = ''); clone.querySelectorAll('img').forEach((img) => img.closest('.mt-4').innerHTML = `<div class="flex h-40 items-center justify-center rounded-2xl border border-dashed border-white/10 text-slate-500">{{ __('admin.no_image') }}</div>`); clone.querySelectorAll('a').forEach((link) => { const holder = link.closest('.mt-4'); if (holder) holder.textContent = @json(__('admin.no_file_added')); }); clone.querySelectorAll('[data-name="image_path"],[data-name="attachment_path"]').forEach((field) => field.value = ''); itemsContainer.appendChild(clone); reindexItems(); });
        itemsContainer.addEventListener('click', (event) => { const card = event.target.closest('.section-item-card'); if (!card) return; if (event.target.classList.contains('remove-item-button')) { if (itemsContainer.querySelectorAll('.section-item-card').length > 1) { card.remove(); reindexItems(); } return; } if (event.target.matches('[data-toggle-item]')) { const body = card.querySelector('.item-body'); const collapsed = body.classList.toggle('hidden'); event.target.textContent = collapsed ? @json(__('admin.expand')) : @json(__('admin.collapse')); return; } if (event.target.matches('[data-open-media-modal]')) { const modal = card.querySelector(`[data-media-modal="${event.target.dataset.openMediaModal}"]`); modal?.classList.remove('hidden'); modal?.classList.add('flex'); return; } if (event.target.matches('[data-close-media-modal]')) { closeModal(event.target.closest('[data-media-modal]')); } });
        document.addEventListener('click', (event) => { if (event.target.matches('[data-media-modal]')) closeModal(event.target); });
        initTabs();
        reindexItems();
    </script>
@endsection

