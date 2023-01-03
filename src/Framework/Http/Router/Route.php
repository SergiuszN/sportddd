<?php

namespace Ddd\Framework\Http\Router;

final class Route
{
    public function __construct(
        public readonly string $name,
        public readonly string $path,
        public readonly string $controller,
        public readonly string $action,
    )
    {

    }
}