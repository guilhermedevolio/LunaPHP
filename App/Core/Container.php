<?php

namespace Gui\Mvc\Core;

use Gui\Mvc\Exceptions\MiddlewareException;

class Container
{
    private static string $namespace = "Gui\\Mvc\\";

    public static function controller(string $controller): object
    {
        $Object = self::$namespace . "Controllers\\" . ucfirst($controller);
        return new $Object;
    }

    public static function isClosure($callback): bool
    {
        return (bool)($callback instanceof \Closure);
    }

    public static function middleware($middleware): void
    {
        $middlewares = require_once __DIR__ . '/../Config/middlewares.php';

        if (is_array($middleware) && is_countable($middleware)) {
            foreach ($middleware as $md) {
                new $middlewares[$md];
            }
        } else {
            if (!isset($middlewares[$middleware])) {
                throw new MiddlewareException();
            }

            new $middlewares[$middleware];
        }
    }

}