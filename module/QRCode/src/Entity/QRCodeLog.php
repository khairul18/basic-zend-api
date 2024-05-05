<?php

namespace QRCode\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * QRCodeLog
 */
class QRCodeLog implements EntityInterface
{
    use \Gedmo\Timestampable\Traits\Timestampable;

    use \Gedmo\SoftDeleteable\Traits\SoftDeleteable;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \QRCode\Entity\QrCode
     */
    private $qrCode;

    /**
     * Set type
     *
     * @param string $type
     *
     * @return QRCodeLog
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set qrCode
     *
     * @param \QRCode\Entity\QrCode $qrCode
     *
     * @return QRCodeLog
     */
    public function setQrCode(\QRCode\Entity\QrCode $qrCode = null)
    {
        $this->qrCode = $qrCode;

        return $this;
    }

    /**
     * Get qrCode
     *
     * @return \QRCode\Entity\QrCode
     */
    public function getQrCode()
    {
        return $this->qrCode;
    }
}
