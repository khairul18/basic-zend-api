<?php

namespace QRCode\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * QRCodeOwnerType Trait
 */
trait QRCodeOwnerTypeTrait
{
    /**
     * @var QRCode\Mapper\QRCodeOwnerType
     */
    protected $qrCodeOwnerTypeMapper;


    /**
     * Get the value of qrCodeOwnerTypeMapper
     *
     * @return  QRCode\Mapper\QRCodeOwnerType
     */
    public function getQRCodeOwnerTypeMapper()
    {
        return $this->qrCodeOwnerTypeMapper;
    }

    /**
     * Set the value of qrCodeOwnerTypeMapper
     *
     * @param  QRCode\Mapper\QRCodeOwnerType  $qrCodeOwnerTypeMapper
     *
     * @return  self
     */
    public function setQRCodeOwnerTypeMapper(\QRCode\Mapper\QRCodeOwnerType $qrCodeOwnerTypeMapper)
    {
        $this->qrCodeOwnerTypeMapper = $qrCodeOwnerTypeMapper;

        return $this;
    }
}
