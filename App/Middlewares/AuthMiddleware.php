<?php

namespace Gui\Mvc\Middlewares;

class AuthMiddleware
{
    public function __construct()
    {
        echo "Auth Middleware" . PHP_EOL;
    }
}