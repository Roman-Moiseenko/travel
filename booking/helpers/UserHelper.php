<?php


namespace booking\helpers;


use booking\entities\Currency;

class UserHelper
{
    public static function listLangs(): array
    {
        return [
            'ru', 'en', 'pl', 'de', 'fr', 'lt', 'lv'
        ];
    }

    public static function listCurrency(): array
    {
        /** Руб, Дол, Евро, Злоты */
        return [
            Currency::RUB => '&#8381;',
            Currency::USD => '&#36;',
            Currency::EURO => '&#8364;',
            Currency::PZL => 'z&#x142;'
        ];
    }

    public static function Currency($code): string
    {
        $list = UserHelper::listCurrency();
        return $list[$code];
    }
}