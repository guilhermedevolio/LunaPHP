<?php

namespace Gui\Mvc\Exceptions;

use Throwable;

class MiddlewareException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        die('Middleware not found');

        parent::__construct($message, $code, $previous);
    }
}