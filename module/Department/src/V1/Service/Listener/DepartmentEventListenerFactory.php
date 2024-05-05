<?php
namespace Department\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class DepartmentEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $departmentMapper = $container->get(\Department\Mapper\Department::class);
        $departmentHydrator = $container->get('HydratorManager')->get('Department\Hydrator\Department');
        $departmentEventListener = new DepartmentEventListener(
            $departmentMapper,
            $accountMapper
        );
        $departmentEventListener->setLogger($container->get("logger_default"));
        $departmentEventListener->setDepartmentHydrator($departmentHydrator);
        return $departmentEventListener;
    }
}
