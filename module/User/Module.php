<?php

namespace User;

use ZF\Apigility\Provider\ApigilityProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Mvc\MvcEvent;
use ZF\MvcAuth\MvcAuthEvent;

class Module implements
    ApigilityProviderInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ConsoleUsageProviderInterface
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $sm = $mvcEvent->getApplication()->getServiceManager();
        // signup
        $signupService  = $sm->get('user.signup');
        $signupEventListener = $sm->get('user.signup.listener');
        $signupEventListener->attach($signupService->getEventManager());
        // signout
        $signoutService  = $sm->get('user.signout');
        $signoutEventListener = $sm->get('user.signout.listener');
        $signoutEventListener->attach($signoutService->getEventManager());
        // user activation
        $userActivationService = $sm->get('user.activation');
        $userActivationEventListener = $sm->get('user.activation.listener');
        $userActivationEventListener->attach($userActivationService->getEventManager());
        // googleAuth
        $googleAuthEventListener = $sm->get('user.google.auth.listener');
        $googleAuthService = $sm->get('user.google.auth');
        $googleAuthEventListener->attach($googleAuthService->getEventManager());
        // facebookAuth
        $facebookAuthEventListener = $sm->get('user.facebook.auth.listener');
        $facebookAuthService = $sm->get('user.facebook.auth');
        $facebookAuthEventListener->attach($facebookAuthService->getEventManager());
        // profile
        $profileEventListener = $sm->get('user.profile.listener');
        $profileService = $sm->get('user.profile');
        $profileEventListener->attach($profileService->getEventManager());
        // $qrCodeOwnerEventLitener = $sm->get(\QRCode\V1\Service\Listener\QRCodeOwnerEventListener::class);
        // $qrCodeOwnerEventLitener->attach($profileService->getEventManager());

        // branch
        $branchService = $sm->get(\User\V1\Service\Branch::class);
        $branchEventListener = $sm->get(\User\V1\Service\Listener\BranchEventListener::class);
        $branchEventListener->attach($branchService->getEventManager());

        // reset password
        $resetPasswordService = $sm->get('user.resetpassword');
        $resetPasswordEventListener = $sm->get('user.resetpassword.listener');
        $resetPasswordEventListener->attach($resetPasswordService->getEventManager());
        // android last state
        $mobileStateService = $sm->get('user.mobilestate');
        $mobileStateEventListener = $sm->get('user.mobilestate.listener');
        $mobileStateEventListener->attach($mobileStateService->getEventManager());
        // change password
        $changePasswordService = $sm->get('user.changepassword');
        $changePasswordEventListener = $sm->get('user.changepassword.listener');
        $changePasswordEventListener->attach($changePasswordService->getEventManager());
        // user activated
        $userActivatedService = $sm->get('user.activated');
        $userActivatedEventListener = $sm->get('user.activated.listener');
        $userActivatedEventListener->attach($userActivatedService->getEventManager());

        //Position
        $positionService = $sm->get(\User\V1\Service\Position::class);
        $positionEventListener = $sm->get(\User\V1\Service\Listener\PositionEventListener::class);
        $positionEventListener->attach($positionService->getEventManager());

        //EmploymentType
        $employmentTypeService = $sm->get(\User\V1\Service\EmploymentType::class);
        $employmentTypeEventListener = $sm->get(\User\V1\Service\Listener\EmploymentTypeEventListener::class);
        $employmentTypeEventListener->attach($employmentTypeService->getEventManager());

        //Education
        $educationService = $sm->get(\User\V1\Service\Education::class);
        $educationEventListener = $sm->get(\User\V1\Service\Listener\EducationEventListener::class);
        $educationEventListener->attach($educationService->getEventManager());

        //UserDocument
        $userDocumentService = $sm->get(\User\V1\Service\UserDocument::class);
        $userDocumentEventListener = $sm->get(\User\V1\Service\Listener\UserDocumentEventListener::class);
        $userDocumentEventListener->attach($userDocumentService->getEventManager());

        // //Customer
        // $customerService = $sm->get(\User\V1\Service\Customer::class);
        // $customerEventListener = $sm->get(\User\V1\Service\Listener\CustomerEventListener::class);
        // $customerEventListener->attach($customerService->getEventManager());

        // // Quotation
        // $quotationService = $sm->get(\User\V1\Service\Quotation::class);
        // $quotationEventListener = $sm->get(\User\V1\Service\Listener\QuotationEventListener::class);
        // $quotationEventListener->attach($quotationService->getEventManager());

        // //BankAccount
        // $bankAccountService = $sm->get(\User\V1\Service\BankAccount::class);
        // $bankAccountEventListener = $sm->get(\User\V1\Service\Listener\BankAccountEventListener::class);
        // $bankAccountEventListener->attach($bankAccountService->getEventManager());

        // //TaxCategory
        // $taxCategoryService = $sm->get(\User\V1\Service\TaxCategory::class);
        // $taxCategoryEventListener = $sm->get(\User\V1\Service\Listener\TaxCategoryEventListener::class);
        // $taxCategoryEventListener->attach($taxCategoryService->getEventManager());

        //BusinessSector
        $businessSectorService = $sm->get(\User\V1\Service\BusinessSector::class);
        $businessSectorEventListener = $sm->get(\User\V1\Service\Listener\BusinessSectorEventListener::class);
        $businessSectorEventListener->attach($businessSectorService->getEventManager());

        // //DivisionCustomer
        // $divisionCustomerService = $sm->get(\User\V1\Service\DivisionCustomer::class);
        // $divisionCustomerEventListener = $sm->get(\User\V1\Service\Listener\DivisionCustomerEventListener::class);
        // $divisionCustomerEventListener->attach($divisionCustomerService->getEventManager());

        // //PositionCustomer
        // $positionCustomerService = $sm->get(\User\V1\Service\PositionCustomer::class);
        // $positionCustomerEventListener = $sm->get(\User\V1\Service\Listener\PositionCustomerEventListener::class);
        // $positionCustomerEventListener->attach($positionCustomerService->getEventManager());

        // //TaxValue
        // $taxValueService = $sm->get(\User\V1\Service\TaxValue::class);
        // $taxValueEventListener = $sm->get(\User\V1\Service\Listener\TaxValueEventListener::class);
        // $taxValueEventListener->attach($taxValueService->getEventManager());

        //UserRole
        $userRoleService = $sm->get(\User\V1\Service\UserRole::class);
        $userRoleEventListener = $sm->get(\User\V1\Service\Listener\UserRoleEventListener::class);
        $userRoleEventListener->attach($userRoleService->getEventManager());

        //UserModule
        $userModuleService = $sm->get(\User\V1\Service\UserModule::class);
        $userModuleEventListener = $sm->get(\User\V1\Service\Listener\UserModuleEventListener::class);
        $userModuleEventListener->attach($userModuleService->getEventManager());

        //UserAcl
        $userAclService = $sm->get(\User\V1\Service\UserAcl::class);
        $userAclEventListener = $sm->get(\User\V1\Service\Listener\UserAclEventListener::class);
        $userAclEventListener->attach($userAclService->getEventManager());

        //UserAccess
        $userAccessService = $sm->get(\User\V1\Service\UserAccess::class);
        $userAccessEventListener = $sm->get(\User\V1\Service\Listener\UserAccessEventListener::class);
        $userAccessEventListener->attach($userAccessService->getEventManager());

        // //Supplier
        // $supplierService = $sm->get(\User\V1\Service\Supplier::class);
        // $supplierEventListener = $sm->get(\User\V1\Service\Listener\SupplierEventListener::class);
        // $supplierEventListener->attach($supplierService->getEventManager());

        // Department
        $departmentService = $sm->get(\User\V1\Service\Department::class);
        // $notificationEventListener = $sm->get(\Notification\V1\Service\Listener\NotificationEventListener::class);
        $departmentEventListener = $sm->get(\User\V1\Service\Listener\DepartmentEventListener::class);
        $departmentEventListener->attach($departmentService->getEventManager());
        // $notificationEventListener->attach($departmentService->getEventManager());

        //Company
        $companyService = $sm->get(\User\V1\Service\Company::class);
        $companyEventListener = $sm->get(\User\V1\Service\Listener\CompanyEventListener::class);
        $companyEventListener->attach($companyService->getEventManager());


        // AuthActiveUserListener
        $app    = $mvcEvent->getApplication();
        $events = $app->getEventManager();
        $mvcAuthEvent = new MvcAuthEvent(
            $mvcEvent,
            $sm->get('authentication'),
            $sm->get('authorization')
        );
        $pdoAdapter = $sm->get('user.auth.pdo.adapter');
        $pdoAdapter->setEventManager($events);
        $pdoAdapter->setMvcAuthEvent($mvcAuthEvent);
        $events->attach(
            MvcAuthEvent::EVENT_AUTHENTICATION_POST,
            $sm->get('user.auth.activeuser.listener'),
            500
        );

        $events->attach(
            MvcAuthEvent::EVENT_AUTHENTICATION_POST,
            $sm->get('user.authentication.timezone.listener'),
            498
        );

        $events->attach(
            MvcAuthEvent::EVENT_AUTHENTICATION_POST,
            $sm->get(\User\Service\Listener\ClientAuthorizationListener::class),
            490
        );
        // $events->attach(MvcAuthEvent::EVENT_AUTHORIZATION, $sm->get('user.authorization.timezone.listener'), 100);
        // add header if get http status 401
        $events->attach(\Zend\Mvc\MvcEvent::EVENT_FINISH, $sm->get('user.auth.unauthorized.listener'), -100);
        // notification email for signup
        $signupNotificationEmailListener = $sm->get('user.notification.email.signup.listener');
        // notification email for reset password
        $resetPasswordNotificationEmailListener = $sm->get(
            'user.notification.email.resetpassword.listener'
        );
        $resetPasswordNotificationEmailListener->attach($resetPasswordService->getEventManager());
        $signupNotificationEmailListener->attach($signupService->getEventManager());
        // notification email for activation
        $activationNotificationEmailListener = $sm->get('user.notification.email.activation.listener');
        $activationNotificationEmailListener->attach($userActivationService->getEventManager());
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

    public function getConsoleUsage(Console $console)
    {
        return [
            // available command
            'v1 user send-welcome-email <emailAddress> <activationCode>' => 'Send Welcome Email to New User',
            'v1 user send-activation-email <emailAddress>' => 'Send Notification Account Activated to New User',
            'v1 user send-resetpassword-email <emailAddress> <resetPaswordKey>' => 'Send Reset Password Link to Email',

            // describe expected parameters
            ['emailAddress',   'Email Address of New User'],
            ['activationCode', 'Activation Code for New user'],
            ['resetPaswordKey', 'Reset Password Key']
        ];
    }
}
