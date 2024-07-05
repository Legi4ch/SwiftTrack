<?php

namespace App\Router;

class Route
{
    private string $uri;
    private string $controller;
    private string $method;
    private array $middlewares;

    public function __construct(string $uri, string $controller, string $method = 'GET', array $middlewares = [])
    {
        $this->uri = $uri;
        $this->controller = $controller;
        $this->method = $method;
        $this->middlewares = $middlewares;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}