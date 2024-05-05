<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014-2016 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Xtend;

return [
    'service_manager' => [
        'factories' => [
            \Xtend\Firebase\Service\Firebase::class => \Xtend\Firebase\Service\FirebaseFactory::class,
            \Xtend\Apns\Service\Apns::class  => \Xtend\Apns\Service\ApnsFactory::class,
            \Xtend\Email\Service\Email::class => \Xtend\Email\Service\EmailFactory::class,
            \Xtend\Zenziva\Service\Sms::class => \Xtend\Zenziva\Service\SmsFactory::class,
            \Xtend\Export\Service\CsvExport::class => \Xtend\Export\Service\CsvExportFactory::class,
            "\Xtend\Email\Service\PhpProcessBuilder" => \Xtend\Email\Service\PhpProcessFactory::class,
            "\Xtend\Zenziva\Service\PhpProcessBuilder" => \Xtend\Zenziva\Service\PhpProcessFactory::class,
            "\Xtend\Sms\Service\Sms" => \Xtend\GoSms\Service\SmsFactory::class,
            "\Xtend\GoSms\Service\PhpProcessBuilder" => \Xtend\GoSms\Service\PhpProcessFactory::class,
            "\Xtend\Manasik\Service\PhpProcessBuilder" => \Xtend\Manasik\Service\PhpProcessFactory::class
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'send-firebase-notification' => [
                    'options' => [
                        'route' => 'firebase send <firebaseId> <message>',
                        'defaults' => [
                            'controller' => \Xtend\Firebase\Console\Controller\NotificationController::class,
                            'action' => 'sendNotification',
                        ],
                    ],
                ],
                'apns-push' => [
                    'options' => [
                        'route' => 'apns send <deviceToken> <payload>',
                        'defaults' => [
                            'controller' => \Xtend\Apns\Console\Controller\NotificationController::class,
                            'action' => 'sendNotification',
                        ],
                    ],
                ],
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            \Xtend\Firebase\Console\Controller\NotificationController::class =>
                \Xtend\Firebase\Console\Controller\NotificationControllerFactory::class,
            \Xtend\Apns\Console\Controller\NotificationController::class =>
                \Xtend\Apns\Console\Controller\NotificationControllerFactory::class,
        ],
    ],
];
