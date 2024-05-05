<?php
namespace Department\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class DepartmentFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $departmentService = new Department();
        $departmentService->setConfig($config);
        return $departmentService;
    }
}
