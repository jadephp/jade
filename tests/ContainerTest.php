<?php

namespace Jade\Tests;

use PHPUnit\Framework\TestCase;
use Jade\Container;
use Jade\Exception\ContainerValueNotFoundException;

class ContainerTest extends TestCase
{
    /**
     * @var Container
     */
    protected $container;

    public function setUp()
    {
        $this->container = new Container();
    }

    public function testGet()
    {
        $this->container['foo'] = function(){
            return 'bar';
        };
        $this->assertSame('bar', $this->container->get('foo'));
    }

    public function testGetWithValueNotFoundError()
    {
        $this->expectException(ContainerValueNotFoundException::class);
        $this->container->get('foo');
    }

    public function testHas()
    {
        $this->assertFalse($this->container->has('foo'));
        $this->container['foo'] = function(){
            return 'bar';
        };
        $this->assertTrue($this->container->has('foo'));
    }
}