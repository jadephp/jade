<?php

namespace Shein\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Shein\App;
use Shein\Middleware\MiddlewareFactory;
use Shein\Routing\Collection;
use Shein\Routing\Route;
use Shein\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zend\Stratigility\MiddlewarePipeInterface;

class AppTest extends TestCase
{

    public function testRoutes()
    {
        $app = new App();
        $this->assertInstanceOf(Collection::class, $app->getRoutes());
    }

    public function testGetRoute()
    {
        $path = '/foo';
        $callable = function ($req, $res) {
            // Do something
        };
        $app = new App();
        $route = $app->get($path, $callable);

        $this->assertInstanceOf(Route::class, $route);
        $this->assertAttributeContains('GET', 'methods', $route);
    }

    public function testPostRoute()
    {
        $path = '/foo';
        $callable = function ($req, $res) {
            // Do something
        };
        $app = new App();
        $route = $app->post($path, $callable);

        $this->assertInstanceOf(Route::class, $route);
        $this->assertAttributeContains('POST', 'methods', $route);
    }

    public function testPutRoute()
    {
        $path = '/foo';
        $callable = function ($req, $res) {
            // Do something
        };
        $app = new App();
        $route = $app->put($path, $callable);

        $this->assertInstanceOf(Route::class, $route);
        $this->assertAttributeContains('PUT', 'methods', $route);
        $this->assertAttributeContains('PATCH', 'methods', $route);
    }

    public function testDeleteRoute()
    {
        $path = '/foo';
        $callable = function ($req, $res) {
            // Do something
        };
        $app = new App();
        $route = $app->delete($path, $callable);

        $this->assertInstanceOf(Route::class, $route);
        $this->assertAttributeContains('DELETE', 'methods', $route);
    }

    public function testOptionsRoute()
    {
        $path = '/foo';
        $callable = function ($req, $res) {
            // Do something
        };
        $app = new App();
        $route = $app->options($path, $callable);

        $this->assertInstanceOf(Route::class, $route);
        $this->assertAttributeContains('OPTIONS', 'methods', $route);
    }

    public function testContainer()
    {
        $app = new App();
        $this->assertInstanceOf(ContainerInterface::class, $app->getContainer());
        // 测试core provider
        $this->assertNotEmpty($app->getProviders());
        $this->assertInstanceOf(ServiceProviderInterface::class, $app->getProviders()[0]);
    }

    public function testBaseService()
    {
        $app = new App();
        $container = $app->getContainer();
        $this->assertInstanceOf(EventDispatcherInterface::class, $container->get('event_dispatcher'));
        $this->assertInstanceOf(MiddlewarePipeInterface::class, $container->get('middleware_pipeline'));
        $this->assertInstanceOf(MiddlewareFactory::class, $container->get('middleware_factory'));
    }
}
