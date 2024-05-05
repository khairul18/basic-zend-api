<?php
namespace User\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class AuthorizationTimezoneListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userProfileMapper = $container->get('User\Mapper\UserProfile');
        $deviceIdListener = new AuthorizationTimezoneListener();
        $deviceIdListener->setUserProfileMapper($userProfileMapper);
        $deviceIdListener->setLogger($container->get("logger_default"));
        return $deviceIdListener;
    }
}
