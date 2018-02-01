<?php

// Config for testing.

return yii\helpers\ArrayHelper::merge(
       require __DIR__ . '/common.php',
       require __DIR__ . '/web.php',
       [
           'components' => [
               'db' => require __DIR__ . '/test_db.php',
               'request' => [
                   'cookieValidationKey' => 'testtesttesttest',
               ],
               'assetManager' => [
                   'basePath' => __DIR__ . '/../../web/assets',
               ],
           ],
       ]
);