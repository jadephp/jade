<?php

/*
 * This file is part of the CubeCloud/Client package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cube\Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

class Notification
{
    /**
     * 普通消息
     */
    const TYPE_MESSAGE = 'message';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var NotificationMetadata[]|Collection
     */
    protected $metadata;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var string
     */
    protected $type = self::TYPE_MESSAGE;

    /**
     * 创建时间
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * 上次更新时间
     * @var \DateTimeInterface
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->metadata = new ArrayCollection();
    }

    /**
     * 匹配用户的metadata
     * @param AdminUser $user
     * @return NotificationMetadata
     */
    public function match(AdminUser $user)
    {
        return $this->metadata->matching(Criteria::create()->where(
            Criteria::expr()->eq('participant', $user)
        ))->first();
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     * @return self
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * 设置参数
     *
     * @param string $name
     * @param mixed $value
     * @return self
     */
    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;
        return $this;
    }

    /**
     * 获取参数
     *
     * @param string $name
     * @return mixed|null
     */
    public function getParameter($name)
    {
        return $this->parameters[$name] ?? null;
    }

    /**
     * 设置参数
     *
     * @param array $parameters
     * @return self
     */
    public function addParameters(array $parameters)
    {
        $this->parameters = array_merge($this->parameters, $parameters);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * {@inheritdoc}
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * {@inheritdoc}
     */
    public function addMetadata(NotificationMetadata $metadata)
    {
        $metadata->setNotification($this);
        $this->metadata[] = $metadata;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface $updatedAt
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
