<?php

namespace App\Http\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use \Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private string $guard;

    public function __construct(string $guard = 'user')
    {
        $this->guard = $guard;
    }

    public function login(User|array $data, string $guard = null): JsonResponse|array
    {
        if (isset($guard)) {
            $this->guard = $guard;
        }

        if ($data instanceof User) {
            $token = JWTAuth::fromUser($data);

            return $this->respondWithToken($token);
        }

        if (! $token = auth($this->guard)->attempt($data)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json($this->respondWithToken($token));
    }

    public function me():  JsonResponse
    {
        return response()->json(new UserResource(auth($this->guard)->user()));
    }

    public function logout(): JsonResponse
    {
        auth($this->guard)->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        return response()->json($this->respondWithToken(auth($this->guard)->refresh()));
    }

    private function respondWithToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth($this->guard)->factory()->getTTL() * 60
        ];
    }
}
