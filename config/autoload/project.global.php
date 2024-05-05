<?php
return [
    'project' => [
        'nearest_users' => [
            'radius'  => 10  //in KM
        ],
        'reimbursement_photo' => [
            'photo_dir'  => 'data/photo/reimbursement',
            'max_uploaded_photo' => 3
        ],
        'overtime_photo' => [
            'photo_dir'  => 'data/photo/overtime',
            'max_uploaded_photo' => 3
        ],
        'leave_photo' => [
            'photo_dir'  => 'data/photo/leave',
            'max_uploaded_photo' => 3
        ],
        'job_photo' => [
            'photo_dir'  => 'data/photo/job',
            'max_uploaded_photo' => 3
        ],
        'vehicle_bill_photo' => [
            'photo_dir'  => 'data/photo/vehicle-bill',
            'max_uploaded_photo' => 2
        ],
        'user_document' => [
            'doc_dir'  => 'data/doc/user-document',
            'max_uploaded_doc' => 5
        ],
        'sales_order' => [
            'photo_dir'  => 'data/photo/sales-order'
        ],
        'user_module' => [
            'photo_dir'  => 'data/photo/icon-module'
        ],
        'quotation' => [
            'photo_dir'  => 'data/photo/quotation'
        ],
        'company' => [
            'photo_dir'  => 'data/photo/company'
        ],
        'attendance' => [
            'photo_dir'  => 'data/photo/attendance'
        ],
        'broadcast_message' => [
            'daily_reminder' => [
                'title' => 'Have you fill Covid19 Questionnaire today?',
                'body' => 'Please fill the questionnaire during 14 days. Just ignore this if you have fill the questionnaire',
            ],
            'case_summary_update' => [
                'title' => 'UMeeShare - Confirmed Case Update',
                'body' => 'Total Number Of Confirmend Case Updated!',
            ],
        ],
        'notification' => [
            'overtime' => [
                'title' => 'Xtend ERP',
                'body' => 'Your overtime request {action}!',
            ],
            'leave' => [
                'title' => 'Xtend ERP',
                'body' => 'Your leave request {action}!',
            ],
            'reimbursement' => [
                'title' => 'Xtend ERP',
                'body' => 'Your reimbursement request {action}!',
            ],
            'salesOrder' => [
                'title' => 'Xtend ERP',
                'body' => 'Your sales order request {action}!',
            ],
            'purchaseRequisition' => [
                'title' => 'Xtend ERP',
                'body' => 'Your purchase requisition request has been {action} by {position}.',
            ],
        ],
        'panicAlert' => [
           'img_dir'  => 'data/panic-alert',
           'url'  => 'http://localhost:8000',
           'max_uploaded_photo' => 1
        ],
        'icons' => [
            'img_dir' => 'data/icons/facilities',
            'icons_url'  => 'http://localhost:8000'
        ],
        'apns' => [
            // 0 for sandbox & 1 for production
            'uri' => 0,
            'pem_file' => 'data/apns/',
            'sound'    => 'bingbong.aiff'
        ],
        'sites' => [
           'reset_password_url' => 'https://umeeshare.com/#/user/resetpassword/:code',
           'activation_url' => 'https://umeeshare.com/#/user/activation/:code',
           'contact_us' => 'https://umeeshare.com'
        ],
        'files' => [
           'img_dir'  => 'data/qrcode',
           'qr_code_url'  => 'http://localhost:8000/qrcode',
           'vehicle_photo' => [
               'photo_dir'  => 'data/photo/vehicle',
               'max_uploaded_photo' => 3
           ],
           'vehicle_report_photo' => [
               'photo_dir'  => 'data/photo/report',
               'max_uploaded_photo' => 3
           ],
        ],
        'images' => [
           'img_dir'  => 'data/ads',
           'ads_url'  => 'http://localhost:8000'
        ],
        'branchPhoto' => [
            'img_dir'  => 'data/branchPhoto',
            'url'  => 'http://localhost:8000',
            'max_uploaded_photo' => 1
         ],
        'hotel_photo' => [
            'img_dir'  => 'data/hotel-photo',
            'url'  => 'http://localhost:8000',
            'max_uploaded_photo' => 1
         ],
        'airline_photo' => [
            'img_dir'  => 'data/airline-photo',
            'url'  => 'http://localhost:8000',
            'max_uploaded_photo' => 1
         ],
        'web' => [
            'allowed_client_id' => 'iqs-web-admin'
         ],
        'mobile' => [
            'allowed_http_header' => [
                'Xtend COV19C\/Android',
            ],
            'allowed_client_id' => [
                'admin'   => 'iqs-web-admin',
                'user'  => 'iqs-mobile-app',
                'patient'  => 'iqs-mobile-app',
            ]
        ],
        'php_process' => [
            'php_binary' => '/usr/bin/php',
            'script' => __DIR__ . '/../../public/index.php'
        ],
    ],
    'telegram_bot' => [
        'url' => '',
        'username' => '',
        'password' => '',
        'from' => '',
        'default_recepient' => ''
    ],
    'firebase' => [
        'base_uri'   => 'https://fcm.googleapis.com',
        'ssl_verify' => false,
        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
        'sound' => 'default',
        'server_key' => '',
        'android' => []
    ],
    'php_process' => [
       'php_binary' => '/usr/bin/php',
       'script' => 'public/index.php'
    ],
    'google_api_client' => [
       'client_id' => ''
    ],
    'facebook' => [
        'app_id' => '',
        'app_secret' => '',
        'default_graph_version' => 'v2.10',
    ],
];
