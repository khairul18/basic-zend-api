<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class UserDocumentEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fileConfig  = $container->get('Config')['project']['user_document'];
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $userDocumentMapper = $container->get(\User\Mapper\UserDocument::class);
        $userDocumentHydrator = $container->get('HydratorManager')->get('User\Hydrator\UserDocument');

        $userDocumentEventListener = new UserDocumentEventListener(
            $userDocumentMapper,
            $accountMapper
        );
        $userDocumentEventListener->setLogger($container->get("logger_default"));
        $userDocumentEventListener->setUserDocumentHydrator($userDocumentHydrator);
        $userDocumentEventListener->setFileConfig($fileConfig);
        return $userDocumentEventListener;
    }
}
