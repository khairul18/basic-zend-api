<?php

namespace QRCode\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * QRCode
 */
class QRCode implements EntityInterface
{
    /**
     * @var string|null
     */
    private $value;

    /**
     * @var string|null
     */
    private $path;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var \DateTime|null
     */
    private $expiredAt;

    /**
     * @var int|null
     */
    private $isAvailable = '1';

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

    // /**
    //  * @var User\Entity\Customer
    //  */
    // private $customer;

    /**
     * Set value.
     *
     * @param string|null $value
     *
     * @return QRCode
     */
    public function setValue($value = null)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set path.
     *
     * @param string|null $path
     *
     * @return QRCode
     */
    public function setPath($path = null)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string|null
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set type.
     *
     * @param string|null $type
     *
     * @return QRCode
     */
    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set expiredAt.
     *
     * @param \DateTime|null $expiredAt
     *
     * @return QRCode
     */
    public function setExpiredAt($expiredAt = null)
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    /**
     * Get expiredAt.
     *
     * @return \DateTime|null
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * Set isAvailable.
     *
     * @param int|null $isAvailable
     *
     * @return QRCode
     */
    public function setIsAvailable($isAvailable = null)
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * Get isAvailable.
     *
     * @return int|null
     */
    public function getIsAvailable()
    {
        return $this->isAvailable;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return QRCode
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
     * @return QRCode
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
     * @return QRCode
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
     * @return QRCode
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

    // /**
    //  * Get the value of customer
    //  *
    //  * @return  User\Entity\Customer
    //  */
    // public function getCustomer()
    // {
    //     return $this->customer;
    // }

    // /**
    //  * Set the value of customer
    //  *
    //  * @param  User\Entity\Customer  $customer
    //  *
    //  * @return  self
    //  */
    // public function setCustomer(\User\Entity\Customer $customer)
    // {
    //     $this->customer = $customer;

    //     return $this;
    // }
}
