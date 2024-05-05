<?php

namespace QRCode\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * QRCodeLog Trait
 */
trait QRCodeOwnerTrait
{
    /**
     * @var QRCode\Mapper\QRCodeLog
     */
    protected $qrCodeOwnerMapper;


    /**
     * Get the value of qrCodeOwnerMapper
     *
     * @return  QRCode\Mapper\QRCodeLog
     */
    public function getQRCodeOwnerMapper()
    {
        return $this->qrCodeOwnerMapper;
    }

    /**
     * Set the value of qrCodeOwnerMapper
     *
     * @param  QRCode\Mapper\QRCodeOwner  $qrCodeOwnerMapper
     *
     * @return  self
     */
    public function setQRCodeOwnerMapper(\QRCode\Mapper\QRCodeOwner $qrCodeOwnerMapper)
    {
        $this->qrCodeOwnerMapper = $qrCodeOwnerMapper;

        return $this;
    }
}
