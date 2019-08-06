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

interface RoleInterface
{
    /**
     * 角色名称
     *
     * @return string
     */
    public function getRole();

    /**
     * 获取权限
     *
     * @return PermissionInterface[]
     */
    public function getPermissions();

    /**
     * 获取角色对应用户
     *
     * @return UserInterface[]|Collection
     */
    public function getUsers();

    /**
     * 赋予权限
     *
     * @param PermissionInterface $permission
     * @return self
     */
    public function givePermission(PermissionInterface $permission);

    /**
     * 取消授权
     *
     * @param PermissionInterface $permission
     * @return self
     */
    public function revokePermission(PermissionInterface $permission);

    /**
     * 是否有权限
     *
     * @param PermissionInterface $permission
     * @return boolean
     */
    public function hasPermission(PermissionInterface $permission);
}