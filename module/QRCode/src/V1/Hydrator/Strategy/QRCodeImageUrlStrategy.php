<?php

namespace QRCode\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;

class QRCodeImageUrlStrategy implements StrategyInterface
{
    protected $qrCodeImageUrl;

    public function __construct($qrCodeImageUrl = null)
    {
        $this->setQrCodeImageUrl($qrCodeImageUrl);
    }


    /**
     * Get the value of qrCodeImageUrl
     */
    public function getQrCodeImageUrl()
    {
        return $this->qrCodeImageUrl;
    }

    /**
     * Set the value of qrCodeImageUrl
     *
     * @return  self
     */
    public function setQrCodeImageUrl($qrCodeImageUrl)
    {
        $this->qrCodeImageUrl = $qrCodeImageUrl;

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
        return $this->getPhotoUrl() . '/' . $value;
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
