<?php
return [
    \redis::class => [
        'host' => \redis::class,
        'port' => '6379',
        'password' => null,
    ],
    'zf-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'adapters' => [
            'zf3_mysql' => [
                'database' => 'xtend-api',
                'driver' => 'PDO_Mysql',
                'hostname' => 'mysql567',
                'username' => 'root',
                'password' => 'password',
                'port' => '3306',
                'dsn' => 'mysql:dbname=xtend-api;host=mysql567;charset=utf8',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authentication' => [
            'map' => [
                'User\\V1' => 'oauth2_pdo',
                'Visitor\\V1' => 'oauth2_pdo',
                'QRCode\\V1' => 'oauth2_pdo',
                'Facility\\V1' => 'oauth2_pdo',
                'Ad\\V1' => 'oauth2_pdo',
                'Complain\\V1' => 'oauth2_pdo',
                'Notification\\V1' => 'oauth2_pdo',
                'BroadcastMessage\\V1' => 'oauth2_pdo',
                'Location\\V1' => 'oauth2_pdo',
                'Security\\V1' => 'oauth2_pdo',
                'Panic\\V1' => 'oauth2_pdo',
                'Billing\\V1' => 'oauth2_pdo',
                'Payment\\V1' => 'oauth2_pdo',
                'Retribution\\V1' => 'oauth2_pdo',
                'Request\\V1' => 'oauth2_pdo',
                'Task\\V1' => 'oauth2_pdo',
                'Services\\V1' => 'oauth2_pdo',
                'Site\\V1' => 'oauth2_pdo',
                'Product\\V1' => 'oauth2_pdo',
                'Order\\V1' => 'oauth2_pdo',
                'Overtime\\V1' => 'oauth2_pdo',
                'Leave\\V1' => 'oauth2_pdo',
                'Department\\V1' => 'oauth2_pdo',
                'Vehicle\\V1' => 'oauth2_pdo',
                'Reimbursement\\V1' => 'oauth2_pdo',
                'Job\\V1' => 'oauth2_pdo',
                'Item\\V1' => 'oauth2_pdo',
                'Invoice\\V1' => 'oauth2_pdo',
                'Receipt\\V1' => 'oauth2_pdo',
                'Attendance\\V1' => 'oauth2_pdo',
                'Journal\\V1' => 'oauth2_pdo',
                'Stock\\V1' => 'oauth2_pdo',
            ],
            'adapters' => [
                'oauth2_pdo' => [
                    'adapter' => \ZF\MvcAuth\Authentication\OAuth2Adapter::class,
                    'storage' => [
                        'storage' => 'user.auth.pdo.adapter',
                    ],
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'oauth' => [
                'options' => [
                    'spec' => '%oauth%',
                    'regex' => '(?P<oauth>(/oauth))',
                ],
                'type' => 'regex',
            ],
        ],
    ],
];
