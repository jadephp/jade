<?php

/*
 * This file is part of the Cube package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cube\Base;

use Cube\Cube;
use Jade\ServiceProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface AppInterface extends ServiceProviderInterface
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
     * @return callable|null
     */
    public function getRoutesFactory();

    /**
     * @return array|null
     */
    public function getEntityMapping();

    /**
     * @param Cube $cube
     */
    public function initialize(Cube $cube);

    /**
     * app 启动
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function start(ServerRequestInterface $request);
}