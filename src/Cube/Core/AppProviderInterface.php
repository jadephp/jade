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

interface AppProviderInterface
{
    /**
     * @return AppInterface[]|\Generator
     */
    public function getApps();
}