<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

abstract class BaseUserController extends Controller
{
    public function currentGuard(): string
    {
        return 'user';
    }

    public function getUser(): Authenticatable
    {
        return auth($this->currentGuard())->user();
    }
}
