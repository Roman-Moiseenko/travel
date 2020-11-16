<?php


namespace booking\helpers\tours;


use booking\entities\booking\tours\Type;
use yii\helpers\ArrayHelper;

class TourTypeHelper
{
    public static function list(): array
    {
        return ArrayHelper::map(
                Type::find()->orderBy(['sort' => SORT_ASC])->asArray()->all(),
                'id',
                function (array $types) {
                    return $types['name'];
                }
            );
    }
}