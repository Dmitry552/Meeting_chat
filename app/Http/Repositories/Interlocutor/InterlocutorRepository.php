<?php

namespace App\Http\Repositories\Interlocutor;

use App\Http\Repositories\BaseRepository;
use App\Models\Interlocutor;
use App\Models\Room;
use Illuminate\Support\Collection;

class InterlocutorRepository extends BaseRepository
{
    public function __construct(Interlocutor $model)
    {
        $this->model = $model;
    }

    /**
     * Select interlocutors from the room
     *
     * @param Room $room
     * @return Collection
     */
    public function interlocutorsRoom(Room $room): Collection
    {
        return $room->interlocutors;
    }
}
