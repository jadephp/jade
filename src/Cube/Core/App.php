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

use Cube\Cube;
use Psr\Http\Message\ServerRequestInterface;

class App implements AppInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var callable
     */
    protected $routesFactory;

    /**
     * @var boolean
     */
    protected $enabled;

    public function __construct($id, $enabled = true)
    {
        $this->id = $id;
        $this->enabled = $enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        if ($this->path) {
            return $this->path;
        }
        $reflection = new \ReflectionObject($this);
        return $this->path = dirname($reflection->getFileName());
    }

    /**
     * {@inheritdoc}
     */
    public function setRoutesFactory(callable $routesFactory)
    {
        $this->routesFactory = $routesFactory;
    }

    public function initialize(Cube $cube)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function start(ServerRequestInterface $request)
    {
        // to do
    }
}