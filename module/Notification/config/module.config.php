<?php
return [
    'notification' => [
        'panic' => [
            'panic_alert_title' => 'Panic Alert Is Triggered',
            'panic_alert_visit_title' => 'Guard Is Visiting Panic Alert Location',
            'panic_alert_resolve_title' => 'Panic Alert Is Resolved By User',
        ],
        'UserActivated' => [
            'user_disabled_title' => 'User has beed disabled',
        ],
        'complain' => [
            'title' => 'Your Complaint Has Been ',
            'title_complain_response' => 'Admin Response Your Complaint ',
        ],
        'broadcast_message' => [
            'title' => 'You Have A New Broadcast Message From Admin',
            'to' => '/topics',
        ],
        'request_approval' => [
            'in_progress' => 'Your Request is In Progress',
            'approved' => 'Your Request Has Been Approved',
            'payment' => 'You Have Received a Payment Request',
            'rejected' => 'Your Request Has Been Rejected',
            'closed' => 'Your Request Has Been Closed',
        ],
        'admin_notification' => [
            'new_visitor_title' => 'New Visitor Created',
            'visitor_check_in_title' => 'Visitor Check In',
            'visitor_check_out_title' => 'Visitor Check Out',
            'new_facility_booking_title' => 'New Facility Booking Created',
            'check_in_facility_booking_title' => 'Facility Booking Checked In',
            'check_out_facility_booking_title' => 'Facility Booking Check Out',
            'check_in_site_title' => 'Site Check In',
            'check_out_site_title' => 'Site Check Out',
            'titleCheckOutFacilityBookingForAdmin' => 'Facility Booking Check Out',
            'cancel_facility_booking_title' => 'Facility Booking Cancelled',
            'new_complaint_title' => 'New User Complaint',
            'new_complaint_response_title' => 'User Reply To Complaint',
            'panic_alert_title' => 'User Trigger Panic Alert',
            'panic_alert_visit_title' => 'Guard Is Visiting Panic Alert Location',
            'panic_alert_resolve_title' => 'User Resolve Panic Alert',
            'request_title' => 'User Request',
            'task_accepted_title' => 'Task Has Been Accepted',
            'task_sent_title' => 'Task Report Received',
        ],
        'telegram' => [
            'new_overtime_created' => '**New Overtime Requested** by `:user`. Click [here](:url) to check.',
            'new_reimbursement_created' => '**New Reimbursement Requested** by `:user`. Click [here](:url) to check.',
            'new_leave_created' => '**New Leave Requested** by `:user`. Click [here](:url) to check.',
        ],
    ],
    'service_manager' => [
        'factories' => [
            \Notification\V1\Service\Notification::class => \Notification\V1\Service\NotificationFactory::class,
            \Notification\V1\Service\Listener\NotificationEventListener::class => \Notification\V1\Service\Listener\NotificationEventListenerFactory::class,
            \Notification\V1\Service\Listener\AdminEventListener::class => \Notification\V1\Service\Listener\AdminEventListenerFactory::class,
            \Notification\V1\Service\Listener\UserActivatedEventListener::class => \Notification\V1\Service\Listener\UserActivatedEventListenerFactory::class,
            \Notification\V1\Rest\Notification\NotificationResource::class => \Notification\V1\Rest\Notification\NotificationResourceFactory::class,
            \Notification\V1\Service\Listener\NotificationLogEventListener::class => \Notification\V1\Service\Listener\NotificationLogEventListenerFactory::class,
            \Notification\V1\Service\Listener\EmailNotificationEventListener::class => \Notification\V1\Service\Listener\EmailNotificationEventListenerFactory::class,
            \Notification\V1\Rest\NotificationLog\NotificationLogResource::class => \Notification\V1\Rest\NotificationLog\NotificationLogResourceFactory::class,
        ],
        'abstract_factories' => [
            0 => \Notification\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'hydrators' => [
        'factories' => [
            'Notification\\Hydrator\\Notification' => \Notification\V1\Hydrator\NotificationHydratorFactory::class,
            'Notification\\Hydrator\\NotificationLog' => \Notification\V1\Hydrator\NotificationLogHydratorFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'notification.rest.notification' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/notification[/:uuid]',
                    'defaults' => [
                        'controller' => 'Notification\\V1\\Rest\\Notification\\Controller',
                    ],
                ],
            ],
            'notification.rest.notification-log' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/notification-log[/:uuid]',
                    'defaults' => [
                        'controller' => 'Notification\\V1\\Rest\\NotificationLog\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'notification.rest.notification',
            1 => 'notification.rest.notification-log',
        ],
    ],
    'zf-rest' => [
        'Notification\\V1\\Rest\\Notification\\Controller' => [
            'listener' => \Notification\V1\Rest\Notification\NotificationResource::class,
            'route_name' => 'notification.rest.notification',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'notification',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
                2 => 'admin',
                3 => 'unread',
                4 => 'pilgrim_uuid',
                5 => 'registrar_uuid',
                6 => 'user_profile',
                7 => 'type',
                8 => 'status_type',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \Notification\Entity\Notification::class,
            'collection_class' => \Notification\V1\Rest\Notification\NotificationCollection::class,
            'service_name' => 'Notification',
        ],
        'Notification\\V1\\Rest\\NotificationLog\\Controller' => [
            'listener' => \Notification\V1\Rest\NotificationLog\NotificationLogResource::class,
            'route_name' => 'notification.rest.notification-log',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'notificationLog',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'ascending',
                2 => 'panic_alert_uuid',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Notification\Entity\NotificationLog::class,
            'collection_class' => \Notification\V1\Rest\NotificationLog\NotificationLogCollection::class,
            'service_name' => 'NotificationLog',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Notification\\V1\\Rest\\Notification\\Controller' => 'HalJson',
            'Notification\\V1\\Rest\\NotificationLog\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Notification\\V1\\Rest\\Notification\\Controller' => [
                0 => 'application/vnd.notification.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Notification\\V1\\Rest\\NotificationLog\\Controller' => [
                0 => 'application/vnd.notification.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Notification\\V1\\Rest\\Notification\\Controller' => [
                0 => 'application/vnd.notification.v1+json',
                1 => 'application/json',
            ],
            'Notification\\V1\\Rest\\NotificationLog\\Controller' => [
                0 => 'application/vnd.notification.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            'Notification\\V1\\Rest\\Notification\\NotificationEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'notification.rest.notification',
                'route_identifier_name' => 'notification_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Notification\V1\Rest\Notification\NotificationCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'notification.rest.notification',
                'route_identifier_name' => 'notification_id',
                'is_collection' => true,
            ],
            \Notification\Entity\Notification::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'notification.rest.notification',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Notification\\Hydrator\\Notification',
            ],
            'Notification\\V1\\Rest\\NotificationLog\\NotificationLogEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'notification.rest.notification-log',
                'route_identifier_name' => 'notification_log_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Notification\V1\Rest\NotificationLog\NotificationLogCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'notification.rest.notification-log',
                'route_identifier_name' => 'notification_log_id',
                'is_collection' => true,
            ],
            \Notification\Entity\NotificationLog::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'notification.rest.notification-log',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Notification\\Hydrator\\NotificationLog',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'Notification\\V1\\Rest\\Notification\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
            'Notification\\V1\\Rest\\NotificationLog\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
    'zf-content-validation' => [
        'Notification\\V1\\Rest\\Notification\\Controller' => [
            'input_filter' => 'Notification\\V1\\Rest\\Notification\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Notification\\V1\\Rest\\Notification\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'unread',
            ],
        ],
    ],
];
