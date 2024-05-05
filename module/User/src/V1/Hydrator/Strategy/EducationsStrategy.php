<?php

namespace User\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use DoctrineModule\Stdlib\Hydrator\Strategy\AbstractCollectionStrategy;

/**
 * Class EducationsStrategy
 *
 * @package User\Stdlib\Hydrator\Strategy
 */
class EducationsStrategy extends AbstractCollectionStrategy implements StrategyInterface
{
    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param  mixed $value The original value.
     * @param  object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     * @throws \RuntimeException If object os not a VehicleBill
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function extract($value, $object = null)
    {
        $values = [];
        foreach ($value as $option) {
            if (! is_null($option)) {
                $values[] = [
                    "uuid" => $option->getUuid(),
                    "levelEducation" => $option->getLevelEducation(),
                    "schoolName" => $option->getSchoolName(),
                    "graduatedYear" => $option->getGraduatedYear(),
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
}
