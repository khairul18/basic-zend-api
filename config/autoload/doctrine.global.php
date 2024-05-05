<?php
return [
    'doctrine' => [
        'connection' => [
            // default connection name
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'host'     => 'mysql567',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => 'password',
                    'dbname'   => 'xtend-api',
                    'charset'  => 'utf8'
                ],
            ],
        ],
    ],
];
