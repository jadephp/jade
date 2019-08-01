<?php

/*
 * This file is part of the shein/framework package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shein;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

interface EventProviderInterface
{
    /**
     * 注册一组事件
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param Container $container
     */
    public function subscribe(EventDispatcherInterface $eventDispatcher, Container $container);
}