<?php


namespace booking\helpers\country;

use booking\entities\Lang;
use booking\entities\user\User;

class CountryHelper
{

    public static function listCountry(): array
    {
        $lang = Lang::current();
        return require '/data/' . $lang . '/country.php';
    }

    public static function name($code): string
    {
        $list = CountryHelper::listCountry();
        return $list[$code];
    }
}