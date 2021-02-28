<?php


namespace booking\helpers\stays;


use booking\entities\booking\stays\comfort_room\ComfortRoomCategory;
use yii\helpers\ArrayHelper;

class ComfortRoomHelper
{

    public static function listCategories(): array
    {
        return ArrayHelper::map(ComfortRoomCategory::find()->orderBy(['sort' => SORT_ASC])->asArray()->all(), 'id', function ($item) {return $item['name'];});
    }
}