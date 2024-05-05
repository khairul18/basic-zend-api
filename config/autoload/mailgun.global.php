<?php
return [
    'mail' => [
        'transport' => [
            'mailgunapp' => [
                'options' => [
                    'host' => 'smtp.mailgun.org',
                    'connection_class'  => 'login',
                    'connection_config' => [
                        'ssl'      => 'tls',
                        'username' => '',
                        'password' => ''
                    ],
                    'port' => 587,
                ]
            ]
        ]
    ]
];
