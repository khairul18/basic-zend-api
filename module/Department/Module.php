<?php
namespace Department;

use Zend\Mvc\MvcEvent;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements ApigilityProviderInterface
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();

        // Department
        $departmentService = $serviceManager->get(\Department\V1\Service\Department::class);
        // $notificationEventListener = $serviceManager->get(\Notification\V1\Service\Listener\NotificationEventListener::class);
        $departmentEventListener = $serviceManager->get(\Department\V1\Service\Listener\DepartmentEventListener::class);
        $departmentEventListener->attach($departmentService->getEventManager());
        // $notificationEventListener->attach($departmentService->getEventManager());

        //Company
        $companyService = $serviceManager->get(\Department\V1\Service\Company::class);
        $companyEventListener = $serviceManager->get(\Department\V1\Service\Listener\CompanyEventListener::class);
        $companyEventListener->attach($companyService->getEventManager());

        // Group
        $groupService = $serviceManager->get(\Department\V1\Service\Group::class);
        $groupEventListener = $serviceManager->get(\Department\V1\Service\Listener\GroupEventListener::class);
        $groupEventListener->attach($groupService->getEventManager());

        // Group User
        $groupUserService = $serviceManager->get(\Department\V1\Service\GroupUser::class);
        $groupUserEventListener = $serviceManager->get(\Department\V1\Service\Listener\GroupUserEventListener::class);
        $groupUserEventListener->attach($groupUserService->getEventManager());
    }

    public function getConfig()
    {
        $config = [];
        $configFiles = [
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/doctrine.config.php',  // configuration for doctrine
        ];

        // merge all module config options
        foreach ($configFiles as $configFile) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, include $configFile, true);
        }

        return $config;
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
