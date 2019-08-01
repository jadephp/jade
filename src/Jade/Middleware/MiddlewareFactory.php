<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Zend\Stratigility\Middleware\CallableMiddlewareDecorator;

final class MiddlewareFactory
{
    /**
     * 创建middleware
     *
     * @param MiddlewareInterface|string|callable $middleware
     * @return MiddlewareInterface
     */
    public function create($middleware)
    {
        // middleware 实例直接返回
        if ($middleware instanceof MiddlewareInterface) {
            return $middleware;
        }
        // middleware 类
        if (is_subclass_of($middleware, MiddlewareInterface::class)) {
            return new $middleware;
        }
        if (is_callable($middleware)) {
            return new CallableMiddlewareDecorator($middleware);
        }
        throw new \InvalidArgumentException('Invalid middleware format');
    }
}