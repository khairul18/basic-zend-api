<?php
namespace Notification\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class EmailNotificationEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $processBuilder = $container->get('Aqilix\Service\PhpProcessBuilder');
        $emailService   = $container->get(\Xtend\Email\Service\Email::class);
        $emailNotificationEventListerner = new EmailNotificationEventListener();
        $emailNotificationEventListerner->setConfig($config['mail']['notification']['activation']);
        $emailNotificationEventListerner->setLogger($container->get("logger_default"));
        $emailNotificationEventListerner->setEmailService($emailService);
        return $emailNotificationEventListerner;
    }
}
