<?php

/*
 * This file is part of the Cube package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade;

use Psr\Container\ContainerInterface as PsrContainerInterface;

interface ContainerInterface extends PsrContainerInterface
{
    /**
     * 批量添加服务/参数
     *
     * @param array $values
     */
    public function add(array $values);

    /**
     * 批量合并参数
     *
     * @param array $values
     */
    public function merge(array $values);
}