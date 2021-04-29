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

    public static function name($id): string
    {
        $result = Category::findOne($id);
        return $result->name;
    }

    public static function firstLevel(): array
    {
        return ArrayHelper::map(
            Category::find()->andWhere(['depth' => 1])->orderBy('lft')->asArray()->all(),
            'id',
            'name'
        );
    }
}