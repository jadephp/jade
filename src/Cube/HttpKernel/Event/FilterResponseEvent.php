<?php

/*
 * This file is part of the shein/framework package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shein\HttpKernel\Event;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Shein\HttpKernel\HttpKernel;

/**
 * 允许动态修改内核周期结束之后产生的response
 */
class FilterResponseEvent extends KernelEvent
{
    protected $response;

    public function __construct(HttpKernel $kernel, ServerRequestInterface $request, ResponseInterface $response)
    {
        parent::__construct($kernel, $request);
        $this->response = $response;
    }

    /**
     * 返回当前处理得到的response
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * 设置一个新的response对象来替换
     *
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }
}