<?php
return [
    'locale' => false, //не отправлять уведомления о бронировании
    'no_notice' => true, //не отправлять уведомления об ответах, когда идет покупка комментов
    'deduction' => 5.0, //% удержания с провайдеров
    'merchant' => 3.5, //экваринг Яндекс.Кассы
    'merchant_payment' => true, //Комиссия включена в платеж Агрегатора
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => 3600 * 24 * 30,
    'paginationTour' => 24,
    'paginationTrip' => 16,
    'paginationCar' => 16,
    'paginationFun' => 10,
    'paginationStay' => 24,
    'paginationFood' => 24,
    'paginationPost' => 10,
    'paginationForum' => 20,
    'mode_confirmation' => false, //true -  Разрешено только подтверждение бронирования, false - Оплата и Подтверждение бронирования

    'bot_review' => false,  //Если true то можно оставлять отзывы без покупки туров

    'errors' => [
        '403' => 'Ой-ой, Вам сюда нельзя!',
        '404' => 'Упс! Данная страница была уничтожена',
        '408' => 'Истекло время ожидания',
        '500' => 'Наш сервер поламался :(',
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
    'daysOfCanceledOrders' => 5, //Через сколько дней удалять не оплаченые заказы (возвращается кол-во товаров)
    'url_img_landing' => '/images/landing/', //Откуда грузить картинки для Заглавной страницы
    //'url_img_landing' => \Yii::$app->params['staticHostInfo'] . '/files/images/landing/booking/',
    //массив папок где надо сжать все фото
    'resize_categories' => [
        [
            'width' => 1024,
            'height' => 768,
            'quality' => 75,
            'items' => [
                '/origin/cars/',
                '/origin/tours/',
                '/origin/stays/',
                '/origin/certs/',
                '/origin/foods/',
                '/origin/shops/',
                '/origin/products/',
            ],
        ],
        [
            'width' => 1280,
            'height' => 800,
            'quality' => 75,
            'items' => [
                '/origin/posts/',
            ],
        ],
        [
           /* 'width' => 1280,
            'height' => 1024,*/
            'quality' => 75,
            'items' => [
                '/images/blog/',
                //'/origin/touristic/',
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
            'width' => 1024,
            'height' => 1024,
            'quality' => 75,
            'items' => [
                '/origin/orders/',
            ],
        ],
        [
            'quality' => 65,
            'items' => [
                '/cache/',
            ],
        ],
        [
            'width' => 1280,
            'height' => 458,
            'quality' => 75,
            'items' => [
                '/files/images/landing/carousel/',
            ],
        ],
        [
            'quality' => 75,
            'items' => [
                '/files/images/landing/booking/',
                '/files/images/landing/other/',
            ],
        ],
        [
        'width' => 150,
        'height' => 150,
        'quality' => 80,
        'items' => [
            '/files/images/contacts/',
        ],
    ],
    ],
    'prepay' => [
        0 => 0,
        20 => 20,
        50 => 50,
        100 => 100,
    ],
    'moving_moderator' => '+79118589719', //№ телефона User модератор переезда
];

