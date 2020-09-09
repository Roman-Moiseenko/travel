<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@staticRoot' => $params['staticPath'],
        '@static' => $params['staticHostInfo'],
    ],
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp',
        ],
    'controllerNamespace' => 'frontend\controllers',
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
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'booking\entities\user\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true, 'domain' => $params['cookieDomain']],
            'loginUrl' => ['auth/auth/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
            'hostInfo' => $params['frontendHostInfo'],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'cache' => false,
            'rules' => [
                '' => 'site/index',
                'contact' => 'contact/index',
                'signup' => 'auth/signup/index',
                'reset/<_a:[\w-]+>' => 'auth/reset/<_a>',
                '<_a:login|logout>' => 'auth/auth/<_a>',
                'site/login' => 'auth/auth/login',
                //'<_a:about>' => 'site/<_a>',
                //['pattern' => 'yandex-market', 'route' => 'market/index', 'suffix' => '.xml'],
                'tours' => 'tours/tours/index',
                'tours/<id:\d+>' => 'tours/tours/tour',
                'tours/category/<id:\d+>' => 'tours/tours/type',
                'cabinet/dialogs' => 'cabinet/dialog/index',
                'cabinet/dialog' => 'cabinet/dialog/dialog',
                'cabinet/petition' => 'cabinet/dialog/petition',
                'conversation' => 'cabinet/dialog/conversation',
                'support' => 'cabinet/dialog/support',
                'blog' => 'blog/post/index',
                'blog/tag/<slug:[\w\-]+>' => 'blog/post/tag',
                'blog/<id:\d+>' => 'blog/post/post',
                'blog/<slug:[\w\-]+>' => 'blog/post/category',
                'cabinet' => 'cabinet/default/index',
                'cabinet/<_c:[\w\-]+>' => 'cabinet/<_c>/index',
                'cabinet/<_c:[\w\-]+>/<id:\d+>' => 'cabinet/<_c>/view',
                'cabinet/<_c:[\w\-]+>/<_a:[\w-]+>' => 'cabinet/<_c>/<_a>',
                'cabinet/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => 'cabinet/<_c>/<_a>',
                // ['class' => 'frontend\urls\PageUrlRule'],
                '<_c:[\w\-]+>' => '<_c>/index',
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>/<_a:[\w\-]+' => '<_c>/<_a>',
                '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+' => '<_c>/<_a>',
            ],
        ],
    ],
    'params' => $params,
];
