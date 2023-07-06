<?php

namespace App\Exceptions;

use Exception;

class UserUpdateException extends Exception
{
    public function __construct()
    {
        parent::__construct("Error update user", 400);
    }
}
