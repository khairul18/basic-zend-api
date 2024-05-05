<?php
namespace Notification\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class UserActivatedEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $processBuilder  = $container->get('Aqilix\Service\PhpProcessBuilder');
        $apnsService     = $container->get(\Xtend\Apns\Service\Apns::class);
        $firebaseService = $container->get(\Xtend\Firebase\Service\Firebase::class);
        $notificationHydrator  = $container->get('HydratorManager')->get('Notification\\Hydrator\\Notification');
        $userActivatedHydrator  = $container->get('HydratorManager')->get('User\\Hydrator\\UserActivatedLog');
        $notificationMapper = $container->get('Notification\Mapper\Notification');
        $userActivatedEventListener = new UserActivatedEventListener($notificationMapper, $processBuilder);
        $userActivatedEventListener->setConfig($config['notification']['UserActivated']);
        $userActivatedEventListener->setUserActivatedHydrator($userActivatedHydrator);
        $userActivatedEventListener->setLogger($container->get("logger_default"));
        $userActivatedEventListener->setFirebaseService($firebaseService);
        $userActivatedEventListener->setApnsService($apnsService);
        return $userActivatedEventListener;
    }
}
