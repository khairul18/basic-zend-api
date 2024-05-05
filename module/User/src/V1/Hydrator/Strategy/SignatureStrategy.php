<?php

namespace User\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use DoctrineModule\Stdlib\Hydrator\Strategy\AbstractCollectionStrategy;

/**
 * Class ImageStrategy
 *
 * @package Reimbursement\Stdlib\Hydrator\Strategy
 */
class SignatureStrategy extends AbstractCollectionStrategy implements StrategyInterface
{
    protected $signatureUrl;

    public function __construct($signatureUrl = null)
    {
        $this->setSignatureUrl($signatureUrl);
    }

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param  mixed $value The original value.
     * @param  object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     * @throws \RuntimeException If object os not a Reimbursement
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function extract($value, $object = null)
    {
        $baseUrl  = $this->getSignatureUrl();
        if (!is_null($value) && $value != "") {
            $baseUrl    = $this->getSignatureUrl();
            $value = str_replace("data/photo", "", $value);
            $newUrl     = $baseUrl . '' . $value;
            return $newUrl;
        } else {
            return null;
        }
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

    /**
     * Get the value of signatureUrl
     */
    public function getSignatureUrl()
    {
        return $this->signatureUrl;
    }

    /**
     * Set the value of signatureUrl
     *
     * @return  self
     */
    public function setSignatureUrl($signatureUrl)
    {
        $this->signatureUrl = $signatureUrl;

        return $this;
    }
}
