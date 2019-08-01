<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade;

use Jade\Middleware\MiddlewareFactory;
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Zend\Stratigility\MiddlewarePipe;

class CoreServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container)
    {
        // 事件管理
        $container['event_dispatcher'] = function(){
            return new EventDispatcher();
        };
        // middleware 控制
        $container['middleware_pipeline'] = function(){
            return new MiddlewarePipe();
        };
        // middleware 控制
        $container['middleware_factory'] = function(){
            return new MiddlewareFactory();
        };
    }
}