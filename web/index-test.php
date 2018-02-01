<?php

// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

define('APPROOT_DIR', dirname(__DIR__));
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require(APPROOT_DIR . '/vendor/autoload.php');
require(APPROOT_DIR . '/vendor/yiisoft/yii2/Yii.php');

$config = require(APPROOT_DIR . '/app/config/test.php');

$app = new app\base\WebApplication($config);
$app->run();
