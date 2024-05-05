<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class BusinessSectorEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $businessSectorMapper = $container->get(\User\Mapper\BusinessSector::class);
        $businessSectorHydrator = $container->get('HydratorManager')->get('User\Hydrator\BusinessSector');
        $businessSectorEventListener = new BusinessSectorEventListener(
            $businessSectorMapper,
            $accountMapper
        );
        $businessSectorEventListener->setLogger($container->get("logger_default"));
        $businessSectorEventListener->setBusinessSectorHydrator($businessSectorHydrator);
        return $businessSectorEventListener;
    }
}
