<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UserCreateRequest;
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
}
