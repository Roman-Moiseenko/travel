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
        'frontend\bootstrap\SetUp',
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'class' => 'yii\bootstrap4\BootstrapAsset',
                  /*  'css' => [
                        'css/bootstrap.min.css',
                    ],*/
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'class' => 'yii\bootstrap4\BootstrapPluginAsset'
                ]
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'class' => 'frontend\urls\LangRequest',
            //'baseUrl' => $_SERVER['DOCUMENT_ROOT'] . $_SERVER['PHP_SELF'] != $_SERVER['SCRIPT_FILENAME'] ? 'https://' . $_SERVER['HTTP_HOST'] : '',
        ],
        'user' => [
           // 'class' => 'anart\forum\PhpBBWebUser',
            'identityClass' => 'booking\entities\user\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-koenigs',
                'domain' => $params['cookieDomain'],
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
                'fast/sign-up' => 'auth/fast/sign-up',
                'site/login' => 'auth/auth/login',
                'site/captcha' => 'site/captcha',

                ['pattern' => 'turbo', 'route' => 'market/turbo', 'suffix' => '.xml'],
                ['pattern' => 'rss', 'route' => 'market/rss', 'suffix' => '.xml'],
                ['pattern' => 'sitemap', 'route' => 'sitemap/index', 'suffix' => '.xml'],
                ['pattern' => 'sitemap-<target:[a-z-]+>', 'route' => 'sitemap/<target>', 'suffix' => '.xml'],

                'apple-touch-icon.png' => 'apple-touch-icon.png',
                'humans.txt' => 'humans.txt',

                //'main' => 'site/main',

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
                'stays/stays/get-booking' => 'stays/stays/get-booking',
                'stays/stays/get-error' => 'stays/stays/get-error',
                'stays/stays/map' => 'stays/stays/map',
                'stays/stays/get-maps' => 'stays/stays/get-maps',
                'stays/checkout/booking' => 'stays/checkout/booking',
                'stay/<id:\d+>' => 'stays/stays/stay',

                'foods' => 'food/index',
                'food/map-foods' => 'food/map-foods',
                'food/<id:\d+>' => 'food/view',

                'shops' => 'shop/catalog/index',
                'shop/catalog/<id:\d+>' => 'shop/catalog/category',
                'shop/product/<id:\d+>' => 'shop/catalog/product',
                'shop/<id:\d+>' => 'shop/catalog/shop',
                'shop/cart/add' => 'shop/cart/add',
                'shop/cart/sub' => 'shop/cart/sub',
                'shop/cart/remove' => 'shop/cart/remove',
                'shop/cart/quantity' => 'shop/cart/quantity',
                'shop/cart' => 'shop/cart/index',
                'survey/<id:\d+>' => 'survey/view',

                'moving' => 'moving/moving/index',
                'moving/faq' => 'moving/faq/index',
                'moving/docs' => 'moving/docs/index',
                'moving/realty' => 'moving/realty/index',
                'moving/area' => 'moving/area/index',
                'moving/region' => 'moving/region/index',
                'moving/bussines' => 'moving/bussines/index',

                'moving/faq/category/<id:\d+>' => 'moving/faq/category',
                'moving/faq/answer/<id:\d+>' => 'moving/faq/answer',
                'moving/close/get-link' => 'moving/close/get-link',
                'moving/<slug:[\w\-]+>' => 'moving/moving/view',


                'tickets' => 'tickets/tickets/index',

                'legals/view' => 'legals/view',
                'cabinet/dialogs' => 'cabinet/dialog/index',
                'cabinet/orders' => 'cabinet/order/index',
                'cabinet/order' => 'cabinet/order/view',
                'cabinet/dialog' => 'cabinet/dialog/dialog',
                'cabinet/petition' => 'cabinet/dialog/petition',
                'conversation' => 'cabinet/dialog/conversation',
                'support' => 'cabinet/dialog/support',
                'post' => 'post/index',
                'post/comment' => 'post/comment',
                'post/widget-map' => 'post/widget-map',
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
                ['class' => 'frontend\urls\MovingPageUrlRule'],
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
