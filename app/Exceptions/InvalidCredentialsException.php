<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class InvalidCredentialsException extends Exception
{
    protected $code = 401;
}
