<?php
return [
    'reset_password' => [
        'expiration' => '14',
    ],
    'controllers' => [
        'factories' => [
            'User\\V1\\Rpc\\Signup\\Controller' => \User\V1\Rpc\Signup\SignupControllerFactory::class,
            'User\\V1\\Rpc\\Me\\Controller' => \User\V1\Rpc\Me\MeControllerFactory::class,
            'User\\V1\\Rpc\\UserActivation\\Controller' => \User\V1\Rpc\UserActivation\UserActivationControllerFactory::class,
            \User\V1\Console\Controller\EmailController::class => \User\V1\Console\Controller\EmailControllerFactory::class,
            'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller' => \User\V1\Rpc\ResetPasswordConfirmEmail\ResetPasswordConfirmEmailControllerFactory::class,
            'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller' => \User\V1\Rpc\ResetPasswordNewPassword\ResetPasswordNewPasswordControllerFactory::class,
            'User\\V1\\Rpc\\AuthRevoke\\Controller' => \User\V1\Rpc\AuthRevoke\AuthRevokeControllerFactory::class,
            'User\\V1\\Rpc\\MobileLastState\\Controller' => \User\V1\Rpc\MobileLastState\MobileLastStateControllerFactory::class,
            'User\\V1\\Rpc\\SignedOutUser\\Controller' => \User\V1\Rpc\SignedOutUser\SignedOutUserControllerFactory::class,
            'User\\V1\\Rpc\\RenewQRCode\\Controller' => \User\V1\Rpc\RenewQRCode\RenewQRCodeControllerFactory::class,
            'User\\V1\\Rpc\\ChangePassword\\Controller' => \User\V1\Rpc\ChangePassword\ChangePasswordControllerFactory::class,
            'User\\V1\\Rpc\\UserActivated\\Controller' => \User\V1\Rpc\UserActivated\UserActivatedControllerFactory::class,
            'User\\V1\\Rpc\\TimezoneSupported\\Controller' => \User\V1\Rpc\TimezoneSupported\TimezoneSupportedControllerFactory::class,
            'User\\V1\\Rpc\\GoogleAuth\\Controller' => \User\V1\Rpc\GoogleAuth\GoogleAuthControllerFactory::class,
            'User\\V1\\Rpc\\FacebookAuth\\Controller' => \User\V1\Rpc\FacebookAuth\FacebookAuthControllerFactory::class,
            'User\\V1\\Rpc\\UserAclUpdate\\Controller' => \User\V1\Rpc\UserAclUpdate\UserAclUpdateControllerFactory::class,
            'User\\V1\\Rpc\\UserSignature\\Controller' => \User\V1\Rpc\UserSignature\UserSignatureControllerFactory::class,
            'User\\V1\\Rpc\\GetMobileAcl\\Controller' => \User\V1\Rpc\GetMobileAcl\GetMobileAclControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            'user.resetpassword' => \User\V1\Service\ResetPasswordFactory::class,
            'user.changepassword' => \User\V1\Service\ChangePasswordFactory::class,
            'user.activated' => \User\V1\Service\UserActivatedFactory::class,
            'user.activation' => \User\V1\Service\UserActivationFactory::class,
            'user.mobilestate' => \User\V1\Service\MobileStateFactory::class,
            'user.signup' => \User\V1\Service\SignupFactory::class,
            'user.signout' => \User\V1\Service\SignoutFactory::class,
            'user.profile' => \User\V1\Service\ProfileFactory::class,
            'user.google.auth' => \User\V1\Service\GoogleAuthFactory::class,
            'user.facebook.auth' => \User\V1\Service\FacebookAuthFactory::class,
            'user.mobilestate.listener' => \User\V1\Service\Listener\MobileStateEventListenerFactory::class,
            'user.activation.listener' => \User\V1\Service\Listener\UserActivationEventListenerFactory::class,
            'user.resetpassword.listener' => \User\V1\Service\Listener\ResetPasswordEventListenerFactory::class,
            'user.changepassword.listener' => \User\V1\Service\Listener\ChangePasswordEventListenerFactory::class,
            'user.activated.listener' => \User\V1\Service\Listener\UserActivatedEventListenerFactory::class,
            'user.signup.listener' => \User\V1\Service\Listener\SignupEventListenerFactory::class,
            'user.signout.listener' => \User\V1\Service\Listener\SignoutEventListenerFactory::class,
            'user.signedout.listener' => 'Ticket\\V1\\Notification\\Firebase\\Listener\\UserEventListenerFactory',
            'user.profile.listener' => \User\V1\Service\Listener\ProfileEventListenerFactory::class,
            'user.google.auth.listener' => \User\V1\Service\Listener\GoogleAuthEventListenerFactory::class,
            'user.facebook.auth.listener' => \User\V1\Service\Listener\FacebookAuthEventListenerFactory::class,
            'user.notification.email.signup.listener' => \User\V1\Notification\Email\Listener\SignupEventListenerFactory::class,
            'user.notification.email.activation.listener' => \User\V1\Notification\Email\Listener\ActivationEventListenerFactory::class,
            'user.notification.email.resetpassword.listener' => \User\V1\Notification\Email\Listener\ResetPasswordEventListenerFactory::class,
            'user.notification.email.service.resetpassword' => \User\V1\Notification\Email\Service\ResetPasswordFactory::class,
            'user.notification.email.service.welcome' => \User\V1\Notification\Email\Service\WelcomeFactory::class,
            'user.notification.email.service.activation' => \User\V1\Notification\Email\Service\ActivationFactory::class,
            'user.auth.pdo.adapter' => \User\OAuth2\Factory\PdoAdapterFactory::class,
            'user.auth.activeuser.listener' => \User\Service\Listener\AuthActiveUserListenerFactory::class,
            'user.auth.unauthorized.listener' => \User\Service\Listener\UnauthorizedUserListenerFactory::class,
            'user.authentication.timezone.listener' => \User\Service\Listener\AuthenticationTimezoneListenerFactory::class,
            \User\V1\Rest\Profile\ProfileResource::class => \User\V1\Rest\Profile\ProfileResourceFactory::class,
            \User\V1\Service\Profile::class => \User\V1\Service\ProfileFactory::class,
            \User\Service\Listener\ClientAuthorizationListener::class => \User\Service\Listener\ClientAuthorizationListenerFactory::class,
            \User\V1\Rest\UserActivatedLog\UserActivatedLogResource::class => \User\V1\Rest\UserActivatedLog\UserActivatedLogResourceFactory::class,
            \User\Export\Service\CsvExport::class => \User\Export\Service\CsvExportFactory::class,
            \User\V1\Rest\Position\PositionResource::class => \User\V1\Rest\Position\PositionResourceFactory::class,
            \User\V1\Service\Position::class => \User\V1\Service\PositionFactory::class,
            \User\V1\Service\Listener\PositionEventListener::class => \User\V1\Service\Listener\PositionEventListenerFactory::class,
            \User\V1\Rest\EmploymentType\EmploymentTypeResource::class => \User\V1\Rest\EmploymentType\EmploymentTypeResourceFactory::class,
            \User\V1\Service\EmploymentType::class => \User\V1\Service\EmploymentTypeFactory::class,
            \User\V1\Service\Listener\EmploymentTypeEventListener::class => \User\V1\Service\Listener\EmploymentTypeEventListenerFactory::class,
            \User\V1\Rest\Education\EducationResource::class => \User\V1\Rest\Education\EducationResourceFactory::class,
            \User\V1\Service\Education::class => \User\V1\Service\EducationFactory::class,
            \User\V1\Service\Listener\EducationEventListener::class => \User\V1\Service\Listener\EducationEventListenerFactory::class,
            \User\V1\Rest\UserDocument\UserDocumentResource::class => \User\V1\Rest\UserDocument\UserDocumentResourceFactory::class,
            \User\V1\Service\UserDocument::class => \User\V1\Service\UserDocumentFactory::class,
            \User\V1\Service\Listener\UserDocumentEventListener::class => \User\V1\Service\Listener\UserDocumentEventListenerFactory::class,
            \User\V1\Rest\UserRole\UserRoleResource::class => \User\V1\Rest\UserRole\UserRoleResourceFactory::class,
            \User\V1\Service\UserRole::class => \User\V1\Service\UserRoleFactory::class,
            \User\V1\Service\Listener\UserRoleEventListener::class => \User\V1\Service\Listener\UserRoleEventListenerFactory::class,
            \User\V1\Rest\UserAccess\UserAccessResource::class => \User\V1\Rest\UserAccess\UserAccessResourceFactory::class,
            \User\V1\Service\UserAccess::class => \User\V1\Service\UserAccessFactory::class,
            \User\V1\Service\Listener\UserAccessEventListener::class => \User\V1\Service\Listener\UserAccessEventListenerFactory::class,
            \User\V1\Rest\UserModule\UserModuleResource::class => \User\V1\Rest\UserModule\UserModuleResourceFactory::class,
            \User\V1\Service\UserModule::class => \User\V1\Service\UserModuleFactory::class,
            \User\V1\Service\Listener\UserModuleEventListener::class => \User\V1\Service\Listener\UserModuleEventListenerFactory::class,
            \User\V1\Rest\UserAcl\UserAclResource::class => \User\V1\Rest\UserAcl\UserAclResourceFactory::class,
            \User\V1\Service\UserAcl::class => \User\V1\Service\UserAclFactory::class,
            \User\V1\Service\Listener\UserAclEventListener::class => \User\V1\Service\Listener\UserAclEventListenerFactory::class,
            \User\V1\Rest\Branch\BranchResource::class => \User\V1\Rest\Branch\BranchResourceFactory::class,
            \User\V1\Service\Branch::class => \User\V1\Service\BranchFactory::class,
            \User\V1\Service\Listener\BranchEventListener::class => \User\V1\Service\Listener\BranchEventListenerFactory::class,
            \User\V1\Rest\Department\DepartmentResource::class => \User\V1\Rest\Department\DepartmentResourceFactory::class,
            \User\V1\Service\Department::class => \User\V1\Service\DepartmentFactory::class,
            \User\V1\Service\Listener\DepartmentEventListener::class => \User\V1\Service\Listener\DepartmentEventListenerFactory::class,
            \User\V1\Rest\Company\CompanyResource::class => \User\V1\Rest\Company\CompanyResourceFactory::class,
            \User\V1\Service\Company::class => \User\V1\Service\CompanyFactory::class,
            \User\V1\Service\Listener\CompanyEventListener::class => \User\V1\Service\Listener\CompanyEventListenerFactory::class,
            \User\V1\Rest\BusinessSector\BusinessSectorResource::class => \User\V1\Rest\BusinessSector\BusinessSectorResourceFactory::class,
            \User\V1\Service\BusinessSector::class => \User\V1\Service\BusinessSectorFactory::class,
            \User\V1\Service\Listener\BusinessSectorEventListener::class => \User\V1\Service\Listener\BusinessSectorEventListenerFactory::class,
        ],
        'abstract_factories' => [
            0 => \User\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'hydrators' => [
        'factories' => [
            'User\\Hydrator\\UserProfile' => \User\V1\Hydrator\UserProfileHydratorFactory::class,
            'User\\Hydrator\\UserActivatedLog' => \User\V1\Hydrator\UserActivatedLogHydratorFactory::class,
            'User\\Hydrator\\Registrar' => 'User\\V1\\Hydrator\\RegistrarHydratorFactory',
            'User\\Hydrator\\Position' => \User\V1\Hydrator\PositionHydratorFactory::class,
            'User\\Hydrator\\EmploymentType' => \User\V1\Hydrator\EmploymentTypeHydratorFactory::class,
            'User\\Hydrator\\Education' => \User\V1\Hydrator\EducationHydratorFactory::class,
            'User\\Hydrator\\UserDocument' => \User\V1\Hydrator\UserDocumentHydratorFactory::class,
            'User\\Hydrator\\UserRole' => \User\V1\Hydrator\UserRoleHydratorFactory::class,
            'User\\Hydrator\\UserAccess' => \User\V1\Hydrator\UserAccessHydratorFactory::class,
            'User\\Hydrator\\UserModule' => \User\V1\Hydrator\UserModuleHydratorFactory::class,
            'User\\Hydrator\\UserAcl' => \User\V1\Hydrator\UserAclHydratorFactory::class,
            'User\\Hydrator\\Branch' => \User\V1\Hydrator\BranchHydratorFactory::class,
            'User\\Hydrator\\Department' => \User\V1\Hydrator\DepartmentHydratorFactory::class,
            'User\\Hydrator\\Company' => \User\V1\Hydrator\CompanyHydratorFactory::class,
            'User\\Hydrator\\BusinessSector' => \User\V1\Hydrator\BusinessSectorHydratorFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            0 => __DIR__ . '/../view',
        ],
    ],
    'router' => [
        'routes' => [
            'user.rpc.signup' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/signup',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\Signup\\Controller',
                        'action' => 'signup',
                    ],
                ],
            ],
            'user.rest.profile' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/profile[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\Profile\\Controller',
                    ],
                ],
            ],
            'user.rpc.me' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/me',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\Me\\Controller',
                        'action' => 'me',
                    ],
                ],
            ],
            'user.rpc.user-activation' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/user/activation',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\UserActivation\\Controller',
                        'action' => 'activation',
                    ],
                ],
            ],
            'user.rpc.reset-password-confirm-email' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/resetpassword/email',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller',
                        'action' => 'resetPasswordConfirmEmail',
                    ],
                ],
            ],
            'user.rpc.reset-password-new-password' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/resetpassword/newpassword',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller',
                        'action' => 'resetPasswordNewPassword',
                    ],
                ],
            ],
            'user.rpc.auth-revoke' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/authrevoke',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\AuthRevoke\\Controller',
                        'action' => 'authRevoke',
                    ],
                ],
            ],
            'user.rpc.mobile-last-state' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/mobilestate',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\MobileLastState\\Controller',
                        'action' => 'mobileLastState',
                    ],
                ],
            ],
            'user.rpc.signed-out-user' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/signedoutuser',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\SignedOutUser\\Controller',
                        'action' => 'signedOutUser',
                    ],
                ],
            ],
            'user.rpc.renew-qr-code' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/renew-qr-code',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\RenewQRCode\\Controller',
                        'action' => 'renewQRCode',
                    ],
                ],
            ],
            'user.rpc.change-password' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/change-password',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\ChangePassword\\Controller',
                        'action' => 'changePassword',
                    ],
                ],
            ],
            'user.rpc.user-activated' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/user-activated',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\UserActivated\\Controller',
                        'action' => 'userActivated',
                    ],
                ],
            ],
            'user.rest.user-activated-log' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/user-activated-log[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\UserActivatedLog\\Controller',
                    ],
                ],
            ],
            'user.rpc.timezone-supported' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/timezone-supported',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\TimezoneSupported\\Controller',
                        'action' => 'timezoneSupported',
                    ],
                ],
            ],
            'user.rpc.google-auth' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/google-auth',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\GoogleAuth\\Controller',
                        'action' => 'googleAuth',
                    ],
                ],
            ],
            'user.rpc.facebook-auth' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/facebook-auth',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\FacebookAuth\\Controller',
                        'action' => 'facebookAuth',
                    ],
                ],
            ],
            'user.rest.position' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/position[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\Position\\Controller',
                    ],
                ],
            ],
            'user.rest.employment-type' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/employment-type[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\EmploymentType\\Controller',
                    ],
                ],
            ],
            'user.rest.education' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/education[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\Education\\Controller',
                    ],
                ],
            ],
            'user.rest.user-document' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/user-document[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\UserDocument\\Controller',
                    ],
                ],
            ],
            'user.rest.user-role' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/user-role[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\UserRole\\Controller',
                    ],
                ],
            ],
            'user.rest.user-access' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/user-access[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\UserAccess\\Controller',
                    ],
                ],
            ],
            'user.rest.user-module' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/user-module[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\UserModule\\Controller',
                    ],
                ],
            ],
            'user.rest.user-acl' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/user-acl[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\UserAcl\\Controller',
                    ],
                ],
            ],
            'user.rpc.user-acl-update' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/user-acl-update',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\UserAclUpdate\\Controller',
                        'action' => 'userAclUpdate',
                    ],
                ],
            ],
            'user.rpc.user-signature' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/user-signature',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\UserSignature\\Controller',
                        'action' => 'userSignature',
                    ],
                ],
            ],
            'user.rpc.get-mobile-acl' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/get-mobile-acl',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\GetMobileAcl\\Controller',
                        'action' => 'getMobileAcl',
                    ],
                ],
            ],
            'user.rest.branch' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/branch[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\Branch\\Controller',
                    ],
                ],
            ],
            'user.rest.department' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/department[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\Department\\Controller',
                    ],
                ],
            ],
            'user.rest.company' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/company[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\Company\\Controller',
                    ],
                ],
            ],
            'user.rest.business-sector' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/business-sector[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\BusinessSector\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'user.rpc.signup',
            1 => 'user.rest.profile',
            2 => 'user.rpc.me',
            3 => 'user.rpc.me',
            4 => 'user.rpc.user-activation',
            5 => 'user.rpc.reset-password-confirm-email',
            6 => 'user.rpc.reset-password-new-password',
            7 => 'user.rpc.auth-revoke',
            9 => 'user.rest.fake-gps-log',
            10 => 'user.rpc.mobile-last-state',
            11 => 'user.rpc.signed-out-user',
            13 => 'user.rpc.renew-qr-code',
            14 => 'user.rpc.change-password',
            15 => 'user.rpc.change-password',
            16 => 'user.rpc.change-password',
            17 => 'user.rpc.change-password',
            18 => 'user.rpc.change-password',
            19 => 'user.rpc.change-password',
            20 => 'user.rpc.user-activated',
            22 => 'user.rest.user-activated-log',
            23 => 'user.rpc.timezone-supported',
            24 => 'user.rest.holiday',
            25 => 'user.rpc.google-auth',
            26 => 'user.rpc.facebook-auth',
            36 => 'user.rest.position',
            37 => 'user.rest.employment-type',
            38 => 'user.rest.education',
            39 => 'user.rest.user-document',
            49 => 'user.rest.user-role',
            50 => 'user.rest.user-access',
            51 => 'user.rest.user-module',
            52 => 'user.rest.user-acl',
            53 => 'user.rpc.user-acl-update',
            56 => 'user.rpc.user-signature',
            57 => 'user.rpc.get-mobile-acl',
            58 => 'user.rest.branch',
            59 => 'user.rest.company',
            60 => 'user.rest.department',
            61 => 'user.rest.business-sector',
        ],
    ],
    'zf-rpc' => [
        'User\\V1\\Rpc\\Signup\\Controller' => [
            'service_name' => 'Signup',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.signup',
        ],
        'User\\V1\\Rpc\\Me\\Controller' => [
            'service_name' => 'Me',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user.rpc.me',
        ],
        'User\\V1\\Rpc\\UserActivation\\Controller' => [
            'service_name' => 'UserActivation',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.user-activation',
        ],
        'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller' => [
            'service_name' => 'ResetPasswordConfirmEmail',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.reset-password-confirm-email',
        ],
        'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller' => [
            'service_name' => 'ResetPasswordNewPassword',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.reset-password-new-password',
        ],
        'User\\V1\\Rpc\\AuthRevoke\\Controller' => [
            'service_name' => 'AuthRevoke',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.auth-revoke',
        ],
        'User\\V1\\Rpc\\MobileLastState\\Controller' => [
            'service_name' => 'MobileLastState',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.mobile-last-state',
        ],
        'User\\V1\\Rpc\\SignedOutUser\\Controller' => [
            'service_name' => 'SignedOutUser',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.signed-out-user',
        ],
        'User\\V1\\Rpc\\RenewQRCode\\Controller' => [
            'service_name' => 'RenewQRCode',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.renew-qr-code',
        ],
        '' => [
            'service_name' => 'ChangePassword',
            'http_methods' => [
                0 => 'GET',
                1 => 'GET',
                2 => 'GET',
                3 => 'GET',
                4 => 'GET',
            ],
            'route_name' => 'user.rpc.change-password',
        ],
        'User\\V1\\Rpc\\ChangePassword\\Controller' => [
            'service_name' => 'ChangePassword',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.change-password',
        ],
        'User\\V1\\Rpc\\UserActivated\\Controller' => [
            'service_name' => 'UserActivated',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.user-activated',
        ],
        'User\\V1\\Rpc\\TimezoneSupported\\Controller' => [
            'service_name' => 'TimezoneSupported',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user.rpc.timezone-supported',
        ],
        'User\\V1\\Rpc\\GoogleAuth\\Controller' => [
            'service_name' => 'GoogleAuth',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.google-auth',
        ],
        'User\\V1\\Rpc\\FacebookAuth\\Controller' => [
            'service_name' => 'FacebookAuth',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.facebook-auth',
        ],
        'User\\V1\\Rpc\\UserAclUpdate\\Controller' => [
            'service_name' => 'UserAclUpdate',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.user-acl-update',
        ],
        'User\\V1\\Rpc\\UserSignature\\Controller' => [
            'service_name' => 'UserSignature',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.user-signature',
        ],
        'User\\V1\\Rpc\\GetMobileAcl\\Controller' => [
            'service_name' => 'GetMobileAcl',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user.rpc.get-mobile-acl',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'User\\V1\\Rpc\\Signup\\Controller' => 'Json',
            'User\\V1\\Rest\\Profile\\Controller' => 'HalJson',
            'User\\V1\\Rpc\\Me\\Controller' => 'HalJson',
            'User\\V1\\Rpc\\UserActivation\\Controller' => 'Json',
            'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller' => 'Json',
            'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller' => 'Json',
            'User\\V1\\Rpc\\AuthRevoke\\Controller' => 'Json',
            'User\\V1\\Rpc\\MobileLastState\\Controller' => 'Json',
            'User\\V1\\Rpc\\SignedOutUser\\Controller' => 'Json',
            'User\\V1\\Rpc\\RenewQRCode\\Controller' => 'Json',
            '' => 'Json',
            'User\\V1\\Rpc\\ChangePassword\\Controller' => 'Json',
            'User\\V1\\Rpc\\UserActivated\\Controller' => 'Json',
            'User\\V1\\Rest\\UserActivatedLog\\Controller' => 'HalJson',
            'User\\V1\\Rpc\\TimezoneSupported\\Controller' => 'Json',
            'User\\V1\\Rest\\Holiday\\Controller' => 'HalJson',
            'User\\V1\\Rpc\\GoogleAuth\\Controller' => 'Json',
            'User\\V1\\Rpc\\FacebookAuth\\Controller' => 'Json',
            'User\\V1\\Rest\\Position\\Controller' => 'HalJson',
            'User\\V1\\Rest\\EmploymentType\\Controller' => 'HalJson',
            'User\\V1\\Rest\\Education\\Controller' => 'HalJson',
            'User\\V1\\Rest\\UserDocument\\Controller' => 'HalJson',
            'User\\V1\\Rest\\UserRole\\Controller' => 'HalJson',
            'User\\V1\\Rest\\UserAccess\\Controller' => 'HalJson',
            'User\\V1\\Rest\\UserModule\\Controller' => 'HalJson',
            'User\\V1\\Rest\\UserAcl\\Controller' => 'HalJson',
            'User\\V1\\Rpc\\UserAclUpdate\\Controller' => 'Json',
            'User\\V1\\Rpc\\UserSignature\\Controller' => 'Json',
            'User\\V1\\Rpc\\GetMobileAcl\\Controller' => 'Json',
            'Vehicle\\V1\\Rest\\Branch\\Controller' => 'HalJson',
            'User\\V1\\Rest\\Branch\\Controller' => 'HalJson',
            'User\\V1\\Rest\\Company\\Controller' => 'HalJson',
            'User\\V1\\Rest\\Department\\Controller' => 'HalJson',
            'User\\V1\\Rest\\BusinessSector\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'User\\V1\\Rpc\\Signup\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rest\\Profile\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
                2 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rpc\\Me\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rpc\\UserActivation\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rpc\\AuthRevoke\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
            'User\\V1\\Rpc\\MobileLastState\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
            'User\\V1\\Rpc\\SignedOutUser\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
            'User\\V1\\Rpc\\RenewQRCode\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            '' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
                3 => 'application/vnd.user.v1+json',
                4 => 'application/json',
                5 => 'application/*+json',
                6 => 'application/vnd.user.v1+json',
                7 => 'application/json',
                8 => 'application/*+json',
                9 => 'application/vnd.user.v1+json',
                10 => 'application/json',
                11 => 'application/*+json',
                12 => 'application/vnd.user.v1+json',
                13 => 'application/json',
                14 => 'application/*+json',
            ],
            'User\\V1\\Rpc\\ChangePassword\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'User\\V1\\Rpc\\UserActivated\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'User\\V1\\Rest\\UserActivatedLog\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'User\\V1\\Rpc\\TimezoneSupported\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'User\\V1\\Rest\\Holiday\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'User\\V1\\Rpc\\GoogleAuth\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
            'User\\V1\\Rpc\\FacebookAuth\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'User\\V1\\Rest\\Position\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\EmploymentType\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\Education\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\UserDocument\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\UserRole\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\UserAccess\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\UserModule\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\UserAcl\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rpc\\UserAclUpdate\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
            'User\\V1\\Rpc\\UserSignature\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'User\\V1\\Rpc\\GetMobileAcl\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
            'User\\V1\\Rest\\Branch\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\Department\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\Company\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\BusinessSector\\Controller' => [
                0 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'User\\V1\\Rpc\\Signup\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1.json',
            ],
            'User\\V1\\Rest\\Profile\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
                2 => 'application/hal+json',
                3 => 'multipart/form-data',
            ],
            'User\\V1\\Rpc\\Me\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rpc\\UserActivation\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rpc\\AuthRevoke\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rpc\\MobileLastState\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rpc\\SignedOutUser\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rpc\\RenewQRCode\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            '' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/vnd.user.v1+json',
                3 => 'application/json',
                4 => 'application/vnd.user.v1+json',
                5 => 'application/json',
                6 => 'application/vnd.user.v1+json',
                7 => 'application/json',
                8 => 'application/vnd.user.v1+json',
                9 => 'application/json',
            ],
            'User\\V1\\Rpc\\ChangePassword\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rpc\\UserActivated\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\UserActivatedLog\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rpc\\TimezoneSupported\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rpc\\GoogleAuth\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rpc\\FacebookAuth\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\Position\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rest\\EmploymentType\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rest\\Education\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rest\\UserDocument\\Controller' => [
                0 => 'application/json',
                1 => 'multipart/form-data',
            ],
            'User\\V1\\Rest\\UserRole\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rest\\UserAccess\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rest\\UserModule\\Controller' => [
                0 => 'application/json',
                1 => 'multipart/form-data',
            ],
            'User\\V1\\Rest\\UserAcl\\Controller' => [
                0 => 'application/json',
                1 => 'multipart/form-data',
            ],
            'User\\V1\\Rpc\\UserAclUpdate\\Controller' => [
                0 => 'application/json',
                1 => 'multipart/form-data',
            ],
            'User\\V1\\Rpc\\UserSignature\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'multipart/form-data',
            ],
            'User\\V1\\Rpc\\GetMobileAcl\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rest\\Branch\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rest\\Department\\Controller' => [
                0 => 'application/json',
            ],
            'User\\V1\\Rest\\Company\\Controller' => [
                0 => 'application/json',
                1 => 'multipart/form-data',
            ],
        ],
    ],
    'zf-content-validation' => [
        'User\\V1\\Rpc\\Signup\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\Signup\\Validator',
        ],
        'User\\V1\\Rest\\Profile\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\Profile\\Validator',
        ],
        'User\\V1\\Rpc\\UserActivation\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\UserActivation\\Validator',
        ],
        'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Validator',
        ],
        'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\ResetPasswordNewPassword\\Validator',
        ],
        'User\\V1\\Rpc\\MobileLastState\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\MobileLastState\\Validator',
        ],
        'User\\V1\\Rpc\\ChangePassword\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\ChangePassword\\Validator',
        ],
        'User\\V1\\Rpc\\UserActivated\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\UserActivated\\Validator',
        ],
        'User\\V1\\Rpc\\GoogleAuth\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\GoogleAuth\\Validator',
        ],
        'User\\V1\\Rpc\\FacebookAuth\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\FacebookAuth\\Validator',
        ],
        'User\\V1\\Rest\\Position\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\Position\\Validator',
        ],
        'User\\V1\\Rest\\EmploymentType\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\EmploymentType\\Validator',
        ],
        'User\\V1\\Rest\\Education\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\Education\\Validator',
        ],
        'User\\V1\\Rest\\UserDocument\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\UserDocument\\Validator',
        ],
        'User\\V1\\Rest\\UserRole\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\UserRole\\Validator',
        ],
        'User\\V1\\Rest\\UserAccess\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\UserAccess\\Validator',
        ],
        'User\\V1\\Rest\\UserModule\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\UserModule\\Validator',
        ],
        'User\\V1\\Rest\\UserAcl\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\UserAcl\\Validator',
        ],
        'User\\V1\\Rpc\\UserAclUpdate\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\UserAclUpdate\\Validator',
        ],
        'User\\V1\\Rpc\\UserSignature\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\UserSignature\\Validator',
        ],
        'User\\V1\\Rest\\Branch\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\Branch\\Validator',
        ],
        'User\\V1\\Rest\\Department\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\Department\\Validator',
        ],
        'User\\V1\\Rest\\Company\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\Company\\Validator',
        ],
        'User\\V1\\Rest\\BusinessSector\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\BusinessSector\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'User\\V1\\Rpc\\Signup\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\EmailAddress::class,
                        'options' => [
                            'message' => 'Email Address Required',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'email',
                'description' => 'Email Address',
                'field_type' => 'email',
                'error_message' => 'Email Address Required',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\Alnum::class,
                        'options' => [
                            'message' => 'Password should contain alpha numeric string',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '8',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'password',
                'description' => 'User Password',
                'field_type' => 'password',
                'error_message' => 'Password length at least 6 character with alphanumeric format',
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'firstName',
            ],
            3 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'lastName',
            ],
            4 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'icNumber',
            ],
            5 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'phone',
            ],
            6 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'address',
            ],
            7 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'state',
            ],
            8 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'longitude',
            ],
            9 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'latitude',
            ],
            10 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'dob',
            ],
            11 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'district',
            ],
            12 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'gender',
            ],
        ],
        'User\\V1\\Rest\\Profile\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '64',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'firstName',
                'description' => 'First Name',
                'field_type' => 'String',
                'error_message' => 'First Name Required',
            ],
            1 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '64',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'lastName',
                'description' => 'Last Name',
                'field_type' => 'String',
            ],
            2 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Date::class,
                        'options' => [
                            'format' => 'Y-m-d',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'dob',
            ],
            3 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '128',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripNewlines::class,
                        'options' => [],
                    ],
                ],
                'name' => 'address',
                'description' => 'Address',
                'error_message' => 'Address Required',
            ],
            4 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '64',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripNewlines::class,
                        'options' => [],
                    ],
                ],
                'name' => 'city',
                'description' => 'City',
                'error_message' => 'City Required',
            ],
            5 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripNewlines::class,
                        'options' => [],
                    ],
                ],
                'name' => 'province',
                'description' => 'Province',
                'error_message' => 'Province Required',
            ],
            6 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\PostCode::class,
                        'options' => [
                            'message' => 'Postal code should be 5 digit numeric characters',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\Digits::class,
                        'options' => [],
                    ],
                ],
                'name' => 'postalCode',
                'description' => 'Postal Code',
                'error_message' => 'Postal Code Required',
            ],
            7 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '2',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripNewlines::class,
                        'options' => [],
                    ],
                ],
                'name' => 'country',
                'description' => 'Country',
            ],
            8 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'extension' => 'png, jpg, jpeg',
                            'message' => 'File extension not match',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'mimeType' => 'image/png, image/jpeg',
                            'message' => 'File type extension not match',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'use_upload_extension' => true,
                            'randomize' => true,
                            'target' => 'data/photo',
                        ],
                    ],
                ],
                'name' => 'photo',
                'description' => 'Photo',
                'field_type' => 'File',
                'type' => \Zend\InputFilter\FileInput::class,
                'error_message' => 'Photo is not valid',
            ],
            9 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '10',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'gender',
            ],
            10 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '50',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\I18n\Filter\Alpha::class,
                        'options' => [],
                    ],
                ],
                'name' => 'identityType',
            ],
            11 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\I18n\Filter\Alnum::class,
                        'options' => [],
                    ],
                ],
                'name' => 'identityNumber',
            ],
            12 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '32',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'role',
            ],
            13 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\EmailAddress::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'email',
            ],
            14 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\Alnum::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '8',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'password',
            ],
            15 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '50',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'bloodType',
            ],
            16 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '64',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'mobile',
            ],
            17 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '50',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'nationality',
            ],
            18 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '64',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'phone',
            ],
            19 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'relation',
            ],
            20 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\I18n\Filter\Alnum::class,
                        'options' => [
                            'allow_white_space' => true,
                        ],
                    ],
                ],
                'name' => 'unit',
            ],
            21 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '255',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'username',
            ],
            22 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'billingCategory',
            ],
            23 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'locationGroup',
            ],
            24 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'hospital',
            ],
            25 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'branch',
            ],
            26 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'department',
            ],
            27 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'leaveQuota',
            ],
            28 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '64',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'nickName',
            ],
            29 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'company',
            ],
            30 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Date::class,
                        'options' => [
                            'format' => 'Y-m-d',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'firstDate',
            ],
            31 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '64',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'pob',
            ],
            32 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '32',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'maritalStatus',
            ],
            33 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '32',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'drivingLicence',
            ],
            34 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '128',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripNewlines::class,
                        'options' => [],
                    ],
                ],
                'name' => 'addressCurrent',
            ],
            35 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '64',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'workphone',
            ],
            36 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\EmailAddress::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'workemail',
            ],
            37 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '64',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'relationPrimaryName',
            ],
            38 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '64',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'relationPrimaryPhone',
            ],
            39 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '32',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'relationshipPrimary',
            ],
            40 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '64',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'relationSecondaryName',
            ],
            41 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '64',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'relationSecondaryPhone',
            ],
            42 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '64',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'relationshipSecondary',
            ],
            43 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '45',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'jobDesk',
            ],
            44 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'message' => 'File extension not match',
                            'extension' => 'pdf, png, jpg, jpeg',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'message' => 'File type extension not match',
                            'mimeType' => 'application/pdf, image/png, image/jpeg',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'randomize' => true,
                            'use_upload_extension' => true,
                            'target' => 'data/doc/user-document',
                        ],
                    ],
                ],
                'name' => 'doc1',
            ],
            45 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'type1',
            ],
            46 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'note1',
            ],
            47 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'educations',
            ],
            48 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'message' => 'File extension not match',
                            'extension' => 'pdf, png, jpg, jpeg',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'message' => 'File type extension not match',
                            'mimeType' => 'application/pdf, image/png, image/jpeg',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'randomize' => true,
                            'use_upload_extension' => true,
                            'target' => 'data/doc/user-document',
                        ],
                    ],
                ],
                'name' => 'doc2',
            ],
            49 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'type2',
            ],
            50 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'note2',
            ],
            51 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'message' => 'File extension not match',
                            'extension' => 'pdf, png, jpg, jpeg',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'message' => 'File type extension not match',
                            'mimeType' => 'application/pdf, image/png, image/jpeg',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'randomize' => true,
                            'use_upload_extension' => true,
                            'target' => 'data/doc/user-document',
                        ],
                    ],
                ],
                'name' => 'doc3',
            ],
            52 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'type3',
            ],
            53 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'note3',
            ],
            54 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'message' => 'File extension not match',
                            'extension' => 'pdf, png, jpg, jpeg',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'message' => 'File type extension not match',
                            'mimeType' => 'application/pdf, image/png, image/jpeg',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'randomize' => true,
                            'use_upload_extension' => true,
                            'target' => 'data/doc/user-document',
                        ],
                    ],
                ],
                'name' => 'doc4',
            ],
            55 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'type4',
            ],
            56 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'note4',
            ],
            57 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'message' => 'File extension not match',
                            'extension' => 'pdf, png, jpg, jpeg',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'message' => 'File type extension not match',
                            'mimeType' => 'application/pdf, image/png, image/jpeg',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'randomize' => true,
                            'use_upload_extension' => true,
                            'target' => 'data/doc/user-document',
                        ],
                    ],
                ],
                'name' => 'doc5',
            ],
            58 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'type5',
            ],
            59 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'note5',
            ],
            60 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'position',
            ],
            61 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'employmentType',
            ],
            62 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '16',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'icNumber',
            ],
            63 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'parent',
            ],
            64 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'message' => 'File type extension not match',
                            'mimeType' => 'image/png, image/jpeg',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'extension' => 'png, jpg, jpeg',
                            'message' => 'File extension not match',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'randomize' => true,
                            'target' => 'data/photo',
                            'use_upload_extension' => true,
                        ],
                    ],
                ],
                'name' => 'signature',
                'type' => \Zend\InputFilter\FileInput::class,
            ],
        ],
        'User\\V1\\Rpc\\UserActivation\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'activationUuid',
                'description' => 'Activation UUID',
                'error_message' => 'Activation UUID required',
            ],
        ],
        'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\EmailAddress::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'emailAddress',
            ],
        ],
        'User\\V1\\Rpc\\ResetPasswordNewPassword\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'resetPasswordKey',
                'description' => 'Reset Password Key',
                'error_message' => 'Reset Password Key Not Valid',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '8',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'newPassword',
                'description' => 'New Password',
                'error_message' => 'New password should be minimum 8 characters',
            ],
            2 => [
                'required' => true,
                'validators' => [
                    1 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '8',
                        ],
                    ],
                    2 => [
                        'name' => \Zend\Validator\Identical::class,
                        'options' => [
                            'token' => 'newPassword',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'confirmNewPassword',
                'description' => 'Confirm New Password',
                'error_message' => 'Confirm new password not valid',
            ],
        ],
        'User\\V1\\Rpc\\MobileLastState\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'androidLastState',
                'allow_empty' => false,
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'androidLastParam',
                'allow_empty' => true,
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'androidDeviceId',
                'description' => 'Android Device ID',
                'field_type' => 'string',
                'error_message' => 'Android Device ID not valid',
            ],
            3 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'firebaseId',
                'allow_empty' => false,
            ],
            4 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'iosDeviceToken',
            ],
        ],
        'User\\V1\\Rpc\\ChangePassword\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\Alnum::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '8',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'currentPassword',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\Alnum::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '8',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'newPassword',
            ],
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\Alnum::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '8',
                        ],
                    ],
                    2 => [
                        'name' => \Zend\Validator\Identical::class,
                        'options' => [
                            'token' => 'newPassword',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'confirmPassword',
            ],
        ],
        'User\\V1\\Rpc\\UserActivated\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Digits::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'isActive',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'uuid',
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'note',
            ],
        ],
        'User\\V1\\Rpc\\GoogleAuth\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'idToken',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'accessToken',
            ],
        ],
        'User\\V1\\Rpc\\FacebookAuth\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'accessToken',
            ],
        ],
        'User\\V1\\Rest\\Position\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'name',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'note',
            ],
        ],
        'User\\V1\\Rest\\EmploymentType\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'name',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'note',
            ],
        ],
        'User\\V1\\Rest\\Education\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'levelEducation',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'schoolName',
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'graduatedYear',
            ],
            3 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'user_uuid',
            ],
        ],
        'User\\V1\\Rest\\UserDocument\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'user',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'type',
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'note',
            ],
            3 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'message' => 'File extension not match',
                            'extension' => 'pdf, jpg, jpeg, png',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'message' => 'File type extension not match',
                            'mimeType' => 'application/pdf, image/png, image/jpeg',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'randomize' => true,
                            'use_upload_extension' => true,
                            'target' => 'data/doc/user-document',
                        ],
                    ],
                ],
                'name' => 'doc',
            ],
        ],
        'User\\V1\\Rest\\UserRole\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'name',
            ],
            1 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'parent',
            ],
        ],
        'User\\V1\\Rest\\UserAccess\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'userProfile',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'userRole',
            ],
        ],
        'User\\V1\\Rest\\UserModule\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'name',
            ],
            1 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'parent',
            ],
            2 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'extension' => 'png, jpg, jpeg',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'mimeType' => 'image/png, image/jpeg',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'randomize' => true,
                            'use_upload_extension' => true,
                            'target' => 'data/photo/icon-module',
                        ],
                    ],
                ],
                'name' => 'photo',
            ],
        ],
        'User\\V1\\Rest\\UserAcl\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'dataAcl',
            ],
        ],
        'User\\V1\\Rpc\\UserAclUpdate\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'dataAcl',
            ],
        ],
        'User\\V1\\Rpc\\UserSignature\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'profile',
                'description' => '',
            ],
            1 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'message' => 'File type extension not match',
                            'mimeType' => 'image/png, image/jpeg',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'extension' => 'png, jpg, jpeg',
                            'message' => 'File extension not match',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'randomize' => true,
                            'use_upload_extension' => true,
                            'target' => 'data/photo/signature',
                        ],
                    ],
                ],
                'name' => 'signature',
            ],
        ],
        'User\\V1\\Rpc\\SignatureUpdate\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'profile',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'message' => 'File type extension not match',
                            'mimeType' => 'image/png, image/jpeg',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'extension' => 'png, jpg, jpeg',
                            'message' => 'File extension not match',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'randomize' => true,
                            'use_upload_extension' => true,
                        ],
                    ],
                ],
                'name' => 'signature',
            ],
        ],
        'User\\V1\\Rest\\Branch\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'name',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'account',
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'exchangeId',
            ],
            3 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'note',
            ],
            4 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'address',
            ],
            5 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'phone',
            ],
            6 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'fax',
            ],
            7 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'email',
            ],
            8 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'extPhone',
            ],
            9 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'company',
            ],
            10 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'isActive',
            ],
            11 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'latitude',
            ],
            12 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'longitude',
            ],
            13 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'geofence',
            ],
            14 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'geofenceRadius',
            ],
        ],
        'User\\V1\\Rest\\Department\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'name',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'note',
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'phone',
            ],
            3 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'extPhone',
            ],
            4 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'fax',
            ],
            5 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'email',
            ],
            6 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'company',
            ],
            7 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'branch',
            ],
            8 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'isActive',
            ],
        ],
        'User\\V1\\Rest\\Company\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'name',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'address',
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'phone',
            ],
            3 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'extPhone',
            ],
            4 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'fax',
            ],
            5 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'registrationId',
            ],
            6 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'taxId',
            ],
            7 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'about',
            ],
            8 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'email',
            ],
            9 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'isActive',
            ],
            10 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'isHq',
            ],
            11 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'extension' => 'png, jpg, jpeg',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'mimeType' => 'image/png, image/jpeg',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'randomize' => true,
                            'use_upload_extension' => true,
                            'target' => 'data/photo/company',
                        ],
                    ],
                ],
                'name' => 'photo',
            ],
            12 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'businessSector',
            ],
        ],
        'User\\V1\\Rest\\BusinessSector\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'name',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'note',
            ],
        ],
    ],
    'zf-rest' => [
        'User\\V1\\Rest\\Profile\\Controller' => [
            'listener' => \User\V1\Rest\Profile\ProfileResource::class,
            'route_name' => 'user.rest.profile',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'profile',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'DELETE',
                2 => 'PATCH',
                3 => 'PUT',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'role',
                1 => 'search',
                2 => 'active',
                3 => 'order',
                4 => 'ascending',
                5 => 'parent',
                6 => 'address',
                7 => 'branch_uuid',
                8 => 'department_uuid',
                9 => 'company_uuid',
                10 => 'position_uuid',
                11 => 'employment_type_uuid',
                12 => 'email',
                13 => 'username',
                14 => 'parent_uuid',
                15 => 'account',
                16 => 'search_employee',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\UserProfile::class,
            'collection_class' => \User\V1\Rest\Profile\ProfileCollection::class,
            'service_name' => 'Profile',
        ],
        'User\\V1\\Rest\\UserActivatedLog\\Controller' => [
            'listener' => \User\V1\Rest\UserActivatedLog\UserActivatedLogResource::class,
            'route_name' => 'user.rest.user-activated-log',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'userActivatedLog',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'DELETE',
                3 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
                2 => 'user_profile_uuid',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\UserActivatedLog::class,
            'collection_class' => \User\V1\Rest\UserActivatedLog\UserActivatedLogCollection::class,
            'service_name' => 'UserActivatedLog',
        ],
        'User\\V1\\Rest\\Position\\Controller' => [
            'listener' => \User\V1\Rest\Position\PositionResource::class,
            'route_name' => 'user.rest.position',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'position',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\Position::class,
            'collection_class' => \User\V1\Rest\Position\PositionCollection::class,
            'service_name' => 'Position',
        ],
        'User\\V1\\Rest\\EmploymentType\\Controller' => [
            'listener' => \User\V1\Rest\EmploymentType\EmploymentTypeResource::class,
            'route_name' => 'user.rest.employment-type',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'employment_type',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\EmploymentType::class,
            'collection_class' => \User\V1\Rest\EmploymentType\EmploymentTypeCollection::class,
            'service_name' => 'EmploymentType',
        ],
        'User\\V1\\Rest\\UserDocument\\Controller' => [
            'listener' => \User\V1\Rest\UserDocument\UserDocumentResource::class,
            'route_name' => 'user.rest.user-document',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'user_document',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
                2 => 'type',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\UserDocument::class,
            'collection_class' => \User\V1\Rest\UserDocument\UserDocumentCollection::class,
            'service_name' => 'UserDocument',
        ],
        'User\\V1\\Rest\\UserRole\\Controller' => [
            'listener' => \User\V1\Rest\UserRole\UserRoleResource::class,
            'route_name' => 'user.rest.user-role',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'user_role',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
                2 => 'name',
                3 => 'account',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\UserRole::class,
            'collection_class' => \User\V1\Rest\UserRole\UserRoleCollection::class,
            'service_name' => 'UserRole',
        ],
        'User\\V1\\Rest\\UserAccess\\Controller' => [
            'listener' => \User\V1\Rest\UserAccess\UserAccessResource::class,
            'route_name' => 'user.rest.user-access',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'user_access',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
                2 => 'user_profile_uuid',
                3 => 'user_role_uuid',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\UserAccess::class,
            'collection_class' => \User\V1\Rest\UserAccess\UserAccessCollection::class,
            'service_name' => 'UserAccess',
        ],
        'User\\V1\\Rest\\UserModule\\Controller' => [
            'listener' => \User\V1\Rest\UserModule\UserModuleResource::class,
            'route_name' => 'user.rest.user-module',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'user_module',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\UserModule::class,
            'collection_class' => \User\V1\Rest\UserModule\UserModuleCollection::class,
            'service_name' => 'UserModule',
        ],
        'User\\V1\\Rest\\UserAcl\\Controller' => [
            'listener' => \User\V1\Rest\UserAcl\UserAclResource::class,
            'route_name' => 'user.rest.user-acl',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'user_acl',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
                2 => 'user_role_uuid',
                3 => 'user_module_uuid',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\UserAcl::class,
            'collection_class' => \User\V1\Rest\UserAcl\UserAclCollection::class,
            'service_name' => 'UserAcl',
        ],
        'User\\V1\\Rest\\Branch\\Controller' => [
            'listener' => \User\V1\Rest\Branch\BranchResource::class,
            'route_name' => 'user.rest.branch',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'branch',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
                2 => 'exchange_id',
                3 => 'company_uuid',
                4 => 'is_active',
                5 => 'name',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\Branch::class,
            'collection_class' => \User\V1\Rest\Branch\BranchCollection::class,
            'service_name' => 'Branch',
        ],
        'User\\V1\\Rest\\Department\\Controller' => [
            'listener' => \User\V1\Rest\Department\DepartmentResource::class,
            'route_name' => 'user.rest.department',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'department',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
                2 => 'is_active',
                3 => 'company_uuid',
                4 => 'branch_uuid',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\Department::class,
            'collection_class' => \User\V1\Rest\Department\DepartmentCollection::class,
            'service_name' => 'Department',
        ],
        'User\\V1\\Rest\\Company\\Controller' => [
            'listener' => \User\V1\Rest\Company\CompanyResource::class,
            'route_name' => 'user.rest.company',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'company',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
                2 => 'name',
                3 => 'is_active',
                4 => 'business_sector_uuid',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\Company::class,
            'collection_class' => \User\V1\Rest\Company\CompanyCollection::class,
            'service_name' => 'Company',
        ],
        'User\\V1\\Rest\\BusinessSector\\Controller' => [
            'listener' => \User\V1\Rest\BusinessSector\BusinessSectorResource::class,
            'route_name' => 'user.rest.business-sector',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'business_sector',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\BusinessSector::class,
            'collection_class' => \User\V1\Rest\BusinessSector\BusinessSectorCollection::class,
            'service_name' => 'BusinessSector',
        ],
        'User\\V1\\Rest\\Education\\Controller' => [
            'listener' => \User\V1\Rest\Education\EducationResource::class,
            'route_name' => 'user.rest.education',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'education',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
                2 => 'user_uuid',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\Education::class,
            'collection_class' => \User\V1\Rest\Education\EducationCollection::class,
            'service_name' => 'Education',
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \User\V1\Rest\Profile\ProfileCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.profile',
                'route_identifier_name' => 'uuid',
                'is_collection' => true,
            ],
            \User\V1\Rpc\Me\MeEntity::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rpc.me',
                'route_identifier_name' => 'profile_id',
                'hydrator' => 'User\\Hydrator\\UserProfile',
            ],
            'User\\V1\\Rest\\Users\\UsersEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.users',
                'route_identifier_name' => 'users_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\Entity\UserProfile::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.profile',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\UserProfile',
            ],
            'User\\V1\\Rest\\UserActivatedLog\\UserActivatedLogEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-activated-log',
                'route_identifier_name' => 'user_activated_log_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\UserActivatedLog\UserActivatedLogCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-activated-log',
                'route_identifier_name' => 'user_activated_log_id',
                'is_collection' => true,
            ],
            \User\Entity\UserActivatedLog::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.user-activated-log',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\UserActivatedLog',
            ],
            \User\V1\Rest\Position\PositionEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.position',
                'route_identifier_name' => 'position_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\Position\PositionCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.position',
                'route_identifier_name' => 'position_id',
                'is_collection' => true,
            ],
            \User\Entity\Position::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.position',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\Position',
            ],
            \User\V1\Rest\EmploymentType\EmploymentTypeEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.employment-type',
                'route_identifier_name' => 'employment_type_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\EmploymentType\EmploymentTypeCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.employment-type',
                'route_identifier_name' => 'employment_type_id',
                'is_collection' => true,
            ],
            \User\Entity\EmploymentType::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.employment-type',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\EmploymentType',
            ],
            \User\V1\Rest\Education\EducationEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.education',
                'route_identifier_name' => 'education_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\Education\EducationCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.education',
                'route_identifier_name' => 'education_id',
                'is_collection' => true,
            ],
            \User\Entity\Education::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.education',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\Education',
            ],
            \User\V1\Rest\UserDocument\UserDocumentEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-document',
                'route_identifier_name' => 'user_document_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\UserDocument\UserDocumentCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-document',
                'route_identifier_name' => 'user_document_id',
                'is_collection' => true,
            ],
            \User\Entity\UserDocument::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.user-document',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\UserDocument',
            ],
            \User\V1\Rest\UserRole\UserRoleEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-role',
                'route_identifier_name' => 'user_role_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\UserRole\UserRoleCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-role',
                'route_identifier_name' => 'user_role_id',
                'is_collection' => true,
            ],
            \User\Entity\UserRole::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.user-role',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\UserRole',
            ],
            \User\V1\Rest\UserAccess\UserAccessEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-access',
                'route_identifier_name' => 'user_access_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\UserAccess\UserAccessCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-access',
                'route_identifier_name' => 'user_access_id',
                'is_collection' => true,
            ],
            \User\Entity\UserAccess::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.user-access',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\UserAccess',
            ],
            \User\V1\Rest\UserModule\UserModuleEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-module',
                'route_identifier_name' => 'user_module_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\UserModule\UserModuleCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-module',
                'route_identifier_name' => 'user_module_id',
                'is_collection' => true,
            ],
            \User\Entity\UserModule::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.user-module',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\UserModule',
            ],
            \User\V1\Rest\UserAcl\UserAclEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-acl',
                'route_identifier_name' => 'user_acl_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\UserAcl\UserAclCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-acl',
                'route_identifier_name' => 'user_acl_id',
                'is_collection' => true,
            ],
            \User\Entity\UserAcl::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.user-acl',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\UserAcl',
            ],
            'User\\V1\\Rest\\Branch\\BranchEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.branch',
                'route_identifier_name' => 'branch_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\Branch\BranchCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.branch',
                'route_identifier_name' => 'branch_id',
                'is_collection' => true,
            ],
            \User\Entity\Branch::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.branch',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\Branch',
            ],
            \User\V1\Rest\Company\CompanyEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.company',
                'route_identifier_name' => 'company_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\Company\CompanyCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.company',
                'route_identifier_name' => 'company_id',
                'is_collection' => true,
            ],
            \User\V1\Rest\Department\DepartmentEntity::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.department',
                'route_identifier_name' => 'uuid',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\Department\DepartmentCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.department',
                'route_identifier_name' => 'uuid',
                'is_collection' => true,
            ],
            \User\Entity\Company::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.company',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\Company',
            ],
            \User\Entity\Department::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.department',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\Department',
            ],
            \User\V1\Rest\BusinessSector\BusinessSectorEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.business-sector',
                'route_identifier_name' => 'business_sector_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\BusinessSector\BusinessSectorCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.business-sector',
                'route_identifier_name' => 'business_sector_id',
                'is_collection' => true,
            ],
            \User\Entity\BusinessSector::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.business-sector',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\BusinessSector',
            ],

        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'User\\V1\\Rest\\Profile\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rpc\\Me\\Controller' => [
                'actions' => [
                    'me' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'User\\V1\\Rpc\\MobileLastState\\Controller' => [
                'actions' => [
                    'MobileLastState' => [
                        'GET' => false,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'User\\V1\\Rpc\\SignedOutUser\\Controller' => [
                'actions' => [
                    'SignedOutUser' => [
                        'GET' => false,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'User\\V1\\Rpc\\RenewQRCode\\Controller' => [
                'actions' => [
                    'RenewQRCode' => [
                        'GET' => false,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'User\\V1\\Rpc\\ChangePassword\\Controller' => [
                'actions' => [
                    'ChangePassword' => [
                        'GET' => false,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'User\\V1\\Rpc\\UserActivated\\Controller' => [
                'actions' => [
                    'UserActivated' => [
                        'GET' => false,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'User\\V1\\Rest\\UserActivatedLog\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rpc\\TimezoneSupported\\Controller' => [
                'actions' => [
                    'TimezoneSupported' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'User\\V1\\Rpc\\GoogleAuth\\Controller' => [
                'actions' => [
                    'googleAuth' => [
                        'GET' => false,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'User\\V1\\Rest\\Education\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rest\\UserDocument\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rest\\Position\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rest\\EmploymentType\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rest\\UserRole\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rest\\UserAccess\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rest\\UserModule\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rest\\UserAcl\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rpc\\UserAclUpdate\\Controller' => [
                'actions' => [
                    'userAclUpdate' => [
                        'GET' => false,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'User\\V1\\Rpc\\UserSignature\\Controller' => [
                'actions' => [
                    'userSignature' => [
                        'GET' => false,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'User\\V1\\Rest\\Branch\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rest\\Department\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rest\\Company\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rest\\BusinessSector\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'v1-send-welcome-email' => [
                    'options' => [
                        'route' => 'v1 user send-welcome-email <emailAddress> <activationCode>',
                        'defaults' => [
                            'controller' => \User\V1\Console\Controller\EmailController::class,
                            'action' => 'sendWelcomeEmail',
                        ],
                    ],
                ],
                'v1-send-activation-email' => [
                    'options' => [
                        'route' => 'v1 user send-activation-email <emailAddress>',
                        'defaults' => [
                            'controller' => \User\V1\Console\Controller\EmailController::class,
                            'action' => 'sendActivationEmail',
                        ],
                    ],
                ],
                'v1-send-resetpassword-email' => [
                    'options' => [
                        'route' => 'v1 user send-resetpassword-email <emailAddress> <resetPasswordKey>',
                        'defaults' => [
                            'controller' => \User\V1\Console\Controller\EmailController::class,
                            'action' => 'sendResetPasswordEmail',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
