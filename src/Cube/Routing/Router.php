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

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use FastRoute\RouteParser;
use FastRoute\RouteParser\Std as StdParser;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    /**
     * @var Collection|Route[]
     */
    protected $routes;

    /**
     * @var
     */
    protected $routeParser;

    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * 缓存路由文件，默认不缓存
     *
     * @var string|False
     */
    protected $cacheFile = false;

    public function __construct(Collection $routes, RouteParser $parser = null)
    {
        $this->routes = $routes;
        $this->routeParser = $parser ?: new StdParser();
    }

    /**
     * 设置路由集合
     *
     * @param Collection $routes
     */
    public function setRoutes($routes): void
    {
        $this->routes = $routes;
    }

    /**
     * 返回路由集合
     *
     * @return Collection
     */
    public function getRoutes(): Collection
    {
        return $this->routes;
    }

    /**
     * 搜索路由
     *
     * @param string $name
     * @return Route
     */
    public function searchRoute($name)
    {
        return $this->routes->search($name);
    }

    /**
     * 调度请求
     *
     * @param ServerRequestInterface $request
     * @return array
     */
    public function dispatch(ServerRequestInterface $request)
    {
        $uri = '/' . ltrim($request->getUri()->getPath(), '/');
        return $this->getDispatcher()->dispatch(
            $request->getMethod(),
            $uri
        );
    }

    /**
     * 设置自定义路由调度器
     *
     * @param Dispatcher $dispatcher
     */
    public function setDispatcher(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * 获取路由调度器
     *
     * @return Dispatcher
     */
    public function getDispatcher()
    {
        if ($this->dispatcher) {
            return $this->dispatcher;
        }
        return $this->dispatcher = $this->createDispatcher();
    }

    /**
     * 设置路由缓存文件，为空表示禁用路由缓存
     *
     * @param string|false $cacheFile
     *
     * @return static
     *
     * @throws \InvalidArgumentException If cacheFile is not a string or not false
     * @throws \RuntimeException         If cacheFile directory is not writable
     */
    public function setCacheFile($cacheFile)
    {
        if (!is_string($cacheFile) && $cacheFile !== false) {
            throw new \InvalidArgumentException('Router cache file must be a string or false');
        }
        if ($cacheFile && file_exists($cacheFile) && !is_readable($cacheFile)) {
            throw new \RuntimeException(
                sprintf('Router cache file `%s` is not readable', $cacheFile)
            );
        }
        if ($cacheFile && !file_exists($cacheFile) && !is_writable(dirname($cacheFile))) {
            throw new \RuntimeException(
                sprintf('Router cache file directory `%s` is not writable', dirname($cacheFile))
            );
        }
        $this->cacheFile = $cacheFile;
        return $this;
    }

    /**
     * 创建路由调度
     *
     * @return Dispatcher
     */
    protected function createDispatcher()
    {
        $routeDefinitionCallback = function (RouteCollector $r) {
            foreach ($this->routes as $route) {
                $r->addRoute($route->getMethods(), $route->getPattern(), $route->getName());
            }
        };
        if ($this->cacheFile) {
            $dispatcher = \FastRoute\cachedDispatcher($routeDefinitionCallback, [
                'routeParser' => $this->routeParser,
                'cacheFile' => $this->cacheFile,
            ]);
        } else {
            $dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback, [
                'routeParser' => $this->routeParser,
            ]);
        }
        return $dispatcher;
    }
}