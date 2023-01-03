<?php

namespace Ddd\Tests\Stabs\Framework;

use Ddd\Framework\Config\Config;

class ArrayPassedConfig implements Config
{
    public function __construct(private readonly string $configName, private readonly array $config)
    {

    }

    public function get(string $configName, mixed $default = null): mixed
    {
        return $this->config[$configName] ?? $default;
    }

    public function getAll(): array
    {
        return $this->config;
    }

    public function getName(): string
    {
        return $this->configName;
    }

    public function exist(string $configName): bool
    {
        return array_key_exists($configName, $this->config);
    }
}