<?php

namespace QRCode\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * QRCode Trait
 */
trait QRCodeTrait
{
    /**
     * @var QRCode\Mapper\QRCode
     */
    protected $qrCodeMapper;

    /**
     * Get QRCodeMapper
     *
     * @return \QRCode\Mapper\QRCode
     */
    public function getQRCodeMapper()
    {
        return $this->qrCodeMapper;
    }

    /**
     * Set QRCodeMapper
     *
     * @param  \QRCode\Mapper\QRCode $qrCodeMapper
     */
    public function setQRCodeMapper(\QRCode\Mapper\QRCode $qrCodeMapper)
    {
        $this->qrCodeMapper = $qrCodeMapper;
    }
}
