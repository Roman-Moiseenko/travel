<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=koenigs_booking',
            'username' => 'koenigs_booking',
            'password' => 'Koenigs20',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.beget.com', ///
                'username' => 'support@koenigs.ru', ///
                'password' => 'Foolprof01', ///
                'port' => '465',
                'encryption' => 'ssl',
            ],
            'messageConfig' => [
                'from' => ['admin@koenigs.ru' => 'booking']
            ],
        ],
        'robokassa' => [
            'class' => '\robokassa\Merchant',
            'baseUrl' => 'https://auth.robokassa.ru/Merchant/Index.aspx',
            'sMerchantLogin' => 'koenigs',
            'sMerchantPass1' => 'suXGG5Q1KF8nWeO4Brf4',
            'sMerchantPass2' => 'b4wCL73EZaXHvi8fYr0z',
            'isTest' => !YII_ENV_PROD,
        ],
        'sms' => [
            'class' => alexeevdv\sms\Sms::class,
            'provider' => [
                'class' => alexeevdv\sms\provider\SmsRuProvider::class,
                'api_id' => '1ECCA5B2-DAF8-E0EA-88AA-9E47CD456813',
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '302202821703-9c5mgkhgj5kfuv49t82gmli6tfiu8l98.apps.googleusercontent.com',
                    'clientSecret' => 'R-7nsqqT1lEekOopHWFFxRD7',
                ],
            ],
        ],
    ],
];
