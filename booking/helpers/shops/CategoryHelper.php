<?php


namespace booking\helpers\shops;


use booking\entities\shops\products\Category;
use yii\helpers\ArrayHelper;

class CategoryHelper
{
    public static function list(): array
    {
        return ArrayHelper::map(Category::find()->andWhere(['>', 'depth', 0])->
        orderBy('lft')->asArray()->all(),
            'id',
            function (array $category) {
                return ($category['depth'] > 1 ?
                        str_repeat('--', $category['depth'] - 1) . ' ' : '') . $category['name'];
            }
        );
    }
}