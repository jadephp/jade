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

use Cube\Base\App;
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

    public function getEntityMapping()
    {
        return [
            'type' => 'simple_xml',
            'namespace' => 'Cube\Admin\Entity',
            'path' => __DIR__.'/Resources/doctrine',
        ];
    }

    public function initialize(Cube $cube)
    {
    }
}