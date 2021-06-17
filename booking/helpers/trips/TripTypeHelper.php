<?php


namespace booking\helpers\trips;


use booking\entities\booking\trips\Type;
use yii\helpers\ArrayHelper;

class TripTypeHelper
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