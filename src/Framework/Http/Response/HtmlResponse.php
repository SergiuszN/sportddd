<?php

namespace Ddd\Framework\Http\Response;

class HtmlResponse implements Response
{
    public function __construct(private readonly string $response)
    {
    }

    public function render()
    {
        echo $this->response;
    }
}