<?php

namespace User\V1\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class SupplierFactory implements FactoryInterface
{
    /**
     * @param  \Interop\Container\ContainerInterface  $container
     * @param  mixed  $requestedName
     * @param  array  $options
     * @return \User\V1\Service\Supplier
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new Supplier();

        return $service;
    }
}
