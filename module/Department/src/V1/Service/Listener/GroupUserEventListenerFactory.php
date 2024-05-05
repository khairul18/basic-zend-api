<?php
namespace Department\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class GroupUserEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $groupUserMapper = $container->get(\Department\Mapper\GroupUser::class);
        $groupUserHydrator = $container->get('HydratorManager')->get('Department\Hydrator\GroupUser');
        $groupUserEventListener = new GroupUserEventListener(
            $groupUserMapper,
            $accountMapper
        );
        $groupUserEventListener->setLogger($container->get("logger_default"));
        $groupUserEventListener->setGroupUserHydrator($groupUserHydrator);
        return $groupUserEventListener;
    }
}
