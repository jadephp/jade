<?php

namespace Shein\Tests\Middleware;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shein\Middleware\MiddlewareFactory;

class TestMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // ignore
    }
}

class MiddlewareFactoryTest extends TestCase
{
    public function testCreate()
    {
        $factory = new MiddlewareFactory();
        $this->assertInstanceOf(MiddlewareInterface::class, $factory->create(function(){
            // ignore
        }));

        $middleware= new TestMiddleware();
        $this->assertInstanceOf(MiddlewareInterface::class, $factory->create($middleware));

        $this->assertInstanceOf(MiddlewareInterface::class, $factory->create(TestMiddleware::class));

        $this->expectException(\InvalidArgumentException::class);
        $factory->create('foo');
    }
}