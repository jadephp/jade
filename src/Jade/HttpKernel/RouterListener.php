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

use FastRoute\Dispatcher;
use Jade\Exception\HttpException;
use Jade\Exception\MethodNotAllowedHttpException;
use Jade\Exception\NotFoundHttpException;
use Jade\HttpKernel\Event\GetResponseEvent;
use Jade\Routing\Route;
use Jade\Routing\Router;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RouterListener implements EventSubscriberInterface
{
    /**
     * @var Router
     */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::MIDDLEWARE => 'onRequest'
        ];
    }

    public function onRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $matches = $this->router->dispatch($request);
        switch ($matches[0]) {
            case Dispatcher::FOUND:
                $route = $this->router->searchRoute($matches[1]);
                $this->prepareRoute($route, $matches);
                // 记录当前路由到指定请求体里
                $request = $request->withAttribute('_route', $route);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $message = sprintf('No route found for "%s %s": Method Not Allowed (Allow: %s)',
                    $request->getMethod(), $request->getUri()->getPath(),
                    implode(',', $matches[1])
                );
                throw new MethodNotAllowedHttpException($message);
            case Dispatcher::NOT_FOUND:
                $message = sprintf('No route found for "%s %s"', $request->getMethod(), $request->getUri()->getPath());
                throw new NotFoundHttpException($message);
        }
        $event->setRequest($request);
    }

    /**
     * 预处理 route
     *
     * @param Route $route
     * @param array $matches
     */
    protected function prepareRoute(Route $route, $matches)
    {
        $routeArguments = [];
        foreach ($matches[2] as $k => $v) {
            $routeArguments[$k] = urldecode($v);
        }
        $route->setArguments($routeArguments);
    }
}