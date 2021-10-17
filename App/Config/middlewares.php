<?php
# Set Middlewares Here

use Gui\Mvc\Middlewares\AuthMiddleware;

return $middlewares = [
    'auth' => AuthMiddleware::class,
    'teste' => AuthMiddleware::class
];