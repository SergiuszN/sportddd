<?php

namespace Ddd\Tests\Framework\Http\Request;

use Ddd\Framework\Http\Request\HttpRequest;
use PHPUnit\Framework\TestCase;

class HttpRequestTest extends TestCase
{
    public function testReadFromGetPostAndServer()
    {
        $_GET['getTest'] = 'value';
        $_POST['postTest'] = 'value';
        $_SERVER['serverTest'] = 'value';
        $request = HttpRequest::getInstance();

        self::assertInstanceOf(HttpRequest::class, $request);
        self::assertEquals('value', $request->get('getTest'));
        self::assertEquals('value', $request->post('postTest'));
        self::assertEquals('value', $request->server('serverTest'));

        self::assertEquals(null, $request->get('postTest'));
        self::assertEquals(1, $request->post('serverTest', 1));
        self::assertEquals(123, $request->server('getTest', 123));
    }

    public function testUsingConstructorThrowsError()
    {
        $this->expectExceptionMessage('Do not use directly constructor of that class. Use Ddd\Framework\Http\Request\HttpRequest::getInstance() instead of new()');
        new HttpRequest();
    }

    public function testUsingConstructorAfterInstanceThrowsError()
    {
        HttpRequest::getInstance();
        $this->expectExceptionMessage('Do not use directly constructor of that class. Use Ddd\Framework\Http\Request\HttpRequest::getInstance() instead of new()');
        new HttpRequest();
    }
}