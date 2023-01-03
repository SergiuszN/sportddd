<?php

namespace Ddd\Tests\Framework\Http\Router;

use Ddd\Framework\Config\Config;
use Ddd\Framework\Http\Request\Request;
use Ddd\Framework\Http\Router\HttpRouter;
use Ddd\Framework\Http\Router\Route;
use Ddd\Tests\Stabs\Framework\ArrayPassedConfig;
use Ddd\Tests\Stabs\Framework\ArrayPassedRequest;
use PHPUnit\Framework\TestCase;

class HttpRouterTest extends TestCase
{
    /**
     * @dataProvider handlerTestDataProvider
     */
    public function testHandler(
        Config  $routerConfig,
        Config  $routes,
        Request $request,
        Route   $expected
    )
    {
        $routeFound = (new HttpRouter($routerConfig, $routes))->handleRequest($request);
        self::assertEquals($expected, $routeFound);
    }

    public function handlerTestDataProvider(): array
    {
        return [
            'successRoute' => [
                self::getRouterConfig(),
                self::getRoutesConfig([
                    'index' => ['/', 'controller', 'action']
                ]),
                self::getRequestForUri('/'),
                new Route(
                    'index',
                    '/',
                    'controller',
                    'action'
                )
            ],
            'successRouteWithQuery' => [
                self::getRouterConfig(),
                self::getRoutesConfig([
                    'post' => ['/post', 'controller', 'post']
                ]),
                self::getRequestForUri('/post?id=10'),
                new Route(
                    'post',
                    '/post',
                    'controller',
                    'post'
                )
            ],
            'successRouteMulti' => [
                self::getRouterConfig(),
                self::getRoutesConfig([
                    'index' => ['/', 'controller', 'action'],
                    'post' => ['/post', 'controller', 'postAction'],
                    'posts' => ['/posts', 'controller', 'postsAction'],
                ]),
                self::getRequestForUri('/post'),
                new Route(
                    'post',
                    '/post',
                    'controller',
                    'postAction'
                )
            ],
            'notFoundRoute' => [
                self::getRouterConfig(),
                self::getRoutesConfig([
                    'index' => ['/path', 'controller', 'action']
                ]),
                self::getRequestForUri('/'),
                new Route(
                    '_framework_not_found',
                    '/',
                    'controller',
                    'notFoundAction'
                )
            ],
        ];
    }

    public static function getRoutesConfig(array $routes)
    {
        return new ArrayPassedConfig(
            'routes',
            $routes
        );
    }

    public static function getRouterConfig(): Config
    {
        return new ArrayPassedConfig(
            'router',
            [
                'BASE_URL' => 'http://localhost',
                'NOT_FOUND_CONTROLLER' => 'controller',
                'NOT_FOUND_ACTION' => 'notFoundAction',
            ]
        );
    }

    public static function getRequestForUri(string $uri): Request
    {
        return new ArrayPassedRequest([], [], ['REQUEST_URI' => $uri]);
    }

    /**
     * @dataProvider generateUrlDataProvider
     */
    public function testGenerateUrl(
        Config $routerConfig,
        Config $routes,
        array  $generateParams,
        string $expected
    )
    {
        $generatedUrl = (new HttpRouter($routerConfig, $routes))->generateUrl(...$generateParams);
        self::assertEquals($expected, $generatedUrl);
    }

    public function generateUrlDataProvider(): array
    {
        return [
            'no_params' => [
                $this->getRouterConfig(),
                $this->getRoutesConfig([
                    'post_comments' => ['/post/comments', 'controller', 'action']
                ]),
                ['post_comments', [], false],
                '/post/comments'
            ],
            'with_params' => [
                $this->getRouterConfig(),
                $this->getRoutesConfig([
                    'post_comments' => ['/post/comments', 'controller', 'action']
                ]),
                ['post_comments', ['id' => 10, 'comment' => 'test'], false],
                '/post/comments?id=10&comment=test'
            ],
            'with_null_params' => [
                $this->getRouterConfig(),
                $this->getRoutesConfig([
                    'post_comments' => ['/post/comments', 'controller', 'action']
                ]),
                ['post_comments', ['id' => 10, 'nullparam' => null, 'comment' => 'test'], false],
                '/post/comments?id=10&comment=test'
            ],
            'only_null_params' => [
                $this->getRouterConfig(),
                $this->getRoutesConfig([
                    'post_comments' => ['/post/comments', 'controller', 'action']
                ]),
                ['post_comments', ['nullparam' => null], false],
                '/post/comments'
            ],
            'with_params_absolute' => [
                $this->getRouterConfig(),
                $this->getRoutesConfig([
                    'post_comments' => ['/post/comments', 'controller', 'action']
                ]),
                ['post_comments', ['id' => 10, 'comment' => 'test'], true],
                'http://localhost/post/comments?id=10&comment=test'
            ]
        ];
    }

    public function testNoRouteFound()
    {
        $this->expectExceptionMessage('There no such route with name: test!');

        (new HttpRouter(self::getRouterConfig(), self::getRoutesConfig([
            'index' => ['/', 'controller', 'action']
        ]),))->generateUrl('test');
    }
}