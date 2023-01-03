<?php

namespace Ddd\Framework\Http\Router;

use Ddd\Framework\Config\Config;
use Ddd\Framework\Controller\FrameworkController;
use Ddd\Framework\Exception\FrameworkException;
use Ddd\Framework\Http\Request\Request;

class HttpRouter implements Router
{
    private readonly array $routes;
    private Config $routerConfig;

    public function __construct(
        Config $routerConfig,
        Config $allRoutes,
    )
    {
        $routes = [];

        foreach ($allRoutes->getAll() as $routeName => $routeParams) {
            $routes[] = new Route(
                $routeName,
                ...$routeParams
            );
        }

        $this->routes = $routes;
        $this->routerConfig = $routerConfig;
    }

    public function handleRequest(Request $request): Route
    {
        $uri = $request->server('REQUEST_URI');
        $uri = strtok($uri, '?');

        foreach ($this->routes as $route) {
            /** @var $route Route */
            if ($route->path === $uri) {
                return $route;
            }
        }

        return new Route(
            '_framework_not_found',
            '/',
            $this->routerConfig->get('NOT_FOUND_CONTROLLER', FrameworkController::class),
            $this->routerConfig->get('NOT_FOUND_ACTION', 'notFoundAction'),
        );
    }

    public function generateUrl(string $routeName, array $params = [], bool $absolute = false): string
    {
        $foundRoutes = array_values(array_filter($this->routes, fn (Route $route) => $route->name === $routeName));

        if (empty($foundRoutes)) {
            throw new FrameworkException("There no such route with name: $routeName!");
        }

        $path = $foundRoutes[0]->path;
        $host = $absolute ? $this->routerConfig->get('BASE_URL', 'http://localhost/') : '';

        $queryParams = [];
        foreach ($params as $paramKey => $paramValue) {
            if ($paramValue) {
                $paramKey = urlencode($paramKey);
                $paramValue = urlencode($paramValue);
                $queryParams[] = "{$paramKey}={$paramValue}";
            }
        }

        $queryParams = !empty($queryParams)
            ? '?' . implode('&', $queryParams)
            : '';


        return $host . $path . $queryParams;
    }
}