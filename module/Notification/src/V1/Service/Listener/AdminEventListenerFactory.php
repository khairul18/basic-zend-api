<?php
namespace Notification\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class AdminEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $processBuilder = $container->get('Aqilix\Service\PhpProcessBuilder');
        $config  = $container->get('Config');
        $firebaseService = $container->get(\Xtend\Firebase\Service\Firebase::class);
        $notificationHydrator  = $container->get('HydratorManager')->get('Notification\\Hydrator\\Notification');
        $notificationMapper = $container->get('Notification\Mapper\Notification');
        $userProfileMapper = $container -> get('User\Mapper\UserProfile');
        $adminEventListener = new AdminEventListener($userProfileMapper, $notificationMapper, $processBuilder);
        // $adminEventListener->setConfig($config['notification']['order_event_notification']);
        $adminEventListener->setNotificationHydrator($notificationHydrator);
        $adminEventListener->setLogger($container->get("logger_default"));
        $adminEventListener->setFirebaseService($firebaseService);
        return $adminEventListener;
    }
}
