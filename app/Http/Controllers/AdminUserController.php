<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::query()->with('roles')->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.users.form', [
            'user' => new User(['is_active' => true]),
            'languages' => Language::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'roles' => Role::query()->where('is_active', true)->orderBy('name')->get(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $user = User::query()->create($data['user']);
        $user->roles()->sync($data['roles']);

        return redirect()->route('admin.users.index')->with('success', __('admin.user_created'));
    }

    public function edit(User $user)
    {
        return view('admin.users.form', [
            'user' => $user->load('roles'),
            'languages' => Language::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'roles' => Role::query()->where('is_active', true)->orderBy('name')->get(),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validatedData($request, $user);

        $user->update($data['user']);
        $user->roles()->sync($data['roles']);

        return redirect()->route('admin.users.index')->with('success', __('admin.user_updated'));
    }

    public function destroy(Request $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            return back()->with('error', __('admin.user_delete_self_blocked'));
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', __('admin.user_deleted'));
    }

    protected function validatedData(Request $request, ?User $user = null): array
    {
        $passwordRules = $user
            ? ['nullable', 'string', 'min:8', 'confirmed']
            : ['required', 'string', 'min:8', 'confirmed'];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'preferred_locale' => ['nullable', 'string', 'max:10'],
            'is_active' => ['nullable', 'boolean'],
            'password' => $passwordRules,
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'job_title' => $validated['job_title'] ?? null,
            'preferred_locale' => $validated['preferred_locale'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ];

        if (! empty($validated['password'])) {
            $userData['password'] = $validated['password'];
        }

        return [
            'user' => $userData,
            'roles' => $validated['roles'] ?? [],
        ];
    }
}
