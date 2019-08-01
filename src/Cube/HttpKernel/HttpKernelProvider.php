<?php

/*
 * This file is part of the shein/framework package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shein\HttpKernel;

use Shein\Container;
use Shein\EventProviderInterface;
use Shein\Routing\Router;
use Shein\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\HttpHandlerRunner\Emitter\SapiStreamEmitter;

class HttpKernelProvider implements ServiceProviderInterface, EventProviderInterface
{
    public function register(Container $container)
    {
        // 路由控制
        $container['router'] = function($c){
            return new Router($c['app']->getRoutes());
        };
        $container['router_listener'] = function($c){
            return new RouterListener($c['router']);
        };
        // http kernel
        $container['controller_resolver'] = function($c){
            return new ControllerResolver();
        };
        $container['argument_resolver'] = function(){
            return new ArgumentResolver();
        };
        // http response emitter
        $container['http_emitter'] = function(){
            return new EmitterDecorator(
                new SapiEmitter(),
                new SapiStreamEmitter()
            );
        };
        $container['http_kernel'] = function($c){
            return new HttpKernel(
                $c['event_dispatcher'],
                $c['controller_resolver'],
                $c['argument_resolver'],
                $c['middleware_pipeline'],
                $c['http_emitter']
            );
        };
    }

    public function subscribe(EventDispatcherInterface $eventDispatcher, Container $container)
    {
        $eventDispatcher->addSubscriber($container['router_listener']);
    }
}