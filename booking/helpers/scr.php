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
        if (is_array($var)) {
            foreach ($var as $item) {
                print_r($item);
            }
        } else {
            print_r($var);
        }
        exit();
    }

}