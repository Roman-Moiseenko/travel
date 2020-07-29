<?php


namespace booking\helpers;


use booking\entities\booking\stays\rules\AgeLimit;
use booking\entities\booking\tours\Extra;

class ToursHelper
{
    public static function listPrivate(): array
    {
        return [
            0 => 'Групповой',
            1 => 'Индивидуальный'
        ];
    }

    public static function stringPrivate($private): string
    {
        if ($private === null) return 'Не задано';
        $arr = ToursHelper::listPrivate();
        return $arr[$private];
    }

    public static function ageLimit(AgeLimit $ageLimit): string
    {
        if ($ageLimit->on == null) return 'Не задано';
        if ($ageLimit->on == false) return 'нет';
        if ($ageLimit->on == true) {
            $min = empty($ageLimit->ageMin) ? '' : 'с ' . $ageLimit->ageMin .' лет ';
            $max = empty($ageLimit->ageMax) ? '' : ' до ' . $ageLimit->ageMax .' лет ';
            return $min . $max;
        }
    }

    public static function listExtra(): array
    {
        return Extra::find()->andWhere(['user_id' => \Yii::$app->user->id])->all();
    }
}