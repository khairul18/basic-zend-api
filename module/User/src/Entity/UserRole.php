<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UserRole
 */
class UserRole implements EntityInterface
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \User\Entity\UserRole
     */
    private $parent;

    /**
     * @var \User\Entity\Account
     */
    private $account;

    /**
     * @var \User\Entity\Company
     */
    private $company;

    /**
     * @var \User\Entity\Branch
     */
    private $branch;

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
     * Get uuid.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of name
     *
     * @return  string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string|null  $name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of account
     *
     * @return  \User\Entity\Account|null
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set the value of account
     *
     * @param  \User\Entity\Account|null $account
     *
     * @return  self
     */
    public function setAccount(\User\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get the value of company
     *
     * @return  \User\Entity\Company|null
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set the value of company
     *
     * @param  \User\Entity\Company|null $company
     *
     * @return  self
     */
    public function setCompany(\User\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get the value of branch
     *
     * @return  \User\Entity\Branch|null
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * Set the value of branch
     *
     * @param  \User\Entity\Branch|null $branch
     *
     * @return  self
     */
    public function setBranch(\User\Entity\Branch $branch = null)
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * Get the value of parent
     *
     * @return  \User\Entity\UserRole|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the value of parent
     *
     * @param  \User\Entity\UserRole|null $parent
     *
     * @return  self
     */
    public function setParent(\User\Entity\UserRole $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Add child.
     *
     * @param \User\Entity\UserRole $child
     *
     * @return UserRole
     */
    public function addChild(\User\Entity\UserRole $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child.
     *
     * @param \User\Entity\UserRole $child
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeChild(\User\Entity\UserRole $child)
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
}
