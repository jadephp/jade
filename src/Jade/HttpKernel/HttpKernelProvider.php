<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade\HttpKernel;

use Jade\ContainerInterface;
use Jade\EventProviderInterface;
use Jade\Routing\Router;
use Jade\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\HttpHandlerRunner\Emitter\SapiStreamEmitter;

class HttpKernelProvider implements ServiceProviderInterface, EventProviderInterface
{
    public function register(ContainerInterface $container)
    {
        $container->add($this->getDefaults());
        // 路由控制
        $container['router'] = function($c){
            return new Router($c['route_collector']->getRoutes());
        };
        $container['router_listener'] = function($c){
            return new RouterListener($c['router']);
        };
        // http kernel
        $container['controller_resolver'] = function($c){
            return new $c['http_kernel.controller_resolver_class']($c);
        };
        $container['argument_resolver'] = function($c){
            return new $c['http_kernel.argument_resolver_class'];
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

    protected function getDefaults()
    {
        return [
            'http_kernel.controller_resolver_class' => ControllerResolver::class,
            'http_kernel.argument_resolver_class' => ArgumentResolver::class
        ];
    }

    public function subscribe(EventDispatcherInterface $eventDispatcher, ContainerInterface $container)
    {
        $eventDispatcher->addSubscriber($container['router_listener']);
    }
}