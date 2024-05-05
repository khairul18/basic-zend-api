<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * UserActivatedLog
 */
class UserActivatedLog implements EntityInterface
{

    /**
     * @var bool
     */
    private $isActive = '0';

    /**
     * @var string|null
     */
    private $note;

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
     * @var string
     */
    private $uuid;

    /**
     * @var \User\Entity\UserProfile
     */
    private $userProfile;

    /**
     * @var \User\Entity\UserProfile
     */
    private $changedBy;


    /**
     * Set note.
     *
     * @param string|null $note
     *
     * @return UserActivatedLog
     */
    public function setNote($note = null)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note.
     *
     * @return string|null
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return UserActivatedLog
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return UserActivatedLog
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt.
     *
     * @param \DateTime|null $deletedAt
     *
     * @return UserActivatedLog
     */
    public function setDeletedAt($deletedAt = null)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt.
     *
     * @return \DateTime|null
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
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
     * Set userProfile.
     *
     * @param \User\Entity\UserProfile|null $userProfile
     *
     * @return UserActivatedLog
     */
    public function setUserProfile(\User\Entity\UserProfile $userProfile = null)
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * Get userProfile.
     *
     * @return \User\Entity\UserProfile|null
     */
    public function getUserProfile()
    {
        return $this->userProfile;
    }

    /**
     * Set changedBy.
     *
     * @param \User\Entity\UserProfile|null $changedBy
     *
     * @return UserActivatedLog
     */
    public function setChangedBy(\User\Entity\UserProfile $changedBy = null)
    {
        $this->changedBy = $changedBy;

        return $this;
    }

    /**
     * Get changedBy.
     *
     * @return \User\Entity\UserProfile|null
     */
    public function getChangedBy()
    {
        return $this->changedBy;
    }

    /**
     * Get the value of isActive
     *
     * @return  bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set the value of isActive
     *
     * @param  bool  $isActive
     *
     * @return  self
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }
}
