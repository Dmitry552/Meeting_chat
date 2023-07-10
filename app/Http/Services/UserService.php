<?php

namespace App\Http\Services;

use App\Http\Repositories\User\UserRepository;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Exceptions\UserUpdateException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    private AuthService $authService;
    private UserRepository $userRepository;

    public function __construct(AuthService $authService, UserRepository $userRepository)
    {
        $this->authService = $authService;
        $this->userRepository = $userRepository;
    }

    public function getUsers(array $data): array
    {
        $users = $this->userRepository->index($data);

        return [
            'data' => UserResource::collection($users),
            'meta' => $this->getTransformedMetaData($users)
        ];
    }

    public function create(array $data): array
    {
        /** @var User $user */
        $user = $this->userRepository->create($data);

        $authUser = $this->authService->login($user, 'user');

        return [
            'data'    => $authUser,
            'message' => __('notifications.email confirmation link')
        ];
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * @throws UserUpdateException
     */
    public function update(array $data, User $user): UserResource
    {
        if ($this->userRepository->update($data, $user)) {
            return new UserResource($user);
        }

        throw new UserUpdateException();
    }

    public function destroy(User $user): UserResource
    {
        $this->userRepository->delete($user);

        return new UserResource($user);
    }

    private function getTransformedMetaData(LengthAwarePaginator $data): array
    {
        return [
            'links' => [
                'path'         => $data->getOptions()['path'],
                'firstPageUrl' => $data->url(1),
                'lastPageUrl'  => $data->url($data->lastPage()),
                'nextPageUrl'  => $data->nextPageUrl(),
                'prevPageUrl'  => $data->previousPageUrl()
            ],
            'meta' => [
                'currentPage'  => $data->currentPage(),
                'from'         => $data->firstItem(),
                'lastPage'     => $data->lastPage(),
                'perPage'      => $data->perPage(),
                'to'           => $data->lastItem(),
                'total'        => $data->total(),
                'count'        => $data->count(),
            ]
        ];
    }
}
