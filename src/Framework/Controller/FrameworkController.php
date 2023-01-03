<?php

namespace Ddd\Framework\Controller;

use Ddd\Framework\Http\Response\HtmlResponse;

class FrameworkController
{
    public function notFoundAction(): HtmlResponse
    {
        return new HtmlResponse('404 Not Found!');
    }
}