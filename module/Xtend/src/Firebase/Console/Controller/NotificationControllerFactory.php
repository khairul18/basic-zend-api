<?php
namespace Xtend\Firebase\Console\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class NotificationControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['firebase'];
        $notificationController = new NotificationController($config);
        $notificationController->setLogger($container->get("logger_default"));
        return $notificationController;
    }
}
