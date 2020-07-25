<?php


namespace booking\helpers;


use Cocur\Slugify\Slugify;

class SlugHelper
{
    public static function slug($string): string
    {
        $slugify = new Slugify();
        $slugify->activateRuleSet('russian');
        return $slugify->slugify($string);
    }
}