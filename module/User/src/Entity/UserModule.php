<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UserModule
 */
class UserModule implements EntityInterface
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var int|null
     */
    private $status = '1';

    /**
     * @var string|null
     */
    private $path;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \User\Entity\UserModule
     */
    private $parent;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \DateTime|null
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     */
    private $deletedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * Set name.
     *
     * @param string|null $name
     *
     * @return UserModule
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set status.
     *
     * @param int|null $status
     *
     * @return UserModule
     */
    public function setStatus($status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get uuid.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of createdAt
     *
     * @return  \DateTime|null
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param  \DateTime|null  $createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     *
     * @return  \DateTime|null
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param  \DateTime|null  $updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of deletedAt
     *
     * @return  \DateTime|null
     */ 
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set the value of deletedAt
     *
     * @param  \DateTime|null  $deletedAt
     *
     * @return  self
     */ 
    public function setDeletedAt($deletedAt = null)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get the value of parent
     *
     * @return  \User\Entity\UserModule
     */ 
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the value of parent
     *
     * @param  \User\Entity\UserModule  $parent
     *
     * @return  self
     */ 
    public function setParent(\User\Entity\UserModule $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Add child.
     *
     * @param \User\Entity\UserModule $child
     *
     * @return UserModule
     */
    public function addChild(\User\Entity\UserModule $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child.
     *
     * @param \User\Entity\UserModule $child
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeChild(\User\Entity\UserModule $child)
    {
        return $this->children->removeElement($child);
    }

    /**
     * Get children.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get the value of path
     *
     * @return  string|null
     */ 
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @param  string|null  $path
     *
     * @return  self
     */ 
    public function setPath($path = null)
    {
        $this->path = $path;

        return $this;
    }
}
