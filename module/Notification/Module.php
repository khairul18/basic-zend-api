<?php
namespace Notification;

use ZF\Apigility\Provider\ApigilityProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

class Module implements
    ApigilityProviderInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $sm = $mvcEvent->getApplication()->getServiceManager();
        $adminEventListener = $sm->get(
            \Notification\V1\Service\Listener\AdminEventListener::class
        );
        $notificationEventListener = $sm->get(
            \Notification\V1\Service\Listener\NotificationEventListener::class
        );
        $userActivatedEventListener = $sm->get(
            \Notification\V1\Service\Listener\UserActivatedEventListener::class
        );
        $notificationLogEventListener = $sm->get(
            \Notification\V1\Service\Listener\NotificationLogEventListener::class
        );
        $emailNotificationEventListener = $sm->get(
            \Notification\V1\Service\Listener\EmailNotificationEventListener::class
        );

        $userActivatedService    = $sm->get('user.activated');
        $resetPasswordService = $sm->get('user.resetpassword');

        $userActivatedEventListener->attach($userActivatedService->getEventManager());
        // $resetPasswordEventListener->attach($resetPasswordService->getEventManager());
        $emailNotificationEventListener->attach($userActivatedService->getEventManager());

        // notification
        $notificationService = $sm->get(\Notification\V1\Service\Notification::class);
        $notificationEventListener = $sm->get(\Notification\V1\Service\Listener\NotificationEventListener::class);
        $notificationEventListener->attach($notificationService->getEventManager());
    }

    public function getConfig()
    {
        $config = [];
        $configFiles = [
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/doctrine.config.php',  // configuration for doctrine
        ];

        // merge all module config options
        foreach ($configFiles as $configFile) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, include $configFile, true);
        }

        return $config;
    }

    public function getAutoloaderConfig()
    {
        return [
            'ZF\Apigility\Autoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }
}
