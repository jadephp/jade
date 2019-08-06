<?php

/*
 * This file is part of the CubeCloud/Client package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Cube\Component\Permission\Exception;

class PermissionNotFoundException extends \RuntimeException
{
    public function __construct($permission)
    {
        parent::__construct(sprintf('The permission "%s" is not found', $permission));
    }
}