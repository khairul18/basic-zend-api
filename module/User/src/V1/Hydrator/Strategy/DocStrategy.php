<?php

namespace User\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use DoctrineModule\Stdlib\Hydrator\Strategy\AbstractCollectionStrategy;

/**
 * Class DocStrategy
 *
 * @package User\Stdlib\Hydrator\Strategy
 */
class DocStrategy extends AbstractCollectionStrategy implements StrategyInterface
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
        $baseUrl  = $this->getDocUrl();
        $values = [];
        foreach ($value as $doc) {
            if (! is_null($doc)) {
                $path = $doc->getPath();
                $type = $doc->getType();
                $note = $doc->getNote();
                // $uuid = $doc->getUuid();
                $docUrl = $baseUrl.'/'.$path;
                $values[] = [
                    // "uuid" => $uuid,
                    "url" => $docUrl,
                    "type" => $type,
                    "note" => $note
                ];
            }
            // return null;
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
