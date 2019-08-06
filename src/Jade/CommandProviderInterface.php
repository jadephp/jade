<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade;

use Jade\Console\Application;
use Psr\Container\ContainerInterface;

interface CommandProviderInterface
{
    /**
     * 注册命令
     *
     * @param Application $app
     * @param ContainerInterface $container
     */
    public function provide(Application $app, ContainerInterface $container);
}