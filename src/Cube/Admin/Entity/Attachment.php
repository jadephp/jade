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

class Attachment
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $mediaKey;

    /**
     * @var string
     */
    protected $mimeType;

    /**
     * @var boolean
     */
    protected $isPublic = true;

    /**
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var User
     */
    protected $user;

    public function __construct(User $user = null, $mediaKey = null, $mimeType = null, $isPublic = false)
    {
        $this->user = $user;
        $this->mediaKey = $mediaKey;
        $this->mimeType = $mimeType;
        $this->isPublic = $isPublic;
    }

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
    public function getMediaKey(): string
    {
        return $this->mediaKey;
    }

    /**
     * @param string $mediaKey
     */
    public function setMediaKey(string $mediaKey): void
    {
        $this->mediaKey = $mediaKey;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType(string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }


    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    /**
     * @param bool $isPublic
     */
    public function setIsPublic(bool $isPublic): void
    {
        $this->isPublic = $isPublic;
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}