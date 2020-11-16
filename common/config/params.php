<?php
return [
    'deduction' => 5.0, //% удержания с провайдеров
    'merchant' => 3.7, //экваринг Яндекс.Кассы
    'merchant_payment' => true, //Комиссия включена в платеж Агрегатора
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => 3600 * 24 * 30,
    'paginationTour' => 24,
    'paginationCar' => 16,
    'paginationPost' => 10,
    'mode_confirmation'=> true, //true -  Разрешено только подтверждение бронирования, false - Оплата и Подтверждение бронирования
    'notSMS' => true,
    'errors' => [
        '403' => 'У Вас закрыт доступ к данному разделу',
        '404' => 'Страница не найдена',
        '408' => 'Истекло время ожидания',
        '500' => 'Внутренняя ошибка сервера',
    ]
];
