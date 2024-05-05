<?php
namespace Department\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class GroupUserFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $groupUserService = new GroupUser();
        $groupUserService->setConfig($config);
        return $groupUserService;
    }
}
