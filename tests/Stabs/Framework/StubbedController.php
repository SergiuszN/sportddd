<?php

namespace Ddd\Tests\Stabs\Framework;

use Ddd\Framework\Http\Response\HtmlResponse;

class StubbedController
{
    public function testAction(): HtmlResponse
    {
        return new HtmlResponse('testActionResponse');
    }

    public function voidAction(): void
    {

    }
}