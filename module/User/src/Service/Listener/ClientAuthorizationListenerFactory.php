<?php
namespace User\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ClientAuthorizationListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $webAppConfig = $config['project']['web'];
        $mobileConfig = $config['project']['mobile'];
        $userProfileMapper = $container->get('User\Mapper\UserProfile');
        $userAccessMapper = $container->get(\User\Mapper\UserAccess::class);
        $mvcAuthEventListener = new ClientAuthorizationListener();
        $mvcAuthEventListener->setUserProfileMapper($userProfileMapper);
        $mvcAuthEventListener->setUserAccessMapper($userAccessMapper);
        $mvcAuthEventListener->setLogger($container->get("logger_default"));
        $mvcAuthEventListener->setMobileConfig($mobileConfig);
        $mvcAuthEventListener->setWebAppConfig($webAppConfig);
        return $mvcAuthEventListener;
    }
}
