<?php


namespace booking\helpers\stays;

use booking\entities\booking\stays\Type;
use yii\helpers\ArrayHelper;

class StayTypeHelper
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