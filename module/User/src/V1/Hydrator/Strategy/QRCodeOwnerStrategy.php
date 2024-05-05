<?php

namespace User\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use QRCode\Entity\QRCodeOwner;
use QRCode\Entity\QRCode;

/**
 * Class AccountStrategy
 *
 * @package User\Stdlib\Hydrator\Strategy
 */
class QRCodeOwnerStrategy implements StrategyInterface
{
    protected $qrCodeUrl;

    public function __construct($qrCodeUrl)
    {
        $this->setQrCodeUrl($qrCodeUrl);
    }

    /**
     * Get the value of qrCodeUrl
     */
    public function getQrCodeUrl()
    {
        return $this->qrCodeUrl;
    }

    /**
     * Set the value of qrCodeUrl
     *
     * @return  self
     */
    public function setQrCodeUrl($qrCodeUrl)
    {
        $this->qrCodeUrl = $qrCodeUrl;

        return $this;
    }

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param  mixed $value The original value.
     * @param  object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     * @throws \RuntimeException If object os not a User
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function extract($value, $object = null)
    {
        if ($value instanceof QRCodeOwner && ! is_null($value)) {
            $qrCodeBaseUrl = $this->getQrCodeUrl();
            $qrCodeUuid  = $value->getQrCode()->getUuid();
            $qrCodeUrl   = $qrCodeBaseUrl. "/qrcode/" .$qrCodeUuid. '.png';
            return $qrCodeUrl;
        } elseif ($value instanceof QRCode && ! is_null($value)) {
            $qrCodeBaseUrl = $this->getQrCodeUrl();
            $qrCodeUuid  = $value->getUuid();
            $qrCodeUrl   = $qrCodeBaseUrl. "/qrcode/" .$qrCodeUuid. '.png';
            return $qrCodeUrl;
        }

        return null;
    }

    /**
     * Converts the given value so that it can be hydrated by the hydrator.
     *
     * @param  mixed $value The original value.
     * @param  array $data (optional) The original data for context.
     * @return mixed Returns the value that should be hydrated.
     * @throws \InvalidArgumentException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function hydrate($value, array $data = null)
    {
        return $value;
    }
}
