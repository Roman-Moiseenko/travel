<?php


namespace booking\helpers\shops;


use booking\entities\shops\TypeShop;
use yii\helpers\ArrayHelper;

class ShopTypeHelper
{
    public static function list(): array
    {
        return ArrayHelper::map(
            TypeShop::find()->asArray()->all(),
            'id',
            function (array $types) {
                return $types['name'];
            }
        );
    }
}