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

use Psr\Http\Message\ServerRequestInterface;

interface ControllerResolverInterface
{
    /**
     * 控制器资源标识结构
     *
     * 例如：
     *
     * ```
     * PostController::indexAction
     * ```
     *
     * @param ServerRequestInterface $request
     * @return callable 返回一个合理有效的php可执行结构
     * @throws \RuntimeException
     */
    public function getController(ServerRequestInterface $request);
}