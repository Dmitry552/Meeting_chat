<?php

namespace App\Http\Controllers\SystemUser;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class SystemUserController extends BaseSystemUserController
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
