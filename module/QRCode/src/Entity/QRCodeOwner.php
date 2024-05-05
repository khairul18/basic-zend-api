<?php

namespace QRCode\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * QRCodeOwner
 */
class QRCodeOwner implements EntityInterface
{
    use \Gedmo\Timestampable\Traits\Timestampable;

    use \Gedmo\SoftDeleteable\Traits\SoftDeleteable;

    /**
     * @var \DateTime|null
     */
    private $expiredAt;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \QRCode\Entity\QRCode
     */
    private $qrCode;

    /**
     * @var \User\Entity\UserProfile
     */
    private $userProfile;

    /**
     * @var \QRCode\Entity\QRCodeOwnerType
     */
    private $qrCodeOwnerType;


    /**
     * Set expiredAt.
     *
     * @param \DateTime|null $expiredAt
     *
     * @return QRCodeOwner
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
     * Get uuid.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set qrCode.
     *
     * @param \QRCode\Entity\QRCode|null $qRCode
     *
     * @return QRCodeOwner
     */
    public function setQRCode(\QRCode\Entity\QRCode $qrCode = null)
    {
        $this->qrCode = $qrCode;

        return $this;
    }

    /**
     * Get qrCode.
     *
     * @return \QRCode\Entity\QRCode|null
     */
    public function getQRCode()
    {
        return $this->qrCode;
    }

    /**
     * Set userProfile.
     *
     * @param \User\Entity\UserProfile|null $userProfile
     *
     * @return QRCodeOwner
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
     * Set qrCodeOwnerType.
     *
     * @param \QRCode\Entity\QRCodeOwnerType|null $qrCodeOwnerType
     *
     * @return QRCodeOwner
     */
    public function setQRCodeOwnerType(\QRCode\Entity\QRCodeOwnerType $qrCodeOwnerType = null)
    {
        $this->qrCodeOwnerType = $qrCodeOwnerType;

        return $this;
    }

    /**
     * Get qrCodeOwnerType.
     *
     * @return \QRCode\Entity\QRCodeOwnerType|null
     */
    public function getQRCodeOwnerType()
    {
        return $this->qrCodeOwnerType;
    }
}
