<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * UserAcl
 */
class UserAcl implements EntityInterface
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \User\Entity\UserModule
     */
    private $userModule;

    /**
     * @var \User\Entity\UserRole
     */
    private $userRole;

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
     * Get uuid.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set userModule.
     *
     * @param \User\Entity\UserModule|null $userModule
     *
     * @return UserAcl
     */
    public function setUserModule(\User\Entity\UserModule $userModule = null)
    {
        $this->userModule = $userModule;

        return $this;
    }

    /**
     * Get userModule.
     *
     * @return \User\Entity\UserModule|null
     */
    public function getUserModule()
    {
        return $this->userModule;
    }

    /**
     * Get the value of userRole
     *
     * @return  \User\Entity\UserRole|null
     */ 
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * Set the value of userRole
     *
     * @param  \User\Entity\UserRole|null $userRole
     *
     * @return  self
     */ 
    public function setUserRole(\User\Entity\UserRole $userRole = null)
    {
        $this->userRole = $userRole;

        return $this;
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
