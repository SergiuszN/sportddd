<?php

namespace Ddd\Sportyvis\Application;

use Ddd\Framework\Http\Response\HtmlResponse;
use Ddd\Framework\Http\Response\HtmlTemplatedResponse;

class IndexController
{
    public function homepage(): HtmlTemplatedResponse
    {
        return new HtmlTemplatedResponse('pages/index/index.php', ['test' => 10]);
    }

    public function posts()
    {
        return new HtmlResponse('posts');
    }

    public function post()
    {
        return new HtmlResponse('post');
    }

    public function postComments()
    {
        return new HtmlResponse('post comments');
    }
}