<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade\Exception;

class NotFoundHttpException extends HttpException
{
    /**
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     */
    public function __construct($message = null, \Exception $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }
}
