<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class MobileStateEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userProfileMapper = $container->get('User\Mapper\UserProfile');
        $ticketHydrator  = $container->get('HydratorManager')->get('User\Hydrator\UserProfile');
        $ticketEventListener = new MobileStateEventListener($userProfileMapper, $ticketHydrator);
        $ticketEventListener->setLogger($container->get("logger_default"));
        return $ticketEventListener;
    }
}
