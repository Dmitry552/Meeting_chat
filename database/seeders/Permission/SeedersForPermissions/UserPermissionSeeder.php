<?php

namespace Database\Seeders\Permission\SeedersForPermissions;

use App\Models\Role;
use Database\Seeders\Permission\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class UserPermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $allPermissions = array_merge(
            UserPermission::USER_PERMISSIONS,
            UserPermission::SYSTEM_PERMISSIONS
        );

        foreach ($allPermissions as $permission) {
            Permission::create($permission);
        }

        /** @var Role $role */
        $roleUser = Role::query()
            ->where('name', Role::NAME_USER)
            ->first();

        /** @var Role $role */
        $roleSystem = Role::query()
            ->where('name', Role::NAME_SYSTEM_USER)
            ->first();

        $roleUser->givePermissionTo(Arr::pluck(UserPermission::USER_PERMISSIONS, 'name'));
        $roleSystem->givePermissionTo(Arr::pluck(UserPermission::SYSTEM_PERMISSIONS, 'name'));
    }
}
