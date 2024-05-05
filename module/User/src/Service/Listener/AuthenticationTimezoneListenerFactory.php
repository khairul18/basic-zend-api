<?php
namespace User\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class AuthenticationTimezoneListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userProfileMapper = $container->get('User\Mapper\UserProfile');
        $authTimezoneListener = new AuthenticationTimezoneListener();
        $authTimezoneListener->setUserProfileMapper($userProfileMapper);
        $authTimezoneListener->setLogger($container->get("logger_default"));
        return $authTimezoneListener;
    }
}
