<?php

namespace Ddd\Framework\Http\Response;

final class JsonResponse implements Response
{

    public function __construct(private readonly array $data)
    {
    }

    public function render()
    {
        echo json_encode($this->data);
    }
}