<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade\Provider;

use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\AnnotationReader;
use Jade\ContainerInterface;
use Jade\ServiceProviderInterface;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
class AnnotationsServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container)
    {
        $container->add([
            'annotations.debug' => false,
            'annotations.options' => [
                'cache_driver' => 'array',
                'cache_dir'    => null,
            ]
        ]);
        $container['annotation_reader'] = function () use ($container) {
            return new AnnotationReader();
        };

        $container['annotations.cached_reader.factory'] = $container->protect(function ($options) use ($container) {
            if (!isset($container['cache'])) {
                throw new \LogicException(
                    'You must register the DoctrineCacheServiceProvider to use the AnnotationServiceProvider.'
                );
            }

            return $container['cache_factory']($options['cache_driver'], $options);
        });

        $container['annotations.cached_reader'] = function () use ($container) {
            return new CachedReader(
                $container['annotation_reader'],
                $container['annotations.cached_reader.factory']($container['annotations.options']),
                $container['annotations.debug']
            );
        };

        $container['annotations'] = function () use ($container) {
            return $container['annotations.cached_reader'];
        };
    }
}