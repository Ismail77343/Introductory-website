@extends('layouts.admin', ['title' => $isEditing ? __('admin.edit_user') : __('admin.new_user')])

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 lg:p-8">
            <h1 class="text-4xl font-black text-white">{{ $isEditing ? __('admin.edit_user') : __('admin.new_user') }}</h1>
            <p class="mt-3 text-slate-300">{{ __('admin.users_intro') }}</p>

            <form method="POST" action="{{ $isEditing ? route('admin.users.update', $user) : route('admin.users.store') }}" class="mt-8 grid gap-8 xl:grid-cols-[minmax(0,1fr)_20rem]">
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/50 p-6">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.user_name') }}</label><input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.email') }}</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.phone') }}</label><input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.job_title') }}</label><input type="text" name="job_title" value="{{ old('job_title', $user->job_title) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.preferred_language') }}</label><select name="preferred_locale" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"><option value="">{{ __('admin.default_site_language') }}</option>@foreach ($languages as $language)<option value="{{ $language->code }}" @selected(old('preferred_locale', $user->preferred_locale) === $language->code)>{{ $language->native_name }}</option>@endforeach</select></div>
                            <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-slate-300"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active))>{{ __('admin.active_status') }}</label>
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.new_password') }}</label><input type="password" name="password" @if(! $isEditing) required @endif class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.password_confirmation') }}</label><input type="password" name="password_confirmation" @if(! $isEditing) required @endif class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                        </div>
                        @if ($isEditing)
                            <p class="mt-4 text-sm text-slate-400">{{ __('admin.leave_password_blank') }}</p>
                        @endif
                    </div>

                    <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/50 p-6">
                        <h2 class="text-2xl font-black text-white">{{ __('admin.assign_roles') }}</h2>
                        <p class="mt-2 text-sm text-slate-400">{{ __('admin.assign_roles_help') }}</p>
                        <div class="mt-6 grid gap-3 md:grid-cols-2">
                            @foreach ($roles as $role)
                                <label class="flex items-start gap-3 rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-slate-300">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" @checked(in_array($role->id, old('roles', $user->roles->pluck('id')->all()), true))>
                                    <span>
                                        <span class="block font-bold text-white">{{ $role->name }}</span>
                                        <span class="mt-1 block text-sm text-slate-400">{{ $role->description }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <aside class="space-y-4 xl:sticky xl:top-6 xl:self-start">
                    <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/60 p-5">
                        <p class="text-sm text-slate-400">{{ __('admin.manage_access') }}</p>
                        <div class="mt-5 space-y-3">
                            <button class="w-full rounded-2xl bg-amber-400 px-8 py-4 font-bold text-slate-950">{{ $isEditing ? __('admin.save_changes') : __('admin.add_user') }}</button>
                            <a href="{{ route('admin.users.index') }}" class="block w-full rounded-2xl border border-white/10 px-8 py-4 text-center font-bold text-white">{{ __('admin.back_to_users') }}</a>
                        </div>
                    </div>
                </aside>
            </form>
        </div>
    </section>
@endsection
