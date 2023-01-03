<?php

namespace Ddd\Tests\Framework\Controller;

use Ddd\Framework\Controller\FrameworkController;
use Ddd\Framework\Http\Response\Response;
use PHPUnit\Framework\TestCase;

class FrameworkControllerTest extends TestCase
{
    public function testNotFound()
    {
        $response = (new FrameworkController())->notFoundAction();
        self::assertInstanceOf(Response::class, $response);
    }
}