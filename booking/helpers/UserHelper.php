<?php


namespace booking\helpers;


use booking\entities\Currency;

class UserHelper
{
    public static function iconNetwork($name): string
    {
        return '<span class="auth-icon ' . $name.'"></span>';
    }
}