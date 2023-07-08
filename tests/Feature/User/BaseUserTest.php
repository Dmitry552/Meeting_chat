<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class BaseUserTest extends TestCase
{
    /**
     * Auth user
     */
    protected const ROUTE_USER_LOGIN = 'api/login';
    protected const ROUTE_USER_LOGOUT = 'api/user/logout';
    protected const ROUTE_USER_REFRESH = 'api/user/refresh';

    protected function getAuthUserLoginRequest(): array
    {
        return [
            'access_token',
            'token_type',
            'expires_in',
        ];
    }

    protected function getValidationErrorStructure(): array
    {
        return [
            'message',
            'errors'
        ];
    }

    protected function getUnauthorizedfragment(): array
    {
        return [
            'error' => 'Unauthorized'
        ];
    }

    protected function getLogoutFragment(): array
    {
        return [
            'message' => 'Successfully logged out'
        ];
    }

    protected function getErrorEmailFieldIsRequired(): array
    {
        return [
          'message' => 'The email field is required.'
        ];
    }

    protected function getErrorEmailMustBeValid(): array
    {
        return [
            'message' => 'The email must be a valid email address.'
        ];
    }

    protected function getErrorPasswordFieldIsRequired(): array
    {
        return [
            'message' => 'The password field is required.'
        ];
    }

    protected function getErrorPasswordMustBeValid(): array
    {
        return [
            'message' => 'The password must contain at least one number.'
        ];
    }
}
