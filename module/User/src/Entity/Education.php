<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * Education
 */
class Education implements EntityInterface
{
    /**
     * @var string|null
     */
    private $levelEducation;

    /**
     * @var string|null
     */
    private $schoolName;

    /**
     * @var string|null
     */
    private $graduatedYear;

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
    private $user;


    /**
     * Set levelEducation.
     *
     * @param string|null $levelEducation
     *
     * @return Education
     */
    public function setLevelEducation($levelEducation = null)
    {
        $this->levelEducation = $levelEducation;

        return $this;
    }

    /**
     * Get levelEducation.
     *
     * @return string|null
     */
    public function getLevelEducation()
    {
        return $this->levelEducation;
    }

    /**
     * Set schoolName.
     *
     * @param string|null $schoolName
     *
     * @return Education
     */
    public function setSchoolName($schoolName = null)
    {
        $this->schoolName = $schoolName;

        return $this;
    }

    /**
     * Get schoolName.
     *
     * @return string|null
     */
    public function getSchoolName()
    {
        return $this->schoolName;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Education
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
     * @return Education
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
     * @return Education
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
     * Set user.
     *
     * @param \User\Entity\UserProfile|null $user
     *
     * @return Education
     */
    public function setUser(\User\Entity\UserProfile $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \User\Entity\UserProfile|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get the value of graduatedYear
     *
     * @return  string|null
     */
    public function getGraduatedYear()
    {
        return $this->graduatedYear;
    }

    /**
     * Set the value of graduatedYear
     *
     * @param  string|null  $graduatedYear
     *
     * @return  self
     */
    public function setGraduatedYear($graduatedYear)
    {
        $this->graduatedYear = $graduatedYear;

        return $this;
    }
}
