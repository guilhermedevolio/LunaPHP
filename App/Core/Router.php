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

    private function loadMiddlewares($middlewares)
    {
        if (isset($middleware) && $middleware != null) {
            Container::middleware($middleware);
        }
    }

    private function getParsedClassData(array $data): array
    {
        $payload['controller'] = new $data['route'][1][0];
        $payload['method'] = $data['route'][1][1] ?? 'index';
        $payload['middlewares'] = $data['route'][2];
        $payload['params'] = $data['params'];

        return $payload;
    }

    private function validateRoute($url): bool
    {
        if ($this->url === $url) {
            return true;
        }

        return false;
    }

    private function mountedRoute(array $route): array
    {
        $urlArray = $this->getParsedUrl();
        $routeArray = explode('/', $route[0]);
        $params = [];

        for ($i = 0; $i < count($routeArray); $i++) {
            if ((strpos($routeArray[$i], '{') !== false) && (count($routeArray) == count($urlArray))) {
                $routeArray[$i] = $urlArray[$i];
                $params[] = $routeArray[$i];
            }
            $route[0] = implode('/', $routeArray);
        }

        return ['route' => $route, 'params' => $params];
    }


    public function dispatch()
    {
        $routes = $this->routes[$this->request()->method()];

        foreach ($routes as $route) {
            $route_mounted = $this->mountedRoute($route);

            $object = $this->getParsedClassData($route_mounted);

            if ($this->validateRoute($route_mounted['route'][0])) {
                return $this->run($object['controller'], $object['method'], $object['params']);
            }
        }

        //TODO: Colocar o Controller de Erro
        die('Página não encontrada');
    }

    private function run($controller, $method, $params)
    {
        if (Container::isClosure($method)) {
            return $method();
        }

        call_user_func_array([$controller, $method], $params);
    }


}