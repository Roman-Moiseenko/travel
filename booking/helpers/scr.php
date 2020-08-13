<?php


namespace booking\helpers;


class scr
{
    public static function v($var)
    {
        echo '<pre>';
        var_dump($var);
        exit();
    }
    public static function p($var)
    {
        echo '<pre>';
        print_r($var);
        exit();
    }
}