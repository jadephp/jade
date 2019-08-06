<?php

/*
 * This file is part of the CubeCloud/Client package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cube\Component\Permission\Security;

use Cube\Component\Permission\Model\UserInterface;
use Cube\Component\Permission\PermissionManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class PermissionVoter extends Voter
{

    /**
     * @var Security $security
     */
    protected $security;

    /**
     * @var PermissionManagerInterface
     */
    protected $permissionManager;

    public function __construct(Security $security, PermissionManagerInterface $permissionManager)
    {
        $this->security = $security;
        $this->permissionManager = $permissionManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        return $this->permissionManager->support($attribute,$subject);
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        // Deny access if user is not logged in.
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        // 如果找不到权限则拒绝
        if (null === ($permission = $this->permissionProvider->findPermissionByName($attribute))) {
            return false;
        }

        return $user->hasPermission($permission);
    }
}