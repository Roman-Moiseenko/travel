<?php


namespace booking\helpers;


class CurrencyHelper
{
    public static function get($cost)
    {
        //TODO Сделать конветор валюты
        if (empty($cost)) {
            return 'free';
        }
        return $cost . ' руб.';
    }
}