<?php

/*
 * This file is part of the shein/framework package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shein\Routing;

final class Collection implements \Countable, \IteratorAggregate
{
    /**
     * 路由集合
     * @var Route[]
     */
    protected $routes = [];

    /**
     * 路由计数
     *
     * @var int
     */
    protected $counter = 0;

    public function __construct($routes = [])
    {
        foreach ($routes as $route) {
            $this->add($route);
        }
    }

    /**
     * 添加一条 route
     *
     * @param Route $route
     */
    public function add(Route $route)
    {
        if (null === $route->getName()) { //路由名称为空则给予默认名称
            $route->setName($this->counter ++);
        }
        $this->routes[$route->getName()] = $route;
    }

    /**
     * 查找 route
     *
     * @param string $name
     * @return Route|null
     */
    public function search($name)
    {
        return $this->routes[$name] ?? null;
    }

    /**
     * 合并 route 集合
     *
     * @param Collection $collection
     */
    public function merge(Collection $collection)
    {
        foreach ($collection as $route) {
            $this->add($route);
        }
    }

    /**
     * 获取集合内路由总数
     *
     * @return int
     */
    public function count()
    {
        return count($this->routes);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->routes);
    }
}