<?php

namespace Ddd\Tests\Framework\Http\Response;

use Ddd\Framework\Http\Response\JsonResponse;
use PHPUnit\Framework\TestCase;

class JsonResponseTest extends TestCase
{
    public function testRender()
    {
        $response = new JsonResponse(['test' => 'ok']);

        ob_start();
        $response->render();
        $render = ob_get_clean();

        self::assertEquals('{"test":"ok"}', $render);
    }
}