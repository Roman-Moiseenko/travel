<?php
return [
    'deduction' => 8.9, //%% удержания с провайдеров = 5% + экваринг робокассы
    'merchant' => 3.9,
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => 3600 * 24 * 30,
    'cookieDomain' => '.travel.loc',
    'frontendHostInfo' => 'http://travel.loc',
    'backendHostInfo' => 'http://office.travel.loc',
    'staticHostInfo' => 'http://static.travel.loc',
    'adminHostInfo' => 'http://admin.travel.loc',
    'staticPath' => dirname(__DIR__, 2) . '/static',
    'supportEmail' => 'admin@kupi41.ru',
    'supportPhone' => '+7-800-000-0101',
    'NotSend' => true,
    'NotPay' => true,
    'paginationTour' => 24,
];
