<?php

namespace Database\Seeders;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use \App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Collection $users */
        $users = User::factory(10)->create();

        /** @var User $testUser */
        $testUser = User::factory()->create([
            'firstName' => 'Test',
            'lastName' => 'User',
            'gender' => 'Female',
            'phone' => '+380501234567',
            'currentAddress' => 'Beech Creek, PA, Pennsylvania',
            'permanantAddress' => 'Arlington Heights, IL, Illinois',
            'email' => '12345@gmail.com',
            'birthday' => Carbon::createFromDate(1975, 5, 21),
            'email_verified_at' => now(),
            'avatarPath' => null,
            'password' => '12345678',
            'remember_token' => Str::random(10),
        ]);

        /** @var User $systemUser */
        $systemUser = User::query()->create([
            'firstName' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin1',
        ]);

        /** @var User $superAdminUser */
        $superAdminUser = User::query()->create([
            'firstName' => 'superAdmin',
            'email' => 'super@gmail.com',
            'password' => 'admin1',
        ]);

        $users->each(function ($user) {
            $user->assignRole(Role::NAME_USER);
        });

        $testUser->assignRole(Role::NAME_USER);
        $systemUser->assignRole([Role::NAME_USER, Role::NAME_SYSTEM_USER]);
        $superAdminUser->assignRole([Role::NAME_USER, Role::NAME_SUPER_ADMIN]);
    }
}
