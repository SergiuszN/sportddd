<?php

namespace Ddd\Framework\Http\Request;

use Ddd\Framework\Pattern\SingletoneInterface;
use Ddd\Framework\Pattern\SingletoneTrait;

final class HttpRequest implements Request, SingletoneInterface
{
    use SingletoneTrait;

    private array $get;
    private array $post;
    private array $server;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;

        /** @noinspection PhpUnhandledExceptionInspection */
        self::throwIfUsedConstructor();
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