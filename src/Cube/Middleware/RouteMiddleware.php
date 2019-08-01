<?php

/*
 * This file is part of the shein/framework package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shein\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shein\Routing\Route;

class RouteMiddleware implements MiddlewareInterface
{
    /**
     * @var Route
     */
    protected $route;

    /**
     * @var MiddlewareInterface
     */
    protected $decorated;

    public function __construct(Route $route, $decoratedMiddleware)
    {
        $this->route = $route;
        $this->decorated = $decoratedMiddleware;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->route === $request->getAttribute('_route')) {
            return $this->decorated->process($request, $handler);
        }
        return $handler->handle($request);
    }
}