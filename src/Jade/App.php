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

use Jade\Routing\RouteCollector;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Jade\HttpKernel\HttpKernelProvider;
use Jade\Routing\RouteCollection as RouteCollection;
use Jade\Routing\Route;
use Jade\Middleware\RouteMiddleware;
use Zend\Diactoros\ServerRequestFactory;

class App extends RouteCollector implements RequestHandlerInterface
{
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
        parent::__construct();
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
    public function handle(ServerRequestInterface $request): ResponseInterface
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
     * @param object $provider
     * @param array $values
     */
    public function register($provider, array $values = [])
    {
        // 注册服务
        if ($provider instanceof ServiceProviderInterface) {
            $provider->register($this->container);
        }
        // 注册事件
        if ($provider instanceof EventProviderInterface) {
            $provider->subscribe($this->container->get('event_dispatcher'), $this->container);
        }
        $this->container->merge($values);
        $this->providers[] = $provider;
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