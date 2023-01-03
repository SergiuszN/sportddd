<?php

namespace Ddd\Framework\Pattern;

interface SingletoneInterface
{
    public static function getInstance(): self;
}