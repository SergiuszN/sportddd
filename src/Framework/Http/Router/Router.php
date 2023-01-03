<?php

namespace Ddd\Framework\Http\Router;

use Ddd\Framework\Http\Request\Request;

interface Router
{
    public function handleRequest(Request $request): Route;

    public function generateUrl(string $routeName, array $params = []): string;
}