<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create([
            'name' => Role::NAME_SUPER_ADMIN
        ]);
        Role::create([
            'name' => Role::NAME_SYSTEM_USER
        ]);
        Role::create([
            'name' => Role::NAME_USER
        ]);
    }
}
