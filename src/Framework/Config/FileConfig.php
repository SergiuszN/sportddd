<?php

namespace Ddd\Framework\Config;

use Ddd\Framework\Exception\FrameworkException;

final class FileConfig implements Config
{
    private static array $configs;
    private readonly array $config;
    private readonly string $name;

    public function __construct(string $name)
    {
        if (!isset(self::$configs[$name])) {
            $configPath = __DIR__ . "/../../../config/{$name}.conf.php";

            if (!file_exists($configPath)) {
                /** @noinspection PhpUnhandledExceptionInspection */
                throw new FrameworkException("Config $name is not exist!");
            }

            self::$configs[$name] = require_once $configPath;
        }

        $this->name = $name;
        $this->config = self::$configs[$name];
    }

    public function exist(string $configName): bool
    {
        return array_key_exists($configName, $this->config);
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
        return $this->name;
    }
}