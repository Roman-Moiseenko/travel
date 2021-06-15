<?php


namespace booking\helpers\tours;


use booking\entities\booking\tours\services\Capacity;
use yii\helpers\ArrayHelper;

class CapacityHelper
{
    public static function list($user_id): array
    {
        return ArrayHelper::map(
            Capacity::find()->andWhere(['user_id' => $user_id])->orderBy(['count' => SORT_ASC])->asArray()->all(),
            'id',
            function (array $capacity) {
                return $capacity['count'] . ' чел. +' . $capacity['percent'] . '%';
            }
        );
    }
}