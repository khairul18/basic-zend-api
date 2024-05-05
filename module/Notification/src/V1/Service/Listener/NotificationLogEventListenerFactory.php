<?php
namespace Notification\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class NotificationLogEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $processBuilder = $container->get('Aqilix\Service\PhpProcessBuilder');
        $config  = $container->get('Config');
        $firebaseService = $container->get(\Xtend\Firebase\Service\Firebase::class);
        $notificationLogHydrator  = $container->get('HydratorManager')->get('Notification\\Hydrator\\NotificationLog');
        $notificationLogMapper = $container->get('Notification\Mapper\NotificationLog');
        $userProfileMapper = $container -> get('User\Mapper\UserProfile');
        $notificationLogEventListener = new NotificationLogEventListener($userProfileMapper, $notificationLogMapper, $processBuilder);
        // $notificationLogEventListener->setConfig($config['notification']['guard_notification']);
        $notificationLogEventListener->setNotificationLogHydrator($notificationLogHydrator);
        $notificationLogEventListener->setLogger($container->get("logger_default"));
        $notificationLogEventListener->setFirebaseService($firebaseService);
        return $notificationLogEventListener;
    }
}
