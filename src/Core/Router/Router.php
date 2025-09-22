<?php

namespace App\Core\Router;

use Exception, App\Core\Logger\Logger;
use App\Controllers\NotFoundController\NotFoundController;

class Router
{
    public array $routes = [];

    public function get(string $route, array|callable $routeHandler): Router
    {
        return $this->register('get', $route, $routeHandler);
    }

    public function post(string $route, array|callable $routeHandler): Router
    {
        return $this->register('post', $route, $routeHandler);
    }


    private function register(string $method, string $route, callable|array $routeHandler): Router
    {
        if (is_array($routeHandler)) {
            $class = $routeHandler[0];
            $classMethod = $routeHandler[1];

            if (!class_exists($class)) {
                throw new Exception("Class for route handler is not defined.");
            }

            if (!method_exists($class, $classMethod)) {
                throw new Exception("Method on class for route handler does not exist.");
            }
        }


        $route = rtrim($route, '/') . '/';
        $this->routes[$method][$route] = $routeHandler;
        return $this;
    }

    public function resolve()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $url = rtrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/') . '/';

        $routeResolver = $this->routes[$method][$url] ?? null;

        if (!isset($routeResolver)) {
            (new NotFoundController())->index();
            return;
        }

        if (is_callable($routeResolver)) {
            $routeResolver();
            return;
        }

        $class = $routeResolver[0];
        $classMethod = $routeResolver[1];

        (new $class())->$classMethod();
    }
}
