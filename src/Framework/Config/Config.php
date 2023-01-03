<?php

namespace Ddd\Framework\Config;

interface Config
{
    public function get(string $configName, mixed $default = null): mixed;

    public function getAll(): array;

    public function getName(): string;

    public function exist(string $configName): bool;
}