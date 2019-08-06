<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade;

use Pimple\Container as PimpleContainer;
use Psr\Container\ContainerInterface;
use Jade\Exception\ContainerException;
use Jade\Exception\ContainerValueNotFoundException;

class Container extends PimpleContainer implements ContainerInterface
{

    /**
     * 从容器中获取实例对象或者其它资源
     *
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        if (!$this->offsetExists($id)) {
            throw new ContainerValueNotFoundException(sprintf('Identifier "%s" is not defined.', $id));
        }
        try {
            return $this->offsetGet($id);
        } catch (\InvalidArgumentException $exception) {
            throw new ContainerException(sprintf('Container error while retrieving "%s"', $id),
                null,
                $exception
            );
        }
    }

    /**
     * 检查容器是否存储该资源，如果存在返回true，否则返回false
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return boolean
     */
    public function has($id)
    {
        return $this->offsetExists($id);
    }

    /**
     * 批量添加服务或者参数
     *
     * @param array $values
     */
    public function add($values)
    {
        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }
    }
}