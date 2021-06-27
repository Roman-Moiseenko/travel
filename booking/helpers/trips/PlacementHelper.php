<?php


namespace booking\helpers\trips;


use booking\entities\booking\trips\placement\Type;
use yii\helpers\ArrayHelper;

class PlacementHelper
{
    public static function list(): array
    {
        return ArrayHelper::map(
            Type::find()->orderBy(['name' => SORT_ASC])->asArray()->all(),
            'id',
            function (array $types) {
                return $types['name'];
            }
        );
    }
}