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

trait RouteBuilderTrait
{
    /**
     * 获取路由集合
     *
     * @return Collection
     */
    abstract public function getRoutes();

    /**
     * 创建一条 http get 路由
     *
     * @param string $path
     * @param string|callable $action
     * @return Route
     */
    public function get($path, $action)
    {
        return $this->http($path, $action, 'GET');
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
        return $this->http($path, $action, 'POST');
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
        return $this->http($path, $action, 'DELETE');
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
        return $this->http($path, $action, ['PUT', 'PATCH']);
    }

    /**
     * 创建一条 http 请求路由
     *
     * @param string $path
     * @param string|callable $action
     * @param array|string $methods
     * @return Route
     */
    public function http($path, $action, $methods = [])
    {
        $methods = array_map('strtoupper', (array)$methods);
        $route = new Route(null, $path, $action, $methods);
        $this->getRoutes()->add($route);
        return $route;
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
        return $this->http($path, $action, 'OPTIONS');
    }
}