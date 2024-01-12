<?php

namespace Database\Seeders;

use App\Models\Interlocutor;
use Illuminate\Database\Seeder;

class InterlocutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Interlocutor::factory(10)->create();
    }
}
