<?php

namespace User\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use DoctrineModule\Stdlib\Hydrator\Strategy\AbstractCollectionStrategy;

/**
 * Class QrCodeStrategy
 *
 * @package Leave\Stdlib\Hydrator\Strategy
 */
class QrCodeStrategy extends AbstractCollectionStrategy implements StrategyInterface
{
    protected $photosUrl;

    public function __construct($photosUrl = null)
    {
        $this->setPathsUrl($photosUrl);
    }

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param  mixed $value The original value.
     * @param  object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     * @throws \RuntimeException If object os not a Leave
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function extract($value, $object = null)
    {
        $baseUrl  = $this->getPathsUrl();
        foreach ($value as $qr) {
            if (! is_null($qr->getPath())) {
                $photosUrl = $baseUrl.'/'.$qr->getPath();
            } else {
                $photosUrl = null;
            }
            $values[] = [
                "uuid" => $qr->getUuid(),
                "path" => $photosUrl
            ];
        }
        return $values;
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
    public function getPathsUrl()
    {
        return $this->photosUrl;
    }

    /**
     * Set the value of photosUrl
     *
     * @return  self
     */
    public function setPathsUrl($photosUrl)
    {
        $this->photosUrl = $photosUrl;

        return $this;
    }
}
