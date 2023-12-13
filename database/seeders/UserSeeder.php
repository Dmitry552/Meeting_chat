<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
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
        User::factory(10)->create();

        User::factory()->create([
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
    }
}
