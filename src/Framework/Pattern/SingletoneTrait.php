<?php

namespace Ddd\Framework\Pattern;

use Ddd\Framework\Exception\FrameworkException;

trait SingletoneTrait
{
    private static ?self $self = null;

    public static function getInstance(): self
    {
        if (!static::$self) {
            static::$self = new static();
        }

        return static::$self;
    }

    private static function throwIfUsedConstructor(): void
    {
        if (self::$self) {
            $class = self::class;
            throw new FrameworkException("Do not use directly constructor of that class. Use {$class}::getInstance() instead of new()");
        }
    }
}