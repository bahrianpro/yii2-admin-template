<?php

/**
 * Don't edit this file.
 * Put your modifications to WEBROOT_DIR . '/config.php'
 */

$config = [
    'id' => 'basic',
    'basePath' => WEBROOT_DIR . '/app',
    'vendorPath' => WEBROOT_DIR . '/vendor',
    'runtimePath' => WEBROOT_DIR . '/runtime',
    'bootstrap' => ['log'],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ], // log
        // Application menus.
        'menu' => [
            'class' => 'app\components\Menu',
            'title' => ['main-nav' => 'Main navigation'],
            'items' => [
                // Navigation menu.
                'main-nav' => [
                    ['label' => 'Development', 'icon' => 'fa fa-building-o', 'url' => '#', 'items' => [
                        ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['gii/default/index']],
                        ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['debug/default/index']],
                    ], 'guest' => false],
                    ['label' => 'Login', 'url' => ['user/login'], 'icon' => 'fa fa-sign-in', 'guest' => true],
                    ['label' => 'Register', 'url' => ['user/register'], 'icon' => 'fa fa-user-plus', 'guest' => true],
                    ['label' => 'Logout', 'url' => ['user/logout'], 'icon' => 'fa fa-sign-out', 'guest' => false],
                ],
            ],
        ], // menu
    ], // component
    'params' => [
        'passwordResetTokenExpire' => 3600, // expire for 1 hour
        'adminEmail' => 'admin@example.com',
    ], // params
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
