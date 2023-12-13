<?php

namespace App\Http\Services;

abstract class BaseAuthService
{
    protected string $guard;

    public function __construct()
    {
        $this->guard = static::getGuard();
    }

    abstract public function getGuard(): string;
}