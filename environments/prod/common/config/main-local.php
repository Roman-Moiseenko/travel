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
                'username' => 'admin@koenigs.ru', ///
                'password' => 'Foolprof77', ///
                'port' => '465',
                'encryption' => 'ssl',
            ],
            'messageConfig' => [
                'from' => ['admin@koenigs.ru' => 'booking']
            ],
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
                    'clientId' => '460552206737-3l609bqkkil7n3t9c8r992q7b5es15g4.apps.googleusercontent.com',
                    'clientSecret' => 'LcABQes7j3YuhxeR0Mo80GKV',
                ],
            ],
        ],
    ],
];
