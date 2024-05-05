<?php

namespace User\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use Vehicle\Entity\VehicleRequest;

/**
 * Class DrivingActivityStrategy
 *
 * @package User\Stdlib\Hydrator\Strategy
 */
class DrivingActivityStrategy implements StrategyInterface
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
        if ($value instanceof VehicleRequest && ! is_null($value)) {
            
            $category = $vehicle = null;
            if (! is_null($value->getVehicle())) {
                if (! is_null($value->getVehicle()->getCategory())) {
                    $category = [
                        "uuid" => $value->getVehicle()->getCategory()->getUuid(),
                        "name" => $value->getVehicle()->getCategory()->getName()
                    ];
                }

                $vehicle = [
                    "uuid" => $value->getVehicle()->getUuid(),
                    "merk" => $value->getVehicle()->getMerk(),
                    "model" => $value->getVehicle()->getModel(),
                    "plate" => $value->getVehicle()->getPlate(),
                    "category" => $category,
                ];
            }
            
            $values = [
                "uuid" => $value->getUuid(),
                "status" => $value->getStatus(),
                "vehicle" => $vehicle
            ];

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
