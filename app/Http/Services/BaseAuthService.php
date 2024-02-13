<?php

namespace App\Http\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

abstract class BaseAuthService
{
    protected string $guard;

    public function __construct()
    {
        $this->guard = static::getGuard();
    }

    public function me():  JsonResponse
    {
        return response()->json(new UserResource(auth($this->guard)->user()));
    }

    public function refresh(): JsonResponse
    {
        return response()->json($this->respondWithToken(auth($this->guard)->refresh()));
    }

    protected function respondWithToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth($this->guard)->factory()->getTTL() * 60
        ];
    }

    abstract public function getGuard(): string;

    abstract public function login(User|array $data): JsonResponse | array;

    abstract public function logout(): JsonResponse;
}