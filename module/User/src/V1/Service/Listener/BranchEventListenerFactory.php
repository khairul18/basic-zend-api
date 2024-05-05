<?php

namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class BranchEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $branchMapper = $container->get(\User\Mapper\Branch::class);
        $userProfileMapper = $container->get('User\Mapper\UserProfile');
        $branchHydrator = $container->get('HydratorManager')->get('User\Hydrator\Branch');
        $branchEventListener = new BranchEventListener($userProfileMapper, $branchMapper);
        $branchEventListener->setBranchHydrator($branchHydrator);
        $branchEventListener->setLogger($container->get("logger_default"));
        return $branchEventListener;
    }
}
