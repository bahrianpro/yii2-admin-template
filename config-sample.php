<?php
if (!defined('WEBROOT_DIR')) die();

/**
 * Local site config.
 * Rename this file to config.php and edit.
 */

// comment out the following two lines when deployed to production
//define('YII_DEBUG', true);
//define('YII_ENV', 'dev');

return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - 
            // this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        // Database configuration.
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2basic',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
    'params' => [
        // Application parameters.
    ],
];
