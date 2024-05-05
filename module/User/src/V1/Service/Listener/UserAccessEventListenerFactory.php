<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class UserAccessEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fileConfig  = $container->get('Config')['project']['files'];
        $userAccessMapper = $container->get(\User\Mapper\UserAccess::class);
        $userAccessHydrator = $container->get('HydratorManager')->get('User\Hydrator\UserAccess');        
        $userAccessEventListener = new UserAccessEventListener(
            $userAccessMapper
        );
        $userAccessEventListener->setLogger($container->get("logger_default"));
        $userAccessEventListener->setConfig($fileConfig);
        $userAccessEventListener->setUserAccessHydrator($userAccessHydrator);
        return $userAccessEventListener;
    }
}
