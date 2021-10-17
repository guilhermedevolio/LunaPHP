<?php

namespace Gui\Mvc\Core;

use Gui\Mvc\Core\Http\Http;

class Router extends Http
{
    private $url;
    private array $routes;
    private array $params = [];

    public function __construct()
    {
        $this->url = $this->request()->url() ?? '/';
    }

    public function getParsedUrl()
    {
        return explode('/', $this->url);
    }

    public function get($url, $controller, $middleware = null)
    {
        $this->routes['GET'][] = [$url, $controller, $middleware];
    }

    public function post($url, $controller, $middleware = null)
    {
        $this->routes['POST'][] = [$url, $controller, $middleware];
    }

    public function put($url, $controller, $middleware = null)
    {
        $this->routes['PUT'][] = [$url, $controller, $middleware];
    }

    public function delete($url, $controller, $middleware = null)
    {
        $this->routes['DELETE'][] = [$url, $controller, $middleware];
    }

    public function dispatch()
    {
        $routes = $this->routes[$this->request()->method()];
        $urlArray = $this->getParsedUrl();

        foreach ($routes as $route) {
            if (Container::isClosure($route[1])) {
                return $route[1]();
            }

            $routeArray = explode('/', $route[0]);

            for ($i = 0; $i < count($routeArray); $i++) {
                if ((strpos($routeArray[$i], '{') !== false) && (count($routeArray) == count($urlArray))) {
                    $routeArray[$i] = $urlArray[$i];
                    $this->params[] = $routeArray[$i];
                }
                $route[0] = implode('/', $routeArray);
            }

            if ($this->url === $route[0]) {
                $controller = explode('@', $route[1])[0];
                $method = explode('@', $route[1])[1];
                $middleware = $route[2] ?? null;

                //Load Middleware if exists
                if (isset($middleware) && $middleware != null) {
                    Container::middleware($middleware);
                }

                call_user_func_array([Container::controller($controller), $method], $this->params);
                break;
            }
        }
    }


}