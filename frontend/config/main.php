<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'language' => '',
    'basePath' => dirname(__DIR__),
    // перевести сайт в режим обслуживания
    //'catchAll' => ['site/update'],
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
            'class' => 'frontend\urls\LangRequest',

        ],
        'user' => [
            'identityClass' => 'booking\entities\user\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-koenigs',
                // 'httpOnly' => true,
                'domain' => $params['cookieDomain'],
                // 'sameSite' => yii\web\Cookie::SAME_SITE_STRICT,
            ],
            'loginUrl' => ['auth/auth/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
            'cookieParams' => [
                //'httponly' => true,
                //'sameSite' => yii\web\Cookie::SAME_SITE_STRICT,
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
        'response' => [
            'formatters' => [
                'pdf' => [
                    'class' => 'robregonm\pdf\PdfResponseFormatter',
                    'mode' => '', // Optional
                    'format' => 'A4',  // Optional but recommended. http://mpdf1.com/manual/index.php?tid=184
                    'defaultFontSize' => 0, // Optional
                    'defaultFont' => '', // Optional
                    'marginLeft' => 15, // Optional
                    'marginRight' => 15, // Optional
                    'marginTop' => 16, // Optional
                    'marginBottom' => 16, // Optional
                    'marginHeader' => 9, // Optional
                    'marginFooter' => 9, // Optional
                    'orientation' => '', // optional. This value will be ignored if format is a string value.
                    'options' => [
                        // mPDF Variables
                        // 'fontdata' => [
                        // ... some fonts. http://mpdf1.com/manual/index.php?tid=454
                        // ]
                    ],
                ],
            ]
        ],
        'urlManager' => [
            'class' => 'frontend\urls\LangUrlManager',
            //           'class' => 'yii\web\UrlManager',
            'hostInfo' => $params['frontendHostInfo'],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'cache' => false,

            'rules' => [
                '' => 'site/index',
                'signup' => 'auth/signup/index',
                'reset/<_a:[\w-]+>' => 'auth/reset/<_a>',
                '<_a:login|logout>' => 'auth/auth/<_a>',
                'auth/network/auth' => 'auth/network/auth',
                'site/login' => 'auth/auth/login',
                //['pattern' => 'yandex-market', 'route' => 'market/index', 'suffix' => '.xml'],
                ['pattern' => 'sitemap', 'route' => 'sitemap/index', 'suffix' => '.xml'],
                ['pattern' => 'sitemap-<target:[a-z-]+>', 'route' => 'sitemap/<target>', 'suffix' => '.xml'],

                'cars' => 'cars/cars/index',
                'car/<id:\d+>' => 'cars/cars/car',

                'cars/cars/get-search' => 'cars/cars/get-search',
                'cars/booking/get-calendar' => 'cars/booking/get-calendar',
                'cars/booking/get-rent-car' => 'cars/booking/get-rent-car',
                'cars/booking/get-amount' => 'cars/booking/get-amount',
                'cars/checkout/booking' => 'cars/checkout/booking',
                'cars/<slug:[\w\-]+>' => 'cars/cars/category',

                'funs' => 'funs/funs/index',
                'fun/<id:\d+>' => 'funs/funs/fun',

                'funs/funs/get-search' => 'funs/funs/get-search',
                'funs/booking/get-calendar' => 'funs/booking/get-calendar',
                'funs/booking/get-tickets' => 'funs/booking/get-tickets',
                'funs/booking/get-times' => 'funs/booking/get-times',
                'funs/booking/get-amount' => 'funs/booking/get-amount',
                'funs/checkout/booking' => 'funs/checkout/booking',
                'funs/<slug:[\w\-]+>' => 'funs/funs/category',

                'tours' => 'tours/tours/index',
                'tours/booking/getcalendar' => 'tours/booking/getcalendar',
                'tours/booking/gettickets' => 'tours/booking/gettickets',
                'tours/booking/getlisttours' => 'tours/booking/getlisttours',
                'tours/booking/getday' => 'tours/booking/getday',
                'tours/booking/get-amount' => 'tours/booking/get-amount',
                'tours/checkout/booking' => 'tours/checkout/booking',

                'tour/<slug:[\w\-]+>' => 'tours/tours/tour',
                'tours/<slug:[\w\-]+>' => 'tours/tours/category',

                'stays' => 'stays/stays/index',
                'tickets' => 'tickets/tickets/index',

                'legals/view' => 'legals/view',
                'cabinet/dialogs' => 'cabinet/dialog/index',
                'cabinet/dialog' => 'cabinet/dialog/dialog',
                'cabinet/petition' => 'cabinet/dialog/petition',
                'conversation' => 'cabinet/dialog/conversation',
                'support' => 'cabinet/dialog/support',
                'post' => 'post/index',
                'post/tag/<slug:[\w\-]+>' => 'post/tag',
                'post/<id:\d+>' => 'post/post',
                'post/<slug:[\w\-]+>' => 'post/category',
                'cabinet' => 'cabinet/default/index',
                'cabinet/<_c:[\w\-]+>' => 'cabinet/<_c>/index',
                'cabinet/<_c:[\w\-]+>/<id:\d+>' => 'cabinet/<_c>/view',
                'cabinet/<_c:[\w\-]+>/<_a:[\w-]+>' => 'cabinet/<_c>/<_a>',
                'cabinet/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => 'cabinet/<_c>/<_a>',
                '/<slug:[\w\-]+>' => 'page/view',
                ['class' => 'frontend\urls\PageUrlRule'],
                ['class' => 'frontend\urls\TourUrlRule'],
                ['class' => 'frontend\urls\TourTypeUrlRule'],
                ['class' => 'frontend\urls\CarTypeUrlRule'],
                ['class' => 'frontend\urls\FunTypeUrlRule'],
                '<_c:[\w\-]+>' => '<_c>/index',
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>/<_a:[\w\-]+' => '<_c>/<_a>',
                '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+' => '<_c>/<_a>',
            ],
        ],
    ],
    'params' => $params,
];
