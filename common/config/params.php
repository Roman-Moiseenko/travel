<?php
return [

    'deduction' => 5.0, //% удержания с провайдеров
    'merchant' => 3.5, //экваринг Яндекс.Кассы
    'merchant_payment' => true, //Комиссия включена в платеж Агрегатора
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => 3600 * 24 * 30,
    'paginationTour' => 24,
    'paginationCar' => 16,
    'paginationFun' => 24,
    'paginationPost' => 10,
    'mode_confirmation' => false, //true -  Разрешено только подтверждение бронирования, false - Оплата и Подтверждение бронирования
    'notSMS' => false,
    'errors' => [
        '403' => 'У Вас закрыт доступ к данному разделу',
        '404' => 'Страница не найдена',
        '408' => 'Истекло время ожидания',
        '500' => 'Внутренняя ошибка сервера',
    ],
    'kkt' => [
        'firm' => 'ООО «Кёнигс.РУ»',
        'address' => 'г.Калининград, ул.Маршала Жукова, д.10, кв.214',
        'number-FNS' => '0004946818006589',
        'number-KKT' => '199036013074',
        'INN' => '3906396773',
        'site-FNS' => 'https://www.nalog.ru',
        'OFD' => 'Яндекс.ОФД ',
        'site-OFD' => 'https://ofd.yandex.ru/check ',
        'INN-OFD' => '7704358518',
        'tax' => 'УСН доход - расход',
    ],
    //массив папок где надо сжать все фото
    'resize_categories' => [
        [
            'width' => 1024,
            'height' => 768,
            'quality' => 75,
            'items' => [
                '/rrrt/',
                '/origin/cars/',
                '/origin/funs/',
                '/origin/tours/',
                '/origin/stays/',
                '/origin/certs/',
            ],
        ],
        [
            'width' => 600,
            'height' => 600,
            'quality' => 75,
            'items' => [
                '/origin/admin_users/',
            ],
        ],
        [
            'quality' => 50,
            'items' => [
                '/cache/',
            ],
        ],
    ]
];

