<?php

namespace App\Http\Services;

use App\Http\Repositories\Room\RoomRepository;
use App\Http\Resources\RoomResource;
use App\Models\Interlocutor;
use App\Models\Room;

class RoomService
{
    private RoomRepository $repository;

    public function __construct(RoomRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data, Interlocutor $interlocutor): Room
    {
        /** @var Room $room */
        $room = $this->repository->create([
            'creator' => $interlocutor->id,
            'name' => $data['name']
        ]);

        $interlocutor->room_id = $room->id;
        $interlocutor->save();

        return $room;
    }

    public function show(Room $room): RoomResource
    {
        return new RoomResource($room);
    }

    public function check(string $name): bool
    {
        return $this->repository->checkRoom($name);
    }
}