<?php

namespace App\Http\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Exceptions\UserUpdateException;

class UserService
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index(): array
    {
        $users = $this->userRepository->index();

        return [
            'data' => UserResource::collection($users),
            'meta' => $this->getTransformedMetaData($users)
        ];
    }

    public function create(array $data): array
    {
        $user = $this->userRepository->create($data);

        $authUser = $this->authService->login($user, 'user');

        return [
            'data'    => $authUser,
            'message' => ''
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


}