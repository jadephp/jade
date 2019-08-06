<?php

/*
 * This file is part of the CubeCloud/Client package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cube\Component\Permission;

use Cube\Component\Permission\Model\PermissionInterface;
use Cube\Component\Permission\Model\RoleInterface;
use Cube\Component\Permission\Model\UserInterface;

interface PermissionManagerInterface
{
    /**
     * 创建一个空角色
     *
     * @return RoleInterface
     */
    public function createRole();

    /**
     * 创建一个空权限
     *
     * @return PermissionInterface
     */
    public function createPermission();

    /**
     * 持久化角色
     *
     * @param RoleInterface $role
     */
    public function saveRole(RoleInterface $role);

    /**
     * 持久化
     * @param PermissionInterface $permission
     */
    public function savePermission(PermissionInterface $permission);

    /**
     * 返回所有role
     *
     * @return RoleInterface[]
     */
    public function findRoles();

    /**
     * 返回所有permission
     *
     * @return PermissionInterface[]
     */
    public function findPermissions();

    /**
     * 根据名称找到权限
     *
     * @param string $name
     * @return PermissionInterface|null
     */
    public function findPermissionByName($name);

    /**
     * 根据名称找到角色
     *
     * @param string $name
     * @return RoleInterface|null
     */
    public function findRoleByName($name);

    /**
     * 判断用户是否有权限做
     *
     * @param UserInterface $user
     * @param string|PermissionInterface $permission
     * @return boolean
     */
    public function hasPermission(UserInterface $user, $permission);

    /**
     * 移除权限
     *
     * @param string|PermissionInterface $permission
     */
    public function removePermission($permission);

    /**
     * 是否有角色
     *
     * @param UserInterface $user
     * @param RoleInterface|string $role
     * @return boolean
     */
    public function hasRole(UserInterface $user, $role);

    /**
     * 是否支持
     *
     * @param string $attribute
     * @param object $subject
     * @return string
     */
    public function support($attribute, $subject);
}