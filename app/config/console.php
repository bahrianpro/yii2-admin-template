<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests/codeception');

$config = [
    'id' => 'basic-console',
    'basePath' => WEBROOT_DIR . '/app',
    'vendorPath' => WEBROOT_DIR . '/vendor',
    'runtimePath' => WEBROOT_DIR . '/runtime',
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
            'docroot' => WEBROOT_DIR . '/web',
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
