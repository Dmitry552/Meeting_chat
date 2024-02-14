<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Status code
     */
    protected const STATUS_METHOD_NOT_ALLOWED = 405;
    protected const STATUS_UNPROCESSABLE_ENTITY = 422;
    protected const STATUS_UNAUTHORIZED = 401;
    protected const STATUS_NOT_FOUND = 404;
    protected const STATUS_FORBIDDEN = 403;
    protected const STATUS_BAD_REQUEST = 400;
    protected const STATUS_MODEL_USED = 409;

    /**
     * Global structure
     */
    protected function getUserStructure(): array
    {
        return [
            'id',
            'firstName',
            'lastName',
            'gender',
            'phone',
            'currentAddress',
            'permanantAddress',
            'email',
            'birthday',
            'email_verified',
            'avatarPath',
            'created_at',
            'updated_at'
        ];
    }
}
