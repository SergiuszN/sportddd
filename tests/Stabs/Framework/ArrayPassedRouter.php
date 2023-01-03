<?php

namespace Ddd\Tests\Stabs\Framework;

use Ddd\Framework\Http\Request\Request;
use Ddd\Framework\Http\Router\Route;
use Ddd\Framework\Http\Router\Router;

class ArrayPassedRouter implements Router
{
    public function __construct(private readonly array $routes)
    {

    }

    public function handleRequest(Request $request): Route
    {
        $routes = array_values(array_filter($this->routes, fn (Route $route) => $route->path === $request->server('uri')));
        return $routes[0];
    }

    public function generateUrl(string $routeName, array $params = []): string
    {
        $route = array_values(array_filter($this->routes, fn (Route $route) => $route->name === $routeName))[0];
        return $route->path;
    }
}