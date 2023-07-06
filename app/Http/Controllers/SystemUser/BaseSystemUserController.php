<?php

namespace App\Http\Controllers\SystemUser;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

abstract class BaseSystemUserController extends Controller
{
    public function currentGuard(): string
    {
        return 'admin';
    }

    public function getUser(): Authenticatable|null
    {
        return auth($this->currentGuard())->user();
    }
}
