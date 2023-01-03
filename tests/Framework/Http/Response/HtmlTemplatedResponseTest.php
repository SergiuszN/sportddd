<?php

namespace Ddd\Tests\Framework\Http\Response;

use Ddd\Framework\Http\Response\HtmlTemplatedResponse;
use PHPUnit\Framework\TestCase;

class HtmlTemplatedResponseTest extends TestCase
{
    public function testRender()
    {
        $response = new HtmlTemplatedResponse('../tests/Stabs/Framework/template.php');

        ob_start();
        $response->render();
        $render = ob_get_clean();

        self::assertEquals('template for testing', $render);
    }

    public function testNotExistedTemplateThrowsException()
    {
        $this->expectExceptionMessage('Template ../tests/Stabs/Framework/testtest.php do not exist!');
        $response = new HtmlTemplatedResponse('../tests/Stabs/Framework/testtest.php');

        ob_start();

        try {
            $response->render();
        } catch (\Throwable $ex) {
            ob_end_clean();
            throw $ex;
        }

        ob_end_clean();
    }

    public function testErrorOnRenderIsFlushedWithoutRender()
    {
        $this->expectExceptionMessage('error from template');
        $response = new HtmlTemplatedResponse('../tests/Stabs/Framework/template_exception.php');
        $response->render();
    }
}