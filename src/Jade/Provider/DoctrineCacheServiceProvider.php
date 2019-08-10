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

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\RedisCache;
use Doctrine\Common\Cache\ApcuCache;
use Doctrine\Common\Cache\XcacheCache;
use Doctrine\Common\Cache\MemcachedCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\MongoDBCache;
use Jade\Container;
use Jade\ContainerInterface;
use Jade\ServiceProviderInterface;

class DoctrineCacheServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container)
    {
        $container['cache.default_options'] = [
            'driver'    => 'array',
            'namespace' => null,
        ];

        $container['caches.options.initializer'] = $container->protect(function () use ($container) {
            static $initialized = false;

            if ($initialized) {
                return;
            }

            $initialized = true;

            if (!isset($container['caches.options'])) {
                $container['caches.options'] = [
                    'default' => $container['cache.options'] ?? [],
                ];
            }

            $container['caches.options'] = array_map(function ($options) use ($container) {
                return array_replace($container['cache.default_options'], is_array($options)
                    ? $options
                    : ['driver' => $options]
                );
            }, $container['caches.options']);

            if (!isset($container['caches.default'])) {
                $container['caches.default'] = array_keys(
                    array_slice($container['caches.options'], 0, 1)
                )[0];
            }
        });

        $container['caches'] = function (ContainerInterface $container) {
            $container['caches.options.initializer']();

            $caches = new Container();
            foreach ($container['caches.options'] as $name => $options) {
                $caches[$name] = function () use ($container, $options) {
                    $cache = $container['cache_factory']($options['driver'], $options);

                    if (isset($options['namespace'])) {
                        $cache->setNamespace($options['namespace']);
                    }

                    return $cache;
                };
            }

            return $caches;
        };

        $container['cache_factory.filesystem'] = $container->protect(function ($options) {
            if (empty($options['cache_dir'])
                || false === is_dir($options['cache_dir'])
            ) {
                throw new \InvalidArgumentException(
                    'You must specify "cache_dir" for Filesystem.'
                );
            }

            return new FilesystemCache($options['cache_dir']);
        });

        $container['cache_factory.array'] = $container->protect(function ($options) {
            return new ArrayCache();
        });

        $container['cache_factory.apcu'] = $container->protect(function ($options) {
            return new ApcuCache();
        });

        $container['cache_factory.mongodb'] = $container->protect(function ($options) {
            if (empty($options['server'])
                || empty($options['name'])
                || empty($options['collection'])
            ) {
                throw new \InvalidArgumentException(
                    'You must specify "server", "name" and "collection" for MongoDB.'
                );
            }

            $client = new \MongoClient($options['server']);
            $db = new \MongoDB($client, $options['name']);
            $collection = new \MongoCollection($db, $options['collection']);

            return new MongoDBCache($collection);
        });

        $container['cache_factory.redis'] = $container->protect(function ($options) {
            if (empty($options['host']) || empty($options['port'])) {
                throw new \InvalidArgumentException('You must specify "host" and "port" for Redis.');
            }

            $redis = new \Redis();
            $redis->connect($options['host'], $options['port']);

            if (isset($options['password'])) {
                $redis->auth($options['password']);
            }

            $cache = new RedisCache();
            $cache->setRedis($redis);

            return $cache;
        });

        $container['cache_factory.xcache'] = $container->protect(function ($options) {

            if (empty($options['host']) || empty($options['port'])) {
                throw new \InvalidArgumentException('You must specify "host" and "port" for Memcached.');
            }

            $memcached = new \Memcached();
            $memcached->addServer($options['host'], $options['port']);

            $cache = new MemcachedCache();
            $cache->setMemcached($memcached);

            return $cache;
        });

        $container['cache_factory.xcache'] = $container->protect(function ($options) {
            return new XcacheCache();
        });

        $container['cache_factory'] = $container->protect(function ($driver, $options) use ($container) {
            if (isset($container['cache_factory.' . $driver])) {
                return $container['cache_factory.' . $driver]($options);
            }

            throw new \RuntimeException();
        });

        // shortcuts for the "first" cache
        $container['cache'] = function (Container $container) {
            $caches = $container['caches'];

            return $caches[$container['caches.default']];
        };
    }
}