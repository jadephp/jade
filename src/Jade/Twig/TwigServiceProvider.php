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

use Jade\ContainerInterface;
use Jade\ServiceProviderInterface;

class TwigServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container)
    {
        $container->add([
            'twig.class' => Twig::class,
            'twig.paths' => [],
            'twig.environment' => [],
        ]);
        $container['twig_class'] = Twig::class;
        
        $container['twig'] = function($c){
            $twig = new $c['twig_class']($c['twig.paths'], $c['twig.environment']);
            return $twig;
        };
    }
}