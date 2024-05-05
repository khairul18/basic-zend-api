<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ChangePasswordEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userMapper      = $container->get('Aqilix\OAuth2\Mapper\OauthUsers');
        $changePasswordHydrator  = $container->get('HydratorManager')->get('User\\Hydrator\\UserProfile');
        $changePasswordEventListener = new ChangePasswordEventListener($userMapper);
        $changePasswordEventListener->setChangePasswordHydrator($changePasswordHydrator);
        $changePasswordEventListener->setLogger($container->get("logger_default"));
        return $changePasswordEventListener;
    }
}
