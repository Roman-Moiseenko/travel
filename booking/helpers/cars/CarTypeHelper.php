<?php


namespace booking\helpers\cars;


use booking\entities\booking\cars\Type;
use yii\helpers\ArrayHelper;

class CarTypeHelper
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