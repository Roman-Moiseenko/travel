<?php


namespace booking\helpers\stays;


use booking\entities\booking\stays\comfort\ComfortCategory;
use yii\helpers\ArrayHelper;

class ComfortHelper
{

    public static function listCategories(): array
    {
        return ArrayHelper::map(ComfortCategory::find()->orderBy(['sort' => SORT_ASC])->asArray()->all(), 'id', function ($item) {return $item['name'];});
    }
}