<?php

/*
 * This file is part of the CubeCloud/Client package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cube\Admin\Entity;

class Setting
{
    /**
     * @var int
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var boolean
     */
    protected $autoload;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isAutoload(): bool
    {
        return $this->autoload;
    }

    /**
     * @param bool $autoload
     * @return Setting
     */
    public function setAutoload(bool $autoload): Setting
    {
        $this->autoload = $autoload;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }
}