<?php

namespace Database\Seeders;

use App\Models\Interlocutor;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Interlocutor::query()->lazy()->each(function ($interlocutor) {
            Room::factory()->create([
                'creator' => $interlocutor->id
            ]);
        });

        Room::query()->lazy()->each(function ($room) {
            $interlocutor = Interlocutor::find($room->creator);
            $interlocutor->room_id = $room->id;
            $interlocutor->save();
        });

        Room::factory()->has(
            Interlocutor::factory()->count(10)
        )->create(['creator' => 1]);
    }
}
