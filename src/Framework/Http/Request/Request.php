<?php

namespace Ddd\Framework\Http\Request;

interface Request
{
    public function get(string $variable, mixed $default = null): mixed;
    public function post(string $variable, mixed $default = null): mixed;
    public function server(string $variable, mixed $default = null): mixed;
}