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

use Doctrine\Common\EventManager;
use Gedmo\Sortable\SortableListener;
use Gedmo\Timestampable\TimestampableListener;
use Gedmo\Sluggable\SluggableListener;
use Jade\ContainerInterface;
use Jade\ServiceProviderInterface;

/**
 * @author Sérgio Rafael Siquira <sergio@inbep.com.br>
 */
class DoctrineExtensionsServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container)
    {
        if (!isset($container['annotations'])) {
            throw new \LogicException(
                'You must register the AnnotationsServiceProvider to use the DoctrineExtensionsServiceProvider.'
            );
        }

        $container['gedmo.listeners'] = function () {
            return [
                new SortableListener(),
                new TimestampableListener(),
                new SluggableListener(),
            ];
        };

        $container['db.event_manager'] = $container->extend('db.event_manager', function (EventManager $event) use ($container) {
            $listeners = $container['gedmo.listeners'];

            foreach ($listeners as $listener) {
                $listener->setAnnotationReader($container['annotations']);
                $event->addEventSubscriber($listener);
            }

            return $event;
        });
    }
}