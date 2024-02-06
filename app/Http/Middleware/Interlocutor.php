<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;

class Interlocutor extends Authenticate
{
    public function __construct(Auth $auth)
    {
        parent::__construct($auth);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  Request  $request
     * @param  array  $guards
     * @return void
     */
    protected function authenticate($request, array $guards): void
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $this->auth->shouldUse($guard);
                return;
            }
        }
    }
}
