<?php


namespace booking\helpers;


use booking\entities\forum\Category;
use yii\helpers\ArrayHelper;

class ForumHelper
{
    const FORUM_LOCK = '11';
    const FORUM_USER = '21';
    const FORUM_MODERATOR = '31';
    const FORUM_ADMIN = '41';

    public static function listCategory(): array
    {
        return ArrayHelper::map(Category::find()->orderBy(['sort' => SORT_ASC])->asArray()->all(), 'id', 'name');
    }
}