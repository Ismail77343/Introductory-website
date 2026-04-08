@extends('layouts.admin', ['title' => __('admin.users_title')])

@section('content')
    <section class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-4xl font-black text-white">{{ __('admin.users_title') }}</h1>
                <p class="mt-3 text-slate-300">{{ __('admin.users_intro') }}</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="rounded-2xl bg-amber-400 px-6 py-3 font-bold text-slate-950">{{ __('admin.add_user') }}</a>
        </div>

        <div class="mt-8 overflow-hidden rounded-[2rem] border border-white/10 bg-white/5">
            <table class="min-w-full divide-y divide-white/10 text-sm">
                <thead class="bg-slate-950/60 text-slate-300">
                    <tr>
                        <th class="px-6 py-4 text-start">{{ __('admin.user_name') }}</th>
                        <th class="px-6 py-4 text-start">{{ __('admin.email') }}</th>
                        <th class="px-6 py-4 text-start">{{ __('admin.linked_roles') }}</th>
                        <th class="px-6 py-4 text-start">{{ __('admin.user_status') }}</th>
                        <th class="px-6 py-4 text-start">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @foreach ($users as $user)
                        <tr class="bg-slate-900/40">
                            <td class="px-6 py-4">
                                <p class="font-bold text-white">{{ $user->name }}</p>
                                <p class="text-slate-400">{{ $user->job_title ?: '—' }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-300">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-slate-300">{{ $user->roles->isNotEmpty() ? $user->roles->pluck('name')->join('، ') : __('admin.no_roles_assigned') }}</td>
                            <td class="px-6 py-4"><span class="rounded-full px-3 py-1 text-xs font-bold {{ $user->is_active ? 'bg-emerald-500/20 text-emerald-300' : 'bg-slate-800 text-slate-400' }}">{{ $user->is_active ? __('admin.active') : __('admin.hidden') }}</span></td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="rounded-2xl border border-white/10 px-4 py-2 font-bold text-white">{{ __('admin.edit') }}</a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('{{ __('admin.confirm_delete_user') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-2xl bg-rose-500/20 px-4 py-2 font-bold text-rose-200">{{ __('admin.delete') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
