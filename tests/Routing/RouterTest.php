<?php

namespace Jade\Tests\Routing;

use FastRoute\Dispatcher;
use PHPUnit\Framework\TestCase;
use Jade\Routing\RouteCollection;
use Jade\Routing\Route;
use Jade\Routing\Router;
use Zend\Diactoros\ServerRequest;

class RouterTest extends TestCase
{
    public function testRoutes()
    {
        $routes = new RouteCollection();
        $router = new Router($routes);
        $this->assertSame($routes, $router->getRoutes());
    }

    public function testSearchRoute()
    {
        $routes = new RouteCollection();
        $router = new Router($routes);
        $route = new Route('route1', '/foo', function(){}, ['GET']);
        $routes->add($route);
        $this->assertSame($routes->search('route1'), $router->searchRoute('route1'));
    }

    public function testDispatcher()
    {
        $routes = new RouteCollection();
        $router = new Router($routes);
        $this->assertInstanceOf(Dispatcher::class, $router->getDispatcher());
    }

    protected function routerFactory()
    {
        $routes = new RouteCollection();
        $route = new Route('route1', '/foo', function(){}, ['GET']);
        $route2 = new Route('route2', '/hello/{username}', function(){}, ['GET']);
        $route3 = new Route('route3', '/greet/{username}', function(){}, ['POST']);
        $routes->add($route);
        $routes->add($route2);
        $routes->add($route3);
       return new Router($routes);
    }

    public function testDispatch()
    {
        $router = $this->routerFactory();
        $request = new ServerRequest([], [], '/foo', 'GET');

        $routerInfo = $router->dispatch($request);
        $this->assertEquals(1, $routerInfo[0]);
    }

    public function testDispatchWithName()
    {
        $router = $this->routerFactory();
        $request = new ServerRequest([], [], '/hello/Jade', 'GET');

        $routerInfo = $router->dispatch($request);
        $this->assertEquals(1, $routerInfo[0]);
        $this->assertArrayHasKey('username', $routerInfo[2]);
        $this->assertEquals('Jade', $routerInfo[2]['username']);
    }

    public function testDispatchWithNonMatchedMethod()
    {
        $router = $this->routerFactory();
        $request = new ServerRequest([], [], '/greet/Jade', 'GET');

        $routerInfo = $router->dispatch($request);
        $this->assertEquals(2, $routerInfo[0]);
        $this->assertEquals(['POST'], $routerInfo[1]);
    }
    // 其它类型调度 fastroute 已经测试通过
}