<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-games',
    'basePath' => dirname(__DIR__),
    // перевести сайт в режим обслуживания
    //'catchAll' => ['site/update'],
    'aliases' => [
        '@staticRoot' => $params['staticPath'],
        '@static' => $params['staticHostInfo'],
    ],

    'controllerNamespace' => 'games\controllers',
    'bootstrap' => [
        'log',
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
            'csrfParam' => '_csrf-games',
            'enableCsrfValidation'=>false,
        ],
        'user' => [
            'identityClass' => 'booking\entities\games\User',
            //'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-games', 'httpOnly' => true, 'sameSite' => yii\web\Cookie::SAME_SITE_STRICT,],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-games',
            'cookieParams' => [
                'httponly' => true,
                'sameSite' => yii\web\Cookie::SAME_SITE_STRICT,
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'hostInfo' => $params['gamesHostInfo'],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<_a:login|logout>' => 'auth/auth/<_a>',
                'site/login' => 'auth/auth/login',
                '<_c:[\w\-]+>' => '<_c>/index',
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
                '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
            ],
        ],
    ],
    'params' => $params,
];
