<?php


namespace booking\helpers;


class UserHelper
{
    public static function listLangs(): array
    {
        return [
            'ru', 'en', 'pl', 'de', 'fr', 'lt', 'lv'
        ];
    }
}