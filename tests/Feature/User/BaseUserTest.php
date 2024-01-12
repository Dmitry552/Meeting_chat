<?php

namespace Tests\Feature\User;

use Tests\Feature\Traits\UserAuthorizedTrait;
use Tests\TestCase;

abstract class BaseUserTest extends TestCase
{
    use UserAuthorizedTrait;

    /**
     * Auth user
     */
    protected const ROUTE_USER_CREATE = 'api/registration';
    protected const ROUTE_AUTH_LOGIN = 'api/login';
    protected const ROUTE_AUTH_LOGOUT = 'api/user/logout';
    protected const ROUTE_AUTH_REFRESH = 'api/user/refresh';
    protected const ROUTE_AUTH_SHOW_ME = 'api/user/me';
    protected const ROUTE_AUTH_FORGOT_PASSWORD = 'api/forgot-password';

    /**
     * User
     */
    protected const ROUTE_USER_INDEX = 'api/user/';
    protected const ROUTE_USER_SHOW = 'api/user/';
    protected const ROUTE_USER_UPDATE = 'api/user/';
    protected const ROUTE_USER_DESTROY = 'api/user/';
    protected const ROUTE_USER_AVATAR = 'api/user/avatar/';
    protected const ROUTE_USER_UPLOAD_PASSWORD = '/api/user/password/';


    /**
     * Methods auth
     */
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

    /**
     * Methods user
     */
    protected function getUsersStructure(): array
    {
        return [
            'data' => [
                '*' => $this->getUserStructure()
            ],
            'links' => [
                'path',
                'firstPageUrl',
                'lastPageUrl',
                'nextPageUrl',
                'prevPageUrl',
            ],
            'meta' => [
                'currentPage',
                'from',
                'lastPage',
                'perPage',
                'to',
                'total',
                'count',
            ]

        ];
    }

    protected function getCreationUserStructure(): array
    {
        return [
          'data' => $this->getAuthUserLoginRequest(),
          'message'
        ];
    }

    protected function getMessageAfterUserCreation(): array
    {
        return [
            'message' => 'You have been sent a confirmation email!'
        ];
    }
}
