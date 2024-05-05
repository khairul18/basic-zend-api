<?php
namespace User\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class PositionCustomerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $positionCustomerService = new PositionCustomer();
        $positionCustomerService->setConfig($config);
        return $positionCustomerService;
    }
}
