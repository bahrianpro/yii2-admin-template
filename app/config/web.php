<?php

/**
 * Don't edit this file.
 * Put your modifications to APPROOT_DIR . '/config.php'
 */

// Should be defined in web/index.php but ensure that is.
defined('APPROOT_DIR') or define('APPROOT_DIR', dirname(dirname(__DIR__)));

$config = [
    'id' => 'admin',
    'name' => 'Admin Template',
    'basePath' => APPROOT_DIR . '/app',
    'vendorPath' => APPROOT_DIR . '/vendor',
    'runtimePath' => APPROOT_DIR . '/runtime',
    'bootstrap' => ['log'],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login'],
        ],
        'formatter' => [
            'class' => 'app\base\Formatter',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login' => 'user/login',
                'register' => 'user/register',
                'logout' => 'user/logout',
            ],
        ], // urlManager
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
        'disableUserRegister' => false,
        'adminEmail' => 'admin@example.com',
        'noAvatarImage' => '@web/images/avatars/avatar2.png',
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
    
    // Link assets instead of copy them (useful for development environment).
    $config['components']['assetManager']['linkAssets'] = true;
}

return $config;
