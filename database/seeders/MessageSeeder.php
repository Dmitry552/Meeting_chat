<?php

namespace Database\Seeders;

use App\Models\Interlocutor;
use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Interlocutor::query()->lazy()->each(function ($interlocutor) {
            Message::factory(10)->create([
                'interlocutor_id' => $interlocutor->id
            ]);
        });
    }
}
