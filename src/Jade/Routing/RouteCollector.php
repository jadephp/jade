<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade\Routing;

class RouteCollector
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var Route[]|RouteCollection
     */
    protected $routes = [];

    public function __construct($prefix = '')
    {
        $this->prefix = $prefix;
        $this->routes = new RouteCollection();
    }

    /**
     * 获取路由集合
     *
     * @return RouteCollection
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * 创建一条 http get 路由
     *
     * @param string $path
     * @param string|callable $action
     * @return Route
     */
    public function get($path, $action)
    {
        return $this->map($path, $action, 'GET');
    }

    /**
     * 创建一条 http post 路由
     *
     * @param string $path
     * @param string|callable $action
     * @return Route
     */
    public function post($path, $action)
    {
        return $this->map($path, $action, 'POST');
    }

    /**
     * 创建一条 http delete 路由
     *
     * @param string $path
     * @param string|callable $action
     * @return Route
     */
    public function delete($path, $action)
    {
        return $this->map($path, $action, 'DELETE');
    }

    /**
     * 创建一条 http put/patch 路由
     *
     * @param string $path
     * @param string|callable $action
     * @return Route
     */
    public function put($path, $action)
    {
        return $this->map($path, $action, ['PUT', 'PATCH']);
    }

    /**
     * 创建一条 http options 路由
     *
     * @param string $path
     * @param string|callable $action
     * @return Route
     */
    public function options($path, $action)
    {
        return $this->map($path, $action, 'OPTIONS');
    }

    /**
     * 创建一条 http 请求路由
     *
     * @param string $path
     * @param string|callable $action
     * @param array|string $methods
     * @return Route
     */
    public function map($path, $action, $methods = [])
    {
        $path = $this->prefix . $path;
        $methods = array_map('strtoupper', (array)$methods);
        $route = new Route(null, $path, $action, $methods);
        $this->getRoutes()->add($route);
        return $route;
    }

    public function any($path, $action)
    {
        return $this->map($path, $action);
    }

    /**
     * 创建一条通用前缀的路由组
     *
     * @param string $prefix
     * @param callable $callback
     */
    public function prefix($prefix, callable $callback)
    {
        $collector = new RouteCollector($prefix);
        call_user_func($callback, $collector);
        $this->routes->merge($collector->getRoutes());
    }
}