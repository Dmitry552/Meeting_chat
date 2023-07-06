<?php

namespace App\Exceptions;

use Exception;

class UserUpdateException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('exceptionMessage.Error update user'), 400);
    }
}
