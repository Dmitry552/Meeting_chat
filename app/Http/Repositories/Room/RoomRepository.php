<?php

namespace App\Http\Repositories\Room;

use App\Http\Repositories\BaseRepository;
use App\Models\Interlocutor;
use App\Models\Room;

class RoomRepository extends BaseRepository
{
    public function __construct(Room $room)
    {
        $this->model = $room;
    }

    public function checkRoom(string $name): bool
    {
        return $this->model->query()
            ->where('name', $name)
            ->exists();
    }

    public function join(Room $room, Interlocutor $interlocutor): Room
    {
        $interlocutor->room_id = $room->id;
        $interlocutor->save();

        return $room;
    }
}