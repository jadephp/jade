<?php

/*
 * This file is part of the Cube package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cube\Admin;

use Cube\Core\App;
use Cube\Cube;

class Admin extends App
{
    public function getId()
    {
        return 'admin';
    }

    public function getPath(): string
    {
        return __DIR__;
    }

    public function initialize(Cube $cube)
    {
        $cube->register(new AdminServiceProvider());
    }
}