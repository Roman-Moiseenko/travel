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


}