<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => [],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'robokassa' => [
            'class' => '\robokassa\Merchant',
            'baseUrl' => 'https://auth.robokassa.ru/Merchant/Index.aspx',
            'sMerchantLogin' => '',
            'sMerchantPass1' => '',
            'sMerchantPass2' => '',
            'isTest' => !YII_ENV_PROD,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
        'geo' => [
            'class' => 'div\geoip\Geo',
            'cityClass' => 'app\models\City' // модель города
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%auth_items}}',
            'itemChildTable' => '{{%auth_item_children}}',
            'assignmentTable' => '{{%auth_assignments}}',
            'ruleTable' => '{{%auth_rules}}',
        ],
    ],
];
