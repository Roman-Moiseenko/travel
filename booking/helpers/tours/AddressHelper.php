<?php


namespace booking\helpers\tours;


use booking\entities\Lang;

class AddressHelper
{
    public static function short(string $address): string
    {
        if (Lang::current() == Lang::DEFAULT) {
            $str = str_replace('Россия, ', '', $address);
            $str = str_replace('Калининградская область, ', '', $str);
            return $str;
        }
    }
}