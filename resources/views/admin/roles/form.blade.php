@extends('layouts.admin', ['title' => $isEditing ? __('admin.edit_role') : __('admin.new_role')])

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 lg:p-8">
            <h1 class="text-4xl font-black text-white">{{ $isEditing ? __('admin.edit_role') : __('admin.new_role') }}</h1>
            <p class="mt-3 text-slate-300">{{ __('admin.roles_intro') }}</p>

            <form method="POST" action="{{ $isEditing ? route('admin.roles.update', $role) : route('admin.roles.store') }}" class="mt-8 grid gap-8 xl:grid-cols-[minmax(0,1fr)_20rem]">
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/50 p-6">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.role_name') }}</label><input type="text" name="name" value="{{ old('name', $role->name) }}" required class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                            <div><label class="mb-2 block text-sm text-slate-300">{{ __('admin.role_slug') }}</label><input type="text" name="slug" value="{{ old('slug', $role->slug) }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white"></div>
                            <div class="md:col-span-2"><label class="mb-2 block text-sm text-slate-300">{{ __('admin.role_description') }}</label><textarea name="description" rows="4" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">{{ old('description', $role->description) }}</textarea></div>
                            <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-slate-300"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $role->is_active))>{{ __('admin.active_status') }}</label>
                        </div>
                    </div>

                    <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/50 p-6">
                        <h2 class="text-2xl font-black text-white">{{ __('admin.permissions') }}</h2>
                        <div class="mt-6 space-y-5">
                            @foreach ($permissions as $group => $groupPermissions)
                                <div class="rounded-[1.5rem] border border-white/10 bg-slate-900/70 p-5">
                                    <h3 class="text-lg font-black text-amber-300">{{ __('admin.permission_group_'.$group) }}</h3>
                                    <div class="mt-4 grid gap-3 md:grid-cols-2">
                                        @foreach ($groupPermissions as $permission)
                                            @php($key = 'admin.permission_'.str_replace('.', '_', $permission->slug))
                                            <label class="flex items-start gap-3 rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-300">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @checked(in_array($permission->id, old('permissions', $role->permissions->pluck('id')->all()), true))>
                                                <span>{{ __($key) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <aside class="space-y-4 xl:sticky xl:top-6 xl:self-start">
                    <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/60 p-5">
                        <p class="text-sm text-slate-400">{{ __('admin.manage_access') }}</p>
                        <div class="mt-5 space-y-3">
                            <button class="w-full rounded-2xl bg-amber-400 px-8 py-4 font-bold text-slate-950">{{ $isEditing ? __('admin.save_changes') : __('admin.add_role') }}</button>
                            <a href="{{ route('admin.roles.index') }}" class="block w-full rounded-2xl border border-white/10 px-8 py-4 text-center font-bold text-white">{{ __('admin.back_to_roles') }}</a>
                        </div>
                    </div>
                </aside>
            </form>
        </div>
    </section>
@endsection
