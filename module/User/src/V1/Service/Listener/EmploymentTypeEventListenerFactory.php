<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class EmploymentTypeEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $employmentTypeMapper = $container->get(\User\Mapper\EmploymentType::class);
        $employmentTypeHydrator = $container->get('HydratorManager')->get('User\Hydrator\EmploymentType');
        $employmentTypeEventListener = new EmploymentTypeEventListener(
            $employmentTypeMapper,
            $accountMapper
        );
        $employmentTypeEventListener->setLogger($container->get("logger_default"));
        $employmentTypeEventListener->setEmploymentTypeHydrator($employmentTypeHydrator);
        return $employmentTypeEventListener;
    }
}
