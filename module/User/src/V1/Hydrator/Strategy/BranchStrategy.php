<?php

namespace User\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use User\Entity\Branch;

/**
 * Class BranchStrategy
 *
 * @package User\Stdlib\Hydrator\Strategy
 */
class BranchStrategy implements StrategyInterface
{
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
        if ($value instanceof Branch && !is_null($value)) {
            $values = [
                "uuid" => $value->getUuid(),
                "name" => $value->getName(),
                "geofence" => $value->getGeofence(),
                "geofenceRadius" => $value->getGeofenceRadius(),
                "latitude" => $value->getLatitude(),
                "longitude" => $value->getLongitude()
            ];
            if (is_null($value->getName()) || $value->getName() == '') {
                $values = null;
            }
            return $values;
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
