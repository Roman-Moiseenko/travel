<?php


namespace booking\helpers;


use booking\entities\booking\stays\rules\AgeLimit;
use booking\entities\booking\tours\Extra;
use booking\entities\Lang;

class ToursHelper
{
    public static function listPrivate(): array
    {
        return [
            0 => Lang::t('Групповой'),
            1 => Lang::t('Индивидуальный')
        ];
    }

    public static function stringPrivate($private): string
    {
        if ($private === null) return Lang::t('Не задано');
        $arr = ToursHelper::listPrivate();
        return $arr[$private];
    }

    public static function ageLimit(AgeLimit $ageLimit): string
    {
        if ($ageLimit->on == null) return Lang::t('Не задано');
        if ($ageLimit->on == false) return Lang::t('нет');
        if ($ageLimit->on == true) {
            $min = empty($ageLimit->ageMin) ? '' : Lang::t('с') . ' ' . $ageLimit->ageMin . ' ' . Lang::t('лет');
            $max = empty($ageLimit->ageMax) ? '' : ' ' . Lang::t('до') . ' ' . $ageLimit->ageMax . ' ' . Lang::t('лет');
            return $min . $max;
        }
    }

    public static function listExtra(): array
    {
        return Extra::find()->andWhere(['user_id' => \Yii::$app->user->id])->all();
    }

    public static function cancellation($cancellation): string
    {
        if ($cancellation === null) return Lang::t('Отмена не предусмотрена');
        if ($cancellation === 0) return Lang::t('Отмена в любое время');
        return Lang::t('Отмена за') . ' ' . $cancellation . ' ' . Lang::t('дней');
    }

    public static function group($min, $max)
    {
        if ($min === null && $max === null) return Lang::t('Кол-во в группе неограничено');
        if ($min === null && $max !== null) return Lang::t('Не более') . ' ' . $max . ' ' . Lang::t(' человек');
        if ($min !== null && $max === null) return Lang::t('Не менее') . ' ' . $max . ' ' . Lang::t(' человек');
        return Lang::t('От') . ' ' . $min . ' ' . Lang::t('до') . ' ' . $max . ' ' .Lang::t('человек');
    }
}