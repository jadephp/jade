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

interface ArgumentResolverInterface
{
    /**
     * 获取 controller 的参数
     * @param ServerRequestInterface $request
     * @param callable $controller
     * @return array
     */
    public function getArguments(ServerRequestInterface $request, callable  $controller);
}