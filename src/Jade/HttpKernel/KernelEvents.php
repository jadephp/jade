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

final class KernelEvents
{
    /**
     * 请求达到时触发
     */
    const REQUEST = 'kernel.request';

    /**
     * 请求经 middleware 调度结束时触发
     */
    const MIDDLEWARE = 'kernel.middle';

    /**
     * 异常时触发
     */
    const EXCEPTION = 'kernel.exception';

    /**
     * 请求达到控制器时触发
     */
    const CONTROLLER = 'kernel.controller';

    /**
     * 请求结束，响应生成时触发
     */
    const RESPONSE = 'kernel.response';

    /**
     * 响应输出时触发
     */
    const TERMINATE = 'kernel.terminate';
}