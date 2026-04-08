@extends('layouts.admin', ['title' => __('admin.my_profile')])

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 lg:p-8">
            <h1 class="text-4xl font-black text-white">{{ __('admin.my_profile') }}</h1>
            <p class="mt-3 text-slate-300">{{ __('admin.profile_intro') }}</p>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <form method="POST" action="{{ route('admin.profile.update') }}" class="rounded-[1.75rem] border border-white/10 bg-slate-950/50 p-6">
                    @csrf
                    @method('PUT')
                    <h2 class="text-2xl font-black text-white">{{ __('admin.profile_information') }}</h2>
                    <p class="mt-2 text-sm text-slate-400">{{ __('admin.profile_information_help') }}</p>
                    <div class="mt-6 grid gap-5">
                        <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.user_name') }}</label><input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                        <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.email') }}</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                        <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.phone') }}</label><input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                        <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.job_title') }}</label><input type="text" name="job_title" value="{{ old('job_title', $user->job_title) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                        <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.preferred_language') }}</label><select name="preferred_locale" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"><option value="">{{ __('admin.default_site_language') }}</option>@foreach ($languages as $language)<option value="{{ $language->code }}" @selected(old('preferred_locale', $user->preferred_locale) === $language->code)>{{ $language->native_name }}</option>@endforeach</select></div>
                    </div>
                    <button class="mt-6 rounded-2xl bg-amber-400 px-8 py-4 font-bold text-slate-950">{{ __('admin.update_profile') }}</button>
                </form>

                <form method="POST" action="{{ route('admin.profile.password') }}" class="rounded-[1.75rem] border border-white/10 bg-slate-950/50 p-6">
                    @csrf
                    @method('PUT')
                    <h2 class="text-2xl font-black text-white">{{ __('admin.change_password') }}</h2>
                    <p class="mt-2 text-sm text-slate-400">{{ __('admin.change_password_help') }}</p>
                    <div class="mt-6 grid gap-5">
                        <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.current_password') }}</label><input type="password" name="current_password" required class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                        <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.new_password') }}</label><input type="password" name="password" required class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                        <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.confirm_new_password') }}</label><input type="password" name="password_confirmation" required class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                    </div>
                    <button class="mt-6 rounded-2xl border border-white/10 px-8 py-4 font-bold text-white">{{ __('admin.update_password') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
