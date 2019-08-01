<?php

/*
 * This file is part of the shein/framework package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shein\Exception;

use Psr\Container\NotFoundExceptionInterface;

class ContainerValueNotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{
}