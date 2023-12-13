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

    protected function tearDown(): void
    {
        DB::table('users')->get()->each(function ($user) {
            $avatarPath = $user->avatarPath ?: '';
            if (Storage::exists($avatarPath)) {
                Storage::delete($avatarPath);
            }
        });

        parent::tearDown();
    }

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
}
