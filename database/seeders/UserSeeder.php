<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'TestUser',
            'email' => '12345@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345678',
            'remember_token' => Str::random(10),
        ]);
    }
}
