<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade\Console;

use Jade\CommandProviderInterface;
use Psr\Container\ContainerInterface;
use Zend\Stdlib\Glob;

class CommandDiscovererProvider implements CommandProviderInterface
{
    /**
     * @var string
     */
    protected $dstDir;

    /**
     * @var string
     */
    protected $namespace;

    public function __construct($namespace, $dstDir)
    {
        $this->namespace = rtrim($namespace, '\\');
        $this->dstDir = rtrim($dstDir, '\\/');
    }

    /**
     * {@inheritdoc}
     */
    public function provide(Application $app, ContainerInterface $container)
    {
        foreach (Glob::glob("{$this->dstDir}/*Command.php") as $file) {
            $commands = [];
            try {
                $class = $this->namespace . pathinfo($file, PATHINFO_FILENAME);
                $r = new \ReflectionClass($class);
                if ($r->isSubclassOf('Symfony\\Component\\Console\\Command\\Command') && !$r->isAbstract() && !$r->getConstructor()->getNumberOfRequiredParameters()) {
                    $command = $r->newInstance();
                    $commands[] = $command;
                }
            } catch (\ReflectionException $e) {
                // 忽略无法反射的命令
            }
            $app->addCommands($commands);
        }
    }
}