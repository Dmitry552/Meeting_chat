<?php

namespace Database\Seeders\Permission\SeedersForPermissions;

use App\Models\Role;
use Database\Seeders\Permission\RoomPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoomPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $allPermissions = RoomPermission::SYSTEM_PERMISSIONS;

        foreach ($allPermissions as $permission) {
            Permission::create($permission);
        }

        /** @var Role $role */
        $roleSystem = Role::query()
            ->where('name', Role::NAME_SYSTEM_USER)
            ->first();

        $roleSystem->givePermissionTo(Arr::pluck(RoomPermission::SYSTEM_PERMISSIONS, 'name'));
    }
}
