<?php

namespace User\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use DoctrineModule\Stdlib\Hydrator\Strategy\AbstractCollectionStrategy;

/**
 * Class PhotosStrategy
 *
 * @package Reimbursement\Stdlib\Hydrator\Strategy
 */
class PhotosStrategy extends AbstractCollectionStrategy implements StrategyInterface
{
    protected $photosUrl;

    public function __construct($photosUrl = null)
    {
        $this->setPhotosUrl($photosUrl);
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
        $baseUrl  = $this->getPhotosUrl();
        if (!is_null($value) && $value != "") {
            $baseUrl    = $this->getPhotosUrl();
            $newUrl     = $baseUrl . '/' . $value;
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
     * Get the value of photosUrl
     */
    public function getPhotosUrl()
    {
        return $this->photosUrl;
    }

    /**
     * Set the value of photosUrl
     *
     * @return  self
     */
    public function setPhotosUrl($photosUrl)
    {
        $this->photosUrl = $photosUrl;

        return $this;
    }
}
