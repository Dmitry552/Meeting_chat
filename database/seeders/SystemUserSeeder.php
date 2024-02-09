<?php

namespace Database\Seeders;

use App\Models\SystemUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SystemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemUser::factory()->create([
            'name' => 'TestSystemUser',
            'email' => '12345@gmail.com',
            'email_verified_at' => now(),
            'password' => '123456781',
            'remember_token' => Str::random(10),
        ]);
    }
}
