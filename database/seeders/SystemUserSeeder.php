<?php

namespace Database\Seeders;

use App\Models\SystemUsers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        SystemUsers::factory()->create([
            'name' => 'TestSystemUser',
            'email' => '12345@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2a$12$STAEX0v/6qnvXzTi4obBG.pW6nu9QfFTrUDcGGPZHHzzJ916KIbQO', // 12345678
            'remember_token' => Str::random(10),
        ]);
    }
}
