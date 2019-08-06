<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade\Twig;

class ConfigProvider
{
    public function __invoke() : array
    {
        return [
            'twig_class' => Twig::class
        ];
    }
}