<?php


namespace booking\helpers;


use booking\entities\Lang;

class ReviewHelper
{

    public static function text(array $review)
    {
        $count = count($review);
        switch ($count) {
            case 1: $text = Lang::t('отзыв');
                break;
            case 2:
            case 3:
            case 4: $text = Lang::t('отзыва');
                break;
            default: $text = Lang::t('отзывов');
        }
        return $count . ' ' . mb_strtolower($text);
    }
}