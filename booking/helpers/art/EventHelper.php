<?php


namespace booking\helpers\art;


use booking\entities\art\event\Category;
use yii\helpers\ArrayHelper;

class EventHelper
{
    public static function listCategories(): array
    {
        return ArrayHelper::map(
            Category::find()->orderBy(['sort' => SORT_ASC])->asArray()->all(),
            'id',
            function (array $types) {
                return $types['name'];
            });
    }
}