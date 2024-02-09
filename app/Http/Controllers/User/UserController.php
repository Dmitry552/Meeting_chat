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
    /**
     * PERMISSION_YYYY_DDDD_AAAA = 'pesmision yyyy dddd aaaa'
     *
     * YYYY(yyyy) - who is doing
     * DDDD(dddd) - where does it do
     * AAAA(aaaa) - what is he doing
     */
    public const PERMISSION_SYSTEM_USER_INDEX = 'permission system user index';
    public const PERMISSION_SYSTEM_USER_SHOW = 'permission system user show';
    public const PERMISSION_SYSTEM_USER_DESTROY = 'permission system user destroy';
    public const PERMISSION_USER_USERS_SHOW = 'permission user users show';
    public const PERMISSION_USER_USERS_UPDATE = 'permission user users update';
    public const PERMISSION_USER_USERS_DESTROY = 'permission user users destroy';

    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;

        $this->authorizeResource(User::class);
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

    protected function resourceAbilityMap(): array
    {
        return [
            'index' => 'systemIndex',
            'show' => 'show',
            'store' => 'create',
            'update' => 'update',
            'destroy' => 'delete',
        ];
    }
}
