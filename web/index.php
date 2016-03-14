<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

define('WEBROOT_DIR', dirname(__DIR__));

$localConfig = [];
if (file_exists(WEBROOT_DIR . '/config.php')) {
    $localConfig = require(WEBROOT_DIR . '/config.php');
}
else {
    die('config.php is missing.');
}

require(WEBROOT_DIR . '/vendor/autoload.php');
require(WEBROOT_DIR . '/vendor/yiisoft/yii2/Yii.php');

$config = yii\helpers\ArrayHelper::merge(
    require(WEBROOT_DIR . '/app/config/web.php'),
    $localConfig
);

$app = new yii\web\Application($config);
$app->run();
