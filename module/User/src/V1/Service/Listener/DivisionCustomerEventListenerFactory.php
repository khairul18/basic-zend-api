<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class DivisionCustomerEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $divisionCustomerMapper = $container->get(\User\Mapper\DivisionCustomer::class);
        $divisionCustomerHydrator = $container->get('HydratorManager')->get('User\Hydrator\DivisionCustomer');
        $divisionCustomerEventListener = new DivisionCustomerEventListener(
            $divisionCustomerMapper,
            $accountMapper
        );
        $divisionCustomerEventListener->setLogger($container->get("logger_default"));
        $divisionCustomerEventListener->setDivisionCustomerHydrator($divisionCustomerHydrator);
        return $divisionCustomerEventListener;
    }
}
