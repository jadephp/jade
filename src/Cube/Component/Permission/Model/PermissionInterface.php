<?php

/*
 * This file is part of the CubeCloud/Client package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cube\Component\Permission\Model;

use Doctrine\Common\Collections\Collection;

interface PermissionInterface
{
    /**
     * 获取权限名称
     *
     * @return string
     */
    public function getPermission();

    /**
     * 获取所属的角色
     *
     * @return RoleInterface[]|Collection
     */
    public function getRoles();
}