<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (config('admin.permissions', []) as $permission) {
            Permission::findOrCreate($permission);
        }

        $superAdmin = Role::findOrCreate('Super Admin');
        $admin = Role::findOrCreate('Admin');

        $superAdmin->syncPermissions(Permission::all());

        $admin->syncPermissions(
            Permission::query()
                ->whereNotIn('name', ['roles.manage', 'users.manage'])
                ->get()
        );
    }
}
