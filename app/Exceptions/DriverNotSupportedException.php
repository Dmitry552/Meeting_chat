<?php

namespace App\Exceptions;

use Exception;

class DriverNotSupportedException extends Exception
{
    public function __construct(string $attribute)
    {
        parent::__construct(__('exceptionMessage.driver not supported', ['attribute' => $attribute]), 400);
    }
}
