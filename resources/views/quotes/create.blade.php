@extends('layouts.app', ['title' => __('ui.quote_request')])

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 lg:p-8">
            <h1 class="text-4xl font-black text-white">{{ __('ui.quote_request') }}</h1>
            <p class="mt-3 text-slate-300">{{ __('ui.quote_intro') }}</p>

            <form method="POST" action="{{ route('quotes.store') }}" class="mt-8 space-y-8">
                @csrf

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm text-slate-300">{{ __('ui.company_name') }}</label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}" required class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-slate-300">{{ __('ui.contact_person') }}</label>
                        <input type="text" name="contact_person" value="{{ old('contact_person') }}" required class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-slate-300">{{ __('ui.email') }}</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-slate-300">{{ __('ui.phone') }}</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">
                    </div>
                </div>

                @php
                    $oldItems = old('items', [[
                        'product_id' => $selectedProduct?->id,
                        'quantity' => 1,
                        'unit' => __('ui.gallon'),
                    ]]);
                @endphp

                <div class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-2xl font-black text-white">{{ __('ui.request_items') }}</h2>
                        <button type="button" id="add-quote-item" class="rounded-2xl bg-white/10 px-5 py-3 font-bold text-white">{{ __('ui.add_item') }}</button>
                    </div>

                    <div id="quote-items-container" class="space-y-4">
                        @foreach ($oldItems as $index => $item)
                            <div class="grid gap-4 rounded-3xl border border-white/10 bg-slate-900/70 p-5 md:grid-cols-4 quote-item">
                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm text-slate-300">{{ __('ui.product') }}</label>
                                    <select name="items[{{ $index }}][product_id]" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white">
                                        <option value="">{{ __('ui.select_product') }}</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" @selected((string) ($item['product_id'] ?? '') === (string) $product->id)>{{ $product->translate('name') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-slate-300">{{ __('ui.quantity') }}</label>
                                    <input type="number" step="0.01" min="1" name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] ?? 1 }}" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-slate-300">{{ __('ui.unit') }}</label>
                                    <div class="flex gap-2">
                                        <select name="items[{{ $index }}][unit]" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white">
                                            <option value="{{ __('ui.gallon') }}" @selected(($item['unit'] ?? '') === __('ui.gallon'))>{{ __('ui.gallon') }}</option>
                                            <option value="{{ __('ui.carton') }}" @selected(($item['unit'] ?? '') === __('ui.carton'))>{{ __('ui.carton') }}</option>
                                        </select>
                                        <button type="button" class="remove-quote-item rounded-2xl bg-rose-500/20 px-4 py-3 text-rose-200">{{ __('ui.remove') }}</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm text-slate-300">{{ __('ui.notes') }}</label>
                    <textarea name="notes" rows="4" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old('notes') }}</textarea>
                </div>

                <button class="rounded-2xl bg-amber-400 px-8 py-4 font-bold text-slate-950">{{ __('ui.send_request') }}</button>
            </form>
        </div>
    </section>

    <template id="quote-item-template">
        <div class="grid gap-4 rounded-3xl border border-white/10 bg-slate-900/70 p-5 md:grid-cols-4 quote-item">
            <div class="md:col-span-2">
                <label class="mb-2 block text-sm text-slate-300">{{ __('ui.product') }}</label>
                <select data-field="product_id" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white">
                    <option value="">{{ __('ui.select_product') }}</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->translate('name') }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-2 block text-sm text-slate-300">{{ __('ui.quantity') }}</label>
                <input type="number" step="0.01" min="1" value="1" data-field="quantity" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white">
            </div>
            <div>
                <label class="mb-2 block text-sm text-slate-300">{{ __('ui.unit') }}</label>
                <div class="flex gap-2">
                    <select data-field="unit" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white">
                        <option value="{{ __('ui.gallon') }}">{{ __('ui.gallon') }}</option>
                        <option value="{{ __('ui.carton') }}">{{ __('ui.carton') }}</option>
                    </select>
                    <button type="button" class="remove-quote-item rounded-2xl bg-rose-500/20 px-4 py-3 text-rose-200">{{ __('ui.remove') }}</button>
                </div>
            </div>
        </div>
    </template>

    <script>
        const quoteItemsContainer = document.getElementById('quote-items-container');
        const addQuoteItemButton = document.getElementById('add-quote-item');
        const quoteItemTemplate = document.getElementById('quote-item-template');

        const reindexQuoteItems = () => {
            quoteItemsContainer.querySelectorAll('.quote-item').forEach((item, index) => {
                item.querySelectorAll('[data-field], input[name], select[name]').forEach((field) => {
                    const key = field.dataset.field;
                    if (key) field.name = `items[${index}][${key}]`;
                });
            });
        };

        addQuoteItemButton.addEventListener('click', () => {
            const fragment = quoteItemTemplate.content.cloneNode(true);
            quoteItemsContainer.appendChild(fragment);
            reindexQuoteItems();
        });

        quoteItemsContainer.addEventListener('click', (event) => {
            if (!event.target.classList.contains('remove-quote-item')) return;
            if (quoteItemsContainer.querySelectorAll('.quote-item').length === 1) return;
            event.target.closest('.quote-item')?.remove();
            reindexQuoteItems();
        });

        reindexQuoteItems();
    </script>
@endsection
