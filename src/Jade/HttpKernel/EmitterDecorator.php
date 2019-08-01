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

use Psr\Http\Message\ResponseInterface;
use Zend\HttpHandlerRunner\Emitter\EmitterInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\HttpHandlerRunner\Emitter\SapiStreamEmitter;

class EmitterDecorator implements EmitterInterface
{
    protected $emitter;
    protected $streamEmitter;

    public function __construct(SapiEmitter $emitter, SapiStreamEmitter $streamEmitter)
    {
        $this->emitter = $emitter;
        $this->streamEmitter = $streamEmitter;
    }

    /**
     * {@inheritdoc}
     */
    public function emit(ResponseInterface $response) : bool
    {
        if (! $response->hasHeader('Content-Disposition')
            && ! $response->hasHeader('Content-Range')
        ) {
            return $this->emitter->emit($response);
        }
        // 内存优化型 response 输出
        return $this->streamEmitter->emit($response);
    }
}