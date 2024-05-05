<?php

namespace User\V1\Service\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class SupplierEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $supplierMapper = $container->get(\User\Mapper\Supplier::class);
        $supplierHydrator = $container->get('HydratorManager')->get('User\Hydrator\Supplier');
        $logger = $container->get('logger_default');

        $invoicesEventListener = new SupplierEventListener(
            $config,
            $supplierMapper,
            $supplierHydrator,
            $logger
        );

        return $invoicesEventListener;
    }
}
