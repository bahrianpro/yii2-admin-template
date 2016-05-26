<?php

defined('APPROOT_DIR') or define('APPROOT_DIR', dirname(dirname(__DIR__)));

Yii::setAlias('@tests', APPROOT_DIR . '/tests');

$config = [
    'id' => 'basic-console',
    'basePath' => APPROOT_DIR . '/app',
    'vendorPath' => APPROOT_DIR . '/vendor',
    'runtimePath' => APPROOT_DIR . '/runtime',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'templateFile' => '@app/views/templates/migration.php',
        ],
        'serve' => [
            'class' => 'yii\console\controllers\ServeController',
            'docroot' => APPROOT_DIR . '/web',
        ],
#        'fixture' => [ // Fixture generation command line.
#            'class' => 'yii\faker\FixtureController',
#        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
