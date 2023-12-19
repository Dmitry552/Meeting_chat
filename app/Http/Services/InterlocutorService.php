<?php

namespace App\Http\Services;

use App\Http\Repositories\Interlocutor\InterlocutorRepository;
use App\Http\Resources\InterlocutorResource;
use App\Models\SystemUsers;
use App\Models\User;

class InterlocutorService
{
    private InterlocutorRepository $repository;

    public function __construct(InterlocutorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $request): InterlocutorResource
    {
        $data = [];

        /** @var User | SystemUsers $user */
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
}
