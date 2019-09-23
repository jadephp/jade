<?php

namespace Jade\Tests\Routing;

use PHPUnit\Framework\TestCase;
use Jade\Routing\RouteCollection;
use Jade\Routing\Route;

class RouteCollectionTest extends TestCase
{
    public function testConstructor()
    {
        $routes = new RouteCollection();
        $this->assertCount(0, $routes);
        $this->assertInstanceOf(\Traversable::class, $routes);
    }
    public function testAdd()
    {
        $routes = new RouteCollection();
        $routes->add(new Route('route1', '/foo', function(){
        }, ['GET']));
        $this->assertCount(1, $routes);

        $routes->add(new Route('route2', '/foo', function(){
        }, ['GET']));

        $this->assertCount(2, $routes);
    }

    public function testAddSameNameRoute()
    {
        $routes = new RouteCollection();
        $routes->add(new Route('route1', '/foo', function(){
        }, ['GET']));
        $this->assertCount(1, $routes);
        // 加同名路由会覆盖
        $routes->add(new Route('route1', '/foo', function(){
        }, ['GET']));
        $this->assertCount(1, $routes);
    }

    public function testSearch()
    {
        $routes = new RouteCollection();
        $route = new Route('route1', '/foo', function(){
        }, ['GET']);
        $routes->add($route);
        $this->assertSame($route, $routes->search('route1'));
    }

    public function testMerge()
    {
        $routes = new RouteCollection();
        $route = new Route('route1', '/foo', function(){
        }, ['GET']);
        $routes->add($route);

        $routes2 = new RouteCollection();
        $route2 = new Route('route2', '/foo', function(){
        }, ['GET']);
        $routes2->add($route2);

        $routes->merge($routes2);
        $this->assertCount(2, $routes);
    }
}