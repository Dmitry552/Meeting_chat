<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthUserController extends BaseUserController
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param UserLoginRequest $request
     * @return array|JsonResponse
     */
    public function login(UserLoginRequest $request): JsonResponse | array
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

    /**
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        return $this->service->forgotPassword($request->all());
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->service->resetPassword($request->all());
    }
}
