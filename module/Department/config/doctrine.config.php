<?php
return [
    'doctrine' => [
        'driver' => [
            'department_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/orm']
            ],
            'orm_default' => [
                'drivers' => [
                    'Department\Entity' => 'department_entity',
                ]
            ]
        ],
    ],
];
