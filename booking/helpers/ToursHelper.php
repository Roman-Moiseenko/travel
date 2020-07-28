<?php


namespace booking\helpers;


class ToursHelper
{
    public static function listPrivate(): array
    {
        return [
            0 => 'Групповой',
            1 => 'Индивидуальный'
        ];
    }
}