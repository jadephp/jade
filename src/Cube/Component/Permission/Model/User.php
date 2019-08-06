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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class User implements UserInterface
{
    /**
     * @var RoleInterface[]|Collection
     */
    protected $authorizedRoles;

    public function __construct()
    {
        $this->authorizedRoles = new ArrayCollection();
    }

    /**
     * 给予授权角色
     *
     * @param RoleInterface $role
     */
    public function giveAuthorizedRole(RoleInterface $role)
    {
        $this->authorizedRoles[] = $role;
    }

    /**
     * 取消授权角色
     *
     * @param RoleInterface $role
     */
    public function revokeAuthorizedRole(RoleInterface $role)
    {
        $this->authorizedRoles->removeElement($role);
    }

    /**
     * 是否有角色
     *
     * @param RoleInterface $role
     * @return bool
     */
    public function hasAuthorizedRole(RoleInterface $role)
    {
        return $this->authorizedRoles->contains($role);
    }

    /**
     * 移除角色
     *
     * @param RoleInterface $role
     */
    public function removeAuthorizedRole(RoleInterface $role)
    {
        $this->authorizedRoles->remove($role);
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorizedRoles()
    {
        return $this->authorizedRoles;
    }

    /**
     * 是否有权限
     *
     * @param PermissionInterface $permission
     * @return boolean
     */
    public function hasPermission(PermissionInterface $permission)
    {
        foreach ($this->getAuthorizedRoles() as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }
}