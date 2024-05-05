<?php
namespace Notification\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class NotificationEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config  = $container->get('Config');
        $firebaseService = $container->get(\Xtend\Firebase\Service\Firebase::class);
        $notificationMapper = $container->get(\Notification\Mapper\Notification::class);
        $accountMapper  = $container->get(\User\Mapper\Account::class);
        $notificationHydrator = $container->get('HydratorManager')->get('Notification\\Hydrator\\Notification');
        $userProfileMapper = $container -> get('User\Mapper\UserProfile');
        $processBuilder = $container->get('Aqilix\Service\PhpProcessBuilder');
        $userAccessMapper = $container->get(\User\Mapper\UserAccess::class);
        $notificationEventListener = new NotificationEventListener(
            $userProfileMapper,
            $notificationMapper,
            $accountMapper,
            $processBuilder,
            $userAccessMapper
        );
        $notificationEventListener->setConfig($config['notification']['admin_notification']);
        $notificationEventListener->setNotificationHydrator($notificationHydrator);
        $notificationEventListener->setLogger($container->get("logger_default"));
        $notificationEventListener->setTelegramConfig($config['telegram_bot']);
        $notificationEventListener->setTelegramNotification($config['notification']['telegram']);
        $notificationEventListener->setFirebaseService($firebaseService);
        return $notificationEventListener;
    }
}
