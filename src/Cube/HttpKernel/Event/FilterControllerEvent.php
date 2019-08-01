<?php

/*
 * This file is part of the shein/framework package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shein\HttpKernel\Event;

use Psr\Http\Message\ServerRequestInterface;
use Shein\HttpKernel\HttpKernel;

/**
 * 允许重新修改
 */
class FilterControllerEvent extends KernelEvent
{
    protected $controller;

    public function __construct(HttpKernel $kernel, ServerRequestInterface $request, callable $controller)
    {
        parent::__construct($kernel, $request);
        $this->setController($controller);
    }

    /**
     * Returns the current controller.
     *
     * @return callable
     */
    public function getController()
    {
        return $this->controller;
    }

    public function setController(callable $controller)
    {
        $this->controller = $controller;
    }
}
