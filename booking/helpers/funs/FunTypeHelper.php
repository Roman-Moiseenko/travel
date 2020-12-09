<?php


namespace booking\helpers\funs;

use booking\entities\booking\funs\Type;
use yii\helpers\ArrayHelper;

class FunTypeHelper
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