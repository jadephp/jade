<?php

/*
 * This file is part of the shein/framework package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shein\HttpKernel;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shein\HttpKernel\Event\FilterControllerEvent;
use Shein\HttpKernel\Event\FilterResponseEvent;
use Shein\HttpKernel\Event\GetResponseEvent;
use Shein\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zend\HttpHandlerRunner\Emitter\EmitterInterface;
use Zend\Stratigility\MiddlewarePipeInterface;

final class HttpKernel implements RequestHandlerInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var MiddlewarePipeInterface
     */
    protected $pipeline;

    /**
     * @var ControllerResolverInterface
     */
    protected $controllerResolver;

    /**
     * @var ArgumentResolverInterface
     */
    protected $argumentResolver;

    /**
     * @var EmitterInterface
     */
    protected $emitter;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        ControllerResolverInterface $controllerResolver,
        ArgumentResolverInterface $argumentResolver,
        MiddlewarePipeInterface $pipeline,
        EmitterInterface $emitter
    ){
        $this->eventDispatcher = $eventDispatcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
        $this->pipeline = $pipeline;
        $this->emitter = $emitter;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // 1. 触发事件
        $event = new GetResponseEvent($this, $request);
        $this->eventDispatcher->dispatch($event, KernelEvents::REQUEST);
        // 2. 调度middleware
        return $this->pipeline->process($event->getRequest(), new CallableRequestHandler([$this, 'handleRequest']));
    }

    /**
     * Emit response.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
    public function terminate(ServerRequestInterface $request, ResponseInterface $response)
    {
        $event = new PostResponseEvent($this, $request, $response);
        $this->eventDispatcher->dispatch($event, KernelEvents::TERMINATE);

        $this->emitter->emit($response);
    }

    /**
     * 处理请求
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handleRequest(ServerRequestInterface $request): ?ResponseInterface
    {
        // 1. middleware 到达结束
        $event = new GetResponseEvent($this, $request);
        $this->eventDispatcher->dispatch($event, KernelEvents::MIDDLEWARE);
        $request = $event->getRequest();

        if ($event->hasResponse()) {
            return $this->filterResponse($event->getResponse(), $request);
        }

        // 2. 获取控制器
        $controller = $this->controllerResolver->getController($request);
        $event = new FilterControllerEvent($this, $request, $controller);
        $this->eventDispatcher->dispatch($event, KernelEvents::CONTROLLER);

        $controller = $event->getController();
        $response = call_user_func_array($controller,
            $this->argumentResolver->getArguments($request, $controller)
        );

        // 3. 过滤响应体
        return $this->filterResponse($response, $request);
    }

    protected function filterResponse(ResponseInterface $response, ServerRequestInterface $request)
    {
        $event = new FilterResponseEvent($this, $request, $response);
        $this->eventDispatcher->dispatch($event, KernelEvents::RESPONSE);
        return $event->getResponse();
    }
}