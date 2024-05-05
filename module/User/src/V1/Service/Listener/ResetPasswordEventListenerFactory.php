<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ResetPasswordEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config  = $container->get('Config');
        $resetPasswordMapper = $container->get('User\Mapper\ResetPassword');
        $userMapper = $container->get('Aqilix\OAuth2\Mapper\OauthUsers');
        $resetPasswordEventListener = new ResetPasswordEventListener($resetPasswordMapper, $userMapper);
        $resetPasswordEventListener->setConfig($config);
        $resetPasswordEventListener->setLogger($container->get("logger_default"));
        return $resetPasswordEventListener;
    }
}
