<?php

namespace Database\Seeders;

use Database\Seeders\Permission\SeedersForPermissions\RoomPermissionSeeder;
use Database\Seeders\Permission\SeedersForPermissions\UserPermissionSeeder;
use Illuminate\Database\Seeder;

class BasePermissionSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserPermissionSeeder::class,
            RoomPermissionSeeder::class
        ]);
    }
}