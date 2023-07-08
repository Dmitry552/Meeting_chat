<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UserLoginRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthUserController extends BaseUserController
{
    private AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService($this->currentGuard());
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        return $this->service->login($request->all());
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return $this->service->me();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return $this->service->logout();
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->service->refresh();
    }
}
