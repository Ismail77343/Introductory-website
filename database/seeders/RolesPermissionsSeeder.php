<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissionMap = [
            ['name' => 'Dashboard', 'slug' => 'dashboard.view', 'group_name' => 'dashboard'],
            ['name' => 'Site Settings', 'slug' => 'settings.manage', 'group_name' => 'content'],
            ['name' => 'Products', 'slug' => 'products.manage', 'group_name' => 'content'],
            ['name' => 'Home Sections', 'slug' => 'home_sections.manage', 'group_name' => 'content'],
            ['name' => 'About Sections', 'slug' => 'about_sections.manage', 'group_name' => 'content'],
            ['name' => 'Articles', 'slug' => 'articles.manage', 'group_name' => 'content'],
            ['name' => 'Testimonials', 'slug' => 'testimonials.manage', 'group_name' => 'content'],
            ['name' => 'Languages', 'slug' => 'languages.manage', 'group_name' => 'system'],
            ['name' => 'Quotes', 'slug' => 'quotes.view', 'group_name' => 'operations'],
            ['name' => 'Messages', 'slug' => 'messages.view', 'group_name' => 'operations'],
            ['name' => 'Roles', 'slug' => 'roles.manage', 'group_name' => 'system'],
            ['name' => 'Users', 'slug' => 'users.manage', 'group_name' => 'system'],
        ];

        foreach ($permissionMap as $permissionData) {
            Permission::query()->updateOrCreate(
                ['slug' => $permissionData['slug']],
                $permissionData
            );
        }

        $allPermissionIds = Permission::query()->pluck('id')->all();

        $superAdminRole = Role::query()->updateOrCreate(
            ['slug' => 'super-admin'],
            [
                'name' => 'Super Admin',
                'description' => 'Full access to the admin dashboard and all management areas.',
                'is_active' => true,
                'is_system' => true,
            ]
        );
        $superAdminRole->permissions()->sync($allPermissionIds);

        $contentManagerRole = Role::query()->updateOrCreate(
            ['slug' => 'content-manager'],
            [
                'name' => 'Content Manager',
                'description' => 'Manages products, articles, testimonials, and site sections.',
                'is_active' => true,
                'is_system' => true,
            ]
        );
        $contentManagerRole->permissions()->sync(
            Permission::query()->whereIn('slug', [
                'dashboard.view',
                'settings.manage',
                'products.manage',
                'home_sections.manage',
                'about_sections.manage',
                'articles.manage',
                'testimonials.manage',
            ])->pluck('id')->all()
        );

        $supportRole = Role::query()->updateOrCreate(
            ['slug' => 'support-agent'],
            [
                'name' => 'Support Agent',
                'description' => 'Reviews incoming messages and quote requests for customer support.',
                'is_active' => true,
                'is_system' => true,
            ]
        );
        $supportRole->permissions()->sync(
            Permission::query()->whereIn('slug', [
                'dashboard.view',
                'quotes.view',
                'messages.view',
            ])->pluck('id')->all()
        );

        if ($admin = User::query()->where('email', 'admin@nofouth.local')->first()) {
            $admin->roles()->syncWithoutDetaching([$superAdminRole->id]);
        }
    }
}
