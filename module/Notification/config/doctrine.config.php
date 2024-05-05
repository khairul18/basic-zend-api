<?php
return [
    'doctrine' => [
        'driver' => [
            'notification_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/orm']
            ],
            'orm_default' => [
                'drivers' => [
                    'Notification\Entity' => 'notification_entity',
                ]
            ]
        ],
    ],
];
