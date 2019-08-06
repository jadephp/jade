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

use Jade\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

class TwigServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container)
    {
        $container['twig_class'] = Twig::class;
        
        $container['twig'] = function($c){
            $twig = new $c['twig_class'];
            return $twig;
        };
    }
}