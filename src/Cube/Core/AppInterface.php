<?php

/*
 * This file is part of the Cube package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cube\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface AppInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return boolean
     */
    public function isEnabled();

    /**
     * @param callable $routesFactory
     */
    public function setRoutesFactory(callable $routesFactory);

    /**
     * app 启动
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function start(ServerRequestInterface $request);
}