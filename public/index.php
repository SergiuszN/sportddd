<?php

require_once __DIR__ . '/../vendor/autoload.php';

$router = new \Ddd\Framework\Http\Router\HttpRouter(
    new \Ddd\Framework\Config\FileConfig('router'),
    new \Ddd\Framework\Config\FileConfig('routes')
);

$framework = new \Ddd\Framework\Framework($router);

$response = $framework->handle(\Ddd\Framework\Http\Request\HttpRequest::getInstance());
$response->render();

die();