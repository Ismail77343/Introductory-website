@extends('layouts.admin', ['title' => __('admin.roles_title')])

@section('content')
    <section class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-4xl font-black text-white">{{ __('admin.roles_title') }}</h1>
                <p class="mt-3 text-slate-300">{{ __('admin.roles_intro') }}</p>
            </div>
            <a href="{{ route('admin.roles.create') }}" class="rounded-2xl bg-amber-400 px-6 py-3 font-bold text-slate-950">{{ __('admin.add_role') }}</a>
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($roles as $role)
                <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-6">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h2 class="text-2xl font-black text-white">{{ $role->name }}</h2>
                            <p class="mt-1 text-sm text-slate-400">{{ $role->slug }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-bold {{ $role->is_active ? 'bg-emerald-500/20 text-emerald-300' : 'bg-slate-800 text-slate-400' }}">{{ $role->is_active ? __('admin.active') : __('admin.hidden') }}</span>
                    </div>
                    <p class="mt-4 min-h-12 text-sm leading-7 text-slate-300">{{ $role->description ?: '—' }}</p>
                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-4"><p class="text-xs text-slate-400">{{ __('admin.users_count') }}</p><p class="mt-2 text-2xl font-black text-white">{{ $role->users_count }}</p></div>
                        <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-4"><p class="text-xs text-slate-400">{{ __('admin.permissions_count') }}</p><p class="mt-2 text-2xl font-black text-white">{{ $role->permissions_count }}</p></div>
                    </div>
                    <div class="mt-5 flex gap-3">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="rounded-2xl border border-white/10 px-4 py-3 font-bold text-white">{{ __('admin.edit') }}</a>
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('{{ __('admin.confirm_delete_role') }}')">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-2xl bg-rose-500/20 px-4 py-3 font-bold text-rose-200">{{ __('admin.delete') }}</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
