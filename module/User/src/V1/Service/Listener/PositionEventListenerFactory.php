<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class PositionEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $positionMapper = $container->get(\User\Mapper\Position::class);
        $positionHydrator = $container->get('HydratorManager')->get('User\Hydrator\Position');
        $positionEventListener = new PositionEventListener(
            $positionMapper,
            $accountMapper
        );
        $positionEventListener->setLogger($container->get("logger_default"));
        $positionEventListener->setPositionHydrator($positionHydrator);
        return $positionEventListener;
    }
}
