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

use Cube\Core\AppInterface;
use Cube\Core\AppProviderInterface;
use Jade\App as JadeApp;

class Cube extends JadeApp
{
    /**
     * @var AppInterface[]
     */
    protected $apps = [];

    public function registerApp(AppInterface $app)
    {
        $this->apps[] = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function register($provider)
    {
        parent::register($provider);

        if ($provider instanceof AppProviderInterface) {
            $provider->provide($this);
        }
    }
}