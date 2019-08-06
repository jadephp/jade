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

class Role implements RoleInterface
{
    /**
     * @var string
     */
    protected $role;

    /**
     * @var PermissionInterface|Collection
     */
    protected $permissions;

    /**
     * @var UserInterface[]|Collection
     */
    protected $users;

    public function __construct()
    {
        $this->permissions = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * {@inheritdoc}
     */
    public function setRole(string $role): RoleInterface
    {
        $this->role = $role;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * {@inheritdoc}
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function givePermission(PermissionInterface $permission)
    {
        $this->permissions[] = $permission;
    }

    /**
     * {@inheritdoc}
     */
    public function revokePermission(PermissionInterface $permission)
    {
        $this->permissions->removeElement($permission);
    }

    /**
     * 是否有权限
     *
     * @param PermissionInterface $permission
     * @return bool
     */
    public function hasPermission(PermissionInterface $permission)
    {
        return $this->permissions->contains($permission);
    }
}