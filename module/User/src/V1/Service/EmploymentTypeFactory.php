<?php
namespace User\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class EmploymentTypeFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $employmentTypeService = new EmploymentType();
        $employmentTypeService->setConfig($config);
        return $employmentTypeService;
    }
}
