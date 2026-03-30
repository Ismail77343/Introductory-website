@extends('layouts.admin', ['title' => __('admin.messages_title')])

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-black text-white">{{ __('admin.messages_title') }}</h1>
            <p class="mt-2 text-slate-300">{{ __('admin.messages_intro') }}</p>
        </div>

        <div class="space-y-5">
            @foreach ($messages as $message)
                <article class="rounded-[2rem] border border-white/10 bg-white/5 p-6">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-black text-white">{{ $message->name }}</h2>
                            <p class="mt-2 text-slate-300">{{ $message->email }}</p>
                        </div>
                        <span class="rounded-full bg-amber-400/10 px-4 py-2 text-sm font-bold text-amber-300">{{ $message->subject }}</span>
                    </div>
                    <p class="mt-5 leading-8 text-slate-200">{{ $message->message }}</p>
                </article>
            @endforeach
        </div>
    </section>
@endsection
