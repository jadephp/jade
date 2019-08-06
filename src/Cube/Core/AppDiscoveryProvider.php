<?php

/*
 * This file is part of the Cube package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cube\Core;

use Symfony\Component\Finder\Finder;

class AppDiscoveryProvider implements AppProviderInterface
{
    /**
     * @var array
     */
    protected $dirs;

    public function __construct($dirs)
    {
        $this->dirs = (array)$dirs;
    }

    public function getApps()
    {
        $finder = new Finder();
        foreach ($finder->in($this->dirs)->name('app.php')->files() as $file) {
            $instance = include $file->getPathname();
            $instance->setPath($file->getRealPath());
            yield $instance;
        }
    }
}