<?php
namespace Xtend;

use ZF\Apigility\Provider\ApigilityProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

class Module implements
    ApigilityProviderInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ConsoleUsageProviderInterface
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getConsoleUsage(Console $console)
    {
        return [
            // available command
            'firebase send <firebaseId> <message>' => 'Send firebase notification',
            'apns send <deviceToken> <payload>' => 'Send APNS notification',
            // describe expected parameters
            [ 'firebaseId', 'Firebase ID'],
            [ 'message', 'Message'],
            // describe expected parameters
            [ 'deviceToken', 'iOS Device Token'],
            [ 'payload', 'Payload Data'],
        ];
    }

    public function getAutoloaderConfig()
    {
        return [
            'ZF\Apigility\Autoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }
}
