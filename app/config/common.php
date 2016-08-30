<?php

// Should be defined in web/index.php but ensure that is.
defined('APPROOT_DIR') or define('APPROOT_DIR', dirname(dirname(__DIR__)));

Yii::setAlias('@modules', APPROOT_DIR . '/modules');

return [
    'basePath' => APPROOT_DIR . '/app',
    'vendorPath' => APPROOT_DIR . '/vendor',
    'runtimePath' => APPROOT_DIR . '/runtime',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];
