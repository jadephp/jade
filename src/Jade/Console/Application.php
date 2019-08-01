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

use Jade\App;
use Jade\CommandProviderInterface;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends SymfonyApplication
{
    /**
     * Logo Text
     *
     * @var string
     */
    const LOGO = <<<EOT
 ____  _          ___
/ ___|| |__   ___|_ _|_ __
\___ \| '_ \ / _ \| || '_ \
 ___) | | | |  __/| || | | |
|____/|_| |_|\___|___|_| |_|

EOT;

    /**
     * @var App
     */
    protected $decorated;

    public function __construct(App $app)
    {
        $this->decorated = $app;
        parent::__construct('Jade', '0.0.1');
    }

    /**
     * {@inheritdoc}
     */
    public function getHelp()
    {
        return parent::getHelp() . PHP_EOL . static::LOGO;
    }

    /**
     * {@inheritdoc}
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->decorated->boot();

        $this->registerCommands();

        return parent::doRun($input, $output);
    }

    protected function registerCommands()
    {
        foreach ($this->decorated->getProviders() as $provider) {
            if ($provider instanceof CommandProviderInterface) {
                $provider->provide($this);
            }
        }
    }
}