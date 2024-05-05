<?php
return [
    'zf-oauth2' => [
        'storage' => 'user.auth.pdo.adapter',
        'db' => [
            'dsn' => 'mysql:host=mysql567;dbname=xtend-api',
            'route' => '/oauth',
            'username' => 'root',
            'password' => 'password',
            'host' => 'mysql567',
            'port' => '3306'
        ],
        'options' => [
            'always_issue_new_refresh_token' => true,
            'unset_refresh_token_after_use' => true,
        ],
        'allow_implicit' => false, // default (set to true when you need to support browser-based or mobile apps)
        'access_lifetime' => 3600, // default (set a value in seconds for access tokens lifetime)
        'enforce_state'  => true,  // default
    ],
];
