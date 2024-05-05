<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class SignoutEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userProfileMapper = $container->get('User\Mapper\UserProfile');
        $signoutEventListener = new SignoutEventListener($userProfileMapper);
        $signoutEventListener->setLogger($container->get("logger_default"));
        return $signoutEventListener;
    }
}
