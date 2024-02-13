<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Facades\JWTAuth;

class SystemAuthService extends BaseAuthService
{
    public function getGuard(): string
    {
        return 'web';
    }

    public function login(User|array $data): JsonResponse | array
    {
        $status = false;

        $remember_me = $data['remember_me'];
        $data = Arr::except($data, 'remember_me');

        if ($remember_me) {
            auth($this->guard)->factory()->setTTL(20160);
            $status = auth($this->guard)->attempt($data, $remember_me);
        } else {
            $status = auth($this->guard)->attempt($data);
        }

        if (!$status) {
            return response()->json(['error' => 'Unauthorized'], 401);
        } else {
            $user = auth($this->guard)->user();
            $token = JWTAuth::fromUser($user);
        }

        return response()->json($this->respondWithToken($token));
    }

    public function logout(): JsonResponse
    {
        auth($this->guard)->logout();
        session()->invalidate();
        session()->regenerateToken();

        return response()->json(['message' => 'Successfully logged out']);
    }

}
