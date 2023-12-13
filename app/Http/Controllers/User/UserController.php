<?php

namespace App\Http\Controllers\User;

use App\Exceptions\UserUpdateException;
use App\Exceptions\UserUpdatePasswordException;
use App\Http\Requests\User\SocialUserDataRequest;
use App\Http\Requests\User\UserAvatarRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserPasswordRequest;
use App\Http\Requests\User\UserGetRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends BaseUserController
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(UserGetRequest $request): JsonResponse
    {
        return response()->json($this->service->getUsers($request->all()));
    }

    public function store(UserCreateRequest $request): JsonResponse
    {
        return response()->json($this->service->create($request->all()));
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($this->service->show($user));
    }

    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        return response()->json($this->service->update($request->all(), $user));
    }

    public function destroy(User $user): JsonResponse
    {
        return response()->json($this->service->destroy($user));
    }

    /**
     * @param SocialUserDataRequest $request
     * @return JsonResponse
     */
    public function socialUserData(SocialUserDataRequest $request): JsonResponse
    {
        return response()->json($this->service->socialUserData($request->all()));
    }

    /**
     * @param UserAvatarRequest $request
     * @return JsonResponse
     * @throws UserUpdateException
     */
    public function avatar(UserAvatarRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        return response()->json($this->service->avatar($request->file('avatar'), $user));
    }

    public function destroyAvatar(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        return response()->json($this->service->destroyAvatar($user));
    }

    /**
     * @param UserPasswordRequest $request
     * @param User $user
     * @throws UserUpdateException
     * @throws UserUpdatePasswordException
     */
    public function password(UserPasswordRequest $request, User $user): void
    {
        $this->service->password($request->all(), $user);

        response()->noContent();
    }
}
