<?php
namespace User\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class DivisionCustomerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $divisionCustomerService = new DivisionCustomer();
        $divisionCustomerService->setConfig($config);
        return $divisionCustomerService;
    }
}
