<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class PositionCustomerEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $positionCustomerMapper = $container->get(\User\Mapper\PositionCustomer::class);
        $positionCustomerHydrator = $container->get('HydratorManager')->get('User\Hydrator\PositionCustomer');
        $positionCustomerEventListener = new PositionCustomerEventListener(
            $positionCustomerMapper,
            $accountMapper
        );
        $positionCustomerEventListener->setLogger($container->get("logger_default"));
        $positionCustomerEventListener->setPositionCustomerHydrator($positionCustomerHydrator);
        return $positionCustomerEventListener;
    }
}
