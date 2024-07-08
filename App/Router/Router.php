<?php

namespace App\Router;

use Config\Config;
use App\Controllers\ErrorsController;
use App\Request\Request;
use ReflectionClass;
use ReflectionException;


class Router
{
    private array $routes = [];

    private function initController($controllerName) {
        try {
            $class = new ReflectionClass($controllerName);
            return $class->newInstance();
        } catch (ReflectionException $e) {
            error_log("Controller initiation error $controllerName");
            ErrorsController::handleError(500, "Controller $controllerName initiation error: " . $e->getMessage());
            die();
        }
    }

    private function matchRoute(Route $route, string $uri): bool {
        return preg_match("#^" . $route->getUri() . "$#", $uri);
    }

    private function runMiddlewares(Request $request, array $middlewares, callable $next)  {
        $middlewareStack = array_reverse($middlewares);

        $pipeline = array_reduce($middlewareStack, function($next, $middleware) {
            return function(Request $request) use ($next, $middleware) {
                return $middleware->handle($request, $next);
            };
        }, $next);

        return $pipeline($request);
    }

    private function handleError(int $statusCode, string $message): void {
        error_log($message);
        ErrorsController::handleError($statusCode, $message);
    }

    public function handle(Request $request): void {
        $uri = parse_url($request->getUri(), PHP_URL_PATH);
        $method = $request->getMethod();

        foreach ($this->routes as $route) {
            if (!class_exists($route->getController())) {
                $this->handleError(500, "Controller class not found: " . $route->getController());
                return;
            }
            if ($this->matchRoute($route, $uri)) {
                if ($route->getMethod() != $method) {
                    $this->handleError(405, "");
                    return;
                }
                // Обработка Middleware перед вызовом контроллера
                $this->runMiddlewares($request, $route->getMiddlewares(), function(Request $request) use ($route) {
                    try {
                        $controller = $this->initController($route->getController());
                        $controller->init($request);
                    } catch (ReflectionException $e) {
                        $this->handleError(500, "Router initiation error: " . $e->getMessage());
                        return;
                    }
                });
                return;
            }
        }
        $this->handleError(404, Config::HOST . $request->getUri());
    }

    public function loadRoutes(string $directory): void
    {
        $files = glob($directory . '/*.php');
        foreach ($files as $file) {
            $routes = require $file;
            if (is_callable($routes)) {
                $routes($this);
            }
        }
    }

    public function get(string $uri, string $controller, array $middlewares = []): void
    {
        $this->addRoute($uri, $controller, 'GET', $middlewares);
    }

    public function post(string $uri, string $controller, array $middlewares = []): void
    {
        $this->addRoute($uri, $controller, 'POST', $middlewares);
    }

    public function put(string $uri, string $controller, array $middlewares = []): void
    {
        $this->addRoute($uri, $controller, 'PUT', $middlewares);
    }

    public function delete(string $uri, string $controller, array $middlewares = []): void
    {
        $this->addRoute($uri, $controller, 'DELETE', $middlewares);
    }

    public function option(string $uri, string $controller, array $middlewares = []): void
    {
        $this->addRoute($uri, $controller, 'OPTION', $middlewares);
    }

    public function addRoute(string $uri, string $controller, string $method, array $middlewares): void
    {
        $this->routes[] = new Route($uri, $controller, $method, $middlewares);
    }

}