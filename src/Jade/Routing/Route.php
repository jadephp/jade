<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade\Routing;

class Route
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $pattern;

    /**
     * @var string|callable
     */
    protected $action;

    /**
     * @var array
     */
    protected $methods;

    /**
     * @var array
     */
    protected $arguments = [];

    public function __construct($name, $pattern, $action, $methods = [])
    {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->action = $action;
        $this->methods = $methods;
    }

    /**
     * 返回路由唯一名称
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * 设置唯一名称
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * 返回路由 pattern
     *
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * 设置路由 pattern
     *
     * @param string $pattern
     */
    public function setPattern(string $pattern): void
    {
        $this->pattern = $pattern;
    }

    /**
     * 获取路由动作
     *
     * @return callable|string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * 设置路由动作
     *
     * @param callable|string $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * 获取路由限制的请求
     *
     * @return array
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * 设置路由限制请求
     *
     * @param array $methods
     */
    public function setMethods(array $methods): void
    {
        $this->methods = $methods;
    }

    /**
     * 获取参数
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * 设置参数
     *
     * @param array $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * 设置单个参数
     *
     * @param string $name
     * @param mixed $value
     */
    public function setArgument($name, $value)
    {
        $this->arguments[$name] = $value;
    }

    /**
     * 获取单个参数
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getArgument($name, $default = null)
    {
        return $this->arguments[$name] ?? $default;
    }
}