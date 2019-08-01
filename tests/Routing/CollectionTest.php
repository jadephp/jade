<?php

namespace Shein\Tests\Routing;

use PHPUnit\Framework\TestCase;
use Shein\Routing\Collection;
use Shein\Routing\Route;

class CollectionTest extends TestCase
{
    public function testConstructor()
    {
        $routes = new Collection();
        $this->assertCount(0, $routes);
        $this->assertInstanceOf(\Traversable::class, $routes);
    }
    public function testAdd()
    {
        $routes = new Collection();
        $routes->add(new Route('route1', '/foo', function(){
        }, ['GET']));
        $this->assertCount(1, $routes);

        $routes->add(new Route('route2', '/foo', function(){
        }, ['GET']));

        $this->assertCount(2, $routes);
    }

    public function testAddSameNameRoute()
    {
        $routes = new Collection();
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
        $routes = new Collection();
        $route = new Route('route1', '/foo', function(){
        }, ['GET']);
        $routes->add($route);
        $this->assertSame($route, $routes->search('route1'));
    }

    public function testMerge()
    {
        $routes = new Collection();
        $route = new Route('route1', '/foo', function(){
        }, ['GET']);
        $routes->add($route);

        $routes2 = new Collection();
        $route2 = new Route('route2', '/foo', function(){
        }, ['GET']);
        $routes2->add($route2);

        $routes->merge($routes2);
        $this->assertCount(2, $routes);
    }
}