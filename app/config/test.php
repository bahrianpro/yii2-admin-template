<?php

// Config for testing.

return yii\helpers\ArrayHelper::merge(
       require_once __DIR__ . '/common.php',
       require_once __DIR__ . '/web.php',
       [
           'components' => [
               'db' => require_once __DIR__ . '/test_db.php',
               'request' => [
                   'cookieValidationKey' => 'testtesttesttest',
               ],
               'assetManager' => [
                   'basePath' => __DIR__ . '/../../web/assets',
               ],
           ],
       ]
);
