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

interface UserInterface
{
    /**
     * 获取角色
     *
     * @return RoleInterface[]
     */
    public function getAuthorizedRoles();

    /**
     * 授权角色
     *
     * @param RoleInterface $role
     */
    public function giveAuthorizedRole(RoleInterface $role);

    /**
     * 取消角色授权
     *
     * @param RoleInterface $role
     */
    public function removeAuthorizedRole(RoleInterface $role);

    /**
     * 是否有角色
     *
     * @param RoleInterface $role
     * @return boolean
     */
    public function hasAuthorizedRole(RoleInterface $role);

    /**
     * 是否有权限
     *
     * @param PermissionInterface $permission
     * @return boolean
     */
    public function hasPermission(PermissionInterface $permission);
}