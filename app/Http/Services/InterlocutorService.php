<?php

namespace App\Http\Services;

use App\Http\Repositories\Interlocutor\InterlocutorRepository;
use App\Http\Resources\InterlocutorResource;
use App\Models\Interlocutor;
use App\Models\Room;
use App\Models\SystemUser;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class InterlocutorService
{
    private InterlocutorRepository $repository;
    private RoomService $roomService;

    public function __construct(InterlocutorRepository $repository, RoomService $roomService)
    {
        $this->repository = $repository;
        $this->roomService = $roomService;
    }

    /**
     *
     * @param Interlocutor $interlocutor
     * @return InterlocutorResource
     */
    public function show(Interlocutor $interlocutor): InterlocutorResource
    {
        return new InterlocutorResource($interlocutor);
    }

    /**
     * Creating a new interlocutor.
     *
     * @param array $request
     * @return InterlocutorResource
     */
    public function create(array $request): InterlocutorResource
    {
        $data = ['code' => Str::uuid()];

        /** @var User | SystemUser $user */
        $user = auth()->user();

        if ($user) {
            $data['interlocutorName'] = $user->firstName;
            $data['user_id'] = $user->id;
        } else {
            $data['interlocutorName'] = $request['userName'];
        }

        $interlocutor = $this->repository->create($data);

        return new InterlocutorResource($interlocutor);
    }

    /**
     * @param Interlocutor $interlocutor
     * @return InterlocutorResource
     */
    public function delete(Interlocutor $interlocutor): InterlocutorResource
    {
        $this->repository->delete($interlocutor);

        /** @var Room $room */
        $room = $interlocutor->room;

        if ($room->interlocutors()->count() === 0) {
            $this->roomService->delete($room);
        }

        return new InterlocutorResource($interlocutor);
    }

    /**
     * Returns the interlocutors of the room
     *
     * @param Room $room
     * @return AnonymousResourceCollection
     */
    public function interlocutorsRoom(Room $room): AnonymousResourceCollection
    {
        return InterlocutorResource::collection($this->repository->interlocutorsRoom($room));
    }
}
