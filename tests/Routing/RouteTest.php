<?php

namespace Shein\Tests\Routing;

use PHPUnit\Framework\TestCase;
use Shein\Routing\Route;

class RouteTest extends TestCase
{
    public function routeFactory()
    {
        $methods = ['GET', 'POST'];
        $pattern = '/hello/{name}';
        $callable = function ($req, $res, $args) {
            // Do something
        };

        return new Route('route1', $pattern, $callable, $methods);
    }

    public function testConstructor()
    {
        $methods = ['GET', 'POST'];
        $pattern = '/hello/{name}';
        $callable = function ($req, $res, $args) {
            // Do something
        };
        $route = new Route('', $pattern, $callable, $methods);

        $this->assertAttributeEquals($methods, 'methods', $route);
        $this->assertAttributeEquals($pattern, 'pattern', $route);
        $this->assertAttributeEquals($callable, 'action', $route);
        $this->assertAttributeEquals([], 'arguments', $route);
    }

    public function testGetMethods()
    {
        $this->assertEquals(['GET', 'POST'], $this->routeFactory()->getMethods());
    }

    public function testGetPattern()
    {
        $this->assertEquals('/hello/{name}', $this->routeFactory()->getPattern());
    }

    public function testGetAction()
    {
        $callable = $this->routeFactory()->getAction();

        $this->assertInternalType('callable', $callable);
    }

    public function testGetName()
    {
        $name = $this->routeFactory()->getName();
        $this->assertEquals('route1', $name);
    }
}