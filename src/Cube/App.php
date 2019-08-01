<?php

/*
 * This file is part of the shein/framework package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shein;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shein\HttpKernel\HttpKernelProvider;
use Shein\Routing\Collection as RouteCollection;
use Shein\Routing\Route;
use Shein\Routing\RouteBuilderTrait;
use Shein\Middleware\RouteMiddleware;
use Zend\Diactoros\ServerRequestFactory;

class App implements RequestHandlerInterface
{
    use RouteBuilderTrait;

    /**
     * 是否已经初始化
     *
     * @var bool
     */
    protected $booted = false;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RouteCollection
     */
    protected $routes;

    /**
     * @var array
     */
    protected $providers;

    public function __construct(ContainerInterface $container = null)
    {
        if (null === $container) {
            $container = new Container();
        }
        // 注册核心服务
        $this->container = $container;
        $this->container['app'] = $this;
        $this->register(new CoreServiceProvider());
        $this->routes = new RouteCollection();
    }

    /**
     * 初始化启动工作
     */
    public function boot()
    {
        if ($this->booted) {
            return;
        }
        $this->booted = true;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request): ResponseInterface
    {
        // 启动应用
        $this->boot();
        $this->register(new HttpKernelProvider());
        // 请求转交给 http kernel
        return $this->container->get('http_kernel')->handle($request);
    }

    /**
     * 代理http kernel
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
    public function terminate(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->container->get('http_kernel')->terminate($request, $response);
    }

    /**
     * 开启服务, 监听请求
     */
    public function serve()
    {
        // 1. 创建请求
        $request = ServerRequestFactory::fromGlobals();
        // 2. 处理请求
        $response = $this->handle($request);
        // 3. 输出响应
        $this->terminate($request, $response);
    }

    /**
     * 注册服务提供者
     *
     * @param ServiceProviderInterface|EventProviderInterface|CommandProviderInterface $provider
     */
    public function register($provider)
    {
        // 注册服务
        if ($provider instanceof ServiceProviderInterface) {
            $provider->register($this->container);
        }
        // 注册事件
        if ($provider instanceof EventProviderInterface) {
            $provider->subscribe($this->container->get('event_dispatcher'), $this->container);
        }
        $this->providers[] = $provider;
    }

    /**
     * 返回该应用对应的路由集合
     *
     * @return RouteCollection
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * 获取服务容器
     *
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * 添加一个 middleware
     *
     * @param string|MiddlewareInterface|callable $middleware
     * @param Route|null $route 绑定的路由
     */
    public function pipe($middleware, Route $route = null)
    {
        $middleware = $this->container->get('middleware_factory')->create($middleware);
        if (null !== $route) {
            $middleware = new RouteMiddleware($route, $middleware);
        }
        $this->container->get('middleware_pipeline')->pipe(
            $middleware
        );
    }

    /**
     * 返回全部的 provider
     *
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }
}