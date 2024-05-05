<?php
return [
    'doctrine' => [
        'driver' => [
            'qrcode_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/orm']
            ],
            'orm_default' => [
                'drivers' => [
                    'QRCode\Entity' => 'qrcode_entity',
                ]
            ]
        ],
    ],
];
