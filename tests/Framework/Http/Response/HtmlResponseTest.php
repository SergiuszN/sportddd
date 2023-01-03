<?php

namespace Ddd\Tests\Framework\Http\Response;

use Ddd\Framework\Http\Response\HtmlResponse;
use PHPUnit\Framework\TestCase;

class HtmlResponseTest extends TestCase
{
    public function testRender()
    {
        $response = new HtmlResponse('test');

        ob_start();
        $response->render();
        $render = ob_get_clean();

        self::assertEquals('test', $render);
    }
}