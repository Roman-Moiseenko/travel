<?php


namespace booking\helpers;


use booking\entities\booking\City;
use booking\entities\Lang;
use yii\helpers\ArrayHelper;

class CityHelper
{
    public static function list()
    {
        return ArrayHelper::map(City::find()->asArray()->all(), 'id', 'name');
    }
}