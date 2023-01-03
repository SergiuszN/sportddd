<?php

namespace Ddd\Tests\Stabs\Framework;

use Ddd\Framework\Http\Request\Request;

class ArrayPassedRequest implements Request
{
    public function __construct(
        private readonly array $get,
        private readonly array $post,
        private readonly array $server,
    )
    {
    }

    public function get(string $variable, mixed $default = null): mixed
    {
        return $this->get[$variable] ?? $default;
    }

    public function post(string $variable, mixed $default = null): mixed
    {
        return $this->post[$variable] ?? $default;
    }

    public function server(string $variable, mixed $default = null): mixed
    {
        return $this->server[$variable] ?? $default;
    }
}