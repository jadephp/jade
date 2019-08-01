<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade\HttpKernel\Event;

use Psr\Http\Message\ServerRequestInterface;
use Jade\HttpKernel\HttpKernel;
use Symfony\Contracts\EventDispatcher\Event;

class KernelEvent extends Event
{
    protected $kernel;
    protected $request;

    public function __construct(HttpKernel $kernel, ServerRequestInterface $request)
    {
        $this->kernel = $kernel;
        $this->request = $request;
    }

    /**
     * 返回 http kernel
     *
     * @return HttpKernel
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * 返回当前正在处理中的请求
     *
     * @return ServerRequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }
}