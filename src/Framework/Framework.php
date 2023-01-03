<?php

namespace Ddd\Framework;

use Ddd\Framework\Exception\FrameworkException;
use Ddd\Framework\Http\Request\Request;
use Ddd\Framework\Http\Response\Response;
use Ddd\Framework\Http\Router\Router;

final class Framework
{
    public function __construct(private readonly Router $router)
    {
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function handle(Request $request): Response
    {
        $route = $this->router->handleRequest($request);

        if (!class_exists($route->controller) || !method_exists($route->controller, $route->action)) {
            throw new FrameworkException("Cant execute route due that {$route->controller}::{$route->action}() do not exist!");
        }

        $response = (new $route->controller())->{$route->action}();

        if (!($response instanceof Response)) {
            throw new FrameworkException('Action response must be always instance of Response');
        }

        return $response;
    }
}