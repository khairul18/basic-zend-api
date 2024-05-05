<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class UserAclEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userAclMapper = $container->get(\User\Mapper\UserAcl::class);
        $userRoleMapper = $container->get(\User\Mapper\UserRole::class);
        $userModuleMapper = $container->get(\User\Mapper\UserModule::class);
        $userAclHydrator = $container->get('HydratorManager')->get('User\Hydrator\UserAcl');
        $userAclEventListener = new UserAclEventListener(
            $userAclMapper,
            $userRoleMapper,
            $userModuleMapper
        );
        $userAclEventListener->setLogger($container->get("logger_default"));
        $userAclEventListener->setUserAclHydrator($userAclHydrator);
        return $userAclEventListener;
    }
}
