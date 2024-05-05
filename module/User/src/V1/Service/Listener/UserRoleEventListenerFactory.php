<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class UserRoleEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $userRoleMapper = $container->get(\User\Mapper\UserRole::class);
        $userRoleHydrator = $container->get('HydratorManager')->get('User\Hydrator\UserRole');
        $userRoleEventListener = new UserRoleEventListener(
            $userRoleMapper,
            $accountMapper
        );
        $userRoleEventListener->setLogger($container->get("logger_default"));
        $userRoleEventListener->setUserRoleHydrator($userRoleHydrator);
        return $userRoleEventListener;
    }
}
