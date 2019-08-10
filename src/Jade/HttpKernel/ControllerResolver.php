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

use Jade\ContainerAwareInterface;
use Jade\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class ControllerResolver implements ControllerResolverInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getController(ServerRequestInterface $request)
    {
        $route = $request->getAttribute('_route');
        if (null === $route) { //如果没有route则直接中断
            throw new \RuntimeException(sprintf('Cannot find route'));
        }
        $action = $route->getAction();
        if ($action instanceof \Closure) { // 如果是可调用的结构直接返回
            return $action;
        }
        return $this->createController($action);
    }

    /**
     * 创建控制器
     *
     * @param string|array $controller
     * @return array
     */
    protected function createController($controller)
    {
        list($class, $method) = is_string($controller) ? explode('::', $controller) : $controller;

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
        }
        return [$this->configureController($this->instantiateController($class)), $method];
    }

    /**
     * 创建控制器实例
     *
     * @param string $class A class name
     *
     * @return object
     */
    protected function instantiateController($class)
    {
        return new $class();
    }

    protected function configureController($controller)
    {
        if ($controller instanceof ContainerAwareInterface) {
            $controller->setContainer($this->container);
        }
        return $controller;
    }
}