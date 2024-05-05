<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class UserActivatedEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userProfileMapper = $container->get('User\Mapper\UserProfile');
        $userActivatedHydrator  = $container->get('HydratorManager')->get('User\\Hydrator\\UserProfile');
        $userActivatedEventListener = new UserActivatedEventListener($userProfileMapper);
        $userActivatedEventListener->setUserActivatedHydrator($userActivatedHydrator);
        $userActivatedEventListener->setLogger($container->get("logger_default"));
        return $userActivatedEventListener;
    }
}
