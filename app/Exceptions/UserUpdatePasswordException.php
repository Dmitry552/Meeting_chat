<?php

namespace App\Exceptions;

use Exception;

class UserUpdatePasswordException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('exceptionMessage.update password'), 400);
    }
}
