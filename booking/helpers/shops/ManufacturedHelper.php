<?php


namespace booking\helpers\shops;


class ManufacturedHelper
{
    const TYPE_ANTIQUES = 1;
    const TYPE_HANDMADE = 2;
    const TYPE_FACTORY = 3;

    public static function list(): array
    {
        return [
            self::TYPE_ANTIQUES => 'Антиквариат',
            self::TYPE_HANDMADE => 'Ручное производство',
            self::TYPE_FACTORY => 'Фабричное',
        ];
    }
}