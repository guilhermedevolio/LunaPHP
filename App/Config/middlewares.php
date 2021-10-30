<?php
# Set Middlewares Here

use Gui\Mvc\Middlewares\AdminAuthMiddleware;
use Gui\Mvc\Middlewares\AuthMiddleware;

return $middlewares = [
    'auth' => AuthMiddleware::class,
    'admin_auth' => AdminAuthMiddleware::class
];