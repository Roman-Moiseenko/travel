<?php

use booking\entities\booking\tours\CostCalendar;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-admin',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@staticRoot' => $params['staticPath'],
        '@static' => $params['staticHostInfo'],
    ],

    'controllerNamespace' => 'admin\controllers',
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp',
    ],
    'modules' => [],
    'components' => [
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'class' => 'yii\bootstrap4\BootstrapAsset'
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'class' => 'yii\bootstrap4\BootstrapPluginAsset'
                ]
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'booking\entities\admin\user\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-admin', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-admin',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'hostInfo' => $params['adminHostInfo'],
            'baseUrl' => '',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',

                '<_a:login|logout>' => 'auth/auth/<_a>',
                'tours' => 'site/tours',
                'stays' => 'site/stays',
                'cars' => 'site/cars',
                'discount' => 'site/discount',
                'tours/common' => 'tours/common/index',
                'tours/photos' => 'tours/photos/index',
                'tours/params' => 'tours/params/index',
                'tours/extra' => '/tours/extra/index',
                'tours/finance' => '/tours/finance/index',
                'tours/calendar' => '/tours/calendar/index',
                'tours/booking' => '/tours/booking/index',
                'tours/reviews' => '/tours/reviews/index',
                'tours/reports' => '/tours/reports/index',
                'cabinet/profile' => '/cabinet/profile/index',
                'cabinet/legal' => '/cabinet/legal/index',
                'cabinet/auth' => '/cabinet/auth/index',
                'signup' => 'auth/signup/index',
                '<_c:[\w\-]+>' => '<_c>/index',
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
                '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
            ],
        ],
    ],
    'params' => $params,
];
