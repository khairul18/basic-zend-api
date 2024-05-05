<?php
return [
    'service_manager' => [
        'factories' => [
            \Department\V1\Rest\Department\DepartmentResource::class => \Department\V1\Rest\Department\DepartmentResourceFactory::class,
            \Department\V1\Service\Department::class => \Department\V1\Service\DepartmentFactory::class,
            \Department\V1\Service\Listener\DepartmentEventListener::class => \Department\V1\Service\Listener\DepartmentEventListenerFactory::class,
            \Department\V1\Rest\Company\CompanyResource::class => \Department\V1\Rest\Company\CompanyResourceFactory::class,
            \Department\V1\Service\Company::class => \Department\V1\Service\CompanyFactory::class,
            \Department\V1\Service\Listener\CompanyEventListener::class => \Department\V1\Service\Listener\CompanyEventListenerFactory::class,
            \Department\V1\Rest\Group\GroupResource::class => \Department\V1\Rest\Group\GroupResourceFactory::class,
            \Department\V1\Service\Group::class => \Department\V1\Service\GroupFactory::class,
            \Department\V1\Service\Listener\GroupEventListener::class => \Department\V1\Service\Listener\GroupEventListenerFactory::class,
            \Department\V1\Rest\GroupUser\GroupUserResource::class => \Department\V1\Rest\GroupUser\GroupUserResourceFactory::class,
            \Department\V1\Service\GroupUser::class => \Department\V1\Service\GroupUserFactory::class,
            \Department\V1\Service\Listener\GroupUserEventListener::class => \Department\V1\Service\Listener\GroupUserEventListenerFactory::class,
        ],
        'abstract_factories' => [
            0 => \Department\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'hydrators' => [
        'factories' => [
            'Department\\Hydrator\\Department' => \Department\V1\Hydrator\DepartmentHydratorFactory::class,
            'Department\\Hydrator\\Company' => \Department\V1\Hydrator\CompanyHydratorFactory::class,
            'Department\\Hydrator\\Group' => \Department\V1\Hydrator\GroupHydratorFactory::class,
            'Department\\Hydrator\\GroupUser' => \Department\V1\Hydrator\GroupUserHydratorFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'department.rest.department' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/department[/:uuid]',
                    'defaults' => [
                        'controller' => 'Department\\V1\\Rest\\Department\\Controller',
                    ],
                ],
            ],
            'department.rest.company' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/company[/:uuid]',
                    'defaults' => [
                        'controller' => 'Department\\V1\\Rest\\Company\\Controller',
                    ],
                ],
            ],
            'department.rpc.division-company' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/division-company',
                    'defaults' => [
                        'controller' => 'Department\\V1\\Rpc\\DivisionCompany\\Controller',
                        'action' => 'divisionCompany',
                    ],
                ],
            ],
            'department.rest.group' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/group[/:uuid]',
                    'defaults' => [
                        'controller' => 'Department\\V1\\Rest\\Group\\Controller',
                    ],
                ],
            ],
            'department.rest.group-user' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/group-user[/:uuid]',
                    'defaults' => [
                        'controller' => 'Department\\V1\\Rest\\GroupUser\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'department.rest.department',
            1 => 'department.rest.company',
            2 => 'department.rpc.division-company',
            3 => 'department.rest.group',
            4 => 'department.rest.group-user',
        ],
    ],
    'zf-rest' => [
        'Department\\V1\\Rest\\Department\\Controller' => [
            'listener' => \Department\V1\Rest\Department\DepartmentResource::class,
            'route_name' => 'department.rest.department',
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
            'entity_class' => \Department\Entity\Department::class,
            'collection_class' => \Department\V1\Rest\Department\DepartmentCollection::class,
            'service_name' => 'Department',
        ],
        'Department\\V1\\Rest\\Company\\Controller' => [
            'listener' => \Department\V1\Rest\Company\CompanyResource::class,
            'route_name' => 'department.rest.company',
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
            'entity_class' => \Department\Entity\Company::class,
            'collection_class' => \Department\V1\Rest\Company\CompanyCollection::class,
            'service_name' => 'Company',
        ],
        'Department\\V1\\Rest\\Group\\Controller' => [
            'listener' => \Department\V1\Rest\Group\GroupResource::class,
            'route_name' => 'department.rest.group',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'group',
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
                2 => 'account_uuid',
                3 => 'branch_uuid',
                4 => 'company_uuid',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \Department\Entity\Group::class,
            'collection_class' => \Department\V1\Rest\Group\GroupCollection::class,
            'service_name' => 'Group',
        ],
        'Department\\V1\\Rest\\GroupUser\\Controller' => [
            'listener' => \Department\V1\Rest\GroupUser\GroupUserResource::class,
            'route_name' => 'department.rest.group-user',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'group_user',
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
                2 => 'group_uuid',
                3 => 'user_profile_uuid',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \Department\Entity\GroupUser::class,
            'collection_class' => \Department\V1\Rest\GroupUser\GroupUserCollection::class,
            'service_name' => 'GroupUser',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Department\\V1\\Rest\\Department\\Controller' => 'HalJson',
            'Department\\V1\\Rest\\Company\\Controller' => 'HalJson',
            'Department\\V1\\Rpc\\DivisionCompany\\Controller' => 'Json',
            'Department\\V1\\Rest\\Group\\Controller' => 'HalJson',
            'Department\\V1\\Rest\\GroupUser\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Department\\V1\\Rest\\Department\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'Department\\V1\\Rest\\Company\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'Department\\V1\\Rpc\\DivisionCompany\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
            'Department\\V1\\Rest\\Group\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'Department\\V1\\Rest\\GroupUser\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Department\\V1\\Rest\\Department\\Controller' => [
                0 => 'application/json',
            ],
            'Department\\V1\\Rest\\Company\\Controller' => [
                0 => 'application/json',
                1 => 'multipart/form-data',
            ],
            'Department\\V1\\Rpc\\DivisionCompany\\Controller' => [
                0 => 'application/json',
            ],
            'Department\\V1\\Rest\\Group\\Controller' => [
                0 => 'application/json',
            ],
            'Department\\V1\\Rest\\GroupUser\\Controller' => [
                0 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Department\V1\Rest\Department\DepartmentEntity::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'department.rest.department',
                'route_identifier_name' => 'uuid',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Department\V1\Rest\Department\DepartmentCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'department.rest.department',
                'route_identifier_name' => 'uuid',
                'is_collection' => true,
            ],
            \Department\Entity\Department::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'department.rest.department',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Department\\Hydrator\\Department',
            ],
            \Department\V1\Rest\Company\CompanyEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'department.rest.company',
                'route_identifier_name' => 'company_id',
                'hydrator' => 'Department\\Hydrator\\Company',
            ],
            \Department\V1\Rest\Company\CompanyCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'department.rest.company',
                'route_identifier_name' => 'company_id',
                'is_collection' => true,
            ],
            \Department\Entity\Company::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'department.rest.company',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Department\\Hydrator\\Company',
            ],
            \Department\V1\Rest\Group\GroupEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'department.rest.group',
                'route_identifier_name' => 'group_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Department\V1\Rest\Group\GroupCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'department.rest.group',
                'route_identifier_name' => 'group_id',
                'is_collection' => true,
            ],
            \Department\Entity\Group::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'department.rest.group',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Department\\Hydrator\\Group',
            ],
            \Department\V1\Rest\GroupUser\GroupUserEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'department.rest.group-user',
                'route_identifier_name' => 'group_user_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Department\V1\Rest\GroupUser\GroupUserCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'department.rest.group-user',
                'route_identifier_name' => 'group_user_id',
                'is_collection' => true,
            ],
            \Department\Entity\GroupUser::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'department.rest.group-user',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Department\\Hydrator\\GroupUser',
            ],
        ],
    ],
    'zf-content-validation' => [
        'Department\\V1\\Rest\\Department\\Controller' => [
            'input_filter' => 'Department\\V1\\Rest\\Department\\Validator',
        ],
        'Department\\V1\\Rest\\Company\\Controller' => [
            'input_filter' => 'Department\\V1\\Rest\\Company\\Validator',
        ],
        'Department\\V1\\Rpc\\DivisionCompany\\Controller' => [
            'input_filter' => 'Department\\V1\\Rpc\\DivisionCompany\\Validator',
        ],
        'Department\\V1\\Rest\\Group\\Controller' => [
            'input_filter' => 'Department\\V1\\Rest\\Group\\Validator',
        ],
        'Department\\V1\\Rest\\GroupUser\\Controller' => [
            'input_filter' => 'Department\\V1\\Rest\\GroupUser\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Department\\V1\\Rest\\Department\\Validator' => [
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
        'Department\\V1\\Rest\\Company\\Validator' => [
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
        'Department\\V1\\Rpc\\DivisionCompany\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'uuid',
            ],
            1 => [
                'required' => true,
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
                'name' => 'level',
            ],
            2 => [
                'required' => true,
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
                'name' => 'isActive',
            ],
        ],
        'Department\\V1\\Rest\\Group\\Validator' => [
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
                'name' => 'company',
            ],
            2 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'branch',
            ],
            3 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'desc',
            ],
        ],
        'Department\\V1\\Rest\\GroupUser\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'groups',
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
                'name' => 'userProfile',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'Department\\V1\\Rest\\Department\\Controller' => [
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
            'Department\\V1\\Rpc\\DivisionCompany\\Controller' => [
                'actions' => [
                    'divisionCompany' => [
                        'GET' => false,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'Department\\V1\\Rest\\Company\\Controller' => [
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
            'Department\\V1\\Rest\\Group\\Controller' => [
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
            'Department\\V1\\Rest\\GroupUser\\Controller' => [
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
    'controllers' => [
        'factories' => [
            'Department\\V1\\Rpc\\DivisionCompany\\Controller' => \Department\V1\Rpc\DivisionCompany\DivisionCompanyControllerFactory::class,
        ],
    ],
    'zf-rpc' => [
        'Department\\V1\\Rpc\\DivisionCompany\\Controller' => [
            'service_name' => 'DivisionCompany',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'department.rpc.division-company',
        ],
    ],
];
