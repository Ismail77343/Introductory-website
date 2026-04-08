<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminRoleController extends Controller
{
    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Role::query()->withCount(['users', 'permissions'])->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.roles.form', [
            'role' => new Role(['is_active' => true]),
            'permissions' => Permission::query()->orderBy('group_name')->orderBy('name')->get()->groupBy('group_name'),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $role = Role::query()->create($data['role']);
        $role->permissions()->sync($data['permissions']);

        return redirect()->route('admin.roles.index')->with('success', __('admin.role_created'));
    }

    public function edit(Role $role)
    {
        return view('admin.roles.form', [
            'role' => $role->load('permissions'),
            'permissions' => Permission::query()->orderBy('group_name')->orderBy('name')->get()->groupBy('group_name'),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $data = $this->validatedData($request, $role);

        $role->update($data['role']);
        $role->permissions()->sync($data['permissions']);

        return redirect()->route('admin.roles.index')->with('success', __('admin.role_updated'));
    }

    public function destroy(Role $role)
    {
        if ($role->is_system || $role->slug === 'super-admin') {
            return back()->with('error', __('admin.role_delete_blocked'));
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', __('admin.role_deleted'));
    }

    protected function validatedData(Request $request, ?Role $role = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('roles', 'slug')->ignore($role?->id)],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        return [
            'role' => [
                'name' => $validated['name'],
                'slug' => $validated['slug'] ?: Str::slug($validated['name']),
                'description' => $validated['description'] ?? null,
                'is_active' => (bool) ($validated['is_active'] ?? false),
            ],
            'permissions' => $validated['permissions'] ?? [],
        ];
    }
}
