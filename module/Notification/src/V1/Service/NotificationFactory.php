<?php
namespace Notification\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class NotificationFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $notificationMapper = $container->get(\Notification\Mapper\Notification::class);
        $accountMapper  = $container->get(\User\Mapper\Account::class);
        $notificationService = new Notification($notificationMapper, $accountMapper);
        $notificationService->setLogger($container->get("logger_default"));
        return $notificationService;
    }
}
