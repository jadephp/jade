<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade\HttpKernel;

use Psr\Http\Message\ServerRequestInterface;

class ArgumentResolver implements ArgumentResolverInterface
{
    protected $defaults = [];

    public function __construct($defaults = [])
    {
        $this->defaults = $defaults;
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments(ServerRequestInterface $request, callable $controller)
    {
        $this->addDefault('request', $request);
        $providedArguments = array_merge(
            $this->defaults,
            $request->getAttribute('_route')->getArguments()
        );
        $arguments = [];
        $parameters = $this->createArgumentMetadata($controller);
        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            $arguments[$name] = isset($providedArguments[$name])
                ? $providedArguments[$name] : (
                    $parameter->isOptional() ? $parameter->getDefaultValue() : null
                );
        }
        return $arguments;
    }

    /**
     * 添加一个默认参数
     *
     * @param string $name
     * @param mixed $value
     */
    public function addDefault($name, $value)
    {
        $this->defaults[$name] = $value;
    }

    /**
     * 设置默认
     *
     * @param array $defaults
     */
    public function setDefaults(array $defaults): void
    {
        $this->defaults = $defaults;
    }

    /**
     * 分析控制器的参数
     *
     * @param callable $controller
     * @return \ReflectionParameter[]
     * @throws \ReflectionException
     */
    protected function createArgumentMetadata($controller)
    {
        if (\is_array($controller)) {
            $reflection = new \ReflectionMethod($controller[0], $controller[1]);
        } elseif (\is_object($controller) && !$controller instanceof \Closure) {
            $reflection = (new \ReflectionObject($controller))->getMethod('__invoke');
        } else {
            $reflection = new \ReflectionFunction($controller);
        }
        return $reflection->getParameters();
    }
}