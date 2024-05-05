<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class UserModuleEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $userModuleMapper = $container->get(\User\Mapper\UserModule::class);
        $userModuleHydrator = $container->get('HydratorManager')->get('User\Hydrator\UserModule');
        $userModuleEventListener = new UserModuleEventListener(
            $userModuleMapper,
            $accountMapper
        );
        $userModuleEventListener->setLogger($container->get("logger_default"));
        $userModuleEventListener->setUserModuleHydrator($userModuleHydrator);
        return $userModuleEventListener;
    }
}
