<?php
namespace Department\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class GroupEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $groupMapper = $container->get(\Department\Mapper\Group::class);
        $groupHydrator = $container->get('HydratorManager')->get('Department\Hydrator\Group');
        $groupEventListener = new GroupEventListener(
            $groupMapper,
            $accountMapper
        );
        $groupEventListener->setLogger($container->get("logger_default"));
        $groupEventListener->setGroupHydrator($groupHydrator);
        return $groupEventListener;
    }
}
