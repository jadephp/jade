<?php

/*
 * This file is part of the CubeCloud/Client package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cube\Component\Permission\Menu;

use Knp\Menu\Factory\ExtensionInterface;
use Knp\Menu\ItemInterface;

class MenuExtension implements ExtensionInterface
{
    public function buildOptions(array $options)
    {
        return array_merge([
            'permission' => null
        ], $options);
    }

    public function buildItem(ItemInterface $item, array $options)
    {
        $item->setExtra('permission', $options['permission']);
    }
}