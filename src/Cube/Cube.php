<?php

/*
 * This file is part of the Cube package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cube;

use Cube\Base\AppDiscoveryProvider;
use Cube\Base\AppInterface;
use Cube\Base\AppProviderInterface;
use Jade\App as JadeApp;
use Jade\Provider\DoctrineOrmServiceProvider;
use Jade\Twig\TwigServiceProvider;

class Cube extends JadeApp implements AppProviderInterface
{
    /**
     * @var AppInterface[]
     */
    protected $apps = [];

    protected $metadataMappings = [];

    /**
     * {@inheritdoc}
     */
    public function register($provider, array $values = [])
    {
        parent::register($provider, $values);

        if ($provider instanceof AppProviderInterface) {
            foreach ($provider->getApps() as $app) {
                $this->apps[] = $app;
            }
        }
    }

    public function boot()
    {
        if ($this->booted) {
            return;
        }
        parent::boot();
        $this->register($this);
        $this->register(new AppDiscoveryProvider($this->getRootDir() . '/apps'));
        $this->register(new TwigServiceProvider(), [
            'cache_dir' => $this->getCacheDir() . '/twig'
        ]);
        $this->register(new DoctrineOrmServiceProvider(), [
            'orm.proxies_dir' => $this->getCacheDir() . '/doctrine_proxies'
        ]);
        $this->initializeApps();
    }

    public function getApps()
    {
        return [
            new Admin\Admin()
        ];
    }

    public function getRootDir()
    {
        return __DIR__ . '/../../';
    }

    public function getCacheDir()
    {
        return $this->getRootDir() . '/var/cache';
    }

    protected function initializeApps()
    {
        foreach ($this->apps as $app) {
            // 注册 app 的路由
            if (null !== ($routesFactory = $app->getRoutesFactory())) {
                $routesFactory($this);
            }
            if (null !== ($mapping = $app->getEntityMapping())) {
                $this->metadataMappings[] = $mapping;
            }
            // 注册
            $app->initialize($this);
        }
        $this->container['orm.em.options'] = ['mappings' => $this->metadataMappings];
    }
}