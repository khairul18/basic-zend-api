<?php

namespace User\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use User\Entity\Account;
use NumberFormatter;

/**
 * Class AccountStrategy
 *
 * @package User\Stdlib\Hydrator\Strategy
 */
class AccountObjectStrategy implements StrategyInterface
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
        if ($value instanceof Account && ! is_null($value)) {
            $numberFormatter = new NumberFormatter($value->getLocale() . '@currency=' . $value->getCurrency(), NumberFormatter::CURRENCY);
            $values = [
                "uuid" => $value->getUuid(),
                "name" => $value->getName(),
                "currency" => $numberFormatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL),
                "timezone" => $value->getTimezone(),
                "locale"   => $value->getLocale(),
                "address"  => $value->getAddress(),
                "city"     => $value->getCity(),
                "state"    => $value->getState(),
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
