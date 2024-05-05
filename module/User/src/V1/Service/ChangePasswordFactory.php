<?php
namespace User\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ChangePasswordFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userMapper    = $container->get('Aqilix\OAuth2\Mapper\OauthUsers');
        return new ChangePassword($userMapper);
    }
}
