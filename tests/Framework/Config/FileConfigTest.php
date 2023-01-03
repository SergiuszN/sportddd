<?php

namespace Ddd\Tests\Framework\Config;

use Ddd\Framework\Config\FileConfig;
use PHPUnit\Framework\TestCase;

class FileConfigTest extends TestCase
{
    public function testExistedFile()
    {
        $config = new FileConfig('../tests/Stabs/Framework/test');
        self::assertEquals('value', $config->get('TEST'));
        self::assertEquals('../tests/Stabs/Framework/test', $config->getName());
    }

    public function testNotExistedConfigThrowsFrameworkException()
    {
        self::expectExceptionMessage('Config ../tests/Stabs/Framework/notExist is not exist!');
        new FileConfig('../tests/Stabs/Framework/notExist');
    }

    public function testExist()
    {
        $config = new FileConfig('../tests/Stabs/Framework/test');
        self::assertTrue($config->exist('TEST'));
        self::assertFalse($config->exist('sss'));
    }

    public function testGetAll()
    {
        $config = new FileConfig('../tests/Stabs/Framework/test');
        self::assertEquals(['TEST' => 'value'], $config->getAll());
    }
}