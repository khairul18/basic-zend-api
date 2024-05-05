<?php
return [
    'service_manager' => [
        'factories' => [
            \QRCode\V1\Rest\QRCode\QRCodeResource::class => \QRCode\V1\Rest\QRCode\QRCodeResourceFactory::class,
            \QRCode\V1\Service\QRCode::class => \QRCode\V1\Service\QRCodeFactory::class,
            \QRCode\V1\Service\Listener\QRCodeEventListener::class => \QRCode\V1\Service\Listener\QRCodeEventListenerFactory::class,
            \QRCode\V1\Service\Listener\QRCodeOwnerEventListener::class => \QRCode\V1\Service\Listener\QRCodeOwnerEventListenerFactory::class,
        ],
        'abstract_factories' => [
            0 => \QRCode\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'hydrators' => [
        'factories' => [
            'QRCode\\Hydrator\\QRCode' => \QRCode\V1\Hydrator\QRCodeHydratorFactory::class,
            'QRCode\\Hydrator\\QRCodeOwner' => \QRCode\V1\Hydrator\QRCodeOwnerHydratorFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'qr-code.rest.qr-code' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/qrcode[/:uuid]',
                    'defaults' => [
                        'controller' => 'QRCode\\V1\\Rest\\QRCode\\Controller',
                    ],
                ],
            ],
            'qr-code.rpc.generate-qr-code' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/generate-qr-code',
                    'defaults' => [
                        'controller' => 'QRCode\\V1\\Rpc\\GenerateQRCode\\Controller',
                        'action' => 'generateQRCode',
                    ],
                ],
            ],
            'qr-code.rpc.qr-code-validator' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/qr-code-validator',
                    'defaults' => [
                        'controller' => 'QRCode\\V1\\Rpc\\QRCodeValidator\\Controller',
                        'action' => 'qRCodeValidator',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'qr-code.rest.qr-code',
            1 => 'qr-code.rpc.generate-qr-code',
            2 => 'qr-code.rpc.qr-code-validator',
        ],
    ],
    'zf-rest' => [
        'QRCode\\V1\\Rest\\QRCode\\Controller' => [
            'listener' => \QRCode\V1\Rest\QRCode\QRCodeResource::class,
            'route_name' => 'qr-code.rest.qr-code',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'qrCode',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
                3 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'start_date',
                1 => 'limit',
                2 => 'available',
                3 => 'end_date',
            ],
            'page_size' => '25',
            'page_size_param' => 'limit',
            'entity_class' => \QRCode\Entity\QRCode::class,
            'collection_class' => \QRCode\V1\Rest\QRCode\QRCodeCollection::class,
            'service_name' => 'QRCode',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'QRCode\\V1\\Rest\\QRCode\\Controller' => 'HalJson',
            'QRCode\\V1\\Rpc\\GenerateQRCode\\Controller' => 'Json',
            'QRCode\\V1\\Rpc\\QRCodeValidator\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'QRCode\\V1\\Rest\\QRCode\\Controller' => [
                0 => 'application/vnd.qr-code.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'QRCode\\V1\\Rpc\\GenerateQRCode\\Controller' => [
                0 => 'application/vnd.qr-code.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'QRCode\\V1\\Rpc\\QRCodeValidator\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
        ],
        'content_type_whitelist' => [
            'QRCode\\V1\\Rest\\QRCode\\Controller' => [
                0 => 'application/vnd.qr-code.v1+json',
                1 => 'application/json',
            ],
            'QRCode\\V1\\Rpc\\GenerateQRCode\\Controller' => [
                0 => 'application/vnd.qr-code.v1+json',
                1 => 'application/json',
            ],
            'QRCode\\V1\\Rpc\\QRCodeValidator\\Controller' => [
                0 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \QRCode\V1\Rest\QRCode\QRCodeCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'qr-code.rest.qr-code',
                'route_identifier_name' => 'uuid',
                'is_collection' => true,
            ],
            \QRCode\Entity\QRCode::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'qr-code.rest.qr-code',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'QRCode\\Hydrator\\QRCode',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'QRCode\\V1\\Rest\\QRCode\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
            ],
            'QRCode\\V1\\Rpc\\GenerateQRCode\\Controller' => [
                'actions' => [
                    'GenerateQRCode' => [
                        'GET' => false,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'QRCode\\V1\\Rpc\\QRCodeValidator\\Controller' => [
                'actions' => [
                    'qRCodeValidator' => [
                        'GET' => false,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'QRCode\\V1\\Rpc\\GenerateQRCode\\Controller' => \QRCode\V1\Rpc\GenerateQRCode\GenerateQRCodeControllerFactory::class,
            'QRCode\\V1\\Rpc\\QRCodeValidator\\Controller' => \QRCode\V1\Rpc\QRCodeValidator\QRCodeValidatorControllerFactory::class,
        ],
    ],
    'zf-rpc' => [
        'QRCode\\V1\\Rpc\\GenerateQRCode\\Controller' => [
            'service_name' => 'GenerateQRCode',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'qr-code.rpc.generate-qr-code',
        ],
        'QRCode\\V1\\Rpc\\QRCodeValidator\\Controller' => [
            'service_name' => 'QRCodeValidator',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'qr-code.rpc.qr-code-validator',
        ],
    ],
    'zf-content-validation' => [
        'QRCode\\V1\\Rpc\\GenerateQRCode\\Controller' => [
            'input_filter' => 'QRCode\\V1\\Rpc\\GenerateQRCode\\Validator',
        ],
        'QRCode\\V1\\Rpc\\QRCodeValidator\\Controller' => [
            'input_filter' => 'QRCode\\V1\\Rpc\\QRCodeValidator\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'QRCode\\V1\\Rpc\\GenerateQRCode\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'units',
            ],
        ],
        'QRCode\\V1\\Rpc\\QRCodeValidator\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'qrCode',
            ],
        ],
    ],
];
