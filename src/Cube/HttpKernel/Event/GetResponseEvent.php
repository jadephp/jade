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

final class GetResponseEvent extends KernelEvent
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * 设置正在处理的请求，由于psr7 request 不可修改特性
     * 但凡对原request修改都要重新写回新的对象
     *
     * @param ServerRequestInterface $request
     */
    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    /**
     * 设置响应体
     *
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * 获取请求
     *
     * @return ResponseInterface
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }


    /**
     * 检查 response 是否存在
     *
     * @return bool
     */
    public function hasResponse()
    {
        return null !== $this->response;
    }
}