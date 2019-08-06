<?php

/*
 * This file is part of the CubeCloud/Client package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cube\Component\Permission\Doctrine;

use Cube\Component\Permission\Exception\PermissionNotFoundException;
use Cube\Component\Permission\Exception\RoleNotFoundException;
use Cube\Component\Permission\Model\PermissionInterface;
use Cube\Component\Permission\Model\RoleInterface;
use Cube\Component\Permission\Model\UserInterface;
use Cube\Component\Permission\PermissionManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PermissionManager implements PermissionManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * 查找所有权限
     *
     * @var PermissionInterface[]
     */
    protected $permissions;

    /**
     * @var RoleInterface[]
     */
    protected $roles;

    /**
     * @var string
     */
    protected $roleClass;

    /**
     * @var string
     */
    protected $permissionClass;

    public function __construct(
        EntityManagerInterface $entityManager,
        $roleClass,
        $permissionClass
    ){
        $this->entityManager = $entityManager;
        $this->roleClass = $roleClass;
        $this->permissionClass = $permissionClass;
    }

    /**
     * {@inheritdoc}
     */
    public function createRole()
    {
        return new $this->roleClass;
    }

    /**
     * {@inheritdoc}
     */
    public function createPermission()
    {
        return new $this->permissionClass;
    }

    /**
     * @param RoleInterface $role
     */
    public function saveRole(RoleInterface $role)
    {
        $this->entityManager->persist($role);
        $this->entityManager->flush();
    }

    /**
     * @param PermissionInterface $permission
     */
    public function savePermission(PermissionInterface $permission)
    {
        $this->entityManager->persist($permission);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function findRoles()
    {
        if ($this->roles) {
            return $this->roles;
        }
        return $this->roles = $this->getRoleRepository()->createQueryBuilder('r')
            ->getQuery()
            ->useResultCache(true, Caches::ROLE_ID, 3600)
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findPermissions()
    {
        if ($this->permissions) {
            return $this->permissions;
        }
        return $this->permissions = $this->getPermissionRepository()->createQueryBuilder('p')
            ->getQuery()
            ->useResultCache(true, Caches::PERMISSION_ID, 3600)
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findPermissionByName($name)
    {
        foreach ($this->findPermissions() as $permission) {
            if ($permission->getPermission() === $name) {
                return $permission;
            }
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function findRoleByName($name)
    {
        foreach ($this->findRoles() as $role) {
            if ($role->getRole() === $name) {
                return $role;
            }
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole(UserInterface $user, $role)
    {
        if (is_string($role)) {
            $role = $this->findRoleByName($role);
        }
        if ($role === null) {
            throw new RoleNotFoundException($role);
        }
        return $user->hasAuthorizedRole($role);
    }

    /**
     * {@inheritdoc}
     */
    public function hasPermission(UserInterface $user, $permission)
    {
        if (is_string($permission)) {
            $permission = $this->findPermissionByName($permission);
        }
        if ($permission === null) {
            throw new PermissionNotFoundException($permission);
        }
        return $user->hasPermission($permission);
    }

    /**
     * {@inheritdoc}
     */
    public function removePermission($permission)
    {
        if (is_string($permission)) {
            $permission = $this->findPermissionByName($permission);
        }
        if ($permission === null) {
            throw new PermissionNotFoundException($permission);
        }
        $this->entityManager->remove($permission);
        $this->entityManager->flush();
    }

    /**
     * @return EntityRepository
     */
    protected function getRoleRepository()
    {
        return $this->entityManager->getRepository($this->roleClass);
    }

    /**
     * @return EntityRepository
     */
    protected function getPermissionRepository()
    {
        return $this->entityManager->getRepository($this->permissionClass);
    }

    /**
     * {@inheritdoc}
     */
    public function support($attribute, $subject)
    {
        return $this->findPermissionByName($attribute) !== null;
    }
}