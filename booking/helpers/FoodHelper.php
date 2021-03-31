<?php


namespace booking\helpers;


use booking\entities\booking\BaseReview;
use booking\entities\foods\Category;
use booking\entities\foods\InfoAddress;
use booking\entities\foods\Kitchen;
use booking\entities\Lang;
use yii\helpers\ArrayHelper;

class FoodHelper
{
    public static function listKitchen(): array
    {
        return ArrayHelper::map(
            Kitchen::find()->orderBy(['name' => SORT_ASC])->asArray()->all(),
            'id',
            function (array $types) {
                return $types['name'];
            }
        );
    }

    public static function listCategory(): array
    {
        return ArrayHelper::map(
            Category::find()->orderBy(['name' => SORT_ASC])->asArray()->all(),
            'id',
            function (array $types) {
                return $types['name'];
            }
        );
    }

    public static function listCity()
    {
        $list = InfoAddress::find()->select('city')->distinct()->asArray()->all();
        return ArrayHelper::map($list, 'city', 'city');
    }

}