<?php

namespace QRCode\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * QRCodeLog Trait
 */
trait QRCodeLogTrait
{
    /**
     * @var QRCode\Mapper\QRCodeLog
     */
    protected $qrCodeLogMapper;

    /**
     * Get QRCodeLogMapper
     *
     * @return \QRCode\Mapper\QRCodeLog
     */
    public function getQRCodeLogMapper()
    {
        return $this->qrCodeLogMapper;
    }

    /**
     * Set QRCodeLogMapper
     *
     * @param  \QRCode\Mapper\QRCodeLog $qrCodeLogMapper
     */
    public function setQRCodeLogMapper(\QRCode\Mapper\QRCodeLog $qrCodeLogMapper)
    {
        $this->qrCodeLogMapper = $qrCodeLogMapper;
    }
}
