<?php

namespace Ddd\Tests\Framework;

use Ddd\Framework\Framework;
use Ddd\Framework\Http\Response\Response;
use Ddd\Framework\Http\Router\Route;
use Ddd\Tests\Stabs\Framework\ArrayPassedRequest;
use Ddd\Tests\Stabs\Framework\ArrayPassedRouter;
use Ddd\Tests\Stabs\Framework\StubbedController;
use PHPUnit\Framework\TestCase;

class FrameworkTest extends TestCase
{
    private function getTestFramework(): Framework
    {
        return new Framework(
            new ArrayPassedRouter([
                new Route('name', '/path', StubbedController::class, 'testAction'),
                new Route('name', '/void', StubbedController::class, 'voidAction'),
                new Route('name', '/not-exist', StubbedController::class, 'noAction'),
            ])
        );
    }

    public function testSuccessHandle(): void
    {
        $framework = $this->getTestFramework();
        $response = $framework->handle(new ArrayPassedRequest([], [], ['uri' => '/path']));

        self::assertInstanceOf(Response::class, $response);
    }

    public function testActionWithNoResponseThrowsFrameworkException()
    {
        $this->expectExceptionMessage('Action response must be always instance of Response');
        $framework = $this->getTestFramework();
        $framework->handle(new ArrayPassedRequest([], [], ['uri' => '/void']));
    }

    public function testNotExistedControllerThrowsFrameworkException()
    {
        $framework = $this->getTestFramework();

        $this->expectExceptionMessage('Cant execute route due that Ddd\Tests\Stabs\Framework\StubbedController::noAction() do not exist!');
        $framework->handle(new ArrayPassedRequest([], [], ['uri' => '/not-exist']));
    }
}