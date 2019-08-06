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

class NotificationMetadata
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var AdminUser
     */
    protected $participant;

    /**
     * @var Notification
     */
    protected $notification;

    /**
     * @var boolean
     */
    protected $seen = false;

    /**
     * @var \DateTimeInterface
     */
    protected $seenAt;

    public function __construct($participant, Notification $notification)
    {
        $this->participant = $participant;
        $this->notification = $notification;
    }

    /**
     * @return AdminUser
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * @param AdminUser $participant
     * @return NotificationMetadata
     */
    public function setParticipant(AdminUser $participant)
    {
        $this->participant = $participant;
        return $this;
    }

    /**
     * @return Notification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @param Notification $notification
     * @return NotificationMetadata
     */
    public function setNotification(Notification $notification)
    {
        $this->notification = $notification;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSeen()
    {
        return $this->seen;
    }

    /**
     * @param bool $seen
     * @return NotificationMetadata
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;
        return $this;
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
     * @return \DateTimeInterface
     */
    public function getSeenAt(): ?\DateTimeInterface
    {
        return $this->seenAt;
    }

    /**
     * @param \DateTimeInterface $seenAt
     */
    public function setSeenAt(\DateTimeInterface $seenAt): void
    {
        $this->seenAt = $seenAt;
    }
}