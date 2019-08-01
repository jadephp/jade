<?php

namespace Jade\Tests\Middleware;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Jade\Middleware\RouteMiddleware;
use Jade\Routing\Route;
use Zend\Diactoros\Response\TextResponse;
use Zend\Diactoros\ServerRequest;
use Zend\Stratigility\Exception\EmptyPipelineException;
use Zend\Stratigility\MiddlewarePipe;

class FooMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new TextResponse('foo_middleware');
    }
}

class RouteMiddlewareTest extends TestCase
{
    public function testExecute()
    {
        $pipeline = new MiddlewarePipe();

        $route = new Route('route1', '/foo', function(){}, ['GET']);
        $pipeline->pipe(new RouteMiddleware($route, new FooMiddleware()));

        $request = new ServerRequest();
        $response = $pipeline->handle($request->withAttribute('_route', $route));
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('foo_middleware', (string)$response->getBody());
    }

    public function testExecuteNotMatched()
    {
        $pipeline = new MiddlewarePipe();

        $route = new Route('route1', '/foo', function(){}, ['GET']);
        $pipeline->pipe(new RouteMiddleware($route, new FooMiddleware()));

        // 不匹配的情况
        $request = new ServerRequest();
        $this->expectException(EmptyPipelineException::class);
        $pipeline->handle($request);
    }
}