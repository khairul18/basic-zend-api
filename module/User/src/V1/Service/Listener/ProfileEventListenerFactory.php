<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ProfileEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fileConfig  = $container->get('Config')['project']['user_document'];
        $userMapper           = $container->get('Aqilix\OAuth2\Mapper\OauthUsers');
        $userProfileMapper    = $container->get('User\Mapper\UserProfile');
        $educationMapper      = $container->get('User\Mapper\Education');
        $userDocumentMapper   = $container->get('User\Mapper\UserDocument');
        $userProfileHydrator  = $container->get('HydratorManager')->get('User\Hydrator\UserProfile');
        $userDocumentHydrator = $container->get('HydratorManager')->get('User\Hydrator\UserDocument');
        $profileEventConfig   = $container->get('Config')['user']['photo'];

        $profileEventListener = new ProfileEventListener(
            $userMapper,
            $userProfileMapper,
            $userProfileHydrator,
            $profileEventConfig,
            $educationMapper,
            $userDocumentMapper
        );

        $profileEventListener->setLogger($container->get("logger_default"));
        $profileEventListener->setUserProfileHydrator($userProfileHydrator);
        $profileEventListener->setUserDocumentHydrator($userDocumentHydrator);
        $profileEventListener->setFileConfig($fileConfig);
        return $profileEventListener;
    }
}
