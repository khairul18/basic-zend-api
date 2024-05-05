<?php

namespace User\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use DoctrineModule\Stdlib\Hydrator\Strategy\AbstractCollectionStrategy;

/**
 * Class DocUrlStrategy
 *
 * @package User\Stdlib\Hydrator\Strategy
 */
class DocUrlStrategy extends AbstractCollectionStrategy implements StrategyInterface
{
    protected $docUrl;

    public function __construct($docUrl = null)
    {
        $this->setDocUrl($docUrl);
    }

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param  mixed $value The original value.
     * @param  object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     * @throws \RuntimeException If object os not a UserDocument
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function extract($value, $object = null)
    {
        if (! is_null($value)) {
            return $this->getDocUrl() . '/' . $value;
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

    /**
     * Get the value of docUrl
     */
    public function getDocUrl()
    {
        return $this->docUrl;
    }

    /**
     * Set the value of docUrl
     *
     * @return  self
     */
    public function setDocUrl($docUrl)
    {
        $this->docUrl = $docUrl;

        return $this;
    }
}
