<?php


namespace booking\helpers;


use booking\entities\admin\User;
use booking\entities\forum\Category;
use booking\entities\forum\Post;
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

    public static function isReadCategory($category_id): bool
    {
        $posts = Post::find()->andWhere(['category_id' => $category_id])->all();
        foreach ($posts as $post) {
            if (!self::isReadPost($post->id)) return false;
        }
        return true;
    }

    public static function isReadPost($post_id): bool
    {
        $user = User::findOne(\Yii::$app->user->id);
        $post = Post::findOne($post_id);
        return $user->isReadForum($post_id, $post->update_at);
    }

    public static function status($forum_role)
    {
        if ($forum_role == self::FORUM_LOCK) return '<span class="badge badge-danger">Заблокирован</span>';
        if ($forum_role == self::FORUM_USER) return '<span class="badge badge-info">Пользователь</span>';
        if ($forum_role == self::FORUM_MODERATOR) return '<span class="badge badge-primary">Модератор</span>';
        if ($forum_role == self::FORUM_ADMIN) return '<span class="badge badge-success">Администратор</span>';
    }

    public static function listStatus(): array
    {
        return [
            self::FORUM_LOCK => 'Заблокирован',
            self::FORUM_USER => 'Пользователь',
            self::FORUM_MODERATOR => 'Модератор',
            self::FORUM_ADMIN => 'Администратор',
        ];
    }
}